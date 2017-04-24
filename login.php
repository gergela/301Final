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

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.blue_grey-amber.min.css" />
    <link rel="stylesheet" href="css/custom.css"/>


    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</head>
<body>
<section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp question-section mdl-cell--8-col mdl-cell--6-col-tablet">
    <div class="mdl-cell mdl-cell--12-col mdl-shadow--4dp mdl-card">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text">Login</h2>
        </div>
        <form method="POST">
            <div class="mdl-card__supporting-text enable-overflow">
                <div class="form-element mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="display: block;">
                    <input type="text" name="username" class="mdl-textfield__input" value="" />
                    <label class="mdl-textfield__label">Username:</label>
                </div>
                <div class="form-element mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="display: block;">
                    <input type="password" name="password" class="mdl-textfield__input" value="" />
                    <label class="mdl-textfield__label">Password:</label>
                </div>
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <input type="submit" value="Log In" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"/>
                <a href="userform.php?action=add"<button  class="mdl-button mdl-js-button mdl-js-ripple-effect"/>Register</button></a>
            </div>
        </form>

    </div>
</section>
</div>
</body>
</html>