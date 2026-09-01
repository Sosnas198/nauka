# Kompletny przewodnik: Przechodzenie do następnego/poprzedniego zdjęcia z "zawijaniem" (operator modulo)

Ta ściąga wytłumaczy Ci **od A do Z**, jak działają przyciski "next" i "prev" — w tym najciekawszą część: dlaczego po piątym zdjęciu przycisk "next" wraca do pierwszego, a z pierwszego zdjęcia przycisk "prev" przechodzi od razu do piątego, zamiast wyświetlić błąd.

---

## SEC-1: Przejście do poprzedniego zdjęcia (`prevImage`)

```javascript
function prevImage() {
    currentImageIndex = (currentImageIndex - 1 + imageArray.length) % imageArray.length;
    updateImage();
}
```

### Jak to działa? Rozbijmy ten wzór na czynniki pierwsze

Na pierwszy rzut oka wzór `(currentImageIndex - 1 + imageArray.length) % imageArray.length` wygląda skomplikowanie, ale rozłóżmy go krok po kroku.

- **Najprostszy przypadek (bez zawijania):** Gdybyśmy chcieli po prostu cofnąć się o jedno zdjęcie, wystarczyłoby `currentImageIndex - 1`. Np. jeśli jesteśmy na zdjęciu nr `2` (czyli trzecim zdjęciu, bo liczymy od zera), to `2 - 1 = 1`, czyli drugie zdjęcie. Działa to poprawnie... dopóki nie jesteśmy na **pierwszym** zdjęciu (`currentImageIndex = 0`).
- **Problem:** Jeśli `currentImageIndex = 0` i policzylibyśmy po prostu `0 - 1`, otrzymalibyśmy `-1` — czyli **nieistniejący** indeks tablicy (tablica `imageArray` ma indeksy tylko od `0` do `4`). Musimy więc jakoś "zawinąć" ten wynik z powrotem na koniec listy, czyli na indeks `4` (piąte zdjęcie).
- **`imageArray.length`** – to wbudowana właściwość każdej tablicy, zwracająca **liczbę jej elementów**. Tutaj `imageArray.length` wynosi `5` (bo w tablicy jest pięć nazw plików).
- **`currentImageIndex - 1 + imageArray.length`** – zamiast liczyć po prostu `currentImageIndex - 1` (co mogłoby dać liczbę ujemną), **z góry dodajemy** długość tablicy (`5`). Dzięki temu wynik tego fragmentu **zawsze** jest liczbą dodatnią, niezależnie od tego, na którym zdjęciu aktualnie jesteśmy.
- **`% imageArray.length`** – operator `%` (*modulo*, reszta z dzielenia) "zawija" wynik z powrotem do zakresu od `0` do `4` (czyli do poprawnych indeksów tablicy z pięcioma elementami). Reszta z dzielenia przez `5` zawsze mieści się w przedziale `0`–`4`, niezależnie od tego, jak dużą liczbę podamy przed `%`.
- **Prześledźmy to na przykładzie `currentImageIndex = 0` (pierwsze zdjęcie), klikamy "prev":**
  - `currentImageIndex - 1 + imageArray.length` = `0 - 1 + 5` = `4`
  - `4 % 5` = `4` (bo `4` podzielone przez `5` daje resztę `4`)
  - Nowy `currentImageIndex` to `4`, czyli **piąte** zdjęcie z listy — dokładnie zgodnie z wymaganiem: *"1 -> 5"*.
- **A dla `currentImageIndex = 2` (trzecie zdjęcie), klikamy "prev":**
  - `2 - 1 + 5` = `6`
  - `6 % 5` = `1` (bo `6` podzielone przez `5` daje wynik `1`, reszta `1`)
  - Nowy `currentImageIndex` to `1`, czyli **drugie** zdjęcie — zgodnie z wymaganiem: *"np. 3 -> 2"*.
- **`updateImage();`** – na koniec funkcji wywołujemy kolejną funkcję (opisaną w module 04), która faktycznie **odświeża obraz na stronie**, żeby pokazać zdjęcie o nowo wyliczonym indeksie.

---

## SEC-2: Przejście do następnego zdjęcia (`nextImage`)

```javascript
function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % imageArray.length;
    updateImage();
}
```

### Jak to działa?

- Ta funkcja działa na tej samej zasadzie co `prevImage()`, tylko w drugą stronę — zamiast odejmować `1`, **dodajemy** `1`.
- **`currentImageIndex + 1`** – zwykłe przejście do następnego indeksu. Np. z `1` (drugie zdjęcie) na `2` (trzecie zdjęcie).
- **`% imageArray.length`** – tutaj zawijanie jest prostsze niż w `prevImage()`, bo dodawanie `1` nigdy nie daje liczby ujemnej — nie musimy niczego dodatkowo "podbijać" przed operacją modulo. Sam operator `%` wystarczy, żeby zawinąć wynik z powrotem do `0`, gdy przekroczymy ostatni indeks.
- **Prześledźmy to na przykładzie `currentImageIndex = 4` (piąte, ostatnie zdjęcie), klikamy "next":**
  - `4 + 1` = `5`
  - `5 % 5` = `0` (bo `5` podzielone przez `5` daje resztę `0`)
  - Nowy `currentImageIndex` to `0`, czyli **pierwsze** zdjęcie — dokładnie zgodnie z wymaganiem: *"gdy aktywnym zdjęciem jest piąte, po wciśnięciu 'next' aktywnym zdjęciem zostaje pierwsze"*.
- **`updateImage();`** – tak samo jak w `prevImage()`, na końcu odświeżamy wyświetlany obraz.

---

# Podsumowanie przepływu danych

```text
SEC-1: prevImage()
       currentImageIndex = (currentImageIndex - 1 + imageArray.length) % imageArray.length
       updateImage()
       — Cofnięcie o jedno zdjęcie, z automatycznym zawinięciem z 1. na 5. zdjęcie
                 ↓
SEC-2: nextImage()
       currentImageIndex = (currentImageIndex + 1) % imageArray.length
       updateImage()
       — Przejście do kolejnego zdjęcia, z automatycznym zawinięciem z 5. na 1. zdjęcie
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**       | **Co oznacza / Co robi?**                                                                       |
| ------------------------------ | -------------------------------------------------------------------------------------------------- |
| **`array.length`**              | Zwraca liczbę elementów w tablicy.                                                                  |
| **`%` (modulo)**                | Zwraca resztę z dzielenia — używany tu do "zawinięcia" indeksu z powrotem w prawidłowy zakres.       |
| **"zawijanie" indeksu**         | Technika sprawiająca, że po ostatnim elemencie wracamy do pierwszego (i odwrotnie), bez błędów.      |
| **dodanie `imageArray.length` przed modulo** | Zabezpiecza przed ujemnym wynikiem odejmowania, zanim zadziała operator `%`.            |
