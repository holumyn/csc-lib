<?php require_once("inc/session.php"); ?>
<?php require_once("inc/connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php include_once("inc/form_function.php"); ?>

<?php find_selected_page(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>MANAGE CONTENT || CSC FUNAAB</title>
	<link rel="stylesheet" href="css/default.css" />
  </head>
  <body id="top">
   <?php include_once('inc/headstyle.php'); ?>
     <div id="wrapper">   
        <div class="header">
          <div class="logo">
            <a href="index.php"><img src="images/logo.jpg" width="200px" height="100px" alt="logo" /></a>
          </div>
           <?php include_once('main_header.php'); ?>
           <div class="search">  
          <form method="post" action="result.php" id="searchbox">
          <input type="search" name="search"  id="search" size="50" placeholder="Search Library"/>
          <input type="submit" name="searchSubmit" id="searchSubmit" value="Search"/>
          </form>
          </div><!-- end search -->
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
       <div class="editSide"><a href="editStaff.php">Edit Current Users</a></div>
       <div class="editSide"><a href="newStaff.php">Add New User</a></div>
       <div class="editSide"><a href="timeout.php">Logout</a></div>
			<?php }
		   ?>
        </div><!-- end category -->
        
        <div class="section">
        <div class="sel_page">
        <?php
		if(isset($_POST['search']) && $_POST['search'] !== '' && $_POST['search'] !== ' '){
			//News Result
			$searchTerm = htmlentities(trim(mysql_prep($_POST['search'])));
        $query = "SELECT * FROM news WHERE headline like '%".$searchTerm."%'";
		$result_set = mysqli_query($connection,$query);
		confirm_query($result_set);
		$no=mysqli_num_rows($result_set);
	if($no == 0){
		 echo ' ';
		}else if($no == 1){
			echo '<h3>&nbsp;News: '. $no.' '.'result found for'.' \'' .$searchTerm.'\''.'</h3>';
			}else{ 
		echo '<h3>&nbsp;News: '.$no.' '.'results found for'.' \'' .$searchTerm.'\''.'</h3>';
		}
		echo '<ul>';
		for($count=0;$result = mysqli_fetch_array($result_set);$count++){
		echo '<li class="list_design"><a href="news_events.php?action=fullNews&id='.urlencode($result['id']).'">'.$result['headline'].'</a></li>';
		}
		echo '</ul>';
		
		//document result
		$searchTerm = htmlentities(trim(mysql_prep($_POST['search'])));
        $query = "SELECT * FROM document WHERE title like '%".$searchTerm."%'";
		$result_set = mysqli_query($connection,$query);
		confirm_query($result_set);
		$no=mysqli_num_rows($result_set);
	if($no == 0){
		 echo ' ';
		}else if($no == 1){
			echo '<h3>&nbsp;Documents: '. $no.' '.'result found for'.' \'' .$searchTerm.'\''.'</h3>';
			}else{ 
		echo '<h3>&nbsp;Documents: '.$no.' '.'results found for'.' \'' .$searchTerm.'\''.'</h3>';
		}
		echo '<ul>';
		for($count=0;$result = mysqli_fetch_array($result_set);$count++){ ?>
		<li class="list_design"><a href="resource.php?action=get_document&resource_id=<?php echo urlencode($result['ISBN']); ?>"><?php echo $result['title'] ?></a></li>
		<?php }
		echo '</ul>';
		
		//audio result
		$searchTerm = htmlentities(trim(mysql_prep($_POST['search'])));
        $query = "SELECT * FROM audio WHERE title like '%".$searchTerm."%'";
		$result_set = mysqli_query($connection,$query);
		confirm_query($result_set);
		$no=mysqli_num_rows($result_set);
	if($no == 0){
		 echo '';
		}else if($no == 1){
			echo '<h3>&nbsp;Audio: '. $no.' '.'result found for'.' \'' .$searchTerm.'\''.'</h3>';
			}else{ 
		echo '<h3>&nbsp;Audio: '.$no.' '.'results found for'.' \'' .$searchTerm.'\''.'</h3>';
		}
		echo '<ul>';
		for($count=0;$result = mysqli_fetch_array($result_set);$count++){ ?>
		<li class="list_design"><a href="resource.php?action=get_audio&resource_id=<?php echo urlencode($result['id']); ?>"><?php echo $result['title'] ?></a></li>
		<?php }
		echo '</ul>';
		
		//video result
		$searchTerm = htmlentities(trim(mysql_prep($_POST['search'])));
        $query = "SELECT * FROM video WHERE title like '%".$searchTerm."%'";
		$result_set = mysqli_query($connection,$query);
		confirm_query($result_set);
		$no=mysqli_num_rows($result_set);
	if($no == 0){
		 echo '';
		}else if($no == 1){
			echo '<h3>&nbsp;Video: '. $no.' '.'result found for'.' \'' .$searchTerm.'\''.'</h3>';
			}else{ 
		echo '<h3>&nbsp;Video: '.$no.' '.'results found for'.' \'' .$searchTerm.'\''.'</h3>';
		}
		echo '<ul>';
		for($count=0;$result = mysqli_fetch_array($result_set);$count++){ ?>
		<li class="list_design"><a href="resource.php?action=get_video&resource_id=<?php echo urlencode($result['id']); ?>"><?php echo $result['title'] ?></a></li>
		<?php }
		echo '</ul>';
		}else{
			echo 'No search performed.';
			}
		
        ?>
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
       
      </div><!--wrapper-->
      
      <div class="footer">
      <div class="footer_hold">
      <div class="external">
        <h2>External Links</h2>
        <ul>
          <li><a href="#">World Library</a></li>
          <li><a href="#">Funaab Library </a></li>
          <li><a href="#">MiiT</a></li>
          <li><a href="#">NASA</a></li>
          <li><a href="#">BBC</a></li>
          <li><a href="#">CNN</a></li>
        </ul>
      </div><!---external--->
        <div class="social">
        <h2>Social Links</h2>
          <a href="https://facebook.com" target="_blank"><img src="images/fb.png" width="20px" height="20px"/ alt="fb"></a>&nbsp;&nbsp;
          <a href="https://linkedin.com" target="_blank"><img src="images/Linked.png" width="20px" height="20px" alt="linkedIn"/></a>&nbsp;&nbsp;
          <a href="https://twitter.com" target="_blank"><img src="images/twitter1.jpg" width="20px" height="20px" alt="twitter"/></a>
          
        </div><!---social-->
        <div class="site">
        <p>
        <a href="contact.php">Contact Us</a><br />
        <a href="about.php">About Us</a><br />
        <a href="policy.php">Privacy Policy</a><br />
        <a href="terms.php">Terms of Use</a><br />
        Copyright &copy; Computer Science, FUNAAB 2014.<br /> All Rights Reserved.
        </p>
        <br /><br /><br /><br /><br />
       
      </div><!---site--->
      <div class="clear"></div>
      </div>
         <div class="clear"></div>
         <span class="top"><a href="#top">Back to top &uArr;</a></span>
      </div><!--footer--->
  </body>
</html>
<?php mysqli_close($connection); ?>