<?php require_once("inc/session.php"); ?>
<?php require_once("inc/connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php include_once("inc/form_function.php"); ?>
<?php confirm_staff_logged_in("staff_login.php"); ?>
<?php 
 if(isset($_GET['action']) && $_GET['action'] == 'delete'){
	 $username = $_GET['user'];
	 $query = "DELETE FROM staff WHERE username = '{$username}'";
	 $result = mysqli_query($connection,$query);
	 confirm_query($result);
	 $message = 'User deleted successfully!';
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
        <div class="editStaff">
        <h2> Active Staffs</h2>
         <?php if(!empty($message)){ echo "<p class=\"message\">" . $message . "</p>"; } ?>
        <?php
$query = "SELECT * FROM staff";
$result_set= mysqli_query($connection,$query);
confirm_query($result_set);
	echo '<table border="0" width="95%" >';
	echo '<tr class="editStaff_tbHead"><td width="15%">Username</td><td>Registration Date</td><td></td></tr>';
for($count=0;$result=mysqli_fetch_array($result_set);$count++){
	 echo '<tr class="editStaff_tbBody">';
	 echo '<td width="20%">'.$result['username'].'</td>'.'<td width="20%">'.$result['reg_date'].'</td>';
	 if($result['username'] == 'admin'){
		 echo '<td width="20%"></td>';
		 }else{
	 echo '<td><a href="editStaff.php?action=delete&user='.urlencode($result['username']).'"';
	 
	 echo 'onclick = "return confirm(\'Are you sure you want to delete this user?\')';
     
	 	  echo '">Delete User</a></td>';
		 }
	 echo '<td><a href="changePass.php?user='.urlencode($result['username']).'">Change password</a></td>';
	 echo '</tr>';
	 }
		   echo '</table>';
?>
       </div><!-- editStaff -->
      </div><!-- wrapper -->
      <footer>
        <p>Copyright &copy; Computer Science, FUNAAB 2014. All Rights Reserved.</p>
        
      </footer>
  </body>
</html>
<?php mysqli_close($connection); ?>