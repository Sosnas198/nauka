> **Krok 2 z 2** | [W Kroku 1](../01_zmiana_obrazow_dom/README.md) ustawiasz `src` dużego obrazu. Teraz **Skrypt 2**: odczyt pól `a` i `b`, rozpoznanie figury po pliku `2d.bmp` i zapis wyniku w `#wynik`.

---

# Kompletny przewodnik: Skrypt 2 — `Number()`, `includes("2d.bmp")` i wzory pól

Ta ściąga wytłumaczy Ci **od A do Z** pobranie liczb z inputów, sprawdzenie **stanu obrazu** (nie osobnej zmiennej) oraz dwa wzory: prostokąt `a * b` i trójkąt `(a * b) / 2`.

---

## SEC-1: Pobranie danych z pól edycyjnych (`Number`)

HTML:

```html
<input type="number" id="a" min="0">
<input type="number" id="b" min="0">
<button type="button" onclick="obliczPole()">Oblicz</button>
```

**`.value`** z inputa to **tekst** (nawet przy `type="number"`). Mnożenie bywa niepewne, dopóki nie zamienisz na liczbę.

```javascript
var bokA = Number(document.getElementById("a").value);
var bokB = Number(document.getElementById("b").value);
```

**`Number("4")`** → `4`. Puste pole → `0`.

Znaczące nazwy: `bokA` / `bokB` (w arkuszu: bok prostokąta / podstawa trójkąta oraz drugi bok / wysokość).

Odczyt aktualnego pliku dużego obrazu:

```javascript
var srcObrazu = document.getElementById("duzyObraz").src;
```

Uwaga: w przeglądarce `.src` bywa **pełnym adresem** (`http://localhost/.../2d.bmp`), nie samym `"2d.bmp"`. Dlatego **nie** porównujesz `src === "2d.bmp"`, tylko sprawdzasz, czy łańcuch **zawiera** nazwę pliku.

---

## SEC-2: Warunek — prostokąt tylko gdy `includes("2d.bmp")`

Arkusz:

- duży obraz to **`2d.bmp`** → pole **prostokąta** (`a * b`);
- duży obraz to **`1d.bmp`** → pole **trójkąta** (`(a * b) / 2`);
- **stan początkowy** (Skrypt 1 ani razu) → też **trójkąt**.

Najprostsza logika: *czy to prostokąt?* Jeśli nie — trójkąt (obejmuje `1d.bmp` i start strony).

```javascript
if (srcObrazu.includes("2d.bmp")) {
    wynik = bokA * bokB;
} else {
    wynik = (bokA * bokB) / 2;
}
```

**`.includes("2d.bmp")`** zwraca `true`, gdy w pełnym `src` jest ten fragment.

Nie polegaj na osobnej zmiennej `figura = "trojkat"` ustawianej tylko w Skrypcie 1 — przy starcie mogłaby być niezgodna z HTML. **Źródło prawdy to aktualny `src` obrazu.**

---

## SEC-3: Wypisanie wyniku w paragrafie `#wynik`

```html
<p id="wynik"></p>
```

```javascript
document.getElementById("wynik").textContent = wynik;
```

**`textContent`** wstawia samą liczbę (bez HTML). Paragraf jest **pod przyciskiem**, zgodnie z arkuszem.

Można też `innerHTML` albo `innerText` — na egzaminie wystarczy wpisanie wartości do tego `p`.

---

# Podsumowanie przepływu danych

```text
onclick="obliczPole()"
        ↓
bokA = Number(#a.value)
bokB = Number(#b.value)
src  = #duzyObraz.src
        ↓
src zawiera "2d.bmp"?
  TAK → a * b          (prostokąt)
  NIE → (a * b) / 2    (trójkąt, także stan początkowy)
        ↓
#wynik.textContent = wynik
```

---

# Ściągawka

| **Pojęcie**                 | **Co robi?**                                           |
| --------------------------- | ------------------------------------------------------ |
| **`Number(...)`**           | Zamienia `.value` na liczbę.                           |
| **`.src`**                  | Aktualny plik dużego obrazu (często pełny URL).        |
| **`.includes("2d.bmp")`**   | Czy wybrano prostokąt.                                 |
| **`a * b`**                 | Pole prostokąta.                                       |
| **`(a * b) / 2`**           | Pole trójkąta (podstawa × wysokość / 2).               |
| **`#wynik`**                | Paragraf na wynik pod przyciskiem.                     |

---

### Gratulacje!

Masz pełny cykl: klik miniatury zmienia figurę, „Oblicz” czyta boki i `src`, wynik ląduje w `#wynik`.

🏠 **[Wróć do głównego spisu treści](../README.md)**
