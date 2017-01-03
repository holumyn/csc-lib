<?php require_once("inc/session.php"); ?>
<?php require_once("inc/connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php include_once("inc/form_function.php"); ?>
<?php 
	confirm_staff_logged_in("staffLogin.php");
?>
<?php 
	$errors = array();
	//form validation
	$required_fields = array('menu_name', 'position', 'visible');
	foreach($required_fields as $fieldname){
	if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])){
		$errors[] = $fieldname;
		}
	}
	$fields_with_lengths = array('menu_name' => 30);
	foreach($fields_with_lengths as $fieldname => $maxlength) {
		if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength){
			$errors[] = $fieldname;
			}
		}
	if(!empty($errors)){
		
		$message= "Subject creation failed. ";
			//redirect_to("new_subject.php");
			}
?>
<?php 
	$menu_name = mysql_prep($_POST['menu_name']);
	$position = mysql_prep($_POST['position']);
	$visible = mysql_prep($_POST['visible']);
?>
<?php 
	$query = "INSERT INTO subjects (
				menu_name, position, visible
			) VALUES (
		 		'{$menu_name}', {$position}, {$visible} 
			)";
		$result = mysqli_query($connection,$query);
	if($result){
		//success
		header("Location:content.php");
		exit;
		}else{
			//Display error message.
	echo "<p>Subject creation failed.</p>";
	echo "<p>" . mysqli_error() . "</p>";
			}
?>

<?php mysqli_close($connection); ?>