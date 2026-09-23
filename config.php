<?php
// ===========================================
// DATABASEVERBINDING
// Dit bestand laad je bovenaan elke pagina in met:
//   require "config.php";
// ===========================================

// Pas deze vier regels aan naar jouw eigen situatie.
// Bij XAMPP/MAMP op je eigen laptop zijn dit meestal de standaardwaarden.
$host      = "localhost";
$dbnaam    = "incheck_systeem";
$gebruiker = "root";
$wachtwoord = "admin";

try {
    $verbinding = new PDO(
        "mysql:host=$host;dbname=$dbnaam;charset=utf8mb4",
        $gebruiker,
        $wachtwoord
    );

    // Zorgt ervoor dat fouten als duidelijke PHP-foutmeldingen verschijnen,
    // in plaats van dat het script stil vastloopt.
    $verbinding->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $fout) {
    // Stopt het script en toont waarom de verbinding niet lukte.
    die("Databaseverbinding is mislukt: " . $fout->getMessage());
}