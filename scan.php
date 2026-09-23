<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<title>Check-in Systeem · Scan pasje</title>
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
          <div class="nav-item active">Scan pasje</div>
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
      <div class="page-head"><h2>Scan pasje</h2><div class="sub">Houd de scanner op dit veld gericht, of typ handmatig en druk op Enter</div></div>

      <div class="scan-box">
        <div class="field">
          <label>Pasjenummer</label>
          <input type="text" id="scanInput" placeholder="Scan een pasje of typ P-1042" autofocus autocomplete="off">
        </div>
        <button class="btn-primary btn-block" onclick="verwerkScan()">Scan pasje</button>
      </div>

      <div class="result-box" id="scanResult">
        <svg class="icon icon-lg" id="scanIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"></svg>
        <div>
          <div class="rt" id="scanTitle"></div>
          <div class="rs" id="scanSub"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var scanInput = document.getElementById("scanInput");

  // Een scanner stuurt de tekens razendsnel achter elkaar en daarna een Enter.
  // Daarom wachten we op Enter, in plaats van op elk teken te reageren.
  scanInput.addEventListener("keydown", function (event) {
    if (event.key === "Enter") {
      event.preventDefault(); // voorkomt dat er per ongeluk een formulier verstuurd wordt
      verwerkScan();
    }
  });

  // Houd het veld altijd gefocust, zodat de scanner er altijd in kan "typen",
  // ook als iemand per ongeluk ergens anders op de pagina klikt.
  scanInput.addEventListener("blur", function () {
    setTimeout(function () {
      scanInput.focus();
    }, 100);
  });

  function verwerkScan() {
    var cardNumber = scanInput.value.trim();
    scanInput.value = "";

    if (cardNumber === "") {
      return;
    }

    fetch("checkin.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ cardNumber: cardNumber })
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        toonResultaat(data);
      })
      .catch(function () {
        toonResultaat({ error: "Kon geen verbinding maken met de server." });
      });
  }

  function toonResultaat(data) {
    var box = document.getElementById("scanResult");
    var icon = document.getElementById("scanIcon");
    var title = document.getElementById("scanTitle");
    var sub = document.getElementById("scanSub");

    box.classList.remove("ok", "fout");

    if (data.error) {
      box.classList.add("fout");
      icon.innerHTML = "<circle cx='12' cy='12' r='9'/><path d='M12 8v5'/><path d='M12 16.2h.01'/>";
      title.textContent = "Kon niet inchecken";
      sub.textContent = data.error;
      box.classList.add("show");
      return;
    }

    if (data.status === "op_tijd") {
      box.classList.add("ok");
      icon.innerHTML = "<path d='M5 12l5 5 9-10'/>";
      title.textContent = "Op tijd ingecheckt";
    } else {
      box.classList.add("fout");
      icon.innerHTML = "<circle cx='12' cy='12' r='9'/><path d='M12 8v5'/><path d='M12 16.2h.01'/>";
      title.textContent = "Te laat ingecheckt";
    }

    sub.textContent = data.student + " · " + data.groep + " · " + data.tijd;
    box.classList.add("show");
  }
</script>

</body>
</html>