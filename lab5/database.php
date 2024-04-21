<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php

class Database
{
    private string $db_dns;
    private string $db_user;
    private string $db_password;
    private PDO $conn;
    public array $errorInfo;

    public function __construct(string $db_dns, string $db_user, string $db_password)
    {
        $this->errorInfo = array();
        $this->db_dns = $db_dns;
        $this->db_user = $db_user;
        $this->db_password = $db_password;
        $this->conn = new PDO($this->db_dns, $this->db_user, $this->db_password);
        return true;
    }

    public function insert(string $table_name, array $colToValue): int|false
    {
        $query = "INSERT INTO $table_name (";
        foreach ($colToValue as $col => $value) {
            $query = $query . $col . ", ";
        }
        $query = rtrim($query, ', ') . ") ";

        $query = $query . "VALUES (";
        foreach ($colToValue as $col => $value) {
            $query = $query . "'" . $value . "'" . ", ";
        }
        $query = rtrim($query, ', ') . ")";

        $inst_stmt = $this->conn->prepare($query);
        if ($inst_stmt->execute()) {
            return $this->conn->lastInsertId();
        }

        $this->errorInfo = $this->conn->errorInfo();
        return false;
    }

    public function select(string $table_name): array|false
    {
        $query = "SELECT * FROM {$table_name}";
        $sel_stmt = $this->conn->prepare($query);
        if ($sel_stmt->execute()) {
            return $sel_stmt->fetchAll();
        }
        $this->errorInfo = $this->conn->errorInfo();
        return false;
    }

    public function update(string $table_name, string $id, array $colToValue): bool
    {
        $query = "UPDATE $table_name SET ";
        foreach ($colToValue as $col => $value) {
            $query = $query . $col . " = " . "'{$value}', ";
        }
        $query = rtrim($query, ', ');

        $query = $query . " WHERE id = {$id}";

        $update_stmt = $this->conn->prepare($query);
        if ($update_stmt->execute()) {
            return true;
        }

        $this->errorInfo = $this->conn->errorInfo();
        return false;
    }

    public function delete(string $table_name, int $id): bool
    {
        $query = "DELETE FROM {$table_name} WHERE id = {$id}";
        $del_stmt = $this->conn->prepare($query);
        return $del_stmt->execute();
    }
}
?>


<?php

$db = new Database($_ENV['DB_DNS'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
$record_id = $db->insert("users", ["firstname" => 'Alaa',"lastname" => 'Kamal',"gender" => "female", "email" => "alaa@cloud.com", "password" => "123456789"]);
print_r($db->select("users"));
echo $db->update("users", $record_id, ["firstname" => "lolo"]);
echo $db->delete('users', $record_id);
