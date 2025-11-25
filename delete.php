<?php
include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT image FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if ($student && $student['image'] != 'default.png' && file_exists("uploads/".$student['image'])) {
    unlink("uploads/".$student['image']);
}

$stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
$stmt->execute([$id]);

$_SESSION['message'] = "تم حذف الطالب بنجاح";
header("Location: index.php");
exit();
?>