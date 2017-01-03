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
	
	//START FORM PROCESSING
	//only execute the form processing if the form has been submitted 
	if(isset($_POST['submit'])){
		//initialize an array to hold our errors
		$errors = array();
		
		//perform validation on the form
	$required_fields = array('menu_name' , 'position', 'visible', );
	$errors =  array_merge($errors, check_required_fields($required_fields));
	
	$fields_with_lengths = array('menu_name' => 30);
	$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));
	
	
		if (empty($errors)){
			//perform update
		$id = mysql_prep($_GET['subj']);
		$menu_name = mysql_prep($_POST['menu_name']);
		$position = mysql_prep($_POST['position']);
		$visible = mysql_prep($_POST['visible']);
		
		$query = "UPDATE subjects SET
					menu_name = '{$menu_name}',
					position = {$position},
					visible = {$visible} 
				WHERE id = {$id}" ;
		$result = mysqli_query($connection,$query);
		if(mysqli_affected_rows() == 1){
			//success
			$message = "The subject was sucessfully updated.";
			}else{
				//failed
			$message = "The subject update failed";
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
		}//end if(isset($_POST['submit']))
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
          </div><!--logo-->
           <?php if(isset($_SESSION['username'])){ ?>
          <div class="user_details">Welcome to the content manager:<?php echo strtoupper($_SESSION['username']);?><br /><a href="content.php">Content Manager</a></div>
          <?php } ?>
          <div class="clear"></div>
        </div><!---header--->
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
        </div><!---nav-->
        <div class="category">
           <div class="subjects">
           <?php echo navigation($sel_subject,$sel_page); ?>
       <div class="editSide"><a href="new_subject.php">Add a new subject</a></div>
       </div><!---subjects--->
           
         <div class="browse"> 
       <p>Staff Activities</p>
       </div><!--browse-->
        <div class="editSide"><a href="editResource.php">Edit Resources</a></div>
        <div class="editSide"><a href="editEvent.php">Edit Event</a></div>
       <div class="editSide"><a href="content.php?action=editLogo">Edit Logo</a></div>
       <div class="editSide"><a href="editNav.php">Edit Navigation</a></div>
       <div class="editSide"><a href="editStaff.php">Edit Current Users</a></div>
       <div class="editSide"><a href="newStaff.php">Add New User</a></div>
       <div class="editSide"><a href="timeout.php">Logout</a></div>
       </div><!-- end category -->
        
        
        <div class="section">
        <div class="sel_page">
        <h2>Edit subject: <?php echo $sel_subject['menu_name']; ?></h2>
<?php if(!empty($message)) {
	echo "<p class=\"message\">" . $message . "</p>";
	} ?>
    <?php 
	//output a list of the fields that had errors
	if (!empty($errors)){ display_errors($errors); }
	?>
<form action="edit_subject.php?subj=<?php echo  urlencode($sel_subject['id']); ?>" method="post">
    <table border="0">
	<tr><td width="150px" height="33">Subject name:</td>
	<td width="350px"> <input type="text" name="menu_name" maxlength="20" value="<?php echo $sel_subject['menu_name']; ?>" id="menu_name" />*max-20 character</td></tr>
	<tr><td height="33">Position:</td>
    <td>
     <select name="position">
     <?php
     $subject_set= get_all_subjects();
	 $subject_count= mysqli_num_rows($subject_set);
	 //$subject_count+1 because we are adding a subject
	 for($count=1; $count<= $subject_count+1; $count++){
		 echo "<option value=\"{$count}\"";
		 if($sel_subject['position'] == $count){
			 echo " selected";
			 }
		echo ">{$count}</option>";
		 }
	 ?>
	
    </select>
    </td>
	</tr>
	<tr><td height="33">Visible: </td>
    <td>
    <input type="radio" name="visible" value="0" <?php 
	if($sel_subject['visible'] == 0){echo " checked";}
	?> />No &nbsp;
	<input type="radio" name="visible" value="1"
     <?php 
	if($sel_subject['visible'] == 1){echo " checked";}
	?> />Yes
    </td>
	</tr>
    <tr><td height="33"></td>
    <td>
	<input type="submit" name="submit" value="Edit Subject" />
    </td>
    </tr>
   <tr>
   <td></td>
    <td><a href="delete_subject.php?subj=<?php 
	echo urlencode($sel_subject['id']); 
	?>"onclick = "return confirm('Are you sure you want to delete this subject?')">Delete Subject</a>&nbsp;&nbsp;
    <a href="content.php">Cancel</a></td>
    </tr>
    </table>
</form>

<div class="pages_list">
<h3>Pages in this subject:</h3>
<ul >
<?php 
$subject_pages = get_pages_for_subject($sel_subject['id']);
while($page = mysqli_fetch_array($subject_pages)){
	echo "<li><a href=\"edit_page.php?page={$page['id']}\">{$page['menu_name']}</a></li>";
	}
?>
</ul><br />
</div><!--pages_list-->
<div class="editSide"><a href="new_page.php?subj=<?php echo $sel_subject['id']; ?>">Add a new page to this subject</a></div>
  </div><!--sel_page-->
        </div><!---section-->
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
          <div class="editSide"><a href="news.php">Click To Add News</a></div>
       
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
      </div><!--footer-->
  </body>
</html>
<?php mysqli_close($connection); ?>