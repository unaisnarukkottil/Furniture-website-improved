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

    $query = 'UPDATE user SET name = :name';

    $criteria = [
        'name' => $_POST['name'],
        'id' => $_POST['id'],
    ];

    if (isset($_POST['password'])) {
        $query .= ', password = :password';
        $criteria['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }
    $query .= ' WHERE id = :id';

    $stmt = $pdo->prepare($query);
    $stmt->execute($criteria);
    echo 'User Saved';
} else {
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

        $currentUser = $pdo->query('SELECT * FROM user WHERE id = ' . $_GET['id'])->fetch();
        ?>


			<h2>Edit User</h2>

			<form action="" method="POST">

				<input type="hidden" name="id" value="<?php echo $currentUser['id']; ?>" />
				<label>Name</label>
				<input type="text" name="name" value="<?php echo $currentUser['name']; ?>" />
				<label>New Password</label>
				<input type="password" name="password" />


				<input type="submit" name="submit" value="Save User" />

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
