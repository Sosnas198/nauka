// UNIWERSALNY WZORZEC: Skrypt (część 2) — walidacja liczby rat i częściowy wynik
// -----------------------------------------------------------------------------

// --- KROK 1: Sprawdzenie poprawności liczby rat ---
// [ZOBACZ W README: SEC-1]
if (isNaN(liczbaRat) || liczbaRat < 1) {
    wynik.textContent = `Kurs odbędzie się w ${miasto}. Koszt całkowity: ${kwotaCalkowita} zł.`;
    return;
}
