<!-- https://bootsnipp.com/snippets/vl4R7 -->
<?php
require "partials/_config.php";

$err="";
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(isset($_POST['usertype']) && $_POST['usertype'] == 'passenger')
    {
        if(isset($_POST['e_user']) && isset($_POST['password']))
        {
            $email = trim($_POST['e_user']);
            $pass = trim($_POST['password']);
            // $hash = password_hash($pass,PASSWORD_DEFAULT);
            $sql1="SELECT * FROM `passenger` WHERE email='$email'";
            $result1=mysqli_query($conn,$sql1);
            $row=mysqli_fetch_assoc($result1);
            if(mysqli_num_rows($result1) == 1)
            {
                if(password_verify($pass,$row['password']))
                {
                    session_start();
                    $_SESSION['login']=true;
                    $_SESSION['pid']=$row['pid'];
                    $_SESSION['email']=$row['email'];
                    $_SESSION['username']=$row['fname'];
                    // echo $_SESSION['pid'];
                    // echo " Session has started";
                    header("location: index.php");
                }
                else
                {
                    $err.="Incorrect password. ";
                }
            }
            else
            {
                $err.="Invalid credentials. ";
            }
        }
    }
    else if(isset($_POST['usertype']) && $_POST['usertype'] == 'driver')
    {
        if(isset($_POST['e_user']) && isset($_POST['password']))
        {
            $username = trim($_POST['e_user']);
            $pass = trim($_POST['password']);
            $sql2="SELECT * FROM `driver` WHERE username='$username'";
            $result2=mysqli_query($conn,$sql2);
            $row=mysqli_fetch_assoc($result2);
            if(mysqli_num_rows($result2) == 1)
            {
                if(password_verify($pass,$row['password']))
                {
                    session_start();
                    $_SESSION['login']=true;
                    $_SESSION['did']=$row['did'];
                    $_SESSION['username']=$row['username'];
                    // $_SESSION['fname']=$row['fname'];
                    // echo $_SESSION['pid'];
                    // echo " Session has started";
                    header("location: index.php");
                }
                else
                {
                    $err.="Incorrect password. ";
                }
            }
            else
            {
                $err.="Invalid credentials. ";
            }
        }
    }
    else
    {
        $err .="Please select user type. ";
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

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/login.css">

    <title>CabX - Login</title>
</head>

<body>
    <?php require "partials/_nav.php";
    if($err != "")
    {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Error!! </strong>$err
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
        </div>";
    }
    ?>

    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>Log In</h3>
                </div>
                <div class="card-body">
                    <form action="#" method="post">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="e_user" class="form-control" placeholder="Email or username">
                        </div>

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        
                        <div class="d-block remember">Choose user type</div>
                        <div class="form-check form-check-inline remember">
                            <input class="form-check-input" type="radio" name="usertype" id="inlineRadio1"
                                value="passenger">
                            <label class="form-check-label" for="inlineRadio1">Passenger</label>
                        </div>
                        <div class="form-check form-check-inline remember">
                            <input class="form-check-input" type="radio" name="usertype" id="inlineRadio2"
                                value="driver">
                            <label class="form-check-label" for="inlineRadio2">Driver</label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn mt-4 login_btn">Login</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        Don't have an account?<a href="register.php">Sign Up</a>
                    </div>
                    <!-- <div class="d-flex justify-content-center">
                        <a href="#">Forgot your password?</a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <?php require"partials/_footer.php"?>

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