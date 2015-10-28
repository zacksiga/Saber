<? 
session_start();
//Check whether the session variable SESS_MEMBER_ID is present or not
if(!isset($_SESSION['username']) || (($_SESSION['TYPE']) == '')) {
	header("location:adlogin.php");
	exit();
}
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy;   // destroy session data in storage
	header("location:adlogin.php");
	exit();
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
echo $_POST['update'];
$typeupdate = $_POST['update'];//Store update form to type update
require('connect.php');// Conntention to database

if($typeupdate =="contentpage")//update content
{
	require('connect.php');// Conntention to database
	$content=$_POST['content'];// The middle content itself
	$title= $_POST['title'];// What page
	$content=mysqli_real_escape_string($con, $content);
	$indon = mysqli_query($con,"UPDATE FrontpageContent SET content = '".$content."' WHERE FirstName='".$title."'");//update the database 
	
	
	if(! $indon )
{
   echo $content;
  die('Could not delete data: ' . mysqli_error($con));
}

}
elseif($typeupdate == "linksup")//update the links
{
	$max =7;
	$count =0;
	while ($count < $max){
		
		$linkname0=$_POST['linkname'.$count.''];// link name
		$linkurl0=$_POST['linkurl'.$count.''];//link url
		$linknum0=$_POST['linknum'.$count.''];//link number
		$indon = mysqli_query($con,"UPDATE Rlink SET title = '".$linkname0."', link = '".$linkurl0."' WHERE linkn = '".$linknum0."'");//update the database 
		$count = $count +1;
	}
	
	if(! $indon )
{
  die('Could not delete links data: ' . mysql_error());
}
	
}
elseif($typeupdate == "pictures")//update the picture
{
	
	$picnum = $_POST['num'];// what num to change
	list($w, $h) = getimagesize($_FILES['ufile']['tmp_name']);
	
	$new_file_name="pic".$picnum.".jpg";
  /* calculate new image size with ratio */
  $width=$w;
  $height=$h;
  $ratio = max($width/$w, $height/$h);
  $h = ceil($height / $ratio);
  $x = ($w - $width / $ratio) / 2;
  $w = ceil($width / $ratio);
  /* new file name */
 $path= "../picture/".$new_file_name;
  /* read binary data from image file */
  $imgString = file_get_contents($_FILES['ufile']['tmp_name']);
  /* create image from string */
  $image = imagecreatefromstring($imgString);
  $tmp = imagecreatetruecolor($width, $height);
  imagecopyresampled($tmp, $image,
    0, 0,
    $x, 0,
    $width, $height,
    $w, $h);
  /* Save image */
if($ufile !=none)
	{
		if(imagejpeg($tmp, $path, 45))
		{
			echo "Successful<BR/>"; 

			//$new_file_name = new file name
			//$HTTP_POST_FILES['ufile']['size'] = file size
			//$HTTP_POST_FILES['ufile']['type'] = type of file
			echo "File Name :".$new_file_name."<BR/>"; 
			echo "File Size :".$HTTP_POST_FILES['ufile']['size']."<BR/>"; 
			echo "File Type :".$HTTP_POST_FILES['ufile']['type']."<BR/>"; 
		}
		else
		{
			echo "Error";
		}
	}
  /* cleanup memory */
  imagedestroy($image);
  imagedestroy($tmp);
}
else 
{
	echo $_POST['update'];
	echo 'failed';
}

?>
<html>
<head>
<script type="text/javascript">
<!--
function delayer(){
  <? print 'window.location = "index.php"'
?>}
//-->
</script>
</head> 
<body onLoad="setTimeout('delayer()', 2000)">
<?
//echo $typeupdate;
echo 'pass';
?>

</body>
</html>