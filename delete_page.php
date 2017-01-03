<?php require_once("inc/connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php 
if(intval($_GET['page'])==0){
		redirect_to("content.php");
		}
		$id = mysql_prep($_GET['page']);
		
		if($page = get_page_by_id($id)){
		$query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";
		$result = mysqli_query($connection,$query);
		if(mysqli_affected_rows() == 1){
			redirect_to("content.php");
			}else{
				//Deletion failed
				echo "<p>Page deletion failed. </p>";
				echo "<p>" . mysqli_error(). "</p>";
				echo "<a href= \"content.php\">Return to main page</a>";
				}
		}else{
			//page didn't exist in database
			redirect_to("content.php");
			}
?>
<?php mysqli_close($connection); ?>