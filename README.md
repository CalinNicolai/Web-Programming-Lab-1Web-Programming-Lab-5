# Отчет по Пятой лабораторной работе

## 1. Инструкции по запуску проекта

Данные инструкции действительны при использовании PhpStorm, в ином случае, воспользуйтесь приведенной ссылкой:
[запуск проекта с gitHub](https://www.youtube.com/watch?v=6N6JFynR0gM)

1. Клонируйте репозиторий:
   ```bash
   https://github.com/CalinNicolai/Web-Programming-Lab-5.git
2. Запустите проект:
   <!-- Если у вас есть веб-сервер (например, Apache или Nginx), настройте его так, чтобы корневой каталог указывал на
   каталог вашего проекта.  
   Если у вас нет веб-сервера, вы можете использовать встроенный сервер PHP для тестирования: -->
   ```bash 
   php -S localhost:8000 task1.php

## 2. Описание проекта

В данной лабораторной работе была изучены способы работы с файлами на языке PHP.

## 3. Краткая документация к проекту

#### Регистрация пользователя и сохранение его логина и пароля в файле.

```PHP
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
```

## 4. Пример использования проекта (с приложением скриншотов)

![Пример работы программы](/Images/1.png)

## 5. Задания:

1.  Запись и чтение из файла:

    -   Создать файл `file.txt` и записать в него данные о пользователях.
    -   Добавить еще 3 записи в файл.
2.  Запись в файл с помощью функции `file_put_contents()`:

    -   Заменить использование функции `fwrite` на `file_put_contents`.
    -   Объяснить различия между функциями `fwrite` и `file_put_contents`.
3.  Обработка форм и файлов:

    -   Создать форму для ввода имени, возраста и email.
    -   Сохранить данные из формы в файл `messages.txt`.
4.  Регистрация и авторизация пользователей:

    -   Создать форму регистрации с полями логина и пароля.
    -   Создать PHP-скрипт для обработки данных формы регистрации:
        -   Проверить заполненность полей.
        -   Зашифровать пароль с помощью `md5`.
        -   Сохранить данные в файл `users.txt`.
    -   Создать форму авторизации с полями логина и пароля.
    -   Создать PHP-скрипт для обработки данных формы авторизации:
        -   Проверить заполненность полей.
        -   Проверить существование пользователя в файле `users.txt`.
        -   Перенаправить на другую страницу при успешной авторизации.