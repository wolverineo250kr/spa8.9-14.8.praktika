<?php
require_once 'functions.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Вход</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link href="/css/index.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
<?php
require_once('functions.php');

session_start();

if (isset($_SESSION['user'])) {
    die("<script>location.href = '/'</script>");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if (existsUser($login) && checkPassword($login, $password)) {
        $_SESSION['user'] = $login;
        $_SESSION['entry_time'] = time();

        die("<script>location.href = '/'</script>");
        exit();
    } else {
        echo "Неверный логин или пароль.";
    }
}
?>
<div class="row">
    <div class="col-sm-12">
        <div class="banner">
            <div class="row">
                <div class="col-sm-12">
                    <h1>Войдите</h1>
                    <form action="login.php" method="POST"><br/>
                        <label for="login">Логин:</label>
                        <input type="text" name="login" id="login" required><br>

                        <label for="password">Пароль:</label>
                        <input type="password" name="password" id="password" required><br>

                        <input class="btn btn-success" type="submit" value="войти">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>