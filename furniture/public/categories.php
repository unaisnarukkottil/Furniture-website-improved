<?php $pdo = new PDO('mysql:dbname=furniture;host=127.0.0.1', 'student', 'student', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);?>

<ul>
<!--The below code will be used to make the 'left' class off the categories page so any category added in the database
will dynamically will show up in the website. -->
<?php
$categories = $pdo->query('SELECT * FROM category');
foreach ($categories as $category) {
    echo '<li>';
    echo '<a href="items.php?id=' . $category['id'] . '">' . $category['name'] . '</a>';
    echo '</li>';
}
?>

</ul>

