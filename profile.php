<!-- https://bbbootstrap.com/snippets/social-profile-container-63944396 -->
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

  $sql="select * from passenger NATURAL join passenger_addr WHERE pid=$pid";
  $result=mysqli_query($conn,$sql);
  if($result)
  {
      $row=mysqli_fetch_assoc($result);
  }

  $sql2="select * from passenger_phone where pid=$pid";
  $result2=mysqli_query($conn,$sql2);
  if($result2)
  {
    $i=0;
    while($row2=mysqli_fetch_assoc($result2))
    {
        $phno[$i++]=$row2['phno'];
    }
  }
}
else if(isset($_SESSION['did']))
{
  $did=$_SESSION['did'];

  $sql="select * from driver where did=$did";
  $result=mysqli_query($conn,$sql);
  if($result)
  {
      $row=mysqli_fetch_assoc($result);
  }

  $sql2="select * from driver_phone where did=$did";
  $result2=mysqli_query($conn,$sql2);
  if($result2)
  {
    $i=0;
    while($row2=mysqli_fetch_assoc($result2))
    {
        $phno[$i++]=$row2['phno'];
    }
  }
}

if(isset($_POST['add_phone']))
{
    if(empty(trim($_POST['new_phone'])) || strlen(trim($_POST['new_phone'])) != 10)
    {
        $_SESSION['err']= "Invalid phone number!";
        header("location: profile.php");
        return;
    }
    else
    {
        $phone=trim($_POST['new_phone']);
        if(isset($pid)){
            $sql_phone="INSERT INTO `passenger_phone` (`pid`, `phno`) VALUES ('$pid', '$phone');";
            $result=mysqli_query($conn,$sql_phone);
            if($result){
                header("location: profile.php");
                return;
            }
        }
        else if(isset($did)){
            $sql_phone="insert into driver_phone values ($did,$phone)";
            $result=mysqli_query($conn,$sql_phone);
            if($result){
                header("location: profile.php");
                return;
            }
        }
    }
}

if(isset($_POST['deleteAcc']))
{
    if(isset($_POST['pid']))
    {
        $sql2="delete from passenger where pid=".$_POST['pid'];
        $result2=mysqli_query($conn,$sql2);
        if($result2)
        {
            header("location: logout.php");
        }
        else
        {
            echo "err --> ".mysqli_error($conn);
        }
    }
    else if(isset($_POST['did']))
    {
        $sql2="delete from driver where did=".$_POST['did'];
        $result2=mysqli_query($conn,$sql2);
        if($result2)
        {
            header("location: logout.php");
        }
        else
        {
            // $_SESSION['err']="Cannot process your request right now. Please try again after sometime.";
            echo "err --> ".mysqli_error($conn);
        }
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <style>
    body {
        background: -webkit-linear-gradient(top, #ff9191, #ffdf5d);
        height: 100vh;
    }
    </style>

    <title>Profile Page - <?php echo $_SESSION['username'] ?></title>
</head>

<body>
    <?php require "partials/_nav.php"?>

    <div class="container text-center mx-auto my-5 p-5">
        <div class="profile-img mb-2">
            <img src="img/profile1.png" width="170em" height="150em" alt="User profile pic">
        </div>
        <?php
            if(isset($pid)){
            ?>
        <p class="h5"><strong>Name:</strong> <?php echo $row['fname']." ".$row['lname'] ?></p>
        <p class="h5"><strong>Email:</strong> <?=$row['email']?></p>
        <p class="h5"><strong>Contact No.:</strong>
            <?php
                foreach($phno as $no)
                {
                    echo $no." | ";
                }
                ?>
            <button class="btn" onclick="createNewElement();" data-toggle="tooltip" data-placement="bottom"
                title="Add new phone number"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                    fill="currentColor" class="bi bi-plus-square text-primary" viewBox="0 0 16 16">
                    <path
                        d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                </svg></button>
            <?php
                if(isset($_SESSION['err'])){
                    echo "<p class='text-danger'>".$_SESSION['err']."</p>";
                    unset($_SESSION['err']);
                }
                ?>
        <div id="newElementId"></div>
        </p>
        <br>

        <p class="h5"><strong>Date of birth:</strong> <?=$row['dob']?></p>
        <p class="h5"><strong>Address:</strong> <?php echo $row['city'].", ".$row['state'] ?></p>

        <?php } else if(isset($did)){?>

        <p class="h5"><strong>Name:</strong> <?php echo $row['fname']." ".$row['lname'] ?></p>
        <p class="h5"><strong>Username:</strong> <?=$row['username']?></p>
        <p class="h5"><strong>Contact No.:</strong>
            <?php
                foreach($phno as $no)
                {
                    echo $no." | ";
                }
                ?>
            <button class="btn" onclick="createNewElement();" data-toggle="tooltip" data-placement="bottom"
                title="Add new phone number"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                    fill="currentColor" class="bi bi-plus-square text-primary" viewBox="0 0 16 16">
                    <path
                        d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                </svg></button>
            <?php
                if(isset($_SESSION['err'])){
                    echo "<p class='text-danger'>".$_SESSION['err']."</p>";
                    unset($_SESSION['err']);
                }
                ?>
        <div id="newElementId"></div>
        </p>
        <p class="h5"><strong>Vehicle details:</strong>
            <?php echo $row['vehicle_no']." (".$row['vehicle_type'].")" ?></p>
        <p class="h5"><strong>Experience:</strong> <?=$row['yr_exp']?> years</p>
        <?php } ?>

        <!-- Button delete account modal -->
        <button type="button" class="btn btn-danger mt-3" data-toggle="modal" data-target="#exampleModal">
            Delete My Account
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z" />
            </svg>
        </button>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete your account?</p>
                    <small>We are sorry to see you go!</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    <form action="#" method="post">
                        <?php if(isset($pid)) { ?>
                        <input type="hidden" name="pid" value="<?=$pid?>">
                        <?php } else if(isset($did)) { ?>
                        <input type="hidden" name="did" value="<?=$did?>">
                        <?php } ?>
                        <button type="submit" class="btn btn-danger" name="deleteAcc">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <script type="text/JavaScript">
        function createNewElement() {
        // First create a DIV element.
        var txtNewInputBox = document.createElement('div');

        // Then add the content (a new input box) of the element.
        var new_content="<form action='#' method='post' id='phone_form'>Enter new phone number: <input type='number' name='new_phone' id='phone'><button type='submit' name='add_phone' class='btn'><svg width='22' height='22' fill='currentColor' class='bi bi-check2 text-success' viewBox='0 0 16 16'><path d='M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z' /></svg></button><button class='btn' onclick='hide_form();'><svg width='24' height='24' fill='currentColor' class='bi bi-x text-danger' viewBox='0 0 16 16'><path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z' /></svg></button></form>";

        txtNewInputBox.innerHTML = new_content;

        // Finally put it where it is supposed to appear.
        document.getElementById("newElementId").appendChild(txtNewInputBox);
    }

    function hide_form() {
        form_phone=document.getElementById('phone_form');
        form_phone.style.display="none";
        console.log("hidden")
    }
</script>

</body>

</html>