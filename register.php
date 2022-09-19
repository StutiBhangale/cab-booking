<!-- https://bootsnipp.com/snippets/dlZAN -->
<?php
require "partials/_config.php";

ob_start();
$err="";
$register=false;
if(isset($_POST['passengerRegister']))
{
    // Check for email
    if(empty(trim($_POST['email'])))
    {
        $err = "Email cannot be blank. ";
    }
    else
    {
        $mail=trim($_POST['email']);
        $sql1="SELECT * FROM passenger WHERE email='$mail'";
        $result1=mysqli_query($conn,$sql1);
        if(mysqli_num_rows($result1) == 1)
        {
            $err="Email already registered. ";
        }
        else
        {
            if(!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)){
                $err .= "Invalid Email. ";
            }
            else{
                $email=trim($_POST['email']);
            }
        }
    }

    // Check for password
    if(empty(trim($_POST['password'])))
    {
        $err.="Password cannot be blank. ";
    }
    else if(strlen(trim($_POST['password'])) < 4)
    {
        $err.="Password cannot be less than 4 characters. ";
    }
    else
    {
        $password=trim($_POST['password']);
    }

    // Check for confirm password
    if(trim($_POST['confirmpassword']) != $password)
    {
        $err.="Passwords do not match. ";
    }

    // Check for fname
    if (!preg_match("/^[a-zA-Z-']*$/",trim($_POST['fname'])) || empty(trim($_POST['fname']))) {
        $err .= "First name cannot be blank. Only letters are allowed in Name. ";
    }
    else
    {
        $fname=trim($_POST['fname']);
    }

    // Check for phone number
    if(empty(trim($_POST['phone'])) || strlen(trim($_POST['phone'])) != 10)
    {
        $err .= "Invalid phone number. ";
    }
    else
    {
        $phone=trim($_POST['phone']);
    }

    // Check for city
    if(isset($_POST['city']))
    {
        $zip=$_POST['city'];
    }

    // Get optional attributes
    $lname =trim($_POST['lname']);
    $dob =$_POST['dob'];

    if(isset($email)&&isset($password)&&isset($fname)&&isset($phone)&&isset($zip)&& $err == '')
    {
        $hash=password_hash($password, PASSWORD_DEFAULT);
        $sql1 = "INSERT INTO `passenger` (`email`, `password`, `fname`, `lname`, `dob`, `zip_id`, `created_at`) VALUES ('$email', '$hash', '$fname', '$lname', '$dob', '$zip', current_timestamp());";

        mysqli_query($conn,$sql1);
        
        $sql="SELECT * FROM `passenger` WHERE email='$email'";
        $result=mysqli_query($conn,$sql);
        $row=mysqli_fetch_assoc($result);

        $pid=$row['pid'];
        $sql2="INSERT INTO `passenger_phone` (`pid`, `phno`) VALUES ('$pid', '$phone');";
        mysqli_query($conn,$sql2);
        $register=true;
    }
}

