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
			<?php include_once '../openinghours.php';?>
			<h1>Fran's Furniture</h1>

		</section>
	</header>
	<?php include_once 'loginnav.php'?>

<img src="/images/randombanner.php"/>
	<main class="admin">

	<section class="left">
	<?php include_once 'catnav.php';?>
	</section>


	<section class="right">

	<?php

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    ?>

<!--user will be able see an overview of who sent the details from this page and the user can
click on the view button to see more details or delete the enquiry.-->
			<h2>Enquiries</h2>
			<?php
echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th >Name</th>';
    echo '<th style="width: 10%">E-mail</th>';
    echo '<th style="width: 5%">&nbsp;</th>';
    echo '<th style="width: 5%">&nbsp;</th>';
    echo '</tr>';

    $enquiriesQuery = $pdo->query('SELECT * FROM enquiries');

    foreach ($enquiriesQuery as $enquiries) {
        echo '<tr>';
        echo '<td>' . $enquiries['name'] . '</td>';
        echo '<td>' . $enquiries['email'] . '</td>';
        echo '<td><a style="float: right" href="viewenquiries.php?id=' . $enquiries['id'] . '">View Details</a></td>';
        echo '</tr>';
    }

    echo '</thead>';
    echo '</table>';

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

</section>
	</main>
	<?php include_once '../footer.php'?>

</body>
</html>
