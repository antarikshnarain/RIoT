<?php
     if($_POST['username'] and $_POST['password'])
     {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT id,username FROM riot4.users WHERE username = ? AND password = HASHBYTES('SHA',?)";
            
        $params = array($username,$password);
        $statement = sqlsrv_query($conn,$query,$params);

        if(sqlsrv_has_rows($statement))
        {
            $row = sqlsrv_fetch_array($statement);
            $_SESSION['userid'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            header ("Location: index.php");
        }
        else
        {
            echo "<script> popup('Username/password combination is incorrect.') </script>";
        }
     }
     else
     {
         echo "<script> popup ('Please provide both username and password.')</script>";
     }
?>