// UNIWERSALNY WZORZEC: Skrypt (część 3) — grupowanie co 4 cyfry i wyświetlenie wyniku
// -----------------------------------------------------------------------------

// --- KROK 1: Pętla grupująca cyfry co 4 znaki od prawej strony ---
// [ZOBACZ W README: SEC-1]
let binarnyGrupowany = "";
for (let i = binarny.length; i > 0; i -= 4) {
    let start = Math.max(i - 4, 0);
    let grupa = binarny.substring(start, i);
    binarnyGrupowany = grupa + (binarnyGrupowany ? " " + binarnyGrupowany : "");
}

// --- KROK 2: Wyświetlenie wyniku z oznaczeniem systemu binarnego ---
// [ZOBACZ W README: SEC-2]
wynikElement.innerHTML = binarnyGrupowany + ' <sub>(2)</sub>';
