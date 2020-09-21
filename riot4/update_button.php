<?php
        $Uid = $_SESSION['userid'];
        $query = "SELECT * FROM riot4.settings WHERE User_ID = ? ORDER BY PrimKey DESC";
        $params = array($Uid);
        $statement_user = sqlsrv_query($conn,$query,$params);

        while($row = sqlsrv_fetch_array($statement_user))
        {
            $d1 = $row['PrimKey'];
            $val = $_POST[$d1];
                
            $query_update = "UPDATE riot4.settings SET Value = ? WHERE PrimKey = ?";
            $params = array($val, $row['PrimKey']);
            $statement_update = sqlsrv_query($conn,$query_update,$params);
        }
        echo "<script>popup('Updated')</script>";
?>