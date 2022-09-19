<?php
// select booking.book_id,pick_up,drop_loc,date,time,amount,method from booking,payment where booking.book_id=payment.book_id and pid=107;
// SELECT fname,pick_up,drop_loc,no_ppl,date,time,status from passenger,booking where passenger.pid=booking.pid

require "partials/_config.php";
session_start();

if(!isset($_SESSION['login']) || $_SESSION['login'] != true)
{
    header("location: login.php");
}
else if(isset($_SESSION['pid']))
{
  $pid=$_SESSION['pid'];
}
else if(isset($_SESSION['did']))
{
  $did=$_SESSION['did'];
}

if(isset($_POST['edit']))
{
  $book_id=$_POST['book_id'];
  header("location: partials/_update.php?book_id=".$book_id);
}

// if(isset($_POST['deleted']))
// {
//   $book_id=$_POST['book_id'];
//   $sql="delete from booking where book_id=".$book_id;
//   $result=mysqli_query($conn,$sql);
//   if($result)
//   {
//     echo "Booking deleted successfully!";
//   }
// }

if(isset($_GET['delete']))
{
    $sno=$_GET['delete'];
    // echo $sno;
    $sql1="delete from booking where book_id=".$sno;
    $result1=mysqli_query($conn,$sql1);
    if($result1)
    {
        $deleted=true;
        header("location:booking_hist.php");
        return;
    }
    else
    {
      echo "Cannot process your request right now. ".mysqli_error($conn);
    }
}

if(isset($_POST['accept']))
{
  $book_id=$_POST['book_id'];
  $p2="call accept_booking($book_id,$did)";
  $r2=mysqli_query($conn,$p2);
  if($r2)
  {
    echo "added";
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
    <link rel="stylesheet" href="css/styles.css">

    <?php
    if(isset($pid))
    {
      echo'<title>Bookings for '.$_SESSION['username'] .'</title>';
    }
    else
    {
      echo '<title>Bookings</title>';
    }
    ?>
</head>

<body>
    <?php require "partials/_nav.php";
    
    if(isset($pid))
    {
    ?>

    <div class="container-fluid my-2">
        <h3>Booking details</h3>
        <table class="table table-sm table-bordered table-hover my-2">
            <thead class="table-info">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Start</th>
                    <th scope="col">End</th>
                    <th scope="col">Date - time</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Method</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql="select booking.book_id,pick_up,drop_loc,date,time,status,amount,method from booking,payment where booking.book_id=payment.book_id and pid=".$pid;
                $result=mysqli_query($conn,$sql);
                $i=1;
                while($row=mysqli_fetch_assoc($result))
                {
                  echo '<tr>
                    <th scope="row">'.$i++.'</th>
                    <td>'.$row["pick_up"].'</td>
                    <td>'.$row["drop_loc"].'</td>
                    <td>'.$row["date"].' - '.$row["time"].'</td>
                    <td>'.$row["amount"].'</td>
                    <td>'.$row["method"].'</td>
                    <td>'.$row["status"].'</td>
                    <td>
                      <form action="#" method="post" class="d-inline">
                        <input type="hidden" name="book_id" value='.$row["book_id"].'>
                        <button class="btn btn-sm btn-primary" name="edit">Edit</button>
                        
                      </form>
                      <button class="delete btn btn-sm btn-danger" id=d'.$row["book_id"].'>Delete</button>
                    </td>
                  </tr>';
                }
                ?>
            </tbody>
        </table>
        <!-- <small class="text-muted">Clicking on Cancel button will directly cancel your booking.</small> -->
    </div>
    <!-- <button class="btn btn-sm btn-danger delete" name="deleted">Cancel</button> -->
    <?php
    }
    else
    {
    ?>

    <div class="container-fluid my-2">
        <h3>Bookings</h3>
        <table class="table table-sm table-bordered table-hover my-2">
            <thead class="table-warning">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Start</th>
                    <th scope="col">End</th>
                    <th scope="col">Date - time</th>
                    <th scope="col">Number of people</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql="SELECT fname,lname,book_id,pick_up,drop_loc,no_ppl,date,time,status from passenger,booking where passenger.pid=booking.pid and status='applied'";
                $result=mysqli_query($conn,$sql);
                $i=1;
                while($row=mysqli_fetch_assoc($result))
                {
                  echo '<tr>
                    <th scope="row">'.$i++.'</th>
                    <td>'.$row["fname"].' '.$row["lname"].'</td>
                    <td>'.$row["pick_up"].'</td>
                    <td>'.$row["drop_loc"].'</td>
                    <td>'.$row["date"].' - '.$row["time"].'</td>
                    <td>'.$row["no_ppl"].'</td>
                    <td>'.$row["status"].'</td>
                    <td>
                      <form action="#" method="post">
                        <input type="hidden" name="book_id" value='.$row["book_id"].'>
                        <button class="btn btn-sm btn-outline-primary" name="accept">Accept</button>
                      </form>
                    </td>
                  </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="container-fluid my-2">
        <h3>Accepted Bookings</h3>
        <table class="table table table-bordered table-hover my-2">
            <thead class="table-info">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Start</th>
                    <th scope="col">End</th>
                    <th scope="col">Number of people</th>
                    <th scope="col">Date - time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // $sql="select * from view_books where did=$did";
                // SELECT view_books.book_id,pick_up,drop_loc,no_ppl FROM `view_books`,booking where did=201 and view_books.book_id=booking.book_id
                $sql="SELECT pick_up,drop_loc,no_ppl,date,time FROM `view_books`,booking where did=$did and view_books.book_id=booking.book_id and status='accepted'";

                $result=mysqli_query($conn,$sql);
                $i=1;
                while($row=mysqli_fetch_assoc($result))
                {
                  echo '<tr>
                    <th scope="row">'.$i++.'</th>
                    <td>'.$row["pick_up"].'</td>
                    <td>'.$row["drop_loc"].'</td>
                    <td>'.$row["no_ppl"].'</td>
                    <td>'.$row["date"].' - '.$row["time"].'</td>
                  </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
    }
    ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <script>
    deletes = document.getElementsByClassName("delete");
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            sno = e.target.id.substr(1, );

            if (confirm("Are you sure you want to delete this booking?")) {
                console.log("yes");
                window.location = `/cab booking/booking_hist.php?delete=${sno}`;
            } else {
                console.log("No");
            }
        })
    })
    </script>
</body>

</html>