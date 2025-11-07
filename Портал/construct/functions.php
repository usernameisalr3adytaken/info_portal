<?php


require 'connect.php';

function tt($value){
    echo '<pre>';
    print_r($value);
    echo '</pre>';
}

function russianDate($date) {
    $months = [
        1 => 'января', 2 => 'февраля', 3 => 'марта',
        4 => 'апреля', 5 => 'мая', 6 => 'июня',
        7 => 'июля', 8 => 'августа', 9 => 'сентября',
        10 => 'октября', 11 => 'ноября', 12 => 'декабря'
    ];
    $timestamp = strtotime($date);
    $day = date('j', $timestamp);
    $month = $months[date('n', $timestamp)];
    $year = date('Y', $timestamp);
    return "$day $month $year";
}

function rusMonthYear($date) {
    $months = [
        1 => 'января', 2 => 'февраля', 3 => 'марта',
        4 => 'апреля', 5 => 'мая', 6 => 'июня',
        7 => 'июля', 8 => 'августа', 9 => 'сентября',
        10 => 'октября', 11 => 'ноября', 12 => 'декабря'
    ];
    $timestamp = strtotime($date);
    $month = $months[date('n', $timestamp)];
    $year = date('Y', $timestamp);
    return "$month $year";
}

function dbCheckError($query){
    $errInfo = $query->errorInfo();
    if ($errInfo[0] !== PDO::ERR_NONE){
        echo $errInfo[2];
        exit();
    }
    return true;
}

function selectOne($table, $params = []){
    global $pdo;
    $sql = "SELECT * FROM $table";

    if(!empty($params)){
        $i = 0;
        foreach ($params as $key => $value){
            if (!is_numeric($value)){
                $value = "'".$value."'";
            }
            if ($i === 0){
                $sql = $sql . " WHERE $key=$value";
            }else{
                $sql = $sql . " AND $key=$value";
            }
            $i++;
        }
    }

    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetch();
}

