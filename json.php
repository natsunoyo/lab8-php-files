<?php
// Вказати директорію з JSON-файлами
define('SURVEY_FOLDER', __DIR__ . '/responses');

// Функція для парсингу JSON-файлів
function parseSurveyFiles($directory)
{
    $surveys = [];

    // Отримуємо всі JSON-файли з директорії
    $files = glob($directory . '/*.json');

    foreach ($files as $file) {
        $content = file_get_contents($file);

        // Декодуємо JSON у асоціативний масив
        $data = json_decode($content, true);

        // Перевіряємо, чи вдалося декодувати JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            continue; // Пропускаємо файли з помилками
        }

        // Додаємо дані до масиву
        $surveys[] = [
            'name' => $data['name'] ?? '',
            'email' => $data['email'] ?? '',
            'answers' => [
                'interests' => $data['answers']['interests'] ?? [],
                'japan' => $data['answers']['japan'] ?? '',
                'china' => $data['answers']['china'] ?? '',
                'country' => $data['answers']['country'] ?? ''
            ],
            'submitted_at' => $data['submitted_at'] ?? ''
        ];
    }

    return $surveys;
}

// Отримуємо дані
$surveys = parseSurveyFiles(SURVEY_FOLDER);

// Виводимо дані у форматі JSON
header('Content-Type: application/json');
echo json_encode($surveys, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>