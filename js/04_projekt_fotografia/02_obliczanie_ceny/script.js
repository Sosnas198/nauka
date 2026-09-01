// UNIWERSALNY WZORZEC: Skrypt 2 — obliczanie ceny wg liczby kopii i rodzaju papieru
// -----------------------------------------------------------------------------

// --- KROK 1: Cennik za kopię wg rodzaju papieru ---
// [ZOBACZ W README: SEC-1]
const pricePerCopy = {
    blyszczacy: 1.5,
    matowy: 2
}

// --- KROK 2: Cena jednostkowa i cena całkowita ---
// [ZOBACZ W README: SEC-2]
const unitPrice = pricePerCopy[paperType] ?? pricePerCopy.blyszczacy
const totalPrice = (copies * unitPrice)
