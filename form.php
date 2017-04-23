<?php
/**
 * Created by PhpStorm.
 * User: gergela1
 * Date: 4/23/17
 * Time: 12:58 AM
 */

include('config.php');

$action = $_GET['action'];



//// If book isbn is not empty, get book record into $book variable from the database
////     Set $book equal to the first book in $books
//// 	   Set $book_categories equal to a list of categories associated to a book from the database
//if(!empty($isbn)) {
//    $sql = file_get_contents('sql/getBook.sql');
//    $params = array(
//        'isbn' => $isbn
//    );
//    $statement = $database->prepare($sql);
//    $statement->execute($params);
//    $books = $statement->fetchAll(PDO::FETCH_ASSOC);
//
//    $book = $books[0];
//
//    // Get book categories
//    $sql = file_get_contents('sql/getBookCategories.sql');
//    $params = array(
//        'isbn' => $isbn
//    );
//    $statement = $database->prepare($sql);
//    $statement->execute($params);
//    $book_categories_associative = $statement->fetchAll(PDO::FETCH_ASSOC);
//
//    foreach($book_categories_associative as $category) {
//        $book_categories[] = $category['categoryid'];
//    }
//}
//
//// Get an associative array of categories
//$sql = file_get_contents('sql/getCategories.sql');
//$statement = $database->prepare($sql);
//$statement->execute();
//$categories = $statement->fetchAll(PDO::FETCH_ASSOC);


$sectionCount = 1;

if((isset($_GET['portfolio']))&& (action == 'edit')) {
    $portfolio = $_GET['portfolio'];
}

// If form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isbn = $_POST['isbn'];
    $title = $_POST['book-title'];
    $book_categories = $_POST['book-category'];
    $author = $_POST['book-author'];
    $price = $_POST['book-price'];

    if($action == 'add') {
        // Insert book
        $sql = file_get_contents('sql/insertBook.sql');
        $params = array(
            'isbn' => $isbn,
            'title' => $title,
            'author' => $author,
            'price' => $price
        );

        $statement = $database->prepare($sql);
        $statement->execute($params);

        // Set categories for book
        $sql = file_get_contents('sql/insertBookCategory.sql');
        $statement = $database->prepare($sql);

        foreach($book_categories as $category) {
            $params = array(
                'isbn' => $isbn,
                'categoryid' => $category
            );
            $statement->execute($params);
        }
    }

    elseif ($action == 'edit') {
        $sql = file_get_contents('sql/updateBook.sql');
        $params = array(
            'isbn' => $isbn,
            'title' => $title,
            'author' => $author,
            'price' => $price
        );

        $statement = $database->prepare($sql);
        $statement->execute($params);

        //remove current category info
        $sql = file_get_contents('sql/removeCategories.sql');
        $params = array(
            'isbn' => $isbn
        );

        $statement = $database->prepare($sql);
        $statement->execute($params);

        //set categories for book
        $sql = file_get_contents('sql/insertBookCategory.sql');
        $statement = $database->prepare($sql);

        foreach($book_categories as $category) {
            $params = array(
                'isbn' => $isbn,
                'categoryid' => $category
            );
            $statement->execute($params);
        };
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

    <title>Manage Book</title>
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
                    <h2 class="mdl-card__title-text">Edit $portfolio.getPortfolioName()</h2>
                <?php endif; ?>
            </div>
            <div class="mdl-card__supporting-text enable-overflow">

                <form action="" method="POST">
                    <h4>Section 1</h4>

                    <div class="form-element">
                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="is-active1">
                            <input type="checkbox" id="is-active1" name="isactive1" value="true" class="mdl-checkbox__input">
                            <span class="mdl-checkbox__label">Use section 1?</span>
                        </label>
                    </div>

                    <div class="form-element mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input type="text" name="sectionName1" class="mdl-textfield__input" value="" />
                        <label class="mdl-textfield__label">Section Name:</label>
                    </div>

                    <div class="form-element mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input type="text" name="featuredImageURL1" class="mdl-textfield__input" value="" />
                        <label class="mdl-textfield__label">URL for featured image:</label>
                    </div>

                    <div class="form-element mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input type="text" name="contentImageURL1" class="mdl-textfield__input" value="" />
                        <label class="mdl-textfield__label">URL for content image:</label>
                    </div>

                    <div class="mdl-textfield mdl-js-textfield fullwidth">
                        <textarea class="mdl-textfield__input" rows="10" name="portfolio1"></textarea>
                        <label class="mdl-textfield__label">Content:</label>
                    </div>

                    <h4>Section 2</h4>

                    <div class="form-element">
                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="is-active2">
                            <input type="checkbox" id="is-active2" name="isactive2" value="true" class="mdl-checkbox__input">
                            <span class="mdl-checkbox__label">Use section 2?</span>
                        </label>
                    </div>
                    <div class="form-element mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input type="text" name="sectionName2" class="mdl-textfield__input" value="" />
                        <label class="mdl-textfield__label">Section Name:</label>
                    </div>

                    <div class="form-element mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input type="text" name="featuredImageURL2" class="mdl-textfield__input" value="" />
                        <label class="mdl-textfield__label">URL for featured image:</label>
                    </div>

                    <div class="form-element mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input type="text" name="contentImageURL2" class="mdl-textfield__input" value="" />
                        <label class="mdl-textfield__label">URL for content image:</label>
                    </div>

                    <div class="mdl-textfield mdl-js-textfield fullwidth">
                        <textarea class="mdl-textfield__input" rows="10" name="portfolio2"></textarea>
                        <label class="mdl-textfield__label">Section Content:</label>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <input type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" />&nbsp;
                        <input type="reset" class="mdl-button mdl-js-button mdl-js-ripple-effect" />
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
