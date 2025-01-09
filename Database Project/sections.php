<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db_connect.php");
    
    $course_number = "";
    $result = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        $course_number = $_POST["course_number"];

        $query = 
        "   SELECT Sections.section_number, Sections.classroom, Sections.meeting_days, Sections.start_time, Sections.end_time, COUNT(Enrollments.student_campus_id) AS num_students_enrolled
            FROM Sections
            LEFT JOIN Enrollments ON Sections.section_number = Enrollments.section_number
            WHERE Sections.course_number = ?
            GROUP BY Sections.section_number;
        ";
        
        
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $course_number);
        $stmt->execute();
        $result_set = $stmt->get_result();

        if ($result_set->num_rows <= 0) {
            echo "Error: Could not find course";
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
    <h2 style="text-align: center;">Sections for Course <?php echo $course_number; ?></h2>
    <?php if ($result): ?>

        <?php foreach ($result as $row): 
            echo "Section Number: " . $row['section_number'] . "<br>";
            echo "Classroom: " . $row['classroom'] . "<br>";
            echo "Meeting Days: " . $row['meeting_days'] . "<br>";
            echo "Time: " . $row['start_time'] . " - " . $row['end_time'] . "<br>";
            echo "Number of Students Enrolled: " . $row['num_students_enrolled'] . "<br><br>";
        endforeach; ?>
    <?php endif; ?>
</body>
</html>
