<?php
/**
 * Created by PhpStorm.
 * User: gergela1
 * Date: 4/23/17
 * Time: 12:53 AM
 */

include('config.php');

// Get search term from URL using the get function
$term = get('search-term');
$portfolios = searchUserPortfolios($term, $database, $_SESSION["userID"]);

$sql = file_get_contents('sql/getBio.sql');
$params = array(
    'userid' => $_SESSION['userID']
);
$statement = $database->prepare($sql);
$statement->execute($params);
$bios = $statement->fetchAll(PDO::FETCH_ASSOC);
if(isset($bios[0])){
    $bio = $bios[0];
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Profile</title>
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
            <h2 class="mdl-card__title-text">Profile  <a href="userform.php?action=edit"><i class="material-icons">mode_edit</i></a></h2>
            <form method="GET">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable" style="position: absolute;right: 10px;top: 40px;">
                    <label class="mdl-button mdl-js-button mdl-button--icon" for="sample6">
                        <i class="material-icons">search</i>
                    </label>
                    <div class="mdl-textfield__expandable-holder">
                        <input class="mdl-textfield__input" name="search-term" type="text" id="sample6">
                        <label class="mdl-textfield__label" for="sample-expandable">Expandable Input</label>
                    </div>
                </div>
            </form>
        </div>
        <div class="mdl-card__supporting-text enable-overflow">
            <div class="page compressed-lines">
                <?php if(isset($bio['bio'])): ?>
                    <h4>Bio</h4>
                    <hr>
                    <p><?php echo $bio['bio'] ?></p>
                    <h4>Portfolios</h4>
                    <hr>
                <?php endif; ?>
                <?php foreach($portfolios as $portfolio) : ?>
                    <p>
                        <a href="viewportfolio.php?portfolioID=<?php echo $portfolio['ID'] ?>" class="basic-link" target="_blank"><?php echo $portfolio['portfolio_name']; ?> </a>
                        <a href="form.php?action=edit&portfolioID=<?php echo $portfolio['ID'] ?>"><i class="material-icons" style="font-size: 14px;">mode_edit</i></a>
                        <br />
                        <small>Created by: <?php echo $user->getName(); ?><br /></small>
                    </p>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="mdl-card__actions mdl-card--border">
            <a href="form.php?action=add"<button  class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"/>Create Portfolio</button></a>
            <a href="viewall.php"<button  class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"/>View All Portfolios</button></a>
            <a href="logout.php"<button  class="mdl-button mdl-js-button mdl-js-ripple-effect"/>Logout</button></a>
        </div>
    </div>
</section>
</body>
</html>
