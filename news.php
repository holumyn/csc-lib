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
	$file = $_FILES['newsImg']['tmp_name'];
			$file_name = $_FILES['newsImg']['name'];
			$file_size = $_FILES['newsImg']['size'];
			$file_type = $_FILES['newsImg']['type'];
			$file_error = $_FILES['newsImg']['error'];
			
	        $allowedExts = array("gif","jpeg","jpg","png");
			$temp = explode(".",$file_name);
			$extension = end($temp);
			$name = $temp[0];
			
			if( ($file_type == 'image/jpg') || ($file_type == 'image/png') || 
			($file_type == 'image/jpeg')  || 
			($file_type == 'image/pjpeg') && in_array($extension,$allowedExts)){
				if($file_error > 0){
				$message = 'Error uploading image: ' . $file_error.'<br />';
				} elseif(file_exists("images/news_events/".$file_name)){
				$new_file_name = $name . rand(1,999).'.'.end(explode('.',$file_name));
				move_uploaded_file($file,"images/news_events/". $new_file_name);
				$doc_name = $new_file_name;
				} else{
			
				move_uploaded_file($file,"images/news_events/". $file_name);
				    $doc_name = $file_name;
					}
				  }else{
				$message = 'Invalid File!';
	
				}
         }
				?>
<?php 
	//Add news
if(isset($_POST['addNews'])){
	//Form has been submitted
		//initialize an array to hold our errors
		$errors = array();
		
		//perform validation on the form
	$required_fields = array('headline', 'news', 'fileUpload' );
	$errors =  array_merge($errors, check_required_fields($required_fields));
	
	$username = $_SESSION['username'];	
	$headline=htmlentities(trim(mysql_prep($_POST['headline'])));
	$news=htmlentities(trim(mysql_prep($_POST['news'])));
	$imgName =htmlentities(trim(mysql_prep($_POST['fileUpload'])));
	$date = date('M').' '.date('d').','.date('Y');
		
	//Database submission only proceeds if there were NO errors
		if (empty($errors)){
		global $connection;	
		$query="INSERT INTO news SET headline = '{$headline}', news = '{$news}', username = '{$username}', imgName = '{$imgName}', date = '{$date}' ";
		$result = mysqli_query($connection,$query);
        confirm_query($result);
		//test to see if the update occured
		if($result){
	
	redirect_to("content.php");
	exit;
		
			}else{
				//failed
			$message = "The News Update failed";
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
           <?php include_once('main_header.php'); ?>
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
        <h3>Add News</h3>
        <?php if(!empty($message)){ echo $message; }?>
        
		<p class="notice"><i>Please upload image before submitting the form.</i></p>
        
         <form method="post" action="news.php" enctype="multipart/form-data">
         <table border="0">
          <tr> <td height="24" colspan="3"><label>Headline:</label>
            <input type="text" name="headline" id="headline" /></td>
           </tr>
           <tr>
            <td colspan="3"><label><i>Please Upload an image</i></label><br />
        <?php if(!empty($doc_name)){ 
		echo '<img src="images/news_events/'.$doc_name.'" width="100px" height="100px" />';
		} ?>
			
        <input type="hidden" name="fileUpload" value="<?php if(isset($doc_name)){  echo $doc_name; }?>"/>
        <input type="file" name="newsImg" /><input type="submit" name="imgUpload" id="imgUpload" value="Upload Image" />
        </td>
        </tr>
        <tr><td></td><td></td></tr>
        <tr>
          <td><label>Details:</label></td>
          <td></td>
          <td></td>
        </tr>
       <tr>
          <td colspan="3"><textarea cols="70%" rows="20" name="news" id="news"></textarea></td>
        </tr>
        <tr>
           <td colspan="3"><input type="submit" name="addNews" id="submit" value="Add News" width="200px" /></td>
        </tr>
        </table>
        </form>
        </div><!---sel_page-->
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
          <div class="editSide"><a href="news.php">Click To Add News</a></div>
       
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
      
     <?php include_once('inc/footer.php'); ?>