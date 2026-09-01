// UNIWERSALNY WZORZEC: Skrypt 1 — 10 obrazów w pętli (src, klasa wzory, title)
// -----------------------------------------------------------------------------

const sekcjaWzor = document.getElementById("sekcja3");

// --- KROK 1: Pętla od 1 do 10 (pliki 1.jpg … 10.jpg) ---
// [ZOBACZ W README: SEC-1]
for (let i = 1; i <= 10; i++) {

    // --- KROK 2: Nowy znacznik img w pamięci ---
    // [ZOBACZ W README: SEC-2]
    const obraz = document.createElement("img");

    // --- KROK 3: Źródło, klasa wzory, dymek z numerem ---
    // [ZOBACZ W README: SEC-3]
    obraz.src = i + ".jpg";
    obraz.className = "wzory";
    obraz.title = i;

    // --- KROK 4: Wklejenie do sekcji Wzór ---
    // [ZOBACZ W README: SEC-4]
    sekcjaWzor.appendChild(obraz);
}
