<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db_connect.php");

    $professor_ssn = "";
    $result = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $professor_ssn = $_POST["professor_ssn"];
        $query = 
        "   SELECT Sections.course_number, Courses.title, Sections.classroom, Sections.meeting_days, Sections.start_time, Sections.end_time
            FROM Sections
            JOIN Courses ON Sections.course_number = Courses.course_number
            WHERE Sections.professor_ssn = ?
        ";
        
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $professor_ssn);
        $stmt->execute();
        $result_set = $stmt->get_result();

        if ($result_set->num_rows <= 0) {
            echo "Error: Could not find SSN ";
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
    <title>Professor SSN Query</title>
    <style>
        body {
            background-color: beige;
        }
        table, th, td {
            border: 1px solid black;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>

