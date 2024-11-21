<?php
// URL для отримання даних
$url = "http://lab.vntu.org/api-server/lab8.php?user=student&pass=p@ssw0rd";

// Ініціалізація cURL
$ch = curl_init($url);

// Налаштування cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Таймаут запиту
$response = curl_exec($ch);

// Перевірка на помилки
if (curl_errno($ch)) {
    die("Помилка cURL: " . curl_error($ch));
}

// Перевірка HTTP статусу
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($httpCode !== 200) {
    die("Помилка: сервер повернув HTTP-код $httpCode");
}

curl_close($ch);

// Перетворення JSON у PHP-масив
$dataArray = json_decode($response, true);

if ($dataArray === null) {
    die("Помилка декодування JSON");
}

// Об'єднання всіх записів у один масив
$people = [];
foreach ($dataArray as $group) {
    $people = array_merge($people, $group);
}

// Генерація HTML-таблиці
?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Дані про персонажів</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <h1>Дані про персонажів</h1>
    <table>
        <thead>
            <tr>
                <th>Ім'я</th>
                <th>Фракція</th>
                <th>Звання</th>
                <th>Локація</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($people as $person): ?>
                <tr>
                    <td><?= htmlspecialchars($person['name'] ?? 'Н/Д') ?></td>
                    <td><?= htmlspecialchars($person['affiliation'] ?? 'Н/Д') ?></td>
                    <td><?= htmlspecialchars($person['rank'] ?? 'Н/Д') ?></td>
                    <td><?= htmlspecialchars($person['location'] ?? 'Н/Д') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>