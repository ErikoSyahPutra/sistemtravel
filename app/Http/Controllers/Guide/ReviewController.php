<?php

namespace App\Http\Controllers\Guide;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Builder;

class ReviewController extends Controller
{
    public function index(): View
    {
        $guide = Auth::user()->guide;

        if (!$guide) {
            return view('guide.reviews.index', ['reviews' => collect()]);
        }

        $guideId = $guide->id;

        $reviews = Review::with(['booking.package', 'user'])
            ->whereHas('booking', function (Builder $query) use ($guideId) {
                $query->whereHas('guideAssignments', function (Builder $subQuery) use ($guideId) {
                    $subQuery->where('guide_id', $guideId);
                });
            })
            ->latest()
            ->paginate(10);

        return view('guide.reviews.index', compact('reviews'));
    }
}
