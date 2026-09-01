// UNIWERSALNY WZORZEC: Skrypt 2 — mouseover, display sekcji, Salmon / Crimson
// -----------------------------------------------------------------------------

// --- KROK 1: Funkcja po najechaniu na przycisk „Kolor” ---
// [ZOBACZ W README: SEC-1, SEC-2 oraz SEC-4]
function kolor() {
    // [ZOBACZ W README: SEC-2] Pierwsza sekcja widoczna, pozostałe ukryte
    document.getElementById("sekcja1").style.display = "block";
    document.getElementById("sekcja2").style.display = "none";
    document.getElementById("sekcja3").style.display = "none";

    // [ZOBACZ W README: SEC-3 oraz SEC-4] Pierwszy przycisk Salmon, reszta Crimson
    const przyciski = document.querySelectorAll("nav button");
    przyciski[0].style.backgroundColor = "Salmon";
    przyciski[1].style.backgroundColor = "Crimson";
    przyciski[2].style.backgroundColor = "Crimson";
}

// --- KROK 2: Funkcja po najechaniu na przycisk „Kształt” ---
// [ZOBACZ W README: SEC-5]
function ksztalt() {
    document.getElementById("sekcja1").style.display = "none";
    document.getElementById("sekcja2").style.display = "block";
    document.getElementById("sekcja3").style.display = "none";

    const przyciski = document.querySelectorAll("nav button");
    przyciski[0].style.backgroundColor = "Crimson";
    przyciski[1].style.backgroundColor = "Salmon";
    przyciski[2].style.backgroundColor = "Crimson";
}

// --- KROK 3: Funkcja po najechaniu na przycisk „Wzór” ---
// [ZOBACZ W README: SEC-5]
function wzor() {
    document.getElementById("sekcja1").style.display = "none";
    document.getElementById("sekcja2").style.display = "none";
    document.getElementById("sekcja3").style.display = "block";

    const przyciski = document.querySelectorAll("nav button");
    przyciski[0].style.backgroundColor = "Crimson";
    przyciski[1].style.backgroundColor = "Crimson";
    przyciski[2].style.backgroundColor = "Salmon";
}
