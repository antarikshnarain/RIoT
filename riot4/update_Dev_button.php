<?php
        $mid = $_SESSION['MID'];
        $query = "SELECT * FROM riot4.ENV_settings WHERE id = ? ORDER BY PrimKey DESC";
		$params = array($mid);
		$statement_user = sqlsrv_query($conn,$query,$params);

		if(sqlsrv_has_rows($statement_user))
		{
			while($row = sqlsrv_fetch_array($statement_user))
			{
				$d1 = $row['PrimKey'].$row['PrimKey'];
				$val = $_POST[$d1];
                
				$query_update = "UPDATE riot4.ENV_settings SET Value = ? WHERE PrimKey = ?";
				$params = array($val, $row['PrimKey']);
				$statement_update = sqlsrv_query($conn,$query_update,$params);
			}
		}
        echo "<script>popup('Updated')</script>";
?>