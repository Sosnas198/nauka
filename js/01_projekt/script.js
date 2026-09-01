// POŁĄCZONY WZORZEC (Moduł 01 + Moduł 02)
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1] Pobieranie inputa
const inputPliku = document.getElementById("plikInput");

// Moduł 01: [SEC-2] Walidacja obecności pliku
if (inputPliku.files.length > 0) {
    
    // Moduł 01: [SEC-3] Pobranie czystej nazwy
    const nazwaPliku = inputPliku.files[0].name;

    // Moduł 02: [SEC-1] Tworzenie elementu w pamięci
    const nowyObraz = document.createElement("img");
    
    // Moduł 02: [SEC-2] Konfiguracja atrybutów i stylów
    nowyObraz.src = nazwaPliku;
    nowyObraz.alt = nazwaPliku;
    nowyObraz.classList.add("miniatury");

    // Moduł 02: [SEC-3] Wklejenie do drzewa DOM
    const galeria = document.querySelector("section");
    galeria.appendChild(nowyObraz);
}