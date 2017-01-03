<?php require_once("inc/session.php"); ?>
<?php require_once("inc/connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php include_once("inc/form_function.php"); ?>
<?php 
	confirm_staff_logged_in("index.php");
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
	$required_fields = array('note', 'noteHead','pix' );
	$errors =  array_merge($errors, check_required_fields($required_fields));
	
	$username = $_SESSION['username'];	
	$picture = $_POST['pix'];
	$note=htmlentities(trim(mysql_prep($_POST['note'])));
	$noteHead=htmlentities(trim(mysql_prep($_POST['noteHead'])));
		
	//Database submission only proceeds if there were NO errors
		if (empty($errors)){
		global $connection;	
		$query="UPDATE welcomePage SET note = '{$note}', noteHead = '{$noteHead}', picture = '{$picture}' ";
		$result = mysqli_query($connection,$query);
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
           <li><a href="content.php" >Content Manager</a></li>
         </ul>
       </div><!-- navi -->
       <span class="date">
       <?php 
	     $date = date('Y').'-'.date('F').'-'.date('d');
	     echo $date
	    ?>
       </span>
       </div><!-- headStyle -->
     <div id="wrapper">   
        <div class="header">
          <div class="logo">
            <img src="images/logo.jpg" width="200px" height="100px" alt="logo" />
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
        </div><!--header--->
        <div id="main">
        
        <div class="nav">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="news_events.php">News & Events</a></li>
          <li><a href="Collections.php">Explore</a></li>
          <li><a href="explore.php">Services & Projects</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="developer.php">Contributors & Developers</a>
            <ul>
                <li><a href="#">Audios</a></li>
                 <li><a href="#">Video</a></li>
                 <li><a href="#">PDF Materials</a></li>
              </ul>
          
          </li>
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
        <div class="editSide"><a href="editEvent.php">Edit Event</a></div>
       <div class="editSide"><a href="content.php?action=editLogo">Edit Logo</a></div>
       <div class="editSide"><a href="editNav.php">Edit Navigation</a></div>
       <div class="editSide"><a href="editStaff.php">Edit Current Users</a></div>
       <div class="editSide"><a href="newStaff.php">Add New User</a></div>
       <div class="editSide"><a href="timeout.php">Logout</a></div>
       </div><!-- end category -->
       
        <div class="section">
          <div class="sel_page">
         <div class="mainSection">
        <?php	  
		  $query = "SELECT * FROM welcomePage";
		  $result = mysqli_query($connection,$query);
		  confirm_query($result);
		  if( $result = mysqli_fetch_array($result)){
			 $note = $result['note'];	
			 $noteHead = $result['noteHead'];
			 $picture = $result['picture'];
			   } else{
				   $message = '';
				   }
		 ?> 
		 	  <p class="notice"><i>Please Upload image before submitting content.</i></p>
              <!--form for image upload and welcome note update-->
			  <form action="welcomeNote.php" method="post" enctype="multipart/form-data">
             <?php
				  if(!empty($file_name)){
			  echo '<img src="images/'.$file_name.'" width="100px" height="100px" alt="'.$file_name.'" /> <br />';
			 } else{
				 echo '<img src="images/'.$picture.'" width="100px" height="100px" alt="'.$picture.'" /> <br />';
				 }
			   ?>
              
              <label>Edit Picture:</label> <br />
			  <input type="hidden" name="pix" value="<?php if(!empty($file_name)){echo $file_name; }else{ echo $picture; } ?>" />
			  <input type="file" name="notePix" id="notePix" alt="head Of Library"  /> <br /><br />
              <input type="submit" name="updatePix" id="updatePix" value="Update Pix"  />  <br /><br /><br /><hr width="95%"/>
			  <table border="0" width="100%">
              <tr>
              <td height="50px"><label>Edit Note Head:</label></td>
              </tr>
              <tr>
			  <td><input type="text" name="noteHead" id="noteHead" value="<?php echo $noteHead ?>" size="91" maxlength="250"/></td>
              </tr>
              <tr>
			  <td height="50px"><label>Edit Note Body:</label></td>
              </tr>
              <tr>
			  <td><textarea name="note"rows="20" cols="70">
			  <?php if(!empty($note)){ echo  $note; } ?>
	      </textarea>
          </td>
          </tr>
          <tr>
		  <td height="50px"><input type="submit" name="updateNote" id="updateNote" value="Update Note"  /></td>
          </tr>
          </table>
			</form>
			    </div><!---main section--->
                </div><!---sel_page-->
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
        
        </div><!--aside-->
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
        <a href="#">Privacy Policy</a><br />
        <a href="#">Terms of Use</a><br />
        Copyright &copy; Computer Science, FUNAAB 2014.<br /> All Rights Reserved.
        </p>
        <br /><br /><br /><br /><br />
       
      </div><!---site--->
      <div class="clear"></div>
      </div>
         <div class="clear"></div>
         <span class="top"><a href="#top">Back to top &uArr;</a></span>
      </div><!--footer-->
  </body>
</html>
<?php mysqli_close($connection); ?>>>>>>>