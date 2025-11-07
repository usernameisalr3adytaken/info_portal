<?php
    require_once '../construct/admin_guard.php';
    include "../construct/functions.php";

    include "../construct/add.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Создание записи</title>
    <link rel="stylesheet" href="../css/main.css" />
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
    </style>
</head>
<body>
    <?php include("../construct/Shapka_admin.php"); ?>

    <div class="back" style="border-top: solid #d1cdcd;">
        <div class="posts col-9">
            <div style="margin-top: 40px;">
                <h2 style="text-align:center;"> Добавление записи </h2>
            </div>
            <div>
                <form action="create-edit.php" method="post" enctype="multipart/form-data">
                    <input name="title"
                    value="<?php echo htmlspecialchars($_POST['title'] ?? '', ENT_QUOTES); ?>"
                      type="text" placeholder="Заголовок" required style="font-size: 28px; margin-left: 100px; width: 85%;" />

                    <p style="font-size: 28px; margin-left: 100px; margin-top: 20px;"> Дата публикации/проведения </p>
                    <p style="font-size: 12px; margin-left: 100px; margin-top: 0px; color: grey;"> при наличии даты проведения ее необходимо указать</p>
                    <input value="<?php echo htmlspecialchars($_POST['date'] ?? '', ENT_QUOTES); ?>" type="date" name="date" style="font-size: 24px; margin-left: 100px; margin-top: 10px;" />

                    <div style="margin-top: 20px;">
                        <p style="margin-top: 20px; margin-left: 100px; font-size: 28px;"> Краткое описание </p>
                        <textarea name="short_description" placeholder="2-3 предложения об информации внутри" 
                        style="margin-top: 10px; margin-left: 100px; font-size: 22px; width: 85%;" rows="3"><?php echo htmlspecialchars($_POST['short_description'] ?? '', ENT_QUOTES); ?></textarea>
                    </div>

                    <textarea name="content" id="hidden-textarea" ><?php echo htmlspecialchars($_POST['content'] ?? '', ENT_QUOTES); ?></textarea>

                    <p style="margin-top: 20px; margin-left: 100px; font-size: 28px;"> Основной контент </p>
                    <div id="editor-container" style=" background: white; height: 600px;"></div>

                    <label for="file-upload" style="display: block; margin-left: 100px; margin-top: 25px; font-weight: bold; color: #333;"> Выберите файл изображения для превью: </label>
                    <input type="file" id="file-upload" name="file" style="margin-left: 100px; width: 85%;" />

                    <label for="link-input" style="display: block; margin-left: 100px; margin-top: 20px; font-weight: bold; color: #333;"> Введите название видеоролика, если он есть: </label>
                    <input name="file_vid" value="<?php echo htmlspecialchars($_POST['file_vid'] ?? '', ENT_QUOTES); ?>"
                      type="text" placeholder="Введите название" style="font-size: 28px; margin-left: 100px; width: 30%;" />

                    <select name="record_type" value="<?php echo htmlspecialchars($_POST['record_type'] ?? '', ENT_QUOTES); ?>" required style="font-size: 20px; width: 220px; height: 36px; margin-top: 35px; margin-left: 100px; text-align: center;">
                        <option value="">Тип записи</option>
                        <option value="Статья">Статья</option>
                        <option value="Видео">Видео</option>
                        <option value="Мероприятие">Мероприятие</option>
                        <option value="Вебинар">Вебинар</option>
                    </select>

                    <input value="<?php echo htmlspecialchars($_POST['topic'] ?? '', ENT_QUOTES); ?>" name="topic" type="text" placeholder="Тема" style="font-size: 20px; width: 220px; height: 36px; margin-top: 35px; margin-left: 100px; text-align: center;" />
                    
                    <br>
                    <?php foreach ($errors as $error): ?>
                        <li style="text-align: center;"><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                    <div>
                        <button name="add_post" class="btn" type="submit" style="margin-left: 43%; font-size: 24px; height: 50px; margin-top: 50px; margin-bottom: 50px;"> Добавить запись </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <?php include("../construct/footer.php"); ?>

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
