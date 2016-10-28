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
    public function store(Request $request, ProductRepository $productRepository)
    {

        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'rating' => 'required|integer|in:1,2,3,4,5',
            'comment' => 'required|string',
            'product_id' => 'required|exists:products,_id',
        ]);

        $review = Review::create($request->all());

        $product = $productRepository->find($request->input('product_id'));
        $product->reviews()->save($review);

        $productRepository->update($request->input('product_id'), $product->toArray());

        /*\Mail::send('emails.new_lead', [], function ($m) use ($lead) {
            $m->from(StaticVars::email(), StaticVars::company());

            $m->to($lead->email)->subject('Your discount!');
        });*/

        if ($request->ajax()) {
            return ['response' => 'Your discount is on the way!'];
        } else {
            \Session::flash('flash_message', 'Your discount is on the way!');
            return redirect(URL::previous());
        }
    }
}
