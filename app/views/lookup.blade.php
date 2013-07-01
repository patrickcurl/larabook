@extends('layouts.master')
@section('content')
<div class="row">
  <div class="large-12 columns"><h1>{{ $book->title }}</h1></div>
</div>
  <div class="row">
 
          <div class="large-3 columns">
 
            <img src="{{ $book->image_url }}"><br />
            <strong>ISBN 10:</strong> {{ $book->isbn10 }} <br />
            <strong>ISBN 13:</strong> {{ $book->isbn13 }} <br />
            <strong>Author:</strong> {{  $book->author }} <br />
            <strong>Publisher:</strong> {{  $book->publisher }} <br />
            <strong>Edition:</strong> {{  $book->edition }} <br />
            <strong>Number of Pages:</strong> {{ $book->num_of_pages }} <br />
            <strong>List Price</strong> ${{  number_format($book->list_price/100, 2) }} <br />
            <a href="{{ $book->amazon_url }}" target="_blank">View Book Details on Amazon</a>
     
          </div>
 
 
          <div class="large-9 columns">
 
            <h3 class="show-for-small">Compare Textbook Prices:<hr/></h3>
 
            <div class="panel">
              <h4 class="hide-for-small">Compare Textbook Prices:<hr/></h4>
                <div class="small-2 columns">Seller</div>
                  <div class="small-2 columns">Used</div>
                  <div class="small-2 columns">New</div>
                  <div class="small-2 columns">Rental <br /></div>
                  <div class="small-2 columns">Ebook</div>
                  <div class="small-2 columns">Buy Back</div>
            <hr />
              @foreach ($prices as $price)
                
                  <div class="small-2 large-2 columns"><img src="{{ $price->merchant->logo_url }}" /></div>
                  <div class="small-2 large-2 columns">{{ number_format($price->amount_used, 2) }}<br /><a href="">Buy Now</a></div>
                  <div class="small-2 large-2 columns">{{ number_format($price->amount_new, 2)  }}</div>
                  <div class="small-2 large-2 columns">{{ number_format($price->amount_rental, 2) }}</div>
                  <div class="small-2 large-2 columns">{{ number_format($price->amount_ebook, 2)  }}</div>
                  <div class="small-2 large-2 columns">{{ number_format($price->amount_buyback, 2) }}</div>

                
             @endforeach   
<br />
              
 
          </div>
 
      
 
      <!-- End Header Content -->
 
 
      <!-- Search Bar -->
 
        <div class="row">
 
          <div class="large-12 columns">
            <div class="radius panel">
 
            {{ Form::open(array('action' => 'BookController@getLookup', 'method' => 'get')) }}
              {{ Form::token() }} 
              <div class="row collapse">
 
                <div class="large-10 small-8 columns">
                  <input type="text" name="isbn" placeholder="Enter your ISBN #" />
                </div>
 
                <div class="large-2 small-3 columns">
                  <input type="submit" class="postfix button expand" value="Get Prices" />
               
                </div>
 
              </div>
            {{ Form::close() }}
 
          </div>
          </div>
 
        </div>
 
      <!-- End Search Bar -->
 
 
      <!-- Thumbnails -->
 
        <div class="row">
 
          <div class="large-12 show-for-small columns">
          <h3>Header</h3><hr>
        </div>
 
          <div class="large-3 small-6 columns">
            <img src="http://placehold.it/500x500&text=Thumbnail">
            <div class="panel">
              <p>Description</p>
            </div>
          </div>
 
          <div class="large-3 small-6 columns">
            <img src="http://placehold.it/500x500&text=Thumbnail">
            <div class="panel">
              <p>Description</p>
            </div>
          </div>
 
          <div class="large-3 small-6 columns">
            <img src="http://placehold.it/500x500&text=Thumbnail">
            <div class="panel">
              <p>Description</p>
            </div>
          </div>
 
          <div class="large-3 small-6 columns">
            <img src="http://placehold.it/500x500&text=Thumbnail">
            <div class="panel">
              <p>Description</p>
            </div>
          </div>
 
        </div>
 
      <!-- End Thumbnails -->
 
 
      <!-- Footer -->
 
        <footer class="row">
        <div class="large-12 columns"><hr />
            <div class="row">
 
              <div class="large-6 columns">
                  <p>&copy; Copyright no one at all. Go to town.</p>
              </div>
 
              <div class="large-6 columns">
                  <ul class="inline-list right">
                    <li><a href="#">Link 1</a></li>
                    <li><a href="#">Link 2</a></li>
                    <li><a href="#">Link 3</a></li>
                    <li><a href="#">Link 4</a></li>
                  </ul>
              </div>
 
            </div>
        </div>
      </footer>

 
@stop