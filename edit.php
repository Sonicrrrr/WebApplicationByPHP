<?php
session_start();
require_once "config.php";
if ( ! isset($_GET['autos_id']) ) {
    $_SESSION['error'] = "Missing autos_id";
    header('Location: index.php');
    return;
}

if(isset($_POST['cancel'])){
    header("Location: index.php");
    return;
}
if(isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])) {
    if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
        $_SESSION['error'] = "All fields is required";
        header("Location: edit.php?autos_id=".$_POST['autos_id']);
        return;
    } else {
        if (!isset($_POST['year']) || !isset($_POST['mileage']) || !is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
            $_SESSION['error'] = "Mileage and year must be numeric";
            header("Location: edit.php?autos_id=".$_POST['autos_id']);
            return;
        } else {
            $sql = "UPDATE autos SET make = :make,
                    model = :model,year = :year , mileage = :mileage
                    WHERE autos_id = :autos_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                    ':make' => $_POST['make'],
                    ':model' => $_POST['model'],
                    ':year' => $_POST['year'],
                    ':mileage' => $_POST['mileage'],
                    ':autos_id' => $_POST['autos_id']));
            $_SESSION['success'] = "Record edited";
            header("Location: index.php");

            return;
        }
    }
}
$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
}

?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body{
            width: 40%;
            height: 100%;
        }
        input{
            margin-bottom: 10px;
        }
        .container{
            margin-left:40%;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="container">
    <?php
    if($_SESSION['name']){
        echo ('<h1 style="font-size:36px;line-height: 1.1;font-weight: 500;">Tracking Autos for ');
        echo ($_SESSION['name']);
        echo ("</h1>");
    }
    if ( isset($_SESSION['error']) ) {
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
    $mk = htmlentities($row['make']);
    $mo = htmlentities($row['model']);
    $yr= htmlentities($row['year']);
    $mi= htmlentities($row['mileage']);
    $autos_id = $row['autos_id'];
    ?>
    <form method="POST">
        <label for="">Make:</label>
        <input type="text" name="make" size="60" value="<?= $mk ?>"><br>
        <label for="">Model:</label>
        <input type="text" name="model" size="60" value="<?= $mo ?>"><br>
        <label for="">Year:</label>
        <input type="text" name="year" value="<?= $yr ?>"><br>
        <label for="">Mileage</label>
        <input type="text" name="mileage" value="<?= $mi ?>"><br>
        <input type="hidden" name="autos_id" value="<?= $autos_id ?>">
        <input type="submit" value="Edit">
        <input type="submit" name="cancel" value="Cancel">
    </form>

</div>
</body>
</html>