function selectAll($table, $params = []){
    global $pdo;
    $sql = "SELECT * FROM $table";

    if(!empty($params)){
        $i = 0;
        foreach ($params as $key => $value){
            if (!is_numeric($value)){
                $value = "'".$value."'";
            }
            if ($i === 0){
                $sql = $sql . " WHERE $key=$value";
            }else{
                $sql = $sql . " AND $key=$value";
            }
            $i++;
        }
    }

    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

function searchInTitleInfo($text, $table){
    $text = trim(strip_tags(stripcslashes(htmlspecialchars($text))));
    global $pdo;
    $sql = 
        "SELECT * FROM $table
        WHERE Title LIKE '%$text%' OR Info LIKE '%$text%' ";

    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

function searchInTitleShort($text, $table){
    $text = trim(strip_tags(stripcslashes(htmlspecialchars($text))));
    global $pdo;
    $sql = 
        "SELECT * FROM $table
        WHERE Title LIKE '%$text%' OR Short LIKE '%$text%' ";

    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

function getThemes($table){
    global $pdo;

    $sql = "SELECT DISTINCT Theme FROM $table";
    $Themes = $pdo->prepare($sql);
    $Themes->execute();
    dbCheckError($Themes);
    return $Themes->fetchAll();
}

function getTime($table) {
    global $pdo;

    // Получаем минимальный и максимальный год из таблицы
    $sql = "SELECT MIN(YEAR(Published)) AS min_year, MAX(YEAR(Published)) AS max_year FROM " . $table;
    $stmt = $pdo->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result || $result['min_year'] === null || $result['max_year'] === null) {
        // Если данных нет, возвращаем пустой массив
        return [];
    }

    $minYear = (int)$result['min_year'];
    $maxYear = (int)$result['max_year'];

    // Формируем массив годов от minYear до maxYear включительно
    return range($minYear, $maxYear);
}
function getTime2($table) {
    global $pdo;

    // Получаем минимальный и максимальный год из таблицы
    $sql = "SELECT MIN(YEAR(ArrangedAt)) AS min_year, MAX(YEAR(ArrangedAt)) AS max_year FROM " . $table;
    $stmt = $pdo->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result || $result['min_year'] === null || $result['max_year'] === null) {
        // Если данных нет, возвращаем пустой массив
        return [];
    }

    $minYear = (int)$result['min_year'];
    $maxYear = (int)$result['max_year'];

    // Формируем массив годов от minYear до maxYear включительно
    return range($minYear, $maxYear);
}

function getWithFilter($table, $selectedTheme = '', $selectedYear = '', $selectedMonth = '') {
    global $pdo;

    $where = [];
    $params = [];

    // Фильтр по теме
    if ($selectedTheme !== '') {
        $where[] = "Theme = :theme";
        $params[':theme'] = $selectedTheme;
    }

    // Фильтр по году
    if ($selectedYear !== '') {
        $where[] = "YEAR(Published) = :year";
        $params[':year'] = (int)$selectedYear;
    }

    // Фильтр по месяцу
    if ($selectedMonth !== '') {
        $where[] = "MONTH(Published) = :month";
        $params[':month'] = (int)$selectedMonth;
    }

    // Формируем SQL-запрос
    $sql = "SELECT * FROM $table";
    if (count($where) > 0) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }
    $sql .= " ORDER BY Published DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getWithFilter2($table, $selectedTheme = '', $selectedYear = '', $selectedMonth = '') {
    global $pdo;

    $where = [];
    $params = [];

    // Фильтр по теме
    if ($selectedTheme !== '') {
        $where[] = "Theme = :theme";
        $params[':theme'] = $selectedTheme;
    }

    // Фильтр по году
    if ($selectedYear !== '') {
        $where[] = "YEAR(ArrangedAt) = :year";
        $params[':year'] = (int)$selectedYear;
    }

    // Фильтр по месяцу
    if ($selectedMonth !== '') {
        $where[] = "MONTH(ArrangedAt) = :month";
        $params[':month'] = (int)$selectedMonth;
    }

    // Формируем SQL-запрос
    $sql = "SELECT * FROM $table";
    if (count($where) > 0) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }
    $sql .= " ORDER BY ArrangedAt DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getFreshSix(array $tables){
    global $pdo;
    
    $unionParts = [];
    foreach ($tables as $table) {
        $unionParts[] = "SELECT *, '$table' AS source_table FROM `$table`";
    }
    $unionQuery = implode(" UNION ALL ", $unionParts);
    $sql = "SELECT * FROM ($unionQuery) AS combined ORDER BY Published DESC LIMIT 6";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();

}

