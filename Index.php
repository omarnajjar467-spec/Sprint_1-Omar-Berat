<?php
require "config.php";

?>

<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<title>Check-in Systeem · Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>


<!-- ================= LOGIN ================= -->
<div id="login-screen">
  <div class="login-card">
    <div class="brand-row"><div class="brand-mark"></div><h1>Docent Login</h1></div>
    <div class="sub">Alleen docenten hebben toegang tot het dashboard.</div>
    <div class="field"><label>E-mailadres</label><input type="email" value="omar@school.nl"></div>
    <div class="field"><label>Wachtwoord</label><input type="password" value="••••••••"></div>
    <button class="btn-primary btn-block" onclick="login()">Inloggen</button>
    <div class="login-note">Demo-omgeving · geen echte authenticatie</div>
  </div>
</div>

<!-- ================= DASHBOARD: HOME ================= -->
<div id="dash-screen">
  <div class="shell">
    <div class="sidebar">
      <div class="sb-brand"><div class="brand-mark"></div><span>Check-in Systeem</span></div>

      <div class="nav-group">
        <div class="nav-head top active">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 11l9-7 9 7"/><path d="M5 10v9a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1v-9"/></svg>
          Home
        </div>
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
          <a class="nav-item" href="instellingen.php">Account &amp; systeem</a>
        </div>
      </div>

      <div class="sb-foot">
        <div class="avatar">O</div>
        <div class="who">Omar<div class="role">Docent</div></div>
        <a href="index.php">Uitloggen</a>
      </div>
    </div>

    <div class="main">
      <div class="page-head"><h2>Home</h2><div class="sub">Snel overzicht van vandaag</div></div>

      <div class="cards-row">
        <div class="card stat-card"><div class="num" id="totaalStudenten"></div><div class="lbl">Studenten totaal</div></div>
        <div class="card stat-card"><div class="num" id="homeOk"></div><div class="lbl">Op tijd ingecheckt</div></div>
        <div class="card stat-card"><div class="num" id="homeLate"></div><div class="lbl">Te laat</div></div>
      </div>

      <div class="cards-row">
        <a class="card link-card" href="scan.php" style="text-decoration:none; color:inherit;">
          <svg class="icon icon-lg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="4" width="16" height="16" rx="2"/><path d="M9 9h6v6H9z"/></svg>
          <h3>Pasje scannen</h3>
          <div class="desc">Registreer een nieuwe check-in.</div>
        </a>
        <a class="card link-card" href="dagoverzicht.php" style="text-decoration:none; color:inherit;">
          <svg class="icon icon-lg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 10h18"/></svg>
          <h3>Dagoverzicht</h3>
          <div class="desc">Bekijk alle check-ins van vandaag.</div>
        </a>
        <a class="card link-card" href="studenten.php" style="text-decoration:none; color:inherit;">
          <svg class="icon icon-lg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="3.2"/><path d="M5 20c0-3.6 3.1-6 7-6s7 2.4 7 6"/></svg>
          <h3>Studenten</h3>
          <div class="desc">Naam, klas, pasnummer…</div>
        </a>
      </div>
    </div>
  </div>
</div>

<script src="data.js"></script>
<script>
  // Alleen inloggen en de cijfers op deze pagina hoeven hier geregeld te worden.

  function login() {
    document.getElementById("login-screen").style.display = "none";
    document.getElementById("dash-screen").style.display = "block";
  }

  // Cijfers meteen invullen (ook al staat het dashboard nog verborgen achter de login)
  document.getElementById("totaalStudenten").textContent = students.length;

  var aantalOk = 0;
  var aantalFout = 0;
  for (var i = 0; i < checkins.length; i++) {
    if (checkins[i].status == "ok") {
      aantalOk = aantalOk + 1;
    } else {
      aantalFout = aantalFout + 1;
    }
  }
  document.getElementById("homeOk").textContent = aantalOk;
  document.getElementById("homeLate").textContent = aantalFout;
</script>

</body>
</html>