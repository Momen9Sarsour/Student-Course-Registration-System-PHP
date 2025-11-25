<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض الطلاب</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1>الطلبة المسجلين</h1>
            <div>
                <a href="index.php" class="btn btn-success">إضافة طالب جديد</a>
                <a href="courses.php" class="btn btn-info">المساقات المطروحة</a>
            </div>
        </div>

        <div class="row">
            <?php
            $stmt = $conn->query("SELECT * FROM students");
            while ($row = $stmt->fetch()) {
                echo '
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="uploads/'.($row['image'] ?? 'default.png').'" class="card-img-top" alt="صورة الطالب" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">'.$row['name'].'</h5>
                            <p class="card-text">
                                <strong>المساق:</strong> '.$row['course'].'<br>
                                <strong>الدرجة:</strong> '.$row['grade'].'
                            </p>
                        </div>
                        <div class="card-footer bg-white">
                            <a href="edit.php?id='.$row['id'].'" class="btn btn-warning btn-sm">تعديل</a>
                            <a href="delete.php?id='.$row['id'].'" class="btn btn-danger btn-sm" onclick="return confirm(\'هل أنت متأكد؟\')">حذف</a>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>
</body>
</html>