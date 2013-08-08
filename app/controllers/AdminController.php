<?php

class AdminController extends BaseController {
    public function __construct(){
        $this->beforeFilter("admin_auth");
    }
       /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $orders=array();
        $orders = Order::with('user')->paginate(2);
        $users = DB::table('users')->paginate(2);
        $totalUsers = DB::table('users')->count();
        $online = new SentryUsersOnline;
        $onlineUsers = $online->getUsersCount();
        //return var_dump($orders);
        return View::make('admin.dashboard', array( 'orders' => $orders,
                                                    'totalUsers' => $totalUsers,
                                                    'onlineUsers' => $online->getUsersCount(),
                                                    'onlineGuests' => $online->getGuestsCount(),
                                                    'users' => $users
                                                  ));
        //return View::make('cart.index', array('cart' => $cart));
    }

    public function postUpdateOrders(){
      //return var_dump(Input::get('orders'));
      $orders = Input::get('orders');
        // process/update each order.
        foreach($orders as $order){

            // grab Order object.
            $o = Order::where('id', '=', $order['id'])->first();

            // grab User object.
            $u = User::where('id', '=', $o->user_id)->first();


            // Received Date
            // check of Received date is set, and not empty. If empty/notset do nothing else update.
            if (isset($order['received_date']) && !empty($order['received_date'])){

                // convert received date to date object;
                $received_date = date('Y-m-d', strtotime($order['received_date']));

                // check if old_received_date exists
                if (isset($order['old_received_date'])){
                    //if old_received_date exists convert to date object.
                    $old_received_date = date('Y-m-d', strtotime($order['old_received_date']));

                    // if received date does not match old received date...ie the record is updated, not the same.
                    if ($received_date != $old_received_date){
                        // update value
                        $o->received_date = $received_date;
                    }
                } else {
                    // there is no old_Received_date value, so it's the first time the record is updated, and we will send an email to user.
                    $o->received_date = $received_date;
                    $data['userId'] = $o->user_id;
                    $data['email'] = $u->email;

                    // Email the user on first update of this data field.
                    Mail::send('emails.shipment_received', $data, function($m) use($data)
                    {
                        $m->from('patrick@recycleabook.com', 'RecycleABook')->to($data['email'])->subject('Shipment Received @ TopBookPrices.com');
                    });
                }
            }


            // Paid Date
            if (isset($order['paid_date']) && !empty($order['paid_date'])){

                // convert paid date to date object;
                $paid_date = date('Y-m-d', strtotime($order['paid_date']));

                // check if old_paid_date exists
                if (isset($order['old_paid_date'])){
                    //if old_paid_date exists convert to date object.
                    $old_paid_date = date('Y-m-d', strtotime($order['old_paid_date']));

                    // if paid date does not match old paid date...ie the record is updated, not the same.
                    if ($paid_date != $old_paid_date){
                        // update value
                        $o->paid_date = $paid_date;
                    }
                } else {
                    // there is no old_paid_date value, so it's the first time the record is updated, and we will send an email to user.
                    $o->paid_date = $paid_date;
                    $data['userId'] = $o->user_id;
                    $data['email'] = $u->email;

                    // Email the user on first update of this data field.
                    Mail::send('emails.payment_sent', $data, function($m) use($data)
                    {
                        $m->from('patrick@recycleabook.com', 'RecycleABook')->to($data['email'])->subject('Payment Received from TopBookPrices.com');
                    });
                }
            }
             /*
            if ($paid_date != $order['old_paid_date']){
              $o->paid_date = $paid_date;

            }
            */
            $o->comments = $order['comments'];
            $o->save();


        }
        return Redirect::back()->with('message', 'Update successful');
    }



    /**
    *   Update method for users table.
    *
    **/
    public function postUpdateUsers(){
      $users = Input::get('users');
      //return var_dump($users);
        // process/update each order.
        foreach($users as $user){

          // grab User object.
          $u = User::where('id', '=', $user['id'])->first();
          $u->first_name = $user['first_name'];
          $u->last_name = $user['last_name'];
          $u->email = $user['email'];
          $u->phone = $user['phone'];
          $u->address = $user['address'];
          $u->city = $user['city'];
          $u->state = $user['state'];
          $u->zip = $user['zip'];
          $u->payment_method = $user['payment_method'];
          $u->paypal_email = $user['paypal_email'];
          $u->name_on_cheque = $user['name_on_cheque'];
          $u->save();

        }
        return Redirect::back()->with('message', 'Update successful');


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