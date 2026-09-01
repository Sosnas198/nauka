Jasne — **treść i kod pozostawione bez zmian**, tylko uporządkowane i estetycznie sformatowane w Markdown.

# Gotowy i poprawny kod (HTML + JavaScript)

**HTML**

```html
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <title>Dynamiczna zmiana rozmiaru czcionki</title>
  </head>
  <body>
    <!-- 1. Suwak (input type="range") z określonymi wartościami i zdarzeniem -->
    <input
      type="range"
      id="wielkosc"
      min="100"
      max="200"
      value="100"
      oninput="zmien()"
    />

    <!-- 2. Element z tekstem (Imię i nazwisko), którego rozmiar będziemy modyfikować -->
    <div id="wynik">Jan Kowalski</div>

    <script>
      // 3. Funkcja wywoływana przy każdej zmianie wartości suwaka
      function zmien() {
        // Pobranie aktualnej wartości suwaka z pola #wielkosc
        let wielkosc = document.querySelector("#wielkosc").value;

        // Pobranie uchwytu do elementu HTML z napisem #wynik
        let wynik = document.querySelector("#wynik");

        // Przypisanie nowej wielkości czcionki w pikselach (np. "120px")
        wynik.style.fontSize = wielkosc + "px";
      }
    </script>
  </body>
</html>
```

---

# Dokładne tłumaczenie elementów z Twojego pliku

## 1. Struktura HTML

- **`<input type="range">`**: Tworzy suwak.
  - **`id="wielkosc"`**: Identyfikator suwaka pozwalający łatwo znaleźć go w skrypcie JS.
  - **`min="100"`**: Ustawia minimalną wartość suwaka na 100.
  - **`max="200"`**: Ustawia maksymalną wartość suwaka na 200.
  - **`value="100"`**: Ustala domyślną/początkową wartość suwaka na 100px.
  - **`oninput="zmien()"`**: Przypisuje zdarzenie (zdarzenie dzieje się na żywo podczas przeciągania suwaka) i wywołuje naszą funkcję `zmien()`.

- **`<div id="wynik">Jan Kowalski</div>`**: Element tekstowy z imieniem i nazwiskiem, który poddajemy modyfikacji.

---

## 2. Logika skryptu JavaScript

- **`function zmien() { ... }`**: Tworzy blok kodu (funkcję), który wykonuje się za każdym razem, gdy poruszymy suwakiem.

- **`let wielkosc = document.querySelector('#wielkosc').value;`**:
  - `document.querySelector('#wielkosc')` odnajduje suwak na stronie po jego `id`.
  - `.value` pobiera aktualnie ustawioną liczbę na suwaku (np. 140).

- **`let wynik = document.querySelector('#wynik');`**: Odnajduje element tekstowy o id `#wynik`.

- **`wynik.style.fontSize = wielkosc + 'px';`**:
  - `.style.fontSize` modyfikuje styl CSS odpowiedzialny za wielkość czcionki.
  - `wielkosc + 'px'` łączy pobraną wartość liczbową z jednostką `px` (np. dając `"140px"`), co jest wymagane przez CSS do poprawnej zmiany rozmiaru.

---

## 3. Różnica między `oninput` a `onchange` (z Twojej notatki w pliku)

### `oninput` (użyty w tym zadaniu)

- Wywołuje się **natychmiast / na żywo** przy każdym ruchu suwaka lub wpisaniu znaku.
- _Zastosowanie:_ Podgląd zmian w czasie rzeczywistym.

### `onchange`

- Wywołuje się **dopiero po zakończeniu akcji** – gdy użytkownik puści suwak lub opuści pole tekstowe (straci fokus).
- _Zastosowanie:_ Odczytywanie gotowych wartości lub walidacja formularzy po zakończeniu pisania.
