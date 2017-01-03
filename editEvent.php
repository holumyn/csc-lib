<?php require_once("inc/session.php"); ?>
<?php require_once("inc/connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php include_once("inc/form_function.php"); ?>
<?php 
	confirm_staff_logged_in("index.php");
?>
<?php 
//change slide show pictures
if(isset($_POST['imgUpload'])){
	//Form has been submitted
	$file = $_FILES['imgEvent']['tmp_name'];
			$file_name = $_FILES['imgEvent']['name'];
			$file_size = $_FILES['imgEvent']['size'];
			$file_type = $_FILES['imgEvent']['type'];
			$file_error = $_FILES['imgEvent']['error'];
			
	        $allowedExts = array("gif","jpeg","jpg","png");
			$temp = explode(".",$file_name);
			$extension = end($temp);
			$name = $temp[0];
			
			if( ($file_type == 'image/jpg') || ($file_type == 'image/png') || 
			($file_type == 'image/jpeg')  || 
			($file_type == 'image/pjpeg') && in_array($extension,$allowedExts)){
				if($file_error > 0){
				echo 'Return Code: ' . $file_error.'<br />';
				} elseif(file_exists('images/news_events/'.$file_name)){
				$new_file_name = $name . rand(1,9999).'.'.end(explode('.',$file_name));
				move_uploaded_file($file,'images/news_events/'. $new_file_name);
				$doc_name = $new_file_name;
				} else{
					move_uploaded_file($file,'images/news_events/'. $file_name);
				    $doc_name = $file_name;
					}
				  }else{
				echo 'Invalid File!';
	
				}
         }
				?>
	<?php 
	//Update welcome page title and body
if(isset($_POST['submitEvent'])){
	//Form has been submitted
		//initialize an array to hold our errors
		$errors = array();
		
		//perform validation on the form
	$required_fields = array('title', 'description', 'fileUpload' );
	$errors =  array_merge($errors, check_required_fields($required_fields));
	
	$username = $_SESSION['username'];	
	$title=htmlentities(trim(mysql_prep($_POST['title'])));
	$description=htmlentities(trim(mysql_prep($_POST['description'])));
	$eventImg=htmlentities(trim(mysql_prep($_POST['fileUpload'])));
		
	//Database submission only proceeds if there were NO errors
		if (empty($errors)){
		global $connection;	
		$query="INSERT INTO events SET username = '{$username}', title = '{$title}', eventImg = '{$eventImg}', description = '{$description}' ";
		$result = mysqli_query($connection,$query);
        confirm_query($result);
		//test to see if the update occured
		if($result){
	
	redirect_to("content.php");
	exit;
		
			}else{
				//failed
			$message = "The Event Update failed";
			$message .= "<br />" . mysqli_error();
				}
		}else{
			//Errors occured
			if(count($errors) == 1){
				$message = "There was 1 error in the form.";
			}else{
		$message = "There were " . count($errors). " errors in the form";
				}
			}
	}
?>
<?php find_selected_page(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>CONTENT MANAGER || CSC FUNAAB</title>
	<link rel="shortcut icon" href="images/logo.jpg" type="image">
	<link rel="stylesheet" href="css/default.css" />
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
        </div><!--header-->
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
       </div>
        </div><!-- end category -->
        <div class="section">
        <div class="sel_page">
        <h3>Add an Upcomming Event</h3>
		<p class="notice"><i>Note: Upload image before filling Event details.</i></p>
        <form action="editEvent.php" method="post" enctype="multipart/form-data" >
          <table border="0" width="95%">
          <tr>
          <td><label>Event Title:</label></td>
          <td><input type="text" name="title" id="title" /></td>
          </tr>
          <tr>
         <td> <label>Event Image:</label></td><?php if(!empty($doc_name)){ 
		echo '<img src="images/news_events/'.$doc_name.'" width="100px" height="100px" />';
		} ?>
			
        <input type="hidden" name="fileUpload" value="<?php if(isset($doc_name)){  echo $doc_name; }?>"/>
          <td><input type="file" name="imgEvent" id="imgEvent" />
          <input type="submit" name="imgUpload" id="imgUpload" value="Upload Image" /></td>
          </tr>
          <tr>
          <td colspan="2"><label>Event Description:</label></td>
		  </tr>
		  <tr>
           <td colspan="2"> <textarea cols="60" rows="15" name="description" id="description"></textarea></td>
          </tr>
          <tr>
          <td></td><td><input type="submit" name="submitEvent" id="submit" value="Submit Event"/></td>
          </tr>
          </table>
          </form>
          </div><!--sel_page-->
        </div><!--section-->
        </div><!-- end main -->
        
       <div class="aside">
        <div class="latestUpdate">
          <h4>Upcoming Events</h4>
          <?php 
		  $query = "SELECT * FROM events ORDER BY id DESC";
		  $result_set = mysqli_query($connection,$query);
		  confirm_query($result_set);
		  for($count=0;$result=mysqli_fetch_array($result_set);$count++){
			?>
          <div class="update"><img src="images/news_events/<?php echo $result['eventImg'] ?>" width="50" height="50" alt="<?php echo $result['eventImg'] ?>"> 
          <a href="news_events.php?action=fullEvent&id=<?php echo urlencode($result['id']); ?>"><?php echo $result['title']; ?></a><br />
		  <?php 
		  $newslenght = str_word_count($result['description']);
		  if($newslenght < 40){
			  echo $result['description'];
			  }else{
				  echo substr($result['description'],0,200).'<a href="news_events.php?action=fullEvent&id='.urlencode($result['id']).'"><i>...read more</i></a><br />';
				  }
			?>
          <div class="clear"></div>
          </div>
          <?php
		  } 
		   ?>
          </div>
        </div><!--aside-->
        <div class="clear"></div>
       
      </div><!--wrapper-->
      
      <?php include_once('inc/footer.php'); ?>