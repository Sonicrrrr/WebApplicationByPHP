<?php
    session_start();
    require_once "config.php"
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <div class="container">
        <h1>Welcome to the Automobiles Database</h1>
        <?php
            if(!isset($_SESSION['name']) && !isset($_SESSION['success'])){
                echo('<p><a href="login.php">Please log in</a></p>');
            }
            else {
                if (isset($_SESSION['success'])) {
                    echo ('<p style="color:green";>') . $_SESSION['success'] . ("</p>\n");
                    unset($_SESSION['success']);
                }
                if (isset($_SESSION['error'])) {
                    echo ('<p style="color:red";>') . $_SESSION['error'] . ("</p>\n");
                    unset($_SESSION['error']);
                }
                echo('<table border="1"' . "\n");
                $sql = "SELECT autos_id,make,model,year,mileage from autos";
                $stmt = $pdo->query($sql);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($rows) > 0) {
                    echo("<tr><th>Make</th><th>Model</th><th>Year</th><th>Mileage</th><th>Action</th></tr>");
                    foreach ($rows as $row) {
                        echo "<tr><td>";
                        echo(htmlentities(($row['make'])));
                        echo "</td><td>";
                        echo(htmlentities($row['model']));
                        echo "</td><td>";
                        echo(htmlentities($row['year']));
                        echo "</td><td>";
                        echo(htmlentities($row['mileage']));
                        echo "</td><td>";
                        echo('<a href="edit.php?autos_id=' . $row['autos_id'] . '">Edit</a> / ');
                        echo('<a href="delete.php?autos_id=' . $row['autos_id'] . '">Delete</a>');
                        echo("</td></tr>\n");
                    }
                } else echo("<p1>No found rows</p1>\n");
                echo ('</table>');
                echo('<p><a href="add.php">Add New Entry</a></p>
                <p><a href="logout.php">Logout</a></p>');
            }
        ?>
    </div>
</body>
</html>
