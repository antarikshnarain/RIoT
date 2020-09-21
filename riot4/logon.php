<?php
    require_once ("Includes/header.php");
?>

<div id="main">
    <h2>Log on</h2>
        <form action="index.php" method="post">
            <fieldset>
            <legend>Log on</legend>
            <ol>
                <li>
                    <label for="username">Username:</label> 
                    <input type="text" name="username" value="" id="username" />
                </li>
                <li>
                    <label for="password">Password:</label>
                    <input type="password" name="password" value="" id="password" />
                </li>
            </ol>
            <input type="submit" id="Login" name="Login" value="Login" />
            <a href="/pwd_recovery.php">Forgot Password?</a> 
        </fieldset>
    </form>
</div>