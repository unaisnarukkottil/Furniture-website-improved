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


			<h2>Categories</h2>

			<a class="new" href="addcategory.php">Add new category</a>

			<?php
echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Name</th>';
    echo '<th style="width: 5%">&nbsp;</th>';
    echo '<th style="width: 5%">&nbsp;</th>';
    echo '</tr>';

    $categories = $pdo->query('SELECT * FROM category');

    foreach ($categories as $category) {
        echo '<tr>';
        echo '<td>' . $category['name'] . '</td>';
        echo '<td><a style="float: right" href="editcategory.php?id=' . $category['id'] . '">Edit</a></td>';
        echo '<td><form method="post" action="deletecategory.php">
				<input type="hidden" name="id" value="' . $category['id'] . '" />
				<input type="submit" name="submit" value="Delete" />
				</form></td>';
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
