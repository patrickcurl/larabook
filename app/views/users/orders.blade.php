@extends('layouts.master')
@section('head')
<style>
 div[id^=printSection] {
      visibility: hidden;
    }
@media (min-width: 980px) {
    tr.visible-desktop {
        display:table-row !important;
    }
    td.visible-desktop,
    th.visible-desktop {
        display:table-cell !important;
    }
}

@media (min-width: 768px) and (max-width: 979px) {

    tr.hidden-desktop,
    tr.visible-tablet {
        display:table-row !important;
    }
    td.hidden-desktop,
    th.hidden-desktop,
    td.visible-tablet,
    th.visible-tablet {
        display:table-cell !important;
    }
}

@media (max-width: 767px) {
    tr.hidden-desktop,
    tr.visible-phone {
        display:table-row !important;
    }
    td.hidden-desktop,
    th.hidden-desktop,
    td.visible-phone,
    th.visible-phone {
        display:table-cell !important;
    }
}


</style>

@stop
@section('content')
<?php $currentUser = Sentry::getUser(); ?>
<br />
<div class="row-fluid">
<table class="table table-condensed table-hover  table-striped">
  <thead class="success">
    <tr style="background-color:gray;color:white;" >
      <th>#</th>
      <th>Total</th>
      <th>Items</th>
      <th>Comments</th>
    </tr>
  </thead>
  @foreach ($orders as $g => $order)

    <tbody>
    <tr>
      <?php $orderNum = $g+1; ?>
        <td>{{ $orderNum }}</td>
        <td>  ${{ number_format($order['total_amount'],2) }} </td>

        <td>
          @foreach($order['items'] as $i => $item)
          <table class="table table-hover table-condensed">




            <tr><td colspan="3">{{ $item['title'] }}</td>
            <tr>
              <td></td>
              <td><img src="{{ $item['image_url'] }}" width="100" class="visible-desktop"></td>
              <td>
                Author: {{ $item['author'] }}
                <br />Publisher: {{ $item['publisher'] }}

                <br />ISBN10: {{ $item['isbn10'] }}
                <br />ISBN13: {{ $item['isbn13'] }}
                <br />Edition: {{ $item['edition'] }}
                <br />Quantity: {{ $item['qty'] }}
                <br />Price: ${{ number_format($item['price'],2) }}
              </td>
            </tr>

            @endforeach

          </table>
        </td>
          <td>

              Order Date: {{$order['created_at']->format("n/d/Y") }}
              <br />Received Date: @if($order['shipment_received']) {{ date("n/d/Y", strtotime($order['shipment_received'])) }} @else Pending @endif
              <br />Payment Date:  @if($order['payment_sent']) {{ date("n/d/Y", strtotime($order['payment_sent'])) }} @else Pending @endif
              <br /><a href="#" class="btn" onClick='document.getElementById("ifr").src="{{URL::to('/orders/label/' . $order['id']) }}";'>Print Shipping Label</a>
              <a href="#" class="btn" onClick='document.getElementById("ifr").src="{{URL::to('/orders/packing-slip/' . $order['id']) }}";'>Print Packing Slip</a>
              <iframe id='ifr' frameborder="0" scrolling="no" width="0" height="0" /></iframe>



              <br />
            <br />{{ $order['comments'] }}</td>


    </tr>



  @endforeach
</tbody>

</table>
</div>



<!-- orders -->

@stop