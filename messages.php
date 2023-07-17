<?
include_once 'lib/db.php';
include_once 'lib/json.php';
include_once 'lib/logged_in_only.php';
include_once 'lib/no_banned_users.php';

if (isset($_SESSION['active'])) {
    if ($_SESSION['active'] != true) {
        echo respond_error(401, "Not signed in");
        exit;
    }
}

if (isset($_POST["message_content"]) && !empty($_POST["message_content"])) {
    execute_statement('INSERT INTO messages (author_id, author_username, message) VALUES (?, ?, ?)', [$_SESSION["id"], $_SESSION["username"], $_POST["message_content"]]);
    echo respond_ok();
    exit;
}

$messages_statement = execute_statement('SELECT id, author_id, author_username, message, timestamp FROM messages', []);
$password_statement->bind_result($id, $author_id, $author_username, $message, $timestamp);
$password_statement->fetch_all();
