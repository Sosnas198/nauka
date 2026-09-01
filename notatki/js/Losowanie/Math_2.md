```html
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <title>Zadanie - Blok</title>
    <style>
      /* Styl dla diva z zadania: wielkość 100x100px oraz startowy rozmiar czcionki */
      #blok {
        height: 100px;
        width: 100px;
        font-size: 10px;
        border: 1px solid black; /* Dodane dla widoczności krawędzi bloku */
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <!-- Blok o id "blok" z imieniem i nazwiskiem -->
    <div id="blok">Jan Kowalski</div>

    <script>
      // 1. Globalny uchwyt - łapiemy blok RAZ na samym początku, żeby każda funkcja go widziała
      const blok = document.querySelector("#blok");

      // FUNKCJA 1: Losowanie koloru tła (z uwzględnieniem poprawnego zakresu 0-255)
      function kolor() {
        let r = Math.floor(Math.random() * 256);
        let g = Math.floor(Math.random() * 256);
        let b = Math.floor(Math.random() * 256);

        blok.style.backgroundColor = `rgb(${r}, ${g}, ${b})`;
      }

      // FUNKCJA 2: Powiększenie czcionki 2 razy (z 10px na 20px) po najechaniu
      function czcionka() {
        blok.style.fontSize = "20px";
      }

      // FUNKCJA 3: Powrót czcionki do pierwotnego rozmiaru (10px) po zabraniu kursora
      function czcionka_usun() {
        blok.style.fontSize = "10px";
      }

      // FUNKCJA 4: Podwójne kliknięcie - wycięcie nazwiska i wyświetlenie w konsoli
      function double() {
        let tekst = blok.innerHTML; // Pobieramy tekst "Jan Kowalski"
        let tablica = tekst.split(" "); // Tniemy tekst w miejscu spacji na tablicę
        let nazwisko = tablica[1]; // Wyciągamy drugi element (indeks 1 to "Kowalski")

        console.log(nazwisko); // Wyświetlamy nazwisko w konsoli przeglądarki
      }

      // 2. Nasłuchiwacze zdarzeń (addEventListener) łączące akcje użytkownika z funkcjami w JS
      blok.addEventListener("click", kolor);
      blok.addEventListener("mouseover", czcionka);
      blok.addEventListener("mouseout", czcionka_usun);
      blok.addEventListener("dblclick", double);
    </script>
  </body>
</html>
```
