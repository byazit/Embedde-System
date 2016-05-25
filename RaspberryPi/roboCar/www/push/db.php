<?php
      $conn = mysql_connect('localhost', 'root', '#razib3417#');
      $db   = mysql_select_db('gpioPin');
			if($conn)
				echo "";
			else{
				echo "not success!";
				exit;
			}
?>
