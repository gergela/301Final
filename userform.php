<?php
/**
 * Created by PhpStorm.
 * User: gergela1
 * Date: 4/24/17
 * Time: 1:02 AM
 */

include('config.php');

$action = $_GET['action'];

// If form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $jobTitle = $_POST['job_title'];
    $bio = $_POST['bio'];

    if($action == 'add') {

        $sql = file_get_contents('sql/insertUser.sql');
        $params = array(
            'username' => $username,
            'password' => $password,
            'name' => $name,
            'job_title' => $jobTitle
        );

        $statement = $database->prepare($sql);
        $statement->execute($params);

        $sql = file_get_contents('sql/insertBio.sql');
        $params = array(
            'userID' => $_SESSION['userID'],
            'bio' => $bio
        );

        $statement = $database->prepare($sql);
        $statement->execute($params);
    }

    elseif ($action == 'edit') {

        $sql = file_get_contents('sql/updateUser.sql');
        $params = array(
            'userID' => $_SESSION["userID"],
            'name' => $name,
            'job_title' => $jobTitle
        );

        $statement = $database->prepare($sql);
        $statement->execute($params);
    }

    // Redirect to book listing page
    header('location: index.php');
}

// In the HTML, if an edit form:
// Populate textboxes with current data of book selected
// Print the checkbox with the book's current categories already checked (selected)
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Manage Portfolio</title>
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
<div class="mdl-grid">
    <div class="mdl-cell--3-col mdl-cell--hide-tablet"></div>
    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-shadow--4dp mdl-card enable-overflow">
        <div class="mdl-card__title">
            <?php if($action == 'add') : ?>
                <h2 class="mdl-card__title-text">Registeration</h2>
            <?php else : ?>
                <h2 class="mdl-card__title-text">Edit Profile</h2>
            <?php endif; ?>
        </div>
        <div class="mdl-card__supporting-text enable-overflow">

            <form action="" method="POST">
                <div class="form-element mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="display: block;">
                    <input type="text" name="name" class="mdl-textfield__input" value="<?php if($action == 'edit') echo $user->getName() ?>" />
                    <label class="mdl-textfield__label">Name:</label>
                </div>

                <div class="form-element mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="display: block;">
                    <input type="text" name="job_title" class="mdl-textfield__input" value="<?php if($action == 'edit') echo $user->getTitle() ?>" />
                    <label class="mdl-textfield__label">Job Title:</label>
                </div>

                <?php if($action == 'add'): ?>
                    <div class="mdl-textfield mdl-js-textfield fullwidth">
                        <textarea class="mdl-textfield__input" rows="10" name="bio"></textarea>
                        <label class="mdl-textfield__label">Bio:</label>
                    </div>

                    <div class="form-element mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="display: block;">
                        <input type="text" name="username" class="mdl-textfield__input" value="" />
                        <label class="mdl-textfield__label">Username:</label>
                    </div>
                    <div class="form-element mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="display: block;">
                        <input type="password" name="password" class="mdl-textfield__input" value="" />
                        <label class="mdl-textfield__label">Password:</label>
                    </div>
                <?php endif; ?>
                <div class="mdl-card__actions mdl-card--border">
                    <input type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" />&nbsp;
                    <input type="reset" class="mdl-button mdl-js-button mdl-js-ripple-effect" />
                    <a href="index.php"<button  class="mdl-button mdl-js-button mdl-js-ripple-effect"/>Cancel</button></a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

</body>
</html>