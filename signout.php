<?
include_once 'lib/json.php';
include_once 'lib/logged_in_only.php';
include_once 'lib/no_banned_users.php';

session_start();
session_destroy();
session_regenerate_id();

respond_ok();
?>