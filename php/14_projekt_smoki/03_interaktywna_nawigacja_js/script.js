// UNIWERSALNY WZORZEC: Nawigacja — display block/none + MistyRose / #FFAEA5
// -----------------------------------------------------------------------------

function funkcjabaza() {
    // --- KROK 1: Widoczna tylko sekcja baza ---
    // [ZOBACZ W README: SEC-2]
    document.getElementById("baza").style.display = "block";
    document.getElementById("opisy").style.display = "none";
    document.getElementById("galeria").style.display = "none";

    // --- KROK 2: Aktywny nav MistyRose, reszta #FFAEA5 ---
    // [ZOBACZ W README: SEC-3]
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
