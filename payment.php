<?php
// book_id, pid, pickup, drop, no_ppl, date-time, status
// 
require "partials/_config.php";

session_start();
if(!isset($_SESSION['login']) || $_SESSION['login'] != true)
{
    header("location: login.php");
}
else
{
    $pid=$_SESSION['pid'];
    // echo $pid;
}
if(!isset($_GET['book_id']))
{
    header("location: booking.php");
    return;
}

$err="";
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(isset($_POST['method']))
    {
        $amount=$_SESSION['amnt'];
        $book_id=$_GET['book_id'];
        $method=$_POST['method'];
        $sql="INSERT INTO `payment` (`book_id`, `method`, `amount`) VALUES ('$book_id', '$method', '$amount');";
        $result=mysqli_query($conn,$sql);
        if($result)
        {
            unset($_SESSION['amnt']);
            // header("Refresh:5; url=booking_hist.php");
            header("Refresh:1; url=partials/_spinner.php");
        }
        else
        {
            echo "err  ".mysqli_error($conn);
        }
    }
    else
    {
        $err.="Please select a payment method";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <link rel="stylesheet" href="css/styles.css">
    <title>CabX - Booking</title>
    <style>
    .method-img {
        width: 3rem;
        height: 3rem;
    }
    </style>
</head>

<body>
    <?php require"partials/_nav.php";
    if($err != "")
    {
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
        <strong>Error! </strong>".$err."
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
        </div>";
    }
    ?>

    <!-- payment form -->
    <div class="container my-3 p-2 border">
        <h3 class="mb-2">Payment Page</h3>
        <hr>
        <div class="jumbotron">
            <p class="lead d-inline">The amount for your ride is <span
                    class="font-weight-bold text-primary"><?php echo $_SESSION['amnt']?></span>. Please select payment
                method and
                confirm your booking now.</p>
            <hr class="my-4">
            <form action="#" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <input class="form-check-input" type="radio" name="method" value="Cash Payment">
                        <div class="border p-1">
                            <img src="img/cash.png" alt="" class="method-img">
                            <label class="form-check-label" for="inlineRadio1">Cash Payment</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input class="form-check-input" type="radio" name="method" value="Debit Card">
                        <div class="border p-1">
                            <img src="https://i.imgur.com/2ISgYja.png" alt="" class="method-img">
                            <label class="form-check-label" for="inlineRadio1">Debit Card</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input class="form-check-input" type="radio" name="method" value="Paytm">
                        <div class="border p-1">
                            <img src="https://i.imgur.com/7kQEsHU.png" alt="" class="method-img">
                            <label class="form-check-label" for="inlineRadio1">Paytm</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input class="form-check-input" type="radio" name="method" value="Netbanking">
                        <div class="border p-1">
                            <img src="img/net2.jpg" alt="" class="method-img">
                            <label class="form-check-label" for="inlineRadio1">Netbanking</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-2" name="submit">Pay Now</button>
            </form>
            <p class="my-4">We never share your account details with anyone.</p>
        </div>
    </div>
    <!-- payment form end -->

    <?php require"partials/_footer.php"?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>

</body>

</html>