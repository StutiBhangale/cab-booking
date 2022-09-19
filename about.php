<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/about.css">
</head>

<body>
  <?php require"partials/_nav.php"?>

    <div class="about-section w-100">
        <h1 class="my-2">About Us</h1>
        <p>Cab-X is an application designed for your comfort so that you can travel distances in a much safe way.</p>
        <p>Our main aim is provide our users daily comfort with high safety standarads. Here safety, comfort and budget
            go hand in hand. Hope you enjoy our rides..</p>
    </div>

    <hr>
    <h2 class="text-center my-2">Our Team</h2>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card m-2">
                    <img src="img/about1.jpg" alt="Our Drivers" class="w-100 aboutimg">
                    <div class="container">
                        <h2>Our Drivers</h2>
                        <p class="text-muted">Drivers</p>
                        <p>Happy Drivers make happy Customers. Best service in city.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <img src="img/about2.jpg" alt="Customers" class="w-100 aboutimg">
                    <div class="container">
                        <h2>Our Customers</h2>
                        <p class="text-muted">Customers</p>
                        <p>Our users trust us because we provide them with quality service.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <img src="img/about3.jpg" alt="Developers" class="w-100 aboutimg">
                    <div class="container">
                        <h2>Our Developer Team</h2>
                        <p class="text-muted">Developers</p>
                        <p>Our developers work very hard to make your trip the best everytime.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require"partials/_footer.php"?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>

</html>