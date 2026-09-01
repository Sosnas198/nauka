Jasne — **bez zmieniania treści ani kodu**, tylko estetyczne formatowanie Markdown.

# Gotowy i poprawny kod (HTML + JavaScript)

> **Uwaga:** W kodzie źródłowym z pliku znajdowała się literówka `maks="255"` – poprawny atrybut HTML to `max="255"`. Poprawiono również łączenie zmiennych w zapisie `rgb(...)`.

## HTML

```html
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <title>Zmiana koloru RGB</title>
  </head>
  <body>
    <!-- 1. Trzy pola numeryczne dla składowych RGB (0-255) -->
    <input type="number" id="r" min="0" max="255" placeholder="255" />
    <input type="number" id="g" min="0" max="255" placeholder="255" />
    <input type="number" id="b" min="0" max="255" placeholder="255" />

    <!-- 2. Pole wyboru (checkbox) z etykietą -->
    Tło koloru strony <input type="checkbox" id="kolor" /> <br />

    <!-- 3. Przycisk wyzwalający funkcję -->
    <button onclick="zmien()">Zmień kolor</button>

    <!-- 4. Blok z imieniem i nazwiskiem -->
    <div id="wynik">Jan Kowalski</div>

    <script>
      // 5. Funkcja zmieniająca kolor tła
      function zmien() {
        // Pobranie wartości z poszczególnych pól numerycznych
        let r = document.querySelector("#r").value;
        let g = document.querySelector("#g").value;
        let b = document.querySelector("#b").value;

        // Sprawdzenie stanu pola wyboru (true jeśli zaznaczone, false jeśli nie)
        let kolor = document.querySelector("#kolor").checked;

        // Pobranie uchwytu do bloku z wynikiem
        let wynik = document.querySelector("#wynik");

        // Instrukcja warunkowa: zmiana tła całej strony lub tylko bloku
        if (kolor) {
          // Jeśli checkbox jest zaznaczony (true) -> zmieniamy tło całej strony
          document.body.style.backgroundColor =
            "rgb(" + r + ", " + g + ", " + b + ")";
        } else {
          // Jeśli checkbox NIE jest zaznaczony (false) -> zmieniamy tło tylko bloku div
          wynik.style.backgroundColor = "rgb(" + r + ", " + g + ", " + b + ")";
        }
      }
    </script>
  </body>
</html>
```

---

# Tłumaczenie elementów z Twojego pliku

## 1. Formularz HTML

- **`<input type="number" min="0" max="255">`**: Pole do wprowadzania liczb ograniczone zakresem od 0 do 255.
  - `id="r"`, `id="g"`, `id="b"`: Odpowiadają odpowiednio składowym: **R**ed (czerwony), **G**reen (zielony), **B**lue (niebieski).
  - `placeholder="255"`: Szary tekst podpowiedzi wewnątrz pola.

- **`<input type="checkbox" id="kolor">`**: Pole wyboru. Decyduje o tym, czy zmiana dotyczy całej strony, czy tylko konkretnego bloku.

- **`<button onclick="zmien()">`**: Przycisk, którego kliknięcie uruchamia funkcję JavaScript o nazwie `zmien()`.

---

## 2. Czym jest zapis RGB w JavaScript? (Wtyczka wiedzy z pliku)

- **RGB** to model koloru oparty na łączeniu trzech barw podstawowych: czerwonej, zielonej i niebieskiej w zakresach od **0 do 255**.
  - `rgb(255, 0, 0)` – czysty czerwony
  - `rgb(0, 255, 0)` – czysty zielony
  - `rgb(0, 0, 255)` – czysty niebieski
  - `rgb(0, 0, 0)` – czarny
  - `rgb(255, 255, 255)` – biały

- W JavaScript format ten zapisujemy łącząc ciągi znaków (konkatenacja):

```javascript
"rgb(" + r + ", " + g + ", " + b + ")";
```

---

## 3. Wyjaśnienie właściwości `.checked` (z pliku)

- **`.checked`** zwraca wartość typu logicznego (`Boolean`): **`true`** lub **`false`**.
  - Jeśli checkbox jest **zaznaczony** → zwraca `true`.
  - Jeśli **odznaczony** → zwraca `false`.

### Dlaczego piszemy `if (kolor)` zamiast `if (kolor == true)`?

Ponieważ właściwość `.checked` sama w sobie zwraca wartość logiczną `true`/`false`. Instrukcja `if` automatycznie sprawdza, czy przekazany warunek jest prawdziwy, więc dopisywanie `== true` jest zbędną powtórką.

---

## 4. Działanie instrukcji warunkowej `if / else`

- **`document.body.style.backgroundColor`**: Odnosi się do koloru tła całej strony (`<body>`).
- **`wynik.style.backgroundColor`**: Odnosi się do koloru tła samego elementu `<div id="wynik">`.
