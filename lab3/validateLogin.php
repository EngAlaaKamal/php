 <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>

<?php
function checkUsersExists($email, $password)
{
    $users = file('customers.txt');
    foreach ($users as $user) {
        
        $user = json_decode($user);
        if ($user->email === $_POST['email'] && $user->password === $_POST['password']) {
            return true;
        }
    }

    return false;
}

if (checkUsersExists($_POST['email'], $_POST['password'])) {
    session_start();
    $_SESSION["email"] = $_POST["email"];
    header('Location: ./home.php?');
    die();
}else{}

echo "Not a valid user";
echo "</br>";
echo "<a href='./userForm.php'>register now</a>";
?>