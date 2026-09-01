// UNIWERSALNY WZORZEC: Skrypt 2 — Number(), includes("2d.bmp"), pole, #wynik
// -----------------------------------------------------------------------------

function obliczPole() {
    // --- KROK 1: Dane z pól a i b oraz aktualny src dużego obrazu ---
    // [ZOBACZ W README: SEC-1]
    var bokA = Number(document.getElementById("a").value);
    var bokB = Number(document.getElementById("b").value);
    var srcObrazu = document.getElementById("duzyObraz").src;
    var wynik = 0;

    // --- KROK 2: Prostokąt tylko przy 2d.bmp; inaczej trójkąt (także stan początkowy) ---
    // [ZOBACZ W README: SEC-2]
    if (srcObrazu.includes("2d.bmp")) {
        wynik = bokA * bokB;
    } else {
        wynik = (bokA * bokB) / 2;
    }

    // --- KROK 3: Wynik w paragrafie pod przyciskiem ---
    // [ZOBACZ W README: SEC-3]
    document.getElementById("wynik").textContent = wynik;
}
