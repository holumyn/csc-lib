<?php require_once("inc/session.php"); ?>
<?php require_once("inc/connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php include_once("inc/form_function.php"); ?>
<?php 
	confirm_staff_logged_in("index.php");
?>
<?php 

if(isset($_POST['updateSlide'])){
	//Form has been submitted
	$file = $_FILES['slide']['tmp_name'];
			$file_name = $_FILES['slide']['name'];
			$file_size = $_FILES['slide']['size'];
			$file_type = $_FILES['slide']['type'];
			$file_error = $_FILES['slide']['error'];
			
	        $allowedExts = array("gif","jpeg","jpg","png");
			$temp = explode(".",$file_name);
			$extension = end($temp);
			$name = $temp[0];
			
			if( ($file_type == 'image/jpg') || ($file_type == 'image/png') || 
			($file_type == 'image/jpeg')  || 
			($file_type == 'image/pjpeg') && in_array($extension,$allowedExts)){
				if($file_error > 0){
				echo 'Return Code: ' . $file_error.'<br />';
				} elseif(file_exists("slider/".$file_name)){
				$new_file_name = 'slide'.rand(1,99).'.'.end(explode('.',$file_name));
				move_uploaded_file($file,'slider/'. $new_file_name);
				$message = 'File uploaded successfully';
				} else{
					
				move_uploaded_file($file,'slider/'. $file_name);
				    $message = 'file uploaded successfully';
					}
				  }else{
				echo 'Invalid File!';
	
				}
         }
				?>
<?php 
//change logo
if(isset($_POST['updateLogo'])){
	//Form has been submitted
	$file = $_FILES['logo']['tmp_name'];
			$file_name = $_FILES['logo']['name'];
			$file_size = $_FILES['logo']['size'];
			$file_type = $_FILES['logo']['type'];
			$file_error = $_FILES['logo']['error'];
			
	        $allowedExts = array("gif","jpeg","jpg","png");
			$temp = explode(".",$file_name);
			$extension = end($temp);
			$name = $temp[0];
			
			if( ($file_type == 'image/jpg') || ($file_type == 'image/png') || 
			($file_type == 'image/jpeg')  || 
			($file_type == 'image/pjpeg') && in_array($extension,$allowedExts)){
				if($file_error > 0){
				echo 'Return Code: ' . $file_error.'<br />';
				} elseif(file_exists("images/".$file_name)){
				$new_file_name = 'logo'.'.'.end(explode('.',$file_name));
				move_uploaded_file($file,'images/'. $new_file_name);
				
				} else{
					$file_name = 'logo'.'.'.end(explode('.',$file_name));
				move_uploaded_file($file,'images/'. $file_name);
				    
					}
				  }else{
				echo 'Invalid File!';
	
				}
         }
				?>
<?php 
//change welcome page picture
if(isset($_POST['updatePix'])){
	//Form has been submitted
	$file = $_FILES['notePix']['tmp_name'];
			$file_name = $_FILES['notePix']['name'];
			$file_size = $_FILES['notePix']['size'];
			$file_type = $_FILES['notePix']['type'];
			$file_error = $_FILES['notePix']['error'];
			
	        $allowedExts = array("gif","jpeg","jpg","png");
			$temp = explode(".",$file_name);
			$extension = end($temp);
			$name = $temp[0];
			
			if( ($file_type == 'image/jpg') || ($file_type == 'image/png') || 
			($file_type == 'image/jpeg')  || 
			($file_type == 'image/pjpeg') && in_array($extension,$allowedExts)){
				if($file_error > 0){
				echo 'Return Code: ' . $file_error.'<br />';
				} elseif(file_exists("images/".$file_name)){
				$new_file_name = 'headOfLibrary'.rand(1,99).'.'.end(explode('.',$file_name));
				move_uploaded_file($file,'images/'. $new_file_name);
				$file_name = $new_file_name;
				
				} else{
					$file_name = 'headOfLibrary'.rand(1,99).'.'.end(explode('.',$file_name));
				move_uploaded_file($file,'images/'. $file_name);
				    
					}
				  }else{
				echo 'Invalid File!';
	
				}
         }
				?>
	<?php 
	//Update welcome page title and body
if(isset($_POST['updateNote'])){
	//Form has been submitted
		//initialize an array to hold our errors
		$errors = array();
		
		//perform validation on the form
	$required_fields = array('note', 'noteHead', 'pix' );
	$errors =  array_merge($errors, check_required_fields($required_fields));
	
	$username = $_SESSION['username'];	
	$picture = $_POST['pix'];
	$note=htmlentities(trim(mysql_prep($_POST['note'])));
	$noteHead=htmlentities(trim(mysql_prep($_POST['noteHead'])));
		
	//Database submission only proceeds if there were NO errors
		if (empty($errors)){
		global $connection;	
		$query="UPDATE welcomePage SET note = '{$note}', noteHead = '{$noteHead}', picture = '{$picture}' ";
		$result = mysqli_query($connection,$query );
        confirm_query($result);
		//test to see if the update occured
		if($result){
	
	redirect_to("content.php");
	exit;
		
			}else{
				//failed
			$message = "The Welcome Note Update failed";
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
if(isset($_POST['submitInfo'])){
	//Form has been submitted
		//initialize an array to hold our errors
		$errors = array();
		
		//perform validation on the form
	$required_fields = array('resourceInfo');
	$errors =  array_merge($errors, check_required_fields($required_fields));
	
	$username = $_SESSION['username'];	
	$resourceInfo=htmlentities(trim(mysql_prep($_POST['resourceInfo'])));
	
	//Database submission only proceeds if there were NO errors
		if (empty($errors)){
		global $connection;	
		$query="INSERT INTO resource SET username = '{$username}', resourceInfo = '{$resourceInfo}' ";
		$result = mysqli_query( $connection,$query);
        confirm_query($result);
		//test to see if the update occured
		if($result){
	      redirect_to("content.php");
	       exit;
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
if(isset($_GET['action']) && $_GET['action'] == 'delResourceInfo'){
  $id = $_GET['id'];
  
  $query = "DELETE FROM resource WHERE id = {$id}";
  $result_set = mysqli_query($connection,$query);
  confirm_query($result_set);
  
  redirect_to('content.php');

}
?>
<?php find_selected_page(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>CONTENT MANAGER || CSC FUNAAB</title>
	<link rel="shortcut icon" href="images/logo.jpg" type="image">
	<link rel="stylesheet" href="css/default.css" />
   <script src="js/jquery.js"></script>
<script>
$(function(){
	$('.slideShow img:gt(0)').hide();
	setInterval(function(){$('.slideShow :first-child').fadeOut().next('img').fadeIn().end().appendTo('.slideShow');}, 5000);
});
</script>

  </head>
  <body id="top">
    <?php include_once('inc/headstyle.php'); ?>
     <div id="wrapper">   
        <div class="header">
          <div class="logo">
            <a href="index.php"><img src="images/logo.jpg" width="200px" height="100px" alt="logo" /></a>
          </div>
          <?php if(isset($_SESSION['username'])){ ?>
          <div class="user_details">Welcome to the content manager:<?php echo strtoupper($_SESSION['username']);?><br /><a href="content.php">Content Manager</a></div>
          
          <?php } ?>
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
        </div><!---nav-->
        <div class="category">
           <div class="subjects">
           <?php echo navigation($sel_subject,$sel_page); ?>
       <div class="editSide"><a href="new_subject.php">Add a new subject</a></div>
       </div>
           
         <div class="browse"> 
       <p>Staff Activities</p>
       </div>
        <div class="editSide"><a href="editResource.php">Edit Resources</a></div>
       <div class="editSide"><a href="content.php?action=editLogo#logo">Edit Logo</a></div>
        <div class="editSide"><a href="about.php?action=editContact">Edit contact</a></div>
        <div class="editSide"><a href="about.php?action=editAbout">Edit About</a></div>
         <div class="editSide"><a href="about.php?action=editPolicy">Edit Privacy Policy</a></div>
          <div class="editSide"><a href="about.php?action=editTerms">Edit Terms of Use</a></div>
       <?php
	   if($_SESSION['username'] == 'admin'){ ?>
       <div class="editSide"><a href="editStaff.php">Edit Current Users</a></div>
       <div class="editSide"><a href="newStaff.php">Add New User</a></div>
	  <?php } else{?>
      <div class="editSide"><a href="changePass.php?user=<?php echo $_SESSION['username']; ?>">Change Password</a></div>
      <?php } ?>
       <div class="editSide"><a href="timeout.php">Logout</a></div>
       
        </div><!-- end category -->
        
        
        <div class="section">
        
        <?php if(!is_null($sel_subject)){ //subject selected ?>
        <div class="sel_page">
<h2><?php echo $sel_subject['menu_name']; ?></h2>
</div><!--sel_page-->
<?php } elseif(!is_null($sel_page)) { //page selected ?>
<div class="sel_page">
<h2><?php echo  $sel_page['menu_name']; ?></h2>
<?php echo strip_tags(nl2br($sel_page['content']), "<b><br><p><a>"); ?>
<br />
  <a href="edit_page.php?page=<?php echo urlencode($sel_page["id"]); ?>" >Edit Page</a>
</div><!--sel_page-->
<?php
} else { // show default page ?>



        <div class="direction">
        <p><marquee><span>Latest News</span>:
        <?php
		$query = "SELECT headline FROM news ORDER BY id DESC LIMIT 10";
		$result_set = mysqli_query($connection,$query);
		confirm_query($result_set);
		for($count=0;$result=mysqli_fetch_array($result_set);$count++){
			echo $result['headline'].'.&nbsp;&nbsp;';
			}
		 ?>
         </marquee></p>
        </div><!-- end direction -->
       
        <?php
         if(isset($_GET['action']) && $_GET['action'] == 'editSlide'){
			 if(!empty($message)){ echo $message; }
			  ?>
         
		<form action="content.php" method="post" enctype="multipart/form-data" id="slide">
			  <label>Add image:</label> <br />
			  <input type="file" name="slide" id="slide" alt="slide"  /> <br />
              <input type="submit" name="updateSlide" value="Upload"/>
			  </form>
		 <?php }else{ ?>
             <div class="slideShow">
             <?php 
	//locate and display content of a dir
	$dir = opendir('slider');
	$count = 0;
	while(($file = readdir($dir)) !== false){
		if($file == '.' || $file == '..' || $file == '_notes'){
			//DO NOTHING
		}else{
		 ?>
            <img src="slider/<?php echo $file ?>" width="580px" height="250px"/>
            
            <?php
		}
			$count++;
			 }
			 closedir($dir);
			  ?>
            </div><!-- end slideShow -->
		<div class="editSection"><a href="content.php?action=editSlide">Click To Edit Slide Show Images</a></div>
		<?php
        }	 ?>
		
        
        <div class="mainSection">
        
        <?php	  
		  $query = "SELECT * FROM welcomePage";
		  $result = mysqli_query($connection,$query);
		  confirm_query($result);
		  if( $result = mysqli_fetch_array($result)){
			 $message = $result['note'];	
			 $noteHead = $result['noteHead'];
			 $picture = $result['picture'];
			   } else{
				   $message = '';
				   }
		  
		  if(isset($_GET['action']) && $_GET['action'] == 'editNote'){
			   ?>
			  <!--form for image upload and welcome note update-->
			  <form action="content.php" method="post" enctype="multipart/form-data">
             <?php
				  if(!empty($file_name)){
			  echo '<img src="images/'.$file_name.'" width="100px" height="100px" alt="'.$file_name.'" /> <br />';
				  
			  }
			   ?>
              
              <label>Edit Picture:</label> <br />
			  <input type="file" name="notePix" id="notePix" alt="head Of Library"  /> <br />
              <input type="submit" name="updatePix" id="updatePix" value="Update Pix"  />  <br /><br /><br /><hr />
			  <label>Edit Note Head:</label><br />
			  <input type="text" name="noteHead" id="noteHead" value="<?php echo $noteHead ?>" size="91" maxlength="250"/> <br />
			  <label>Edit Note Body:</label> <br />
			  <textarea name="note"rows="20" cols="70">
			  <?php if(!empty($message)){ echo  $message; } ?>
	      </textarea>
		  <input type="submit" name="updateNote" id="updateNote" value="Update Note"  /> <br />
			</form>
			    <?php }
				elseif(isset($_GET['action']) && $_GET['action'] == 'editLogo'){ ?>
			<form action="content.php" method="post" enctype="multipart/form-data" id="logo">
			<table border="0" width="95%">
            <tr><td width="100px" height="30px"><label class="form_notice"><i>Please choose a new logo to upload</i></label> </td></tr>
            <tr>
            <td>
			  <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
			  <input type="file" name="logo" id="logo" alt="logo"  />
              
			  <input type="submit" name="updateLogo" id="submit" value="Update logo"  /> 
             </td>
              </tr>
              </table>
			  </form>
					<?php
					}else{ if(!empty($message)){ ?>
						<h3 style="padding:5px 0 5px 0;"><?php echo $noteHead ?></h3>
						<p>
          <img src="images/<?php echo $picture; ?>" width="100px" height="100px" alt="Head Of Library" />
						 <?php echo  $message ?>
					<div class="editSection"><a href="welcomeNote.php">Click To Edit Welcome Note and Image</a></div>
					</p>
                    <?php }
					} ?>
		 
        </div><!--end mainSection -->
        <?php } ?>
        
        <div class="bottomSection">
        <h3 id="event">Upcoming Events</h3>
        <?php 
		$query = "SELECT * FROM events ORDER BY id DESC";
		$result_set = mysqli_query($connection,$query);
		confirm_query($query);
		
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
          
                  
		
		<?php }
		 ?>
        <div class="update"> <a href="news_events.php">view all</a>
        
        <div class="clear"></div>
        </div>
         <div class="editSection" ><a href="editEvent.php" >Click To Add an Event</a></div>
        </div><!--bottomsection-->
        
        <div class="bottomSection">
        <h3 id="resource">Resources</h3>
        <?php 
		$query = "SELECT * FROM resource";
		$result_set = mysqli_query($connection,$query);
		confirm_query($result_set);
		
		?>
               <ul>
               <?php 
			   for($count=0;$result=mysqli_fetch_array($result_set);$count++){
				   echo '<li>'.$result['resourceInfo'].'</li>';
				   if(isset($_SESSION['username'])){
				   echo '<a href="content.php?action=delResourceInfo&id='.$result['id'].'">Delete</a>';
				   }
				   }
			   ?>
               
              </ul>
    <?php if(isset($_GET['action']) && $_GET['action'] == 'addResourceInfo'){ ?>
             <hr />
	           <form action="content.php" method="post">
               <label>Enter Resource information</label><br />
               <input type="text" name="resourceInfo" id="resourceInfo" /><br />
               <input type="submit" name="submitInfo" id="submit" value=" Add Resource Information " />
               </form>
<?php 	}
	 ?>

        <div class="editSection" ><a href="content.php?action=addResourceInfo&#resource" >Click To Add Additional Resource Information</a></div>
        </div>
        
        
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
          <div class="update"> 
          <img src="images/oijio.jpg" width="150" height="150" >
          
          <div class="clear"></div>
          </div>
          
        </div>
        
        </div><!---aside-->
        <div class="clear"></div>
       </div><!--wrapper-->
      
     <?php include_once('inc/footer.php'); ?>