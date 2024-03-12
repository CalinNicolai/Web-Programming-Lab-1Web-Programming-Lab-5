<?php
require_once('Validator.php');

$data = [
    'login' => $_POST['login'] ?? '',
    'password' => $_POST['password'] ?? '',
];

$validator = new Validator();

$validator->addValidation('login', function ($value) {
    return $value;
}, 'Логин не введен');

$validator->addValidation('login', function ($value) {
    $users = file("users.txt", FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        list($existingLogin, $existingPassword) = explode(":", $user);
        if ($value === $existingLogin) {
            return true;
        }
    }
    return false; // Логин уникальный
}, 'Неверный логин или пароль');

$validator->addValidation('password', function ($value) use ($data) {
    $users = file("users.txt", FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        list($existingLogin, $existingPassword) = explode(":", $user);
        if ($data['login'] === $existingLogin && md5($value) === $existingPassword) {
            return true;
        }
    }
    return false; // Пароль неверный
}, 'Неверный логин или пароль');


$errors = $validator->validateForm($data);

$firstError = null;
foreach ($errors as $field => $fieldErrors) {
    foreach ($fieldErrors as $error) {
        $firstError = $error;
        break 2; // Выход из обоих циклов
    }
}

if ($firstError !== null) {
    echo $firstError;
} else {
    echo "Пользователь авторизован";
}
