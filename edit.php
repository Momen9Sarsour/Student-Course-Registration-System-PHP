<?php
include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if (!$student) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $course = $_POST['course'];
    $grade = $_POST['grade'];
    
    $image = $student['image'];
    if (!empty($_FILES['image']['name'])) {
        if ($image != 'default.png' && file_exists("uploads/$image")) {
            unlink("uploads/$image");
        }
        
        $targetDir = "uploads/";
        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image = $fileName;
        }
    }
    
    $stmt = $conn->prepare("UPDATE students SET name=?, course=?, grade=?, image=? WHERE id=?");
    $stmt->execute([$name, $course, $grade, $image, $id]);
    
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل بيانات الطالب</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h1 class="text-center mb-4">تعديل بيانات الطالب</h1>
        
        <form method="post" enctype="multipart/form-data" class="mx-auto" style="max-width: 500px;">
            <div class="mb-3">
                <label for="name" class="form-label">اسم الطالب</label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="<?= htmlspecialchars($student['name']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="course" class="form-label">المساق</label>
                <select class="form-select" id="course" name="course" required>
                    <option value="">اختر المادة</option>
                    <?php
                    $courses = $conn->query("SELECT * FROM courses");
                    while ($course = $courses->fetch()) {
                        $selected = ($course['name'] == $student['course']) ? 'selected' : '';
                        echo '<option value="'.$course['name'].'" '.$selected.'>'.$course['name'].'</option>';
                    }
                    ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="grade" class="form-label">الدرجة</label>
                <input type="text" class="form-control" id="grade" name="grade" 
                       value="<?= htmlspecialchars($student['grade']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="image" class="form-label">صورة الطالب</label>
                <input type="file" class="form-control" id="image" name="image">
                
                <?php if ($student['image'] && file_exists("uploads/".$student['image'])): ?>
                    <div class="mt-2">
                        <img src="uploads/<?= $student['image'] ?>" width="100" class="img-thumbnail">
                        <p class="text-muted mt-1">الصورة الحالية</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                <a href="index.php" class="btn btn-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</body>
</html>