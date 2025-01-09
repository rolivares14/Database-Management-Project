<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db_connect.php");
    
    $student_campus_id = "";
    $result = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        $student_campus_id = $_POST["student_campus_id"];

        $query = 
        "   SELECT Courses.course_number, Courses.title, Enrollments.grade
            FROM Enrollments
            JOIN Sections ON Enrollments.section_number = Sections.section_number
            JOIN Courses ON Sections.course_number = Courses.course_number
            WHERE Enrollments.student_campus_id = ?;
        ";
        
        
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $student_campus_id);
        $stmt->execute();
        $result_set = $stmt->get_result();

        if ($result_set->num_rows <= 0) {
            echo "Error: Could not find CWID";
        }

        if ($result_set->num_rows > 0) {
            $result = $result_set->fetch_all(MYSQLI_ASSOC);
        }

        

        $stmt->close();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title style="text-align: center;">Professor SSN Query</title>
    <style>
        body {
            background-color: beige;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Academic history for <?php echo $student_campus_id; ?></h2>
    <?php if ($result): ?>
        <?php foreach ($result as $row): 
            echo "Course Number: " . $row['course_number'] . "<br>";
            echo "Class Name: " . $row['title'] . "<br>";
            echo "Grade: " . $row['grade'] . "<br><br><br>";
        endforeach;
    endif; ?>
</body>
</html>
