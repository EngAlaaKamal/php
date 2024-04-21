<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ?>
    <?php
    session_start();

    if(!$_SESSION['email']){
        header('Location:./login.php');
        die();
    }

    function getLoggedUser(): ?object
    {
        $users = file('customers.txt');
        foreach ($users as $user) {
            $user = json_decode($user);
            if ($user->email === $_SESSION['email']) {
                return $user;
            }
        }
        return null;
    }

    $user = getLoggedUser();

    if(!$user){
        header('Location: ./login.php');
        die();
    }

    echo "<h1>Welcome Home, {$user->firstname}</h1>";
    ?>

    <p><a href="./logout.php" class="link-danger">Log Out</a></p>


</body>

</html>