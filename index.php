<?php
require_once 'functions.php';
?>
<? $currentUser = getCurrentUser(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>SPA Salon</title>
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

<div class="container">
    <div class="col-sm-6 text-left">
        <?php if ($currentUser): ?>
            привет, <b><?= $currentUser ?></b>!
        <? endif; ?>
    </div>
    <div class="col-sm-6 text-right">
        <?php if ($currentUser): ?>
            <a href="logout.php" class="btn btn-warning">Выйти</a>
        <? else: ?>
            <a href="login.php" class="btn btn-info">Login</a>
        <? endif; ?>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="banner">
                <? if ($currentUser): ?>
                    <div class="discount"><?
                        $remain = getTimeRemain();

                        if ($remain['remainingSeconds'] >= 0) {

                            // Форматируем оставшееся время в часы, минуты и секунды
                            $remainingHours = $remain['remainingHours'];
                            $remainingMinutes = $remain['remainingMinutes'];
                            $remainingSeconds = $remain['remainingSeconds'];

                            // Выводим оставшееся время
                            echo "До истечения персональной<br/>скидки осталось:<br/>";
                            echo $remainingHours . " часов, ";
                            echo $remainingMinutes . " минут, ";
                            echo $remainingSeconds . " секунд.";
                        }
                        ?></div>
                <? endif; ?>

            </div>
            <? if (getUserBirthday() && $currentUser): ?>
                <div class="birthday"><?
                    $currentDate = new DateTime(); // Текущая дата
                    $targetDate = DateTime::createFromFormat('Y-m-d', getUserBirthday()); // Заданная дата
                    ?>
                    <? if ($currentDate->format('Y-m-d') == $targetDate->format('Y-m-d')): ?>
                        С Днем рождения! Поздравляем вас с особенным днем!<br>
                        Вы получаете персональную скидку 5% на все услуги салона!;
                    <? else: ?>
                        <? $remainingDays = getRemainingDays($currentDate->format('Y-m-d'), $targetDate->format('Y-m-d')); ?>
                        До вашего Дня рождения осталось <?= $remainingDays ?>  дней.<br/><br/>
                    <? endif; ?></div>
            <? endif; ?>


            <? if (!getUserBirthday() && $currentUser): ?>
                <form method="POST" action="process_birthday.php">
                    <label for="birthday">Дата рождения:</label>
                    <input type="date" id="birthday" name="birthday" required>
                    <input type="submit" value="Получить скидку">
                </form>
            <? endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h2>услуги </h2>
        </div>
        <div class="col-sm-4">
            <div class="service one">
                <p>Skin Care</p>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="service two">
                <p>Body Treatment</p>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="service tri">
                <p>Massage</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
