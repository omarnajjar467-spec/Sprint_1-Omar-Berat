<?php
// ===========================================
// CHECK-IN VERWERKEN
// Ontvangt een pasjenummer (JSON), zoekt de student op,
// controleert of het pasje geldig is, en slaat de check-in op.
// Geeft altijd JSON terug, ook bij een fout.
// ===========================================

header("Content-Type: application/json");
require "config.php";

// Stap 1: de binnenkomende data lezen
$data = json_decode(file_get_contents("php://input"), true);
$cardNumber = isset($data["cardNumber"]) ? trim($data["cardNumber"]) : "";

if ($cardNumber === "") {
    echo json_encode(["error" => "Geen pasjenummer ontvangen."]);
    exit;
}

try {
    // Stap 2: student + pasje + groep opzoeken bij dit pasjenummer
    $query = $verbinding->prepare("
        SELECT
            students.id AS student_id,
            students.name AS student_naam,
            groups_table.name AS groep_naam,
            cards.id AS card_id,
            cards.valid_until,
            cards.status AS card_status
        FROM cards
        JOIN students ON students.id = cards.student_id
        JOIN groups_table ON groups_table.id = students.group_id
        WHERE cards.card_number = ?
    ");
    $query->execute([$cardNumber]);
    $student = $query->fetch();

    if (!$student) {
        echo json_encode(["error" => "Geen student gevonden met pasjenummer \"$cardNumber\"."]);
        exit;
    }

    $vandaag = date("Y-m-d");

    // Stap 3: validatie van het pasje (dit is de isGeldig()-regel uit het class diagram)
    if ($student["card_status"] !== "actief") {
        echo json_encode(["error" => "Dit pasje is geblokkeerd."]);
        exit;
    }
    if ($student["valid_until"] < $vandaag) {
        echo json_encode(["error" => "Dit pasje is verlopen."]);
        exit;
    }

    // Stap 4: bepalen of de student op tijd of te laat is
    $nu = date("Y-m-d H:i:s");
    $tijdVanNu = date("H:i:s");
    $grensTeLaat = "08:55:00";
    $status = ($tijdVanNu <= $grensTeLaat) ? "op_tijd" : "te_laat";

    // Stap 5: de check-in opslaan
    $insert = $verbinding->prepare("
        INSERT INTO checkins (student_id, card_id, checked_in_at, checkin_date, status)
        VALUES (?, ?, ?, ?, ?)
    ");
    $insert->execute([
        $student["student_id"],
        $student["card_id"],
        $nu,
        $vandaag,
        $status
    ]);

    // Stap 6: het resultaat teruggeven aan scan.php
    echo json_encode([
        "student" => $student["student_naam"],
        "groep"   => $student["groep_naam"],
        "status"  => $status,
        "tijd"    => date("H:i")
    ]);

} catch (PDOException $fout) {
    echo json_encode(["error" => "Er ging iets mis bij het opslaan: " . $fout->getMessage()]);
}