if(isset($_POST['driverRegister']))
{
    // Check for username
    if(empty(trim($_POST['username'])))
    {
        $err = "Username cannot be blank. ";
    }
    else
    {
        $user=trim($_POST['username']);
        $sql1="SELECT * FROM driver WHERE username='$user'";
        $result1=mysqli_query($conn,$sql1);
        if(mysqli_num_rows($result1) == 1)
        {
            $err="Username already taken. ";
        }
        else
        {
            if(preg_match('/^\w{5,}$/', trim($_POST['username'])))
            {
                $username=trim($_POST['username']);
                echo $username;
            }
            else
            {
                $err = "Invalid username. ";
            }
        }
    }

    // Check for password
    if(empty(trim($_POST['password'])))
    {
        $err.="Password cannot be blank. ";
    }
    elseif(strlen(trim($_POST['password'])) < 4)
    {
        $err.="Password cannot be less than 4 characters. ";
    }
    else
    {
        $password=trim($_POST['password']);
        echo $password;
    }

    // Check for confirm password
    if(trim($_POST['confirmpassword']) != $password)
    {
        $err.="Passwords should match. ";
    }

    // Check for fname
    if (!preg_match("/^[a-zA-Z-']*$/",trim($_POST['fname'])) || empty(trim($_POST['fname']))) {
        $err .= "First name cannot be blank. Only letters are allowed in Name. ";
    }
    else
    {
        $fname=trim($_POST['fname']);
        echo $fname;
    }

    // Check for phone number
    if(empty(trim($_POST['phone'])) || strlen(trim($_POST['phone'])) != 10)
    {
        $err .= "Invalid phone number. ";
    }
    else
    {
        $phone=trim($_POST['phone']);
        echo $phone;
    }

    // Check for vehicle number
    // if (!preg_match("/^[A-Z]{2}-[0-9]{2}-[A-Z]{2}-[0-9]{4}$/",trim($_POST['vehicle_no'])) || empty(trim($_POST['vehicle_no']))) {
    //     $err .= "Invalid vehicle number. ";
    // }
    // else
    // {
    //     $vehicle_no=trim($_POST['vehicle_no']);
    // }

    // Get optional attibutes
    $lname =trim($_POST['lname']);
    $yr_exp =trim($_POST['yr_exp']);
    $type = $_POST['vehicle_type'];
    // echo $dob; // yyyy-mm-dd

    if(isset($username)&&isset($password)&&isset($fname)&&isset($phone)&& $err == '')
    {
        $hash=password_hash($password, PASSWORD_DEFAULT);
        $sql1 = "INSERT INTO `driver` (`username`, `password`, `fname`, `lname`, `yr_exp`, `vehicle_type`) VALUES ('$username', '$hash', '$fname', '$lname', '$yr_exp', '$type');";

        $result=mysqli_query($conn,$sql1);
        if($result)
        {
            $sql="SELECT * FROM `driver` WHERE username='$username'";
            $result=mysqli_query($conn,$sql);
            $row=mysqli_fetch_assoc($result);
            // echo var_dump($row);

            $did=$row['did'];
            $sql2="INSERT INTO `driver_phone` (`did`, `phno`) VALUES ('$did', '$phone');";
            mysqli_query($conn,$sql2);
            $register=true;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/register.css">
    <title>CabX - Register</title>
</head>

<body>
    <?php
    require"partials/_nav.php";
    if($err != "")
    {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Error!! </strong>$err
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
        </div>";
    }
    if($register)
    {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success </strong>Your account is created successfully. Redirecting you to login page.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
        </div>";
        header("Refresh:2; url=login.php");
    }
?>
    <div class="container register mt-1">
        <div class="row">
            <div class="col-md-3 register-left">
                <!-- <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt="" /> -->
                <img src="img/register1.png" alt="car" />
                <h3>Welcome</h3>
                <p>You are a few seconds away from booking your own cab!</p>
                <a href="login.php" class="btn bg-white rounded-pill my-4" style="width:8rem">Login</a>
            </div>

            <div class="col-md-9 register-right">
                <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">Passenger</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Driver</a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h3 class="register-heading">Register as a Passenger</h3>
                        <form action="#" method="post">
                            <div class="row register-form">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="fname" class="form-control" placeholder="First Name *"
                                            value="" />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="lname" class="form-control" placeholder="Last Name"
                                            value="" />
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Password *">
                                        <i class="far fa-eye" id="togglePassword"></i>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="confirmpassword" class="form-control"
                                            placeholder="Confirm Password *" value="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="Your Email *"
                                            value="" />
                                    </div>
                                    <div class="form-group">
                                        <input type="number" name="phone" minlength="10" maxlength="10"
                                            name="txtEmpPhone" class="form-control" placeholder="Phone Number *"
                                            value="" />
                                    </div>
                                    <div class="form-group">
                                        <select name="city" class="custom-select" id="validationCustom04" required>
                                            <option selected disabled value="0">City *</option>
                                            <?php
                                            $sql="CALL `getcity`()";
                                            $result=mysqli_query($conn,$sql);
                                            while($row=mysqli_fetch_assoc($result))
                                            {
                                                echo '<option value='.$row['zip_id'].'>'.$row['city'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <!-- <input type="date" class="form-control" placeholder="Birthdate" value="" /> -->
                                        <input placeholder="Birthdate" class="form-control" type="text" name="dob"
                                            onfocus="(this.type='date')">
                                    </div>
                                    <button type="submit" name="passengerRegister" class="btnRegister">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h3 class="register-heading">Register as a Driver</h3>
                        <form action="#" method="post">
                        <div class="row register-form">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="fname" class="form-control" placeholder="First Name *" value="" />
                                </div>
                                <div class="form-group">
                                    <input type="text" name="lname" class="form-control" placeholder="Last Name" value="" />
                                </div>
                                <div class="form-group">
                                    <input type="text" name="username" maxlength="20" class="form-control" placeholder="Username *" value="" />
                                </div>
                                <div class="form-group">
                                    <input type="number" name="phone" maxlength="10" minlength="10" class="form-control"
                                        placeholder="Phone *" value="" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="password" name="password" id="password2" maxlength="20" class="form-control" placeholder="Password *">
                                    <i class="far fa-eye" id="togglePassword2"></i>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password *"
                                        value="" />
                                </div>
                                <div class="form-group">
                                    <select name="vehicle_type" class="custom-select" id="validationCustom04">
                                        <option selected disabled value="0">Type of Vehicle</option>
                                        <option value="Mini">Mini</option>
                                        <option value="Sedan">Sedan</option>
                                        <option value="SUV">SUV</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="number" maxlength="2" name="yr_exp" class="form-control" placeholder="Years of Experience">
                                </div>
                                <input type="submit" name="driverRegister" class="btnRegister" value="Register" />
                            </div>
                        </div>
                        </form>
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

    <script>
    // passenger form
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    togglePassword.addEventListener('click', function(e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });

    // driver form
    const togglePassword2 = document.querySelector('#togglePassword2');
    const password2 = document.querySelector('#password2');
    togglePassword2.addEventListener('click', function(e) {
        // toggle the type attribute
        const type = password2.getAttribute('type') === 'password' ? 'text' : 'password';
        password2.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });
    </script>
</body>

</html>
<?php ob_end_flush(); ?>