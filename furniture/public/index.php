
<html>

<head>
	<link rel="stylesheet" href="/styles.css" />
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

	<img src="images/randombanner.php" />
	<main class="home">
		<p>Welcome to Fran's Furniture. We're a family run furniture shop based in Northampton. We stock a wide variety of
			modern and antique furniture including laps, bookcases, beds and sofas.</p>

			
<ol>
<?php
$pdo = new PDO('mysql:dbname=furniture;host=127.0.0.1', 'student', 'student', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$updatesQuery = $pdo->prepare('SELECT * FROM updates');
$updatesQuery->execute();
/*will take the neccessory data from the database and show the update on the index page.*/
$numResults = $updatesQuery->rowCount();
if ($numResults > 0) {
    echo "<h2>Updates</h2>";
    foreach ($updatesQuery as $update) {
        echo '<li>';
        echo '<p>' . $update['date'] . '</p>';
        echo '<div class="details">';
        echo '<h3>' . $update['title'] . '</h3>';
        $filename = 'images/updates/' . $update['id'] . '.jpg';
        if (file_exists($filename)) {
            echo '<a href="' . $filename . '"><img src="' . $filename . '" /></a>';
        }
        echo '<p>' . $update['description'] . '</p>';
        echo '</div>';
        echo '</li>';
    }
} else {
    echo "<h3>No updates for the moment</h3>";
}
?>
</ol>

	</main>

<?php include_once 'footer.php';?>
</body>

</html>