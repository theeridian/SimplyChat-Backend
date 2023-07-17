<?
session_start();

if (isset($_SESSION["active"])) {
    if ($_SESSION["active"] == true) {
        echo respond_error(401, "Already logged in.");
        exit;
    }
}
?>