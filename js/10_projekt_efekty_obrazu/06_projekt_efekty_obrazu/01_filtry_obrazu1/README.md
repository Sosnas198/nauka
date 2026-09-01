# Kompletny przewodnik: Łączenie kilku filtrów CSS jednocześnie na podstawie zaznaczonych pól (checkbox)

Ten przewodnik tłumaczy **od A do Z**, jak funkcja `zastosuj()` sprawdza, które pola wyboru zostały zaznaczone, i na tej podstawie buduje **jeden, złożony** filtr CSS, łączący nawet kilka efektów naraz (rozmycie, sepia, negatyw).

---

## 🎯 Cel skryptu

Po kliknięciu przycisku "Zastosuj" w pierwszym bloku strony, sprawdzić, które z trzech pól (Blur, Sepia, Negatyw) są zaznaczone, i nałożyć na obrazek dokładnie te efekty, które użytkownik wybrał — nawet kilka jednocześnie.

> ℹ️ **Uwaga:** W treści zadania pola te są opisane jako "pole" (co sugeruje checkboxy), natomiast w kodzie HTML są to znaczniki `<input type="radio">`. W praktyce z punktu widzenia JavaScriptu (odczytywanie `.checked`) działają one identycznie — każdy z nich ma swoją właściwość `checked`, którą można odczytać niezależnie.

---

## SEC-1: Pobranie obrazka i stanu poszczególnych pól wyboru

```javascript
const img = document.getElementById('pszczola');
const blur = document.getElementById('blur').checked;
const sepia = document.getElementById('sepia').checked;
const negatyw = document.getElementById('negatyw').checked;
```

### Jak to działa?

- **`document.getElementById('pszczola')`** — pobiera element `<img>` o identyfikatorze `pszczola` (obrazek pszczoły w pierwszym bloku strony). Zapisujemy go w zmiennej `img`, żeby móc dalej modyfikować jego styl.
- **`document.getElementById('blur').checked`** — pobiera pole wyboru o identyfikatorze `blur`, a następnie od razu odczytuje jego właściwość **`.checked`**. Ta właściwość zwraca wartość logiczną: **`true`**, jeśli pole jest zaznaczone, albo **`false`**, jeśli nie jest.
- Dokładnie tak samo odczytywane są stany pól `sepia` i `negatyw`. Po tych trzech liniach mamy trzy zmienne (`blur`, `sepia`, `negatyw`), każda zawierająca `true` lub `false` — czyli wiemy dokładnie, które efekty użytkownik chce zastosować.

---

## SEC-2: Budowanie tekstu filtra CSS na podstawie zaznaczonych pól

```javascript
let filterValue = '';
if (blur) {
    filterValue += 'blur(6px) ';
}
if (sepia) {
    filterValue += 'sepia(100%) ';
}
if (negatyw) {
    filterValue += 'invert(100%) ';
}
```

### Jak to działa?

- **`let filterValue = '';`** — tworzymy zmienną tekstową, która na razie jest pustym tekstem. Będziemy do niej **dopisywać** kolejne fragmenty w zależności od tego, co zostało zaznaczone.
- **`if (blur) { filterValue += 'blur(6px) '; }`** — jeśli zmienna `blur` ma wartość `true` (czyli pole "Blur" było zaznaczone), dopisujemy do `filterValue` fragment `'blur(6px) '`. Operator **`+=`** oznacza *"dopisz to na końcu istniejącego tekstu"* (to skrót od `filterValue = filterValue + 'blur(6px) '`). Wartość `6px` mieści się dokładnie w wymaganym w treści zadania przedziale (4 px ÷ 8 px).
- Analogicznie: jeśli zaznaczono "Sepia", dopisujemy `'sepia(100%) '`; jeśli zaznaczono "Negatyw", dopisujemy `'invert(100%) '`.
- **Kluczowa cecha tego podejścia:** każdy z trzech warunków `if` jest **niezależny** od pozostałych (nie ma tu `else if`) — dzięki temu, jeśli użytkownik zaznaczy np. **jednocześnie** Blur i Sepia, oba fragmenty tekstu trafią do `filterValue`, jeden po drugim, oddzielone spacją (zauważ spację na końcu każdego dopisywanego fragmentu, np. `'blur(6px) '`) — co pozwala na **łączenie wielu efektów CSS naraz** w jednej właściwości `filter`.

---

## SEC-3: Zastosowanie zbudowanego filtra na obrazku

```javascript
img.style.filter = filterValue.trim();
```

### Jak to działa?

- **`img.style.filter = ...`** — właściwość CSS `filter` pozwala nałożyć na element graficzne efekty (rozmycie, zmianę kolorów, itd.). Ustawiając ją z poziomu JavaScriptu (`img.style.filter`), bezpośrednio zmieniamy wygląd obrazka na stronie, bez potrzeby przeładowania jej.
- **`filterValue.trim()`** — funkcja `.trim()` usuwa białe znaki (w tym spacje) z **początku i końca** tekstu. Jest to potrzebne, bo każdy dopisywany fragment kończył się spacją (np. `'blur(6px) '`) — gdyby zaznaczono tylko jeden efekt, na samym końcu `filterValue` zostałaby jedna, zbędna spacja. `.trim()` porządkuje to, usuwając taką nadmiarową spację z końca całego tekstu.
- Jeśli **żadne** pole nie zostało zaznaczone, `filterValue` pozostaje pustym tekstem, więc `img.style.filter` zostanie ustawiony na `''` — czyli obrazek wróci do swojego normalnego, niezmienionego wyglądu (bez żadnych filtrów).

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Właściwość**       | **Co oznacza / Co robi?**                                                                     |
| --------------------------------- | -------------------------------------------------------------------------------------------------|
| `.checked`                         | Właściwość pola typu checkbox/radio, zwracająca `true`, jeśli jest zaznaczone, `false` jeśli nie. |
| `+=` (dopisywanie do tekstu)        | Operator dopisujący nowy fragment tekstu na końcu istniejącej zmiennej tekstowej.                  |
| `style.filter`                      | Właściwość CSS, którą można ustawić z JavaScriptu, aby nałożyć na element efekty graficzne.        |
| `blur(Npx)`, `sepia(N%)`, `invert(N%)` | Funkcje filtra CSS: rozmycie, sepia (efekt starej fotografii), negatyw (odwrócenie kolorów).    |
| `.trim()`                           | Usuwa białe znaki (spacje, tabulatory) z początku i końca tekstu.                                  |
| Kilka niezależnych `if` (bez `else`) | Pozwala sprawdzić wiele niezależnych warunków i połączyć ich efekty (tu: kilka filtrów naraz), zamiast wybierać tylko jeden. |
