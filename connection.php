<?php
// Connect to Database
$conn = new mysqli('localhost','root','','inventory');
if(!$conn){
	die('Sorry, We are having some problems.');
}
?>