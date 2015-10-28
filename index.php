<?php

//full path to Smarty.class.php
require_once('Smarty.class.php');
require_once('connecttpl.php');//connect to database database connet file

$smarty = new Smarty();//Start smarty

$smarty->setTemplateDir('wsbzasite/templates');//Smarty templates dir
$smarty->setCompileDir('wsbzasite/templates_c');//Smarty complier dir
$smarty->setCacheDir('wsbzasite/cache');//Smarty Cache
$smarty->setConfigDir('wsbzasite/configs');//
$smarty->setCaching(Smarty::CACHING_LIFETIME_CURRENT);//Set true to cache 

$url = str_replace("/","",$_SERVER['REQUEST_URI']);//Check url address
//if($url = "" or $url = "index.php"){
$url = "Home";
//}//set url home when it reach the main page
// check cache, if not cache then get data
$my_cache_id = $url;
if(!$smarty->isCached('index.tpl',$my_cache_id)) {// check to see if their cache file exist
$result = mysqli_query($con,"SELECT * FROM FrontpageContent WHERE FirstName = '$url'") or die("Could not connect db in re: " . mysql_error());//if not cache grab data from database. mysql query to select data for content
$row = mysqli_fetch_array($result);//arrange data from result per row in result and send array of row in row 
$info =  $row['content'];//extend row and grab data from content
$smarty->assign('contentpl', $info);//shara data contentpl 
$resultlm = mysqli_query($con,"SELECT title, link FROM Rlink") or die("Could not bb connect: " . mysql_error());//mysql query to select data for all link
//
while($row = mysqli_fetch_array($resultlm)) {//loop for arrange and send data to array leftm
  $leftm[] = $row;//leftm per row of row
}//loop to get all link in the table 
$smarty->assign('mleft', $leftm);//shara data mleft
$result->free;//free the query 
$resultlm->free;//free the query 
mysqli_close($con);//connection close
}



$smarty->assign('page', $url);//shara data url with page
$smarty->display('index.tpl',$my_cache_id);//show index.tpl

?>