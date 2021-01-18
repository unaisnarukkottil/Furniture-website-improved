<?php
$pdo = new PDO('mysql:dbname=furniture;host=127.0.0.1', 'student', 'student', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="/styles.css"/>
		<title>Fran's Furniture - Home</title>
	</head>
	<body>
	<header>
		<section>
<?php include_once '../openinghours.php'?>
			<h1>Fran's Furniture</h1>

		</section>
	</header>
	</header>
	<?php include_once 'loginnav.php';?>
<img src="/images/randombanner.php"/>
	<main class="admin">

	<?php

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $enquiries = $pdo->query('SELECT * FROM enquiries WHERE id = ' . $_GET['id'])->fetch();
    ?>
<!--Here user can see all the details of the enquirer.-->
	<section class="left">
	<?php include_once 'catnav.php';?>
	</section>

	<section class="right">
	<h3>Enquiry Details</h3>

    <form action="deleteenquiries.php" method="POST">

	<label>Name</label>
	<input readonly type="text" name="name" value="<?php echo $enquiries['name']; ?>" />

	<label>Email</label>
	<input readonly type="text" name="email" value="<?php echo $enquiries['email']; ?>" />

	<label>Telephone</label>
	<input readonly type="text" name="telephone" value="<?php echo $enquiries['telephone']; ?>" />

	<label>Enquiry</label>
	<textarea readonly rows="4" cols="50" type="text" name="enquiry"><?php echo $enquiries['enquiry']; ?></textarea>
	
	<input type="hidden" name="id" value="<?php echo $enquiries['id']; ?>" />
	<!--By clicking on the delete the enquiry button the enquiry will be deleted-->
	<input type="submit" name="submit" value="Delete the enquiry" />


</form>
	</section>
	<?php
} else {
    ?>
		<h2>Log in</h2>

<form action="index.php" method="post" style="padding: 40px">

	<label>Username</label>
	<input type="text" name="username" />

	<label>Enter Password</label>
	<input type="password" name="password" />

	<input type="submit" name="submit" value="Log In" />
</form>
	<?php
}
?>


	</main>

	<?php include_once '../footer.php';?>
</body>
</html>

