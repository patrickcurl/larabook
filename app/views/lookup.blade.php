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
            <strong>Author:</strong> {{ $book->author }} <br />
            <strong>Publisher:</strong> {{ $book->publisher }} <br />
            <strong>Edition:</strong> {{ $book->edition }} <br />
            <strong>Number of Pages:</strong> {{ $book->num_of_pages }} <br />
            <strong>List Price</strong> ${{ number_format($book->list_price/100, 2) }} <br />
            <a href="{{ $book->amazon_url }}" target="_blank">View Book Details on Amazon</a>
     
          </div>
 
 
          <div class="large-9 columns">
 
            <h3 class="show-for-small">Compare Textbook Prices:<hr/></h3>
 
            <div class="panel">
              <h4 class="hide-for-small">Compare Textbook Prices:<hr/></h4>
            <h5 class="subheader">I don't have to tell you how expensive college text-books can be, that's why we created this nifty thrifty college textbook pricing tool. <br /><br />
            Get up-to-the-minute price quotes on thousands of text-books simply enter the ISBN# below! Our mission is to help more people go to college, buy lowering the costs, we can show you how you can save hundreds by price-comparing at EVERY major text-book supplier on the market! <br /><br />Don't buy a textbook till you check TopBookPrices.com!</h5>
            </div>
 
          <div class="row">
            
              <div class="large-12 columns">
                <div class="panel">
                  <h5>Prices</h5>
                  <div class="row">

                  <div class="small-2 columns">Seller</div>
                  <div class="small-2 columns">Used</div>
                  <div class="small-2 columns">New</div>
                  <div class="small-2 columns">Rental <br /></div>
                  <div class="small-2 columns">Ebook</div>
                  <div class="small-2 columns">Buy Back Offer</div>




                  <div class="small-2 columns"><img src="{{ $prices['new']['amazon']['logo_url'] }}" /></div>
                  <div class="small-2 columns">{{ $prices['new']['amazon']['price']  }}</div>
                  <div class="small-2 columns">{{ $prices['new']['amazon']['price']  }}</div>
                  <div class="small-2 columns">{{ $prices['new']['amazon']['price']  }}</div>
                  <div class="small-2 columns">{{ $prices['new']['amazon']['price']  }}</div>
                  <div class="small-2 columns">{{ $prices['new']['amazon']['price']  }}</div>
             
                 </div>
                
                </div>
              </div>
          </div>
 
          </div>
 
        </div>
 
      <!-- End Header Content -->
 
 
      <!-- Search Bar -->
 
        <div class="row">
 
          <div class="large-12 columns">
            <div class="radius panel">
 
            
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