# Kompletny przewodnik: Wspólna funkcja odświeżająca wyświetlane zdjęcie (`updateImage`)

Ta ściąga wytłumaczy Ci **od A do Z**, jak działa funkcja `updateImage()` — jedyne miejsce w całym kodzie, które faktycznie **zmienia to, co widać na ekranie**. Wszystkie trzy pozostałe funkcje (`prevImage`, `nextImage`, `changeImage`) tylko wyliczają nowy `currentImageIndex`, a na koniec **wywołują właśnie tę funkcję**, żeby pokazać efekt.

> **Uwaga:** Ta funkcja nie jest wprost wymieniona w treści zadania jako jedna z "trzech funkcji obsługujących wyświetlanie" — te trzy to `prevImage`, `nextImage` i `changeImage` (moduły 02 i 03). `updateImage()` jest jednak niezbędną **funkcją pomocniczą**, wspólną dla wszystkich trzech, i jest częścią przesłanego, kompletnego kodu.

---

## SEC-1: Pobranie elementu dużego zdjęcia

```javascript
var galleryImage = document.getElementById('galleryImage');
```

### Jak to działa?

- **`document.getElementById('galleryImage')`** – wyszukuje w HTML znacznik `<img id="galleryImage" src="1.jpg" alt="galeria">` — to właśnie ten duży obrazek w bloku prawym, nazywany w zadaniu "aktywnym zdjęciem".
- **`var galleryImage = ...`** – zapisujemy ten element do zmiennej `galleryImage`, żeby móc zaraz zmienić jego atrybut `src` (czyli źródło obrazka).
- Zwróć uwagę, że ta zmienna jest deklarowana **wewnątrz** funkcji `updateImage()` (a nie na zewnątrz, jak `currentImageIndex` i `imageArray` w module 01) — jest więc **lokalna**, potrzebna tylko na czas działania tej jednej funkcji, w przeciwieństwie do zmiennych globalnych.

---

## SEC-2: Podmiana źródła zdjęcia na aktualne (`src`)

```javascript
galleryImage.src = imageArray[currentImageIndex];
```

### Jak to działa?

- **`imageArray[currentImageIndex]`** – korzystamy tutaj z dwóch zmiennych globalnych z modułu 01: z tablicy `imageArray` (lista wszystkich nazw plików) oraz z `currentImageIndex` (numer aktywnego zdjęcia, wyliczony wcześniej przez `prevImage()`, `nextImage()` albo `changeImage()`). Zapis `tablica[indeks]` pobiera element tablicy znajdujący się na danej pozycji — np. jeśli `currentImageIndex` wynosi `2`, to `imageArray[2]` da nam `'3.jpg'`.
- **`galleryImage.src = ...`** – ustawiamy atrybut `src` (źródło obrazka) dużego zdjęcia na tę właśnie nazwę pliku. Przeglądarka, widząc zmianę atrybutu `src`, **natychmiast** wczytuje i wyświetla nowy obrazek — to jest dokładnie ten moment, w którym użytkownik **widzi** efekt kliknięcia "next", "prev" albo miniatury.
- Ta jedna linijka jest tak naprawdę **sercem całej galerii** — niezależnie od tego, która z trzech funkcji nawigacyjnych ją wywołała, efekt końcowy jest zawsze taki sam: duże zdjęcie pokazuje dokładnie ten plik, na który w danej chwili wskazuje `currentImageIndex`.

---

# Podsumowanie przepływu danych

```text
SEC-1: galleryImage = document.getElementById('galleryImage')
       — Pobranie elementu dużego, aktywnego zdjęcia
                 ↓
SEC-2: galleryImage.src = imageArray[currentImageIndex]
       — Podmiana wyświetlanego obrazka na ten, wskazywany przez aktualny indeks
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**   | **Co oznacza / Co robi?**                                                            |
| -------------------------- | -------------------------------------------------------------------------------------- |
| **funkcja pomocnicza**       | Funkcja wywoływana przez inne funkcje, wykonująca wspólną dla nich czynność.            |
| **zmienna lokalna**           | Zmienna zadeklarowana wewnątrz funkcji — istnieje tylko na czas jej działania.          |
| **`tablica[indeks]`**         | Pobiera element tablicy znajdujący się na wskazanej pozycji.                            |
| **`element.src = "plik"`**    | Zmienia źródło obrazka — przeglądarka od razu wczytuje i wyświetla nowy plik.           |
