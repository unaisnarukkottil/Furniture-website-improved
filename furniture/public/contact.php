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
<?php include_once 'openinghours.php'?>

			<h1>Fran's Furniture</h1>

		</section>
	</header>
<?php include_once 'nav.php';?>

<img src="images/randombanner.php"/>
	<main class="home">
<!--Will send the admin the information any user puts into the contact details.
later the admin can view them in viewenquiries.php-->
	<?php

if (isset($_POST['submit'])) {

    $stmt = $pdo->prepare('INSERT INTO enquiries (name, email, telephone, enquiry)
							   VALUES (:name, :email, :telephone, :enquiry)');

        $criteria = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'telephone' => $_POST['telephone'],
            'enquiry' => $_POST['enquiry']
        ];
        $stmt->execute($criteria);
        echo 'Equiry Sent';

} else {
    ?>
<h3>Please fill in the details.</h3>

<form action="contact.php" method="post" style="padding: 40px">

	<label>Name</label>
	<input type="text" name="name" />

	<label>Email</label>
	<input type="text" name="email" />

	<label>Telephone</label>
	<input type="text" name="telephone" />

	<label>Enquiry</label>
	<textarea rows="4" cols="50" type="text" name="enquiry"></textarea>


	<input type="submit" name="submit" value="Submit" />
</form>
		<?php
}
?>
</main>

<?php include_once 'footer.php';?>
</body>
</html>

