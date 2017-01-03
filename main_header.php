<?php if(isset($_SESSION['username'])){ ?>
          <div class="user_details">Welcome to the content manager: <?php echo strtoupper($_SESSION['username']);?><br />
          <a href="content.php">Content Manager</a>
          </div>
          <?php } else { ?>
			  <div class="welcome_message">
              <p>COMPUTER SCIENCE DEPARTMENT </p>
              FEDERAL UNIVERSITY OF AGRICULTURE, ABEOKUTA
              
              </div><!---welcome_message-->
			  
			  <?php }?>