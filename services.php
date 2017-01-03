<?php require_once("inc/session.php"); ?>
<?php require_once("inc/connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php include_once("inc/form_function.php"); ?>
<?php
//Update welcome page title and body
if(isset($_POST['submitServices'])){
	//Form has been submitted
		//initialize an array to hold our errors
		$errors = array();
		
		//perform validation on the form
	$required_fields = array('header','note' );
	$errors =  array_merge($errors, check_required_fields($required_fields));
	
	$page = 'services';
	$header=htmlentities(trim(mysql_prep($_POST['header'])));
	$note=htmlentities(trim(mysql_prep($_POST['note'])));
		
	//Database submission only proceeds if there were NO errors
		if (empty($errors)){
		global $connection;	
		
		$query="INSERT INTO navigation_pages SET header = '{$header}', note = '{$note}', page = '{$page}'";
		$result = mysqli_query($connection,$query);
        confirm_query($result);
		//test to see if the update occured
		if($result){
	
	$message = 'Updated Successfully!';	
			}else{
				//failed
			$message = "The Update failed";
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
<?php
//Update welcome page title and body
if(isset($_POST['updateServices'])){
	//Form has been submitted
		//initialize an array to hold our errors
		$errors = array();
		
		//perform validation on the form
	$required_fields = array('header','note', 'id' );
	$errors =  array_merge($errors, check_required_fields($required_fields));
	$id = $_POST['id'];
	$header=htmlentities(trim(mysql_prep($_POST['header'])));
	$note=htmlentities(trim(mysql_prep($_POST['note'])));
		
	//Database submission only proceeds if there were NO errors
		if (empty($errors)){
		global $connection;	
		$query="UPDATE navigation_pages SET header = '{$header}', note = '{$note}' WHERE id = '{$id}'";
		$result = mysqli_query($connection,$query);
        confirm_query($result);
		//test to see if the update occured
		if($result){
	
	$message = 'Updated Successfully!';	
			}else{
				//failed
			$message = "The Update failed";
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
<?php 
if(isset($_GET['action']) && $_GET['action'] == 'del'){
	$id = $_GET['id'];
	$page = 'services';
	$query = "DELETE FROM navigation_pages WHERE id = '{$id}' AND page = '{$page}'";
	$result_set = mysqli_query($connection,$query);
	confirm_query($result_set);
	
	$message = 'Deleted Successfully!';
	}
?>

<?php include_once('inc/developer.php'); ?>
<?php find_selected_page(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>SERVICES || CSC FUNAAB</title>
	<link rel="shortcut icon" href="images/logo.jpg" type="image">
	<link rel="stylesheet" href="css/default.css" />
  </head>
  <body id="top">
    <?php include_once('inc/headstyle.php'); ?>
     <div id="wrapper">   
        <div class="header">
          <div class="logo">
           <a href="index.php"> <img src="images/logo.jpg" width="200px" height="100px" alt="logo" /></a>
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
           <?php 
		if(isset($_GET['action']) && $_GET['action']=='editServices'){
			$page = 'services';
			$query ="SELECT * FROM navigation_pages WHERE page = '{$page}'";
		$result_set = mysqli_query($connection,$query);
		confirm_query($result_set);
		?>
         <p class="notice"><i>Select header to edit/delete </i></p>
        <?php
		for($count=0;$result = mysqli_fetch_array($result_set);$count++){
		echo '<a href="services.php?action=updateServices&id='. $result['id'] .'"><h3>'.$result['header'].'</h3></a>';
		
		}
			 ?>
              <p class="form_notice"><i>Please fill to add new  header/content</i></p>
        <form action="services.php" method="post" id="form">
			<table border="0" width="95%">
            <tr><td width="60px" height="50px"><label>Header</label></td><td><input type="text" name="header" size="74px" id="header"></td></tr>
              <tr><td colspan="2"><label>Content</label></td></tr>
              <tr><td colspan="2"><textarea cols="65px" rows="15px" name="note"></textarea></td></tr>
              <tr><td></td><td><input type="submit" name="submitServices" id="submit" value="Insert Services"></td></tr>
            </table>
            </form>
		<?php	}else 
			if(isset($_GET['action']) && $_GET['action']=='updateServices'){
	 $id = $_GET['id'];
	 $query = "SELECT * FROM navigation_pages WHERE id = {$id} LIMIT 1";
	 $result_set = mysqli_query($connection,$query);
	 confirm_query($result_set);
	 $result = mysqli_fetch_array($result_set);
	 ?>
	 <form action="services.php" method="post" id="form">
			<table border="0" width="95%">
            <tr><td width="60px" height="50px"><label>Header</label></td><td><input type="text" name="header" size="74px" id="header" value="<?php echo $result['header'] ?>"><input type="hidden" name="id" value="<?php echo $id ?>"/></td></tr>
              <tr><td colspan="2"><label>Content</label></td></tr>
              <tr><td colspan="2"><textarea cols="65px" rows="15px" name="note"><?php echo $result['note'] ?></textarea></td></tr>
              <tr><td></td><td><input type="submit" name="updateServices" id="submit" value="Update Services">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="services.php?action=del&id=<?php echo $result['id']; ?>" id="submit">Delete</a></td></tr>
            </table>
            </form>
	<?php
    }else{
			if(!empty($message)){ echo '<p class="message">'.$message.'</p>'; }
		$page = 'services';
		$query ="SELECT * FROM navigation_pages WHERE page = '{$page}'";
		$result_set = mysqli_query($connection,$query);
		confirm_query($result_set);
		
		for($count=0;$result = mysqli_fetch_array($result_set);$count++){
		echo '<h3>'.$result['header'].'</h3>';
		echo $result['note'];
		  }
		} ?>
         <?php if(isset($_SESSION['username'])){ ?>
        <div class="editSection"><a href="services.php?action=editServices">Click To Edit Services</a></div>
            <?php } ?>
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
      
      <?php include_once('inc/footer.php'); ?>