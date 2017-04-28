<?php

namespace App\Http\Controllers\Api;

use App\Business\Repositories\ProductRepository;
use App\Review;
use Illuminate\Http\Request;
use URL;

class ReviewController extends ApiController
{
    /**
     * @param Request $request
     * @param ProductRepository $productRepository
     * @param Review $review
     * @return array|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, ProductRepository $productRepository, Review $review)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'rating' => 'required|integer|in:1,2,3,4,5',
            'comment' => 'required|string',
            'product_id' => 'required|exists:products,_id',
        ]);

        $product = $productRepository->findBy('_id', $request->input('product_id'));
        $product->reviews()->save($review->newInstance($request->all()));

        if ($request->ajax()) {
            return ['response' => trans('review.success_message')];
        } else {
            \Session::flash('flash_message', trans('review.success_message'));
            return redirect(URL::previous());
        }
    }
}
