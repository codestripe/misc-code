<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Push Notification Panel</title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<!-- Javascripts -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>

    <!-- Stylesheets -->
    <link type="text/css" rel="stylesheet" href="css/styles.css">

</head>
<body>
	<?php
		
		// -- Step 1 - Include custom DB functions class and instantiate
		require_once("lib/functions.database.class.php");
		$db    = new CustomDatabaseMethods();

		// -- Step 2 - Get all users in the database
		$users = $db->GetAllUsers();

		// -- Return number of rows
		if (sizeof($users) == 0) 
		{
			$number_of_rows = 0; 
		}
		else
		{
			$number_of_rows = sizeof($users);
		}

	?>

	<div class="container">
                <a href="http://vikeer.org/push/bin/android/push/bin/push.apk">Click here</a> to download the app for Android.
                <br>
		<h1>Total Devices Registered on System: <?php echo $number_of_rows; ?></h1>
		<hr />
		<ul class="devices">
			<?php if ($number_of_rows > 0) { ?>
				<?php foreach ($users as $key => $value) { ?>
					<li>
						<form id="<?php echo $value['id']; ?>" name="" method="post" onsubmit="return SendPushNotification('<?php echo $value["id"]; ?>')"> 
							<label>Name: </label> <span><?php echo $value["name"] ?></span>
                            <div class="clear"></div>
                            <label>Email:</label> <span><?php echo $value["email"] ?></span>
                            <div class="clear"></div>
                            <div class="send_container">                                
                                <textarea rows="3" name="message" cols="25" class="txt_message" placeholder="Enter message here"></textarea>
                                <input type="hidden" name="reg_id" value="<?php echo $value["gcm_regid"] ?>"/>
                                <input type="submit" class="send_btn" value="Send" onclick=""/>
                            </div>
                        </form>
                    </li>
				<?php } // end foreach ?>
			<?php } else { // end if ?>
				<li>
					There are no registered users in the database at present.
				</li>
			<?php } // end if ?>
</body>
</html>