<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h2>We received your shipment @ TopBookPrices.</h2>

    <p><b>Account:</b> {{{ $email }}}</p>
    <p>We received your shipment, and are processing it.</p> 
    <p>You can expect payment shortly.</p>
    <p>To view the status of your order, or order history please login at:</p> 
    {{  URL::to('users/login') }}
    <p>Be sure to bookmark us and comeback each semester.</p> 
    <p>Our customers save thousands on textbooks.</p>
    <p>Thank you, <br />
      ~The TopBookPrices Team</p>
  </body>
</html>