<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handlePayment(Request $request)
    {
        // Log semua request untuk debugging
        Log::info('Payment Webhook received', $request->all());

        // Verifikasi signature (jika gateway mendukung)
        $signature = $request->header('X-Webhook-Signature');
        $webhookSecret = config('services.payment.webhook_secret'); // tambahkan di .env nanti

        $payload = $request->all();
        $expectedSignature = hash_hmac('sha256', json_encode($payload), $webhookSecret ?? '');

        if ($webhookSecret && !hash_equals($expectedSignature, $signature)) {
            Log::warning('Invalid webhook signature', [
                'expected' => $expectedSignature,
                'received' => $signature,
            ]);
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        // Process webhook
        $event = $request->input('event');
        $data = $request->input('data');

        if ($event === 'payment.success') {
            $externalId = $data['external_id'];

            $booking = Booking::where('booking_number', $externalId)->first();

            if (!$booking) {
                Log::warning('booking not found', ['external_id' => $externalId]);
                return response()->json(['error' => 'booking not found'], 404);
            }

            // Check if already processed (idempotency)
            if ($booking->isPaid()) {
                Log::info('Payment already processed', ['booking_id' => $booking->id]);
                return response()->json(['message' => 'Already processed'], 200);
            }

            // Update booking status
            $booking->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);

            // Reduce product stock
            $packages = $booking->package;
            $packages->decrement('stock', $booking->quantity);

            Log::info('Payment success processed', [
                'booking_id' => $booking->id,
                'booking_number' => $booking->booking_number,
                'amount' => $booking->total_amount,
            ]);

            return response()->json(['message' => 'Webhook processed successfully'], 200);
        }

        if ($event === 'payment.failed') {
            $externalId = $data['external_id'];

            $booking = Booking::where('booking_number', $externalId)->first();

            if ($booking) {
                $booking->update(['payment_status' => 'failed']);
                Log::info('Payment failed processed', ['booking_id' => $booking->id]);
            }

            return response()->json(['message' => 'Webhook processed'], 200);
        }

        if ($event === 'payment.expired') {
            $externalId = $data['external_id'];

            $booking = booking::where('booking_number', $externalId)->first();

            if ($booking) {
                $booking->update(['payment_status' => 'expired']);
                Log::info('Payment expired processed', ['booking_id' => $booking->id]);
            }

            return response()->json(['message' => 'Webhook processed'], 200);
        }

        return response()->json(['message' => 'Event not handled'], 200);
    }
}
