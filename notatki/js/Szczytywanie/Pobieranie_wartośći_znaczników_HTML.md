Poniżej masz tę samą treść, tylko uporządkowaną i sformatowaną jako czytelny Markdown — **bez zmieniania treści ani kodu**.

# Oto szczegółowy opis i omówienie działania skryptu zawartego w pliku **Pobieranie wartości znaczników HTML_2.pdf**.

### 1. Ogólny cel i działanie skryptu

Skrypt służy do **interaktywnego zarządzania prostym magazynem produktów** umieszczonym w tabeli HTML. Odpowiada za trzy kluczowe funkcjonalności:

1. **Automatyczną weryfikację i oznaczanie stanów magazynowych** odpowiednimi kolorami tła tuż po załadowaniu strony.
2. **Edycję stanów magazynowych** za pomocą okna dialogowego (`prompt`) i natychmiastowe przeliczenie kolorów tła po zmianie.
3. **Składanie zamówień**, co generuje kolejny numer ID zamówienia i wyświetla komunikat z nazwą wybranego produktu.

---

### 2. Wyjaśnienie kluczowych pojęć z materiału

#### A. Dlaczego `.value` nie działa na komórkach tabeli (`<td>`)?

- Właściwość **`.value`** służy wyłącznie do pobierania i ustawiania wartości w polach formularzy (takich jak `<input>`, `<textarea>`, `<select>`).
- Zwykłe znaczniki HTML – w tym komórki tabeli (`<td>`) – nie posiadają właściwości `.value`.
- Aby odczytać lub zmodyfikować zawartość komórki tabeli w JavaScript, należy stosować właściwości **`.innerHTML`** lub **`.textContent`**.

#### B. Różnica między `id` a `class` w selekcji DOM

- **`id`** – selektor unikalny. Wskazuje tylko jeden konkretny element na stronie (w CSS zapisywany z `#`, w JS pobierany m.in. przez `document.getElementById()`).
- **`class`** – selektor grupowy. Może być nadany wielu elementom jednocześnie (w CSS zapisywany z `.`, w JS pobierany przez `document.querySelectorAll()` lub `getElementsByClassName()`).
- Skrypt wykorzystuje klasy `.ile` oraz `.nazwa`, aby odwołać się do całej kolumny komórek naraz.

---

### 3. Omówienie poszczególnych funkcji skryptu

#### A. Funkcja `braki()` (Oznaczanie stanów magazynowych)

**JavaScript**

```javascript
function braki() {
  var ilosc = document.querySelectorAll(".ile");
  for (let i = 0; i <= 3; i++) {
    if (ilosc[i].innerHTML == 0) {
      ilosc[i].style.backgroundColor = "red";
    } else if (ilosc[i].innerHTML <= 5 && ilosc[i].innerHTML >= 1) {
      ilosc[i].style.backgroundColor = "yellow";
    } else {
      ilosc[i].style.backgroundColor = "green"; // lub "honeydew"
    }
  }
}
```

- **Pobranie elementów:** `querySelectorAll(".ile")` zwraca listę wszystkich komórek zawierających liczby z ilością produktów.
- **Iteracja:** Pętla `for` przechodzi kolejno po indeksach `0, 1, 2, 3` (dla 4 wierszy).
- **Warunki kolorowania:**
  - Wartość równa `0` $\rightarrow$ zmiana tła na **czerwone** (brak towaru).
  - Wartość w przedziale $1$ do $5$ $\rightarrow$ zmiana tła na **żółte** (niski stan).
  - Pozostałe wartości $\rightarrow$ zmiana tła na **zielone / honeydew** (bezpieczny stan).

#### B. Funkcja `aktualziacji(x)` (Zmiana ilości produktu)

**JavaScript**

```javascript
function aktualziacji(x) {
  var ilosc = document.querySelectorAll(".ile");
  ilosc[x].innerHTML = prompt("podaj wartosc");
  braki();
}
```

- **Przekazywanie argumentu** **`x`**: Przycisk w wierszu wywołuje funkcję ze swoim indeksem (np. `onclick="aktualziacji(2)"`).
- **Modyfikacja komórki:** `ilosc[x].innerHTML` odwołuje się dokładnie do tej komórki, która odpowiada klikniętemu przyciskowi i przypisuje do niej wartość wpisaną w oknie `prompt`.
- **Ponowna weryfikacja:** Na końcu wywoływana jest funkcja `braki()`, aby od razu zaktualizować kolor tła komórki na podstawie nowej wartości.

#### C. Funkcja `zamowienia(x)` i zasięg zmiennej `id_zam`

**JavaScript**

```javascript
var id_zam = 0; // Zmienna globalna

function zamowienia(x) {
  id_zam = id_zam + 1;
  var nazwa = document.querySelectorAll(".nazwa");
  alert("Zamówienie nr: " + id_zam + " Produkt: " + nazwa[x].innerHTML);
}
```

- **Dlaczego** **`id_zam`** **jest poza funkcją?** Deklaracja zmiennej w zasięgu globalnym (_global scope_) sprawia, że jej wartość jest zapamiętywana. Każde wywołanie funkcji `zamowienia(x)` zwiększa ten sam licznik o $1$ (`1, 2, 3...`). Gdyby zmienna znajdowała się wewnątrz funkcji (_function scope_), przy każdym kliknięciu tworzyłaby się na nowo i zawsze wynosiła $1$.
- **Pobranie nazwy:** `nazwa[x].innerHTML` pobiera tekst z odpowiedniej komórki z klasą `.nazwa` dla wskazanego wiersza `x`.
- **Wyświetlenie:** `alert()` wyświetla komunikat z unikalnym numerem zamówienia oraz nazwą wybranego produktu.
