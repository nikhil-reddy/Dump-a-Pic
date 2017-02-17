<!-- using Session variable to limit access to only authorized user to edit uploaded content.-->

<?php
ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }?>

 <?php
 // select loggedin users detail
 $res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
 $userRow=mysql_fetch_array($res);
 $email = $userRow['userEmail'];
 
include('dbconnect.php'); //include of db config file
include ('paginate.php'); //include of paginat page
$per_page = 10; // number of results to show per page

//fetching al image content belonging to logged in user based on Session variable.
$result = mysql_query("SELECT * FROM user_images ui, users u WHERE ui.userEmail = u.userEmail AND u.userId=".$_SESSION['user']." ORDER BY ui.imageId DESC");


$total_results = mysql_num_rows($result);
$total_pages = ceil($total_results / $per_page);//total pages we going to have


//-------------if page is setcheck------------------//
$show_page=1; 
if (isset($_GET['page'])) 
{
  $show_page = $_GET['page']; //current page
  if ($show_page > 0 && $show_page <= $total_pages) 
  {
   $start = ($show_page - 1) * $per_page;
   $end = $start + $per_page;
  }
  else 
  {
    // error - show first set of results
    $start = 0;
    $end = $per_page;
  }
} 
else 
{
// if page isn't set, show first set of results
$start = 0;
$end = $per_page;
}


// display pagination
$page = intval($_GET['page']);
$tpages=$total_pages;
if ($page <= 0)
$page = 1;

?>
 <HTML>
<HEAD>
<TITLE>Dump-a-Pic.com</TITLE>
<link href="imageStyles.css" rel="stylesheet" type="text/css" />
</HEAD>
<nav class="navbar navbar-default navbar-fixed-top">
        <div id="navbar" class="navbar-collapse collapse">
          <h1>Hi! <?php echo $userRow['userName'];?></h1>
          
        </div>
    
    </nav>  


</HTML>
<HTML>
<ul class="nav navbar-nav navbar-right">
            
            
              
                <li><a href="home.php?listImages"><span class="glyphicon glyphicon-list-images"></span>&nbsp;Upload New Image</a></li>
                <li><a href="listImages.php?listImages"><span class="glyphicon glyphicon-list-images"></span>&nbsp;View all Images</a></li>
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>

              </ul>
            
          </ul>
</HTML>


<?php
$reload = $_SERVER['PHP_SELF'] . "?tpages=" . $tpages;
echo '<div class="pagination"><ul>';
if ($total_pages > 1) {
echo paginate($reload, $show_page, $tpages);
}

for ($i = $start; $i < $end; $i++) {
// making sure that PHP doesn't try to show results out of the upperbounds in the database.
if ($i == $total_results) {
break;
}


$id = mysql_result($result, $i, 'imageId');
$tmp =$id;
$caption= mysql_result($result, $i, 'imageCaption');


echo '<div style="float:left;margin:0 0 6px 18px;padding:4px;text-align:center;border:1px solid #000010;">
<img style="width:500px;height:500px;border:0;" src="data:image/jpeg;base64,'.base64_encode( mysql_result($result, $i, 'imageData') ).'" title= "Zzz" width="500" height="500" alt=""  alt="Grand Canyon" /> <br/>'.$caption.' <br/>';
echo "<a href='edit_form.php?id=".$id."'>Edit Picture</a> &nbsp";  echo "<a href='editCaption_form.php?id=".$id."'>Edit Caption</a> &nbsp";  echo "<a href='delete_form.php?id=".$id."'>Flush It!</a>

</div>";

}

// pagination
?>


