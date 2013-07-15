@extends('layouts.master')
@section('content')
 <div class="jumbotron">
        <h2>Compare TextBook Prices</h2>
        <p style="text-align:left;">I don't have to tell you how expensive college text-books can be, that's why we created this nifty thrifty college textbook pricing tool.</p>
<p style="text-align:left;">Get up-to-the-minute price quotes on thousands of text-books simply enter the ISBN# below! Our mission is to help more people go to college, buy lowering the costs, we can show you how you can save hundreds by price-comparing at EVERY major text-book supplier on the market!</p>
<p style="text-align:left;">Don't buy a textbook till you check TopBookPrices.com!</p>
             {{ Form::open(array('action' => 'BooksController@getLookup', 'method' => 'get', 'class' => 'form-search')) }}

             {{ Form::token() }}

                  <div class='input-append'>
                    <input type="text" name="isbn" placeholder="Enter your ISBN #" class="span4 search-query" />
                    <button type="submit" class="btn">Get Prices</button>
                  </div>

                  {{ Form::close() }}

      </div>

      <hr>

      <!-- Example row of columns -->
      <div class="row-fluid">
        <div class="span4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
        <div class="span4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
       </div>
        <div class="span4">
          <h2>Heading</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
      </div>



      <!-- End Header Content -->


      <!-- Search Bar -->



      <!-- End Search Bar -->


      <!-- Thumbnails -->

        <!--
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
    -->
      <!-- End Thumbnails -->


      <!-- Footer

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
      </footer> -->
@stop