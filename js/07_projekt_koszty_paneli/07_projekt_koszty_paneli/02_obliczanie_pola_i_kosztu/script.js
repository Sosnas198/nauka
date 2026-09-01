// UNIWERSALNY WZORZEC: Skrypt (część 2) — obliczanie pola powierzchni i kosztu montażu
// -----------------------------------------------------------------------------

// --- KROK 1: Obliczenie pola powierzchni pomieszczenia ---
// [ZOBACZ W README: SEC-1]
const pole = szerokosc * dlugosc;

// --- KROK 2: Ustalenie kosztu za metr kwadratowy zależnie od typu panelu ---
// [ZOBACZ W README: SEC-2]
let kosztZaM2 = 0;
if (typPanelu.value === "laminowane") kosztZaM2 = 12;
else if (typPanelu.value === "winylowe") kosztZaM2 = 14;
else if (typPanelu.value === "deska") kosztZaM2 = 18;

// --- KROK 3: Obliczenie całkowitego kosztu montażu ---
// [ZOBACZ W README: SEC-3]
const koszt = pole * kosztZaM2;
