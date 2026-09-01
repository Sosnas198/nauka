## 1. Zadanie 1: Analiza łańcucha znaków i zmiana DOM

### A. Pełny kod programu (HTML + JavaScript)

**HTML**

```html id="6g2m4p"
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <title>Zadanie 1 - Analiza Łańcucha</title>
  </head>
  <body>
    <input type="text" id="haslo" placeholder="podaj hasło" />
    <button type="button" onclick="lancuch()">przycisk</button>
    <p id="tekst">Tekst do wymiany</p>
    <section id="wynik"></section>

    <script>
      function lancuch() {
        // Pobranie wartości i elementów z DOM
        let haslo = document.getElementById("haslo").value;
        let wynik = document.getElementById("wynik");
        let paragraf = document.getElementById("tekst");

        // Czyszczenie poprzedniego wyniku
        wynik.innerHTML = "";

        // 1. Informacja jeśli pole jest puste
        if (haslo.length === 0) {
          wynik.innerHTML = "pole jest puste";
          return; // Przerwanie dalszego wykonywania
        }

        // 2. Długość wpisu
        wynik.innerHTML += "Długość wpisu: " + haslo.length + "<br>";

        // 3. Czy wpis zawiera znak "&" i na którym miejscu
        let pozycjaAnd = haslo.search("&");
        if (pozycjaAnd !== -1) {
          // Pozycja dla użytkownika liczona od 1 (stąd +1 do indeksu)
          wynik.innerHTML +=
            "Zawiera znak '&' na pozycji: " + (pozycjaAnd + 1) + "<br>";
        } else {
          wynik.innerHTML += "Brak znaku '&'<br>";
        }

        // 4. Czy wpis zawiera dużą literę
        if (haslo.search(/[A-Z]/) !== -1) {
          wynik.innerHTML += "Zawiera dużą literę<br>";
        } else {
          wynik.innerHTML += "Nie zawiera dużej litery<br>";
        }

        // 5. Czy zawiera małą literę
        if (haslo.search(/[a-z]/) !== -1) {
          wynik.innerHTML += "Zawiera małą literę<br>";
        } else {
          wynik.innerHTML += "Nie zawiera małej litery<br>";
        }

        // 6. Czy zawiera jakąś cyfrę
        if (haslo.search(/[0-9]/) !== -1) {
          wynik.innerHTML += "Zawiera cyfrę<br>";
        } else {
          wynik.innerHTML += "Nie zawiera cyfry<br>";
        }

        // 7. Czy zawiera znak ze zbioru !@#$%
        if (haslo.search(/[!@#$%]/) !== -1) {
          wynik.innerHTML += "Zawiera znak specjalny (!@#$%)<br><br>";
        } else {
          wynik.innerHTML += "Nie zawiera znaku specjalnego (!@#$%)<br><br>";
        }

        // 8. Wpisany ciąg pisany wielkimi literami
        wynik.innerHTML += "Wielkie litery: " + haslo.toUpperCase() + "<br>";

        // 9. Wpisany ciąg pisany małymi literami
        wynik.innerHTML += "Małe litery: " + haslo.toLowerCase() + "<br>";

        // 10. Pierwsza litera wielka, pozostałe małe (Kapitalizacja)
        let kapitalizacja =
          haslo.charAt(0).toUpperCase() + haslo.slice(1).toLowerCase();
        wynik.innerHTML +=
          "Pierwsza wielka, reszta małe: " + kapitalizacja + "<br>";

        // 11. Trzy znaki ciągu począwszy od 3 znaku (indeks 2)
        if (haslo.length >= 5) {
          // substr(2, 3) wycina 3 znaki zaczynając od indeksu 2 (trzeci znak)
          wynik.innerHTML +=
            "Trzy znaki od 3. znaku: " + haslo.substr(2, 3) + "<br><br>";
        } else {
          wynik.innerHTML +=
            "Hasło za krótkie na wycięcie 3 znaków od 3. znaku<br><br>";
        }

        // 12. Zamiana słowa "wymiany" w paragrafie na wpisany ciąg
        if (paragraf.innerHTML.includes("wymiany")) {
          paragraf.innerHTML = paragraf.innerHTML.replace("wymiany", haslo);
          wynik.innerHTML += "Paragraf został zaktualizowany";
        } else {
          wynik.innerHTML += "Paragraf nie zawiera już słowa 'wymiany'";
        }
      }
    </script>
  </body>
</html>
```

### B. Omówienie użytych metod i mechanizmów (Zadanie 1)

