<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php
if (!isset($_REQUEST['start'])) { ?>
    <form class="p-3" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Ваше имя:</label>
            <input id="name" name="name" type="text" class="form-control" placeholder="Введите ваше имя" required>
        </div>
        <div class="mb-3">
            <label for="age" class="form-label">Ваш возраст:</label>
            <input id="age" name="age" type="number" class="form-control" placeholder="Введите ваш возраст" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Ваш E-mail:</label>
            <input id="email" name="email" type="email" class="form-control" placeholder="Введите ваш email" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Ваше мнение о нас:</label>
            <textarea id="message" name="message" class="form-control" rows="4" placeholder="Напишите ваше мнение"
                      required></textarea>
        </div>
        <div class="mb-3">
            <button type="reset" class="btn btn-secondary">Стереть</button>
            <button type="submit" class="btn btn-primary" name="start">Передать</button>
        </div>
    </form>
<?php } else {
    // Данные с формы
    $data = [
        'name' => $_POST['name'] ?? "",
        'age' => $_POST['age'] ?? "",
        'email' => $_POST['email'] ?? "",
        'message' => $_POST['message'] ?? "",
    ];
    // Сохранение данных в файл
    $file = fopen('messages.txt', 'a+') or die("Недоступный файл!");
    foreach ($data as $field => $value) {
        fwrite($file, "$field: $value\n");
    }
    fwrite($file, "\n");
    fclose($file);
    ?>
    <div class="alert alert-success">Данные были сохранены! Вот что хранится в файле:</div>
    <?php
    $file = fopen("messages.txt", "r") or die("Недоступный файл!");
    while (!feof($file)) {
        $line = fgets($file);
        if (!empty($line)) {
            ?>
            <div class="card">
                <div class="card-body">
                    <p class="card-text"><?= $line ?></p>
                </div>
            </div>
            <?php
        }
    }
    fclose($file);

}

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
