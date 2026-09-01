# 🛠️ Zadanie 2: Współrzędne geometryczne, DOM i zdarzenia myszy (Przewodnik dla amatora)

## 📌 Treść zadania

Zadanie wymaga przygotowania stylów CSS oraz skryptu JavaScript, który tworzy wielki kontener (blok) z paskami przewijania, umieszcza w nim przycisk o konkretnych współrzędnych, a po kliknięciu przycisku sprawdza współrzędne kursora myszy, zmienia kolor tła bloku w zależności od ich parzystości i wyświetla powiadomienie.

## 🚀 Kompletny kod programu (Gotowiec)

Oto jak wygląda kompletny, działający plik HTML zawierający stylizację CSS oraz logikę JavaScript opisaną w zadaniu:

### HTML

```html
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <title>Zadanie 2 - Współrzędne i zdarzenia</title>
    <style>
      /* CSS wymagany przez treść zadania */
      .blok {
        width: 150vw; /* Wykracza poza ekran w poziomie */
        height: 150vh; /* Wykracza poza ekran w pionie */
        overflow: auto; /* Włącza paski przewijania */
        background-color: rebeccapurple;
        position: relative; /* Pozwala pozycjonować przycisk względem bloku */
      }
      .przycisk {
        position: absolute; /* Przypina przycisk w konkretnym miejscu geometrycznym */
        top: 200px;
        left: 300px;
        border: none; /* Wyłączenie obramowania */
        padding: 10px;
        cursor: pointer;
      }
    </style>
  </head>
  <body>
    <script>
      // KROK 1: Dynamiczne tworzenie bloku i przycisku w DOM
      const blok = document.createElement("div");
      blok.className = "blok";
      document.body.appendChild(blok);

      const przycisk = document.createElement("button");
      przycisk.className = "przycisk";
      przycisk.textContent = "Wyświetl moją pozycję";
      blok.appendChild(przycisk); // Przycisk ląduje wewnątrz bloku

      // KROK 2: Funkcja obsługująca kliknięcie i pobierająca pozycję kursora
      function sprawdzPolozenie(event) {
        // a) Stałe współrzędne lewego górnego rogu przycisku wynikające z CSS
        let lewyRogX = 300;
        let gornyRogY = 200;

        // b) Dynamiczne współrzędne kliknięcia kursora myszy
        let kursorX = event.clientX;
        let kursorY = event.clientY;

        // Logika parzystości za pomocą operatora modulo (% 2)
        let czyXParzyste = kursorX % 2 === 0;
        let czyYParzyste = kursorY % 2 === 0;
        let tekstInformacyjny = "";

        // Sprawdzanie warunków kolorów tła bloku
        if (czyXParzyste && czyYParzyste) {
          blok.style.backgroundColor = "red";
          tekstInformacyjny = "Obie współrzędne kliknięcia są PARZYSTE.";
        } else if (!czyXParzyste && !czyYParzyste) {
          blok.style.backgroundColor = "green";
          tekstInformacyjny = "Obie współrzędne kliknięcia są NIEPARZYSTE.";
        } else {
          blok.style.backgroundColor = "blue";
          tekstInformacyjny =
            "Jedna współrzędna kliknięcia jest parzysta, a druga nieparzysta.";
        }

        // Wyświetlenie okna informacyjnego z pełnymi danymi
        alert(
          "Lewy górny róg przycisku -> X: " +
            lewyRogX +
            "px, Y: " +
            gornyRogY +
            "px\n" +
            "Pozycja kursora myszy -> X: " +
            kursorX +
            ", Y: " +
            kursorY +
            "\n\n" +
            tekstInformacyjny,
        );
      }

      // KROK 3: Podpięcie czujnika kliknięcia bezpośrednio do przycisku
      przycisk.addEventListener("click", sprawdzPolozenie);
    </script>
  </body>
</html>
```

## 🔍 Tłumaczenie dla amatora krok po kroku

### Część 1: Stylizacja CSS (Fundament wizualny)

#### Klasa `.blok` (Wielki kontener)

