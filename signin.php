<?
include_once 'lib/db.php';
include_once 'lib/json.php';
include_once 'lib/no_logged_in.php';


if (!isset($_POST['email'], $_POST['password']) || empty($_POST['email']) || empty($_POST['password'])) {
    echo respond_error(400, "Missing required credentials");
    exit;
}

$timeout_statement = execute_statement('SELECT id FROM timeouts WHERE ip = ? OR email = ?', [$_SERVER['REMOTE_ADDR'], $_POST['email']]);
if ($timeout_statement->num_rows > 0) {
    echo respond_error(403, "Banned");
    exit;   
}

$password_statement = execute_statement('SELECT id, password FROM accounts WHERE email = ?', [$_POST['email']]);

if ($password_statement->num_rows == 0) {
    respond_error(400, "Invalid credentials");
    exit;
}

$password_statement->bind_result($id, $password);
$password_statement->fetch();

if (!password_verify($_POST['password'], $password)) {
    respond_error(400, "Invalid credentials");
    exit;
}

session_start();
session_regenerate_id();
$_SESSION['active'] = true;
$_SESSION['email'] = $_POST['email'];
$_SESSION['username'] = $_POST['username'];
$_SESSION['id'] = $id;

respond_ok();
?>