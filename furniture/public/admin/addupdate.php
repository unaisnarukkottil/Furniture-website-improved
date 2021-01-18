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
/**This will add the data to the database that is to be displayed on the front page as update */
    if (isset($_POST['submit'])) {

        $stmt = $pdo->prepare('INSERT INTO updates (`date`, title, description)
		  									VALUES (:date, :title, :description)');

        $criteria = [
            'date' => date("Y-m-d H:i:s", strtotime($_POST['date'])),
            'title' => $_POST['title'],
            'description' => $_POST['description'],
        ];

        $stmt->execute($criteria);

        if ($_FILES['image']['error'] == 0) {
            $fileName = $pdo->lastInsertId() . '.jpg';
            move_uploaded_file($_FILES['image']['tmp_name'], '../images/updates/' . $fileName);
        }

        echo 'Update added';
    } else {

        ?>


			<h2>Add Update</h2>

			<a class="new" href="deleteupdate.php">Delete existing updates</a>

			<form action="addupdate.php" method="POST" enctype="multipart/form-data">
				<label>Date</label>
				<input type="date" name="date" />


				<label>Title</label>
				<input type="text" name="title" />

				<label>Description</label>
				<textarea name="description"></textarea>

				<label>Image</label>

				<input type="file" name="image" />

				<input type="submit" name="submit" value="Add" />

			</form>



		<?php
}
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