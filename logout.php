<?php
// Очистка данных сессии и перенаправление на главную страницу
session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit();
?>