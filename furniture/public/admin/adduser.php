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

if (isset($_POST['submit'])) {
/*This is used for creating new user and the data is stored in database instead of the html.*/
    $stmt = $pdo->prepare('INSERT INTO user (username, password, name) VALUES (:username, :password, :name)');

    $criteria = [
        'username' => $_POST['username'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'name' => $_POST['name'],
    ];

    $stmt->execute($criteria);
    echo 'User added';
} else {
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        ?>

			<h2>Add User</h2>

			<form action="" method="POST">
				<label>Username</label>
				<input type="text" name="username" />
				<label>Password</label>
				<input type="password" name="password" />
				<label>Name</label>
				<input type="text" name="name" />


				<input type="submit" name="submit" value="Add User" />

			</form>


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

}
?>


</section>
	</main>
	<?php include_once '../footer.php'?>
</body>
</html>
