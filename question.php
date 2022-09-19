<!doctype html>
<html lang="fa_IR" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>کارمن</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="KareMan">
    <link rel="stylesheet" type="text/css" href="mds.bs.datetimepicker.style.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.rtl.min.css"
          integrity="sha384-+4j30LffJ4tgIMrq9CwHvn0NjEvmuDCOfk6Rpg2xg7zgOxWWtLtozDEEVvBPgHqE" crossorigin="anonymous">
    <style type="text/css">
        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Vazirmatn";
            background-color: #f5f5f5;
        }

        .btn-primary {
            background-color: #0047ab !important;
        }

        header {
            padding: 2rem 1rem;
            margin-bottom: 2rem;
            background-color: #e9ecef;
        }

        #tp-wrap *::selection {
            background: transparent;
        }

        #tp-wrap {
            width: 100vw;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999;
            background: rgba(0, 0, 0, 0.7);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s;
        }

        #tp-wrap.show {
            opacity: 1;
            visibility: visible;
        }

        /* (B) BOX */
        #tp-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 320px;
            display: flex;
            flex-wrap: wrap;
            flex-direction: row-reverse;
            border: 1px solid #000;
            background: #2d2d2d;
            border-radius: 10px;
        }

        /* (C) HR/MIN/AM/PM */
        .tp-cell {
            width: 33.3%;
            padding: 0 15px;
            text-align: center;
        }

        .tp-up,
        .tp-down {
            padding: 10px 0;
            color: rgb(237, 189, 0);
            font-size: 32px;
            font-weight: 700;
            cursor: pointer;
        }

        .tp-val {
            width: 100%;
            padding: 10px 0;
            text-align: center;
            font-size: 22px;
            background: #fff;
        }

        /* (D) CLOSE & SET BUTTON */
        #tp-close,
        #tp-set {
            width: 50%;
            padding: 15px 0;
            border: 0;
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
        }

        #tp-close {
            background: #c2c2c2;
            border-bottom-left-radius: 10px;
        }

        #tp-set {
            background: rgb(237, 189, 0);
            border-bottom-right-radius: 10px;
        }

        /* (E) 24-HOUR MODIFY */
        #tp-wrap.tp-24 #tp-ap {
            display: none;
        }

        #tp-wrap.tp-24 #tp-hr,
        #tp-wrap.tp-24 #tp-min {
            width: 50%;
        }

        .widget-wrap {
            width: 500px;
            padding: 30px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.5);
        }

        .widget-wrap label,
        .widget-wrap input {
            display: block;
            padding: 10px;
            width: 100%;
        }

        /* SVG */
        #hash {
            width: 100px;
            height: 100px;
            background-image: url('data:image/svg+xml;utf8,<svg viewBox="0 0 640 512" width="100" xmlns="http://www.w3.org/2000/svg"><path d="M496 224c-79.59 0-144 64.41-144 144s64.41 144 144 144 144-64.41 144-144-64.41-144-144-144zm64 150.29c0 5.34-4.37 9.71-9.71 9.71h-60.57c-5.34 0-9.71-4.37-9.71-9.71v-76.57c0-5.34 4.37-9.71 9.71-9.71h12.57c5.34 0 9.71 4.37 9.71 9.71V352h38.29c5.34 0 9.71 4.37 9.71 9.71v12.58zM496 192c5.4 0 10.72.33 16 .81V144c0-25.6-22.4-48-48-48h-80V48c0-25.6-22.4-48-48-48H176c-25.6 0-48 22.4-48 48v48H48c-25.6 0-48 22.4-48 48v80h395.12c28.6-20.09 63.35-32 100.88-32zM320 96H192V64h128v32zm6.82 224H208c-8.84 0-16-7.16-16-16v-48H0v144c0 25.6 22.4 48 48 48h291.43C327.1 423.96 320 396.82 320 368c0-16.66 2.48-32.72 6.82-48z"/></svg>');
            background-repeat: no-repeat;
            background-position: center;
        }

        /* FOOTER */
        #code-boxx {
            font-weight: 600;
            margin-top: 30px;
        }

        #code-boxx a {
            display: inline-block;
            padding: 5px;
            text-decoration: none;
            background: #b90a0a;
            color: #fff;
        }

        .reports {
        }

        .reports-add, .hedabdari-add, .products-add {
            width: 60px;
            margin: auto;
            cursor: pointer;
        }

        .reports-add span, .hedabdari-add span, .products-add span {
            font-size: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgb(237, 189, 0);
            border-radius: 100%;
            width: 60px;
            height: 60px;
        }

        .card-icon {
            width: 30px;
            height: 30px;
            background-color: #db0909;
            border-radius: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            cursor: pointer;
            float: left;
            margin-top: -10px;
            margin-left: -10px;
        }

        .card-icon-delete {

        }

        table.table tr td svg {
            max-width: 100%;
        }

    </style>
