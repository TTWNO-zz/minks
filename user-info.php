<?php
    require('variables.php');
    require('MinksDB.php');

    $db = new MinksDB($SQLITE3_DATABASE);
    $users = $db->getListFromQuery("SELECT name FROM SQLITE_MASTER WHERE type='table'");
?>

<!doctype html>
<html>
    <head>

    </head>
    <body>
        <form action="user-info.php" method="GET">
            <p>
                Select user for data
            </p>
            <select name="user">
                <?php
                    foreach ($users as $row) {
                        $name = $row['name'];
                        echo "<option value=\"$name\">$name</option>";
                    }
                ?>
            </select>
            <br />
            <input type="submit" />
        </form>
        <div id="user-info">
            <?php

                if (!is_null($_GET['user'])){
                    echo '<p>Results for: '.$_GET['user'].'</p><br />';
                    $udrel = $db->query('SELECT * FROM '.$_GET['user']);
                    while ($table = $udrel->fetchArray(SQLITE3_ASSOC)) {
                        echo $table['word'].' | '.$table['kl'].'<br />';
                    }
                }
            ?>
        </div>
    </body>
</html>
