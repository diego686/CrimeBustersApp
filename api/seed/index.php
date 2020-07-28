 <?php

 require "../db.php";

 try {
 	$pdo = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
  	// set the PDO error mode to exception
 	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	// echo "Connected successfully";


  	/**************************************
    * Create tables                       *
    **************************************/

    // Create table messages
  	// $pdo->exec("CREATE TABLE IF NOT EXISTS Material (
   //   id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   //   name VARCHAR(30) NOT NULL UNIQUE,
   //   type VARCHAR(30) NOT NULL,
   //   appearance VARCHAR(30) NOT NULL,
   //   water_reaction VARCHAR(30) NOT NULL,
   //   ph VARCHAR(30) NOT NULL,
   //   hcl_reaction VARCHAR(30) NOT NULL,
   //   iodine_reaction VARCHAR(30) NOT NULL)");



    $pdo->exec("CREATE TABLE IF NOT EXISTS User (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      first_name VARCHAR(64) NOT NULL,
      last_name VARCHAR(64) NOT NULL,
      email VARCHAR(64) NOT NULL UNIQUE,
      password VARCHAR(255) NOT NULL,
      state_code CHAR(2),
      school VARCHAR(64),
      app_permissions TINYINT NOT NULL DEFAULT 0,
      created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
      FOREIGN KEY (state_code)
      REFERENCES State(code)
    )");

    

  	// SEED DATABASE






    // $pdo->exec("INSERT INTO User (first_name, last_name, email, state_code, app_permissions) 
    //   VALUES ('Diego', 'Gomez', 'dgg2010@gmail.com', 'AZ', 5)");

    // importUnknowns($pdo);

    createShoes($pdo);
    createFootprints($pdo);

    $pdo = null;

  } catch(PDOException $e) {
   echo "Error: " . $e->getMessage();
 }

 function createShoes($pdo) {
  $pdo->exec("CREATE TABLE IF NOT EXISTS Shoe (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(64) NOT NULL UNIQUE)");

  $pdo->exec("INSERT INTO Shoe (image_path) VALUES ('images/shoes/1/Shoe1.jpg')");
  $pdo->exec("INSERT INTO Shoe (image_path) VALUES ('images/shoes/2/Shoe1.jpg')");
}

function createFootprints($pdo) {
  $pdo->exec("CREATE TABLE IF NOT EXISTS Footprint (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    shoe_id INT(6) UNSIGNED, 
    image_path VARCHAR(64) NOT NULL UNIQUE,
    FOREIGN KEY (shoe_id)
    REFERENCES Shoe(id)
    ON DELETE CASCADE
  )");

  $pdo->exec("INSERT INTO Footprint (shoe_id, image_path) VALUES (1, 'images/shoes/1/Footprint1.jpg')");
  $pdo->exec("INSERT INTO Footprint (shoe_id, image_path) VALUES (2, 'images/shoes/2/Footprint1.jpg')");
}

