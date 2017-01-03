<?php require_once("inc/session.php"); ?>
<?php require_once("inc/connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php include_once("inc/form_function.php"); ?>
<?php  if(staff_logged_in()){
		redirect_to("content.php");}
?>
<?php 
if(isset($_POST['submit'])){
	//Form has been submitted
	//initialize an array to hold our errors
		$errors = array();
	//perform validation on the form
	$required_fields = array('usrname', 'pass' );
	$errors =  array_merge($errors, check_required_fields($required_fields));
	
	$fields_with_lengths = array('usrname' => 250, 'pass' => 40);
	$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));
	
	//Clean up the form data before putting it in the database
		
		$username = htmlentities(trim( mysql_prep($_POST['usrname'])));
		$pass = htmlentities(trim(mysql_prep($_POST['pass'])));
		$password = sha1($pass);
		
	//Database submission only proceeds if there were NO errors
		if (empty($errors)){
		$query = "SELECT * ";
		$query .= "FROM staff ";
		$query .= "WHERE username = '{$username}' ";
		$query .= "AND password = '{$password}' ";
		$query .= "LIMIT 1";
		$result_set = mysqli_query($connection,$query);
        confirm_query($result_set);
		//test to see if the update occured
		if(mysqli_num_rows($result_set) == 1){
			//success
			$found_user = mysqli_fetch_array($result_set);
			$_SESSION['username'] = $found_user['username'];
			
			redirect_to("content.php");
			}else{
				//failed
			$message = "Please review username/password combination. ";
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
		if(isset($_GET['timeout']) && $_GET['timeout'] == 1 ){
			
			$message = 'You are now logged out. <a href="index.php">Click</a> to go to main site';
			}
		$username = '';
		$password = '';
		
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
          <div class="clear"></div>
        </div><!---header-->
       <div class="login">
       
       <h2>Welcome to computer Science department library staff login page.</h2>
       <h5>Please login using your username and password combinations.</h5>
       <?php if(!empty($message)){ echo "<p class=\"message\">" . $message . "</p>"; } ?>
       <form method="post" action="staffLogin.php">
         <table border="0" >
         
           <tr>
           <td>Username:</td><td><input type="text" name="usrname" id="usrname" /></td>
           </tr>
           <tr>
           <td>Password:</td><td><input type="password" name="pass" id="pass" /></td>
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