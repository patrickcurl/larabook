<p><script language="javascript" type="text/javascript">
function open_window(rid)
{
window.open('paking_slip.php?rid='+rid,'Packing Slip','width=200,height=100')
}
</script><?PHP<br />
// http://localhost/wordpress/details_bl</p>
<p>session_start();<br />
$session_id=session_id();<br />
$first_name=$_REQUEST['first_name'];<br />
$last_name=$_REQUEST['last_name'];<br />
$email=$_REQUEST['email'];<br />
$phone=$_REQUEST['phone'];<br />
$address=$_REQUEST['address'];<br />
$city=$_REQUEST['city'];<br />
$state=$_REQUEST['state'];<br />
$zip=$_REQUEST['zip'];<br />
$paypal=$_REQUEST['paypal_user'];<br />
$cheque= $_REQUEST['cheque_user'];<br />
$pmethod = $_REQUEST['pmethod'];<br />
$cart_detail=serialize($_SESSION['cart']);<br />
if($_SESSION['dcnt_flag']==1)<br />
{<br />
$mheader="<br/> Coupon Promotion (";<br />
if($_SESSION['dcnt_type']==1) { $mheader .= $_SESSION['dcnt_price']." %"; }<br />
else { $mheader .= "$ ".$_SESSION['dcnt_price']; }<br />
$mheader .= ")&nbsp;&nbsp;: Donation To : ". $_SESSION['dcnt_dname'];<br />
}<br />
else<br />
{<br />
$mheader = "";<br />
}<br />
$tem=array();<br />
$tem=$_SESSION['cart']['price'];<br />
//print_r($tem);<br />
$total=array_sum($tem);<br />
//echo $total;</p>
<p>if($first_name!="" && $last_name!="" && $email!="" && $phone!="" && $address!="" && $city!="" && $state!="" && $zip!="")<br />
{<br />
     $sql="select * from wp_order_detail where session_id='".$session_id."'";<br />
     $rs=mysql_query($sql);<br />
     if(mysql_num_rows($rs)>0)<br />
     {   //----------------------------------  update information<br />
         $sql="update wp_order_detail set first_name='".$first_name."',last_name='".$last_name."',email_address='".$email."',phone='".$phone."',address='".$address."',city='".$city."',state='".$state."',zip='".$zip."',paypal_user='".$paypal."',cheque_user = '".$cheque.", pmethod = '".$pmethod."', cart_detail='".$cart_detail."' where session_id='".$session_id."'";<br />
}<br />
     else<br />
     {  //----------------------------------  Insert information<br />
  $sql="insert into wp_order_detail (session_id,first_name,last_name,email_address,phone,address,city,state,zip,paypal_user,cart_detail, cheque_user, pmethod)<br />
  values('".$session_id."','".$first_name."','".$last_name."','".$email."','".$phone."','".$address."','".$city."','".$state."','".$zip."','".$paypal."','".$cart_detail."','".$cheque."','".$pmethod."')";<br />
     }<br />
  if(mysql_query($sql))<br />
      {<br />
          if($_session['last_id']!="")<br />
           { $last_id=$_session['last_id']; }<br />
          else<br />
           { $last_id=mysql_insert_id();<br />
             $_session['last_id']=$last_id;<br />
            }<br />
//echo("Thank You –");</p>
<p>// Always set content-type when sending HTML email<br />
$headers = "MIME-Version: 1.0" . "\r\n";<br />
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";<br />
$headers .= 'From: info@recycleabook.com' . "\r\n" .<br />
    'Reply-To: From: info@recycleabook.com' . "\r\n" .<br />
    'X-Mailer: PHP/' . phpversion();<br />
$admin_email = $admin_email = get_option('admin_email');<br />
$subject = "Name : ".$first_name." ".$last_name." <br/>E mail : ".$email."<br/>Phone : ".$phone."<br/>Address : ".$address."<br/> City : ".$city."<br/>State : ".$state."<br/>Zip : ".$zip."<br/>Payment Method : ".$_REQUEST['pmethod'].$mheader;<br />
if($_REQUEST['pmethod'] == 'PayPal')<br />
$subject .= "Paypal : ".$paypal;<br />
else<br />
$subject .= "Cheque : ".$_REQUEST['cheque_user'];<br />
$subject .= "<br/>Order ID : ".$last_id;<br />
//Affifliate commission integration<br />
if (!empty($_SESSION['ap_id']))<br />
{<br />
    $referrer = $_SESSION['ap_id'];<br />
}<br />
else if (isset($_COOKIE['ap_id']))<br />
{<br />
    $referrer = $_COOKIE['ap_id'];<br />
}<br />
if (!empty($referrer))<br />
{<br />
    wp_aff_award_commission($referrer,$total,$txn_id,$last_id,$email);<br />
}<br />
else<br />
{<br />
    //Not an affiliate conversion<br />
}<br />
// End of Affiliate Integration code</p>
<p>$subject .="<br/><br/></p>
<table width='644' cellpadding='2' cellspacing='2'>
<tr style='background-color:#3399CC; color:#FFFFFF; font-weight:bold;'>
<td>Book</td>
<td>Price</td>
<td>Qty</td>
</tr>
<p>";<br />
  for($i=0;$i<=count($_SESSION['cart']['isbn']);$i++)<br />
  {<br />
  if($_SESSION['cart']['isbn'][$i]!="")<br />
  {<br />
   //----- API Start<br />
  $final_data=max_price($_SESSION['cart']['isbn'][$i]);<br />
  $final_price=$final_data[3];                             // Price<br />
   if($final_price>0)<br />
   {<br />
  $show_checkout="true";<br />
$subject .= "</p>
<tr valign='middle' style='border-bottom:medium;'>
<td width='418'>".$final_data[0]."</td>
<td width='54'>$ ".$final_price."</td>
<td width='59'>".$_SESSION['cart']['qty'][$i]."</td>
</tr>
<p>>";<br />
$j++;<br />
}<br />
}<br />
}<br />
$subject .="</table>
<p>";<br />
/////////////////////////////////////////////////////////////////////////////////////////////////<br />
       mail($admin_email,'Order Detail', $subject, $headers);       mail($email,'Order Detail', $subject, $headers);<br />
     if($total > 20)<br />
     {<br />
       echo("</p>
<div align='center'>
<table width='100%'>
<tr>
<td><a href='fedex_label.php?fname=".$first_name."&lname=".$last_name."&email=".$email."&phone=".$phone."&address=".$address."&city=".$city."&state=".$state."&zcode=".$zip."&total=".$total."' target='_blank'><img src='/wp-content/themes/recycleabook/images/print_shipping_label.png' border='0' /></a></td>
<td><a href='#' onClick='open_window(\"".$_session['last_id']."\");'>Print Packing Slip</a></td>
</tr>
</table>
</div>
<p>");<br />
    }<br />
    else<br />
    {?></p>
<div align='center'>
<table width='100%'>
<tr>
<td>
      <strong style="font-size:15px;">Please take the books to the US Post office and ship "media mail" to</strong> <br><br />
      Recycleabook.com<br><br />
561 Congress Park Dr<br><br />
Centerville, OH, 45459</p>
<p>We also encourage you to purchase a bubble wrap envelope for around $1.50 to protect book during shipping. </p>
</td>
</tr>
<tr>
<td><a href='#' onClick='open_window("<?php echo $_session['last_id']; ?>.");'>Print Packing Slip</a></td>
</tr>
</table>
</div>
<p>  <?php }<br />
?></p>
<div align="center">
<p>&nbsp;</p>
<p>Thanks for you business. Please print the above shipping label and drop off at nearest Fedex.</p>
<p>&nbsp;</p>
<p><strong>Please Note: </strong> WE WILL NOT ACCEPT ANY MORE THAN 3 COPIES OF ANY BOOK<br />
WITHOUT AUTHORIZATION.  PLEASE CALL 937-439-4848 FOR<br />
PERMISSION TO SEND MOE THAN 3 COPIES OF ANY BOOK.
</p>
<p>&nbsp;</p>
<p><h1>PAYMENT</h1>
<p>How do you pay me? We mail you a check using USPS ordeposit funds into your PayPal account.
    </p>
</p>
<p>&nbsp; </p>
<p>How do I set up a PayPal accounr? Signup at <a href="http://www.paypal.com/" tagert="_BLANK">www.paypal.com</a> to link your credit card or bank account to a PayPal account.</p>
<p>&nbsp;</p>
<p>When will you pay me? We normally issue payment within one business day of processing your shipment.</p>
<p>&nbsp;</p>
<p>How long will it take to receive my check? We mail the checks using USPS, how long it takes to reach you is upto them. We normally issue payment within one business day of processing your shipment because we want you to get paid as quickly as possible.</p>
<p>  <br>
  </p>
</div>
<p><?php<br />
     /*?><script>window.location='fedex_label.php?fname=<?php echo $first_name; ?>&#038;lname=<?php echo $last_name; ?>&#038;email=<?php echo $email; ?>&phone=<?php echo $phone; ?>&address=<?php echo $address; ?>&city=<?php echo $city; ?>&state=<?php echo $state; ?>&zcode=<?php echo $zip; ?>&total=<?php echo $total; ?>';</script><?php*/<br />
     unset($_SESSION['cart']);<br />
    }}<br />
else<br />
  echo("all fields are mandatory");<br />
?></p>
