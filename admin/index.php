<?php
session_start();
if(!isset($_SESSION['admin_login']))
{
    header("location: login.php");
}

require "../partials/_config.php";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
  $city=$_POST['city'];
  $state=$_POST['state'];
  $sql1="SELECT * FROM `passenger_addr` WHERE city='$city' and state='$state'";
  // echo $sql1;
  $result1=mysqli_query($conn,$sql1);
  if(mysqli_num_rows($result1) == 0)
  {
    $sql2="INSERT INTO `passenger_addr` ( `city`, `state`) VALUES ('$city', '$state')";
    $result2=mysqli_query($conn,$sql2);
    unset($city);
    unset($state);
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
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <title>Admin Panel</title>
</head>

<body>
    <div class="jumbotron jumbotron-fluid bg-dark text-light">
        <div class="container">
            <h2>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" heigth="24" fill="currentColor" class="bi bi-gear"
                    viewBox="0 0 16 17">
                    <path fill-rule="evenodd"
                        d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z" />
                    <path fill-rule="evenodd"
                        d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z" />
                </svg>
                CabX - Admin
            </h2>
            <!-- <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p> -->
            <p class="lead">The admin control panel settings only visible to the admin</p>
            <form action="logout.php" method="post">
                <button class="btn btn-outline-info" type="submit">Logout</button>
            </form>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <div class="list-group list-group-flush" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list"
                        href="#list-home" role="tab" aria-controls="home">Stats</a>
                    <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list"
                        href="#list-profile" role="tab" aria-controls="profile">Cities</a>
                    <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list"
                        href="#list-messages" role="tab" aria-controls="messages">Feedbacks</a>
                    <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list"
                        href="#list-settings" role="tab" aria-controls="settings">Bookings</a>
                    <a class="list-group-item list-group-item-action" id="list-payments-list" data-toggle="list"
                        href="#list-payments" role="tab" aria-controls="settings">Payments</a>
                </div>
            </div>
            <div class="col-9 border-left">
                <div class="tab-content" id="nav-tabContent">
                    <!-- stats -->
                    <div class="tab-pane fade show active" id="list-home" role="tabpanel"
                        aria-labelledby="list-home-list">
                        <div class="container my-1">
                            <div class="row d-flex justify-content-around">
                                <div class="col-md-3 border border-primary m-1 p-1">
                                    <div class="d-flex flex-column align-items-stretch bg-primary text-center">
                                        <p class="h2">
                                            <?php
                                            $f1="SELECT `total_passengers`() AS `tp`;";
                                            $r1=mysqli_query($conn,$f1);
                                            if($r1)
                                            {
                                                $row1=mysqli_fetch_assoc($r1);
                                                echo $row1['tp'];
                                            }
                                        ?>
                                        </p>
                                        <p>Total number of customers registered.</p>
                                    </div>
                                </div>
                                <div class="col-md-3 border border-success m-1 p-1">
                                    <div class="d-flex flex-column align-items-stretch bg-success text-center">
                                        <p class="h2">
                                            <?php
                                            $f2="SELECT `total_drivers`() AS `td`;";
                                            $r2=mysqli_query($conn,$f2);
                                            if($r2)
                                            {
                                                $row2=mysqli_fetch_assoc($r2);
                                                echo $row2['td'];
                                            }
                                        ?>
                                        </p>
                                        <p>Total number of employees working in CabX.</p>
                                    </div>
                                </div>
                                <div class="col-md-3 border border-info m-1 p-1">
                                    <div class="d-flex flex-column align-items-stretch bg-info text-center">
                                        <p class="h2">
                                            <?php
                                            $f3="SELECT `total_bookings`() AS `tb`;";
                                            $r3=mysqli_query($conn,$f3);
                                            if($r3)
                                            {
                                                $row3=mysqli_fetch_assoc($r3);
                                                echo $row3['tb'];
                                            }
                                        ?>
                                        </p>
                                        <p>Total number of bookings done done till date.</p>
                                    </div>
                                </div>
                                <div class="col-md-3 border border-warning m-1 p-1">
                                    <div class="d-flex flex-column align-items-stretch bg-warning text-center">
                                        <p class="h2">
                                            <?php
                                            $f4="SELECT `total_feedbacks`() AS `tf`;";
                                            $r4=mysqli_query($conn,$f4);
                                            if($r4)
                                            {
                                                $row4=mysqli_fetch_assoc($r4);
                                                echo $row4['tf'];
                                            }
                                        ?>
                                        </p>
                                        <p>Total valuable feedbacks in the system.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- cities -->
                    <div class="tab-pane fade show" id="list-profile" role="tabpanel"
                        aria-labelledby="list-profile-list">

                        <!-- Button trigger modal -->
                        <!-- <button type="button" class="btn btn-sm btn-primary mb-1" data-toggle="modal"
                            data-target="#exampleModal">
                            Add new city
                        </button> -->

                        <?php
                          $sql3 = 'select * from passenger_addr';
                          $result3 = mysqli_query($conn,$sql3);
                          echo '<table class="table">
                          <thead>
                            <tr class="table-info">
                              <th scope="col">Zip code</th>
                              <th scope="col">City</th>
                              <th scope="col">State</th>
                            </tr>
                          </thead>
                          <tbody>';
                          while($row = mysqli_fetch_assoc($result3))
                          {
                            echo '
                              <tr>
                                <th scope="row">'.$row['zip_id'].'</th>
                                <td>'.$row['city'].'</td>
                                <td>'.$row['state'].'</td>
                              </tr>';
                            }
                            echo '</tbody>
                          </table>';
                        ?>

                        <!-- Modal -->
                        <!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#" method="post">
                                            <div class="form-group">
                                                <label for="formGroupExampleInput">City</label>
                                                <input type="text" class="form-control" id="formGroupExampleInput"
                                                    placeholder="City" name="city">
                                            </div>
                                            <div class="form-group">
                                                <label for="formGroupExampleInput2">State</label>
                                                <input type="text" class="form-control" id="formGroupExampleInput2"
                                                    placeholder="State" name="state">
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div> -->
                    </div>

                    <!-- feedbacks -->
                    <div class="tab-pane fade show" id="list-messages" role="tabpanel"
                        aria-labelledby="list-messages-list">
                        <?php
                          $sql3 = 'select * from feedback';
                          $result3 = mysqli_query($conn,$sql3);
                          echo '<table class="table">
                          <thead>
                            <tr class="table-success">
                              <th scope="col">#</th>
                              <th scope="col">Rating</th>
                              <th scope="col">Message</th>
                            </tr>
                          </thead>
                          <tbody>';
                          $i=1;
                          while($row = mysqli_fetch_assoc($result3))
                          {
                            echo '
                              <tr>
                                <th scope="row">'.$i++.'</th>
                                <td>'.$row['rating'].'</td>
                                <td>'.$row['message'].'</td>
                              </tr>';
                            }
                            echo '</tbody>
                          </table>';
                        ?>
                    </div>

                    <!-- bookings -->
                    <div class="tab-pane fade show" id="list-settings" role="tabpanel"
                        aria-labelledby="list-settings-list">
                        <table class="table table-sm table-hover" id="myTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">From - To</th>
                                    <th scope="col">No ppl</th>
                                    <th scope="col">Datetime</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Booking date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                            $sql4="SELECT fname,lname,pick_up,drop_loc,no_ppl,date,time,status,booked_at from passenger,booking where passenger.pid=booking.pid";
                            $result4=mysqli_query($conn,$sql4);
                            if($result4)
                            {
                                $i=1;
                                while($row=mysqli_fetch_assoc($result4))
                                {
                                    echo "<tr>
                                    <th scope='row'>".$i++."</th>
                                    <td>".$row['fname']." ".$row['lname']."</td>
                                    <td>".$row['pick_up']." - ".$row['drop_loc']."</td>
                                    <td>".$row['no_ppl']."</td>
                                    <td>".$row['date']." - ".$row['time']."</td>
                                    <td>".$row['status']."</td>
                                    <td>".$row['booked_at']."</td>
                                    </tr>";
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- payments -->
                    <div class="tab-pane fade show" id="list-payments" role="tabpanel"
                        aria-labelledby="list-payments-list">
                        <?php
                        $sql='call get_payments()';
                        $i=0;
                        if (mysqli_multi_query($conn, $sql)){
                            do{
                                if ($result = mysqli_store_result($conn)){
                                    while ($row = mysqli_fetch_row($result)){
                                        if($row[0]!=NULL){
                                            $pay[$i++]=$row[0];
                                        }
                                        else{
                                            $pay[$i++]=0;
                                        }
                                    }
                                    mysqli_free_result($result);
                                }
                            }while (mysqli_next_result($conn));
                        }
                        ?>
                        <div class="row justify-content-center text-center">
                            <div class="col-md-3 m-2 p-2 bg-success">
                                <h2><?=$pay[0]?></h2>
                                <p>total amount overall</p>
                            </div>
                            <div class="col-md-3 m-2 p-2 bg-primary">
                                <h2><?=$pay[1]?></h2>
                                <p>total amount yearly</p>
                            </div>
                            <div class="col-md-3 m-2 p-2 bg-warning">
                                <h2><?=$pay[2]?></h2>
                                <p>total amount monthly</p>
                            </div>
                            <div class="col-md-3 m-2 p-2 bg-info">
                                <h2><?=$pay[3]?></h2>
                                <p>total amount today</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    </script>
</body>

</html>