# Kompletny przewodnik: Regulacja jasności obrazka suwakiem o niestandardowym zakresie

Ten przewodnik tłumaczy **od A do Z**, jak funkcja `jasnosc()` odczytuje wartość suwaka i na jej podstawie zmienia jasność obrazka — zwracając szczególną uwagę na to, czym różni się ten suwak od suwaka przezroczystości z submodułu 3.

---

## 🎯 Cel skryptu

Po przesunięciu suwaka i kliknięciu przycisku "Zastosuj" w czwartym bloku strony, nałożyć na obrazek filtr zmieniający jego jasność, o wartości procentowej wskazanej suwakiem.

---

## SEC-1: Pobranie obrazka za pomocą selektora CSS

```javascript
const img = document.querySelector('#blok4 img');
```

### Jak to działa?

- Dokładnie tak samo jak w submodule 3: obrazek żółwia w bloku 4 (`<img src="zolw.jpg" alt="Żółw w wodzie">`) **nie ma własnego `id`**, więc pobieramy go za pomocą selektora CSS **`'#blok4 img'`** — czyli *"znajdź `<img>` wewnątrz elementu o id `blok4`"*.

---

## SEC-2: Odczytanie wartości suwaka jasności

```javascript
const jasnoscValue = document.getElementById('jasnosc').value;
```

### Jak to działa?

- **`document.getElementById('jasnosc').value`** — pobiera aktualną wartość suwaka o identyfikatorze `jasnosc`.

> ⚠️ **Ważna różnica względem submodułu 3 (przezroczystość):** Przyjrzyj się dokładnie znacznikowi tego suwaka w kodzie HTML:
>
> ```html
> <input type="range" min="0" max="250" id="jasnosc" name="jasnosc">
> ```
>
> - **Zakres suwaka to `min="0"` do `max="250"`**, a nie `0` do `100`, jak przy przezroczystości! Oznacza to, że użytkownik może ustawić wartość jasności znacznie **powyżej** 100%, aż do 250% — co pozwala nie tylko przyciemnić obrazek, ale też znacząco go **rozjaśnić** ponad normalny poziom.
> - **Ten suwak nie ma atrybutu `value="..."`** ustawionego na sztywno w HTML (w przeciwieństwie do suwaka przezroczystości, który miał `value="100"`). Oznacza to, że domyślnie taki suwak w przeglądarce zaczyna od wartości równej połowie zakresu (czyli w tym przypadku od `125`, bo `(0 + 250) / 2 = 125`), dopóki użytkownik go nie przesunie.

---

## SEC-3: Zastosowanie filtra jasności

```javascript
img.style.filter = `brightness(${jasnoscValue}%)`;
```

### Jak to działa?

- Podobnie jak w submodule 3, używamy **szablonu literału** (tekstu w znakach `` ` ``), żeby wstawić wartość suwaka bezpośrednio do tekstu filtra.
- **`brightness(N%)`** — to funkcja filtra CSS zmieniająca jasność elementu:
  - `brightness(100%)` — jasność normalna, bez zmian.
  - `brightness(0%)` — obrazek staje się całkowicie czarny.
  - `brightness(200%)` — obrazek staje się znacznie jaśniejszy niż normalnie (prześwietlony), a właśnie taki wysoki poziom jasności jest możliwy dzięki temu, że suwak sięga aż do `250`.
- Efekt: jeśli suwak ustawiono na `180`, obrazek otrzyma filtr `brightness(180%)`, czyli będzie wyraźnie jaśniejszy niż w swojej oryginalnej wersji.

---

## 🔍 Porównanie submodułu 3 i 4 — dlaczego są tak podobne, a jednak różne?

| Cecha                          | Submoduł 3 (przezroczystość)         | Submoduł 4 (jasność)                  |
| -------------------------------- | --------------------------------------- | ---------------------------------------- |
| Zakres suwaka (`min`/`max`)      | `0` do `100`                            | `0` do `250`                              |
| Wartość początkowa (`value`)      | ustawiona na `100`                      | brak — domyślnie środek zakresu           |
| Filtr CSS                        | `opacity(N%)`                           | `brightness(N%)`                          |
| Sens wartości powyżej 100%       | niemożliwe (maksimum to pełna widoczność) | możliwe — obrazek staje się jaśniejszy niż oryginalnie |

Obie funkcje mają niemal identyczną **strukturę kodu** (pobierz obrazek → odczytaj suwak → zbuduj filtr przez szablon literału → zastosuj), różnią się jednak nazwą filtra CSS oraz zakresem sensownych wartości, co wynika z natury samego efektu (przezroczystość ma sens tylko do 100%, a jasność można zwiększać znacznie powyżej normy).

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Właściwość**       | **Co oznacza / Co robi?**                                                                     |
| --------------------------------- | -------------------------------------------------------------------------------------------------|
| `brightness(N%)`                    | Filtr CSS zmieniający jasność elementu — `100%` to normalna jasność, więcej niż `100%` rozjaśnia ponad oryginał. |
| `max` w `<input type="range">`      | Górna granica zakresu suwaka — tutaj `250`, co pozwala na rozjaśnienie obrazka powyżej normy.       |
| Brak atrybutu `value` w `<input type="range">` | Suwak domyślnie ustawia się na środku zakresu (`min` + `max`) / 2, dopóki użytkownik go nie przesunie. |
