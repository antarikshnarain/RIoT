<?php
    global $conn;
    $mid = $_SESSION['MID'];

	/**/
    $query = "SELECT * FROM riot4.ENV_settings WHERE id = ? ORDER BY PrimKey DESC";
    $params = array($mid);
    $statement_user = sqlsrv_query($conn,$query,$params);
    
    echo "<p><form action=\"index.php\" method=\"post\"></p>";
                        
        while($row = sqlsrv_fetch_array($statement_user))
        {
            $d = $row['PrimKey'].$row['PrimKey'];
            $dev = $row['Device'];
            $val = $row['Value'];

            if($val!=NULL||$val==0)
            {
				if($_SESSION['ROOT']==$_SESSION['userid']||$row['LOCK']==0)
				{
					echo "<div class=\"settings\">";
						echo "<img src=\"/Images/$dev.png\" alt=\"$dev\" height=\"50em\" width=\"50em\">";
						echo "<input name=\"$d\" type=\"range\" min=\"0\" max=\"10\" value=\"$val\" oninput=\"showValue(this.name,this.value)\" />";
						if($_SESSION['ROOT']==$_SESSION['userid'])
						{
							if($row['LOCK']==0)
								echo "<img id=\"un_lock\" src=\"/Images/unlock.png\" height=\"30px\" width=\"20px\" onclick=\"_un_lock_img(this)\">";
							else
								echo "<img id=\"un_lock\" src=\"/Images/lock.png\" height=\"30px\" width=\"20px\" onclick=\"_un_lock_img(this)\">";
						}
						echo "<span id=\"$d\">$val</span>";
					echo "</div>";
				}
            }
        }
        echo "<div class=\"settingsUpdate\">";
            echo "<input id=\"ENV_Update\" name=\"ENV_Update\" type=\"submit\" value=\"Update Env\"/>&nbsp;&nbsp;&nbsp;";
        echo "</div>";
    echo "</form>";
?>