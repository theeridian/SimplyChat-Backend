<?
include_once 'json.php';

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'chat';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    error_log("There was a MySQL connection error. Check the provided credentials.");
    error_log(mysqli_connect_error());
    echo respond_error(503, "MySQL improperly configured");
}


function execute_statement($sql, $variables) {
    if ($stmt = $con->prepare($sql)) {
        $stmt->execute($variables);
        $stmt->store_result();
        return $stmt;
    }
}
?>