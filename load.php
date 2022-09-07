<?php

require "db.php";

session_start();

function redirect($path)
{
    header("Location: " . $path);
    exit();
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

function add_repoets($user_id, $time_starts, $time_ends, $time_teaches, $descriptions)
{
    $time_starts_count = count($time_starts);
    $time_ends_count = count($time_ends);
    $time_teaches_count = count($time_teaches);
    $description_count = count($descriptions);
    if ($time_starts_count === 0 || $time_ends_count === 0 || $time_teaches_count === 0 || $description_count === 0) return "خطا!!وارد کردن ساعت کاری اجباری است.";
    if ($time_starts_count !== $time_ends_count || $time_starts_count !== $time_teaches_count || $time_starts_count !== $description_count || $time_ends_count !== $time_teaches_count || $time_ends_count !== $description_count || $time_teaches_count !== $description_count) return "خطا!!تعداد ساعات وارد شده با هم برابر نیست.";
    foreach ($time_starts as $i => $time_start) {
        if (trim($time_start) === "" || trim($time_ends[$i]) === "" || trim($time_teaches[$i]) === "" || trim($descriptions[$i] === "")) return "خطا!!فیلد خالی مجاز نیست.";
        add_report($user_id, $time_start, $time_ends[$i], $time_teaches[$i], $descriptions[$i]);
        return true;
    }
}

function add_report($user_id, $time_start, $time_end, $time_teach, $description)
{
    $date = date("y-m-d");
    global $db;
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

///////
if (isset($_SESSION["user_id"])) $is_auth = true;
else $is_auth = false;

if ($is_auth === true) {
    $user = get_user_by_id($_SESSION["user_id"]);
} else {
    $is_auth = false;
}
