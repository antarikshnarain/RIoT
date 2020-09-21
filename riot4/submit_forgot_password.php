<?php 
    require_once ("Includes/simplecms-config.php"); 
    require_once ("Includes/connectDB.php");
    require_once ("Includes/header.php"); 

    if (isset($_POST['forgot_password']))
    {
        if($_POST['username'] and $_POST['email'] )
        {
            $username = $_POST['username'];
            $email    = $_POST['email'];

            $query = "SELECT * FROM riot4.users WHERE username = ? and email = ?";
            $params = array($username, $email);
            $statement = sqlsrv_query($conn, $query, $params);
        
            $creationWasSuccessful = sqlsrv_rows_affected($statement) == 1? true: false;

            if ($creationWasSuccessful)
            {
                //generate random key
                //store random key in
                //redirect to password_reset page and check key then add new password
               
            }
            else
            {
                echo "<script> popup('No such Account found.\nTry Again.') </script>";
            }
            
        }
        else
        {
                echo "<script> popup ('Please fill up all the fields!')</script>";
        }
    }
?>