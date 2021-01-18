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
	<?php include_once '../nav.php';?>
<img src="/images/randombanner.php"/>
	<main class="admin">

	<?php
/*The bellow code will check the username and  password with the database and see 
whether the credentials are correct and let the user log in if correct or else won't allow them to login.*/
if (isset($_POST['submit'])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->execute([$_POST['username']]);
        $user = $stmt->fetch();
        if (password_verify($_POST['password'], $user['password'])) {
            $_SESSION['loggedin'] = true;
        }
    }
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    ?>

	<section class="left">
	<?php include_once 'catnav.php';?>
	</section>

	<section class="right">
	<h2>You are now logged in </h2>
	<p><a href="../admin/logout.php">Logout</a></p>
	</section>
	<?php
} else {
    ?>
		<h2>Log in</h2>

		<form action="index.php" method="post" style="padding: 40px">
<!-- The username has been added because functionality to login as different users were added to the website. -->
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

