<?php

session_start();
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

function uploadImage($file, $type, &$errors) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExts)) {
        $errors[] = 'Недопустимый тип файла изображения.';
    }

    $uploadDir = '../Info/' . $type . '/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileName = uniqid() . '.' . $ext;
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        return $fileName;
    } else {
        $errors[] = 'Ошибка при загрузке файла.';
    }
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