function uploadImage(array $file, string $uploadDir): array {
    // Безопасная загрузка изображений
    // Возвращает ['ok'=>bool, 'path'=>string|null, 'error'=>string|null]
    // Требования:
    // - Проверка размера, MIME и структуры файла
    // - Запрет двойных расширений и нестандартных типов
    // - Генерация безопасного имени файла и установка прав
    // - Перемещение только через move_uploaded_file

    if (!isset($file['error'], $file['tmp_name'], $file['name'], $file['size'])) {
        return ['ok' => false, 'path' => null, 'error' => 'Некорректный массив файла'];
    }

    // 1) Проверка ошибок PHP
    if (!is_int($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        $codeMap = [
            UPLOAD_ERR_INI_SIZE   => 'Размер файла превышает upload_max_filesize',
            UPLOAD_ERR_FORM_SIZE  => 'Размер файла превышает MAX_FILE_SIZE',
            UPLOAD_ERR_PARTIAL    => 'Файл загружен частично',
            UPLOAD_ERR_NO_FILE    => 'Файл не был загружен',
            UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная директория',
            UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск',
            UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку',
        ];
        $msg = $codeMap[$file['error']] ?? 'Ошибка загрузки файла';
        return ['ok' => false, 'path' => null, 'error' => $msg];
    }

    // 2) Ограничение размера (например, 5 МБ)
    $MAX_SIZE = 5 * 1024 * 1024; // 5 MiB
    if (!is_int($file['size']) || $file['size'] <= 0 || $file['size'] > $MAX_SIZE) {
        return ['ok' => false, 'path' => null, 'error' => 'Недопустимый размер файла (максимум 5 МБ)'];
    }

    // 3) Запрет двоичных расширений типа "shell.php.jpg"
    $name = $file['name'];
    // Нормализуем имя (только базовое имя)
    $baseName = basename($name);
    // Проверяем на дополнительные точки кроме одной перед расширением
    $dotCount = substr_count($baseName, '.');
    if ($dotCount != 1) {
        return ['ok' => false, 'path' => null, 'error' => 'Недопустимое имя файла'];
    }

    // 4) Разрешённые расширения и строгая мапа MIME
    $allowed = [
        'jpg'  => ['image/jpeg'],
        'jpeg' => ['image/jpeg'],
        'png'  => ['image/png'],
        'gif'  => ['image/gif'],
        'webp' => ['image/webp'],
    ];

    $ext = strtolower(pathinfo($baseName, PATHINFO_EXTENSION));
    if (!array_key_exists($ext, $allowed)) {
        return ['ok' => false, 'path' => null, 'error' => 'Недопустимый тип файла'];
    }

    // 5) Проверка реального MIME через finfo
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']) ?: '';
    if ($mime === '' || !in_array($mime, $allowed[$ext], true)) {
        return ['ok' => false, 'path' => null, 'error' => 'Файл не является валидным изображением (MIME)'];
    }

    // 6) Доп.проверка структуры изображения
    $imageInfo = @getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        return ['ok' => false, 'path' => null, 'error' => 'Файл не является валидным изображением (структура)'];
    }
    // Желаемые пределы на размеры (например, до 8000x8000)
    $maxW = 8000; $maxH = 8000;
    if ($imageInfo[0] <= 0 || $imageInfo[1] <= 0 || $imageInfo[0] > $maxW || $imageInfo[1] > $maxH) {
        return ['ok' => false, 'path' => null, 'error' => 'Недопустимые размеры изображения'];
    }

    // 7) Проверка и подготовка директории
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0750, true)) {
            return ['ok' => false, 'path' => null, 'error' => 'Не удалось создать директорию загрузки'];
        }
    }
    if (!is_writable($uploadDir)) {
        return ['ok' => false, 'path' => null, 'error' => 'Директория загрузки недоступна для записи'];
    }

    // 8) Генерация безопасного имени файла (без исходного basename)
    // Используем префикс и случайный компонент
    $random = bin2hex(random_bytes(16));
    $targetName = 'img_' . $random . '.' . $ext;
    $targetPath = rtrim($uploadDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $targetName;

    // 9) Перемещаем только через move_uploaded_file
    if (!is_uploaded_file($file['tmp_name'])) {
        return ['ok' => false, 'path' => null, 'error' => 'Некорректный временный файл'];
    }

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['ok' => false, 'path' => null, 'error' => 'Не удалось сохранить файл'];
    }

    // 10) Жёсткие права на сохранённый файл
    @chmod($targetPath, 0640);

    // 11) Дополнительно: при желании можно делать "re-encode" (пересохранение) в безопасный формат,
    // чтобы отрезать двоичные хвосты/метаданные (не делаем здесь для простоты).

    return ['ok' => true, 'path' => $targetPath, 'error' => null];
}

function openType($type){
    if ($type == 1)
        return "article-inside.php?post=";
    else if ($type == 2)
        return "video-inside.php?video=";
    else if ($type == 3)
        return "event-inside.php?event=";
    else{
        return "vebinar-inside.php?activ=";
    }
}

function deletePostById($id, $table) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT Preview FROM {$table} WHERE Id = ?");
    $stmt->execute([$id]);
    $file = $stmt->fetchColumn();

    if ($file) {
        global $help;
        if ($table == 'posts') $help = 'Posts/';
        else if ($table == 'videos') $help = 'Videos/';
        else if ($table == 'events_') $help = 'Events/';
        else $help = 'Activities/';

        $filePath = __DIR__.'/../Info/'.$help.$file;
        if (file_exists($filePath)) {
            unlink($filePath); // удаляем файл с диска
        }
    }

    $stmt = $pdo->prepare("DELETE FROM $table WHERE Id = ?");
    $stmt->execute([$id]);
}

?>