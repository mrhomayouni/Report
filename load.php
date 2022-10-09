<?php


require "db.php";

session_start();

date_default_timezone_set('asia/tehran');

function redirect(string $path): never
{
    header("Location:" . $path);
    exit();
}

function check_page(string $path): bool
{
    return basename($_SERVER["SCRIPT_NAME"] == $path);
}

function get_user_by_password(string $username, string $password): ?array
{
    global $db;

    $sql = "SELECT `id` FROM `user` WHERE `username` = :username AND `password` = :password ;";
    $stmt = $db->prepare($sql);
    $stmt->bindParam("username", $username);
    $stmt->bindParam("password", $password);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user === false) return null;
    else return $user;
}

function get_user_by_id(int $id): ?array
{
    global $db;

    $sql = "SELECT * FROM `user` WHERE `id`=:id;";
    $stmt = $db->prepare($sql);
    $stmt->bindParam("id", $id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user === false) return null;
    else return $user;
}

function add_reports(int $user_id, array $time_starts, array $time_ends, array $time_teaches, array $descriptions): bool|string
{
    $time_starts_count = count($time_starts);
    $time_ends_count = count($time_ends);
    $time_teaches_count = count($time_teaches);
    $description_count = count($descriptions);
    if ($time_starts_count === 0 || $time_ends_count === 0 || $time_teaches_count === 0 || $description_count === 0) return "خطا!!وارد کردن ساعت کاری اجباری است.";
    if ($time_starts_count !== $time_ends_count || $time_starts_count !== $time_teaches_count || $time_starts_count !== $description_count || $time_ends_count !== $time_teaches_count || $time_ends_count !== $description_count || $time_teaches_count !== $description_count) return "خطا!!تعداد ساعات وارد شده با هم برابر نیست.";
    foreach ($time_starts as $i => $time_start) {
        if (!isset($time_start, $time_ends[$i], $time_teaches[$i], $time_teaches[$i])) continue;
        if (trim($time_start) === "" || trim($time_ends[$i]) === "" || trim($time_teaches[$i]) === "" || trim($descriptions[$i] === "")) return "خطا!!فیلد خالی مجاز نیست.";

        add_report($user_id, $time_start, $time_ends[$i], $time_teaches[$i], $descriptions[$i]);

        return true;
    }
    return false;
}

function add_report(int $user_id, string $time_start, string $time_end, string $time_teach, string $description)
{
    global $db;

    $date = date("y-m-d");

    $sql = "INSERT INTO `report`(`user_id`, `date`, `time_start`, `time_end`, `time_teach`, `description`) VALUES (:user_id, :date, :time_start, :time_end, :time_teach, :description);";
    $stmt = $db->prepare($sql);
    $stmt->bindParam("user_id", $user_id);
    $stmt->bindParam("date", $date);
    $stmt->bindParam("time_start", $time_start);
    $stmt->bindParam("time_end", $time_end);
    $stmt->bindParam("time_teach", $time_teach);
    $stmt->bindParam("description", $description);
    $stmt->execute();
}

function add_to_archive(string $type, string $description, string $file_name): bool|string
{
    global $db;

    $sql = "INSERT INTO `archive`(`type`, `file_name`, `description`) 
VALUES (:type,:file_name,:description);";
    $stmt = $db->prepare($sql);
    $stmt->bindValue("type", $type);
    $stmt->bindValue("file_name", $file_name);
    $stmt->bindValue("description", $description);
    if ($stmt->execute()) {
        return true;
    } else {
        return "خطا در اپلود فایل";
    }
}

function get_archives(): array
{
    global $db;

    $sql = "SELECT * FROM `archive`";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $archives = $stmt->fetchAll();
    return $archives;
}

function change_Specifications(int $user_id, string $username, string $first_name, string $last_name): bool
{
    global $db;

    $sql = "UPDATE `user` SET `username`=:username,`first_name`=:first_name,`last_name`=:last_name WHERE `id`=:id;";
    $stmt = $db->prepare($sql);
    $stmt->bindValue("id", $user_id);
    $stmt->bindValue("username", $username);
    $stmt->bindValue("first_name", $first_name);
    $stmt->bindValue("last_name", $last_name);

    if ($stmt->execute()) {
        return true;
    }
    return false;
}