1. **Przeszukiwanie za pomocą `.search()` oraz wyrażeń regularnych (`RegEx`):**
   - Metoda `.search()` przeszukuje ciąg tekstowy.
   - Jeśli dopasowanie zostanie znalezione, zwraca **indeks pierwszego wystąpienia** (liczba $\ge 0$).
   - Jeśli dopasowania brak, **zawsze zwraca wartość** **`-1`**.
   - wzorce `/[A-Z]/`, `/[a-z]/`, `/[0-9]/`, `/[!@#$%]/` sprawdzają obecność przynajmniej jednego znaku z podanej klasy.

2. **Główne metody transformacji tekstu**:
   - **`.toUpperCase()`**: Zamienia wszystkie litery na wielkie.
   - **`.toLowerCase()`**: Zamienia wszystkie litery na małe.
   - **`.charAt(0)`**: Wyciąga pojedynczy znak znajdujący się pod wskazanym indeksem (tutaj: pierwsza litera).
   - **`.slice(1)`**: Odcina fragment ciągu od wskazanego indeksu do końca.
   - **`.substr(start, length)`**: Wyciąga określoną liczbę znaków (`length`), zaczynając od podanej pozycji (`start`).
   - **`.includes("tekst")`**: Zwraca `true` lub `false` w zależności od tego, czy szukany ciąg występuje w tekście.
   - **`.replace("stare", "nowe")`**: Podmienia pierwsze wystąpienie wskazanego słowa na nową wartość.

## 2. Zadanie 2: Formularz danych użytkownika, walidacja i generowanie poświadczeń

### A. Pełny kod programu (HTML + JavaScript)

**HTML**

```html id="7y4t8r"
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <title>Zadanie 2 - Formularz i Generowanie Danych</title>
  </head>
  <body>
    <h2>Formularz danych</h2>
    Imię: <input type="text" id="imie" /><br /><br />
    Nazwisko: <input type="text" id="nazwisko" /><br /><br />
    Miejsce zamieszkania: <input type="text" id="miejsce" /><br /><br />
    Klasa: <input type="text" id="klasa" /><br /><br />

    <button onclick="generuj()">Zatwierdź</button>
    <button onclick="czysc()">Wyczyść pola</button>

    <h3>Wyniki analizy:</h3>
    <section id="wynik"></section>

    <script>
      function generuj() {
        // 1. Pobranie danych z obcięciem zbędnych spacji na brzegach (.trim())
        let imie = document.getElementById("imie").value.trim();
        let nazwisko = document.getElementById("nazwisko").value.trim();
        let miejsce = document.getElementById("miejsce").value.trim();
        let klasa = document.getElementById("klasa").value.trim();

        let wynik = document.getElementById("wynik");
        wynik.innerHTML = ""; // Czyszczenie sekcji przed nowym wygenerowaniem

        // 2. Walidacja: czy pola nie są puste
        if (imie === "" || nazwisko === "" || miejsce === "" || klasa === "") {
          wynik.innerHTML = "Błąd: Wszystkie pola muszą być wypełnione!";
          return;
        }

        // 3. Walidacja: czy imię, nazwisko i miejscowość nie są samymi liczbami
        // !isNaN(wartość) zwraca true, jeśli ciąg da się w pełni przekonwertować na liczbę
        if (!isNaN(imie) || !isNaN(nazwisko) || !isNaN(miejsce)) {
          wynik.innerHTML =
            "Błąd: Imię, nazwisko i miejscowość nie mogą być samymi liczbami!";
          return;
        }

        // 4. Generowanie loginu: 3 pierwsze litery imienia + 3 pierwsze litery nazwiska + klasa połączone '_'
        let login =
          imie.slice(0, 3).toLowerCase() +
          "_" +
          nazwisko.slice(0, 3).toLowerCase() +
          "_" +
          klasa.toLowerCase();

        // 5. Generowanie hasła: 3 ostatnie litery imienia i 3 ostatnie litery nazwiska
        // Pierwsze litery każdej z tych dwóch części mają być wielkie, pozostałe małe
        let imieKoniec = imie.slice(-3).toLowerCase();
        let imieHaslo =
          imieKoniec.charAt(0).toUpperCase() + imieKoniec.slice(1);

        let nazwiskoKoniec = nazwisko.slice(-3).toLowerCase();
        let nazwiskoHaslo =
          nazwiskoKoniec.charAt(0).toUpperCase() + nazwiskoKoniec.slice(1);

        let haslo = imieHaslo + nazwiskoHaslo;

        // 6. Generowanie adresu e-mail: imie.nazwisko@miejscowosc.pl (pisane małymi literami)
        let email =
          imie.toLowerCase() +
          "." +
          nazwisko.toLowerCase() +
          "@" +
          miejsce.toLowerCase() +
          ".pl";

        // 7. Sprawdzenie, czy w miejscowości znajduje się litera "a"
        let czyMaA = "";
        if (miejsce.toLowerCase().indexOf("a") !== -1) {
          czyMaA = "Tak, nazwa miejscowości zawiera literę 'a'.";
        } else {
          czyMaA = "Nie, nazwa miejscowości nie zawiera litery 'a'.";
        }

        // 8. Wyświetlenie wyników w sekcji DOM
        wynik.innerHTML += "<b>Utworzony login:</b> " + login + "<br>";
        wynik.innerHTML += "<b>Wygenerowane hasło:</b> " + haslo + "<br>";
        wynik.innerHTML += "<b>Adres e-mail:</b> " + email + "<br><br>";
        wynik.innerHTML += "<i>Sprawdzenie miejscowości:</i> " + czyMaA;
      }

      // Funkcja czyszcząca wszystkie pola i wynik
      function czysc() {
        document.getElementById("imie").value = "";
        document.getElementById("nazwisko").value = "";
        document.getElementById("miejsce").value = "";
        document.getElementById("klasa").value = "";
        document.getElementById("wynik").innerHTML = "";
      }
    </script>
  </body>
</html>
```

