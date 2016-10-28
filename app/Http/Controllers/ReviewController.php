<?php

namespace App\Http\Controllers;

use App\Business\Repositories\ProductRepository;
use App\Review;
use Illuminate\Http\Request;

use App\Http\Requests;

class ReviewController extends Controller
{
    /**
     * @param Request $request
     * @param ProductRepository $productRepository
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
            return ['response' => 'Thanks for reviewing our product!'];
        } else {
            \Session::flash('flash_message', 'Thanks for reviewing our product!');
            return redirect(URL::previous());
        }
    }
}
