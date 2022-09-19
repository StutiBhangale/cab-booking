<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login']!=true)
{
    $loggedin=false;
}
else
{
    $loggedin=true;
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">

    <title>CabX - Get There Now!</title>
</head>

<body>
    <?php require "partials/_nav.php" ?>

    <!-- // carousel -->
    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active" data-interval="3000">
                <img src="img/slider1.jpg" class="d-block w-100" alt="slider1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>CabX - Get There Now!</h5>
                    <p>The best cab services in town. You can always rely on us.</p>
                </div>
            </div>
            <div class="carousel-item" data-interval="3000">
                <img src="img/slider2.jpg" class="d-block w-100" alt="slider2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>CabX - Get There Now!</h5>
                    <p>Book a cab of your choice and travel wherever you want.</p>
                </div>
            </div>
            <div class="carousel-item" data-interval="3000">
                <img src="img/slider3.jpg" class="d-block w-100" alt="slider3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>CabX - Get There Now!</h5>
                    <p>Get outstation cabs easily with CabX.</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- banner -->
    <?php if(!$loggedin && !$driver_login) { ?>
    <div class="bg-secondary my-3 p-2">
        <div class="text-center text-light">
            <h1>We are hiring.</h1>
            <p>Be a part of our driver community.</p>
            <p>Work with us and earn upto Rs.30000 per month</p>
            <a href="register.php" class="btn btn-info">Apply Now</a>
        </div>
    </div>
    <?php } ?>

    <!-- cards -->
    <hr class="my-5" id="services">
    <h2 class="text-center my-3">Our services</h2>
    <div class="my-3 mx-auto container mycards">
        <div class="box card p-1">
            <img src="img/card1.jpg" class="img1" alt="auto">
            <h3>Get an Auto at your doorstep</h3>
            <p>
                The all too familiar auto ride, minus the hassle of waiting and haggling for price. A convenient way
                to travel everyday.Verified drivers, an emergency alert button, and live ride tracking are some of
                the features that we have in place to ensure you a safe travel experience.
            </p>
            <a href="booking.php" class="btn btn-outline-danger">Book Now</a>
        </div>
        <div class="box card p-1">
            <img src="img/card2.jpg" class="img1" alt="Booking">
            <h3>Book a Cab</h3>
            <p>
                The perfect way to get through your everyday travel needs. City taxis are available 24/7 and you can
                book and travel in an instant. With rides starting from as low as Rs. 6/km, you can choose from a
                wide range of options! You can also opt to do your bit for the environment with Ola Share! Quick and
                safe rides.
            </p>
            <a href="booking.php" class="btn btn-outline-danger">Book Now</a>
        </div>
        <div class="box p-1">
            <img src="img/card3.jpg" class="img1" alt="Outstation">
            <h3>Outstation</h3>
            <p>
                Ride out of town at affordable one-way and round-trip fares with Ola’s intercity travel service.
                Choose from a range of AC cabs driven by top partners, available in 1 hour or book upto 7 days in
                advance. We have you covered across India with presence in 90+ cities with over 500 one way routes.
            </p>
            <a href="about.php" class="btn btn-outline-danger">Know More</a>
        </div>
    </div>

    <?php require "partials/_footer.php" ?>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

</body>

</html>