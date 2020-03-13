<?php
namespace App\Http\Controllers;

use App\Http\Requests\OrdersRequest;

class OrdersController extends BaseController
{

    /**
     * OrdersController constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->countPrice($this->OrderRepository->getOrders());

        return view('orders', compact(self::viewShareVarsOrders));
    }

    /**
     * Display a listing of the overdue orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function overdueOrders()
    {
        $orders = $this->countPrice($this->OrderRepository->getOverdueOrders());

        return view('orders', compact(self::viewShareVarsOrders));
    }

    /**
     * Display a listing of the current orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function currentOrders()
    {
        $orders = $this->countPrice($this->OrderRepository->getCurrentOrders());

        return view('orders', compact(self::viewShareVarsOrders));
    }

    /**
     * Display a listing of the new orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function newOrders()
    {
        $orders = $this->countPrice($this->OrderRepository->getNewOrders());

        return view('orders', compact(self::viewShareVarsOrders));
    }

    /**
     * Display a listing of the completed orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function completedOrders()
    {
        $orders = $this->countPrice($this->OrderRepository->getCompletedOrders());

        return view('orders', compact(self::viewShareVarsOrders));
    }

    /**
     * Edit the order.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! $this->OrderRepository->getEdit($id)) {
            return redirect()->back()->withErrors('This order does not exist.');
        }

        $order = $this->OrderRepository->getOrderByOrderId($id);
        $partners = $this->PartnerRepository->getPartners();

        return view('order', compact(self::viewShareVarsOrderEdit));
    }

    /**
     * Update the order.
     *
     * @param App\Http\Requests\OrdersRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrdersRequest $request, $id)
    {
        $this->OrderRepository->updateOrder($id, $request->input());

        if ($request->input('status') == 20) {
            $partner = $this->PartnerRepository->getPartnerById($request->input('partner_id'));
            $order = $this->OrderRepository->getOrderByOrderId($id);

            // send an email to the partner
            $this->sendCompletedOrderEmail($partner, $order);

            // send emails to the vendors
            foreach ($order->products as $product) {
                $vendor = $this->ProductRepository->getVendor($product->product_id);
                $this->sendCompletedOrderEmail($vendor, $order);
            }
        }

        return redirect()->back()->with('success', 'The order has been updated successfully');
    }
}