function createStates($pdo) {
  $pdo->exec("CREATE TABLE IF NOT EXISTS State (
    `id` int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `code` char(2) NOT NULL UNIQUE,
    `name` varchar(128) NOT NULL UNIQUE)");

  $pdo->exec("INSERT INTO State (code,name) VALUES ('AL','Alabama');
    INSERT INTO State (code,name) VALUES ('AK','Alaska');
    INSERT INTO State (code,name) VALUES ('AS','American Samoa');
    INSERT INTO State (code,name) VALUES ('AZ','Arizona');
    INSERT INTO State (code,name) VALUES ('AR','Arkansas');
    INSERT INTO State (code,name) VALUES ('CA','California');
    INSERT INTO State (code,name) VALUES ('CO','Colorado');
    INSERT INTO State (code,name) VALUES ('CT','Connecticut');
    INSERT INTO State (code,name) VALUES ('DE','Delaware');
    INSERT INTO State (code,name) VALUES ('DC','District of Columbia');
    INSERT INTO State (code,name) VALUES ('FM','Federated States of Micronesia');
    INSERT INTO State (code,name) VALUES ('FL','Florida');
    INSERT INTO State (code,name) VALUES ('GA','Georgia');
    INSERT INTO State (code,name) VALUES ('GU','Guam');
    INSERT INTO State (code,name) VALUES ('HI','Hawaii');
    INSERT INTO State (code,name) VALUES ('ID','Idaho');
    INSERT INTO State (code,name) VALUES ('IL','Illinois');
    INSERT INTO State (code,name) VALUES ('IN','Indiana');
    INSERT INTO State (code,name) VALUES ('IA','Iowa');
    INSERT INTO State (code,name) VALUES ('KS','Kansas');
    INSERT INTO State (code,name) VALUES ('KY','Kentucky');
    INSERT INTO State (code,name) VALUES ('LA','Louisiana');
    INSERT INTO State (code,name) VALUES ('ME','Maine');
    INSERT INTO State (code,name) VALUES ('MH','Marshall Islands');
    INSERT INTO State (code,name) VALUES ('MD','Maryland');
    INSERT INTO State (code,name) VALUES ('MA','Massachusetts');
    INSERT INTO State (code,name) VALUES ('MI','Michigan');
    INSERT INTO State (code,name) VALUES ('MN','Minnesota');
    INSERT INTO State (code,name) VALUES ('MS','Mississippi');
    INSERT INTO State (code,name) VALUES ('MO','Missouri');
    INSERT INTO State (code,name) VALUES ('MT','Montana');
    INSERT INTO State (code,name) VALUES ('NE','Nebraska');
    INSERT INTO State (code,name) VALUES ('NV','Nevada');
    INSERT INTO State (code,name) VALUES ('NH','New Hampshire');
    INSERT INTO State (code,name) VALUES ('NJ','New Jersey');
    INSERT INTO State (code,name) VALUES ('NM','New Mexico');
    INSERT INTO State (code,name) VALUES ('NY','New York');
    INSERT INTO State (code,name) VALUES ('NC','North Carolina');
    INSERT INTO State (code,name) VALUES ('ND','North Dakota');
    INSERT INTO State (code,name) VALUES ('MP','Northern Mariana Islands');
    INSERT INTO State (code,name) VALUES ('OH','Ohio');
    INSERT INTO State (code,name) VALUES ('OK','Oklahoma');
    INSERT INTO State (code,name) VALUES ('OR','Oregon');
    INSERT INTO State (code,name) VALUES ('PW','Palau');
    INSERT INTO State (code,name) VALUES ('PA','Pennsylvania');
    INSERT INTO State (code,name) VALUES ('PR','Puerto Rico');
    INSERT INTO State (code,name) VALUES ('RI','Rhode Island');
    INSERT INTO State (code,name) VALUES ('SC','South Carolina');
    INSERT INTO State (code,name) VALUES ('SD','South Dakota');
    INSERT INTO State (code,name) VALUES ('TN','Tennessee');
    INSERT INTO State (code,name) VALUES ('TX','Texas');
    INSERT INTO State (code,name) VALUES ('UT','Utah');
    INSERT INTO State (code,name) VALUES ('VT','Vermont');
    INSERT INTO State (code,name) VALUES ('VI','Virgin Islands');
    INSERT INTO State (code,name) VALUES ('VA','Virginia');
    INSERT INTO State (code,name) VALUES ('WA','Washington');
    INSERT INTO State (code,name) VALUES ('WV','West Virginia');
    INSERT INTO State (code,name) VALUES ('WI','Wisconsin');
    INSERT INTO State (code,name) VALUES ('WY','Wyoming');");
}


function importUnknowns($pdo) {

  $pdo->exec("CREATE TABLE IF NOT EXISTS Unknown (
   id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   category VARCHAR(30) NOT NULL,
   name VARCHAR(30) NOT NULL UNIQUE,
   type VARCHAR(30) NOT NULL,
   appearance VARCHAR(64) NOT NULL,
   ph VARCHAR(30) NOT NULL,
   water_reaction VARCHAR(30) NOT NULL,
   hcl_reaction VARCHAR(30) NOT NULL,
   iodine_reaction VARCHAR(30) NOT NULL,
   other_observation VARCHAR(64),
   odor VARCHAR(30),
   apply_magnet VARCHAR(30),
   microscope_view VARCHAR(30),
   apply_flame VARCHAR(30),
   buoyancy_water VARCHAR(30),
   buoyancy_IPA VARCHAR(30),
   buoyancy_vegetable_oil VARCHAR(30),
   buoyancy_nacl VARCHAR(30),
   buoyancy_saturated_nacl VARCHAR(30)
 )");

  $csv = array_map('str_getcsv', file('Matrix of Unknowns.csv'));
  $skip_first = true;

  foreach($csv as $unknown) {
    // echo json_encode($unknown);


    $sql = "INSERT INTO Unknown (category, name, type, appearance, ph, water_reaction, hcl_reaction, iodine_reaction, other_observation, odor, apply_magnet, microscope_view, apply_flame, buoyancy_water, buoyancy_IPA, buoyancy_vegetable_oil, buoyancy_nacl, buoyancy_saturated_nacl) 
    VALUES (:category, :name, :type, :appearance, :ph, :water_reaction, :hcl_reaction, :iodine_reaction, :other_observation, :odor, :apply_magnet, :microscope_view, :apply_flame, :buoyancy_water, :buoyancy_IPA, :buoyancy_vegetable_oil, :buoyancy_nacl, :buoyancy_saturated_nacl)";

    $stmt = $pdo->prepare($sql);

    // Bind parameters to statement variables
    $stmt->bindParam(':category', $unknown[0]);
    $stmt->bindParam(':name', $unknown[1]);
    $stmt->bindParam(':type', $unknown[2]);
    $stmt->bindParam(':appearance', $unknown[3]);
    $stmt->bindParam(':ph', $unknown[4]);
    $stmt->bindParam(':water_reaction', $unknown[5]);
    $stmt->bindParam(':hcl_reaction', $unknown[6]);
    $stmt->bindParam(':iodine_reaction', $unknown[7]);
    $stmt->bindParam(':other_observation', $unknown[8]);
    $stmt->bindParam(':odor', $unknown[9]);
    $stmt->bindParam(':apply_magnet', $unknown[10]);
    $stmt->bindParam(':microscope_view', $unknown[11]);
    $stmt->bindParam(':apply_flame', $unknown[12]);
    $stmt->bindParam(':buoyancy_water', $unknown[13]);
    $stmt->bindParam(':buoyancy_IPA', $unknown[14]);
    $stmt->bindParam(':buoyancy_vegetable_oil', $unknown[15]);
    $stmt->bindParam(':buoyancy_nacl', $unknown[16]);
    $stmt->bindParam(':buoyancy_saturated_nacl', $unknown[17]);


    if ($skip_first) {
      $skip_first = false;
    } else {
      $stmt->execute();
    }
    
  }


  // fclose($file);
}

?> 