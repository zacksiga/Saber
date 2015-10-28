<?php

ob_start();
session_start();

require_once ('connect.php');//method of connect
$tbl_name="Adminpage"; // Table name

// username and password sent from form 
$myusername=$_POST['myusername']; //username from forum
$mypassword=$_POST['mypassword'];//password from forum

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);//clean username from slashes
$mypassword = stripslashes($mypassword);//claean password from slashes
$myusername = mysqli_real_escape_string($con,$myusername);//Clean for mysql syntx
$mypassword = mysqli_real_escape_string($con,$mypassword);//Clean for my mysql syntx

$encrypted_mypassword=hash('sha512' ,$mypassword);//Password hash type

$result=mysqli_query($con,"SELECT * FROM $tbl_name WHERE username='$myusername' and password='$encrypted_mypassword'"); //ql query statement
$row = mysqli_fetch_array($result);//stores info in row array
// Mysql_num_row is counting table row
$count=mysqli_num_rows($result);
// If result matched $myusername and $mypassword, table row must be 1 row

if($count==1){
// Register $myusername, $mypassword and redirect to file "login_success.php"
$_SESSION['username'] = $row['username'];
$_SESSION['LAST_ACTIVITY'] = time();
$_SESSION['TYPE'] = $row['type'];
header("location:index.php");
}
else {
$wronge= "Wrong Username or Password";
$_SESSION['wronge'];
header("location:adlogin.php");
}

mysqli_close();
?>