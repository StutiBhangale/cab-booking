<?php
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
    <title>Contact</title>
</head>

<body>
    <?php require "partials/_nav.php"?>
    <div class="container my-3">
        <h3>Contact:</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php
    //   SELECT fname,lname,phno from driver,driver_phone,view_books where driver.did=driver_phone.did and driver.did=view_books.did
    $sql="SELECT DISTINCT pid,contact.did,fname,lname,phno from driver,driver_phone,contact where driver.did=driver_phone.did and driver.did=contact.did and contact.pid=$pid";
    //   $sql="select * from contact";
      $result=mysqli_query($conn,$sql);
      if($result)
      {
        $i=1;
        while($row=mysqli_fetch_assoc($result))
        {
            echo '<tr>
            <th scope="row">'.$i++.'</th>
            <td>'.$row["fname"].' '.$row["lname"].'</td>
            <td>'.$row["phno"].'</td>
          </tr>';
        }
      }
    ?>
            </tbody>
        </table>
    </div>

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

</body>

</html>