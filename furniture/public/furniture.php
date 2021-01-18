<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="/styles.css"/>
		<title>Fran's Furniture - Our Furniture</title>
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



<?php
$pdo = new PDO('mysql:dbname=furniture;host=127.0.0.1', 'student', 'student', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$categoryQuery = $pdo->prepare('SELECT * FROM category');
$categoryQuery->execute();

$categories = [];
foreach ($categoryQuery as $category) {
    $categories[$category['id']] = $category['name'];
}

$categoryId = isset($_POST['categoryId']) ? $_POST['categoryId'] : 0;
$condition = isset($_POST['condition']) ? $_POST['condition'] : 0;

?>

<section class="right">

<h1><?php echo $categoryId == 0 ? "Furniture" : $categories[$categoryId]; ?></h1>

<form action="furniture.php" method="POST">
<label>Category</label>
<select name="categoryId">
<option value="0">All</option>
<?php

foreach ($categories as $id => $name) {
    if ($categoryId == $id) {
        echo '<option selected value="' . $id . '">' . $name . '</option>';
    } else {
        echo '<option value="' . $id . '">' . $name . '</option>';
    }
}

?>
</select>

<label>Condition</label>
<select name="condition">
	<option value="0" <?php if ($condition == 0) {echo "selected";}?>>All</option>
	<option value="1" <?php if ($condition == 1) {echo "selected";}?>>New</option>
	<option value="2" <?php if ($condition == 2) {echo "selected";}?>>Second hand</option>
</select>

<input type="submit" name="submit" value="Apply" />
</form>
<ul class="furniture" style="clear: left;">
<!--The below code will allow the user to filter according to the categorry aswellas the condition of the product-->
<?php
$furnitureQuerySQL = 'SELECT * FROM furniture WHERE hide = 0';
if ($categoryId != 0) {
    $furnitureQuerySQL .= ' AND categoryId = ' . $categoryId;
}
if ($condition != 0) {
    $furnitureQuerySQL .= ' AND `condition` = ' . $condition;
}
$furnitureQuery = $pdo->prepare($furnitureQuerySQL);
$furnitureQuery->execute();

$numResults = $furnitureQuery->rowCount();
if ($numResults > 0) {
    echo "<p>Number of items: " . $numResults . "</p>";
    foreach ($furnitureQuery as $furniture) {
        echo '<li>';

        if (file_exists('images/furniture/' . $furniture['id'] . '.jpg')) {
            echo '<a href="images/furniture/' . $furniture['id'] . '.jpg"><img src="images/furniture/' . $furniture['id'] . '.jpg" /></a>';
        }

        echo '<div class="details">';
        echo '<h2>' . $furniture['name'] . '</h2>';
        echo '<h3>' . $categories[$furniture['categoryId']] . '</h3>';
        echo '<h4>£' . $furniture['price'] . '</h4>';
        echo '<p>' . $furniture['description'] . '</p>';
        /*Will display in our furniture page if the product is new or second hand if the product is new it will
        be colored green and if it is second hand it will be displayed red.*/
        echo '<p style="color:'. ($furniture['condition'] == 1 ? 'green' : 'red') .'"><b>' . ($furniture['condition'] == 1 ? 'New' : 'Second hand') . '</b></p>';
        echo '</div>';
        echo '</li>';
    }
} else {
    echo "<h2>No results found. Please adjust filters and try again... </h2>";
}

?>

</ul>

</section>
	</main>


<?php include_once 'footer.php';?>
</body>
</html>
