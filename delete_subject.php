<?php require_once("inc/session.php"); ?>
<?php require_once("inc/connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php 
	confirm_staff_logged_in("staffLogin.php");
?>
<?php 
if(intval($_GET['subj'])==0){
		redirect_to("content.php");
		}
		$id = mysql_prep($_GET['subj']);
		
		if($subject = get_subject_by_id($id)){
		$query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";
		$result = mysqli_query($connection,$query);
		if(mysqli_affected_rows() == 1){
			redirect_to("content.php");
			}else{
				//Deletion failed
				echo "<p>Subject deletion failed. </p>";
				echo "<p>" . mysqli_error(). "</p>";
				echo "<a href= \"content.php\">Return to main page</a>";
				}
		}else{
			//subject didn't exist in database
			redirect_to("content.php");
			}
?>
<?php mysqli_close($connection); ?>