<?php
//создание файла
$file = fopen("file.txt", "w") or die("Ошибка создания файла!");

$fileContent = "1. William Smith, 1990, 2344455666677\n";
$fileContent .= "2. John Doe, 1988, 4445556666787\n";
$fileContent .= "3. Michael Brown, 1991, 7748956996777\n";
$fileContent .= "4. David Johnson, 1987, 5556667779999\n";
$fileContent .= "5. Robert Jones, 1992, 99933456678888\n";

file_put_contents("file.txt", $fileContent);

$fileContent = "6. James Wilson, 1993, 1234557890123\n";
$fileContent .= "7. Daniel Lee, 1994, 2345678301234\n";
$fileContent .= "8. Christopher Clark, 1995, 3256789012345\n";

file_put_contents("file.txt", $fileContent, FILE_APPEND);

$fileContent = file_get_contents("file.txt");
?>
    <div>Данные из файла:</div>
<?php
echo nl2br($fileContent);
