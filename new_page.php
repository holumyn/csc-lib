<?php require_once("inc/session.php"); ?>
<?php require_once("inc/connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php include_once("inc/form_function.php"); ?>
<?php 
	confirm_staff_logged_in("staffLogin.php");
?>
<?php
//make sure the subject id sent is an integer
	if(intval($_GET['subj'])==0){
		redirect_to("content.php");
		}
		
	include_once("inc/form_function.php");
	
	//START FROM PROCESSING
	//only execute the form processing if the form has been submitted 
	if(isset($_POST['submit'])){
		//initialize an array to hold our errors
		$errors = array();
		
		//perform validation on the form
	$required_fields = array('menu_name', 'position', 'visible', 'content' );
	$errors =  array_merge($errors, check_required_fields($required_fields));
	
	$fields_with_lengths = array('menu_name' => 30);
	$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));
	
	//Clean up the form data before putting it in the database
		$id = mysql_prep($_GET['subj']);
		$menu_name =trim( mysql_prep($_POST['menu_name']));
		$position = mysql_prep($_POST['position']);
		$visible = mysql_prep($_POST['visible']);
		$content = mysql_prep($_POST['content']);
		
		
		//Database submission only proceeds if there were NO errors
		if(empty($errors)){
		$query = "INSERT INTO pages (
					subject_id, menu_name, position, visible, content 
					) VALUES (
					{$id}, '{$menu_name}', {$position}, {$visible}, '{$content}' 
					)";
		$result = mysqli_query($connection,$query);
		//test to see if the update occured
		if(mysqli_affected_rows() == 1){
			//success
			$message = "The page was sucessfully updated.";
			}else{
				//failed
			$message = "The page update failed";
			$message .= "<br />" . mysqli_error();
				}
		}else{
			//Errors occured
			if(count($errors) == 1)
			{
				$message = "There was 1 error in the form.";
			}else{
		$message = "There were" . count($errors). "errors in the form";
			}
	     }//END FORM PROCESSING
	}
	?>
<?php find_selected_page(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>MANAGE CONTENT || CSC FUNAAB</title>
	<link rel="stylesheet" href="css/default.css" />
  </head>
  <body id="top">
    <div class="headStyle">
       <div class="navi">
         <ul>
           <li><a href="#">Help?</a></li>
           <li><a href="#" >main site</a></li>
         </ul>
       </div><!-- navi -->
       </div><!-- headStyle -->
       <div class="headfill"></div>
       
       
     <div id="wrapper">   
        <div class="header">
          <div class="logo">
            <img src="images/logo.jpg" width="200px" height="100px" alt="logo" />
          </div>
          <p>Welcome to the content manager:<?php echo $_SESSION['username'];?>, time, date.</p>
          <div class="clear"></div>
        </div><!---header-->
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
        <h2>Add a New Page</h2>
<?php if(!empty($message)) {echo "<p class=\"message\">" . $message . 
"</p>";} ?>
    <?php 
	//output a list of the fields that had errors
	if (!empty($errors)){ display_errors($errors); }
	?>
<form action="new_page.php?subj=<?php echo  urlencode($sel_subject['id']); ?>" method="post" id="form">
    <?php $new_page = true; ?>
	<?php include "page_form.php" ?>
</form>
<br />
<a href="edit_subject.php?subj=<?php echo $sel_subject['id']; ?>">Cancel</a>
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
      
      <footer><hr />
        <p>Copyright &copy; Computer Science, FUNAAB 2014. All Rights Reserved.</p>
        <hr />
        <a href="#top">Back to top &uArr;</a>
        <div class="clear"></div>
      </footer>
  </body>
</html>
<?php mysqli_close($connection); ?>