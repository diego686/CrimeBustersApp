 <?php
 
 require "../../db.php";

 try {
 	$pdo = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
  	// set the PDO error mode to exception
 	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


 	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

 		$sanitized_data = [];
 		$error = "";

 		$post = json_decode(file_get_contents("php://input"),true);

 		if (!empty($post)) {

 			if (isset($post["email"]) && !empty($post["email"])) {
 				$sanitized_data["email"] = filter_var(trim($post["email"]), FILTER_SANITIZE_EMAIL);
 			} else {
 				$error .= "An email is required.\n";
 			}

 			if (isset($post["password"]) && !empty($post["password"])) {
 				$sanitized_data["password"] = trim($post["password"]);
 			} else {
 				$error .= "A password is required.\n";
 			}

 			$sql = "SELECT id, first_name, password, app_permissions FROM User WHERE email = ?";
 			$stmt = $pdo->prepare($sql);
 			$stmt->execute([$sanitized_data['email']]); 
 			$user = $stmt->fetch();

 			// echo json_encode($user);

 			if(password_verify($sanitized_data["password"], $user["password"])) {
 				session_start();

 				$_SESSION['valid'] = true;
 				$_SESSION['first_name'] = $user["first_name"];
 				$_SESSION['email'] = $sanitized_data["email"];
 				$_SESSION['user_id'] = $user["id"];
 				$_SESSION['app_permissions'] = $user["app_permissions"];


    			echo "success";
 			} else {
 				echo "failure";
 			}

 		}
 	}


 	// $sql = "SELECT * FROM Material";

 	// $stmt = $db->prepare($sql);
 	// $stmt->execute();

 	// $stmt->setFetchMode(PDO::FETCH_ASSOC);
 	// $result = $stmt->fetchAll();

 	// echo json_encode($result);


 	$pdo = null;

 } catch(PDOException $e) {
 	echo "Error: " . $e->getMessage();
 }
 ?> 