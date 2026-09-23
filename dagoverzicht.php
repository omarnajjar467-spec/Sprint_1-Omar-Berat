<?php
require "config.php";

?>


<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<title>Check-in Systeem · Dagoverzicht</title>
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
          <div class="nav-item active">Alle check-ins</div>
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
      <div class="page-head"><h2>Dagoverzicht</h2><div class="sub">Alle check-ins van vandaag</div></div>

      <div class="filters">
        <input type="text" id="fStudent" placeholder="Zoek op student…" oninput="renderCheckins()">
        <select id="fGroup" onchange="renderCheckins()">
          <option value="">Alle groepen</option>
          <option value="Klas 2A">Klas 2A</option>
          <option value="Klas 2B">Klas 2B</option>
        </select>
        <select id="fStatus" onchange="renderCheckins()">
          <option value="">Alle statussen</option>
          <option value="ok">Op tijd</option>
          <option value="fout">Te laat</option>
        </select>
      </div>

      <div class="panel">
        <table>
          <thead><tr><th>Tijd</th><th>Student</th><th>Groep</th><th>Pasje</th><th>Status</th></tr></thead>
          <tbody id="checkinBody"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="data.js"></script>
<script>
  function renderCheckins() {
    var zoekterm = document.getElementById("fStudent").value.toLowerCase();
    var gekozenGroep = document.getElementById("fGroup").value;
    var gekozenStatus = document.getElementById("fStatus").value;

    var html = "";

    for (var i = 0; i < checkins.length; i++) {
      var c = checkins[i];
      var s = studentById(c.studentId);
      if (s === null) {
        continue;
      }

      var naamKomtOvereen = s.name.toLowerCase().indexOf(zoekterm) !== -1;
      var groepKomtOvereen = (gekozenGroep === "") || (s.group === gekozenGroep);
      var statusKomtOvereen = (gekozenStatus === "") || (c.status === gekozenStatus);

      if (naamKomtOvereen && groepKomtOvereen && statusKomtOvereen) {
        html += "<tr>";
        html += "<td>" + c.time + "</td>";
        html += "<td>" + s.name + "</td>";
        html += "<td><span class='group-tag'>" + s.group + "</span></td>";
        html += "<td>" + c.card + "</td>";
        html += "<td>" + statusHtml(c.status) + "</td>";
        html += "</tr>";
      }
    }

    if (html === "") {
      html = "<tr><td colspan='5' style='color:var(--tekst-zwak); padding:18px;'>Geen check-ins gevonden voor deze filters.</td></tr>";
    }

    document.getElementById("checkinBody").innerHTML = html;
  }

  renderCheckins();
</script>

</body>
</html>