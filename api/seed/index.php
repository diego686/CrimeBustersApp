 <?php

 require "../db.php";

 try {
 	$conn = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
  	// set the PDO error mode to exception
 	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	// echo "Connected successfully";


  	/**************************************
    * Create tables                       *
    **************************************/

    // Create table messages
  	$conn->exec("CREATE TABLE IF NOT EXISTS Material (
     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
     name VARCHAR(30) NOT NULL UNIQUE,
     type VARCHAR(30) NOT NULL,
     appearance VARCHAR(30) NOT NULL,
     water_reaction VARCHAR(30) NOT NULL,
     ph VARCHAR(30) NOT NULL,
     hcl_reaction VARCHAR(30) NOT NULL,
     iodine_reaction VARCHAR(30) NOT NULL)");

    $conn->exec("CREATE TABLE IF NOT EXISTS State (
      `id` int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `code` char(2) NOT NULL UNIQUE,
      `name` varchar(128) NOT NULL UNIQUE)");

    $conn->exec("CREATE TABLE IF NOT EXISTS User (
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

    $conn->exec("INSERT INTO Material (name, type, appearance, water_reaction, ph, hcl_reaction, iodine_reaction)
      VALUES ('Baking Soda', 'Solid', 'Powder', 'Soluble', '8', 'Bubbles form', 'No reaction');
      INSERT INTO Material (name, type, appearance, water_reaction, ph, hcl_reaction, iodine_reaction)
      VALUES ('Gypsum', 'Solid', 'Powder', 'Not Soluble', '>8', 'No reaction', 'No reaction');");



    $conn->exec("INSERT INTO State (code,name) VALUES ('AL','Alabama');
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

    // $conn->exec("INSERT INTO User (first_name, last_name, email, state_code, app_permissions) 
    //   VALUES ('Diego', 'Gomez', 'dgg2010@gmail.com', 'AZ', 5)");

    $conn = null;

  } catch(PDOException $e) {
   echo "Error: " . $e->getMessage();
 }
 ?> 