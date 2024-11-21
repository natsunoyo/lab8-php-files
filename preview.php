<?php
// URL до json.php
$url = 'http://localhost/php-practice/json.php';

// Отримуємо JSON-дані
$jsonData = file_get_contents($url);

// Перевіряємо, чи вдалося отримати дані
if ($jsonData === false) {
    die('Не вдалося отримати дані з json.php.');
}

// Декодуємо JSON у PHP-об’єкти
$data = json_decode($jsonData, true);

// Перевіряємо, чи вдалося декодувати JSON
if (json_last_error() !== JSON_ERROR_NONE) {
    die('Помилка декодування JSON: ' . json_last_error_msg());
}

// Виводимо дані у HTML-таблицю
?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Перегляд анкет</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Список анкет</h1>
    <table>
        <thead>
            <tr>
                <th>Ім'я</th>
                <th>Email</th>
                <th>Інтереси</th>
                <th>Відповідь на питання про Японію</th>
                <th>Відповідь на питання про Китай</th>
                <th>Ваша відповідь на питання про країну</th>
                <th>Дата та час подачі</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $survey): ?>
                <tr>
                    <td><?php echo htmlspecialchars($survey['name']); ?></td>
                    <td><?php echo htmlspecialchars($survey['email']); ?></td>
                    <td><?php echo htmlspecialchars(implode(', ', $survey['answers']['interests'])); ?></td>
                    <td><?php echo htmlspecialchars($survey['answers']['japan']); ?></td>
                    <td><?php echo htmlspecialchars($survey['answers']['china']); ?></td>
                    <td><?php echo htmlspecialchars($survey['answers']['country']); ?></td>
                    <td><?php echo htmlspecialchars($survey['submitted_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>