function change_password(int $user_id, string $new_password): bool|string
{
    global $db;

    $sql = "UPDATE `user` SET `password`=:new_password WHERE `id`=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue("id", $user_id);
    $stmt->bindValue("new_password", md5($new_password));

    if ($stmt->execute()) {
        return true;
    }
    return "خطادر تغییر رمز عبور";
}

function add_letter(string $type, string $recipient, string $title, string $body): bool|string
{
    global $db;

    $date = time();
    $sql = "INSERT INTO `letter`(`type`, `recipient`, `title`, `body`, `annex`, `date`)
 VALUES (:type, :recipient, :title, :body, :annex, :date)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue("type", $type);
    $stmt->bindValue("recipient", $recipient);
    $stmt->bindValue("title", $title);
    $stmt->bindValue("body", $body);
    $stmt->bindValue("annex", rand(100, 999));
    $stmt->bindValue("date", $date);
    if ($stmt->execute()) {
        return true;
    } else return "خطا در ثبت اطلاعات";
}

function get_letters(): bool|array
{
    global $db;

    $sql = "SELECT * FROM `letter`;";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $letter = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $letter;
}

function get_letter_by_id(int $id)
{
    global $db;

    $sql = "SELECT * FROM `letter` WHERE `id`=:id;";
    $stmt = $db->prepare($sql);
    $stmt->bindValue("id", $id);
    $stmt->execute();
    $letter = $stmt->fetch(PDO::FETCH_ASSOC);
    return $letter;
}


function add_vacation( int $user_id, string $date, string $type, string $duration, string $description): bool|string
{
    global $db;

    $created_at = time();

    $sql = "INSERT INTO `vacation`( `user_id`, `date`, `type`, `duration`, `description`, `created_at`) 
VALUES (:user_id, :date, :type, :duration, :description, :created_at)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue("user_id", $user_id);
    $stmt->bindValue("date", $date);
    $stmt->bindValue("type", $type);
    $stmt->bindValue("duration", $duration);
    $stmt->bindValue("description", $description);
    $stmt->bindValue("created_at", $created_at);
    if ($stmt->execute()) {
        return true;
    } else {
        return "خطا در ثبت مرخصی";
    }
}

function get_all_vacation(): bool|array
{
    global $db;

    $sql = "SELECT * FROM `vacation` ORDER BY `id` DESC;";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $vacation = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $vacation;

}

function get_vacation(int $user_id): bool|array
{
    global $db;

    $sql = "SELECT * FROM `vacation` WHERE `user_id` = :id ORDER BY `id` DESC;";
    $stmt = $db->prepare($sql);
    $stmt->bindValue("id", $user_id);
    $stmt->execute();
    $vacation = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $vacation;
}

function change_vacation(int $id, int $status): void
{
    global $db;

    $sql = "UPDATE `vacation` SET `status`=:status WHERE `id`=:id;";
    $stmt = $db->prepare($sql);
    $stmt->bindValue("id", $id);
    $stmt->bindValue("status", $status);
    $stmt->execute();
}

function change_vacation_to_displayed(): void
{
    global $db;
    $sql = "UPDATE `vacation` SET `status` = 0 WHERE `status` = 3;";
    $stmt = $db->prepare($sql);
    $stmt->execute();
}

function add_question_with_file(string $title, string $body, int $user_id, string $category, string $Priority, string $file_name): bool|string
{
    global $db;
    $sql = "INSERT INTO `question`(`title`, `body`, `user_id`, `category`, `Priority`, `file_name`) 
VALUES (:title, :body, :user_id, :category, :Priority, :file_name)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue("title", $title);
    $stmt->bindValue("body", $body);
    $stmt->bindValue("user_id", $user_id);
    $stmt->bindValue("category", $category);
    $stmt->bindValue("Priority", $Priority);
    $stmt->bindValue("file_name", $file_name);
    if ($stmt->execute()) {
        return true;
    } else {
        return "خطا در ثبت سوال";
    }
}

