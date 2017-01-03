<?php session_start(); 


function staff_logged_in(){
	return isset($_SESSION['username']);
	}

function confirm_staff_logged_in($url){
	if(!staff_logged_in()){
		redirect_to($url);
		}
		
	}
?>