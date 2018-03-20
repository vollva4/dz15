<?php
require_once ('dbConnect.php');
$table = 'items';
try {
    $sql = "CREATE TABLE `$table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` VARCHAR(50) NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  `cost` int(11) NOT NULL,
  `in_stock` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    $pdo->exec($sql);
    echo "Таблица $table создана успешно.<br>";
}
catch (PDOException $e) {
    echo 'Что-то тут не так: ',  $e->getMessage();
}

?>