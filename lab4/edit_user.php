 <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ?>

 <?php
    require "./db_connection.php";

    $get_user_stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $get_user_stmt->bindParam(':id', $_GET['id']);
    if (!$get_user_stmt->execute()) {
        echo $conn->errorInfo() . PHP_EOL;
        exit('Failed retrieve user info' . PHP_EOL);
    }

    $user = $get_user_stmt->fetchObject();
    if (!$user) {
        print_r($conn->errorInfo());
        exit('Failed retrieve user info' . PHP_EOL);
    }

    $edit_user_stmt = $conn->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email, gender = :gender,  password = :password,  image_url = :image_url WHERE id = {$user->id}");
    ?>
<?php
$errors = [];
$old_data = [];

if (empty($_POST["firstname"])) {
 
    $old_data['firstname'] = $_POST["firstname"];
}

if (empty($_POST["lastname"])) {
 
    $old_data['lastname'] = $_POST["lastname"];
}

if (empty($_POST["email"])) {
 
    $old_data['email'] = $_POST["email"];
}

if (empty($_POST["gender"])) {
 
    $old_data['gender'] = $_POST["gender"];
}



if (count($errors)) {
    $errors = json_encode($errors);
    $old_data = json_encode($old_data);
    $url = (!empty($old_data)) ? "errors={$errors}&old_data={$old_data}" : "errors={$errors}";
    header("Location: ./edit_user_form.php?{$url}");
} else {

    move_uploaded_file($_FILES['image']['tmp_name'], "./images/" . $_FILES['image']['name']);
    $_POST['imageURL'] = "./images/" . $_FILES['image']['name'];
    $data = json_encode($_POST);

    $edit_user_stmt->bindValue(
        ':firstname',
        $_POST['firstname'] ? $_POST['firstname'] : $user->firstname
    );
    $edit_user_stmt->bindValue(
        ':lastname',
        $_POST['lastname'] ? $_POST['lastname'] : $user->lastname
    );
    
    $edit_user_stmt->bindValue(
        ':email',
        $_POST['email'] ? $_POST['email'] : $user->email
    );
    $edit_user_stmt->bindValue(
        ':gender',
        $_POST['gender'] ? $_POST['gender'] : $user->gender
    );
    $edit_user_stmt->bindValue(
        ':password',
        $_POST['password'] ? $_POST['password'] : $user->password
    );
   
    $edit_user_stmt->bindValue(
        ':image_url',
        $_FILES['image'] ? $imageURL : $user->image_url
    );
    
    if ($edit_user_stmt->execute()) {
        header('Location: ./customers.php');
        die();
    }
    
    echo $conn->errorInfo();
    
}

?>