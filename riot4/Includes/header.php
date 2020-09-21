<?php require_once ("Includes/session.php"); ?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <?php
			$relative_path = $_SERVER['PHP_SELF'];
            if(($relative_path=='/index.php'&&logged_on())||ENV_logged_on())
            {
                echo "<meta http-equiv=\"refresh\" content=\"15\">";
            }
        ?>
        <title>User Profiles</title>
        <link href="/Styles/Site.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/Scripts/Site.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1"> 

    </head>

    <body>
        <div class="outer-wrapper" >
        <header>
            <div class="content-wrapper">
                <div class="float-left">
                    <p class="site-title"><a href="/index.php">RIoT User Profiles</a></p>
                </div>
                <div class="float-right">
                    <section id="login">
                        <ul id="login">
                        <?php
                            $relative_path = $_SERVER['PHP_SELF'];
                            if (logged_on())
                            {
                                if(!ENV_logged_on())
                                {
                                    echo '<li><a href="/dev_logon.php">Add Environment</a></li>' . "\n";
                                }
                                echo '<li><a href="/logoff.php">Sign out</a></li>' . "\n";
                            }
                            else if($relative_path=="/index.php")
                            {
                                echo '<li><a href="/register.php">Register</a></li>' . "\n";
                            }
                            else
                            {
                                echo '<li><a href="/index.php">Login</a></li>' . "\n";
                            }
                        ?>
                        </ul>
                        <?php 
                            if (logged_on()) 
                            {
                                echo "<div class=\"welcomeMessage\">Welcome, <strong>{$_SESSION['username']}</strong></div>\n";
                            }
                        ?>
                    </section>
                </div>

                <div class="clear-fix"></div>
            </div>
        </header>
        <center>