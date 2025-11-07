<?php
require_once '../../construct/admin_guard.php';
include "../../construct/functions.php";

$errors = [];
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$id) {
    die("Не указан ID записи для редактирования.");
}

// Получаем данные записи из базы
$stmt = $pdo->prepare("SELECT * FROM events_ WHERE Id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    die("Запись не найдена.");
}

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $title = trim($_POST['title'] ?? '');
    $date = $_POST['date'] ?? null;
    $short_description = trim($_POST['short_description'] ?? '');
    $content = $_POST['content'] ?? '';
    $topic = trim($_POST['topic'] ?? '');

    if ($title === '') {
        $errors[] = "Заголовок обязателен.";
    }
    if (empty($errors)) {


        if (empty($errors)) {
            // Обновляем запись в базе
            $stmt = $pdo->prepare("UPDATE events_ SET Title = ?, ArrangedAt = ?, Short = ?, Info = ?, Theme = ? WHERE Id = ?");
            $stmt->execute([
                $title,
                $date ?: null,
                $short_description,
                $content,
                $topic,
                $id
            ]);

            // Перенаправление после успешного обновления
            echo '<script>window.location.href = "../event-admin.php";</script>';
            exit;
        }
    }
} else {
    // При первом заходе заполняем форму из базы
    $title = $post['Title'];
    $date = $post['ArrangedAt'];
    $short_description = $post['Short'];
    $content = $post['Info'];
    $record_type = $post['Type'];
    $topic = $post['Theme'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Редактирование записи</title>
    <link rel="stylesheet" href="../../css/main.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/01be32f69c.js" crossorigin="anonymous"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet" />
    <style>
        .ql-editor {
            font-size: 22px;
            padding: 12px 15px;
        }
        .ql-toolbar {
            margin-left: 100px;
            width: 85%;
            border-radius: 0 0 5px 5px;
            border: solid black;
        }
        #editor-container {
            margin-top: 10px;
            margin-left: 100px;
            width: 85%;
        }
        #hidden-textarea {
            display: none;
        }
        .preview-image {
            margin-left: 100px;
            margin-top: 10px;
            max-width: 300px;
            max-height: 200px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <?php include("../../construct/Shapka_admin_inside.php"); ?>

    <div class="back" style="border-top: solid #d1cdcd;">
        <div class="posts col-9">
            <div style="margin-top: 40px;">
                <h2 style="text-align:center;"> Редактирование записи </h2>
            </div>
            <div>
                <?php if (!empty($errors)): ?>
                    <ul style="color: red; text-align: center;">
                        <?php foreach ($errors as $error): ?>
                            <li><?=htmlspecialchars($error)?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <form action="edit-event.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
                    <input name="title" type="text" placeholder="Заголовок" required
                        style="font-size: 28px; margin-left: 100px; width: 85%;"
                        value="<?= htmlspecialchars($title ?? '', ENT_QUOTES) ?>" />

                    <p style="font-size: 28px; margin-left: 100px; margin-top: 20px;"> Дата публикации/проведения </p>
                    <p style="font-size: 12px; margin-left: 100px; margin-top: 0px; color: grey;">
                        при наличии даты проведения ее необходимо указать
                    </p>
                    <input type="date" name="date"
                        style="font-size: 24px; margin-left: 100px; margin-top: 10px;"
                        value="<?= htmlspecialchars($date ?? '', ENT_QUOTES) ?>" />

                    <div style="margin-top: 20px;">
                        <p style="margin-top: 20px; margin-left: 100px; font-size: 28px;"> Краткое описание </p>
                        <textarea name="short_description" placeholder="2-3 предложения об информации внутри"
                            style="margin-top: 10px; margin-left: 100px; font-size: 22px; width: 85%;" rows="3"><?= htmlspecialchars($short_description ?? '', ENT_QUOTES) ?></textarea>
                    </div>

                    <textarea name="content" id="hidden-textarea"><?= htmlspecialchars($content ?? '', ENT_QUOTES) ?></textarea>

                    <p style="margin-top: 20px; margin-left: 100px; font-size: 28px;"> Основной контент </p>
                    <div id="editor-container" style=" background: white; height: 600px;"></div>


                    <label for="file-upload" style="display: block; margin-left: 100px; margin-top: 25px; font-weight: bold; color: #333;">
                        Выберите файл изображения для превью (если хотите заменить):
                    </label>
                    <input disabled type="file" id="file-upload" name="file" style="margin-left: 100px; width: 85%;" />

                    <label for="link-input" style="display: block; margin-left: 100px; margin-top: 20px; font-weight: bold; color: #333;">
                        Введите название видеоролика, если он есть:
                    </label>
                    <input name="file_vid" type="text" placeholder="Введите название" disabled
                        style="font-size: 28px; margin-left: 100px; width: 30%;"
                        value="<?= htmlspecialchars($file_vid ?? '', ENT_QUOTES) ?>" />

                    <select name="record_type" disabled
                        style="font-size: 20px; width: 220px; height: 36px; margin-top: 35px; margin-left: 100px; text-align: center;">
                        <option value=""> 
                            <?php
                            if($post['Type'] == 1) echo 'Статья';
                            else if($post['Type'] == 2)  echo 'Видео';
                            else if($post['Type'] == 3)  echo 'Мероприятие';
                            else  echo 'Вебинар';
                            ?>
                        </option>
                    </select>

                    <input name="topic" type="text" placeholder="Тема"
                        style="font-size: 20px; width: 220px; height: 36px; margin-top: 35px; margin-left: 100px; text-align: center;"
                        value="<?= htmlspecialchars($topic ?? '', ENT_QUOTES) ?>" />

                    <br>

                    <div>
                        <button name="edit_post" class="btn" type="submit"
                            style="margin-left: 43%; font-size: 24px; height: 50px; margin-top: 50px; margin-bottom: 50px;">
                            Сохранить изменения
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include("../../construct/footer.php"); ?>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        const quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'image'],
                    ['clean']
                ]
            },
            placeholder: 'Текст статьи'
        });

        // Заполняем редактор содержимым из textarea
        quill.root.innerHTML = <?= json_encode($content ?? '') ?>;

        quill.on('text-change', function() {
            document.getElementById('hidden-textarea').value = quill.root.innerHTML;
        });

        document.querySelector('form').onsubmit = function() {
            document.getElementById('hidden-textarea').value = quill.root.innerHTML;
            return true;
        };
    </script>
</body>
</html>
