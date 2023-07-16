<?php
session_start();

// Подключение файла с пользователями
require_once 'users.php';

function getUsersList()
{
    global $users; // Объявление переменной $users как глобальной
    return $users;
}

function existsUser($login)
{
    $users = getUsersList();
    foreach ($users as $user) {
        if ($user["login"] === $login) {
            return true;
        }
    }
    return false;
}

function checkPassword($login, $password)
{
    $users = getUsersList();

    foreach ($users as $user) {
        if ($user["login"] != $login) {
            continue;
        }

        // Получение пароля пользователя
        $passwordUser = $user['password'];

        if (password_verify($password, $passwordUser)) {
            return true;
        }
    }
    return false;
}

function getCurrentUser()
{
    session_start();

    if (isset($_SESSION["user"])) {
        return $_SESSION["user"];
    }
    return null;
}

// Функция для получения оставшихся дней до Дня рождения пользователя
function getRemainingDays($currentDate, $userBirthday)
{
    $currentYear = date('Y');
    $currentYearBirthday = date('Y') . '-' . date('m-d', strtotime($userBirthday));
    $nextYearBirthday = ($currentYear + 1) . '-' . date('m-d', strtotime($userBirthday));

    if ($currentDate < $currentYearBirthday) {
        $nextBirthday = $currentYearBirthday;
    } else {
        $nextBirthday = $nextYearBirthday;
    }

    $remainingDays = floor((strtotime($nextBirthday) - strtotime($currentDate)) / (60 * 60 * 24));

    return $remainingDays;
}

function getEntryTime()
{
    if (isset($_SESSION['entry_time'])) {
        return $_SESSION['entry_time'];
    }
    return false;
}

function getTimeRemain()
{
    // Время входа пользователя на сайт
    $entryTime = getEntryTime();

    if (!$entryTime) {
        return [
            'remainingHours' => '',
            'remainingMinutes' => '',
            'remainingSeconds' => ''
        ];
    }

// Время, через которое истекает персональная скидка (24 часа)
    $discountExpirationTime = $entryTime + (24 * 60 * 60);

// Текущее время
    $currentTime = time();
    $remainingTime = $discountExpirationTime - $currentTime;

// Вычисляем оставшееся время до истечения персональной скидки
    return [
        'remainingHours' => floor($remainingTime / 3600),
        'remainingMinutes' => floor(($remainingTime % 3600) / 60),
        'remainingSeconds' => $remainingTime % 60,
    ];
}

function getUserBirthday()
{
    $userCurrent = getCurrentUser();
    $users = getUsersList();

    $user2Birthday = '';
    foreach ($users as $user) {
        if ($user['login'] === $userCurrent && isset($user['birthday'])) {
            $user2Birthday = $user['birthday'];
            break;
        }
    }

    return $user2Birthday;
}

function setUserBirthday($birthday, $currentUser)
{
    $users = getUsersList();

    foreach ($users as $index => $value) {
        if ($currentUser === $value['login']) {
            $users[$index]['birthday'] = $birthday;
        }
    }

    // Записываем обновленный массив $users в файл
    $fileContents = '<?php' . PHP_EOL;
    $fileContents .= '$users = ' . var_export($users, true) . ';' . PHP_EOL;
    file_put_contents('users.php', $fileContents);
}

?>