<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'functions.php';

    // Получаем значение даты рождения из формы
    $birthday = $_POST['birthday'];
    $currentUser = getCurrentUser();
    setUserBirthday($birthday, $currentUser);

    // Перенаправляем пользователя на главную
    die("<script>location.href = '/'</script>");
    exit;
}
?>
