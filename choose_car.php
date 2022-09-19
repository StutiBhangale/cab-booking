<?php
require "partials/_config.php";
session_start();
$sql1='SELECT * FROM cars';
$result1=mysqli_query($conn,$sql1);
if($result1)
{
    $i=0;
    while($row=mysqli_fetch_assoc($result1))
    {
        $cars[$i++]=$row;
    }
}

if(isset($_SESSION['pick'])&&isset($_SESSION['drop'])&&isset($_SESSION['km'])&&isset($_SESSION['no_ppl'])&&isset($_SESSION['date'])&&isset($_SESSION['time'])&&isset($_SESSION['pid']))
{
    $pid=$_SESSION['pid'];
    $pickup=$_SESSION['pick'];
    $drop_loc=$_SESSION['drop'];
    $km=$_SESSION['km'];
    $people=$_SESSION['no_ppl'];
    $selected_date=$_SESSION['date'];
    $selected_time=$_SESSION['time'];
}
else
{
    header("location: booking.php");
    return;
}

if(isset($_POST['choose']))
{
    $car_id=$_POST['car_id'];
    $car_type=$_POST['car_type'];

    $sql="INSERT INTO `booking` ( `pid`, `car_id`, `pick_up`, `drop_loc`, `no_ppl`, `date`, `time`, `status`) VALUES ('$pid', '$car_id', '$pickup', '$drop_loc', '$people', '$selected_date', '$selected_time', 'Applied')";
    $result=mysqli_query($conn,$sql);
    if($result)
    {
        unset($_SESSION['pick']);
        unset($_SESSION['drop']);
        unset($_SESSION['no_ppl']);
        unset($_SESSION['date']);
        unset($_SESSION['time']);

        $stmt="SELECT CURRENT_DATE() as cd";
        $response=mysqli_query($conn,$stmt);
        $row=mysqli_fetch_assoc($response);
        $current_date=$row['cd'];
        $sql2="SELECT book_id FROM `booking` WHERE pid=$pid and car_id=$car_id and pick_up='$pickup' AND drop_loc='$drop_loc' AND booked_at='$current_date'";
        $result2=mysqli_query($conn,$sql2);
        
        $row2=mysqli_fetch_assoc($result2);
        $bid=$row2['book_id'];
        $row3=mysqli_num_rows($result2);
        if($row3==1)
        {
            if($car_type == "Mini")
            {
                $amnt=$km*6;
            }
            else if($car_type == "Sedan")
            {
                $amnt=$km*8;
            }
            else if($car_type == "SUV")
            {
                $amnt=$km*10;
            }
            $_SESSION['amnt']=intval($amnt);
            unset($_SESSION['km']);
            header("Refresh:1; url=payment.php?book_id=".$bid);
        }
        else
        {
            $stmt="delete from booking where book_id=".$bid;
        }
    }
    else
    {
        $err.="Sorry for inconvinience. We cannot process your request right now. ".mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,  
        initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        background: #f1f1f1;
        background: url('img/car1.gif') no-repeat fixed center/cover;
        /* background-image: url('img/car2.webp'); */
        /* background-repeat: no-repeat; */
        /* background-attachment: fixed; */
        /* background-size: cover; */
    }

    .collapse {
        /* background-color:#f5f6fa; */
        background-color: #dcdde1;
    }

    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }

    .box:hover {
        transform: scale(1.03);
        transition: 0.5s;
        box-shadow: 0 5px 5px rgba(245, 182, 182, 0.514);
        /* box-shadow: 0 5px 5px rgba(0, 0, 0, .5); */
    }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center text-white mb-4 mt-2">Choose your car</h2>
        <div class="accordion m-auto w-75" id="accordionExample">
            <!-- menu 1 -->
            <div class="card mx-auto my-2">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-block text-center" type="button" data-toggle="collapse"
                            data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Mini
                        </button>
                    </h2>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="container my-2">
                        <div class="row justify-content-center">
                            <?php
                            foreach($cars as $mini)
                            {
                                if($mini['type'] == "Mini")
                                {
                                    echo '<div class="card col-md-3 mt-1 box m-2 text-center border border-secondary overflow-hidden"
                                    style="width: 10rem;height:12rem">
                                    <img src="img/cars/'.$mini['model'].'.jpg" alt="'.$mini['model'].'" width="150px" height="100px">
                                    <div class="card-body">
                                    <h6 class="Model-title">'.$mini['model'].'</h6>
                                    <form action="#" method="post">
                                        <input type="hidden" name="car_id" value="'.$mini['car_id'].'">
                                        <input type="hidden" name="car_type" value="'.$mini['type'].'">
                                        <button type="submit" class="btn btn-outline-danger" name="choose">Choose</button>
                                    </form>
                                    </div>
                                    </div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- menu 2 -->
            <div class="card mx-auto my-2">
                <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                        <button class="btn btn-block text-center collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Sedan
                        </button>
                    </h2>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="container my-2">
                        <div class="row justify-content-center">
                            <?php
                            foreach($cars as $mini)
                            {
                                if($mini['type'] == "Sedan")
                                {
                                    echo '<div class="card col-md-3 mt-1 box m-2 text-center border border-secondary overflow-hidden"
                                    style="width: 10rem;height:12rem">
                                    <img src="img/cars/'.$mini['model'].'.jpg" alt="'.$mini['model'].'" width="150px" height="100px">
                                    <div class="card-body">
                                    <h6 class="Model-title">'.$mini['model'].'</h6>
                                    <form action="#" method="post">
                                        <input type="hidden" name="car_id" value="'.$mini['car_id'].'">
                                        <input type="hidden" name="car_type" value="'.$mini['type'].'">
                                        <button type="submit" class="btn btn-outline-danger" name="choose">Choose</button>
                                    </form>
                                    </div>
                                    </div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- menu 3  -->
            <div class="card mx-auto">
                <div class="card-header" id="headingThree">
                    <h2 class="mb-0">
                        <button class="btn btn-block text-center collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            SUV
                        </button>
                    </h2>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="container my-2">
                        <div class="row justify-content-center">
                            <?php
                            foreach($cars as $mini)
                            {
                                if($mini['type'] == "SUV")
                                {
                                    echo '<div class="card col-md-3 mt-1 box m-2 text-center border border-secondary overflow-hidden"
                                    style="width: 10rem;height:12rem">
                                    <img src="img/cars/'.$mini['model'].'.jpg" alt="'.$mini['model'].'" width="150px" height="100px">
                                    <div class="card-body">
                                    <h6 class="Model-title">'.$mini['model'].'</h6>
                                    <form action="#" method="post">
                                        <input type="hidden" name="car_id" value="'.$mini['car_id'].'">
                                        <input type="hidden" name="car_type" value="'.$mini['type'].'">
                                        <button type="submit" class="btn btn-outline-danger" name="choose">Choose</button>
                                    </form>
                                    </div>
                                    </div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center m-3">
            <small><strong>Note: </strong>Select a car based on the number of people.</small>
            <p>Don't want to book now?<a href="index.php">Cancel here.</a></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

</body>

</html>

<!-- <div class="row box my-2 p-2 border border-dark rounded bg-light">
    <div class="col-6">
        <img src="../img/cab.jpg" class="rounded" width="340" height="160" alt="">
    </div>
    <div class="col-3 m-auto">
        <p>Lorem ipsum dolor sit.</p>
    </div>
    <div class="col-3 m-auto"><a href="#" class="btn btn-outline-danger">Choose</a></div>
</div> -->