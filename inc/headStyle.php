 <div class="headStyle">
       <div class="navi">
         <ul>
           <li><a href="about.php?action=contact">Need Help?</a></li>
           <li><a href="http://funaab.edu.ng" target="_blank">Funaab site</a></li>
         </ul>
       </div><!-- navi -->
        <script>
		document.getElementById("date").innerHTML = setCurrentTime();
		
		function setCurrentTime(){
			var date = new Date();
			var hours = date.getHours();
			var days = date.getDay();
			var munites = date.getMinutes();
			
			var curTime = date + ' ' + hours + ' ' + minutes ;
			return curTime;
			}
		        </script>
                <script>
				var date = new Date;
				var n = date.toDateString();
				var time = date.toLocaleTimeString();
				
				document.getElementById("date").innerHTML = n + ' ' + time;
				</script>
       <div class="date" id="date">
       
       <?php 
	     $date = date('Y').' '.date('M').' '.date('d');
	     echo $date;
         
	    ?>
       
       </div><!--date-->
       </div><!-- headStyle -->