# Kompletny przewodnik: Włączanie i zdejmowanie filtra odcieni szarości dwoma przyciskami

Ten przewodnik tłumaczy **od A do Z**, jak dwie osobne funkcje — `kolorowy()` i `czarnobialy()` — obsługują dwa przyciski, które w prosty sposób przełączają obrazek między jego naturalnymi kolorami a wersją czarno-białą.

---

## 🎯 Cel skryptu

Dać użytkownikowi dwa przyciski: "Kolorowy" (zdejmujący wszelkie filtry z obrazka) oraz "Czarno-Biały" (nakładający na obrazek pełny filtr odcieni szarości).

---

## SEC-1: Funkcja `kolorowy()` — zdjęcie filtra

```javascript
function kolorowy() {
    const img = document.getElementById('owoce');
    img.style.filter = 'none';
}
```

### Jak to działa?

- **`document.getElementById('owoce')`** — pobiera obrazek o identyfikatorze `owoce` (obrazek drzewa pomarańczy w drugim bloku strony).
- **`img.style.filter = 'none';`** — ustawia właściwość CSS `filter` na wartość **`'none'`**, czyli dosłownie "brak filtra". Niezależnie od tego, jaki filtr był wcześniej nałożony na ten obrazek (np. jeśli chwilę wcześniej kliknięto "Czarno-Biały"), ta linijka **całkowicie go usuwa**, przywracając obrazkowi jego oryginalne, pełne kolory.
- Ta funkcja wywoływana jest po kliknięciu przycisku `<button onclick="kolorowy()">Kolorowy</button>`.

---

## SEC-2: Funkcja `czarnobialy()` — nałożenie filtra odcieni szarości

```javascript
function czarnobialy() {
    const img = document.getElementById('owoce');
    img.style.filter = 'grayscale(100%)';
}
```

### Jak to działa?

- **`document.getElementById('owoce')`** — pobieramy ten sam obrazek, co w funkcji `kolorowy()`.
- **`img.style.filter = 'grayscale(100%)';`** — ustawia filtr CSS **`grayscale()`**, który usuwa nasycenie kolorów z obrazka (zamienia je na odcienie szarości). Wartość **`100%`** oznacza **pełne** odbarwienie — obrazek staje się w całości czarno-biały, bez śladu koloru. Gdyby podać np. `50%`, obrazek byłby tylko częściowo odbarwiony.
- Ta funkcja wywoływana jest po kliknięciu przycisku `<button onclick="czarnobialy()">Czarno-Biały</button>`.

---

## 💡 Dlaczego te dwie funkcje są takie proste (bez żadnych warunków `if`)?

W odróżnieniu od submodułu 1 (gdzie trzeba było sprawdzać, które pola są zaznaczone, i budować złożony tekst filtra), tutaj mamy do czynienia z **dwoma prostymi, niezależnymi przełącznikami**:

- Kliknięcie "Kolorowy" **zawsze** robi dokładnie jedną rzecz: usuwa filtr.
- Kliknięcie "Czarno-Biały" **zawsze** robi dokładnie jedną rzecz: nakłada pełny filtr `grayscale(100%)`.

Nie ma tu żadnej "decyzji" do podjęcia wewnątrz funkcji (żadnego sprawdzania stanu pól, jak w submodule 1) — każda funkcja po prostu ustawia jedną, stałą wartość stylu. To najprostszy możliwy wzorzec obsługi przycisku w JavaScripcie: **kliknięcie → wywołanie funkcji → ustawienie jednej właściwości stylu**.

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Właściwość**  | **Co oznacza / Co robi?**                                                                |
| --------------------------- | ---------------------------------------------------------------------------------------- |
| `style.filter = 'none'`      | Usuwa wszystkie filtry CSS nałożone na element, przywracając jego oryginalny wygląd.       |
| `grayscale(N%)`              | Filtr CSS odbarwiający element — `100%` oznacza pełne odbarwienie (czarno-biały).          |
| `onclick="nazwaFunkcji()"`   | Atrybut HTML wywołujący podaną funkcję JavaScript po kliknięciu elementu (np. przycisku).  |
