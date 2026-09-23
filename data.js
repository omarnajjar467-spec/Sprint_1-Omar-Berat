/* ===========================================
   GEGEVENS
   Dit stelt de database voor. Elke pagina laadt
   dit bestand in en begint dus met dezelfde data.
   =========================================== */

var students = [
  { id: 1, name: "Sanne de Vries",    group: "Klas 2A", card: "P-1042", email: "sanne.devries@school.nl", validUntil: "2027-07-01" },
  { id: 2, name: "Omar Yildiz",       group: "Klas 2A", card: "P-1043", email: "omar.yildiz@school.nl", validUntil: "2027-07-01" },
  { id: 3, name: "Berat Aydin",       group: "Klas 2B", card: "P-1044", email: "berat.aydin@school.nl", validUntil: "2027-07-01" },
  { id: 4, name: "Lotte Bakker",      group: "Klas 2B", card: "P-1045", email: "lotte.bakker@school.nl", validUntil: "2027-07-01" },
  { id: 5, name: "Youssef El Amrani", group: "Klas 2A", card: "P-1046", email: "youssef.elamrani@school.nl", validUntil: "2027-07-01" },
  { id: 6, name: "Fenna Visser",      group: "Klas 2B", card: "P-1047", email: "fenna.visser@school.nl", validUntil: "2027-07-01" },
  { id: 7, name: "Nora Peters",       group: "Klas 2A", card: "P-1048", email: "nora.peters@school.nl", validUntil: "2027-07-01" }
];
var nextId = 8;

var checkins = [
  { time: "08:41", studentId: 1, card: "P-1042", status: "ok" },
  { time: "08:43", studentId: 2, card: "P-1043", status: "ok" },
  { time: "08:44", studentId: 3, card: "P-1044", status: "ok" },
  { time: "08:47", studentId: 4, card: "P-1045", status: "ok" },
  { time: "08:58", studentId: 5, card: "P-1046", status: "fout" },
  { time: "09:02", studentId: 6, card: "P-1047", status: "fout" }
];

/* ===========================================
   HULPFUNCTIES
   Deze worden op meerdere pagina's gebruikt.
   =========================================== */

// Zoekt een student op zijn id. Geeft de student terug, of null.
function studentById(id) {
  for (var i = 0; i < students.length; i++) {
    if (students[i].id == id) {
      return students[i];
    }
  }
  return null;
}

// Zoekt een student op zijn pasjenummer. Geeft de student terug, of null.
function studentByCard(cardNumber) {
  for (var i = 0; i < students.length; i++) {
    if (students[i].card.toLowerCase() === cardNumber.toLowerCase()) {
      return students[i];
    }
  }
  return null;
}

// Bouwt de kleine "Op tijd" / "Te laat" label met icoon.
function statusHtml(status) {
  if (status == "ok") {
    return "<span class='status ok'><svg class='icon' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.4'><path d='M5 12l5 5 9-10'/></svg>Op tijd</span>";
  }
  return "<span class='status fout'><svg class='icon' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.4'><circle cx='12' cy='12' r='9'/><path d='M12 8v5'/><path d='M12 16.2h.01'/></svg>Te laat</span>";
}



