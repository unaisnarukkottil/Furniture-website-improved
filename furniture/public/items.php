<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $pdo = new PDO('mysql:dbname=furniture;host=127.0.0.1', 'student', 'student');
    $currentCategory = $pdo->query('SELECT * FROM category WHERE id = ' . $id)->fetch();
    $categoryName = $currentCategory['name'];
} else {
    die("Category id not specified");
}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="/styles.css"/>
		<title>Fran's Furniture - <?php echo $categoryName; ?></title>
	</head>
	<body>
	<header>
		<section>
<?php include_once 'openinghours.php';?>
			<h1>Fran's Furniture</h1>

		</section>
	</header>
	<?php include_once 'nav.php';?>

<img src="images/randombanner.php"/>
	<main class="admin">

	<section class="left">
<?php include_once 'categories.php';?>
	</section>

	<section class="right">

		<h1><?php echo $categoryName; ?></h1>

	<ul class="furniture">


<?php
$furnitureQuery = $pdo->prepare('SELECT * FROM furniture WHERE hide = 0 AND categoryId = ' . $id);
$furnitureQuery->execute();

foreach ($furnitureQuery as $furniture) {
    echo '<li>';

    if (file_exists('images/furniture/' . $furniture['id'] . '.jpg')) {
        echo '<a href="images/furniture/' . $furniture['id'] . '.jpg"><img src="images/furniture/' . $furniture['id'] . '.jpg" /></a>';
    }

    echo '<div class="details">';
    echo '<h2>' . $furniture['name'] . '</h2>';
    echo '<h3>£' . $furniture['price'] . '</h3>';
	echo '<p>' . $furniture['description'] . '</p>';
	echo '<p style="color:'. ($furniture['condition'] == 1 ? 'green' : 'red') .'"><b>' . ($furniture['condition'] == 1 ? 'New' : 'Second hand') . '</b></p>';
    echo '</div>';
    echo '</li>';
}
?>
</ul>
</section>
</main>
<?php include_once 'footer.php';?>
</body>
</html>
