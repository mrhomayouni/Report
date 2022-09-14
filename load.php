<?php

require "db.php";

session_start();

date_default_timezone_set('asia/tehran');

function redirect($path)
{
    header("Location:" . $path);
    exit();
}

function Is_File0($path)
{
    if (basename($_SERVER["SCRIPT_NAME"]) === $path) return true;
}

function get_user_by_password(string $username, string $password): ?array
{
    global $db;

    $sql = "SELECT `id` FROM `user` WHERE `username`=:username AND `password`=:password ;";
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

function add_reports($user_id, $time_starts, $time_ends, $time_teaches, $descriptions)
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
}

function add_report($user_id, $time_start, $time_end, $time_teach, $description)
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

function add_to_archive($type, $description, $file_name)
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

function get_archives()
{
    global $db;

    $sql = "SELECT * FROM `archive`";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $archives = $stmt->fetchAll();
    if (count($archives) > 0) {
        return $archives;
    } else {
        return false;
    }
}

function change_Specifications($user_id, $username, $first_name, $last_name)
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
}

function change_password($user_id, $new_password): bool|string
{
    global $db;

    $sql = "UPDATE `user` SET `password`=:new_password WHERE `id`=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue("id", $user_id);
    $stmt->bindValue("new_password", md5($new_password));
    if ($stmt->execute()) {
        return true;
    } else {
        return "خطادر تغییر رمز عبور";
    }
}

function add_letter($type, $recipient, $title, $body): bool|string
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
    if (count($letter) > 0) {
        return $letter;
    } else {
        return false;
    }
}

function get_letter_by_id($id)
{
    global $db;

    $sql = "SELECT * FROM `letter` WHERE `id`=:id;";
    $stmt = $db->prepare($sql);
    $stmt->bindValue("id", $id);
    $stmt->execute();
    $letter = $stmt->fetch(PDO::FETCH_ASSOC);
    return $letter;
}


function add_vacation($user_id, $date, $type, $duration, $description)
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

function get_vacation($user_id)
{
    global $db;

    $sql = "SELECT * FROM `vacation` WHERE `user_id` = :id;";
    $stmt = $db->prepare($sql);
    $stmt->bindValue("id", $user_id);
    $stmt->execute();
    $vacation = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($vacation) < 1) {
        return false;
    } else {
        return $vacation;
    }
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
