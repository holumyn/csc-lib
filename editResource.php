<?php require_once("inc/session.php"); ?>
<?php require_once("inc/connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php include_once("inc/form_function.php"); ?>
<?php 
	confirm_staff_logged_in("index.php");
?>
<?php 

?>
 <?php if(isset($_POST['uploadDoc'])){
	         $file = $_FILES['document']['tmp_name'];
			$file_name = $_FILES['document']['name'];
			$file_size = $_FILES['document']['size'];
			$file_type = $_FILES['document']['type'];
			$file_error = $_FILES['document']['error'];
			
	        $allowedExts = array("jpg","docx","doc","pdf","ppt","pptx","xls");
			$temp = explode(".",$file_name);
			$extension = end($temp);
			$name = $temp[0];
			
			if( (($file_type == 'application/doc') || 
			($file_type == 'application/docx') || 
			($file_type == 'application/pdf') || 
			($file_type == 'application/ppt') || 
			($file_type == 'application/pptx') || 
			($file_type == 'application/xls')) &&  
			in_array($extension,$allowedExts) && $file_size < 100000000000 ){
				if($file_error > 0){
				echo 'Return Code: ' . $file_error.'<br />';
				} elseif(file_exists('resources/documents/'.$file_name)){
				$new_file_name = $name . rand(1,99999).'.'.end(explode('.',$file_name));
				move_uploaded_file($file,'resources/documents/'.$new_file_name);
				$doc_file_name = $new_file_name;
				} else{
				move_uploaded_file($file,'resources/documents/'.$file_name);
				$doc_file_name = $file_name;
				    }
				  }else{
				$message1 = 'Invalid File!';
	               }			
				}
?>
 <?php if(isset($_POST['uploadAudio'])){
	         $file = $_FILES['audio']['tmp_name'];
			$file_name = $_FILES['audio']['name'];
			$file_size = $_FILES['audio']['size'];
			$file_type = $_FILES['audio']['type'];
			$file_error = $_FILES['audio']['error'];
			
	        $allowedExts = array("mp3","wma");
			$temp = explode(".",$file_name);
			$extension = end($temp);
			$name = $temp[0];
			
			if( (($file_type == 'audio/mp3') || 
			($file_type == 'audio/wma')) &&  
			in_array($extension,$allowedExts)){
				if($file_error > 0){
				echo 'Return Code: ' . $file_error.'<br />';
				} elseif(file_exists('resources/audios/'.$file_name)){
				$new_file_name = $name . rand(1,9999).'.'.end(explode('.',$file_name));
				move_uploaded_file($file,'resources/audios/'.$new_file_name);
				$audio_file_name = $new_file_name;
				} else{
				move_uploaded_file($file,'resources/audios/'.$file_name);
				    $audio_file_name = $file_name;
					}
				  }else{
				$message = 'Invalid File!';
                 	}			
				}
?>
<?php if(isset($_POST['uploadVideo'])){
	         $file = $_FILES['video']['tmp_name'];
			$file_name = $_FILES['video']['name'];
			$file_size = $_FILES['video']['size'];
			$file_type = $_FILES['video']['type'];
			$file_error = $_FILES['video']['error'];
			
	        $allowedExts = array("mp4","3pg","mov");
			$temp = explode(".",$file_name);
			$extension = end($temp);
			$name = $temp[0];
			
			if( (($file_type == 'video/mp4') || 
			($file_type == 'video/3pg') || ($file_type == 'video/3pg')) &&  
			in_array($extension,$allowedExts)){
				if($file_error > 0){
				echo 'Return Code: ' . $file_error.'<br />';
				} elseif(file_exists('resources/videos/'.$file_name)){
				$new_file_name = $name . rand(1,9999).'.'.end(explode('.',$file_name));
				move_uploaded_file($file,'resources/videos/'.$new_file_name);
				$video_file_name = $new_file_name;
				} else{
				move_uploaded_file($file,'resources/videos/'.$file_name);
				    $video_file_name = $file_name;
					}
				  }else{
				$message3 = 'Invalid File!';
                 	}			
				}
?>
 


   <?php 
if(isset($_POST['submitDocument'])){
	//Form has been submitted
		//initialize an array to hold our errors
		$errors = array();
		
		//perform validation on the form
	$required_fields = array('title', 'author', 'category', 'docName', 'description' );
	$errors =  array_merge($errors, check_required_fields($required_fields));
	
	$username = $_SESSION['username'];	
	$ISBN = htmlentities(trim(mysql_prep($_POST['ISBN'])));
	$title = htmlentities(trim(mysql_prep($_POST['title'])));
	$author = htmlentities(trim(mysql_prep($_POST['author'])));
	$category = htmlentities(trim(mysql_prep($_POST['category'])));
	$docName = htmlentities(trim(mysql_prep($_POST['docName'])));
	$description = htmlentities(trim(mysql_prep($_POST['description'])));
		
	//Database submission only proceeds if there were NO errors
		if (empty($errors)){
		global $connection;	
		$query="INSERT INTO document SET username = '{$username}', ISBN = '{$ISBN}', title = '{$title}', author = '{$author}', category = '{$category}', docName = '{$docName}', description = '{$description}'";
		$result = mysqli_query($connection,$query);
        confirm_query($result);
		//test to see if the update occured
		if($result){
	$message1 = 'Document succesfully added.';
		}else{
				//failed
			$message1 = "The Document Update failed";
			$message1 .= "<br />" . mysqli_error();
				}
		}else{
			//Errors occured
			if(count($errors) == 1){
				$message1 = "There was 1 error in the form.";
			}else{
		$message1 = "There were " . count($errors). " errors in the form";
				}
			}
	}
?>
   <?php 
if(isset($_POST['submitAudio'])){
	//Form has been submitted
		//initialize an array to hold our errors
		$errors = array();
		
		//perform validation on the form
	$required_fields = array('title', 'author', 'category', 'fileName', 'description' );
	$errors =  array_merge($errors, check_required_fields($required_fields));
	
	$username = $_SESSION['username'];	
	$title = htmlentities(trim(mysql_prep($_POST['title'])));
	$author = htmlentities(trim(mysql_prep($_POST['author'])));
	$category = htmlentities(trim(mysql_prep($_POST['category'])));
	$fileName = htmlentities(trim(mysql_prep($_POST['fileName'])));
	$description = htmlentities(trim(mysql_prep($_POST['description'])));
		
	//Database submission only proceeds if there were NO errors
		if (empty($errors)){
		global $connection;
		$query="INSERT INTO audio SET username = '{$username}', title = '{$title}', author = '{$author}', category = '{$category}', audioName = '{$fileName}', description = '{$description}'";
		$result = mysqli_query($connection,$query);
        confirm_query($result);
		//test to see if the update occured
		if($result){
	$message2 = 'Document succesfully added.';
		}else{
				//failed
			$message2 = "The Document Update failed";
			$message2 .= "<br />" . mysqli_error();
				}
		
		}else{
			//Errors occured
			if(count($errors) == 1){
				$message2 = "There was 1 error in the form.";
			}else{
		$message2 = "There were " . count($errors). " errors in the form";
				}
			
			}
	}
?>
<?php 
if(isset($_POST['submitVideo'])){
	//Form has been submitted
		//initialize an array to hold our errors
		$errors = array();
		
		//perform validation on the form
	$required_fields = array('title', 'author', 'category', 'fileName', 'description' );
	$errors =  array_merge($errors, check_required_fields($required_fields));
	
	$username = $_SESSION['username'];	
	$title = htmlentities(trim(mysql_prep($_POST['title'])));
	$author = htmlentities(trim(mysql_prep($_POST['author'])));
	$category = htmlentities(trim(mysql_prep($_POST['category'])));
	$fileName = htmlentities(trim(mysql_prep($_POST['fileName'])));
	$description = htmlentities(trim(mysql_prep($_POST['description'])));
		
	//Database submission only proceeds if there were NO errors
		if (empty($errors)){
		global $connection;
		$query="INSERT INTO video SET username = '{$username}', title = '{$title}', author = '{$author}', category = '{$category}', videoName = '{$fileName}', description = '{$description}'";
		$result = mysqli_query($connection,$query);
        confirm_query($result);
		//test to see if the update occured
		if($result){
	$message3 = 'Document succesfully added.';
		}else{
				//failed
			$message3 = "The Document Update failed";
			$message3 .= "<br />" . mysqli_error();
				}
		
		}else{
			//Errors occured
			if(count($errors) == 1){
				$message3 = "There was 1 error in the form.";
			}else{
		$message3 = "There were " . count($errors). " errors in the form";
				}
			
			}
	}
?>
<?php find_selected_page(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>MANAGE CONTENT || CSC FUNAAB</title>
	<link rel="stylesheet" href="css/default.css" />
    <script src="js/jquery.js"></script>
    <script src="js/functions.js"></script>
  </head>
  <body id="top">
   <?php include_once('inc/headstyle.php'); ?>
       
       
     <div id="wrapper">   
        <div class="header">
          <div class="logo">
            <img src="images/logo.jpg" width="200px" height="100px" alt="logo" />
          </div>
           <?php if(isset($_SESSION['username'])){ ?>
         <div class="user_details">Welcome to the content manager:<?php echo strtoupper($_SESSION['username']);?><br /><a href="content.php">Content Manager</a></div>
          <?php } ?>
          <div class="clear"></div>
        </div><!--header--->
        <div id="main">
        <div class="nav">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="news_events.php">News & Events</a></li>
          <li><a href="explore.php">Explore</a></li>
          <li><a href="services.php">Services</a></li>
          <li><a href="project.php">Projects</a></li>
          <li><a href="developer.php">Contributors & Developers</a></li>
        </ul>
        </div><!--nav-->
       
        <div class="category">
           <div class="subjects">
           <?php echo public_navigation($sel_subject,$sel_page); ?>
            <?php if(isset($_SESSION['username'])){ ?>
           <div class="editSide"><a href="new_subject.php">Add a new subject</a></div>
           <?php } ?>
       </div>
       <?php if(isset($_SESSION['username'])){ ?>
	        <div class="browse"> 
       <p>Staff Activities</p>
       </div>
        <div class="editSide"><a href="editResource.php">Edit Resources</a></div>
        <div class="editSide"><a href="editEvent.php">Edit Event</a></div>
       <div class="editSide"><a href="content.php?action=editLogo">Edit Logo</a></div>
       <div class="editSide"><a href="editNav.php">Edit Navigation</a></div>
       <?php
	   if($_SESSION['username'] == 'admin'){ ?>
       <div class="editSide"><a href="editStaff.php">Edit Current Users</a></div>
       <div class="editSide"><a href="newStaff.php">Add New User</a></div>
	  <?php } else{?>
      <div class="editSide"><a href="changePass.php?user=<?php echo $_SESSION['username']; ?>">Change Password</a></div>
      <?php } ?>
       <div class="editSide"><a href="timeout.php">Logout</a></div>
			<?php }
		   ?>
        </div><!-- end category -->
         <div class="section">
           <div class="sel_page">
        <h4><i>*Please upload document, audio or video before submitting the entire form.</i></h4><br />
        
        <h3>Add Documents to Library&nbsp;[Pdf, Word, Power Point, MS Excel only]</h3><br />
        <?php if(!empty($message1)){echo '<p class="notice"><i>'.$message1.'</i></p>'; } ?>
         <form method="post" action="editResource.php" enctype="multipart/form-data">
       <table border="0" width="70%">
         <tr>
        <td></td><td></td>
        </tr>
        <tr>
        <td><label>Book Title:</label></td><td><input type="text" name="title" id="title"  /></td>
        </tr>
        <tr>
        <td><label>Book Author(s):</label></td><td><input type="text" name="author" id="author" /></td>
        </tr>
        <tr>
        <td><label>Category:</label></td>
       <td> <?php
        $query = "SELECT menu_name FROM pages";
		$result_set = mysqli_query($connection,$query);
		confirm_query($result_set);
		?>
        <select name="category" id="category">
		<?php
		for($count=0;$result=mysqli_fetch_array($result_set);$count++){ ?>
			 
          <option><?php echo $result['menu_name']; ?></option>
       
			
			<?php
			}
		?>
         </select></td>
        </tr>
        <tr>
          <td colspan="2"><?php if(isset($doc_file_name)){ $username=$_SESSION['username']; echo '<p class="notice"><i>File Ready: </i>'. $doc_file_name .'</p>';}?></td>
        </tr>
        <tr>
        <td><label>Document:</label></td>
        <td><input type="hidden" name="docName" id="docName" value="<?php if(isset($doc_file_name)){echo $doc_file_name;}?>" />
            <input type="file" name="document" id="document" /><input type="submit" name="uploadDoc" value="Upload Doc"></td>
        </tr>
        <tr>
        <td><label>Description:</label></td>
       <td> <textarea cols="20" rows="10" name="description" id="description"></textarea></td>
       </tr> 
       <tr>
       <td></td><td> <input type="submit" name="submitDocument" id="submit" value="Add Document" /></td>
        </tr>
        </table>
        </form>
        
        <br />
       
        <h3 id="audio">Add Audios to Library&nbsp;[mp3] </h3><br />
         <?php if(!empty($message2)){echo '<p class="notice"><i>'.$message2.'</i></p>'; } ?>
         <form method="post" action="editResource.php#audio" enctype="multipart/form-data">
         <table border="0" width="70%">
         <tr>
       <td> <label>Audio Title:</label></td>
       <td> <input type="text" name="title" id="title" /></td>
        </tr>
        <tr>
       <td> <label>Author(s):</label></td>
        <td><input type="text" name="author" id="author" /></td>
        </tr>
        <tr>
        <td><label>Category:</label></td>
        <td>
        <?php
        $query = "SELECT menu_name FROM pages";
		$result_set = mysqli_query($connection,$query);
		confirm_query($result_set);
		?>
        <select name="category" id="category">
		<?php
		for($count=0;$result=mysqli_fetch_array($result_set);$count++){ ?>
			 
          <option><?php echo $result['menu_name']; ?></option>
       
			
			<?php
			}
		?>
         </select>
       </td>
        </tr>
        <tr>
       <td> <label>Upload Audio</label></td>
        <td>
            <?php if(isset($audio_file_name)){echo '<p class="notice"><i>File Ready: </i>'.$audio_file_name.'</p>';}?><input type="hidden" name="fileName" id="audioName" value="<?php if(isset($audio_file_name)){echo $audio_file_name;}?>" />
            <input type="file" name="audio" id="audio"/><input type="submit" name="uploadAudio" value="Upload Audio"/></td>
        </tr>
        <tr>
        <td><label>Description:</label></td>
        <td><textarea cols="20" rows="10" name="description" id="description"></textarea></td>
        </tr>
        <tr>
        <td></td><td><input type="submit" name="submitAudio" id="submit" value="Add Audio" /></td>
        </tr>
        </table>
        </form>
        <br />
        
        <h3 id="video">Add Videos to Library&nbsp;[mp4, 3pg, mov, wma]</h3>
        
         <?php if(!empty($message3)){echo '<p class="notice"><i>'.$message3.'</i></p>'; } ?>
         <form method="post" action="editResource.php#video" enctype="multipart/form-data">
       <table border="0" width="70%">
       <tr>
        <td><label>Video Title:</label></td>
        <td><input type="text" name="title" id="title" /></td>
        </tr>
        <tr>
        <td><label>Author(s):</label></td>
       <td> <input type="text" name="author" id="author" /></td>
        </tr>
        <tr>
        <td><label>Category:</label></td>
        <td><?php
        $query = "SELECT menu_name FROM pages";
		$result_set = mysqli_query($connection,$query);
		confirm_query($result_set);
		?>
        <select name="category" id="category">
		<?php
		for($count=0;$result=mysqli_fetch_array($result_set);$count++){ ?>
			 
          <option><?php echo $result['menu_name']; ?></option>
       
			
			<?php
			}
		?>
         </select></td>
        </tr>
        <tr>
       <td> <label>Upload Video</label></td>
       <td>
       <?php if(isset($video_file_name)){echo '<p class="notice"><i>File Ready: </i>'.$video_file_name.'</p>';}?><input type="hidden" name="fileName" id="fileName" value="<?php if(isset($video_file_name)){echo $video_file_name;}?>" />
        <input type="file" name="video" id="video" /><input type="submit" name="uploadVideo"  value="Upload Video"/></td>
        </tr>
        <tr>
       <td> <label>Description:</label></td>
       <td> <textarea cols="20" rows="10" name="description" id="description"></textarea></td>
        </tr>
        <tr>
       <td></td><td> <input type="submit" name="submitVideo" id="submit" value="Add Video" /></td>
        </tr>
        </table>
        </form>
        </div><!--sel_page-->
        </div><!--section-->
        </div><!-- end main -->
        <div class="aside">
        <div class="latestUpdate">
          <h4>Latest News</h4>
          <?php 
		  $query = "SELECT * FROM news ORDER BY id DESC";
		  $result_set = mysqli_query($connection,$query);
		  confirm_query($result_set);
		  for($count=0;$result=mysqli_fetch_array($result_set);$count++){
			  
		  ?>
          
          <div class="update"><img src="images/news_events/<?php echo $result['imgName'] ?>" width="50" height="50" alt="<?php echo $result['imgName'] ?>"> 
          <a href="news_events.php?action=fullNews&id=<?php echo urlencode($result['id']); ?>"><?php echo $result['headline']; ?></a><br />
		  <?php 
		  $newslenght = str_word_count($result['news']);
		  if($newslenght < 40){
			  echo $result['news'];
			  }else{
				  echo substr($result['news'],0,200).'<a href="news_events.php?action=fullNews&id='.urlencode($result['id']).'"><i>...read more</i></a><br />';
				  }
			  
			  
		  ?>
          
          <div class="updater">
          Updated By:<br /><a href="#"><?php echo $result['username']; ?></a></div>
          
          <div class="clear"></div>
          </div>
          
          <?php 
		  if($count == 4){
		       break;
		       }
		  } 
		   ?>
          <div class="editSide"><a href="news_events.php">view all</a></div> 
          
        </div>
        
        <div class="latestUpdate">
          <h4>Sponsored</h4>
          <div class="update"> <a href="#">Java Progamming || 10th Edition by Deitel</a><br />
          <img src="images/oijio.jpg" width="50" height="50" ><p class="updater">Updated By:<br /><a href="#"> Dr. Onashoga S.A</a></p>
          
          <div class="clear"></div>
          </div>
          
        </div>
        
        
        </div><!--aside-->
        <div class="clear"></div>
       
      </div><!-- wrapper -->
      
      <div class="footer"><hr />
        <p>Copyright &copy; Computer Science, FUNAAB 2014. All Rights Reserved.</p>
        <hr />
        <a href="#top">Back to top &uArr;</a>
        <div class="clear"></div>
      </div>
  </body>
</html>
<?php mysqli_close($connection); ?>