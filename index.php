<?php require_once("inc/session.php"); ?>
<?php require_once("inc/connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php include_once("inc/form_function.php"); ?>
<?php include_once('inc/developer.php'); ?>
<?php find_selected_page(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>CSC FUNAAB LIBRARY || HOME</title>
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
   <?php include_once('inc/headStyle.php'); ?>
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
        </div><!--header--->
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
           <!--
           <div class="catalogue">
           <div class="pages">
           <li><a href="index.php?action=catalog&list1=a&list2=b&list3=c&list4=d&list5=e">A - E</a></li><br />
           <li><a href="#">F - J</a></li><br />
           <li><a href="#">K - O</a></li><br />
           <li><a href="#">P - T</a></li><br />
           <li><a href="#">U - Z</a></li><br />
           </div><!---pages--->
           <!--
           </div><!--catalogue -->
           
           <?php echo public_navigation($sel_subject,$sel_page); ?>
       </div>
        </div><!-- end category -->
        
        <div class="section">
          
        <?php if(isset($_GET['action']) && $_GET['action'] == 'catalog') {
			echo '<div class="catalog">';
               $list1 = $_GET['list1'];
			   $list2 = $_GET['list2'];
			   $list3 = $_GET['list3'];
			   $list4 = $_GET['list4'];
			   $list5 = $_GET['list5'];
			   
			   
			   $query = "SELECT * FROM document WHERE title LIKE '%{$list1}%' ";
			   $result_set = mysqli_query($connection,$query);
			   confirm_query($result_set);
			   
			   for($k = 0;$result = mysqli_fetch_array($result_set);$k++){
				   echo '<div class="list_design">';
				   echo '<label>Title:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>'.$result['title'].'<br />';
				   echo '<label>Author:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>'.$result['author'].'<br />';
				   echo '<label>Category:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>'.$result['category'].'<br />';
				   echo '<label>Description:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>'.$result['description'].'<br />';
				   echo '</div>';
				   }
			   
			   
			   ?>
               </div><!---catalog--->
        <?php } else{ ?>
        <?php if(!is_null($sel_subject)){ //subject selected ?>
        <div class="sel_page">
                <h2><?php echo $sel_subject['menu_name']; ?></h2>
                </div><!--sel_page-->
                <?php } elseif(!is_null($sel_page)) { //page selected ?>
                <div class="sel_page">
                <h2><?php echo  $sel_page['menu_name']; ?></h2>
                <?php echo strip_tags(nl2br($sel_page['content']), "<b><br><p><a>"); ?>
                <?php
				if(isset($_GET['page'])){
					//get category using page id
					$id = $_GET['page'];
				$query = "SELECT id,menu_name FROM pages WHERE id = '{$id}'";
				$result_set = mysqli_query($connection,$query);
				confirm_query($result_set);
				$result = mysqli_fetch_array($result_set);
				 	
				//get documents under this category 
				$category = $result['menu_name'];
				$query = "SELECT * FROM document WHERE category = '{$category}'";
				$result_set = mysqli_query($connection,$query);
				confirm_query($result_set);
				$result_no = mysqli_num_rows($result_set);
				if($result_no > 0){
				?>
                <h3>Available Documents</h3>
                    <ul>
                <?php
				for($count=0;$result=mysqli_fetch_array($result_set);$count++){
					?>
                    
                      <li class="list_design"><?php echo 'Title:&nbsp;'.$result['title'].'<br />'.'Author(s):&nbsp;'.$result['author'].'<br />'.'ISBN:&nbsp;'.$result['ISBN'].'<br />'.'Description:&nbsp;'.$result['description']?>
                       <form action="resource.php" method="get">
                      <button id="submit" name="action" value="get_document"><a href="resource.php?action=get_document&resource_id=<?php echo urlencode($result['ISBN']); ?>">Full Details</a></button>
                      <input type="hidden" name="resource_id" value="<?php echo urlencode($result['ISBN']); ?>" />
                    </form>
                    </li>
                    <?php
					}
				?>
                </ul>
                <?php }
				
				//get category using page id
					$id = $_GET['page'];
				$query = "SELECT id,menu_name FROM pages WHERE id = '{$id}'";
				$result_set = mysqli_query($connection,$query);
				confirm_query($result_set);
				$result = mysqli_fetch_array($result_set);
				
			
				//get audios under this category 
				$category = $result['menu_name'];
				$query = "SELECT * FROM audio WHERE category = '{$category}'";
				$result_set = mysqli_query($connection,$query);
				confirm_query($result_set);
				$result_no = mysqli_num_rows($result_set);
				if($result_no > 0){
				?>
                <h3>Available Audios</h3>
                    <ul>
                <?php
				for($count=0;$result=mysqli_fetch_array($result_set);$count++){
					?>
                    
                      <li class="list_design"><?php echo 'Title:&nbsp;'.$result['title'].'<br />'.'Instructor(s):&nbsp;'.$result['author'].'<br />'.'Description:&nbsp;'.$result['description']?>
                      <form action="resource.php" method="get">
                      <button id="submit" name="action" value="get_audio"><a href="resource.php?action=get_audio&resource_id=<?php echo urlencode($result['id']); ?>">Full Details</a></button>
                      <input type="hidden" name="resource_id" value="<?php echo urlencode($result['category']); ?>" />
                    </form>
                    </li>
                    <?php
					}
				?>
                </ul>
                <?php
				}
				
				//get category using page id
					$id = $_GET['page'];
				$query = "SELECT id,menu_name FROM pages WHERE id = '{$id}'";
				$result_set = mysqli_query($connection,$query);
				confirm_query($result_set);
				$result = mysqli_fetch_array($result_set);
				
			
				//get video under this category 
				$category = $result['menu_name'];
				$query = "SELECT * FROM video WHERE category = '{$category}'";
				$result_set = mysqli_query($connection,$query);
				confirm_query($result_set);
				$result_no = mysqli_num_rows($result_set);
				if($result_no > 0){
				?>
                <h3>Available Videos</h3>
                    <ul>
                <?php
				for($count=0;$result=mysqli_fetch_array($result_set);$count++){
					?>
                    
                      <li class="list_design"><?php echo 'Title:&nbsp;'.$result['title'].'<br />'.'Instructor(s):&nbsp;'.$result['author'].'<br />'.'Description:&nbsp;'.$result['description']?>
                      <form action="resource.php" method="get">
                      <button id="submit" name="action" value="get_video"><a href="resource.php?action=get_video&resource_id=<?php echo urlencode($result['id']); ?>">Full Details</a></button>
                      <input type="hidden" name="resource_id" value="<?php echo urlencode($result['category']); ?>" />
                    </form>
                    </li>
                    <?php
					}
				?>
                </ul>
                <?php
				}
				} ?>
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
			echo $result['headline'].'...&nbsp;&nbsp;&nbsp;&nbsp;';
			}
		 ?>
         </marquee></p>
        </div><!-- end direction -->
       
        <?php
         if(isset($_GET['action']) && $_GET['action'] == 'editSlide'){
			 if(!empty($message)){ echo $message; }
			  ?>
         
		<form action="content.php" method="post" enctype="multipart/form-data">
			  <label>Add image:</label> <br />
			 <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
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
            <img src="slider/<?php echo $file ?>" width="580px" height="300px"/>
            
            <?php
		}
			$count++;
			 }
			 closedir($dir);
			  ?>
            </div><!-- end slideShow -->
		
		<?php
        }	 ?>
		
        
        <div class="mainSection">
        
        <?php	  
		  $query = "SELECT * FROM welcomepage";
		  $result_set = mysqli_query($connection,$query);
		  confirm_query($result_set);
		  if( $result = mysqli_fetch_array($result_set)){
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
			  <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
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
			<form action="content.php" method="post" enctype="multipart/form-data">
			<label>Edit Logo:</label> <br />
			  <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
			  <input type="file" name="logo" id="logo" alt="logo"  /> <br />
			  <input type="submit" name="updateLogo" id="updateLogo" value="Update logo"  /> <br />
			  </form>
					<?php
					}else{ if(!empty($message)){ ?>
						<h3 style="padding:5px 0 5px 0;"><?php echo $noteHead ?></h3>
						<p>
          <img src="images/<?php echo $picture; ?>" width="100px" height="100px" alt="Head Of Library" />
						 <?php echo  $message ?>
					<div class="clear"></div>
                    </p>
                    <?php }
					} ?>
		 
        </div><!--end mainSection -->
        <div class="bottomSection">
        <h3>Upcoming Events</h3>
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
        <div id="submit"> <a href="news_events.php">view all</a>
        <div class="clear"></div>
        </div>
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
				   }
			   ?>
               
              </ul>
     </div> 
        <?php } ?>
        <?php } ?>
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
          <div id="submit"><a href="news_events.php">view all</a></div> 
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