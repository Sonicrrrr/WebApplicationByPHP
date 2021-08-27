<?php
session_start();
require_once "config.php";


if(!isset($_SESSION['name']) || strlen($_SESSION['name']) < 1){
    die('Name parameter missing');
}
if(isset($_POST['cancel'])){
    header("Location: index.php");
    return;
}
if(isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])) {
    if (!isset($_POST['make']) || strlen($_POST['make']) < 1 || !isset($_POST['model']) || strlen($_POST['model']) < 1 || !isset($_POST['year']) || strlen($_POST['year']) < 1 || !isset($_POST['mileage']) || strlen($_POST['mileage']) < 1) {
        $_SESSION['error'] = "All fields is required";
    } else {
        if (!isset($_POST['year']) || !isset($_POST['mileage']) || !is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
            $_SESSION['error'] = "Mileage and year must be numeric";
        } else {
            $stmt = $pdo->prepare('INSERT INTO autos(make, model, year, mileage) VALUES ( :mk, :mo,:yr, :mi)');
            $stmt->execute(array(
                    ':mk' => $_POST['make'],
                    ':mo' => $_POST['model'],
                    ':yr' => $_POST['year'],
                    ':mi' => $_POST['mileage'])
            );
            $_SESSION['success'] = "Record added";
            header("Location: index.php");
            return;
        }
    }
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
    if(isset($_SESSION['error'])){
        echo ('<p style="color:red;">').$_SESSION['error'].("</p>\n");
        unset($_SESSION['error']);
    }
    ?>
    <form method="POST">
        <label for="">Make:</label>
        <input type="text" name="make" size="60"><br>
        <label for="">Model:</label>
        <input type="text" name="model" size="60"><br>
        <label for="">Year:</label>
        <input type="text" name="year"><br>
        <label for="">Mileage</label>
        <input type="text" name="mileage"><br>
        <input type="submit" value="Add">
        <input type="submit" name="cancel" value="Cancel">
    </form>

</div>
</body>
</html>