<?php 
    require_once ("Includes/simplecms-config.php"); 
    require_once ("Includes/connectDB.php");
    require_once ("Includes/header.php"); 

    if (isset($_POST['Register']))
    {
        if($_POST['username'] and $_POST['password'] and $_POST['confirmpassword'])
        {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $cpasswrd = $_POST['confirmpassword'];
            $email    = $_POST['email'];

            if($cpasswrd!=$password)
            {
                echo "<script> popup('Passwords Mismatch') </script>";
            }
            elseif (strlen($username)<4 or strlen($username)>31)
            {
                echo "<script> popup('username should be of length 5 to 30') </script>";
            }
            elseif(preg_match('/[^a-z0-9\-\_\.]+/i',$_POST['username']))
	        {
		        echo "<script> popup('Your username contains invalid characters!') </script>";
	        }
         //   elseif(!checkEmail($_POST['email']))
	        //{
         //       echo "<script> popup('Your email is not valid!') </script>";
	        //}
            else
            {
                echo "sdfdsfDS";
                $query = "INSERT INTO riot4.users (username, password, emailid) VALUES (?, HASHBYTES('SHA',?), ?)";
                $params = array($username, $password, $email);
                $statement = sqlsrv_query($conn, $query, $params);
        
                $creationWasSuccessful = sqlsrv_rows_affected($statement) == 1? true: false;

                if ($creationWasSuccessful)
                {
                    $query = "SELECT id,username FROM riot4.users WHERE username = ? AND password = HASHBYTES('SHA',?)";
                    $params = array($username,$password);
                    $statement = sqlsrv_query($conn,$query,$params);

                    if(sqlsrv_has_rows($statement))
                    {
                        $row = sqlsrv_fetch_array($statement);
                        $_SESSION['userid'] = $row['id'];
                        $_SESSION['username'] = $row['username'];
                        
                        $query_insert = "INSERT INTO riot4.settings (User_ID,Device,Value) VALUES (?,'light_bulb',0),(?,'fan_ceil',0),(?,'light_table',0),(?,'fan_table',0),(?,'light_cfl',0)";
            
                        $params = array($_SESSION['userid'],$_SESSION['userid'],$_SESSION['userid'],$_SESSION['userid'],$_SESSION['userid']);
                        sqlsrv_query($conn,$query_insert,$params);

                        header ("Location: index.php");
                    }
                }
                else
                {
                    echo "<script> popup('Username/EmailID already exists. Try Again!') </script>";
                }
            }
        }
        else
        {
             echo "<script> popup ('Please fill up all the fields!')</script>";
        }
    }
?>
    <div id="main">
        <h2>Register an account</h2>
        <form action="register.php" method="post">
            <fieldset>
                <legend>Register an account</legend>
                <ol>
                    <li>
                        <label for="username">Username:</label> 
                        <input type="text" name="username" value="" id="username" />
                    </li>
                    <li>
                        <label for="password">Password:</label>
                        <input type="password" name="password" value="" id="password" />
                    </li>
                    <li>
                        <label for="password">Confirm Password:</label>
                        <input type="password" name="confirmpassword" value="" id="confirmpassword" />
                    </li>
                    <li>
                        <label for="email">Email:</label>
                        <input type="email" name="email" value="" id="email" />
                    </li>
                </ol>
                <input type="submit" name="Register" value="Register" />
            </fieldset>
        </form>
    </div>
</div> <!-- End of outer-wrapper which opens in header.php -->
<?php
    include ("Includes/footer.php");
?>