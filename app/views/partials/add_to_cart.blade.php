<?php //$buyback = 0; ?>
<!-- add_to_cart.blade.php -->
<!--      <div class="tab-pane" id="sell">
   @if ($buyback > 0.01)
 <h2 style="text-align:center">Current Buyback Price</h2>
 <br />

 <div class="span3 offset1"><h3>${{ $buyback }}</h3></div>
 <div class="span7">

                 {{ Form::open(array('action' => 'CartController@postAdd', 'method' => 'post')) }}
                 {{ Form::token() }}
                 <input type="hidden" name="id" value="{{ $book->id }}" />
                 <input type="hidden" name="price" value="{{ $buyback }}" />
                 <input type="hidden" name="name" value="{{ $book->title }}" />
                 <input type="hidden" name="weight" value="{{ $book->weight }}" />
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
-->