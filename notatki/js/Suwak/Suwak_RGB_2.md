Jasne — **niczego nie zmieniam w treści ani w kodzie**. Tylko porządkuję i estetycznie formatuję Markdown.

# Dokładny, pełny kod oparty 1 do 1 na Twoich obrazkach oraz jego szczegółowe tłumaczenie linijka po linijce

## Gotowy i poprawny kod (HTML + JavaScript)

Aby wartości liczbowe przy suwakach pokazały się od razu po załadowaniu strony (tak jak na Twoim podglądzie), wywołujemy funkcję `zmiana_koloru()` dodatkowo w zdarzeniu `onload` w elemencie `<body>`.

## HTML

```html
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <title>Suwaki RGB</title>
  </head>
  <body onload="zmiana_koloru()">
    <!-- 1. Suwak dla koloru czerwonego (R) z wartością w span -->
    <input
      type="range"
      name=""
      id="red"
      value="255"
      min="0"
      max="255"
      oninput="zmiana_koloru()"
    /><span id="span_r"></span> <br />

    <!-- 2. Suwak dla koloru zielonego (G) z wartością w span -->
    <input
      type="range"
      name=""
      id="green"
      value="255"
      min="0"
      max="255"
      oninput="zmiana_koloru()"
    /><span id="span_g"></span> <br />

    <!-- 3. Suwak dla koloru niebieskiego (B) z wartością w span -->
    <input
      type="range"
      name=""
      id="blue"
      value="255"
      min="0"
      max="255"
      oninput="zmiana_koloru()"
    /><span id="span_b"></span> <br />

    <script>
      // Funkcja zmieniająca kolor tła oraz aktualizująca cyfry obok suwaków
      function zmiana_koloru() {
        // Pobranie wartości z poszczególnych suwaków
        let r = document.getElementById("red").value;
        let g = document.getElementById("green").value;
        let b = document.getElementById("blue").value;

        // Wpisanie aktualnych wartości suwaków do elementów <span>
        let span_r = (document.getElementById("span_r").innerHTML = r);
        let span_g = (document.getElementById("span_g").innerHTML = g);
        let span_b = (document.getElementById("span_b").innerHTML = b);

        // Ustawienie koloru tła strony za pomocą template string (backticki ` `)
        document.body.style.backgroundColor = `rgb(${r}, ${g},${b})`;
      }
    </script>
  </body>
</html>
```

---

# Dokładne tłumaczenie kodu (z obrazków)

## 1. Kod HTML (Struktura suwaków i tekstów)

- **`<input type="range" ...>`**: Tworzy suwak.
  - **`id="red"`** **/** **`id="green"`** **/** **`id="blue"`**: Unikalne identyfikatory suwaków dla JavaScriptu.
  - **`value="255"`**: Początkowe ustawienie suwaka (ustawiony maksymalnie w prawo).
  - **`min="0" max="255"`**: Określa zakres wartości – od 0 (brak koloru) do 255 (pełne nasycenie).
  - **`oninput="zmiana_koloru()"`**: Wywołuje funkcję natychmiast, podczas gdy ruch suwaka trwa (na żywo).

- **`<span id="span_r"></span>`**: Pusty kontener tekstowy, do którego skrypt JS na bieżąco wpisuje aktualną wartość liczbową suwaka (efekt niebieskich cyferek `255` widocznych na podglądzie).

- **`<br>`**: Przejście do nowej linii.

---

## 2. Kod JavaScript (Logika działania)

- **`function zmiana_koloru() { ... }`**: Nagłówek funkcji, która odpowiada za cały proces.

- **`let r = document.getElementById('red').value;`**: Pobiera aktualną cyfrę z suwaka czerwonego (np. `255`).

- **`let g = document.getElementById('green').value;`**: Pobiera aktualną cyfrę z suwaka zielonego.

- **`let b = document.getElementById('blue').value;`**: Pobiera aktualną cyfrę z suwaka niebieskiego.

- **`document.getElementById('span_r').innerHTML = r;`**: Wstawia odczytaną wartość `r` do środka znacznika `<span id="span_r">`, wyświetlając liczbę obok suwaka.

- **`document.body.style.backgroundColor = `rgb(${r}, ${g}, ${b})``**:
  - **`document.body.style.backgroundColor`**: Odnosi się bezpośrednio do koloru tła całej strony `<body>`.
  - **`` `rgb(${r}, ${g}, ${b})` ``**: Użycie tzw. **Template Literals** (zapis w odwrotnych apostrofach **`**). Pozwala to wstawiać zmienne JS bezpośrednio w tekst za pomocą składni `${zmienna}`. Jest to bardziej nowoczesny i czytelny odpowiednik zapisu `"rgb(" + r + ", " + g + ", " + b + ")"`.
