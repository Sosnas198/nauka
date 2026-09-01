// POŁĄCZONY WZORZEC — Moduł 03 (nawigacja)
// -----------------------------------------------------------------------------

function funkcjabaza() {
    // Moduł 03: [SEC-2] Sekcja baza widoczna, opisy i galeria ukryte
    document.getElementById("baza").style.display = "block";
    document.getElementById("opisy").style.display = "none";
    document.getElementById("galeria").style.display = "none";

    // Moduł 03: [SEC-3] Aktywny nav: MistyRose, pozostałe: #FFAEA5
    document.getElementById("nav-baza").style.backgroundColor = "MistyRose";
    document.getElementById("nav-opisy").style.backgroundColor = "#FFAEA5";
    document.getElementById("nav-galeria").style.backgroundColor = "#FFAEA5";
}

function funkcjaopisy() {
    document.getElementById("baza").style.display = "none";
    document.getElementById("opisy").style.display = "block";
    document.getElementById("galeria").style.display = "none";

    document.getElementById("nav-baza").style.backgroundColor = "#FFAEA5";
    document.getElementById("nav-opisy").style.backgroundColor = "MistyRose";
    document.getElementById("nav-galeria").style.backgroundColor = "#FFAEA5";
}

function funkcjagaleria() {
    document.getElementById("baza").style.display = "none";
    document.getElementById("opisy").style.display = "none";
    document.getElementById("galeria").style.display = "block";

    document.getElementById("nav-baza").style.backgroundColor = "#FFAEA5";
    document.getElementById("nav-opisy").style.backgroundColor = "#FFAEA5";
    document.getElementById("nav-galeria").style.backgroundColor = "MistyRose";
}
