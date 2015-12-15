  <?php

require_once('autoload.php');
require_once('database.php');
 
$dbHost = $argv[1];
$dbName = $argv[2];
$dbUser = $argv[3];
$dbPass = $argv[4];
$tableName = $argv[5];
$className = ucfirst($argv[6]);
// Connexion à la BDD & requête afin de récuperer chaque nom de colonnes
Database::getInstance()->connect($dbHost, $dbName, $dbUser, $dbPass);
$req = Database::getInstance()->prepare('SHOW COLUMNS FROM '.$tableName);
$req->getInstance()->execute();
$fields = $req->getInstance()->fetchAll(PDO::FETCH_COLUMN, 0);
$gen = 4;


function Table($gen)
{
    $ret = '';
    for ($i = 0; $i < $gen; $i ++)
        $ret .= ' ';
    return $ret;
}
$code = "<?php\n\n";
$code .= "class $className\n{\n";
$code .= Table($gen) . 'protected $tableName'.";\n";
foreach ($fields as $field)
{
    $code .= Table($space) . 'protected $'.$field.";\n";
}
$code .= "\n";
$code .= Table($gen) . 'public function TableNameBdd'.'()'."\n";
$code .= Table($gen) . "{\n";
$code .= Table($gen+2) . 'return '."'".$tableName."'".";\n";
$code .= Table($gen) . "}\n";
$code .= "\n";

$code .= Table($gen) . 'public function GetTable'.'()'."\n";
$code .= Table($gen) . "{\n";
$code .= Table($gen+2) . 'return $this->tableNameBdd'.' = $tableName'.";\n";
$code .= Table($gen) . "}\n";
$code .= "\n";

$code .= Table($gen) . 'public function SetTable'.'()'."\n";
$code .= Table($gen) . "{\n";
$code .= Table($gen+2) . 'return $this->tableNameBdd'.' = $tableName'.";\n";
$code .= Table($gen) . "}\n";

$code .= "}\n";

file_put_contents('Generator/'.$className.".php", $code);



