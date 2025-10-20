<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_post'])) {
    $title = trim($_POST['title'] ?? '');
    $shortDescription = trim($_POST['short_description'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $topic = trim($_POST['topic'] ?? '');
    $recordType = $_POST['record_type'] ?? '';
    $dateConducted = $_POST['date'] ?? null;
    $currentDate = date('Y-m-d');
    $fileVid = trim($_POST['file_vid'] ?? '');

    if (!$title) {
        $errors[] = 'Введите заголовок.';
    }
    else{
        switch ($recordType) {
            case 'Статья':
                $imagePath = uploadImage($_FILES['file'], "Posts", $errors);
                if (!$imagePath){
                    $errors[] = 'Для добавления записи обязательно загрузите изображение';
                }
                else{
                    $sql = "INSERT INTO posts (Title, Short, Published, Info, Preview, Theme) VALUES (:title, :short, :published, :info, :preview, :theme)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ':title' => $title,
                        ':short' => $shortDescription,
                        ':published' => $currentDate,
                        ':info' => $content,
                        ':preview' => $imagePath,
                        ':theme' => $topic
                    ]);                     
                }
                break;

            case 'Видео':
                $imagePath = uploadImage($_FILES['file'], "Videos", $errors);
                if (!$fileVid) {
                    $errors[] = 'Для ролика обязательно загрузите видео.';
                }
                else if (!$imagePath){
                    $errors[] = 'Для добавления записи обязательно загрузите изображение';
                }
                else{
                    $sql = "INSERT INTO videos (Title, Short, Published, Preview, Video, Theme) VALUES (:title, :short, :published, :preview, :video, :theme)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ':title' => $title,
                        ':short' => $shortDescription,
                        ':published' => $currentDate,
                        ':preview' => $imagePath,
                        ':video' => $fileVid,
                        ':theme' => $topic
                    ]);
                }
                break;

            case 'Мероприятие':
                $imagePath = uploadImage($_FILES['file'], "Events", $errors);
                if (!$dateConducted) {
                    $errors[] = 'Для мероприятия обязательно укажите дату проведения.';
                }
                else if (!$imagePath){
                    $errors[] = 'Для добавления записи обязательно загрузите изображение';
                }
                else{
                    $sql = "INSERT INTO events_ (Title, Short, ArrangedAt, Info, Preview, Theme) VALUES (:title, :short, :arrangedAt, :info, :preview, :theme)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ':title' => $title,
                        ':short' => $shortDescription,
                        ':arrangedAt' => $dateConducted,
                        ':info' => $content,
                        ':preview' => $imagePath,
                        ':theme' => $topic
                    ]);
                }
                break;

            case 'Вебинар':
                $imagePath = uploadImage($_FILES['file'], "Activities", $errors);
                if (!$dateConducted) {
                    $errors[] = 'Для вебинара обязательно укажите дату проведения.';
                }
                else if (!$imagePath){
                    $errors[] = 'Для добавления записи обязательно загрузите изображение';
                }
                else{
                    $sql = "INSERT INTO activities (Title, Short, ArrangedAt, Info, Preview, Theme) VALUES (:title, :short, :arrangedAt, :info, :preview, :theme)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ':title' => $title,
                        ':short' => $shortDescription,
                        ':arrangedAt' => $dateConducted,
                        ':info' => $content,
                        ':preview' => $imagePath,
                        ':theme' => $topic
                    ]);
                }
                break;

            default:
                $errors[] = 'Неверный тип записи.';
        }
    }

    if (count($errors) == null){
        echo '
            <div id="modal" class="modal-overlay">
                <div class="modal-content">
                    <p class="modal-message">Запись успешно добавлена</p>
                    <button id="okBtn" class="modal-btn">ОК</button>
                </div>
            </div>

            <style>
            /* Анимация появления */
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }

            @keyframes slideUp {
                from { transform: translateY(20px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }

            /* Основные стили модального окна */
            .modal-overlay {
                position: fixed;
                left: 0;
                top: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0,0,0,0.5);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 9999;
                backdrop-filter: blur(5px);
                animation: fadeIn 0.3s ease-out;
            }

            .modal-content {
                background: #fff;
                padding: 40px 50px;
                border-radius: 16px;
                text-align: center;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
                max-width: 450px;
                width: 90%;
                animation: slideUp 0.4s cubic-bezier(0.22, 1, 0.36, 1);
                border: 1px solid rgba(255,255,255,0.2);
            }

            .modal-message {
                font-size: 20px;
                margin-bottom: 30px;
                color: #333;
                line-height: 1.5;
                font-weight: 500;
            }

            /* Стили кнопки */
            .modal-btn {
                background: linear-gradient(135deg,rgb(251, 110, 110),rgb(227, 119, 119));
                color: white;
                border: none;
                padding: 12px 30px;
                font-size: 16px;
                border-radius: 50px;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(251, 110, 110, 0.3);
                font-weight: 600;
                letter-spacing: 0.5px;
                min-width: 120px;
            }

            .modal-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(110, 142, 251, 0.4);
            }

            .modal-btn:active {
                transform: translateY(0);
            }

            /* Адаптивность */
            @media (max-width: 600px) {
                .modal-content {
                    padding: 30px 20px;
                }
                
                .modal-message {
                    font-size: 18px;
                }
            }
            </style>

                <script>
                    document.getElementById("okBtn").onclick = function() {
                        window.location.href = "create-edit.php"; // Замените на нужный адрес
                    }
                </script>
                ';
    }
}
?>