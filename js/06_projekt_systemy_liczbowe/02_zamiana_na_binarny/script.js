// UNIWERSALNY WZORZEC: Skrypt (część 2) — algorytm zamiany na system binarny
// -----------------------------------------------------------------------------

// --- KROK 1: Przypadek szczególny — liczba zero ---
// [ZOBACZ W README: SEC-1]
if (liczba === 0) {
    wynikElement.innerHTML = "0 <sub>(2)</sub>";
    return;
}

// --- KROK 2: Pętla algorytmu — dzielenie przez 2 i zbieranie reszt ---
// [ZOBACZ W README: SEC-2]
let binarny = "";
while (liczba > 0) {
    binarny = (liczba % 2) + binarny;
    liczba = Math.floor(liczba / 2);
}
