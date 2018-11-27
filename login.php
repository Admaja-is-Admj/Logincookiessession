<?php
    session_start();
    if (isset($_COOKIE['login'])) {
        if ($_COOKIE['login']=='true') {
            $_SESSION['login'] = true;
        }
    }
    if(isset($_SESSION["login"])){
        header("location:index.php");
        exit;
    }
    require 'functions.php';
    if (isset($_POST["login"])) {
        $username=$_POST["username"];
        $password=$_POST["password"];

        $result=mysqli_query($conn,"SELECT * FROM user WHERE username='$username'");

        //cek username
        //mysqli_num_rows=untuk menghitung ada berapa baris yang akan dikembaikan oleh parameter
        //kalau ada yang dikembalikan nilainya adlaah 1 kalau enggak ada nilainya 0

        if (mysqli_num_rows($result)===1) {
            $row=mysqli_fetch_assoc($result);
            if ($key=== hash('sha256',$row['username'])) {
                $_SESSION['login'] = true;
            }
            if (password_verify($password,$row["password"])) {
                $_SESSION["login"] =true;
                if (isset($_POST['remember'])) {
                    setcookie('id',$row['id'],time()+60)
                    setcookie('key',hash(sha256,$row['username']),time()+60);
                }
                header("Location:index.php");
                exit;
            }
        }
        $error=true;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <h1 align="center">Halaman Login</h1>
    <?php if (isset($error)):?>
        <p style = "color:red;font-style=bold"?>
        Username dan password salah</p>
    <?php endif?>
    <form action="" method="POST" class="form-horizontal" role="form">
            <div class="form-group">
                <label for="username" class="col-sm-2 control-label">Username:</label>
                <div class="col-sm-10">
                    <input type="text" name="username" id="username" class="form-control"required="required">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">Password:</label>
                <div class="col-sm-10">
                    <input type="password" name="password" id="input" class="form-control" required="required">
                </div>
            </div>
            <div class="checkbox col-sm-10 col-sm-offset-2">
                <label>
                    <input type="checkbox" value="">
                    remember
                </label>
            </div>
            
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </div>
    </form>
</body>
</html>