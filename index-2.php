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
?>
<?php
require('adminlay.php');
echo '<html>';
echo '<head>';
echo '<TITLE> ATOZ Office Solutions - '.$title.'</TITLE>';
echo '<link rel="stylesheet" type="text/css" href="template/css/indextpl.css" />';
echo '</head>';
echo '<body>';
echo $_SESSION['username'];
echo '<div id=main style="width:80%; margin-left:auto; margin-right:auto; margin-top:20px; height:auto" align="center">';
echo '<div id=top style="float:top;" align="center"><img src="images/top.jpg" align="middle" width="50%" height="25%" />';
echo '</div>';
echo '<div id=leftm style="width:20%; float:left; height:inherit" align="left">';
require('leftm.php');
echo '</div>
<div id=rightm style="width:20%; float:right; height:100%; " align="center">
</div>
<div id=content style="float:center;" align="center">';
eval('?>' . $info. '<?php '); 
print '</div>
<div id=bottom style="float:bottom; clear:left; width:100%;" align="center">
</div>
</div>
</body>
</html>';

?>