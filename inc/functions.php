<?php
//all basic functions

function mysql_prep($value) {
	global $connection; 
	$magic_quotes_active = get_magic_quotes_gpc();
	$new_enough_php = function_exists("mysqli_real_escape_string");//i.e PHP >= v4.3.0
	if ($new_enough_php){ // PHP v4.3.0 or higher
	//undo any magic quote effects so mysql_real_escape_string can do the work
	if($magic_quotes_active){$value = stripslashes($value);}
		$value = mysqli_real_escape_string($connection,$value);
		}else{ //before PHP v4.3.0
		//if magic quotes aren't already on then add slashes manually
		if(!$magic_quotes_active){$value = addslashes($value);}
		//if magic quotes are active, then the slashes already exist
			}
			return $value;
	}
	
function redirect_to($location= NULL){
	if($location != NULL){
		header("Location: {$location}");
		exit;
		}
	}

function confirm_query($result_set){
	if(!$result_set){
		die("DATABASE QUERY FAILED:" . mysqli_error($connection));
		}
	}

function get_all_subjects($public = true){
	global $connection;
	$query="SELECT * 
		FROM subjects "; 
	if ($public){
	$query .="WHERE visible = 1 ";
	}
	$query .="ORDER BY position ASC ";
$subject_set=mysqli_query( $connection,$query);
confirm_query($subject_set);
return $subject_set;
		}

function get_values($username){
	global $connection;
	$query = "SELECT * FROM all_registered_users WHERE username = '{$username}' ";
	$result = mysqli_query( $connection,$query);
	confirm_query($result);
	while ($value_set = mysqli_fetch_array($result)){ 
	$output=  $value_set;
	return $output;
}}
	
function get_pages_for_subject($subject_id, $public = true){
	global $connection;
	$query= "SELECT * 
			FROM pages ";
	$query .= "WHERE subject_id ={$subject_id} ";
	if ($public){
	$query .= "AND visible = 1 ";	
		} 
	$query .= "ORDER BY position ASC ";
	$page_set=mysqli_query( $connection,$query);
	confirm_query($page_set);
	return $page_set;
	}

function get_subject_by_id($subject_id){
	global $connection;
	$query = "SELECT * ";
	$query .= "FROM subjects ";
	$query .= "WHERE id=" . $subject_id. " ";
	$query .= "LIMIT 1";
	$result_set = mysqli_query($connection,$query);
	confirm_query($result_set);
	//if no rows are returned, fetch array will return false
	if ($subject= mysqli_fetch_array($result_set)){
	return $subject;
	}else{
		return NULL;
		}
	}
function get_page_by_id($page_id){
	global $connection;
	$query = "SELECT * ";
	$query .= "FROM pages ";
	$query .= "WHERE id=" . $page_id. " ";
	$query .= "LIMIT 1";
	$result_set = mysqli_query($connection,$query);
	confirm_query($result_set);
	//REMEMBER:
	//if no rows are returned, fetch_array will return false
	if ($page= mysqli_fetch_array($result_set)){
	return $page;
	}else{
		return NULL;
		}
	}
	
function get_default_page($subject_id){
	$page_set = get_pages_for_subject($subject_id, true);
	if ($first_page = mysqli_fetch_array($page_set)){
		return $first_page;
		}else{
			return NULL;
			}
		}
	
function find_selected_page(){
	global $sel_subject;
	global $sel_page;
	if(isset($_GET['subj'])){
	$sel_subject = get_subject_by_id($_GET['subj']);
	$sel_page=get_default_page($sel_subject['id']);
	}elseif(isset($_GET['page'])){
		$sel_subject = NULL;
		$sel_page = get_page_by_id($_GET['page']);
		}else{
			$sel_subject = NULL;
			$sel_page = NULL;
			}
	}

function navigation($sel_subject,$sel_page, $public = false){
	$output ="<ul class=\"subjects\">";
$subject_set=get_all_subjects();
      while($subject= mysqli_fetch_array($subject_set)){
     $output .= "<li";
	 if ($subject["id"]==$sel_subject['id']){$output .= " class=\"subject\"";}
	 $output .= "><a href=\"edit_subject.php?subj=" . urlencode($subject["id"]) . "\">{$subject["menu_name"]}</a></li>";
	$page_set=get_pages_for_subject($subject["id"], $public);
	$output .= "<ul class=\"pages\">";
	while($page = mysqli_fetch_array($page_set)){
		$output .= "<li";
		if($page["id"]==$sel_page['id']){$output .= " class=\"page\"";}
		$output .= "><a href=\"content.php?page=" . urlencode($page["id"]) ."\">{$page["menu_name"]}</a></li>"; 
		
	}
	$output .= "</ul>";
	}
	$output .= "</ul>";
	return $output;
	
	}
	
function public_navigation($sel_subject,$sel_page, $public = true){
	$output ="<ul class=\"subjects\">";
$subject_set=get_all_subjects();
      while($subject= mysqli_fetch_array($subject_set)){
     $output .= "<li";
	 if ($subject["id"]==$sel_subject['id']){$output .= " class=\"subject\"";}
	 $output .= "><a href=\"index.php?subj=" . urlencode($subject["id"]) . "\">{$subject["menu_name"]}</a></li>";
	$page_set=get_pages_for_subject($subject["id"], $public);
	$output .= "<ul class=\"pages\">";
	while($page = mysqli_fetch_array($page_set)){
		$output .= "<li";
		if($page["id"]==$sel_page['id']){$output .= " class=\"page\"";}
		$output .= "><a href=\"index.php?page=" . urlencode($page["id"]) ."\">{$page["menu_name"]}</a></li>"; 
		
	}
	$output .= "</ul>";
	}
	$output .= "</ul>";
	return $output;
	
	}
	
function get_category_by_id($id){
	global $connection;
	$query = "SELECT id,menu_name FROM pages WHERE id = '{$id}'";
				$result_set = mysqli_query($connection,$query);
				confirm_query($result_set);
				$result = mysqli_fetch_array($result_set);
				return $result['menu_name'];
	}			
?>