<?php

class AdminController extends BaseController {
    public function __construct(){
        $this->beforeFilter("admin-auth");
    }
    public function getDashboard(){
        $orders=array();
        $orders = Order::where('payment_sent', '=', NULL)->get();
        return var_dump($orders);
        //return View::make('admin.dashboard', array('orders', $orders));
        //return View::make('cart.index', array('cart' => $cart));
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
         $orders=array();
        $orders = Order::where('payment_sent', '=', NULL)->get();
        return var_dump($orders);
        //return View::make('admin.dashboard', array('orders', $orders));
        //return View::make('cart.index', array('cart' => $cart));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}