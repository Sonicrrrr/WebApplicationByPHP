<?php
    session_start();
    require_once "config.php";
    $salt = 'XyZzy12*_';
    $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

    //Password = php123 , only check password
    if(isset($_POST['email']) || isset($_POST['pass'])){
        if(strlen($_POST['email']) < 1 || strlen($_POST['pass']) <1 ){
            $_SESSION['error'] = "Username and Password are required";
            header('Location: login.php');
            return;
        }
        elseif(strpos($_POST['email'],'@') == false){
            $_SESSION['error'] = 'Email must have an at-sign (@)';
            header('Location: login.php');
        }
        else{
            $check = hash('md5',$salt.$_POST['pass']);
            if($check == $stored_hash){
                $_SESSION['name'] = $_POST['email'];
                error_log("Login success ".$_POST['email']);
                header("Location: index.php");
                return;
            }
            else{
                error_log("Login fail ".$_POST['email']." $check");
                $_SESSION['error']= "Incorrect Password";
            }
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <div class="container">
        <h1>Please Log In</h1>
        <?php
            if(isset($_SESSION['error'])){
                echo ('<p style="color:red">').htmlentities($_SESSION['error']).("</p>\n");
                unset($_SESSION['error']);
            }
        ?>
        <form method="POST">
            <label for="nam">User Name</label>
            <input type="text" name="email" id="nam"><br>
            <label for="id1731">Password</label>
            <input type="password" name="pass" id="id1731"><br>
            <input type="submit" value="Log In">
            <a href="index.php">Cancel</a>
        </form>
    </div>
</body>
</html>