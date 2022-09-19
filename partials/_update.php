<?php
require "_config.php";
session_start();
if(isset($_GET['book_id']))
{
    $book_id=$_GET['book_id'];
    $stmt="select * from booking where book_id=$book_id";
    $response=mysqli_query($conn,$stmt);
    if($response)
    {
        $row=mysqli_fetch_assoc($response);
        $pick_up=$row['pick_up'];
        $drop_loc=$row['drop_loc'];
        $no_ppl=$row['no_ppl'];
        $date=$row['date'];
        $time=$row['time'];
    }
    else
    {
        echo "Cannot fetch data. Try after sometime.";
        header("Refresh:2; url=../booking_hist.php");
    }
}
else
{
    header("location: ../booking_hist.php");
}

if(isset($_POST['submit']))
{
    if((isset($_POST['date']) || isset($_POST['time'])) && ($_POST['date']!="" && $_POST['time']!=""))
    {
        $new_date=$_POST['date'];
        $new_time=$_POST['time'];
        $sql="update booking set date='$new_date', time='$new_time' where book_id=$book_id";
        $result=mysqli_query($conn,$sql);
        if($result)
        {
            echo '<p style="color:green">Update successful</p>';
            header("Refresh:1; url=../booking_hist.php");

        }
    }
    else
    {
        echo "<p style='color:red'>Please select new date or time</p>";
    }
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

    <title>Reschedule booking</title>
</head>

<body>
    <div class="m-3">
        <h4>Reschedule booking</h4>
        <hr>
        <form action="#" method="post">
            <label for="pickup">Pick up location:</label>
            <input type="text" name="pickup" id="pickup" value="<?=$pick_up?>" disabled>
            <label for="drop">Drop location:</label>
            <input type="text" name="drop" id="drop" value="<?=$drop_loc?>" disabled>
            <br>
            <label for="drop">Number of people:</label>
            <input type="text" name="no_ppl" id="drop" value="<?=$no_ppl?>" disabled>
            <hr>
            <label for="drop">Date:</label>
            <input type="date" name="date" id="drop" value="<?=$date?>">
            <br>
            <label for="drop">Time:</label>
            <input type="time" name="time" id="drop" value="<?=$time?>" >
            <br>
            <button class="btn btn-primary" name="submit">Confirm</button>
        </form>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
</body>

</html>