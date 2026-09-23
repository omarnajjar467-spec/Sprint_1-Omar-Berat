<?php
require "config.php";

?>
<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<title>Check-in Systeem · Studenten</title>
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
          <div class="nav-item active" onclick="toonPane('studentenlijst', this)">Studentenlijst</div>
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

      <!-- ===== STUDENTENLIJST ===== -->
      <div id="pane-studentenlijst" class="pane active">
        <div class="page-head-row">
          <div class="page-head"><h2>Studentenlijst</h2><div class="sub">Alle studenten in het systeem</div></div>
          <button class="btn-primary" onclick="openModal('add')">+ Student toevoegen</button>
        </div>
        <div class="filters">
          <input type="text" id="sSearch" placeholder="Zoek op naam…" oninput="renderStudents()">
          <select id="sGroup" onchange="renderStudents()">
            <option value="">Alle groepen</option>
            <option value="Klas 2A">Klas 2A</option>
            <option value="Klas 2B">Klas 2B</option>
          </select>
        </div>
        <div class="panel">
          <table>
            <thead><tr><th>Naam</th><th>Groep</th><th>Pasjenummer</th><th></th></tr></thead>
            <tbody id="studentBody"></tbody>
          </table>
        </div>
      </div>

      <!-- ===== STUDENTDETAIL ===== -->
      <div id="pane-studentdetail" class="pane">
        <a class="back-link" href="#" onclick="toonPane('studentenlijst'); return false;">&larr; Terug naar studentenlijst</a>
        <div id="studentDetailContent"></div>
      </div>

    </div>
  </div>
</div>

<!-- ===== MODAL: student toevoegen/bewerken ===== -->
<div class="modal-overlay" id="modalOverlay">
  <div class="modal">
    <h3 id="modalTitle">Student toevoegen</h3>
    <div class="field"><label>Naam</label><input type="text" id="mNaam" placeholder="Voor- en achternaam"></div>
    <div class="field"><label>E-mailadres</label><input type="text" id="mEmail" placeholder="naam@school.nl"></div>
    <div class="field"><label>Groep</label><select id="mGroep"><option>Klas 2A</option><option>Klas 2B</option></select></div>
    <div class="field"><label>Pasjenummer</label><input type="text" id="mPasje" placeholder="P-1050"></div>
    <div class="modal-actions">
      <button class="btn-secondary" onclick="closeModal()">Annuleren</button>
      <button class="btn-primary" onclick="saveStudent()">Opslaan</button>
    </div>
  </div>
</div>

