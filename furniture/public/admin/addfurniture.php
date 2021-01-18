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

    if (isset($_POST['submit'])) {

        $stmt = $pdo->prepare('INSERT INTO furniture (name, description, price, categoryId, hide, `condition`)
							   VALUES (:name, :description, :price, :categoryId, :hide, :condition)');

        $criteria = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
			'categoryId' => $_POST['categoryId'],
			'hide' => $_POST['hide'],
            'condition' => $_POST['condition'],
        ];

        $stmt->execute($criteria);

        if ($_FILES['image']['error'] == 0) {
            $fileName = $pdo->lastInsertId() . '.jpg';
            move_uploaded_file($_FILES['image']['tmp_name'], '../images/furniture/' . $fileName);
        }

        echo 'Furniture added';
    } else {

        ?>


			<h2>Add Furniture</h2>

			<form action="addfurniture.php" method="POST" enctype="multipart/form-data">
<!--The below dropdown list will help add a value on database 0 or 1 in furniture table so admin can choose to 
hide or show product according to his desire.-->
				<label>Product hidden</label>
				<select name="hide">
					<option value="0" selected >NO</option>
					<option value="1" >YES</option>
				</select>
<!--The below code will allow the admin to select if a product is new or not.-->
				<label>Condition</label>
				<select name="condition">
					<option value="1">New</option>
					<option value="2">Second hand</option>
				</select>
				<label>Name</label>
				<input type="text" name="name" />

				<label>Description</label>
				<textarea name="description"></textarea>

				<label>Price</label>
				<input type="text" name="price" />

				<label>Category</label>

				<select name="categoryId">
				<?php
$stmt = $pdo->prepare('SELECT * FROM category');
        $stmt->execute();

        foreach ($stmt as $row) {
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }

        ?>

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
