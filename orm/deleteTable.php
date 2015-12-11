<html>
<head>
<title>Creating MySQL Tables</title>
</head>
<body>

<?php 
require('creationTable.php');

$host = 'localhost';
$user = 'root';
$pass = '';
$conn = mysql_connect($host, $user, $pass);
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully<br />';
$sql = "DROP TABLE tutorials_tbl";
mysql_select_db( 'TUTORIALS' );
$retval = mysql_query( $sql, $conn );
if(! $retval )
{
  die('Could not delete table: ' . mysql_error());
}
echo "Table deleted successfully\n";
mysql_close($conn);
?>
</body>
</html>