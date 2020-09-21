<?php
    $Envir_ID = $_POST['Chip_ID'];
    $password = $_POST['OTP'];

    $query = "SELECT * FROM riot4.ENV WHERE id = ?";
            
    $params = array($Envir_ID);
    $statement = sqlsrv_query($conn,$query,$params);

    if(sqlsrv_has_rows($statement))
    {
        $row = sqlsrv_fetch_array($statement);

        if($row['OTP']==$password)
        {
            $_SESSION['ENV_OTP'] = $row['OTP'];
            $_SESSION['MID'] = $row['id'];
            $_SESSION['ROOT'] = $row['root'];

            if($row['root']==NULL)
            {
                $query_update = "UPDATE riot4.ENV SET root = ? WHERE id = ?";

                $params = array($_SESSION['userid'],$Envir_ID);
                $statement_update = sqlsrv_query($conn,$query_update,$params);

                $_SESSION['ROOT'] = $_SESSION['userid'];

				echo "<script>popup('You have been set as root for the environment')</script>";
            }

            if($_SESSION['ROOT']==$_SESSION['userid'])
            {
                /* Change ENV values to that of root
                -------------------------------------------*/
                $query = "SELECT * from riot4.settings WHERE User_ID = ?";
                $params = array($_SESSION['userid']);
                $statement = sqlsrv_query($conn, $query, $params);

				if(sqlsrv_has_rows($statement))
				{
					while($row = sqlsrv_fetch_array($statement))
					{
						$query_env_update = "UPDATE riot4.ENV_settings SET Value  = ? WHERE id = ? AND Device = ?";
						$params = array($row['Value'],$Envir_ID,$row['Device']);
						$statement_env_update = sqlsrv_query($conn, $query_env_update,$params);
					}
				}

				echo "<script>popup('You are admin for the environment')</script>";
            }
            else if($row['n_users']==0)
            {
                /* Change ENV values to that of first user
                -------------------------------------------*/
				$query = "SELECT * from riot4.settings WHERE User_ID = ?";
                $params = array($_SESSION['userid']);
                $statement = sqlsrv_query($conn, $query, $params);

				if(sqlsrv_has_rows($statement))
				{
					while($row = sqlsrv_fetch_array($statement))
					{
						$query_env_update = "UPDATE riot4.ENV_settings SET Value  = ? WHERE id = ? AND Device = ? AND LOCK=0";
						$params = array($row['Value'],$Envir_ID,$row['Device']);
						$statement_env_update = sqlsrv_query($conn, $query_env_update,$params);
					}
				}

				echo "<script>popup('You are 1st user in the environment')</script>";
            }
        }
        else
        {
            echo "<script>popup('Environment_ID/OTP combination is incorrect.')</script>";
        }
    }
    else
    {
        echo "<script>popup('Environment does not exist.')</script>";
    }
?>