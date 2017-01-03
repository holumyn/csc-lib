// JavaScript Document
$('#hide_form').click(function(){
	var value = ('#hide_form').attr('value');
	$('form').toggle('fast');
	
	if(value == 'Hide'){
		$('#hide_form').attr('value','Show');
		}else if(value == 'Show'){
			$('#hide_form').attr('value','Hide');
			}
	
	});