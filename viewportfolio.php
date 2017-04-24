<?php
include('config.php');


$portfolioID = $_GET['portfolioID'];

// Query records that have usernames and passwords that match those in the customers table
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

$portfolio->updateUserInfo($database);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <link rel="stylesheet" href="./css/swiper.css">
    <link href="./css/bootstrap.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./css/main.css">

    <!-- <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans" rel="stylesheet"> -->

</head>
<body>
    <image src="./images/WebHeader.png" class="header-image" id="Page-Top">
    <div class="header-name"><?php echo $portfolio->getName() ?></div>
    <div class="header-title"><?php echo $portfolio->getTitle() ?></div>
    <div class="intro-div">
      <image src="./images/WebFooter.png" class="footer-image">
      <div class="swiper-container">
          <div class="swiper-wrapper">
            <?php if ($portfolio->getSections()[1]['isActive']== 'true'): ?>

                <div class="swiper-slide">
                    <img src="<?php echo $portfolio->getSections()[1]['featuredImage']?>" class="slide-image-crop" onclick="$.scrollTo('#1', { duration: 300 })">
                    <div class="hover-slide"onclick="$.scrollTo('#1', { duration: 300 })"><span><?php echo $portfolio->getSections()[1]['sectionTitle'] ?></span>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($portfolio->getSections()[2]['isActive']== 'true'): ?>
                <div class="swiper-slide">
                    <img src="<?php echo $portfolio->getSections()[2]['featuredImage']?>" class="slide-image-crop" onclick="$.scrollTo('#2', { duration: 300 })">
                    <div class="hover-slide"onclick="$.scrollTo('#2', { duration: 300 })"><span><?php echo $portfolio->getSections()[2]['sectionTitle'] ?></span>
                    </div>
                </div>
            <?php endif; ?>

          </div>
          <div class="swiper-pagination"></div>
          <div class="swiper-button-prev"><i class="material-icons icon-prev">chevron_left</i></div>
          <div class="swiper-button-next"><i class="material-icons icon-next">chevron_right</i></div>
      </div>
    </div>
    <div>

        <?php if ($portfolio->getSections()[1]['isActive']== 'true'): ?>
            <div class="project-container">
                <div class="col-md-12 section-title" id="1"><?php echo $portfolio->getSections()[1]['sectionTitle'] ?></div>
                <div class="col-md-8 section-body">
                    <a href="<?php echo $portfolio->getSections()[1]['image'] ?>" target="_blank"><image src="<?php echo $portfolio->getSections()[1]['image'] ?>" class="img-responsive image-medium auto-margin"></a>
                </div>
                <div class="col-md-4 section-aside">
                    <p><?php echo $portfolio->getSections()[2]['text'] ?></p>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($portfolio->getSections()[2]['isActive']== 'true'): ?>
            <div class="project-container">
                <div class="col-md-12 section-title2" id="2"><?php echo $portfolio->getSections()[2]['sectionTitle'] ?></div>
                <div class="col-md-8 section-body">
                    <a href="<?php echo $portfolio->getSections()[2]['image'] ?>" target="_blank"><image src="<?php echo $portfolio->getSections()[2]['image'] ?>" class="img-responsive image-medium auto-margin"></a>
                </div>
                <div class="col-md-4 section-aside">
                    <p><?php echo $portfolio->getSections()[2]['text'] ?></p>
                </div>
            </div>
        <?php endif; ?>

    </div>
    <img src="./images/UpArrow.png" style="Position:fixed;bottom:20px;right:20px;" onclick=" $.scrollTo('#Page-Top', { duration: 300 })">
    <script src="./js/jquery-3.1.1.min.js"></script>
    <script src="./js/swiper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/jquery.scrollTo.min.js"></script>


    <script>
    var swiper = new Swiper('.swiper-container', {
        spaceBetween:30,
        pagination: '.swiper-pagination',
        // effect: 'coverflow',
        slidesPerView: 'auto',
        centeredSlides: true,
        paginationClickable: true,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        keyboardControl: true,
        mousewheelControl: true,
        mousewheelSensitivity:1,
        //mousewheelEventsTarged:'.swiper-mousezone',
        mousewheelForceToAxis:true,
        slideToClickedSlide:true,
        loop: true
        // coverflow: {
        //     rotate: 50,
        //     stretch: 0,
        //     depth: 100,
        //     modifier: 1,
        //     slideShadows : true
        // },
        //spaceBetween: 30
    });
    </script>
</body>
</html>
