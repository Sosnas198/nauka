# Kompleksowy kurs JavaScript & DOM: Galeria zdjęć — nawigacja next/prev i miniatury

Witaj w projekcie **10_projekt_galeria**!

Ten przewodnik prowadzi Cię **krok po kroku** przez proces budowania interaktywnej galerii zdjęć, która:

1. przechowuje numer aktywnego zdjęcia oraz listę wszystkich zdjęć,
2. pozwala przechodzić do następnego/poprzedniego zdjęcia przyciskami "next"/"prev", z zawijaniem (po piątym wraca do pierwszego, i odwrotnie),
3. pozwala wybrać dowolne zdjęcie bezpośrednio, klikając jego miniaturę,
4. zawsze pokazuje aktualnie wybrane zdjęcie jako duże, aktywne zdjęcie w bloku prawym.

Cały projekt został podzielony na **4 spójne moduły**.

> **Główna idea:**
> **ZAPAMIĘTAJ STAN → PRZELICZ INDEKS (next/prev/klik miniatury) → ODŚWIEŻ WIDOK**

---

# 📁 Architektura i struktura projektu

```text
10_projekt_galeria/
│
├── 01_zmienne_globalne_i_indeks/
│   ├── README.md
│   └── script.js
│
├── 02_nawigacja_next_i_prev/
│   ├── README.md
│   └── script.js
│
├── 03_wybor_zdjecia_z_miniatury/
│   ├── README.md
│   └── script.js
│
├── 04_aktualizacja_wyswietlanego_zdjecia/
│   ├── README.md
│   └── script.js
│
└── README.md
    └── Główny przewodnik projektu
```

> **Ważna uwaga o "trzech funkcjach" z treści zadania:** Zadanie mówi o *"trzech funkcjach obsługujących wyświetlanie"* — to `prevImage()`, `nextImage()` (moduł 02) oraz `changeImage()` (moduł 03). Czwarta funkcja, `updateImage()` (moduł 04), to wspólna dla nich wszystkich **funkcja pomocnicza**, wywoływana na końcu każdej z trzech głównych funkcji — to ona faktycznie zmienia obrazek widoczny na stronie.

---

# 🔗 Jak to się ma do wymagań zadania?

- **"Zmienna liczbowa przechowująca numer aktywnego zdjęcia"** → moduł `01_zmienne_globalne_i_indeks` (`currentImageIndex`)
- **"Aktywne zdjęcie początkowo jest zdjęciem pierwszym"** → `currentImageIndex = 0` (moduł 01)
- **"Wciśnięcie 'next' zmienia na następne, a z piątego wraca na pierwsze"** → moduł `02_nawigacja_next_i_prev`, SEC-2 (`nextImage`, operator `%`)
- **"Wciskając 'prev', zmiana na poprzednie, np. 4->3, ale 1->5"** → moduł `02_nawigacja_next_i_prev`, SEC-1 (`prevImage`)
- **"Po kliknięciu na miniaturę, aktywnym zdjęciem staje się to kliknięte"** → moduł `03_wybor_zdjecia_z_miniatury` (`changeImage`, `indexOf`)
- **"Aplikacja utrzymuje kontekst — można nawigować na zmianę miniaturami i przyciskami"** → to zasługa jednej, wspólnej zmiennej globalnej `currentImageIndex` (moduł 01), aktualizowanej przez wszystkie trzy funkcje

---

# 🔄 Przepływ logiki

```text
┌───────────────────────────────────────────┐
│  01_zmienne_globalne_i_indeks              │
│  currentImageIndex = 0                     │
│  imageArray = ['1.jpg', ..., '5.jpg']      │
└──────────────────┬─────────────────────────┘
                   │
       ┌───────────┼──────────────┐
       ▼           ▼              ▼
┌─────────────┐┌─────────────┐┌──────────────────────┐
│02_nawigacja ││02_nawigacja ││03_wybor_zdjecia_      │
│_next_i_prev ││_next_i_prev ││z_miniatury            │
│ prevImage() ││ nextImage() ││ changeImage(imageName)│
│ (currentIdx ││ (currentIdx ││ indexOf(imageName)    │
│  -1+len)%len││  +1)%len    ││                       │
└──────┬──────┘└──────┬──────┘└──────────┬────────────┘
       └───────────────┴──────────────────┘
                       ▼
┌───────────────────────────────────────────┐
│  04_aktualizacja_wyswietlanego_zdjecia     │
│  galleryImage = getElementById(...)        │
│  galleryImage.src = imageArray[currentIdx] │
└──────────────────┬─────────────────────────┘
                   ▼
┌───────────────────────────────────────────┐
│              WIDOK STRONY                 │
│   🖼️ duże, aktywne zdjęcie się zmienia       │
└────────────────────────────────────────────┘
```

