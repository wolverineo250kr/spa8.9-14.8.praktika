<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'functions.php';

    $dateString = $_POST['birthday'];
    $format = 'Y-m-d';

    $date = DateTime::createFromFormat($format, $dateString);

    if ($date && $date->format($format) === $dateString && strlen($dateString) === 10) {
        // Дата прошла валидацию
        // Получаем значение даты рождения из формы
        $birthday = $_POST['birthday'];
        $currentUser = getCurrentUser();
        setUserBirthday($birthday, $currentUser);

        // Перенаправляем пользователя на главную
        die("<script>location.href = '/'</script>");
        exit;
    } else {
        // Дата не прошла валидацию
        echo "Некорректный формат даты рождения.";
        die();
    } 
}
?>
