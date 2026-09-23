<?php

require "config.php";

echo "<h1>Verbinding gelukt!</h1>";


$query = $verbinding->query("
    SELECT students.name, students.email, groups_table.name AS groep
    FROM students
    JOIN groups_table ON students.group_id = groups_table.id
");

$studenten = $query->fetchAll();

echo "<h2>Studenten in de database:</h2>";
echo "<ul>";

foreach ($studenten as $student) {
    echo "<li>" . $student["name"] . " - " . $student["groep"] . " - " . $student["email"] . "</li>";
}

echo "</ul>";