// UNIWERSALNY WZORZEC: Bezpieczne pobieranie nazwy pliku z inputa
// -----------------------------------------------------------------------------

// --- KROK 1: Pobieranie elementu z HTML ---
// [ZOBACZ W README: SEC-1]
const inputPliku = document.getElementById("plikInput");

// --- KROK 2: Zabezpieczenie przed pustym inputem ---
// [ZOBACZ W README: SEC-2]
if (inputPliku.files.length > 0) {
    
    // --- KROK 3: Odczytywanie czystej nazwy pliku z tablicy files ---
    // [ZOBACZ W README: SEC-3]
    const nazwaPliku = inputPliku.files[0].name;
    
    console.log(nazwaPliku); // Wyświetli w konsoli czysty tekst: "smok.png"
    
} else {
    console.log("Hej, zapomniałeś dodać plik!");
}