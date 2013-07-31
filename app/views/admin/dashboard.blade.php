@extends('layouts.master')
@section('head')
<link href="{{ URL::asset('css/datepicker.css') }}" rel="stylesheet">
@stop
@section('content')


<h3>Dashboard</h3>
  <div class="row-fluid">
   Total Users: {{{ $totalUsers }}} | Online:  {{{ $onlineUsers }}} | Guests:  {{{ $onlineGuests }}}

  </div>
  <div class="span12">
    <ul class="nav nav-tabs" id="myTab">
      <li class="active"><a href="#orders">Orders</a></li>
      <li><a href="#users">Users</a></li>
    </ul>
   <div class="tab-content">
      <div class="tab-pane active" id="orders" >
        {{ Form::open(array('action' => 'AdminController@postUpdateOrders', 'method' => 'post')) }}

          <table class="table-striped span11 table-bordered">
            <thead>
              <tr>
                <th>User</th>
                <th>Items</th>
                <th>Tracking Number</th>
                <th>Total</th>
                <th>Date Received /<br />Date Paid</th>
              
                <th>Comments</th>
                <th>Date Created</th>
              </tr>
            </thead>
            <tbody>
            <?php $count = 0; ?>
            @foreach ($orders as $order)
            <tr>
            <input type="hidden" name ="orders[{{$count}}][id]" value="{{$order->id}}" />
              <td class="span1">{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
              <td> <?php $itemCount = Item::where('order_id', '=', $order->id)->count(); echo $itemCount ?></td>
              <td>{{ $order->tracking_number}}</td>
              <td>{{ number_format($order->total_amount, 2) }}</td>
              <td class="span2"><div class="input-append date" id="dp_received_{{$count}}" data-date="<?php echo date("m/d/Y"); ?>" data-date-format="mm/dd/yyyy">
                <input id="received_date_{{$count}}" name="orders[{{$count}}][received_date]" class="span2" size="16" type="text" value="<?php if ($order->received_date){echo date('m/d/Y', strtotime($order->received_date));/*$date = date_create($order->received_date); echo $date->format('m/d/Y'); */} ?>" readonly>
                @if ($order->received_date)
                  <input type="hidden" name="orders[{{$count}}][old_received_date]" value="{{$order->received_date}}" />
                @endif
                @if ($order->paid_date)
                  <input type="hidden" name="orders[{{$count}}][old_paid_date]" value="{{$order->paid_date}}" />
                @endif
                
                <span class="add-on"><i class="icon-calendar"></i></span>
                </br ><br /><div class="input-append date" id="dp_paid_{{$count}}" data-date="<?php echo date("m/d/Y"); ?>" data-date-format="mm/dd/yyyy">
                <input id="paid_date_{{$count}}" name="orders[{{$count}}][paid_date]" class="span2" size="16" type="text" value="<?php if ($order->paid_date){echo date('m/d/Y', strtotime($order->paid_date)); } ?>" readonly>
                <span class="add-on"><i class="icon-calendar"></i></span> }}</td>
              <td class="span2"><textarea name="orders[{{$count}}][comments]" rows="3" cols="60"/>{{ $order->comments }}</textarea></td>
              <td style="width:90px;">{{date_format($order->created_at, 'm-d-Y') }}</td>
            </tr>
            <?php $count++; ?>
            @endforeach
            </tbody>
          </table>
          <div style="clear:left;float:left;"><?php echo $orders->links(); ?></div> 
        <div style="float:left;margin-top:20px;margin-left:50px;"><button type="submit" name="update_orders" class="btn btn-primary">Update Orders</button></div>
                {{ form::close() }}
      </div>
        <div class="tab-pane" id="users">
         {{ Form::open(array('action' => 'AdminController@postUpdateUsers', 'method' => 'post', )) }}

          <table class="table-striped span10 table-bordered">
            <thead>
              <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Payment Method</th>
                <th>Date Joined</th>
              </tr>
            </thead>
            <tbody>
            <?php $count = 0; ?>
            @foreach ($users as $user)
            <tr>
            <input type="hidden" name ="users[{{$count}}][id]" value="{{$user->id}}" />
            <td class="span3">
                <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="first_name">First</label></div>
                <div style="float:right;margin-right:30px;"><input type="text" value="{{$user->first_name}}" name="users[{{$count}}][first_name]" class="input-medium"/></div>
                 <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="last_name">Last</label></div>
                <div style="float:right;margin-right:30px;"><input type="text" value="{{$user->last_name}}" name="users[{{$count}}][last_name]" class="input-medium"/></div>
            </td>
            <td class="span3"> <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="email">Email</label></div>
                 <div style="float:right;margin-right:30px"><input type="text" value="{{$user->email}}" name="users[{{$count}}][email]" class="input-medium"/></div>
                 
                 <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="phone">Phone</label></div>
                 <div style="float:right;margin-right:30px"><input type="text" value="{{$user->phone}}" name="users[{{$count}}][phone]" class="input-medium"/></div>
                 
                 <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="address">Address</label></div>
                 <div style="float:right;margin-right:30px"><input type="text" value="{{$user->address}}" name="users[{{$count}}][address]" class="input-medium"/></div>
                 
                 <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="city">City</label></div>
                 <div style="float:right;margin-right:30px"><input type="text" value="{{$user->city}}" name="users[{{$count}}][city]" class="input-medium"/></div>
                 
                 <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="state">State</label></div>
                 <div style="float:right;margin-right:30px"><input type="text" value="{{$user->state}}" name="users[{{$count}}][state]" class="input-medium"/></div>

                 <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="zip">Zip</label></div>
                 <div style="float:right;margin-right:30px"><input type="text" value="{{$user->zip}}" name="users[{{$count}}][zip]" class="input-medium"/></div>
            </td>
            <td class="span3">
                 <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="payment_method">Method</label></div>
                 <div style="float:right;margin-right:30px"><input type="text" value="{{$user->payment_method}}" name="users[{{$count}}][payment_method]" class="input-medium"/></div>
                 <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="paypal_email">Paypal</label></div>
                 <div style="float:right;margin-right:30px"><input type="text" value="{{$user->paypal_email}}" name="users[{{$count}}][paypal_email]" class="input-medium"/></div>
                 <div style="clear:both;float:left;padding:0 10px 0 10px "><label for="name_on_cheque">Cheque</label></div>
                 <div style="float:right;margin-right:30px"><input type="text" value="{{$user->name_on_cheque}}" name="users[{{$count}}][name_on_cheque]" class="input-medium"/></div>




          
            </td>
            <td class="span1">{{ date('m/d/Y', strtotime($user->created_at)) }}</td>
            </tr>
            <?php $count++; ?>
            @endforeach
            </tbody>
          </table>
         <div style="clear:left;float:left;"><?php echo $users->links(); ?></div> 
        <div style="float:left;margin-top:20px;margin-left:50px;"><button type="submit" name="update_users" class="btn btn-primary">Update Users</button>
        </div>
                {{ form::close() }}

        </div>
    </div>
@stop
@section('footer')
<script src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
<?php
$count = 0;
 foreach ($orders as $order){
?><script>
$(function(){
  $("#dp_received_<?php echo $count; ?>").datepicker();

});
$(function(){
$("#dp_paid_<?php echo $count; ?>").datepicker();
});
</script>
<?php
$count++;
}
?>
@stop