---

# 📚 Jak uczyć się z tego projektu?

## Moduł 1 — `01_zmienne_globalne_i_indeks`
**Cel:** Przygotowanie "pamięci" programu — który numer zdjęcia jest aktywny i jakie zdjęcia w ogóle istnieją.
**Czego się nauczysz:** zmienne globalne, tablice, indeksowanie od zera.

## Moduł 2 — `02_nawigacja_next_i_prev`
**Cel:** Obsłużenie przycisków "next" i "prev", z zawijaniem na końcach listy.
**Czego się nauczysz:**
- **[SEC-1]** `prevImage()` i technika `(x - 1 + length) % length`
- **[SEC-2]** `nextImage()` i technika `(x + 1) % length`

## Moduł 3 — `03_wybor_zdjecia_z_miniatury`
**Cel:** Obsłużenie kliknięcia w dowolną miniaturę.
**Czego się nauczysz:** parametry funkcji, `array.indexOf()`

## Moduł 4 — `04_aktualizacja_wyswietlanego_zdjecia`
**Cel:** Wspólna funkcja pomocnicza, która faktycznie pokazuje wybrane zdjęcie.
**Czego się nauczysz:** zmienne lokalne, `element.src = ...`

---

# 🧩 Cały mechanizm krok po kroku

```text
1. Strona się ładuje: currentImageIndex = 0, imageArray = [...]
              ↓
2a. Użytkownik klika "next"          2b. Użytkownik klika "prev"        2c. Użytkownik klika miniaturę
    currentImageIndex =                  currentImageIndex =                currentImageIndex =
    (currentImageIndex+1) % length       (currentImageIndex-1+length)       imageArray.indexOf(imageName)
                                          % length
              ↓                              ↓                                  ↓
              └──────────────────────────────┴──────────────────────────────────┘
                                       ▼
3. updateImage() wywoływane na końcu każdej z powyższych funkcji
              ↓
4. galleryImage = getElementById('galleryImage')
              ↓
5. galleryImage.src = imageArray[currentImageIndex]
              ↓
6. 🖼️ nowe zdjęcie widoczne na stronie
```

---

# 🧠 Podsumowanie i wzorce do zapamiętania

| Moduł / Pojęcie                         | Kluczowa funkcja / właściwość      | Zastosowanie                                                |
| --------------------------------------------- | ----------------------------------------- | ------------------------------------------------------------------ |
| `01_zmienne_globalne_i_indeks`                 | zmienne globalne, tablica                 | Przechowanie stanu galerii (który numer zdjęcia jest aktywny)        |
| `02_nawigacja_next_i_prev`                     | `(x ± 1 [+ length]) % length`             | Zmiana zdjęcia z automatycznym zawinięciem na końcach listy           |
| `03_wybor_zdjecia_z_miniatury`                 | `array.indexOf()`                         | Ustawienie jako aktywnego dokładnie tego zdjęcia, które kliknięto     |
| `04_aktualizacja_wyswietlanego_zdjecia`        | `element.src = imageArray[index]`         | Wspólne dla wszystkich trzech funkcji odświeżenie widoku               |

---

# 🎯 Wzorzec końcowy do zapamiętania (kod złożony w całość)

```javascript
var currentImageIndex = 0;
var imageArray = ['1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg'];

function prevImage() {
    currentImageIndex = (currentImageIndex - 1 + imageArray.length) % imageArray.length;
    updateImage();
}

function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % imageArray.length;
    updateImage();
}

function changeImage(imageName) {
    currentImageIndex = imageArray.indexOf(imageName);
    updateImage();
}

function updateImage() {
    var galleryImage = document.getElementById('galleryImage');
    galleryImage.src = imageArray[currentImageIndex];
}
```

---

# 🚀 Najważniejsza logika

```text
ZAPAMIĘTAJ STAN (currentImageIndex, imageArray)
   ↓
PRZELICZ INDEKS
   next: (x + 1) % length
   prev: (x - 1 + length) % length
   miniatura: indexOf(nazwa_pliku)
   ↓
ODŚWIEŻ WIDOK (src = imageArray[currentImageIndex])
```

Czyli:

> **`currentImageIndex` (stan) → `% imageArray.length` (zawijanie) lub `indexOf()` (wybór wprost) → `galleryImage.src = imageArray[currentImageIndex]`**

To jest cały podstawowy przepływ od **kliknięcia przycisku lub miniatury przez użytkownika** do **wyświetlenia właściwego, aktywnego zdjęcia w galerii**.
