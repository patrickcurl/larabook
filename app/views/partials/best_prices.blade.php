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