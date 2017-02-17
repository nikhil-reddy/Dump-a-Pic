
<?php
ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }
include('dbconnect.php'); //include of db config file
$del=$_GET['id'];
$sql = mysql_query("DELETE FROM user_images WHERE imageID=". $del);
// $ins="delete from user_images where imageId='$del'";
$result=mysql_query($ins);

header("Location: editImages.php");
?>
