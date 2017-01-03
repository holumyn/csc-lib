<?php require_once("inc/session.php"); ?>
<?php require_once("inc/connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php include_once("inc/form_function.php"); ?>
<?php 
	confirm_staff_logged_in("staffLogin.php");
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
       
       
       
     <div id="wrapper">   
        <div class="header">
          <div class="logo">
            <img src="images/logo.jpg" width="200px" height="100px" alt="logo" />
          </div>
          <p>Welcome to the content manager:<?php echo $_SESSION['username'];?>, time, date.</p>
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
       <h2>Add subject</h2>
<form action="create_subject.php" method="post">
<table border="0" width="100%">
	<tr><td width="20%" height="50px">Subject name:</td>
    <td><input type="text" name="menu_name" value="" id="menu_name" /></td>
     </tr>
	<tr><td height="50px">Position:</td>
    <td>
     <select name="position">
     <?php
     $subject_set= get_all_subjects();
	 $subject_count= mysqli_num_rows($subject_set);
	 //$subject_count+1 because we are adding a subject
	 for($count=1; $count<= $subject_count+1; $count++){
		 echo "<option value=\"{$count}\">{$count}</option>";
		 }
	 ?>
	
    </select>
    </td>
	</tr>
	<tr><td height="50px">Visible:</td> 
    <td><input type="radio" name="visible" value="0" />No &nbsp;
	<input type="radio" name="visible" value="1" />Yes</td>
	</tr>
    <tr>
	<td height="50px"></td><td><input type="submit" value="Add Subject" />&nbsp;&nbsp;&nbsp;<a href="content.php">Cancel</a></td>
    </tr>
    </table>
</form>

</div><!--sel_page-->
        </div><!--section--->
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
        
        
        </div><!---aside-->
        <div class="clear"></div>
      </div><!-- wrapper -->
       <div class="footer">
        <p>Copyright &copy; Computer Science, FUNAAB 2014. All Rights Reserved.</p>
        <hr />
        <a href="#top">Back to top &uArr;</a>
        <div class="clear"></div>
      </div><!--footer-->
  </body>
</html>
<?php mysqli_close($connection); ?>