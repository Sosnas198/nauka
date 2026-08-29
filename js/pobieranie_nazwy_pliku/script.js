// UNIWERSALNY WZORZEC: Pobieranie nazwy pliku z input[type="file"]

const inputPliku = document.getElementById("wzor");

// Sprawdzenie czy użytkownik w ogóle wybrał plik
if (inputPliku.files.length > 0) {
    const nazwaPliku = inputPliku.files[0].name;
    console.log(nazwaPliku); // Wyświetli np. "smok.png"
} else {
    console.log("Nie wybrano żadnego pliku");
}