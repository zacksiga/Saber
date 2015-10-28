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
require('connect.php');// Conntention to database

class showoop
{
	public function showpic() //script to show picture in the picture folder
	{
		$folder = '../picture/';
		$filetype = '*.*';
		$files = glob($folder.$filetype);
		$count = 6;
 
		echo '<table>';
		for ($i = 0; $i < $count; $i++) {
    		echo '<tr><td>';
    		echo '<a name="'.$i.'" href="#'.$i.'"><img src="'.$files[$i].'" /></a>';
    		echo substr($files[$i],strlen($folder),strpos($files[$i], '.')-strlen($folder));
			$files[$i]=str_replace("/","",$files[$i]);
			echo '<p class="name"><u>'.$files[$i].'</u></p>';
    		echo '</td></tr>';
		}
		echo '</table>';
	}
	
	public function showlinks()//script to show links in a forum type 
	{
		require('connect.php');
		$resultlm = mysqli_query($con,"SELECT * FROM Rlink") or die("Could not bb connect: " . mysql_error());
		$count = 0;
		while($row = mysqli_fetch_array($resultlm))
		{//loop to setup the table for all the link in the system
			echo '<table width="50%" border="0" cellpadding="1">';
			echo '<td>';
			echo '<label for="linkname">link name</label>';
			echo '</td>';
			echo '<td>';
  			echo '<input name="linkname'.$count.'" type="text" id="linkname'.$count.'" value="'.$row['title'].'" />';
			echo '</td>';
			echo '<td>';
   			echo '<label for="linkurl">	linkurl</label>';
			echo '</td>';
			echo '<td>';
   			echo '<input name="linkurl'.$count.'" type="text" id="linkurl'.$count.'" value="'.$row['link'].'" />';
  			echo '<input type="hidden" name="linknum'.$count.'" id="linknum'.$count.'" value="'.$row['linkn'].'" />';
			echo '</td>';
			echo '</tr>';
			echo '</table>';
			
			$count = $count + 1;
		}//loop to get all link in the table
	}
	
	public function showcontent($title)
	{
		require('connect.php');
		$result = mysqli_query($con,"SELECT * FROM FrontpageContent WHERE FirstName = '$title'") or die("Could not connect db in re: " . mysql_error());//if not cache grab data from database. mysql query to select data for content
		$row = mysqli_fetch_array($result);//arrange data from result per row in result and send array of row in row 
		$info =  $row['content'];//extend row and grab data from content
		echo $info;
	}
}

?>