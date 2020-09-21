<?php
    require_once ("Includes/session.php");
    require_once ("Includes/simplecms-config.php"); 
    require_once ("Includes/connectDB.php");
    require_once ("Includes/header.php");
?>

<?php
    /* logon.php SUBMIT button function
    -------------------------------------------------*/
    if (isset($_POST['forgot_password']))
    {
        $username  = $_POST['username'];
        $email = $_POST['email'];

        $query = " SELECT * FROM riot4.users WHERE username = ? and emailid = ?";
        $params = array($username, $email);
        $statement = sqlsrv_query($conn, $query, $params);

        if(sqlsrv_has_rows($statement))
        {
            $_SESSION['random_key'] = rand(10000,99999);
            $_SESSION['temp_user'] = $username;
            //send_mail(	'yashchandak@outlook.com', $email,'RIoT - Forgot Password - OTP', 'Your password is: '.$_SESSION['random_key']);

            /*
            *  TODO:
            *  Mailing is not working, mailing server required.
            */

            $Name = "RIoT"; //senders name
            $email = "yashchandak@yahoo.in"; //senders e-mail adress
            $recipient = $email; //recipient
            $mail_body = "Your password is:.".$_SESSION['random_key']; //mail body
            $subject = "RIoT - Forgot Password - OTP"; //subject
            $header = "From: ". $Name . " <" . $email . ">\r\n"; //optional headerfields

            mail($recipient, $subject, $mail_body, $header); 
            header("Location: pwd_reset.php");
        }
        else
        {
            echo "<script>popup('No such user-email combination exists. Please Try Again!')</script>";
        }
    }
?>

    <div id="main">
        <h2>Password Recovery</h2>
        <form action="pwd_recovery.php" method="post">
            <fieldset>
                <legend>Password Recovery</legend>
                <ol>
                    <li>
                        <label for="username">Username:</label> 
                        <input type="text" name="username" value="" id="username" />
                    </li>
                    <li>
                        <label for="email">Email:</label>
                        <input type="email" name="email" value="" id="email" />
                    </li>
                </ol>
                <input type="submit" name="forgot_password" id="forgot_password" value="Recover" />
            </fieldset>
        </form>
    </div>

</center>
</div> <!-- End of outer-wrapper which opens in header.php -->
<?php 
    require_once ("Includes/footer.php");
 ?>