### B. Omówienie kluczowych koncepcji i trików (Zadanie 2)

1. **Sprawdzanie, czy wpisano tekst, a nie liczbę (`isNaN`):**
   - Funkcja `isNaN(wartość)` sprawdz czy dane **NIE SĄ** liczbą.
   - Jeśli wpiszemy `"Jan"`, `isNaN("Jan")` zwróci `true` (to tekst).
   - Jeśli wpiszemy `"123"`, `isNaN("123")` zwróci `false` (dane można zmienić w liczbę).
   - Dlatego użycie zaprzeczenia `!isNaN(imie)` pozwala wyłapać sytuację, gdy użytkownik wpisał same cyfry zamiast liter.

2. **Wycinanie znaków od końca (Ujemny parametr w `.slice()`):**
   - Metoda `.slice(-3)` odlicza 3 znaki od końca ciągu tekstowego niezależnie od jego długości.
   - **Przykład:** Dla słowa `"Sebastian"`, `slice(-3)` wycina `"ian"`. Dla słowa `"Jan"`, wycina `"Jan"`.

3. **Metoda `.indexOf()` a `.search()`:**
   - Zwraca indeks pierwszego wystąpienia podanego znaku lub ciągu.
   - Jeżeli szukany znak nie istnieje w tekście, zwraca **`-1`**.

## 3. Ściąga z najważniejszych metod operacji na stringach (Zestawienie)

```text id="v5x6pr"
+--------------------+-------------------------------------------+-----------------------------------+
| Metoda / Własność  | Opis działania                            | Przykładowy wynik                 |
+--------------------+-------------------------------------------+-----------------------------------+
| .length            | Zwraca długość ciągu znaków               | "ABC".length -> 3                 |
| .toUpperCase()     | Zamienia cały tekst na wielkie litery     | "abc" -> "ABC"                    |
| .toLowerCase()     | Zamienia cały tekst na małe litery        | "ABC" -> "abc"                    |
| .charAt(index)     | Zwraca znak na danej pozycji (od 0)       | "Akapit".charAt(0) -> "A"         |
| .slice(start, end) | Wycina fragment od start do end-1         | "Kraków".slice(0, 3) -> "Kra"     |
| .slice(-N)         | Wycina N ostatnich znaków od końca        | "Kraków".slice(-3) -> "ków"       |
| .indexOf("x")      | Zwraca indeks znaku "x" (lub -1 gdy brak) | "Anna".indexOf("n") -> 1          |
| .search(/regex/)   | Przeszukuje tekst wzorcem, zwraca indeks  | "A1".search(/[0-9]/) -> 1         |
| .includes("x")     | Zwraca true/false czy tekst zawiera "x"   | "Dom".includes("o") -> true       |
| .replace("a", "b") | Zamienia pierwsze wystąpienie "a" na "b"  | "Kot".replace("K", "P") -> "Pot"  |
+--------------------+-------------------------------------------+--------------------------
```