function add_question_without_file(string $title, string $body, int $user_id, string $category, string $Priority): bool|string
{
    global $db;

    $date = time();
    $sql = "INSERT INTO `question`(`title`, `body`, `user_id`, `category`, `Priority`, `date`) 
VALUES (:title, :body, :user_id, :category, :Priority, :date)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue("title", $title);
    $stmt->bindValue("body", $body);
    $stmt->bindValue("user_id", $user_id);
    $stmt->bindValue("category", $category);
    $stmt->bindValue("Priority", $Priority);
    $stmt->bindValue("date", $date);
    if ($stmt->execute()) {
        return true;
    } else {
        return "خطا در ثبت سوال";
    }
}

function get_questions(): array
{
    global $db;
    $sql = "SELECT * FROM `question`";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $questions = $stmt->fetchAll();
    return $questions;
}

function add_answer(int $question_id, int $user_id, string $body): bool|string
{
    global $db;

    $date = time();
    $sql = "INSERT INTO `answer`( `question_id`, `user_id`, `body`, `date`) 
VALUES (:question_id,:user_id,:body,:date)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue("question_id", $question_id);
    $stmt->bindValue("user_id", $user_id);
    $stmt->bindValue("body", $body);
    $stmt->bindValue("date", $date);
    if ($stmt->execute()) {
        return true;
    } else {
        return "خطا در ثبت پاسخ";
    }
}

function get_answers(int $question_id): array
{
    global $db;
    $sql = "SELECT * FROM `answer` WHERE `question_id`=:question_id ORDER BY `id` DESC";
    $stmt = $db->prepare($sql);
    $stmt->bindValue("question_id", $question_id);
    $stmt->execute();
    $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $answers;
}

function get_question_by_question_id(int $question_id): ?array
{
    global $db;
    $sql = "SELECT * FROM `question` WHERE `id` = :question_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue("question_id", $question_id);
    $stmt->execute();
    $question = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($question === false) {
        return null;
    } else {
        return $question;
    }
}

function gregorian_to_jalali(int $year, int $month, int $day): array
{
    $result = [];
    $array = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];

    if ($year <= 1600) {
        $year -= 621;
        $result["year"] = 0;
    } else {
        $year -= 1600;
        $result["year"] = 979;
    }

    $temp = ($year > 2) ? ($year + 1) : $year;
    $days = ((int)(($temp + 3) / 4)) + (365 * $year) - ((int)(($temp + 99) / 100)) - 80 + $array[$month - 1] + ((int)(($temp + 399) / 400)) + $day;
    $result["year"] += 33 * ((int)($days / 12053));
    $days %= 12053;
    $result["year"] += 4 * ((int)($days / 1461));
    $days %= 1461;

    if ($days > 365) {
        $result["year"] += (int)(($days - 1) / 365);
        $days = ($days - 1) % 365;
    }

    $result["month"] = ($days < 186)
        ? 1 + (int)($days / 31)
        : 7 + (int)(($days - 186) / 30);

    $result["day"] = 1 + (($days < 186)
            ? ($days % 31)
            : (($days - 186) % 30));

    return $result;
}

function gregorian_to_jalali_str(int $year, int $month, int $day): string
{
    $result = gregorian_to_jalali($year, $month, $day);

    if ($result["month"] < 10)
        $result["month"] = "0" . $result["month"];
    if ($result["day"] < 10)
        $result["day"] = "0" . $result["day"];

    return $result["year"] . "/" . $result["month"] . "/" . $result["day"];
}

function return_date_to_jalali($timestamp): string
{
    $year = date("Y", $timestamp);
    $month = date("m", $timestamp);
    $day = date("d", $timestamp);
    $date = gregorian_to_jalali_str($year, $month, $day);
    return $date;
}

