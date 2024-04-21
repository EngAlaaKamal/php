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
    move_uploaded_file($_FILES['image']['tmp_name'], "images/" . $_FILES['image']['name']);
    $_POST['imageURL'] = "images/" . $_FILES['image']['name'];
    $data = json_encode($_POST);
    save_data($data . PHP_EOL, "customers.txt");
}

 

function save_data($data, $filename) {
    $fileobj = fopen($filename, "a");
    $res = fwrite($fileobj, $data);
    fclose($fileobj);
    header(
        'Location: ./login.php'
    );
}

 
