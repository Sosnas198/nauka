// UNIWERSALNY WZORZEC: Skrypt (część 3) — obliczenie raty i pełny komunikat
// -----------------------------------------------------------------------------

// --- KROK 1: Obliczenie wysokości jednej raty ---
// [ZOBACZ W README: SEC-1]
const rata = (kwotaCalkowita / liczbaRat).toFixed(2);

// --- KROK 2: Zbudowanie i wyświetlenie pełnego komunikatu ---
// [ZOBACZ W README: SEC-2]
wynik.textContent = `Kurs odbędzie się w ${miasto}. Koszt całkowity: ${kwotaCalkowita} zł. Płacisz ${liczbaRat} rat po ${rata} zł`;
