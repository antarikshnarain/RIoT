<?php
    global $conn;
    $Uid = $_SESSION['userid'];

    $query = "SELECT * FROM riot4.settings WHERE User_ID = ? ORDER BY PrimKey DESC";
    $params = array($Uid);
    $statement_user = sqlsrv_query($conn,$query,$params);

    echo "<p><form action=\"index.php\" method=\"post\"></p>";
                        
        while($row = sqlsrv_fetch_array($statement_user))
        {
            $d = $row['PrimKey'];
            $dev = $row['Device'];
            $val = $row['Value'];

            if($val!=NULL||$val==0)
            {
                echo "<div class=\"settings\">";
                    echo "<img src=\"/Images/$dev.png\" alt=\"$dev\" height=\"50em\" width=\"50em\">";
                    echo "<input name=\"$d\" type=\"range\" min=\"0\" max=\"10\" value=\"$val\" oninput=\"showValue(this.name,this.value)\" />";
                    echo "<span id=\"$d\">$val</span>";
                echo "</div>";
            }
        }
        echo "<div class=\"settingsUpdate\">";
            echo "<input id=\"Update\" name=\"Update\" type=\"submit\" value=\"Update\"/>&nbsp;&nbsp;&nbsp;";
            //echo "<input id=\"AddDevice\" name=\"AddDevice\" type=\"submit\" value=\"AddDevice\" />";
        echo "</div>";
    echo "</form>";
?>