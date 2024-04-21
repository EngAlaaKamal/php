<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
require "./db_connection.php";

$del_user_stmt = $conn->prepare("DELETE FROM users WHERE id = :id");

$del_user_stmt->bindParam(':id', $_GET['id']);
if ($del_user_stmt->execute()) {
    header('Location: ./customers.php');
    die();
}

echo $conn->errorInfo();
?>