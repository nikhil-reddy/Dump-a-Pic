<?php
ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // if session is not set this will redirect to login page, prevent Directory Traversal Attack
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }
 // select loggedin users detail
 $res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
 $userRow=mysql_fetch_array($res);
 $email = $userRow['userEmail'];
 // echo $email;





if(count($_FILES) > 0) {
if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
mysql_connect("localhost", "root", "");
mysql_select_db ("dbtest");
$email = $userRow['userEmail'];

// echo $email;

//collect image and convert it into file for temp storage and collect properties
$imgData =addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
$imageProperties = getimageSize($_FILES['userImage']['tmp_name']);
$imageType = $imageProperties['mime'];


$dangerMime = array('image/gif','image/jpg','image/jpeg', 'image/png'); //allowed formats according to requirements.
if (in_array($imageType, $dangerMime)) 
{
  //allow upload since valid format

  //insert table entry for pictures.
  $sql = "INSERT INTO user_images(imageType ,imageData, userEmail,imageCaption)
  VALUES('{$imageProperties['mime']}', '{$imgData}','{$email}', '{$_POST['imageCaption']}')";
  
  $current_id = mysql_query($sql) or die("<b>Error:</b> Problem on Image Insert<br/>" . mysql_error());
  if(isset($current_id))
  {
    // in case of a success upload, directed to the view images page.
    header("Location: listImages.php");
  }
}

else
{
  //block upload since format is not allowed.
  $errmessage = "Please upload a valid file.";
  // header("Location: home.php");
}
}
}

else{
  $errmessage = "Please upload a file.";
  // header("Location: home.php");
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

    <!-- form for uploading image and caption --> 
<form name="frmImage" enctype="multipart/form-data" action="" method="post" class="frmImageUpload">
<label>Upload Image File:</label><br/>
<input name="userImage" type="file" class="inputFile" accept="image/gif, image/jpeg, image/png" /><br/> <!-- form accepts only these formats hence in the browse window shows only files of supported formats -->
<br/>
<label>Image Caption:</label><br/>
<input name="imageCaption" type ="text"  />
<input type="submit" value="Dump It!" class="btnSubmit" />
</form>
</div>

</BODY>

<ul class="nav navbar-nav navbar-right">
            
            
              
                <li><a href="listImages.php?listImages"><span class="glyphicon glyphicon-list-images"></span>&nbsp;View All Images</a></li>
                <li><a href="editImages.php?editImages"><span class="glyphicon glyphicon-list-images"></span>&nbsp;Edit your Images</a></li>
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>

              </ul>
            
          </ul>
</HTML>