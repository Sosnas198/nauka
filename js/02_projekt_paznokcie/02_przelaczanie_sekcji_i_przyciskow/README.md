> **Krok 2 z 2** | [W Kroku 1](../01_generowanie_obrazow/README.md) wygenerowaliśmy galerię wzorów. Teraz **Skrypt 2**: po **najechaniu** na przycisk pokazujemy jedną sekcję i podświetlamy właściwy przycisk.

---

# Kompletny przewodnik: Skrypt 2 — `mouseover`, `display` oraz kolory Salmon / Crimson

Ta ściąga wytłumaczy Ci **od A do Z** zdarzenie najechania kursorem, ukrywanie bloków przez `display` oraz zmianę tła przycisków nawigacji.

---

## SEC-1: Zdarzenie najechania — `onmouseover` / `mouseover` (nie kliknięcie)

Arkusz: skrypt wykonuje się **po stronie klienta**, **po najechaniu kursorem na przycisk**.

To **nie** jest `onclick`. Użytkownik nie musi klikać.

W HTML (wariant egzaminacyjny, atrybut zdarzenia):

```html
<button onmouseover="kolor()">Kolor</button>
<button onmouseover="ksztalt()">Kształt</button>
<button onmouseover="wzor()">Wzór</button>
```

| Zapis                 | Znaczenie                                              |
| --------------------- | ------------------------------------------------------ |
| **`onmouseover`**     | Atrybut HTML — „gdy kursor wjedzie na element”.        |
| **`mouseover`**       | Nazwa tego samego zdarzenia w modelu DOM.              |
| **`kolor()`**         | Wywołanie funkcji JS w momencie zdarzenia.             |

Równoważny, nowocześniejszy zapis (bez atrybutu w HTML):

```javascript
przycisk.addEventListener("mouseover", kolor);
```

Na egzaminie INF.03 / EE.09 najczęściej zostawia się **`onmouseover="nazwaFunkcji()"`** na przycisku, tak jak w kontrolce.

---

## SEC-2: Trzy bloki sekcji i `style.display`

W HTML są trzy kontenery:

- `#sekcja1` — Kolor
- `#sekcja2` — Kształt
- `#sekcja3` — Wzór

Arkusz: **aktywny** blok ma być wyświetlany **w postaci blokowej**, pozostałe **usunięte** (ukryte).

W CSS/JS „postać blokowa” to `display = "block"`. Ukrycie to `display = "none"` (element nie zajmuje miejsca, jakby go nie było w układzie).

```javascript
document.getElementById("sekcja1").style.display = "block";
document.getElementById("sekcja2").style.display = "none";
document.getElementById("sekcja3").style.display = "none";
```

| Przycisk     | Widoczna sekcja | Ukryte          |
| ------------ | --------------- | --------------- |
| **Kolor**    | `#sekcja1`      | 2 i 3           |
| **Kształt**  | `#sekcja2`      | 1 i 3           |
| **Wzór**     | `#sekcja3`      | 1 i 2           |

`getElementById` pobiera jeden element po `id`. Potem `.style.display` zmienia styl **inline** (nadpisuje CSS z arkusza na czas działania skryptu).

---

## SEC-3: Przyciski w `nav` oraz `querySelectorAll`

Kolory tła dotyczą **przycisków**, nie sekcji.

```javascript
const przyciski = document.querySelectorAll("nav button");
```

- **`querySelectorAll("nav button")`** — wszystkie `<button>` wewnątrz `<nav>`.
- Wynik to **lista** (NodeList) w kolejności z HTML: `[0]` Kolor, `[1]` Kształt, `[2]` Wzór.

Indeksy w programowaniu liczymy od **zera**.

---

## SEC-4: Salmon (aktywny) i Crimson (pozostałe)

Arkusz podaje **nazwy kolorów CSS**:

- aktywny przycisk → **`Salmon`**
- pozostałe → **`Crimson`**

```javascript
przyciski[0].style.backgroundColor = "Salmon";
przyciski[1].style.backgroundColor = "Crimson";
przyciski[2].style.backgroundColor = "Crimson";
```

| Przycisk     | Tło pierwszego | Tło drugiego | Tło trzeciego |
| ------------ | -------------- | ------------ | ------------- |
| **Kolor**    | Salmon         | Crimson      | Crimson       |
| **Kształt**  | Crimson        | Salmon       | Crimson       |
| **Wzór**     | Crimson        | Crimson      | Salmon        |

Właściwość JS to **`backgroundColor`** (camelCase), nie `background-color`.

---

## SEC-5: Trzy funkcje: `kolor`, `ksztalt`, `wzor`

Każda funkcja robi **ten sam schemat**, tylko inny indeks jest „aktywny”:

1. Ustaw `display` trzech sekcji.
2. Ustaw `backgroundColor` trzech przycisków.

```javascript
function kolor() {
    document.getElementById("sekcja1").style.display = "block";
    document.getElementById("sekcja2").style.display = "none";
    document.getElementById("sekcja3").style.display = "none";

    const przyciski = document.querySelectorAll("nav button");
    przyciski[0].style.backgroundColor = "Salmon";
    przyciski[1].style.backgroundColor = "Crimson";
    przyciski[2].style.backgroundColor = "Crimson";
}
```

Funkcje `ksztalt()` i `wzor()` różnią się tylko tym, która sekcja ma `block` i który przycisk ma `Salmon`.

Da się to skrócić jedną funkcją z numerem aktywnego bloku — na egzaminie **trzy osobne funkcje** (jak w kontrolce) są w pełni poprawne i czytelne dla sprawdzającego.

---

# Podsumowanie przepływu danych

```text
Kursor wjeżdża na <button onmouseover="…">
                 ↓
Wywołanie kolor() / ksztalt() / wzor()
                 ↓
Jedna sekcja: display = "block"
Pozostałe:     display = "none"
                 ↓
querySelectorAll("nav button")
                 ↓
Aktywny:  backgroundColor = "Salmon"
Pozostałe: backgroundColor = "Crimson"
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / metoda**              | **Co robi?**                                           |
| --------------------------------- | ------------------------------------------------------ |
| **`onmouseover`**                 | Atrybut HTML — start skryptu po najechaniu.            |
| **`mouseover`**                   | Nazwa zdarzenia DOM (to samo co najechanie).           |
| **`getElementById("sekcja1")`**   | Pobranie konkretnego bloku.                            |
| **`style.display = "block"`**     | Pokazanie sekcji jako bloku.                           |
| **`style.display = "none"`**      | Ukrycie sekcji (arkusz: „usunięte”).                   |
| **`querySelectorAll("nav button")`** | Lista trzech przycisków w kolejności HTML.          |
| **`backgroundColor`**             | Tło przycisku z poziomu JS.                            |
| **`Salmon` / `Crimson`**          | Kolory z arkusza (aktywny / nieaktywny).               |

---

### Gratulacje!

Masz pełny cykl: pętla buduje wzory, a najechanie na przycisk przełącza widok i kolory nawigacji.

🏠 **[Wróć do głównego spisu treści](../README.md)**
