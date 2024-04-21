
<?php
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $conn = new PDO($_ENV['DB_DNS'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    exit("DB Connection failed");
}
?>
