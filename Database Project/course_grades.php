<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db_connect.php");
    
    $course_number = "";
    $section_number = "";
    $result = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $course_number = $_POST["course_number"];
        $section_number = $_POST["section_number"];

        $query = 
        "   SELECT grade, COUNT(*) as student_count
            FROM Enrollments
            JOIN Sections ON Enrollments.section_number = Sections.section_number
            WHERE Sections.course_number = ? AND Sections.section_number = ?
            GROUP BY grade;
        ";
        
        
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ss", $course_number, $section_number);
        $stmt->execute();
        $result_set = $stmt->get_result();

        if ($result_set->num_rows <= 0) {
            echo "Error: Course or Section number not found";
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
    <h2 style="text-align: center;">Grade Distribution for Course <?php echo $course_number, " Section Number: ", $section_number?></h2>
    <?php if ($result): ?>
            <?php foreach ($result as $row): ?>
            <div><?php echo "Grade: " . $row['grade'] . " ~ Student Count: " . $row['student_count']; ?> ;
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>