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
    echo $conn->errorInfo() . PHP_EOL;
    exit('Failed retrieve user info' . PHP_EOL);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1> Register an account </h1>
    <form action=<?php echo "./edit_user.php?id={$user->id}"?> method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="exampleInputFirstname" class="form-label">First Name</label>
            <input type="text" name="firstname" class="form-control" id="exampleInputFirstname"
                   value="<?php echo isset($old_data['firstname']) ? $old_data['firstname'] : ''; ?>">
            <label style="color: red; font-weight: bold">
                <?php echo isset($errors['firstname']) ? $errors['firstname'] : ''; ?>
            </label>
        </div>
        <div class="mb-3">
            <label for="exampleInputLastname" class="form-label">Last Name</label>
            <input type="text" name="lastname" class="form-control" id="exampleInputLastname"
                   value="<?php echo isset($old_data['lastname']) ? $old_data['lastname'] : ''; ?>">
            <label style="color: red; font-weight: bold">
                <?php echo isset($errors['lastname']) ? $errors['lastname'] : ''; ?>
            </label>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail"
                   value="<?php echo isset($old_data['email']) ? $old_data['email'] : ''; ?>">
            <label style="color: red; font-weight: bold">
                <?php echo isset($errors['email']) ? $errors['email'] : ''; ?>
            </label>
        </div>
        <div class="mb-3">
            <label for="exampleInputGender" class="form-label">Gender</label>
            <select class="form-select" name="gender" id="exampleInputGender">
                <option value="male" <?php echo (isset($old_data['gender']) && $old_data['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                <option value="female" <?php echo (isset($old_data['gender']) && $old_data['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
            </select>
            <label style="color: red; font-weight: bold">
                <?php echo isset($errors['gender']) ? $errors['gender'] : ''; ?>
            </label>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword">
            <label style="color: red; font-weight: bold">
                <?php echo isset($errors['password']) ? $errors['password'] : ''; ?>
            </label>
        </div>
        <div class="mb-3">
                <label for="formFile" class="form-label">Profile Picture</label>
                <input class="form-control" name="image" type="file" id="formFile">
            </div>


        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>