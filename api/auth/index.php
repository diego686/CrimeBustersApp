 <?php

 session_start();
 
 if (isset($_SESSION["valid"]) && $_SESSION["valid"] == true) {
 	echo json_encode($_SESSION);
 } else {
 	echo json_encode(["valid" => false]);
 }

 ?> 