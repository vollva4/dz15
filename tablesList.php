<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Таблицы:</title>
</head>
<body>
<?php
require_once ('dbConnect.php');
error_reporting(E_ALL);
$showall = $pdo->query('SHOW TABLES from avolvach');
foreach ($showall as $key => $table) {
    echo '<a href="tableinfo.php?name=' . $table[0] . '">' . $table[0] . '</a><br>';
}
?>
</body>
</html>