- `width: 150vw;` oraz `height: 150vh;` – jednostki `vw` (Viewport Width) i `vh` (Viewport Height) odnoszą się do rozmiaru okna przeglądarki. Wartość `150` sprawia, że blok jest o połowę większy niż ekran użytkownika w pionie i w poziomie, co idealnie spełnia warunek wykraczania poza okno.
- `overflow: auto;` – ponieważ blok jest ogromny i nie mieści się na ekranie, ta linijka nakazuje przeglądarce automatycznie dorobić paski przewijania (scrolle) – zarówno pionowy, jak i poziomy.

#### Klasa `.przycisk` (Element pozycjonowany)

- `position: absolute;` – najważniejsza właściwość, która odrywa przycisk z normalnego układu strony i pozwala ustawić go w konkretnym miejscu geometrycznym, jak pinezkę na mapie.
- `top: 200px;` oraz `left: 300px;` – definiują dokładne położenie przycisku, odsuwając jego lewy górny róg o odpowiednią liczbę pikseli od krawędzi bloku-rodzica.
- `border: none;` – usuwa domyślną, brzydką ramkę przycisku narzucaną przez przeglądarkę.

### Część 2: JavaScript – Tworzenie świata w DOM

### JavaScript

```JavaScript
let blok = document.createElement('div');
blok.className = 'blok';
document.body.appendChild(blok);

let przycisk = document.createElement('button');
przycisk.className = 'przycisk';
przycisk.textContent = 'Wyświetl moją pozycję';
blok.appendChild(przycisk);
```

- `document.createElement` – tworzymy w pamięci czysty element `div` oraz `button`.
- `className` – przypisujemy im klasy, dzięki czemu automatycznie „ubierają się” w style CSS omówione wcześniej.
- `appendChild` – blok wrzucamy bezpośrednio do `document.body` (staje się widoczny na ekranie), a przycisk wrzucamy do środka bloku (`blok.appendChild(przycisk)`), dzięki czemu staje się on „dzieckiem” fioletowego kontenera.

### Część 3: Podpinanie czujnika i „magiczny argument” (Event)

### JavaScript

```JavaScript
przycisk.addEventListener('click', sprawdzPolozenie);
```

- **Złota zasada czujników (`addEventListener`):** Żeby założyć czujnik na jakikolwiek element, musisz najpierw wskazać komputerowi konkretny obiekt. Wyobraź sobie, że `addEventListener` to obroża z lokalizatorem GPS – nie możesz założyć obroży na „powietrze”, musisz założyć ją na konkretnego psa (w kodzie tym psem jest Twój przycisk).
- **Dlaczego używamy argumentu `event` w funkcji?** W przeciwieństwie do prostych zadań (gdzie obchodził nas tylko fakt, że użytkownik _w ogóle_ kliknął), tutaj musimy podjąć decyzję na podstawie geometrycznego punktu $X$ i $Y$ kliknięcia. Przeglądarka pakuje te dane w gigantyczną paczkę informacji i wstrzykuje ją do nawiasu funkcji (często nazywaną `event`, `e` lub po prostu `a`).
- `event.clientX` i `event.clientY` – to współrzędne pozioma ($X$) i pionowa ($Y$) kursora w ułamku sekundy, w którym docisnąłeś myszkę.

### Część 4: Logika kolorów i parzystości (Instrukcja warunkowa)

Zadanie każe sprawdzić parzystość współrzędnych kliknięcia myszy przy użyciu operatora modulo `% 2 === 0` (reszta z dzielzenia przez 2 wynosi zero, czyli liczba jest parzysta).

### JavaScript

```JavaScript
if (kursorX % 2 === 0 && kursorY % 2 === 0) {
    blok.style.backgroundColor = 'red';
}
else if (kursorX % 2 !== 0 && kursorY % 2 !== 0) {
    blok.style.backgroundColor = 'green';
}
else {
    blok.style.backgroundColor = 'blue';
}
```

- **Warunek 1 (`if`):** Jeśli współrzędna $X$ jest parzysta **oraz** ($&&$) współrzędna $Y$ jest parzysta ➡️ przemaluj tło bloku na **czerwony**.
- **Warunek 2 (`else if`):** Jeśli współrzędna $X$ jest nieparzysta **oraz** ($&&$) współrzędna $Y$ jest nieparzysta ➡️ przemaluj tło bloku na **zielony**.
- **Warunek 3 (`else`):** W każdym pozostałym przypadku (czyli gdy jedna współrzędna jest parzysta, a druga nieparzysta) ➡️ tło zmienia się na **niebieski**.