function motivational_sentence()
{
    $motivational_sentence = "من برای ماه‌ها و سال‌ها فکر می‌کنم و فکر می‌کنم.نود و نه دفعه نتیجه‌ام غلط است.بار صدم به نتیجه درست می‌رسم.آلبرت انیشتین
موفقیت عبارت است از رفتن از شکست به شکست دیگر بدون از دست دادن اشتیاق. وینستون چرچیل 
اگر از وضعیت چیزها راضی نیستی، آنها را تغییر بده. تو یک درخت نیستی!جیم ران 
من شکست نخورده‌ام.فقط ده هزار روش پیدا کرده‌ام که درست عمل نمی‌کند.توماس ادیسون 
اجازه ندهید مشکلات‌تان شما را هل بدهند، بگذارید رویاهایتان شما را هدایت کنند.رالف والد و امرسان 
رؤیاهای‌ خودتان را بسازید در غیر این صورت فرد دیگری شما را برای ساختن رؤیایش به کار خواهد گرفت.فرا گری
فقط یک چیز می‌تواند رسیدن به یک رویا را ناممکن سازد: ترس از شکست پائلو کوئیلو
لازم نیست حتماً عالی باشی تا شروع کنی، ولی حتماً باید شروع کنی تا بتوانی عالی باشی.زیگ زیگلار
پیروزی به معنای رَد کردن و پشت سر گذاشتنِ شکست‌های متوالی بدون از دست دادن انگیزه و توان است. اگر می‌خواهید به پیروزی دست پیدا کنید باید شکست خوردن را هم بلد باشید.وینستون چرچیل، سیاستمدار حاضرجواب و باهوش
زمان شما محدود است پس آن را صرف زندگی‌ای‌ نکنید که به فرد دیگری متعلق است.استیو جابز 
با اراده‌ای قوی می‌توان سخت‌ترین موانع را هم جا به جا نمود. کافی است که پشتکار و شهامت به خرج بدهید. فاصله مردان بزرگ با افراد حقیر در همین تلاش و شهامت برای رسیدن به هدف است.توماس فولر، نویسنده روشنفکر
من برای ماه‌ها و سال‌ها فکر می‌کنم و فکر می‌کنم. نود و نه دفعه نتیجه‌ام غلط است. بار صدم به نتیجه درست می‌رسم.آلبرت انیشتین 
خیلی تلاش کردی؟ خیلی شکست خوردی؟ ایرادی نداره…دوباره امتحان کن … دوباره شکست بخور، این بار یک شکست بهتر! 
شجاعت، نداشتن ترس نیست بلکه پیروزی بر آن است و شجاع کسی نیست که احساس ترس نمی کند بلکه کسی است که بر آن ترس غلبه می کند
وقتی چیزی را از دست می‌دهید، درسی را که از آن گرفته اید از دست ندهید.آنتونی رابینز
 سفر هزار کیلومتری با قدم اول شروع می‌شود.لائوتسه
موفقیت‌هایی که نصیب افراد صبور می‌شود، همان‌هایی هستند که توسط افراد عجول رها شده اند!آلبرت انیشتین
درست آن زمانی که تصمیم می‌گیرید که از ادامه راه منصرف شوید، از آنچه تصور می‌کنید به مقصد نزدیکترید.باب پارسنز، بنیانگذار Go Daddy 
من یاد گرفتم که راه پیشرفت نه سریع و نه آسان است.ماری کوری
وقتی که شهامتِ قدرتمند بودن را پیدا می‌کنم تا بتوانم از توانایی‌ها و استعدادهایم برای تحققِ چشم‌اندازم استفاده کنم، ترسِ من رفته رفته بی‌اهمیت‌تر می‌شود.آدری لرد (نویسنده و فعال حقوق زنان) 
خواسته‌های بزرگ نشان دهنده شخصیت بزرگ است.ناپلئون بناپارت
تنها در فرهنگ لغت می‌توانید پیروزی را پیش از عمل ببینید.وایدال سَسون (بازرگان و آرایشگر) 
انسان نمی‌تواند به سینه‌خیز رفتن قانع باشد اگر در درونش میل شدیدی به پرواز کردن داشته باشد.هلن کلر
شجاعت، مقابله با ترس و سلطه بر آن است نه فقدانِ ترس.مارک تواین (نویسنده) 
هیچ وقت رنگین کمان را نمی‌بینی اگر به پایین نگاه کنی.چارلی چاپلین
موفقیت، مجموعه‌ای از تلاش‌های کوچک است که هر روز و هر روز تکرار شده‌اند.روبرت کالیر (نویسنده‌ی کتاب‌های خودیاری) 
راز جلو افتادن، آغاز کردن است.مارک تواین
هرچه تلاش کردی، هرچه شکست خوردی، مهم نیست. باز هم تلاش کن، باز هم شکست بخور. این بار بهتر شکست بخور.
بزرگ‌ترین ریسک این است که هیچ ریسکی نکنی.مارک زاکربرگ
تو وقتی به پایان می‌رسی که تغییر یافتن در تو به پایان برسد.
اگر شکست بخورید ممکن است ناامید شوید، اما اگر تلاش نکنید قطعا شکست می‌خورید.بورلی سیلز (خواننده‌ی اپرا)
شروع هر کاری، مهم‌ترین بخش آن است.افلاطون
جسی اُونز (قهرمان ورزشی سیاه‌پوست امریکایی که پیروزی‌اش در المپیک، هیتلر را به خشم آورد). 
اگر مهم‌ترین هدف ناخدا این بود که از کشتی خود محافظت کند، همیشه آن را در لنگرگاه نگه می‌داشت.
از جایی که هستید شروع کنید. از آنچه دارید استفاده کنید. کاری که می‌توانید را انجام بدهید.آرتور اَش (بازیکنِ سیاه‌پوست تنیس که برای نخستین بار قهرمانی انفرادی آمریکا و انگلیس را به دست آورد). 
من شکست نخورده‌ام. فقط ده هزار روش پیدا کرده‌ام که درست عمل نمی‌کند.توماس ادیسون 
مردم اغلب می‌گویند انگیزه‌ها دوام ندارند. خب، اثر حمام نیز ماندگار نیست. به همین دلیل توصیه می‌شود روزانه دوش بگیرید.زیگ زیگلار (روان‌شناس) 
انگیزه داشتن هیچ هزینه‌ای برای‌تان ندارد اما می‌تواند همه چیز را برای شما فراهم کند.موری نیولند 
زندگی هر چقدر هم بد به نظر برسد، باز هم کاری وجود دارد که می‌توانی انجام دهی و در آن موفق شوی.استیون‌ هاوکینگ 
تا زمانی که نفس می‌کشی، هیچ‌وقت برای انجام اقدام خوب دیر نیست.مایا آنجلو 
انسان دانا بیشتر از اینکه فرصت‌ها را پیدا کند، برای خود فرصت ایجاد می‌کند.فرانسیس بیکن 
تنها مسیر غیرممکن، مسیری است که هنوز شروع نکرده‌ای.آنتونی رابینز 
شما به دنیا آمدید تا برنده شوید، ولی برای برنده بودن، باید برای بردن برنامه‌ریزی کنید، برای بردن آماده شوید و انتظار بردن را داشته باشید.زیگ زیگلار 
اگر من بیشتر از دیگران دیده‌ام، به خاطر این است که بر شانه‌های غول‌ها ایستاده‌ام.ایزاک نیوتن 
تو می‌توانی مرا به زنجیر بکشی، شکنجه‌ام دهی، حتی بدنم را نابود کنی، ولی هرگز ذهن مرا اسیر نخواهی کرد.مهاتما گاندی 
خطر بزرگی که همه ما را تهدید می‌کند این نیست که اهدافمان را بسیار بلند تعیین کنیم و به آن نرسیم، بلکه اهدافمان را بسیار پایین تعیین کنیم و به حد خود برسیم.میکل‌ آنژ 
هیچ دلیلی وجود ندارد که از قلبت پیروی نکنی.استیو جابز 
مسیرهای سخت و پرپیچ و خم به بهترین مقصدها می‌رسند. هنوز بهترین اتفاق زندگی‌ات رخ نداده است، منتظر باش.مارتین لوتر کینگ";

    $motivational_sentence = explode("\n", $motivational_sentence);
    echo $motivational_sentence[array_rand($motivational_sentence)];
}

///////
if (isset($_SESSION["user_id"])) $is_auth = true;
else $is_auth = false;

if ($is_auth === true) {
    $user = get_user_by_id($_SESSION["user_id"]);
} else {
    $is_auth = false;
}
if (isset($user)) {
    if ($user["admin"] === 1) {
        $is_admin = true;
    } else {
        $is_admin = false;
    }
}