</head>
<body>
<header>
    <div class="container d-flex align-items-center justify-content-center flex-column">
        <img class="mb-2" src="logo.png" alt="" width="100px">
        <h3 class="display-5">سلام محمدرضا همایونی!</h3>
        <p class="mt-4">
            عده ای از مردم ،تماشاگر خوشبختي اند و طول حياتشان صحبت از خوشبختي مي شنوند ؛ اما هرگز بدون آنكه واقعا ان را
            بشناسند از جهان مي روند.
        </p>
        <p>
            <a class="btn btn-primary btn-sm" href="index.php" role="button">داشبورد</a>
            &nbsp;
            <a class="btn btn-primary btn-sm" href="report.php" role="button">گزارش کار</a>
            &nbsp;
            &nbsp;
            <a class="btn btn-primary btn-sm" href="tasks.php" role="button">وظایف</a>
            &nbsp;
            <a class="btn btn-primary btn-sm" href="questions.php" role="button">سوالات</a>
            &nbsp;
            <a class="btn btn-primary btn-sm" href="morakhesi.php" role="button">مرخصی</a>
            &nbsp;
            <a class="btn btn-primary btn-sm" href="profile.php" role="button">پروفایل</a>
            &nbsp;
            <a class="btn btn-primary btn-sm" href="logout.php" role="button">خروج</a>
        </p>
    </div>
</header>

<main class="container">

    <!-- <div class="d-flex flex-direction-row align-items-center"> -->
    <h1 class="mt-2 w-100">
        سوال تستی </h1>
    <br>
    <span class="badge bg-primary">
                محمدرضا همایونی            </span>
    <span class="badge bg-warning ms-2">
                1401/06/19            </span>
    <!-- </div> -->
    <br>
    <p>
        متن سوال تستی </p>

    <a href="question.php?id=5&status=pending" class="btn btn-primary">باز کردن سوال</a>

    <h2 class="h3 mt-5 mb-3 fw-normal">پاسخ ها</h2>
    <div id="answer-11" class="card mb-2">
        <div class="card-body d-flex align-items-center" style="background-color: yellow;">
            <div class="w-100">
                <b>
                    محمدرضا همایونی </b>
                در
                1401/06/28 پاسخ می دهد:
                <p style="margin-bottom: 0;">
                    تست 2 </p>
            </div>
        </div>
    </div>
    </tr>
    <div id="answer-10" class="card mb-2">
        <div class="card-body d-flex align-items-center" style="background-color: yellow;">
            <div class="w-100">
                <b>
                    محمدرضا همایونی </b>
                در
                1401/06/28 پاسخ می دهد:
                <p style="margin-bottom: 0;">
                    پاسخ تست فایل </p>
            </div>
        </div>
    </div>
    </tr>
    <div id="answer-8" class="card mb-2">
        <div class="card-body d-flex align-items-center">
            <div class="w-100">
                <b>
                    MAX </b>
                در
                1401/06/19 پاسخ می دهد:
                <p style="margin-bottom: 0;">
                    سلام دمتون گرم </p>
            </div>
        </div>
    </div>
    </tr>
    <div id="answer-7" class="card mb-2">
        <div class="card-body d-flex align-items-center">
            <div class="w-100">
                <b>
                    محمدرضا همایونی </b>
                در
                1401/06/19 پاسخ می دهد:
                <p style="margin-bottom: 0;">
                    پاسخ برای سوال خودم </p>
            </div>
        </div>
    </div>
    </tr>


    <form action="" method="POST" enctype="multipart/form-data" onsubmit="return send(this);">
        <h1 class="h3 mt-4 mb-1 fw-normal">ثبت پاسخ</h1>

        <div class="mt-2 alert alert-warning" role="alert">
            خطا: لطفا متن پاسخ را وارد کنید.
        </div>

        <div class="form-group mt-4">
            <label for="descriptionInput">شرح <font color="red">*</font></label>
            <textarea name="description" rows="5" class="form-control" id="descriptionInput" required=""></textarea>
        </div>

        <div class="row">
            <div class="form-group mt-4 col-6">
                <label for="fileInput">فایل</label>
                <input name="file" id="fileInput" type="file" class="form-control">
            </div>
        </div>

        <button name="submit" type="submit" class="btn btn-primary mt-4">ذخیره</button>
    </form>


    <footer>
        <p class="mt-5 mb-3 text-muted text-center">&copy; تولید اسرز با عشق 2022</p>
    </footer>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
</body>
</html>

