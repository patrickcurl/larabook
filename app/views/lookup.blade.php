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
    <img src="{{ $book->image_url }}" width="300"><br />

  </div>
  <div class="span6">

    <dl class="dl-horizontal">
    <dt>Author:</dt><dd>{{  $book->author }}</dd> <br />
    <dt>Publisher:</dt><dd>{{  $book->publisher }} <br /></h4>
    <dt>Edition:</dt><dd>{{  $book->edition }} <br />
    <dt>Number of Pages:</dt><dd>{{ $book->num_of_pages }} <br />
    <dt>List Price:</dt><dd>${{  number_format($book->list_price/100, 2) }} <br />
    <dt>ISBN:</dt><dd>{{ $book->isbn10 }} / {{ $book->isbn13 }} <br />
    <a href="{{ $book->amazon_url }}" target="_blank">View Book Details on Amazon</a>
  </div>

  <div class="span7">
    <ul class="nav nav-tabs" id="myTab">
      <li class="active"><a href="#buy">Buy / Rent Textbooks</a></li>
      <li><a href="#sell">Sell Textbooks</a></li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane active" id="buy">
        <table class="table table-striped">
          <tr>
            <td>  
              @if (Input::get('orderby')=='merchant_id' && Input::get('dir')=='ASC') 
                <a href="{{ URL::current() }}?isbn={{Input::get('isbn')}}&orderby=merchant_id&dir=DESC">Seller</a>  
              @else 
                <a href="{{ URL::current() }}?isbn={{Input::get('isbn')}}&orderby=merchant_id&dir=ASC">Seller</a> 
              @endif
            </td>
            <td>  
              @if (Input::get('orderby')=='amount_used' && Input::get('dir')=='ASC') 
                <a href="{{ URL::current() }}?isbn={{Input::get('isbn')}}&orderby=amount_used&dir=DESC">Used</a>  
              @else 
                <a href="{{ URL::current() }}?isbn={{Input::get('isbn')}}&orderby=amount_useddir=ASC">Used</a> 
              @endif
            </td>
            <td>  
              @if (Input::get('orderby')=='amount_new' && Input::get('dir')=='ASC') 
                <a href="{{ URL::current() }}?isbn={{Input::get('isbn')}}&orderby=amount_new&dir=DESC">New</a>  
              @else
                <a href="{{ URL::current() }}?isbn={{Input::get('isbn')}}&orderby=amount_new&dir=ASC">New</a> 
              @endif
            </td>
            <td>  
              @if (Input::get('orderby')=='amount_rental' && Input::get('dir')=='ASC') 
                <a href="{{ URL::current() }}?isbn={{Input::get('isbn')}}&orderby=amount_ebook&dir=DESC">Rental</a>  
              @else 
                <a href="{{ URL::current() }}?isbn={{Input::get('isbn')}}&orderby=amount_ebook&dir=ASC">Rental</a> 
              @endif
            </td>
            <td>  
              @if (Input::get('orderby')=='amount_ebook' && Input::get('dir')=='ASC') 
                <a href="{{ URL::current() }}?isbn={{Input::get('isbn')}}&orderby=merchant_id&dir=DESC">eBook</a>  
              @else 
                <a href="{{ URL::current() }}?isbn={{Input::get('isbn')}}&orderby=merchant_id&dir=ASC">eBook</a> 
              @endif
            </td>
          </tr>
          @foreach ($prices as $price)
          <tr>
            <td><img src="{{ $price->merchant->logo_url }}" /></td>
            <td>@if ($price->amount_used != null )${{ number_format($price->amount_used, 2) }} @else N/A @endif<br /><a href="{{ $price->url_used }}">Buy Now</a></td>
            <td>@if ($price->amount_new != null )${{ number_format($price->amount_new, 2)  }} <br /><a href="{{ $price->url_new }}">Buy Now</a> @else N/A @endif</td>
            <td>@if ($price->amount_rental != null )${{ number_format($price->amount_rental, 2) }} <br /><a href="{{ $price->url_rental }}">Buy Now</a>@else N/A @endif</td>
            <td>@if ($price->amount_ebook != null )${{ number_format($price->amount_ebook, 2)  }} <br /><a href="{{ $price->url_ebook }}">Buy Now</a>@else N/A @endif</td>

          </tr>
          @endforeach
        </table>
      </div>
      <div class="tab-pane" id="sell">
   @if ($buyback > 0.01)     
 <h2 style="text-align:center">Current Buyback Price</h2>
 <br />

 <div class="span3 offset1"><h3>${{ $buyback }}</h3></div>
 <div class="span7">
             
                 {{ Form::open(array('action' => 'CartController@addCartItem', 'method' => 'post')) }}
                 {{ Form::token() }}
                 <input type="hidden" name="id" value="{{ $book->id }}" />
                 <input type="hidden" name="price" value="{{ $buyback }}" />
                 <input type="hidden" name="name" value="{{ $book->title }}" />
                 <input type="hidden" name="qty" value="1" />
                 <input type="hidden" name="image_url" value="{{ $book->image_url }}" />
                 <input type="hidden" name="author" value="{{ $book->author }}" />
                 <input type="hidden" name="publisher" value="{{ $book->publisher }}" />
                 <input type="hidden" name="edition" value="{{ $book->edition }}" />
                 <input type="hidden" name="isbn10" value="{{ $book->isbn10 }}" />
                 <input type="hidden" name="isbn13" value="{{ $book->isbn13 }}" />
                 <input type="image" src="img/addtocart.png" name="addToCart" />
                 {{ Form::close() }}
            
      </div>
        @else
                <h3>Currently, we are not buying this book.</h3>
              @endif
    </div>
  </div>
</div>

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
              <dt>Title:</dt><dd><a href="{{URL::current()}}?isbn={{$b->isbn13}}">{{$b->title}}</a></dd>
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
