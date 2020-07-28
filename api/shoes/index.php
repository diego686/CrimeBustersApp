 <?php
 
 require "../db.php";

 session_start();

 if ($_SESSION["valid"] == true) {
 	try {
 		$db = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
  	// set the PDO error mode to exception
 		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


 		$sql = "SELECT * FROM Shoe";

 		$stmt = $db->prepare($sql);
 		$stmt->execute();

 		$stmt->setFetchMode(PDO::FETCH_ASSOC);
 		$result = $stmt->fetchAll();

 		echo json_encode($result);


 		$db = null;

 	} catch(PDOException $e) {
 		echo "Error: " . $e->getMessage();
 	}
 } else {
 	http_response_code(403);
 	die('Forbidden');
 }


 ?> 