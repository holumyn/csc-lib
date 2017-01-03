<?php require_once("inc/session.php"); ?>
<?php require_once("inc/connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php include_once("inc/form_function.php"); ?>
<?php confirm_staff_logged_in("staff_login.php"); ?>
<?php
if(isset($_POST['submit'])){
	//Form has been submitted
	
		//initialize an array to hold our errors
		$errors = array();
		
		//perform validation on the form
	$required_fields = array('username', 'password' );
	$errors =  array_merge($errors, check_required_fields($required_fields));
	
	$fields_with_lengths = array('username' => 250, 'password' => 40);
	$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));
	
	//Clean up the form data before putting it in the database
		
		$username = trim( mysql_prep($_POST['username']));
		$password = trim(mysql_prep($_POST['password']));
		$hashed_password = sha1($password);
		
		
		//Database submission only proceeds if there were NO errors
		if (empty($errors)){
		$query = "INSERT INTO staff (
					username, password
					) VALUE (
					 '{$username}', '{$hashed_password}'
					 )";
		$result = mysqli_query($connection,$query);
		confirm_query($result);
		//test to see if the update occured
		if($result){
			//success
			$message = "The user was successfully created. Please create another or <a href=\"content.php\">click</a> to go back to content";
			}else{
				//failed
			$message = "The user creation failed";
			$message .= "<br />" . mysqli_error();
				}
		}else{
			//Errors occured
			if(count($errors) == 1){
				$message = "There was 1 error in the form.";
			}else{
		$message = "There were" . count($errors). "errors in the form";
			}
		}//END FORM PROCESSING
	
	} else {
		$username = "";
		$password = "";
		}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>STAFF LOGIN||CSC FUNAAB</title>
	<link rel="stylesheet" href="css/default.css" />
  </head>
  <body>
    
     <div id="wrapper">   
        <div class="header">
          <div class="logo">
            <img src="images/logo_11.jpg" width="200px" height="100px" alt="" />
          </div>
           <?php if(isset($_SESSION['username'])){ ?>
         <div class="user_details">Welcome to the content manager:<?php echo strtoupper($_SESSION['username']);?><br /><a href="content.php">Content Manager</a></div>
          <?php } ?>
          <div class="clear"></div>
        </div><!---header-->
        <div class="login">
       
       <h2>Welcome <?php echo strtoupper($_SESSION['username']);?>, Please create a new user.</h2>
       
       <?php if(!empty($message)){ echo "<p class=\"message\">" . $message . "</p>"; } ?>
       <form method="post" action="newStaff.php">
         <table border="0" >
         
           <tr>
           <td><label>Username</label></td><td><input type="text" name="username" id="username" /></td>
           </tr>
           <tr>
           <td><label>Password</label></td><td><input type="password" name="password" id="password" /></td>
           </tr>
           <tr>
           <td></td><td><input type="submit" name="submit" id="submit" /></td>
           </tr>
         </table>
         </form>
       </div><!-- end login -->
       
      </div><!-- wrapper -->
      <footer>
        <p>Copyright &copy; Computer Science, FUNAAB 2014. All Rights Reserved.</p>
        
      </footer>
  </body>
</html>
<?php mysqli_close($connection); ?>
