@extends('layouts.master')

@section('content')
 <div class="jumbotron">
<div class="row-fluid" style="color:#4dafd3;font-size:24px;font-weight: 400;line-height:24px;font-family: 'Syncopate', sans-serif;">
  <div class="span3 offset2">
    <span style="font-size: 36px;line-height: 49px;vertical-align: middle;" /> 1</span>
    <span style="vertical-align:middle;line-height:27px;">Search </span>
    <img src="{{{ asset('img/search-icon.png') }}}"    />
  </div>
  <div class="span3">
    <span style="font-size: 36px;line-height: 49px;vertical-align: middle;" /> 2</span>
    <span style="vertical-align:middle;">Compare </span>
    <img src="{{{ asset('img/compare-icon.png') }}}"    />
  </div>
  <div class="span3">
    <span style="font-size: 36px;line-height: 49px;vertical-align: middle;" /> 3</span>
    <span style="vertical-align:middle;">Save </span>
    <img src="{{{ asset('img/save-icon.png') }}}"    />
  </div>

  </div>
  <div class="row-fluid">
  <div class="span12">
             {{ Form::open(array('url'=> 'books/isbn', 'method' => 'post', 'class' => 'form-search')) }}

             {{ Form::token() }}

                  <div class='input-append'>
                    <input type="text" name="isbn" placeholder="Enter your ISBN #" class="span11 search-query" />
                    <button type="submit" class="btn">Get Prices</button>
                  </div>

                  {{ Form::close() }}
</div>
      </div>
      </div>
<div class="row-fluid home-blocks">
  <div class="span4 home-block-1">
    <div class="block-content">
    <h3>Buy Textbooks</h3>
    <p>Get the lowest prices on new textbooks. Save Hundreds by buying cheap used textbooks or discounted eBook textbooks. </p>
    </div>
  </div>
  <div class="span4 home-block-2">
    <div class="block-content">
    <h3>Rent Textbooks</h3>
    <p>Renting textbooks is one of the easiest ways to save money on textbooks. Rent them for the semester and return them when you're done.</p>
    </div>
  </div>
  <div class="span4 home-block-3">
    <div class="block-content">
    <h3>Sell Textbooks</h3>
    <p>Got old textbooks laying around? Turn them into cold hard cash. Featuring the best buyback rates online!</p>
    </div>
  </div>
  </div>
      <hr>

      <!-- Example row of columns -->
      <div class="row-fluid">
        <div class="span4">
<a href="http://www.tkqlhce.com/click-7171865-11398628" target="_top">
<img src="http://www.ftjcfx.com/image-7171865-11398628" width="300" height="250" alt="" border="0"/></a>
        </div>
        <div class="span4">
         <a href="http://www.anrdoezrs.net/click-7205117-10577310" target="_top">
<img src="http://www.awltovhc.com/image-7205117-10577310" width="270" height="155" alt="Click here to save with Student Advantage!" border="0"/></a>

<div class="row-fluid" style="text-align:center;margin-top:15px;">
<div class="span5" style="margin-left:5px;"><a href="http://www.jdoqocy.com/click-7205117-11236383" target="_top">
<img src="http://www.ftjcfx.com/image-7205117-11236383" width="120" height="60" alt="" border="0"/></a>
</div><div class="span5"><a href="http://www.tkqlhce.com/click-7205117-11136286" target="_top">
<img src="http://www.awltovhc.com/image-7205117-11136286" width="120" height="60" alt="" border="0"/></a></div>
</div>
       </div>
        <div class="span4">

          <a href="http://www.dpbolvw.net/click-7205117-10494111" target="_top">
<img src="http://www.tqlkg.com/image-7205117-10494111" width="300" height="250" alt="I signed up on Tuesday" border="0"/></a>
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