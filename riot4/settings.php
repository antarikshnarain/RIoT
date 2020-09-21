<div id="main">
<h2><a href="/index.php">Settings</a></h2>

<?php
    prep_DB_content();

    if(logged_on())
    {
        if(ENV_logged_on())
        {
            require_once ("env_settings.php");
        }
        else
        {
            require_once ("userPref_settings.php");
        }
    }
    ?>
</div>