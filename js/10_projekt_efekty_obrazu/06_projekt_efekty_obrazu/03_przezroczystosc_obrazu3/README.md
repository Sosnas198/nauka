# Kompletny przewodnik: Regulacja przezroczystości obrazka suwakiem (range) i szablony literałów

Ten przewodnik tłumaczy **od A do Z**, jak funkcja `przezroczystosc()` odczytuje wartość ustawioną suwakiem i na jej podstawie dynamicznie zmienia przezroczystość obrazka.

---

## 🎯 Cel skryptu

Po przesunięciu suwaka (`<input type="range">`) i kliknięciu przycisku "Zastosuj" w trzecim bloku strony, nałożyć na obrazek filtr przezroczystości o wartości procentowej dokładnie takiej, jaką wskazuje suwak.

---

## SEC-1: Pobranie obrazka za pomocą selektora CSS (`querySelector`)

```javascript
const img = document.querySelector('#blok3 img');
```

### Jak to działa?

- **`document.querySelector('#blok3 img')`** — w odróżnieniu od poprzednich submodułów, gdzie obrazek pobierano po jego własnym `id` (np. `getElementById('owoce')`), tutaj obrazek w bloku 3 **nie ma własnego identyfikatora** w kodzie HTML (`<img src="owoce.jpg" alt="Kosz pełen owoców">` — bez atrybutu `id`).
- Dlatego używamy **`querySelector()`** z selektorem CSS **`'#blok3 img'`**, co oznacza: *"znajdź znacznik `<img>`, który znajduje się gdziekolwiek wewnątrz elementu o identyfikatorze `blok3`"*. Spacja między `#blok3` a `img` w selektorze oznacza właśnie relację "wewnątrz", "potomek".
- Dzięki temu skrypt trafia dokładnie na obrazek z trzeciego bloku, mimo że ten obrazek nie ma swojego własnego `id`.

---

## SEC-2: Odczytanie aktualnej wartości suwaka

```javascript
const przezroczystoscValue = document.getElementById('przezroczystosc').value;
```

### Jak to działa?

- **`document.getElementById('przezroczystosc')`** — pobiera element suwaka (`<input type="range" ... id="przezroczystosc">`).
- **`.value`** — właściwość `.value` dla suwaka typu `range` zwraca **aktualnie ustawioną przez użytkownika wartość** (jako tekst), mieszczącą się w przedziale zdefiniowanym atrybutami `min="0"` i `max="100"` z kodu HTML.
- Wynik zapisujemy w zmiennej `przezroczystoscValue` — nazwa tej zmiennej jest **znacząca** (czyli jasno mówi, co przechowuje), zgodnie z wymaganiem zadania dotyczącym nazewnictwa.

---

## SEC-3: Zastosowanie filtra przezroczystości z użyciem szablonu literału (template literal)

```javascript
img.style.filter = `opacity(${przezroczystoscValue}%)`;
```

### Jak to działa?

- To zapis z użyciem **szablonu literału** (*template literal*) — specjalnego rodzaju tekstu w JavaScript, otoczonego **znakami odwrotnego apostrofu** (`` ` ``, tzw. *backtick*), a nie zwykłym cudzysłowem.
- **`${przezroczystoscValue}`** — wewnątrz takiego szablonu można umieścić dowolne wyrażenie JavaScript w nawiasach klamrowych poprzedzonych znakiem dolara, a jego wartość zostanie automatycznie wstawiona do tekstu. Tutaj wstawiana jest aktualna wartość suwaka.
- Efekt: jeśli suwak ustawiono np. na `40`, cały tekst przyjmie postać `'opacity(40%)'`.
- **`opacity(N%)`** — to funkcja filtra CSS zmieniająca przezroczystość elementu. `opacity(100%)` oznacza pełną nieprzezroczystość (obrazek widoczny normalnie), a np. `opacity(20%)` oznacza, że obrazek stanie się w dużej mierze przezroczysty (niemal niewidoczny, przebija przez niego tło strony).
- Ustawiając `img.style.filter` na tak zbudowany tekst, natychmiast zmieniamy przezroczystość obrazka zgodnie z pozycją suwaka.

---

## 💡 Dlaczego szablon literału (`` ` ``), a nie zwykłe łączenie kropką (`+`)?

W poprzednich submodułach (np. w PHP-owych projektach z tego kursu) łączenie tekstu odbywało się przez kropkę (`.`). W JavaScript odpowiednikiem byłoby użycie `+`, np.:

```javascript
img.style.filter = 'opacity(' + przezroczystoscValue + '%)';
```

Zapis z szablonem literału (`` `opacity(${przezroczystoscValue}%)` ``) jest **czytelniejszy** — od razu widać "kształt" końcowego tekstu, bez rozbijania go na kawałki oddzielone znakami `+`. To nowocześniejsza, zalecana praktyka w JavaScript (dostępna od standardu ES6).

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Właściwość**       | **Co oznacza / Co robi?**                                                                     |
| --------------------------------- | -------------------------------------------------------------------------------------------------|
| `querySelector('#id element')`     | Wyszukuje pierwszy element danego typu (np. `img`) znajdujący się wewnątrz elementu o podanym `id`. |
| `.value` (dla `<input type="range">`) | Zwraca aktualnie ustawioną przez użytkownika wartość suwaka.                                    |
| Szablon literału (`` `tekst ${zmienna}` ``) | Sposób budowania tekstu w JavaScript, pozwalający wstawiać wartości zmiennych wprost w środku tekstu. |
| `opacity(N%)`                       | Filtr CSS zmieniający przezroczystość elementu — `100%` to pełna widoczność, `0%` to całkowita przezroczystość. |
