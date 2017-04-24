<?php
/**
 * Created by PhpStorm.
 * User: gergela1
 * Date: 4/23/17
 * Time: 12:58 AM
 */

include('config.php');

$action = $_GET['action'];

$sectionCount = 1;
$portfolio = new Portfolio();

if(isset($_GET['portfolioID'])) {
    $portfolioID = $_GET['portfolioID'];
    $sql = file_get_contents('sql/getPortfolio.sql');
    $params = array(
        'portfolioID' => $portfolioID
    );
    $statement = $database->prepare($sql);
    $statement->execute($params);
    $portfolios = $statement->fetchAll(PDO::FETCH_ASSOC);
    $portfolio = $portfolios[0];
    $portfolio = $portfolio['portfolio_object'];
    $portfolio = unserialize($portfolio);
}

// If form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $portfolioName = $_POST['portfolioName'];

    $isActive1 = $_POST['isActive1'];
    $sectionName1 = $_POST['sectionName1'];
    $featuredImageURL1 = $_POST['featuredImageURL1'];
    $contentImageURL1 = $_POST['contentImageURL1'];
    $sectionContent1 = $_POST['sectionContent1'];

    $isActive2 = $_POST['isActive2'];
    $sectionName2 = $_POST['sectionName2'];
    $featuredImageURL2 = $_POST['featuredImageURL2'];
    $contentImageURL2 = $_POST['contentImageURL2'];
    $sectionContent2 = $_POST['sectionContent2'];

    if($action == 'add') {
        $portfolio = new Portfolio();
        $portfolio->updateUserInfo($database);
        $portfolio->addSection($sectionName1,$featuredImageURL1,$sectionContent1,$contentImageURL1,1, $isActive1);
        $portfolio->addSection($sectionName2,$featuredImageURL2,$sectionContent2,$contentImageURL2,2, $isActive2);
        $portfolio->setPortfolioName($portfolioName);
        // Insert portfolio
        $sql = file_get_contents('sql/insertPortfolio.sql');
        $params = array(
            'portfolio' => serialize($portfolio),
            'userID' => $_SESSION['userID'],
            'portfolioName' => $portfolioName
        );

        $statement = $database->prepare($sql);
        $statement->execute($params);
    }

    elseif ($action == 'edit') {
        $portfolio = new Portfolio();

        $portfolioName = $_POST['portfolioName'];

        $isActive1 = $_POST['isActive1'];
        $sectionName1 = $_POST['sectionName1'];
        $featuredImageURL1 = $_POST['featuredImageURL1'];
        $contentImageURL1 = $_POST['contentImageURL1'];
        $sectionContent1 = $_POST['sectionContent1'];

        $isActive2 = $_POST['isActive2'];
        $sectionName2 = $_POST['sectionName2'];
        $featuredImageURL2 = $_POST['featuredImageURL2'];
        $contentImageURL2 = $_POST['contentImageURL2'];
        $sectionContent2 = $_POST['sectionContent2'];

        $portfolio->updateUserInfo($database);
        $portfolio->addSection($sectionName1,$featuredImageURL1,$sectionContent1,$contentImageURL1,1, $isActive1);
        $portfolio->addSection($sectionName2,$featuredImageURL2,$sectionContent2,$contentImageURL2,2, $isActive2);
        $portfolio->setPortfolioName($portfolioName);

        $sql = file_get_contents('sql/updatePortfolio.sql');
        $params = array(
            'portfolioID' => $_GET['portfolioID'],
            'portfolio' => serialize($portfolio),
            'portfolioName' => $portfolioName
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
                    <h2 class="mdl-card__title-text">New Portfolio</h2>
                <?php else : ?>
                    <h2 class="mdl-card__title-text">Edit <?php echo $portfolio->getPortfolioName() ?></h2>
                <?php endif; ?>
            </div>
            <div class="mdl-card__supporting-text enable-overflow">

                <form action="" method="POST">
                    <div class="form-element mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="display: block;">
                        <input type="text" name="portfolioName" class="mdl-textfield__input" value="<?php echo $portfolio->getPortfolioName() ?>" />
                        <label class="mdl-textfield__label">Portfolio name:</label>
                    </div>

                    <h4>Section 1</h4>

                    <div class="form-element">
                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="is-active1">
                            <input type="checkbox" id="is-active1" name="isActive1" value="true" class="mdl-checkbox__input" <?php if($portfolio->getSections()[1]['isActive']=="true") echo "checked" ?>>
                            <span class="mdl-checkbox__label">Use section 1?</span>
                        </label>
                    </div>

                    <div class="form-element mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="display: block;">
                        <input type="text" name="sectionName1" class="mdl-textfield__input" value="<?php echo $portfolio->getSections()[1]['sectionTitle'] ?>" />
                        <label class="mdl-textfield__label">Section Name:</label>
                    </div>

                    <div class="form-element mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input type="text" name="featuredImageURL1" class="mdl-textfield__input" value="<?php echo $portfolio->getSections()[1]['featuredImage']?>" />
                        <label class="mdl-textfield__label">URL for featured image:</label>
                    </div>

                    <div class="form-element mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input type="text" name="contentImageURL1" class="mdl-textfield__input" value="<?php echo $portfolio->getSections()[1]['image'] ?>" />
                        <label class="mdl-textfield__label">URL for content image:</label>
                    </div>

                    <div class="mdl-textfield mdl-js-textfield fullwidth">
                        <textarea class="mdl-textfield__input" rows="10" name="sectionContent1"><?php echo $portfolio->getSections()[1]['text'] ?></textarea>
                        <label class="mdl-textfield__label">Content:</label>
                    </div>

                    <h4>Section 2</h4>

                    <div class="form-element">
                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="is-active2">
                            <input type="checkbox" id="is-active2" name="isActive2" value="true" class="mdl-checkbox__input" <?php if($portfolio->getSections()[2]['isActive']=="true") echo "checked" ?>>
                            <span class="mdl-checkbox__label">Use section 2?</span>
                        </label>
                    </div>
                    <div class="form-element mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="display: block;">
                        <input type="text" name="sectionName2" class="mdl-textfield__input" value="<?php echo $portfolio->getSections()[2]['sectionTitle'] ?>" />
                        <label class="mdl-textfield__label">Section Name:</label>
                    </div>

                    <div class="form-element mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input type="text" name="featuredImageURL2" class="mdl-textfield__input" value="<?php echo $portfolio->getSections()[2]['featuredImage']?>" />
                        <label class="mdl-textfield__label">URL for featured image:</label>
                    </div>

                    <div class="form-element mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input type="text" name="contentImageURL2" class="mdl-textfield__input" value="<?php echo $portfolio->getSections()[2]['image'] ?>" />
                        <label class="mdl-textfield__label">URL for content image:</label>
                    </div>

                    <div class="mdl-textfield mdl-js-textfield fullwidth">
                        <textarea class="mdl-textfield__input" rows="10" name="sectionContent2"><?php echo $portfolio->getSections()[2]['text'] ?></textarea>
                        <label class="mdl-textfield__label">Section Content:</label>
                    </div>
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

    <!--    <script>-->
    <!--        var sectionCount = 1;-->
    <!--        function addSection() {-->
    <!--            sectionCount++;-->
    <!--            $(".portfolio-form").append(-->
    <!--                "<div class='form-element'>"+-->
    <!--                    "<label>Section Name "+ sectionCount +":</label>"+-->
    <!--                    "<input type='text' name='section"+ sectionCount +"' class='textbox' value='' />"+-->
    <!--                "</div>"+-->
    <!--                "<div class='form-element'>"+-->
    <!--                    "<label>Section "+ sectionCount +":</label>"+-->
    <!--                    "<textarea rows='10' cols='40' name='portfolio"+ sectionCount +"'>"+-->
    <!--                    "</textarea>"+-->
    <!--                "</div>"-->
    <!--            )-->
    <!--        }-->
    <!---->
    <!--        $( ".section-add" ).click(function() {-->
    <!--            addSection();-->
    <!--        });-->
    <!--    </script>-->
</body>
</html>
