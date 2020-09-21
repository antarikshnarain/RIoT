<?php
    require_once ("Includes/header.php");
?>

	<div id="main">
		<h2>Log on</h2>
			<form action="index.php" method="post">
				<fieldset>
				<legend>Environment Login</legend>
				<ol>
					<li>
						<label for="username">Chip ID:</label> 
						<input type="text" name="Chip_ID" value="" id="Chip_ID" />
					</li>
					<li>
						<label for="password">OTP:</label>
						<input type="password" name="OTP" value="" id="OTP" />
					</li>
				</ol>
				<input type="submit" id="Dev_Login" name="Dev_Login" value="Dev_Login" />
			</fieldset>
		</form>
	</div>

</center>
</div> <!-- End of outer-wrapper which opens in header.php -->

<?php 
    require_once ("Includes/footer.php");
 ?>