<?php
$isbn = "9780131367739";
$biggerbooks = simplexml_load_string(file_get_contents("http://www.biggerbooks.com/botpricexml?isbn=$isbn"));
echo $biggerbooks->NewPrice[0];

?>