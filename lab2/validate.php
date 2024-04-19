<?php

$errors = [];
$old_data = [];

if (empty($_POST["firstname"])) {
    $errors["firstname"] = "First Name is required";
} else {
    $old_data['firstname'] = $_POST["firstname"];
}

if (empty($_POST["lastname"])) {
    $errors["lastname"] = "Last Name is required";
} else {
    $old_data['lastname'] = $_POST["lastname"];
}

if (empty($_POST["email"])) {
    $errors["email"] = "Email is required";
} else {
    $old_data['email'] = $_POST["email"];
}

if (empty($_POST["gender"])) {
    $errors["gender"] = "Gender is required";
} else {
    $old_data['gender'] = $_POST["gender"];
}

if (empty($_POST["password"])) {
    $errors['password'] = "Password is required";
}

if (count($errors)) {
    $errors = json_encode($errors);
    $old_data = json_encode($old_data);
    $url = (!empty($old_data)) ? "errors={$errors}&old_data={$old_data}" : "errors={$errors}";
    header("Location: register.php?{$url}");
} else {
    $data = json_encode($_POST);
    $res = save_data($data . PHP_EOL, "customers.txt");
    if ($res) {
        echo "<h1>Users Data</h1>";
        display_data_in_table("customers.txt");
    } else {
        echo "<h1>Error saving data</h1>";
    }
}

function save_data($data, $filename) {
    $fileobj = fopen($filename, "a");
    $res = fwrite($fileobj, $data);
    fclose($fileobj);
    return $res;
}

function display_data_in_table($filename) {
    echo "<table class='table'> <tr> <th>First Name</th> <th>Last Name</th> <th>Email</th> <th>Gender</th></tr>";
    $file_data = file($filename);
    foreach ($file_data as $line) {
        $info = json_decode($line, true);
        echo "<tr>";
        echo "<td>{$info['firstname']}</td>";
        echo "<td>{$info['lastname']}</td>";
        echo "<td>{$info['email']}</td>";
        echo "<td>{$info['gender']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>
