<!-- no Session variable check as user can access the view all images page without logging in. -->
<HTML>
<HEAD>
<TITLE>Dump-a-Pic.com</TITLE>
<link href="imageStyles.css" rel="stylesheet" type="text/css" />
</HEAD>
<nav class="navbar navbar-default navbar-fixed-top">
        <div id="navbar" class="navbar-collapse collapse">
          <h1>Welcome! </h1>
          
        </div>
    
    </nav>  


</HTML>

 <?php

//include database configuration file and pagination function 

include('dbconnect.php'); 
include ('paginate.php'); 


$per_page = 10; // number of results to show per page
$result = mysql_query("SELECT * FROM user_images ORDER BY imageID DESC"); // sorting images by newest image first as imageId increases with timestamp and submission no.
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
  else {
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
<ul class="nav navbar-nav navbar-right">
            
            
              
                <li><a href="home.php?listImages"><span class="glyphicon glyphicon-list-images"></span>&nbsp;Upload New Image</a></li>
                <li><a href="editImages.php?editImages"><span class="glyphicon glyphicon-list-images"></span>&nbsp;Edit your Images</a></li>
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
// database entries upperbound check
if ($i == $total_results) {
break;
}


$id = mysql_result($result, $i, 'imageId');
$tmp =$id;
$caption= mysql_result($result, $i, 'imageCaption');


echo '<div style="float:left;margin:2px 4px 6px 18px;padding:8px;text-align:center;border:1px solid #000010;">
<img style="width:500px;height:500px;border:0;" src="data:image/jpeg;base64,'.base64_encode( mysql_result($result, $i, 'imageData') ).'" title= "Zzz" width="500" height="500" alt=""  alt="Grand Canyon" /> <br/>   <br/> '.$caption.' <br/> </div>';


}

?>