<script src="data.js"></script>
<script>
  /* ===========================================
     NAVIGATIE TUSSEN DE TWEE PANES OP DEZE PAGINA
     =========================================== */

  function toonPane(naam, klikElement) {
    var panes = document.getElementsByClassName("pane");
    for (var i = 0; i < panes.length; i++) {
      panes[i].classList.remove("active");
    }
    document.getElementById("pane-" + naam).classList.add("active");

    var items = document.getElementsByClassName("nav-item");
    for (var j = 0; j < items.length; j++) {
      items[j].classList.remove("active");
    }
    if (klikElement) {
      klikElement.classList.add("active");
    }
  }

  /* ===========================================
     STUDENTENLIJST
     =========================================== */

  function renderStudents() {
    var zoekterm = document.getElementById("sSearch").value.toLowerCase();
    var gekozenGroep = document.getElementById("sGroup").value;

    var html = "";

    for (var i = 0; i < students.length; i++) {
      var s = students[i];
      var naamKomtOvereen = s.name.toLowerCase().indexOf(zoekterm) !== -1;
      var groepKomtOvereen = (gekozenGroep === "") || (s.group === gekozenGroep);

      if (naamKomtOvereen && groepKomtOvereen) {
        html += "<tr class='clickable' onclick='openStudentDetail(" + s.id + ")'>";
        html += "<td>" + s.name + "</td>";
        html += "<td><span class='group-tag'>" + s.group + "</span></td>";
        html += "<td>" + s.card + "</td>";
        html += "<td class='row-actions'><a href='#' onclick='event.stopPropagation(); openModal(\"edit\", " + s.id + ")'>Bewerken</a></td>";
        html += "</tr>";
      }
    }

    document.getElementById("studentBody").innerHTML = html;
  }

  /* ===========================================
     STUDENTDETAIL
     =========================================== */

  function openStudentDetail(id) {
    var s = studentById(id);
    if (s === null) {
      return;
    }

    var geschiedenisRijen = "";
    for (var i = 0; i < checkins.length; i++) {
      if (checkins[i].studentId === id) {
        geschiedenisRijen += "<tr><td>" + checkins[i].time + "</td><td>" + statusHtml(checkins[i].status) + "</td></tr>";
      }
    }
    if (geschiedenisRijen === "") {
      geschiedenisRijen = "<tr><td colspan='2' style='color:var(--tekst-zwak); padding:14px 18px;'>Nog geen check-ins.</td></tr>";
    }

    var html = "";
    html += "<div class='page-head'><h2>" + s.name + "</h2><div class='sub'>" + s.group + "</div></div>";
    html += "<div class='detail-grid'>";
    html += "<div class='detail-col'>";
    html += "<div class='card info-card' style='margin-bottom:var(--spacing);'>";
    html += "<h3 style='margin-bottom:10px;'>Persoonlijke info</h3>";
    html += "<div class='kv'><span class='k'>Naam</span><span>" + s.name + "</span></div>";
    html += "<div class='kv'><span class='k'>E-mail</span><span>" + s.email + "</span></div>";
    html += "<div class='kv'><span class='k'>Groep</span><span class='group-tag'>" + s.group + "</span></div>";
    html += "</div>";
    html += "<h3 style='font-size:14px; margin-bottom:8px;'>Check-in geschiedenis</h3>";
    html += "<div class='panel'><table><thead><tr><th>Tijd</th><th>Status</th></tr></thead>";
    html += "<tbody>" + geschiedenisRijen + "</tbody></table></div>";
    html += "</div>";
    html += "<div class='detail-col' style='max-width:300px;'>";
    html += "<h3 style='font-size:14px; margin-bottom:8px;'>Pasje <span class='badge'>CARD</span></h3>";
    html += "<div class='pasje-card'>";
    html += "<div class='top'><span class='lbl'>Studentenpas</span><span class='lbl'>Actief</span></div>";
    html += "<div class='num'>" + s.card + "</div>";
    html += "<div class='meta'><span>" + s.name + "</span><span>Geldig tot " + s.validUntil + "</span></div>";
    html += "</div></div></div>";

    document.getElementById("studentDetailContent").innerHTML = html;
    toonPane("studentdetail");
  }

  /* ===========================================
     MODAL: student toevoegen / bewerken
     =========================================== */

  var editingId = null;

  function openModal(mode, id) {
    editingId = null;
    document.getElementById("mNaam").value = "";
    document.getElementById("mEmail").value = "";
    document.getElementById("mGroep").value = "Klas 2A";
    document.getElementById("mPasje").value = "";

    if (mode === "edit") {
      var s = studentById(id);
      if (s !== null) {
        editingId = s.id;
        document.getElementById("mNaam").value = s.name;
        document.getElementById("mEmail").value = s.email;
        document.getElementById("mGroep").value = s.group;
        document.getElementById("mPasje").value = s.card;
      }
      document.getElementById("modalTitle").textContent = "Student bewerken";
    } else {
      document.getElementById("modalTitle").textContent = "Student toevoegen";
    }

    document.getElementById("modalOverlay").classList.add("active");
  }

  function closeModal() {
    document.getElementById("modalOverlay").classList.remove("active");
  }

  function saveStudent() {
    var naam = document.getElementById("mNaam").value || "Naamloos";
    var email = document.getElementById("mEmail").value || "—";
    var groep = document.getElementById("mGroep").value;
    var pasje = document.getElementById("mPasje").value || "—";

    if (editingId !== null) {
      var s = studentById(editingId);
      s.name = naam;
      s.email = email;
      s.group = groep;
      s.card = pasje;
    } else {
      students.push({
        id: nextId,
        name: naam,
        email: email,
        group: groep,
        card: pasje,
        validUntil: "2027-07-01"
      });
      nextId = nextId + 1;
    }

    closeModal();
    renderStudents();
  }

  // Tabel meteen vullen zodra de pagina laadt
  renderStudents();
</script>

</body>
</html>