<?php
require "load.php";
require "header.php";

if (isset($_POST["type"], $_POST["title"], $_POST["description"], $_POST["priority"])) {
    $type = $_POST["type"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $priority = $_POST["priority"];

    if ($type === "" || $title === "" || $description === "") {
        $ok = "خطا !! فیلد خالی مجاز نیست";
    } else {
        if (isset($_FILES["file"]) && $_FILES["file"]["name"] !== "") {
            $file_name = rand(1000, 9999) . rand(1000, 9999) . $_FILES["file"]["name"];
            $file_path = "question/" . $file_name;

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $file_path)) {
                $ok = add_question_with_file($title, $description, $user["id"], $type, $priority, $file_name);
            } else {
                $ok = "خطا در اپلود فایل سوال!!";
            }
        } else {
            $ok = add_question_without_file($title, $description, $user["id"], $type, $priority);
        }
    }
}

$questions = get_questions();
?>
<!doctype html>
<html lang="fa_IR" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>کارمن - سوالات</title>
</head>
<body>
<main class="container">
    <form action="" method="POST" enctype="multipart/form-data" onsubmit="return send(this);">
        <h1 class="h3 mb-1 fw-normal">تعریف سوال</h1>
        <?php if (isset($ok) && $ok === true) { ?>

            <div class="alert alert-success" role="alert">
                با موفقیت ثبت شد.
            </div>
        <?php } elseif (isset($ok) && $ok !== true) { ?>

            <div class="alert alert-warning" role="alert">
                <?= $ok ?>
            </div>
        <?php } ?>

        <div class="row mb-4">
            <div class="form-group mt-4 col-4">
                <label for="idInput">نوع <font color="red">*</font></label>
                <select name="type" class="form-control" required="">
                    <option disabled="">انتخاب کنید</option>
                    <option value="اداری">اداری</option>
                    <option value="طراحی">طراحی</option>
                    <option value="برنامه نویسی">برنامه نویسی</option>
                </select>
            </div>
            <div class="form-group mt-4 col-4">
                <label for="titleInput">موضوع <font color="red">*</font></label>
                <input name="title" id="titleInput" type="text" class="form-control date-picker" required="">
            </div>
        </div>

        <div class="form-group mt-4">
            <label for="descriptionInput">شرح <font color="red">*</font></label>
            <textarea name="description" rows="5" class="form-control" id="descriptionInput" required=""></textarea>
        </div>

        <div class="row">
            <div class="form-group mt-4 col-6">
                <label for="idInput">الویت <font color="red">*</font></label>
                <select name="priority" class="form-control" required="">
                    <option value="1">مهم و فوری</option>
                    <option value="2">مهم و غیرفوری</option>
                    <option value="3">غیرمهم و فوری</option>
                    <option value="4">غیرمهم و غیرفوری</option>
                </select>
            </div>
            <div class="form-group mt-4 col-6">
                <label for="fileInput">فایل</label>
                <input name="file" id="fileInput" type="file" class="form-control">
            </div>
        </div>

        <button name="submit" type="submit" class="btn btn-primary mt-4">ذخیره</button>
    </form>

    <h1 class="h3 mt-3 mb-3 fw-normal">لیست سوالات</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">سوال</th>
            <th scope="col">وضعیت</th>
            <th scope="col">پاسخ</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ($questions as $question) {
                $answer_count = count(get_answers($question["id"]));
                ?>
                <tr>
                    <td>
                        <b> <?php $person = get_user_by_id($question["user_id"]);
                            echo $person["first_name"] . " " . $person["last_name"] ?> </b>
                        می پرسد:
                        <b>
                            <a style="color: inherit; text-decoration: none;"
                               href="question.php?id=<?= $question["id"] ?>">
                                <?= $question["title"] ?> </a>
                        </b>
                        <br>
                        <?= $question["body"] ?>
                    </td>
                    <td>
                    <span class="badge <?= ($question["status"] === 0) ? "bg-warning" : "bg-success"; ?>">
                        <?= ($question["status"] === 0) ? "حل نشده" : "حل شده"; ?>
                    </span>
                    </td>
                    <td>
            <span class="badge bg-primary">
                <?= $answer_count ?>
            </span>
                    </td>
                </tr>
            <?php } ?>

        <br>
        </tbody>
    </table>

    <footer>
        <p class="mt-5 mb-3 text-muted text-center">&copy; تولید اسرز با عشق 2022</p>
    </footer>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="mds.bs.datetimepicker.js"></script>
</body>
</html>
