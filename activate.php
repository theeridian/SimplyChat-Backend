<?
include_once 'lib/db.php';
include_once 'lib/json.php';
include_once 'lib/no_logged_in.php';

if (!isset($_GET['activation_code']) || empty($_GET['activation_code']) || strlen($_GET['activation_code']) != 8) {
    echo respond_error(400, "Missing required credentials");
    exit;
}

$verify_statement = execute_statement('SELECT id FROM accounts WHERE activation_code = ?', [$_GET['activation_code']]);

if ($verify_statement->num_rows == 0) {
    respond_error(400, "Invalid credentials");
    exit;
}

$verify_statement->bind_result($id);
$verify_statement->fetch();

$activate_statement = execute_statement('UPDATE accounts SET activation_code = ? WHERE activation_code = ? AND id = ?', [$_GET['activation_code'], $_GET['activation_code'], $id]);

respond_ok();
?>