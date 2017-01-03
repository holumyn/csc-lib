<?php require_once("inc/session.php"); ?>
<?php //confirm_staff_logged_in(); ?>
<?php // this page is included by new_page.php and edit_page.php ?>
<?php if(!isset($new_page)){$new_page = false;} ?>
<table border="0" width="95%">
<tr><td width="60" height="33"><label>Page name</label> </td><td width="350"><input type="text" name="menu_name" size="75px"value="<?php echo $sel_page['menu_name']; ?>" id="menu_name" /></td></tr>

<tr><td height="33"><label>Position</label> </td><td><select name="position">
     <?php
	 if(!$new_page){
   		 $page_set= get_pages_for_subject($sel_page['subject_id']);
	 	 $page_count= mysqli_num_rows($page_set);
	 }else{
	 	$page_set = get_pages_for_subject($sel_subject['id']);
	 	$page_count= mysqli_num_rows($page_set) + 1 ;	 
		 }
	 //$page_count+1 because we are adding a page
	 for($count=1; $count<= $page_count; $count++){
		 echo "<option value=\"{$count}\"";
		 if($sel_page['position'] == $count){echo " selected";}
		echo ">{$count}</option>";
		 }
	 ?>
</select></td></tr>
<tr><td height="33"><label>Visible</label></td> 
    <td><input type="radio" name="visible" value="0" <?php 
	if($sel_page['visible'] == 0){echo " checked";}
	?> />No &nbsp;
	<input type="radio" name="visible" value="1"
     <?php 
	if($sel_page['visible'] == 1){echo " checked";}
	?> />Yes
    </td>
	</tr>
   <tr>
   <td colspan="2"><label>Content</label></td>
   </tr>
   <tr>
   <td colspan="2">
   <textarea rows="15" cols="70" name="content" ><?php echo $sel_page['content']; ?></textarea>
   </td>
   </tr>
   <tr><td></td><td><input type="submit" name="submit" id="submit" value="Create Page" /></td></tr>
   </table>