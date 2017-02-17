<!-- form for editing captions. update query to Table. -->
<?php
ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }
 // select loggedin users detail
 $res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
 $userRow=mysql_fetch_array($res);
 $email = $userRow['userEmail'];
 // echo $email;

// Update Table entry for caption
if($_POST['imageCaption']!=null){
	$sql = "UPDATE user_images SET imageCaption= '{$_POST['imageCaption']}' WHERE imageId =".$_POST['id'];


$current_id = mysql_query($sql) or die("<b>Error:</b> Problem on Image Insert<br/>" . mysql_error());
if(isset($current_id)) {
header("Location: editImages.php");

}
}










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
<BODY>
<form name="frmImage" enctype="multipart/form-data" action="" method="post" class="frmImageUpload">
<!-- label>Upload Image File:</label><br/>
<input name="userImage" type="file" class="inputFile" /><br/> -->
<input type="hidden" name='id' value=<?php if (isset($_GET['id'])){ echo $_GET['id'];}elseif (isset($_POST['id'])){ echo $_POST['id'];} ?> />
<label>Image Caption:</label><br/>
<input name="imageCaption" type ="text"  />
<input type="submit" value="Dump It!" class="btnSubmit" />
</form>
</BODY>

<ul class="nav navbar-nav navbar-right">
            
            
              
                <li><a href="listImages.php?listImages"><span class="glyphicon glyphicon-list-images"></span>&nbsp;View All Images</a></li>
                <li><a href="editImages.php?editImages"><span class="glyphicon glyphicon-list-images"></span>&nbsp;Edit your Images</a></li>
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>

              </ul>
            
          </ul>
</HTML>