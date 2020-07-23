 <?php
 
 require "../../db.php";

 try {
 	$db = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
  	// set the PDO error mode to exception
 	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


 	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

 		$sanitized_data = [];
 		$error = "";

 		$post = json_decode(file_get_contents("php://input"),true);

 		if (!empty($post)) {

 			if (isset($post["firstName"]) && !empty($post["firstName"])) {
 				$sanitized_data["firstName"] = htmlspecialchars(trim($post["firstName"]));
 			} else {
 				$error .= "A first name is required.\n";
 			}

 			if (isset($post["lastName"]) && !empty($post["lastName"])) {
 				$sanitized_data["lastName"] = htmlspecialchars(trim($post["lastName"]));
 			} else {
 				$error .= "A last name is required.\n";
 			}

 			if (isset($post["email"]) && !empty($post["email"])) {
 				$sanitized_data["email"] = filter_var(trim($post["email"]), FILTER_SANITIZE_EMAIL);
 			} else {
 				$error .= "An email is required.\n";
 			}

 			if (isset($post["state"]) && !empty($post["state"])) {
 				$sanitized_data["state"] = htmlspecialchars(trim($post["state"]));
 			} else {
 				$error .= "A state is required.\n";
 			}

 			if (isset($post["school"]) && !empty($post["school"])) {
 				$sanitized_data["school"] = htmlspecialchars(trim($post["school"]));
 			} else {
 				$error .= "A school is required.\n";
 			}

 			if (isset($post["password"]) && !empty($post["password"])) {
 				$password = trim($post["password"]);
 				$hashed_password = password_hash($password, PASSWORD_DEFAULT);
 			} else {
 				$error .= "A password is required.\n";
 			}
 		}


 		if (empty($error)) {
 			$insert = "INSERT INTO User (first_name, last_name, email, password, state_code, school) 
 			VALUES (:first_name, :last_name, :email, :password, :state_code, :school)";
 			$stmt = $db->prepare($insert);

      		// Bind parameters to statement variables
 			$stmt->bindParam(':first_name', $sanitized_data["firstName"]);
 			$stmt->bindParam(':last_name', $sanitized_data["lastName"]);
 			$stmt->bindParam(':email', $sanitized_data["email"]);
 			$stmt->bindParam(':password', $hashed_password);
 			$stmt->bindParam(':state_code', $sanitized_data["state"]);
 			$stmt->bindParam(':school', $sanitized_data["school"]);

 			$stmt->execute();

 			echo "User created.";
 		} else {
 			echo $error;
 		}
 	}


 	// $sql = "SELECT * FROM Material";

 	// $stmt = $db->prepare($sql);
 	// $stmt->execute();

 	// $stmt->setFetchMode(PDO::FETCH_ASSOC);
 	// $result = $stmt->fetchAll();

 	// echo json_encode($result);


 	$db = null;

 } catch(PDOException $e) {
 	echo "Error: " . $e->getMessage();
 }
 ?> 