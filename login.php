<?php
/**
 * Created by PhpStorm.
 * User: gergela1
 * Date: 4/23/17
 * Time: 12:39 AM
 */

include('config.php');

// If form submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get username and password from the form as variables
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query records that have usernames and passwords that match those in the customers table
    $sql = file_get_contents('sql/attemptLogin.sql');
    $params = array(
        'username' => $username,
        'password' => $password
    );
    $statement = $database->prepare($sql);
    $statement->execute($params);
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);
    echo $users[0];
    // If $users is not empty
    if(!empty($users)) {
        // Set $user equal to the first result of $users
        $user = $users[0];

        // Set a session variable with a key of customerID equal to the customerID returned
        $_SESSION['userID'] = $user['user_id'];

        // Redirect to the index.php file
        header('location: index.php');
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Login</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="SitePoint">

    <link rel="stylesheet" href="css/style.css">

    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->
</head>
<body>
<div class="page">
    <h1>Login</h1>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" />
        <input type="password" name="password" placeholder="Password" />
        <input type="submit" value="Log In" />
    </form>
</div>
</body>
</html>