<?php

require "partials/_config.php";
require "partials/_calculate_distance.php";

session_start();
if(!isset($_SESSION['login']) || $_SESSION['login'] != true)
{
    header("location: login.php");
}
else
{
    $pid=$_SESSION['pid'];
}

$stmt="CALL `getcity`();";
$result12=mysqli_query($conn,$stmt);
$i=0;
while($entry=mysqli_fetch_assoc($result12))
{
    $cities[$i++]=$entry;
}

while(mysqli_next_result($conn)){;}

if(isset($_POST['submit']))
{
    if(isset($_POST['pickup']) && isset($_POST['drop']) && isset($_POST['mydate']) && isset($_POST['mytime']))
    {
        $pickup=$_POST['pickup'];
        $drop_loc=$_POST['drop'];
        foreach($cities as $c)
        {
            if($c['city']==$pickup)
            {
                $lat1=$c['latitude'];
            }
            if($c['city']==$drop_loc)
            {
                $lat2=$c['latitude'];
            }
        }
        $lat1=explode(",",$lat1);
        $lat2=explode(",",$lat2);
        $km=distance($lat1[0],$lat1[1],$lat2[0],$lat2[1]);
        $people=$_POST['no_ppl'];
        $selected_time=$_POST['mytime'];

        $today=date_create(date("Y-m-d"));
        $mydate=date_create($_POST['mydate']);
        $diff=date_diff($today,$mydate);
        $d= $diff->format("%R%a days");
        // booking should be done 1 day prior and also only within next 30 days
        if($d>=0 && $d<30)
        {
            $selected_date=$_POST['mydate'];

            $_SESSION['pick']=$pickup;
            $_SESSION['drop']=$drop_loc;
            $_SESSION['km']=$km;
            $_SESSION['no_ppl']=$people;
            $_SESSION['date']=$selected_date;
            $_SESSION['time']=$selected_time;

            // header("location:choose_car.php?pick=".$pickup."&drop=".$drop_loc."&km=".$km."&no_ppl=".$people."&date=".$selected_date."&time=".$selected_time);
            header("location: choose_car.php");
        }
        else
        {
            $_SESSION['err']="Please select a valid date";
            header("location: booking.php");
            return;
        }
    }
    else
    {
        $_SESSION['err'].="All fields are required";
        header("location: booking.php");
        return;
    }
}
// if($_SERVER['REQUEST_METHOD'] == 'POST')
// {
//     if(isset($_POST['pickup']) && isset($_POST['drop']) && isset($_POST['mydate']) && isset($_POST['mytime']))
//     {
//         $pickup=$_POST['pickup'];
//         $drop_loc=$_POST['drop'];
//         $people=$_POST['no_ppl'];
//         $selected_time=$_POST['mytime'];

//         if(isset($_POST['mydate']))
//         {
//             $today=date_create(date("Y-m-d"));
//             $mydate=date_create($_POST['mydate']);
//             $diff=date_diff($today,$mydate);
//             $d= $diff->format("%R%a days");
//             // booking should be done 1 day prior and also only within next 30 days
//             if($d>=0 && $d<30)
//             {
//                 $selected_date=$_POST['mydate'];
//                 $sql="INSERT INTO `booking` ( `pid`, `pick_up`, `drop_loc`, `no_ppl`, `date`, `time`, `status`) VALUES ('$pid', '$pickup', '$drop_loc', '$people', '$selected_date', '$selected_time', 'Applied')";
//                 $result=mysqli_query($conn,$sql);
//                 if($result)
//                 {
//                     $stmt="SELECT CURRENT_DATE() as cd";
//                     // echo $stmt;
//                     $response=mysqli_query($conn,$stmt);
//                     echo var_dump($response);
//                     $row=mysqli_fetch_assoc($response);
//                     echo var_dump($row);
//                     $current_date=$row['cd'];
//                     echo $current_date;

//                     $sql2="SELECT book_id FROM `booking` WHERE pid=$pid and pick_up='$pickup' AND drop_loc='$drop_loc' AND booked_at='$current_date'";
//                     $result2=mysqli_query($conn,$sql2);
                    
//                     $row2=mysqli_fetch_assoc($result2);
//                     $bid=$row2['book_id'];
//                     $row3=mysqli_num_rows($result2);
//                     if($row3==1)
//                     {
//                         header("Refresh:1; url=payment.php?book_id=".$bid);
//                     }
//                     else
//                     {
//                         $stmt="delete from booking where book_id=".$bid;
//                     }
//                 }
//                 else
//                 {
//                     $err.="Sorry for inconvinience. We cannot process your request right now. ".mysqli_error($conn);
//                 }
//             }
//             else
//             {
//                 $err.="Please select a valid date. ";
//             }
//         }
//     }
//     else
//     {
//         $err.="Please fill all the fields. ";
//     }
// }

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
</head>

<body>

    <?php require "partials/_nav.php";
    if(isset($_SESSION['err']))
    {
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
        <strong>Error! </strong>".$_SESSION['err']."
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button>
        </div>";
        unset($_SESSION['err']);
    }
    ?>

    <!-- booking form -->
    <div class="container my-3 p-2 border">
        <h3 class="mb-2">Book your Cab here</h3>
        <hr>
        <form action="#" method="post">
            <div class="form-group">
                <label for="validationCustom04">Pickup Location</label>
                <select name="pickup" class="custom-select" id="validationCustom04">
                    <option selected disabled>Choose</option>
                    <?php
                        foreach($cities as $city)
                        {
                            echo '<option value="'.$city['city'].'">'.$city['city'].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="validationCustom05">Drop Location</label>
                <select name="drop" class="custom-select" id="validationCustom05">
                    <option selected disabled>Choose</option>
                    <?php
                        foreach($cities as $city)
                        {
                            echo '<option value="'.$city['city'].'">'.$city['city'].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Select number of people</label>
                <select name="no_ppl" class="form-control" id="exampleFormControlSelect1">
                    <option selected value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="row my-3">
                <div class="col-lg-6">
                    <label>Date</label>
                    <input type="date" name="mydate" class="form-control" id="datetimepicker"
                        placeholder="Choose a date">
                </div>
                <div class="col-lg-6">
                    <label for="validationCustom02">Time</label>
                    <input name="mytime" type="time" class="form-control" id="validationCustom02">
                </div>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Proceed <svg xmlns="http://www.w3.org/2000/svg"
                    width="25" height="25" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                </svg></button>
        </form>
    </div>
    <!-- booking form end -->

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