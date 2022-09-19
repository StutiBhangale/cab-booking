<?php
// session_start();

if(!isset($_SESSION['login']) || $_SESSION['login'] != true || !isset($_SESSION['pid']))
{   
    $loggedin = false;
}
else
{
    $loggedin = true;
}

if(!isset($_SESSION['did']))
{
    $driver_login=false;
}
else
{
    // $loggedin=true;
    $driver_login=true;
}


    echo '<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
        <a class="navbar-brand" href="index.php">
            <img src="img/logo1.png" class="logo mx-3" alt="logo img">
            CabX
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">';

            if(!$loggedin && !$driver_login)
                {
                echo '<li class="nav-item active mx-3">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-house" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                        <path fill-rule="evenodd"
                            d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                    </svg>
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link" href="#services">Services</a>';
                }

                if($loggedin)
                {
                    echo '</li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="booking.php">Book Now</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="booking_hist.php">Booking History</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="profile.php">My profile</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="feedback.php">Feedback</a>
                    </li>';
                }

                if($driver_login)
                {
                    echo '</li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="booking_hist.php">View Bookings</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="profile.php">My profile</a>
                    </li>';
                }
                
                // if(!$loggedin)
                // {
                echo '<li class="nav-item mx-3">
                        <a class="nav-link" href="about.php">About</a>
                    </li>';
                // }
               echo '</ul>';
               if(!$loggedin && !$driver_login)
               {
                echo '<div class="ml-auto">
                <a class="btn btn-sm btn-light" href="login.php">Login</a>
                <a class="btn btn-sm btn-light mx-1" href="register.php">Register</a>';
            }

            if($loggedin || $driver_login)
            {
                echo '<svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-person-fill mx-1" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                </svg>
                <p class="name mt-3" id="profileName">'.$_SESSION['username'].'</p>
                <a class="btn btn-sm btn-light ml-1" href="logout.php">Logout</a>
                </div>';
            }

        echo '</div>
    </nav>';
?>