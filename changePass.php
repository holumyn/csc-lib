<?php require_once("inc/session.php"); ?>
<?php require_once("inc/connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php include_once("inc/form_function.php"); ?>
<?php confirm_staff_logged_in("staff_login.php"); ?>
<?php
if(isset($_POST['submitPass'])){
	$username = $_GET['user'];
	$ex_pass = $_POST['ex_pass'];
	$pass = $_POST['pass'];
	$re_pass = $_POST['re_pass'];
	$query = "SELECT password FROM staff WHERE username = '{$username}' LIMIT 1";
	$result_set = mysqli_query($query,$connection);
	confirm_query($result_set);
	$result = mysqli_fetch_array($result_set);
	//check if database password matches user given password i.e old password
	if(sha1($ex_pass) == $result['password']){
		//check if the entered password matches
		if($pass == $re_pass){
			$username = $_GET['user'];
			$pass = $_POST['pass'];
			$password = sha1($pass);
			$query = "UPDATE staff SET password = '{$password}' WHERE username = '{$username}'";
			$result_set = mysqli_query($query,$connection);
			confirm_query($result_set);
			$message = 'Password Changed Successfully!';
			}else{
				//new passwords does not match
				$message = 'New passwords doesn\'t match';
				}
		}else{
			//entered old password does not match the database password
			$message = 'Password incorrect! Try again or contact the admin for help.';
			}
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
            <a href="index.php"><img src="images/logo_11.jpg" width="200px" height="100px" alt="" /></a>
          </div>
           <?php if(isset($_SESSION['username'])){ ?>
         <div class="user_details">Welcome to the content manager:<?php echo strtoupper($_SESSION['username']);?><br /><a href="content.php">Content Manager</a></div>
          <?php } ?>
          <div class="clear"></div>
        </div><!---header-->
        <div class="login">
       
       <h2>Welcome <?php echo strtoupper($_SESSION['username']);?>, Please change your password.</h2>
       
       <?php if(!empty($message)){ echo "<p class=\"message\">" . $message . "</p>"; } ?>
       <form method="post" action="changePass.php?user=<?php echo $_GET['user']; ?>">
         <table border="0" >
         
           <tr>
           <td>Old Password:</td><td><input type="password" name="ex_pass" id="ex_pass" /></td>
           </tr>
           <tr>
           <td>New Password:</td><td><input type="password" name="pass" id="pass" /></td>
           </tr>
           <tr>
           <td>Re-enter New Password:</td><td><input type="password" name="re_pass" id="re_pass" /></td>
           </tr>
           <tr>
           <td></td><td><input type="submit" name="submitPass" id="submitPass" /></td>
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
<?php mysql_close($connection); ?>
