<?php
    require 'variables.php';
?>
<!doctype html>
<html>
    <head>

    </head>
    <body>
        <form action="reader.php" method="GET">
            <p>Select book: (CHS = Simplified)</p>
            <br />
            <select name="book">
            <?php
                $files = scandir($BOOKS_DIR);
                foreach ($files as $file){
                    if (strpos($file, '.epub') !== false){
                        echo "<option value=".$file.">$file</option><br />";
                    }
                }
            ?>
            </select>
            <br />
            <p>UID:</p>
            <input type="username" name="user" />
            <br />
            <p>Font Size:</p>
            <input type="text" name="fontsize" value="110" />
            <br />
            <input type="submit" />
        </form>
    </body>
</html>
