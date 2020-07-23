 <?php
 
require "../db.php";

 try {
 	$db = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
  	// set the PDO error mode to exception
 	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


 	$sql = "SELECT code, name FROM State";

 	$stmt = $db->prepare($sql);
 	$stmt->execute();

 	$stmt->setFetchMode(PDO::FETCH_ASSOC);
 	$result = $stmt->fetchAll();

 	echo json_encode($result);
  	

  	$db = null;

} catch(PDOException $e) {
	echo "Error: " . $e->getMessage();
}
?> 