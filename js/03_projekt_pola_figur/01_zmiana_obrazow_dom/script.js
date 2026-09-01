// UNIWERSALNY WZORZEC: Skrypt 1 — zmiana src dużego obrazu po kliknięciu miniatury
// -----------------------------------------------------------------------------

// --- KROK 1: Miniatura 1m.bmp → duży obraz 1d.bmp (trójkąt) ---
// [ZOBACZ W README: SEC-1]
function wybierzTrojkat() {
    document.getElementById("duzyObraz").src = "1d.bmp";
}

// --- KROK 2: Miniatura 2m.bmp → duży obraz 2d.bmp (prostokąt) ---
// [ZOBACZ W README: SEC-2]
function wybierzProstokat() {
    document.getElementById("duzyObraz").src = "2d.bmp";
}
