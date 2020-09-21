<?php
    require_once ("Includes/session.php");
    require_once ("Includes/simplecms-config.php"); 
    require_once ("Includes/connectDB.php");
    require_once ("Includes/header.php");
?>

<?php
    /* pwd_recovery.php SUBMIT button function
    -------------------------------------------------*/
    if (isset($_POST['password_reset']))
    {
        $OTP = $_POST['OTP'];
        $pwd = $_POST['password'];
        $cpwd = $_POST['confirm_password'];

        if($pwd != $cpwd)
        {
            echo "<script> popup('Password Mismatch. Please try Again!')</script>";
        }
        elseif($OTP != $_SESSION['random_key'])
        {
            echo "<script> popup('OTP is incorrect. Please try Again!')</script>";
        }
        else
        {            
            $query = "SELECT * FROM riot4.users WHERE username = ?";
            $params = array($_SESSION['temp_user']);
            $statement = sqlsrv_query($conn, $query, $params);

            $row = sqlsrv_fetch_array($statement);
            $_SESSION['userid'] = $row['id'];
            $_SESSION['username'] = $_SESSION['temp_user'];

            header ("Location: index.php");
        }
    }
?>

    <div id="main">
        <h2>Password Recovery</h2>
        <form action="pwd_reset.php" method="post">
            <fieldset>
                <legend>Password Reset</legend>
                <ol>
                    <li>
                        <label for="OTP">OTP:</label>
                        <input type="password" name="OTP" value="" id="OTP" />
                    </li>
                    <li>
                        <label for="password">Password:</label>
                        <input type="password" name="password" value="" id="password" />
                    </li>
                    <li>
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" name="confirm_password" value="" id="confirm_password" />
                    </li>
                </ol>
                <input type="submit" name="password_reset" value="password_reset" />
            </fieldset>
        </form>
    </div>

</center>
</div> <!-- End of outer-wrapper which opens in header.php -->
<?php 
    require_once ("Includes/footer.php");
 ?>