<?php
// Создание экземпляра класса Validator
require_once('Validator.php');
$validator = new Validator();

// Добавление правила для проверки уникальности логина
$validator->addValidation('login', function ($value) {
    $users = file("users.txt", FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        list($existingLogin, $existingPassword) = explode(":", $user);
        if ($value === $existingLogin) {
            return false; // Логин уже существует
        }
    }
    return true; // Логин уникальный
}, 'Пользователь с таким логином уже существует');

// Добавление правила для проверки пароля
$validator->addValidation('password', function ($value) {
    return strlen($value) >= 6;
}, 'Пароль должен содержать минимум 6 символов');

$validator->addValidation('password', function ($value) {
    return preg_match("/[A-Z]/", $value);
}, 'Пароль должен содержать хотя бы одну заглавную букву');

$validator->addValidation('password', function ($value) {
    return preg_match("/\d/", $value);
}, 'Пароль должен содержать хотя бы одну цифру');
// Подготовка данных для проверки
$data = [
    'login' => $_POST['login'] ?? '',
    'password' => $_POST['password'] ?? '',
];

// Выполнение всех проверок
$errors = $validator->validateForm($data);

// Обработка ошибок
if (!empty($errors)) {
    foreach ($errors as $field => $fieldErrors) {
        foreach ($fieldErrors as $error) {
            echo "$field: $error<br>";
        }
    }
} else {
// Добавление пользователя в файл users.txt
    $hashedPassword = md5($data['password']);
    $userData = "{$data['login']}:{$hashedPassword}\n";
    file_put_contents("users.txt", $userData, FILE_APPEND);
    echo "Пользователь зарегистрирован";
}
