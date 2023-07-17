<?
include_once 'lib/db.php';
include_once 'lib/json.php';
include_once 'lib/no_logged_in.php';

$timeout_statement = execute_statement('SELECT id FROM timeouts WHERE ip = ? OR email = ?', [$_SERVER['REMOTE_ADDR'], $_POST['email']]);
if ($timeout_statement->num_rows > 0) {
    echo respond_error(403, "Banned");
    exit;   
}

if (!isset($_POST['email'], $_POST['username'], $_POST['password']) || empty($_POST['email']) || empty($_POST['username']) || empty($_POST['password'])) {
    echo respond_error(400, "Missing required credentials");
    exit;
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || strlen($_POST['password']) < 8 || preg_match('^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$', $_POST['username']) == 0) {
    echo respond_error(400, "Invaid credentials");
    exit;
}

$check_statement = execute_statement('SELECT id FROM accounts WHERE username = ? OR email = ?', [$_POST['username'], $_POST['email']]);

if ($check_statement->num_rows > 0) {
    echo respond_error(400, "User already exists");
    exit;
}

$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$create_statement = execute_statement('INSERT INTO accounts (username, password, email, activation_code) VALUES (?, ?, ?, ?)', [$_POST['username'], $password, $_POST['email'], random_int(10000000, 99999999)]);

respond_ok();
?>