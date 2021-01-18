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
    $stmt = $pdo->prepare('UPDATE furniture
								SET name = :name,
								    description = :description,
								    price = :price,
								    categoryId = :categoryId,
									`hide` = :hide,
									`condition` = :condition
								   WHERE id = :id
						');

    $criteria = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'price' => $_POST['price'],
        'categoryId' => $_POST['categoryId'],
        'hide' => $_POST['hide'],
        'condition' => $_POST['condition'],
        'id' => $_POST['id'],
    ];

    $stmt->execute($criteria);

    if ($_FILES['image']['error'] == 0) {
        $fileName = $_POST['id'] . '.jpg';
        move_uploaded_file($_FILES['image']['tmp_name'], '../images/furniture/' . $fileName);
    }

    echo 'Product saved';
} else {
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

        $furniture = $pdo->query('SELECT * FROM furniture WHERE id = ' . $_GET['id'])->fetch();

        ?>

			<h2>Edit Furniture</h2>

			<form action="editfurniture.php" method="POST" enctype="multipart/form-data">

				<input type="hidden" name="id" value="<?php echo $furniture['id']; ?>" />

				<label>Product hidden</label>
				<select name="hide">
					<option value="0" <?php if ($furniture['hide'] == 0) {echo "selected";}?>>NO</option>
					<option value="1" <?php if ($furniture['hide'] == 1) {echo "selected";}?>>YES</option>
				</select>
				<label>Condition</label>
				<select name="condition">
					<option value="1" <?php if ($furniture['condition'] == 1) {echo "selected";}?>>New</option>
					<option value="2" <?php if ($furniture['condition'] == 2) {echo "selected";}?>>Second hand</option>
				</select>

				<label>Name</label>
				<input type="text" name="name" value="<?php echo $furniture['name']; ?>" />

				<label>Description</label>
				<textarea name="description"><?php echo $furniture['description']; ?></textarea>

				<label>Price</label>
				<input type="text" name="price" value="<?php echo $furniture['price']; ?>" />

				<label>Category</label>

				<select name="categoryId">
				<?php
$stmt = $pdo->prepare('SELECT * FROM category');
        $stmt->execute();

        foreach ($stmt as $row) {
            if ($furniture['categoryId'] == $row['id']) {
                echo '<option selected="selected" value="' . $row['id'] . '">' . $row['name'] . '</option>';
            } else {
                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
            }

        }

        ?>

				</select>


				<?php

        if (file_exists('../images/furniture/' . $furniture['id'] . '.jpg')) {
            echo '<img style="width: 200px; clear: both" src="../images/furniture/' . $furniture['id'] . '.jpg" />';
        }
        ?>
				<label>Product image</label>

				<input type="file" name="image" />

				<input type="submit" name="submit" value="Save Product" />

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
