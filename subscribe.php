<?php

// Start the session if it wasn't started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Subscribe | 8 Bit Bazaar</title>
	<meta name="author" content="" />
	<meta name="description" content="Website of old products">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/style.css" />
	<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />

	<!-- Google Fonts -->
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
	<!-- Page-level header -->
	<header>
		<?php
		include ("templates/header.php");
		?>
	</header>
	<!-- Page-level main content -->
	<main>
		<section>
			<h3>Thank you for subscribing to our newsletter. You now will receive important communications, including
				the newest and best deals.</h3>
			<?php

			$emailAddress = $_GET['emailAddress'];

			echo ('<p>Your email address, ' . $emailAddress . ' has been added to our list of subscribers.</p>');
			?>
		</section>
		<!-- Page-level footer -->
		<footer>
			<?php
			include ("templates/footer.php");
			?>
		</footer>
	</main>
	<!-- Add the javascript file that has some scripts -->
	<script src="scripts/scripts.js"></script>
</body>

</html>