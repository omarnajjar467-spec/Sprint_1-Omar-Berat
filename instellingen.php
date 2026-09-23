<?php
require "config.php";

?>

<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<title>Check-in Systeem · Instellingen</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<div id="dash-screen" style="display:block;">
  <div class="shell">
    <div class="sidebar">
      <div class="sb-brand"><div class="brand-mark"></div><span>Check-in Systeem</span></div>

      <div class="nav-group">
        <a class="nav-head top" href="index.php" style="text-decoration:none;">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 11l9-7 9 7"/><path d="M5 10v9a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1v-9"/></svg>
          Home
        </a>
      </div>

      <div class="nav-group">
        <div class="nav-head">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="3.2"/><path d="M5 20c0-3.6 3.1-6 7-6s7 2.4 7 6"/></svg>
          Studenten
        </div>
        <div class="nav-sub">
          <a class="nav-item" href="studenten.php">Studentenlijst</a>
        </div>
      </div>

      <div class="nav-group">
        <div class="nav-head">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="4" width="16" height="16" rx="2"/><path d="M9 9h6v6H9z"/></svg>
          Check-in
        </div>
        <div class="nav-sub">
          <a class="nav-item" href="scan.php">Scan pasje</a>
        </div>
      </div>

      <div class="nav-group">
        <div class="nav-head">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 10h18"/></svg>
          Dagoverzicht
        </div>
        <div class="nav-sub">
          <a class="nav-item" href="dagoverzicht.php">Alle check-ins</a>
        </div>
      </div>

      <div class="nav-group">
        <div class="nav-head">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 8v5l3 2"/></svg>
          Instellingen
        </div>
        <div class="nav-sub">
          <div class="nav-item active">Account &amp; systeem</div>
        </div>
      </div>

      <div class="sb-foot">
        <div class="avatar">O</div>
        <div class="who">Omar<div class="role">Docent</div></div>
        <a href="index.html">Uitloggen</a>
      </div>
    </div>

    <div class="main">
      <div class="page-head"><h2>Instellingen</h2><div class="sub">Account- en systeeminstellingen</div></div>

      <div class="cards-row">
        <div class="card info-card" style="flex:1; min-width:260px;">
          <h3>Account instellingen</h3>
          <div class="desc" style="margin-bottom:14px;">Naam, e-mailadres en wachtwoord van je docentaccount.</div>
          <div class="field"><label>Naam</label><input type="text" value="Omar Najjar"></div>
          <div class="field"><label>E-mailadres</label><input type="text" value="omar@school.nl"></div>
          <button class="btn-secondary">Opslaan</button>
        </div>
        <div class="card info-card" style="flex:1; min-width:260px;">
          <h3>Systeem instellingen</h3>
          <div class="desc" style="margin-bottom:14px;">Tijdstip waarop een check-in als "te laat" geldt, en wanneer de dag automatisch wisselt.</div>
          <div class="field"><label>Grens "te laat" vanaf</label><input type="text" value="08:55"></div>
          <div class="field"><label>Nieuwe dag start om</label><input type="text" value="00:00" disabled></div>
          <button class="btn-secondary">Opslaan</button>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>