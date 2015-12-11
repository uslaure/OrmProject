 <?php	
    $host = "localhost";
	$user = "root";
	$pass = "";
	$dbname = "orm";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $sql = "CREATE TABLE Michel (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    reg_date TIMESTAMP
    )";

     // use exec() because no results are returned
    $conn->exec($sql);
    echo "<br>";
    echo "Table Michel created successfully ";
    }
  catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "orm";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to delete a record
    $sql = "DELETE FROM Michel WHERE id=3";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Record deleted successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;