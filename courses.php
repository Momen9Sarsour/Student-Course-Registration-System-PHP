<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المساقات المطروحة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1>الطلبة المسجلين للمساقات المطروحة</h1>
            <a href="student.php" class="btn btn-secondary">رجوع</a>
        </div>

        <div class="row">
            <?php
            $courses = $conn->query("SELECT DISTINCT course FROM students");
            while ($course = $courses->fetch()) {
                echo '
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h3 class="mb-0">' . $course['course'] . '</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">';

                $students = $conn->query("SELECT * FROM students WHERE course = '" . $course['course'] . "'");
                while ($student = $students->fetch()) {
                    echo '
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>' . $student['name'] . '</strong>
                                        <div class="text-muted">الدرجة: ' . $student['grade'] . '</div>
                                    </div>
                                    <img src="uploads/' . $student['image'] . '" width="50" height="50" class="rounded-circle border">
                                </li>';
                }

                echo '
                            </ul>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>
</body>

</html>