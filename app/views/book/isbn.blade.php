@extends('layouts.master')
@section('title')
Top TextBook Price : {{ $book->title }}
@stop
@section('content')

<div class="row-fluid">
  @if (strlen($book->title) > 110)
  <div class="span12"><h2>{{ substr($book->title, 0, 110) }}...</h2></div>
  @else
  <div class="span12"><h2>{{ $book->title }}</h2></div>

  @endif
  <div class="span4 muted">
    <img src="<?php if ($book->image_url) {echo $book->image_url; } else {echo URL::asset('img/no_image.png'); } ?>" width="300"><br />

  </div>
  <div class="span6">

    <dl class="dl-horizontal">
    <dt>Author:</dt><dd>{{  $book->author }}</dd> <br />
    <dt>Publisher:</dt><dd>{{  $book->publisher }} <br /></h4>
    <dt>Edition:</dt><dd>{{  $book->edition }} <br />
    <dt>Number of Pages:</dt><dd>{{ $book->num_of_pages }} <br />
    <dt>Weight:</dt><dd>{{ number_format($book->weight, 2) }} lbs<br />
    <dt>List Price:</dt><dd>{{ $book->list_price }} <br />
    <dt>ISBN:</dt><dd>{{ $book->isbn10 }} / {{ $book->isbn13 }} <br />

    <a href="{{ $book->amazon_url }}" target="_blank">View Book Details on Amazon</a>

  </div>

  <div class="span7">
   <table class="table table-condensed">
          <thead>
            <tr><td colspan='5'><h1 class="text-center">Best Prices</h1></td></tr>
            <tr>
              <th>Used</th>
              <th>New</th>
              <th>Rental</th>
              <th>eBook</th>
              <th>BuyBack</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                @if (!empty($best['used']))
                  <img src="{{ $best['used']['logo'] }}" width="100" height="25"/>
                 <h3>${{ number_format($best['used']['price'], 2) }}</h3>
                 <a href="{{$best['used']['url']}}" class="btn btn-danger">Buy Now</a>
                @endif
              </td>
              <td>
                @if (!empty($best['new']))
                  <img src="{{ $best['new']['logo'] }}" width="100" height="25"/>
                 <h3>${{ number_format($best['new']['price'], 2) }}</h3>
                 <a href="{{$best['new']['url']}}" class="btn btn-danger">Buy Now</a>
                @endif
              </td>
              <td>

                @if (!empty($best['rental']['price']))

                  <img src="{{ $best['rental']['logo'] }}" width="100" height="25"/>
                 <h3>${{ number_format($best['rental']['price'], 2) }}</h3>
                 <a href="{{$best['rental']['url']}}" class="btn btn-danger">Buy Now</a>
                @else
                  <h2 class="text-center">N/A</h2>
                @endif
              </td>
              <td>
                @if (!empty($best['ebook']['price']))
                  <img src="{{ $best['ebook']['logo'] }}" width="100" height="25"/>
                 <h3>${{ number_format($best['ebook']['price'], 2) }}</h3>
                 <a href="{{$best['ebook']['url']}}" class="btn btn-danger">Buy Now</a>
                 @else
                  <h2 class="text-center">N/A</h2>
                @endif
              </td>
              <td>
                @if (!empty($best['buyback']))
                  <img src="{{ $best['buyback']['logo'] }}" width="100" height="25"/>
                 <h3>${{ number_format($best['buyback']['price'], 2) }}</h3>
                 <a href="{{$best['buyback']['url']}}" class="btn btn-success">Sell Now</a>
                @endif
              </td>
            </tr>
          </tbody>
        </table>
    <ul class="nav nav-tabs" id="myTab">
      <li class="<?php if($activeTab=="buy" or empty($activeTab)) {echo "active"; } ?>"><a href="#buy">Buy / Rent Textbooks</a></li>
      <li class="<?php if($activeTab=="sell") {echo "active"; } ?>"><a href="#sell">Sell Textbooks</a></li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane <?php if($activeTab=="buy" or empty($activeTab)) {echo "active"; } ?>" id="buy">

        <table class="table table-striped">
        <thead>
            <tr>
              <th>
                @if ($orderby=='merchant_id' && $dir=='ASC')
                  <a href="{{URL::to("book/isbn/$isbn?orderby=merchant_id&dir=DESC&a=buy")}}">Merchant</a>
                @else
                  <a href="{{URL::to("book/isbn/$isbn?orderby=merchant_id&dir=ASC&a=buy")}}">Merchant</a>
                @endif
              </th>
              <th>
                @if ($orderby=='amount_used' && $dir=='ASC')
                  <a href="{{URL::to("book/isbn/$isbn?orderby=amount_used&dir=DESC&a=buy")}}">Used</a>
                @else
                  <a href="{{URL::to("book/isbn/$isbn?orderby=amount_used&dir=ASC&a=buy")}}">Used</a>
                @endif
              </th>
              <th>
                @if ($orderby=='amount_new' && $dir=='ASC')
                  <a href="{{URL::to("book/isbn/$isbn?orderby=amount_new&dir=DESC&a=buy")}}">New</a>
                @else
                  <a href="{{URL::to("book/isbn/$isbn?orderby=amount_new&dir=ASC&a=buy")}}">New</a>
                @endif
              </th>
              <th>
                @if ($orderby=='amount_rental' && $dir=='ASC')
                  <a href="{{URL::to("book/isbn/$isbn?orderby=amount_rental&dir=DESC&a=buy")}}">Rental</a>
                @else
                  <a href="{{URL::to("book/isbn/$isbn?orderby=amount_rental&dir=ASC&a=buy")}}">Rental</a>
                @endif
              </th>
              <th>
                @if ($orderby=='amount_ebook' && $dir=='ASC')
                  <a href="{{URL::to("book/isbn/$isbn?orderby=amount_ebook&dir=DESC&a=buy")}}">eBook</a>
                @else
                  <a href="{{URL::to("book/isbn/$isbn?orderby=amount_ebook&dir=ASC&a=buy")}}">eBook</a>
                @endif
              </th>
            </tr>
          </thead>
          @foreach ($prices as $price)
          <?php if ($price->amount_used OR $price->amount_new OR $price->amount_ebook OR $price->amount_rental) { ?>
          <tr>
            <td><img src="{{ $price->logo_url }}" width="120" /></td>
            <td>@if ($price->amount_used != null )
                  ${{ number_format($price->amount_used, 2) }}
                  <br /><a href="{{ $price->url_used }}">Buy Now</a>
                @else N/A
                @endif
            </td>
            <td>@if ($price->amount_new != null )
                  ${{ number_format($price->amount_new, 2)  }}
                  <br /><a href="{{ $price->url_new }}">Buy Now</a>
                @else N/A
                @endif
            </td>
            <td>@if ($price->amount_rental != null )
                  ${{ number_format($price->amount_rental, 2) }}
                  <br /><a href="{{ $price->url_rental }}">Buy Now</a>
                @else N/A
                @endif
            </td>
            <td>@if ($price->amount_ebook != null )
                  ${{ number_format($price->amount_ebook, 2)  }}
                  <br /><a href="{{ $price->url_ebook }}">Buy Now</a>
                @else N/A
                @endif
            </td>

          </tr>
          <?php } ?>
          @endforeach
        </table>
      </div>
            <div class="tab-pane <?php if($activeTab=="sell") {echo "active"; } ?>" id="sell" >
        <table class="table table-striped">
          <thead>
            <tr>
              <th>
                @if ($orderby=='merchant_id' && $dir=='ASC')
                  <a href="{{URL::to("book/isbn/$isbn?orderby=merchant_id&dir=DESC&a=sell")}}">Merchant</a>
                @else
                  <a href="{{URL::to("book/isbn/$isbn?orderby=merchant_id&dir=ASC&a=sell")}}">Merchant</a>
                @endif
              </th>
              <th>
                @if ($orderby=='amount_buyback' && $dir=='ASC')
                  <a href="{{URL::to("book/isbn/$isbn?orderby=amount_buyback&dir=DESC&a=sell")}}">Sell Your Books</a>
                @else
                  <a href="{{URL::to("book/isbn/$isbn?orderby=amount_buyback&dir=ASC&a=sell")}}">Sell Your Books</a>
                @endif
              </th>
            </tr>
          </thead>
          <tbody>
          @foreach ($prices as $price)
          @if (!empty($price->amount_buyback) && $price->amount_buyback!= null)
          <tr>
            <td><img src="{{ $price->logo_url }}" width="120" /></td>
            <td>@if ($price->amount_buyback != null )${{ number_format($price->amount_buyback, 2) }} @else N/A @endif<br /><a href="{{ $price->url_buyback }}">Sell TextBooks</a></td>


          </tr>
          @endif
          @endforeach
          </tbody>
        </table>
      </div>
