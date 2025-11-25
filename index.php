<?php 
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $course = $_POST['course'];
    $grade = $_POST['grade'];
    
    $image = 'default.png';
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image = $fileName;
        }
    }
    
    $stmt = $conn->prepare("INSERT INTO students (name, course, grade, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $course, $grade, $image]);
    
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة طالب جديد</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .header-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            margin-bottom: 30px;
            border-radius: 10px;
        }
        .form-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 30px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <img src="uploads/Programming-bro.png" alt="إدارة الطلاب" class="header-image">
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h1 class="text-center mb-4">إضافة طالب جديد</h1>
                    
                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">اسم الطالب</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="course" class="form-label">المساق</label>
                            <select class="form-select" id="course" name="course" required>
                                <option value="">اختر المساق</option>
                                <?php
                                $courses = $conn->query("SELECT * FROM courses");
                                while ($course = $courses->fetch()) {
                                    echo '<option value="'.$course['name'].'">'.$course['name'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="grade" class="form-label">الدرجة</label>
                            <input type="text" class="form-control" id="grade" name="grade" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">صورة الطالب</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">حفظ البيانات</button>
                            <a href="student.php" class="btn btn-outline-secondary">عرض الطلاب</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>