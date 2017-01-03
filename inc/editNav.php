<?php
//all basic functions

function mysql_prep($value) {
	$magic_quotes_active = get_magic_quotes_gpc();
	$new_enough_php = function_exists("mysql_real_escape_string");//i.e PHP >= v4.3.0
	if ($new_enough_php){ // PHP v4.3.0 or higher
	//undo any magic quote effects so mysql_real_escape_string can do the work
	if($magic_quotes_active){$value = stripslashes($value);}
		$value = mysql_real_escape_string($value);
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
		die("Database connection failed" . mysql_error());
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
$subject_set=mysql_query($query, $connection);
confirm_query($subject_set);
return $subject_set;
		}

function get_values($username){
	global $connection;
	$query = "SELECT * FROM all_registered_users WHERE username = '{$username}' ";
	$result = mysql_query($query, $connection);
	confirm_query($result);
	while ($value_set = mysql_fetch_array($result)){ 
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
	$page_set=mysql_query($query, $connection);
	confirm_query($page_set);
	return $page_set;
	}

function get_subject_by_id($subject_id){
	global $connection;
	$query = "SELECT * ";
	$query .= "FROM subjects ";
	$query .= "WHERE id=" . $subject_id. " ";
	$query .= "LIMIT 1";
	$result_set = mysql_query($query,$connection);
	confirm_query($result_set);
	//if no rows are returned, fetch array will return false
	if ($subject= mysql_fetch_array($result_set)){
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
	$result_set = mysql_query($query,$connection);
	confirm_query($result_set);
	//REMEMBER:
	//if no rows are returned, fetch_array will return false
	if ($page= mysql_fetch_array($result_set)){
	return $page;
	}else{
		return NULL;
		}
	}
	
function get_default_page($subject_id){
	$page_set = get_pages_for_subject($subject_id, true);
	if ($first_page = mysql_fetch_array($page_set)){
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
      while($subject= mysql_fetch_array($subject_set)){
     $output .= "<li";
	 if ($subject["id"]==$sel_subject['id']){$output .= " class=\"selected\"";}
	 $output .= "><a href=\"edit_subject.php?subj=" . urlencode($subject["id"]) . "\">{$subject["menu_name"]}</a></li>";
	$page_set=get_pages_for_subject($subject["id"], $public);
	$output .= "<ul class=\"pages\">";
	while($page = mysql_fetch_array($page_set)){
		$output .= "<li";
		if($page["id"]==$sel_page['id']){$output .= " class=\"selected\"";}
		$output .= "><a href=\"content.php?page=" . urlencode($page["id"]) ."\">{$page["menu_name"]}</a></li>"; 
		
	}
	$output .= "</ul>";
	}
	$output .= "</ul>";
	return $output;
	
	}
	
function public_navigation($sel_subject,$sel_page, $public = true){
	$output ="<ul class=\"subjects\">";
$subject_set=get_all_subjects($public);
      while($subject= mysql_fetch_array($subject_set)){
     $output .= "<li ";
	 if ($subject["id"]==$sel_subject['id']){$output .= " class=\"selected\"";}
	 $output .= "><a href=\"focus.php?subj=" . urlencode($subject["id"]) . "\">{$subject["menu_name"]}</a></li>";
	$page_set=get_pages_for_subject($subject["id"]);
	$output .= "<ul class=\"pages\">";
	while($page = mysql_fetch_array($page_set)){
		$output .= "<li";
		if($page["id"]==$sel_page['id']){$output .= " class=\"selected\"";}
		$output .= "><a href=\"focus.php?page=" . urlencode($page["id"]) ."\">{$page["menu_name"]}</a></li>"; 
		
	}
	$output .= "</ul>";
	}
	$output .= "</ul>";
	return $output;
	
	}
	
function profile_form1($menu_name, $input_name, $menu_name_value){
	$output = "{$menu_name}
      <input type=\"text\" name=\"{$input_name}\" size=\"40\" value=\"";
$result_array= get_values( $_SESSION['username']);
  $output .= $result_array[$menu_name_value]; 
$output .= "\" />
		";
return $output;
	}
	
function profile_form2($input_name, $menu_name_value){
	$output = "
	<textarea cols=\"50\" rows=\"10\" name=\"$input_name\">";
	$result_array= get_values($_SESSION['username']);
  $output .=  $result_array[$menu_name_value]; 
	$output .= "</textarea>
	";
	return $output ;
	}
	
function profile_frame1($menu_name, $menu_name_value, $username){
$output = "{$menu_name}";
$result_array= get_values( $username);
  $output .= $result_array[$menu_name_value];
	return $output;
	}
	
function profile_frame2($menu_name_value){
	
  $result_array= get_values($_SESSION['username']);
  $output = strip_tags(nl2br($result_array[$menu_name_value]), "<b><br><p>");
  return $output;
	}
	
	
function form_head($menu_name, $link_pos){
	$output = "<hr />&nbsp;&nbsp;{$menu_name}
	<form action=\"profile.php?profile={$link_pos}\" method=\"post\">";
	return $output;
	}
function form_bottom($submit_id){
	$output = "
	<input type=\"submit\" name=\"submit{$submit_id}\" value=\"submit\" />
	</form>";
	return $output;
	}
function profile_head($menu_name, $link_pos){
	$output = "<hr />{$menu_name} &nbsp; &nbsp; <a href=\"profile.php?profile={$link_pos}\">[edit]</a>";
	return $output;
}

function get_single_page(){
	global $connection;
	$query = "SELECT * FROM single_pages ";
	$result_set = mysql_query($query, $connection);
	confirm_query($result_set);
	//REMEMBER:
	//if no rows are returned, fetch_array will return false
	while($single_page= mysql_fetch_array($result_set)){
	echo "<a href=\"single_page.php?single_page=". urlencode($single_page['id']). "\">";
	echo $single_page['menu_name']."<br />";
	 echo "</a>";    
		 }
	}
	
?>