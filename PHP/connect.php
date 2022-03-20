<?PHP
$host = "localhost";
$user = "mysql";
$pass = "123456";
$db = "db_testephp/mysql";

// CONEXÃO COM O DB
$con = mysqli_connect($host, $user, $pass, $db);

if (!$con) {
    die("ERRO: " . mysqli_connect_error());
  }
  //echo "Conectado.";

?>