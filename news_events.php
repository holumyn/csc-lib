<?php require_once("inc/session.php"); ?>
<?php require_once("inc/connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php include_once("inc/form_function.php"); ?>

<?php include_once('inc/developer.php'); ?>
<?php find_selected_page(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>NEWS AND EVENTS|| CSC FUNAAB</title>
	<link rel="shortcut icon" href="images/logo.jpg" type="image">
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
          <input type="search" name="search"  id="search" size="42" placeholder="Search Library"/>
          <input type="submit" name="searchSubmit" id="searchSubmit" value="Search"/>
          </form>
          </div><!-- end search -->
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
       <div class="editSide"><a href="content.php?action=editLogo">Edit Logo</a></div>
       <div class="editSide"><a href="editNav.php">Edit Navigation</a></div>
       <?php
	   if(isset($_SESSION['username']) && $_SESSION['username'] == 'admin'){ ?>
       <div class="editSide"><a href="editStaff.php">Edit Current Users</a></div>
       <div class="editSide"><a href="newStaff.php">Add New User</a></div>
	  <?php } else if(isset($_SESSION['username'])){?>
      <div class="editSide"><a href="changePass.php?user=<?php echo $_SESSION['username']; ?>">Change Password</a></div>
      <?php } ?>
       <div class="editSide"><a href="timeout.php">Logout</a></div>
       <?php } ?>
        </div><!-- end category -->
        <div class="section">
        <?php
if(isset($_GET['action']) && $_GET['action'] == 'fullNews'){
	$id = $_GET['id'];
	$query = "SELECT * FROM news WHERE id = {$id}";
	$result_set = mysqli_query($connection,$query);
	confirm_query($result_set);
	$result = mysqli_fetch_array($result_set);
	?>
    <div class="sel_page">
    <div class="update"><img src="images/news_events/<?php echo $result['imgName'] ?>" width="150" height="150" ><h2><?php echo $result['headline']; ?></h2><br />
          <?php 
		    echo $result['news'];
			?>
          <div class="updater">
          Updated By:<br /><a href="#"><?php echo $result['username']; ?></a>
          </div>
          
          <div class="clear"></div>
          </div>
          </div><!--sel_page-->
    <?php
	
	}else
	
if(isset($_GET['action']) && $_GET['action'] == 'fullEvent'){
	$id = $_GET['id'];
	$query = "SELECT * FROM events WHERE id = {$id}";
	$result_set = mysqli_query($connection,$query);
	confirm_query($result_set);
	$result = mysqli_fetch_array($result_set);
	?>
    <div class="sel_page">
    <div class="update"><img src="images/news_events/<?php echo $result['eventImg'] ?>" width="150" height="150" ><h2><?php echo $result['title']; ?></h2><br />
          <?php 
		    echo $result['description'];
			?>
          <div class="updater">
          Updated By:<br /><a href="#"><?php echo $result['username']; ?></a>
          </div>
          
          <div class="clear"></div>
          </div>
          </div><!--sel_page-->
    <?php
}else if(isset($_GET['action']) && $_GET['action'] == 'next'){
?>
           <?php 
		   $id = $_GET['next'];
		  $query = "SELECT * FROM news WHERE id <= {$id} ORDER BY id DESC LIMIT 20";
		  $result_set = mysqli_query($connection,$query);
		  confirm_query($result_set);
		  ?>
		  <div class="sel_page">
          <?php
		  for($count=1;$result=mysqli_fetch_array($result_set);$count++){ ?>
			<div class="update"><img src="images/news_events/<?php echo $result['imgName'] ?>" width="50" height="50" /> <a href="news_events.php?action=fullNews&id=<?php echo urlencode($result['id']); ?>"><?php echo $result['headline']; ?></a><br />
          <?php 
		  $newslenght = str_word_count($result['news']);
		  if($newslenght < 100){
			  echo $result['news'];
			  }else{
				  echo substr($result['news'],0,500).'<a href="news_events.php?action=fullNews&id='.urlencode($result['id']).'"><i>...read more</i></a><br />';
				  
				  }
			  
			  
		  ?>
          <div class="updater">
          Updated By:<br /><a href="#"><?php echo $result['username']; ?></a>&nbsp;&nbsp;&nbsp;<?php echo $result['date']; ?>
          </div>
          
          <div class="clear"></div>
          </div>
         
          <?php
		   } 
		    ?>
		   </div><!--sel_page-->
		<?php  }else{
			 //show latest 20 news
		  $query = "SELECT * FROM news ORDER BY id DESC LIMIT 20";
		  $result_set = mysqli_query($connection,$query);
		  confirm_query($result_set);
		  
		  
		  ?>
		  <div class="sel_page">
          <?php
		 
		  
		  for($count=1;$result=mysqli_fetch_array($result_set);$count++){ ?>
			<div class="update"><img src="images/news_events/<?php echo $result['imgName'] ?>" width="50" height="50" /> <a href="news_events.php?action=fullNews&id=<?php echo urlencode($result['id']); ?>"><?php echo $result['headline']; ?></a><br />
          <?php 
		  
		  $newslenght = str_word_count($result['news']);
		  if($newslenght < 100){
			  echo $result['news'];
			  }else{
				  echo substr($result['news'],0,500).'<a href="news_events.php?action=fullNews&id='.urlencode($result['id']).'"><i>...read more</i></a><br />';
				  
				  }
			  
			  
		  ?>
          <div class="updater">
          Updated By:<br /><a href="#"><?php echo $result['username']; ?></a>&nbsp;&nbsp;&nbsp;<?php echo $result['date']; ?>
          </div>
          
          <div class="clear"></div>
          </div>
         
          <?php
		  
		   } 
		}
		//To set next/previous links
		$query = "SELECT * FROM news ORDER BY id DESC";
		  $result_set = mysqli_query($connection,$query);
		  confirm_query($result_set);
		   $no_of_result = mysqli_num_rows($result_set);
		  if($no_of_result > 20){
		  $next = $no_of_result + 20;
		  for($count=1;$result=mysqli_fetch_array($result_set);$count++){
			  $next = $next - 20; 
			  if($count == floor($no_of_result/20)){
					  echo '&nbsp;&nbsp;<a href="news_events.php?action=next&next='.$next.'">Last</a>&nbsp;&nbsp;';
					  break;
					  }else{
						  echo '&nbsp;&nbsp;<a href="news_events.php?action=next&next='. $next.'">'.$count.'</a>&nbsp;&nbsp;';
						  }
			  }
			  }
		 ?>
           </div><!--sel_page-->
		<?php	 ?>
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
        <?php if(isset($_SESSION['username'])){ ?>
           <div class="editSide"><a href="news.php">Click To Add News</a></div>
           <?php } ?>
         
        </div><!--aside-->
        <div class="clear"></div>
        
        
       
      </div><!--wrapper-->
      
     <?php include_once('inc/footer.php'); ?>