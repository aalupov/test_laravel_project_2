<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends BaseController
{

    /**
     * ProductsController constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->ProductRepository->getProducts();

        return view('products', compact(self::viewShareVarsProducts));
    }

    /**
     * Update the product price
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updatePrice(Request $request)
    {
        $this->ProductRepository->updatePrice($request->input('product_id'), $request->input('price'));      
    }
}
