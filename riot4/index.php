<?php
    require_once ("Includes/session.php");
    require_once ("Includes/simplecms-config.php"); 
    require_once ("Includes/connectDB.php");
    require_once ("Includes/header.php");
?>

<?php
    /* logon.php SUBMIT button function
    -------------------------------------------------*/
    if (isset($_POST['Login']))
    {
        include("submit_button.php");
    }

    /* dev_logon.php SUBMIT button function
    -------------------------------------------------*/
    if (isset($_POST['Dev_Login']))
    {
        include("submit_Dev_button.php");
    }

    /* userPref_settings.php UPDATE button function
    -------------------------------------------------*/
    if (isset($_POST['Update']))
    {
        include("update_button.php");
    }

    /* env_settings.php UPDATE button function
    -------------------------------------------------*/
    if (isset($_POST['ENV_Update']))
    {
        include("update_Dev_button.php");
    }

    /* settings.php ADD DEVICE button function
        (NOT USED AS OF NOW)
    -------------------------------------------------*/
    if (isset($_POST['AddDevice']))
    {
        include("add_device_button.php");
    }
    
    /* Choose to load settings.php or login.php as Body
    -----------------------------------------------------------*/
    if(logged_on())
    {
        include("settings.php");
    }
    else
    {
        include("logon.php");
    }
?>

</center>
</div> <!-- End of outer-wrapper which opens in header.php -->

<?php 
    require_once ("Includes/footer.php");
 ?>