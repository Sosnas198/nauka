# Kompletny przewodnik: Zmienne globalne — numer aktywnego zdjęcia i lista wszystkich zdjęć

Ta ściąga wytłumaczy Ci **od A do Z**, jak przechowywana jest informacja o tym, które zdjęcie jest aktualnie "aktywne" (czyli wyświetlane jako duże, w bloku prawym), oraz skąd program w ogóle wie, jakie zdjęcia są dostępne w galerii.

---

## SEC-1: Zmienna przechowująca numer aktywnego zdjęcia (`currentImageIndex`)

```javascript
var currentImageIndex = 0;
```

### Jak to działa?

- **`var currentImageIndex = 0;`** – tworzymy zmienną, która **przez cały czas działania strony** będzie pamiętać, które zdjęcie jest właśnie aktywne. Nazwa `currentImageIndex` (z angielskiego: "indeks bieżącego obrazka") jasno mówi, do czego służy.
- Zaczynamy od wartości `0` — w programowaniu **numerację elementów zaczyna się od zera**, a nie od jedynki. Oznacza to, że `currentImageIndex = 0` odpowiada w praktyce **pierwszemu** zdjęciu z listy (zobacz SEC-2), a nie "zerowemu". To dokładnie realizuje wymaganie: *"Aktywne zdjęcie początkowo jest zdjęciem pierwszym"*.
- **`var`** (zamiast `let`, którego używaliśmy w poprzednich projektach) – to starszy sposób deklarowania zmiennych w JavaScript. Działa podobnie do `let` (zmienna, którą można później zmieniać), ale ma nieco inne, szczególne zasady dotyczące zasięgu — w tym projekcie nie ma to jednak znaczenia praktycznego, `var` działa tu poprawnie.
- **Zmienna globalna** – ta zmienna jest zadeklarowana **poza jakąkolwiek funkcją**, bezpośrednio w znaczniku `<script>`. Dzięki temu **wszystkie cztery funkcje** w tym projekcie (`prevImage`, `nextImage`, `changeImage`, `updateImage`) mogą ją odczytywać i zmieniać — to właśnie ona jest tym wspomnianym w zadaniu: *"zmienną liczbową przechowującą numer aktywnego zdjęcia"*.

---

## SEC-2: Zmienna przechowująca listę wszystkich zdjęć (`imageArray`)

```javascript
var imageArray = ['1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg'];
```

### Jak to działa?

- **`imageArray`** – to **tablica** (ang. *array*), czyli uporządkowana lista wartości. Tutaj każda wartość to nazwa pliku ze zdjęciem, w postaci tekstu.
- Kwadratowe nawiasy `[ ]` oznaczają w JavaScript zapis tablicy, a poszczególne elementy oddziela się przecinkami.
- Elementy tablicy są ponumerowane **od zera**: `imageArray[0]` to `'1.jpg'`, `imageArray[1]` to `'2.jpg'`, `imageArray[2]` to `'3.jpg'`, `imageArray[3]` to `'4.jpg'`, a `imageArray[4]` to `'5.jpg'`.
- Dzięki temu widać teraz, dlaczego `currentImageIndex` zaczyna się od `0`: `imageArray[currentImageIndex]`, czyli `imageArray[0]`, to właśnie `'1.jpg'` — pierwsze zdjęcie na liście.
- Ta zmienna jest też **globalna** — wszystkie funkcje w projekcie mogą z niej odczytywać nazwy plików, ale żadna z nich nie musi (i nie powinna) jej modyfikować — służy wyłącznie jako "spis dostępnych zdjęć".

---

# Podsumowanie przepływu danych

```text
SEC-1: currentImageIndex = 0
       — Numer aktywnego zdjęcia (0 = pierwsze zdjęcie na liście)
                 ↓
SEC-2: imageArray = ['1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg']
       — Lista wszystkich dostępnych zdjęć, w ustalonej kolejności
                 ↓
       imageArray[currentImageIndex] — zawsze wskazuje na nazwę pliku aktywnego zdjęcia
       (dalej: moduły 02–04 — zmiana currentImageIndex i wyświetlenie zdjęcia)
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**    | **Co oznacza / Co robi?**                                                                  |
| ---------------------------- | -------------------------------------------------------------------------------------------- |
| **zmienna globalna**          | Zmienna zadeklarowana poza funkcjami — dostępna i modyfikowalna przez wszystkie funkcje.       |
| **`var`**                     | Sposób deklarowania zmiennej (podobny do `let`), której wartość można później zmieniać.        |
| **tablica (`[ ]`)**            | Uporządkowana lista wartości, numerowanych od `0`.                                             |
| **indeksowanie od zera**      | Pierwszy element tablicy ma indeks `0`, drugi `1`, itd.                                        |
