<?
session_start();

$timeout_statement = execute_statement('SELECT id FROM timeouts WHERE ip = ? OR email = ?', [$_SERVER['REMOTE_ADDR'], $_SESSION['email']]);
if ($timeout_statement->num_rows > 0) {
    echo respond_error(403, "Banned");
    exit;   
}
?>