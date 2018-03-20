<?php
require_once 'dbConnect.php';
if (isset($_GET)) {
    $table = strip_tags(htmlspecialchars($_GET['name']));
}
$table_info = $pdo->prepare("DESCRIBE $table");
$table_info->execute();
$get_table = $table_info->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Информация о таблице:<?=$table?></title>
</head>
<body>
<?php
if (isset($_POST['action'])) { ?>
    <form method="post">
            <input type="hidden" name="name" value="<?= $_POST['field_name'] ?>">
            <input type="hidden" name="type" value="<?= $_POST['field_type'] ?>">
<?php if ($_POST['action'] == 'Change_name') { ?>
            <input type="text" name="new_name" value="<?= $_POST['field_name'] ?>">
            <input type="submit" name="sub_new_name" value="Изменить имя поля <?= $_POST['field_name'] ?>">
        </form>
<?php } if ($_POST['action'] == 'Change_type') { ?>
            <input type="text" name="new_type" value="<?= $_POST['field_type'] ?>">
            <input type="submit" name="sub_new_type" value="Изменить тип поля <?= $_POST['field_name'] ?>">
        </form>
<?php } if ($_POST['action'] == 'Delete_field') {
        $name = htmlspecialchars($_POST['field_name']);
        $pdo->exec("ALTER TABLE $table DROP COLUMN $name");
        header("Refresh: 0;");
    }
}
if (isset($_POST['sub_new_name'])) {
    $name = htmlspecialchars($_POST['name']);
    $new_name = htmlspecialchars($_POST['new_name']);
    $type = htmlspecialchars($_POST['type']);
    $pdo->exec("ALTER TABLE $table CHANGE $name $new_name $type");
    header("Refresh: 0;");
}
if (isset($_POST['sub_new_type'])) {
    $name = htmlspecialchars($_POST['name']);
    $type = htmlspecialchars($_POST['new_type']);
    $pdo->exec("ALTER TABLE $table MODIFY $name $type");
    header("Refresh: 0;");
}
?>


<table>
    <tr>
        <th>Название поля</th>
        <th>Тип</th>
        <th>Действия</th>
    </tr>
    <?php foreach ($get_table as $fields) :
        ?>
        <tr>
            <td><?= $fields['Field'] ?></td>
            <td><?= $fields['Type'] ?></td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="field_name" value="<?= $fields['Field'] ?>">
                    <input type="hidden" name="field_type" value="<?= $fields['Type'] ?>">
                    <select name="action">
                        <option value="Change_name">Изменить назвиние</option>
                        <option value="Change_type">Изменить тип</option>
                        <option value="Delete_field">Удалить поле</option>
                    </select>
                    <input type="submit" value="Готово">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="index.php">На главную</a>
<a href="tablesList.php">Список таблиц</a>
</body>
</html>