<?php  // echo $add_to_cart  - removed cart partial  ?>
<div class="row-fluid span12 offset1">
  <h3>Recent Text-Book Prices</h3><hr>
  <table>
  @foreach ($books as $b)
      <div class="span10" style="padding-top:20px;">
        <div class="span3">
          <img src="{{$b->image_url}}" width="200" height="200">
        </div>
        <div class="span9">
          <dl class="dl-horizontal">
              <dt>Title:</dt><dd><a href="<?php echo URL::to("book/$b->slug"); ?>">{{$b->title}}</a></dd>
              <dt>ISBN:</dt><dd>{{ $b->isbn10 }} / {{$b->isbn13}}</dd>
              <dt>Author:</dt><dd>{{ $b->author }}</dd>
              <dt>Publisher:</dt><dd>{{ $b->publisher }}</dd>
              <dt>Edition:</dt><dd>{{ $b->edition }} </dd>
              <dt>Number of Pages:</dt><dd>{{ $b->num_of_pages }}</dd>

          </dl>

        </div>
      </div>

  @endforeach
</table>
</div>
</div>

@stop
@section('footer')
    <script>
$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
})
@if ($activeTab == "sell")
$('#myTab a[href="#sell"]').tab('show');
@elseif ($activeTab == "buy" || empty($activeTab))
$('#myTab a[href="#buy"]').tab('show');
@else
$('#myTab a[href="#buy"]').tab('show');
@endif
  </script>
  @stop