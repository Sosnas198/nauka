# Projekt JavaScript + DOM: galeria zdjęć (nawigacja next/prev i miniatury)

**Słowa kluczowe:** zmienne globalne (`currentImageIndex`, `imageArray`), indeksowanie od zera, zawijanie indeksu modulo (`(x + 1) % length`, `(x - 1 + length) % length`), wybór po nazwie (`array.indexOf()`), wspólna funkcja odświeżająca (`updateImage()`), `element.src = ...`.

Projekt uczy, jak trzy różne sposoby zmiany aktywnego zdjęcia — przycisk
"next", przycisk "prev" i kliknięcie miniatury — mogą współdzielić jedną,
wspólną zmienną stanu oraz jedną, wspólną funkcję odświeżającą widok. Dzięki
temu galeria "pamięta kontekst": można swobodnie przełączać się między
nawigacją przyciskami a wyborem miniatury, bo wszystkie trzy ścieżki
aktualizują ten sam licznik. Całość jest zebrana w jednym pliku ze skryptem
strony. Poniżej znajdziesz **esencję każdego wzorca** — jeśli tylko chcesz
sobie przypomnieć jak coś działało, masz to tutaj. Pełne, powolne
tłumaczenie "od zera" (z podziałem na sekcje SEC-1, SEC-2...) znajduje się w
README każdego podfolderu.

## Struktura projektu

```text
10_projekt_galeria/
├── 01_zmienne_globalne_i_indeks/               -> currentImageIndex + imageArray
├── 02_nawigacja_next_i_prev/                   -> zawijanie indeksu modulo
├── 03_wybor_zdjecia_z_miniatury/                -> indexOf() po kliknięciu miniatury
└── 04_aktualizacja_wyswietlanego_zdjecia/       -> wspólna funkcja updateImage()
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.js`
(czysta implementacja wzorca). Trzy główne funkcje — `prevImage()`,
`nextImage()` (moduł 02) i `changeImage()` (moduł 03) — to te wspomniane w
treści zadania _"trzy funkcje obsługujące wyświetlanie"_. Czwarta funkcja,
`updateImage()` (moduł 04), to wspólna dla nich wszystkich funkcja pomocnicza,
wywoływana na końcu każdej z trzech głównych — to ona faktycznie zmienia
obrazek widoczny na stronie.

---

## Ściągawka wzorców

### 1. Zmienne globalne i indeks

```javascript
var currentImageIndex = 0;
var imageArray = ["1.jpg", "2.jpg", "3.jpg", "4.jpg", "5.jpg"];
```

`currentImageIndex` to "pamięć" programu — liczbowy indeks aktualnie
aktywnego zdjęcia, startujący od `0` (pierwsze zdjęcie w tablicy, bo
indeksowanie w JavaScript zaczyna się od zera, nie od jedynki).
`imageArray` to lista wszystkich dostępnych zdjęć. Obie zmienne są
zdefiniowane na poziomie globalnym, dzięki czemu wszystkie trzy funkcje
nawigacyjne mogą je odczytywać i modyfikować.

→ Pełne wytłumaczenie: [`01_zmienne_globalne_i_indeks/README.md`](./01_zmienne_globalne_i_indeks/README.md)

### 2. Nawigacja next/prev z zawijaniem

```javascript
function prevImage() {
  currentImageIndex =
    (currentImageIndex - 1 + imageArray.length) % imageArray.length;
  updateImage();
}

function nextImage() {
  currentImageIndex = (currentImageIndex + 1) % imageArray.length;
  updateImage();
}
```

`nextImage()` zwiększa indeks o 1, a operator `%` (reszta z dzielenia)
sprawia, że po przekroczeniu ostatniego indeksu wynik "zawija się" z
powrotem do zera — bez tego trzeba by pisać osobny `if` sprawdzający
przekroczenie zakresu. `prevImage()` działa odwrotnie, ale dodaje najpierw
`imageArray.length`, żeby uniknąć ujemnego wyniku przy cofaniu się z
pierwszego zdjęcia (JavaScript nie liczy reszty z ujemnej liczby tak, jak
matematyka zwykle by chciała). Obie funkcje kończą się wywołaniem
`updateImage()`, które faktycznie zmienia obrazek na stronie.

→ Pełne wytłumaczenie: [`02_nawigacja_next_i_prev/README.md`](./02_nawigacja_next_i_prev/README.md)

### 3. Wybór zdjęcia z miniatury

```javascript
function changeImage(imageName) {
  currentImageIndex = imageArray.indexOf(imageName);
  updateImage();
}
```

Zamiast przeliczać indeks o jeden krok w przód lub w tył, ta funkcja
przyjmuje jako parametr **nazwę pliku** klikniętej miniatury i od razu
wyszukuje jej pozycję w tablicy przez `array.indexOf()`. Dzięki temu
kliknięcie w dowolną miniaturę ustawia `currentImageIndex` bezpośrednio na
właściwą wartość, bez względu na to, które zdjęcie było aktywne wcześniej.

→ Pełne wytłumaczenie: [`03_wybor_zdjecia_z_miniatury/README.md`](./03_wybor_zdjecia_z_miniatury/README.md)

### 4. Aktualizacja wyświetlanego zdjęcia

```javascript
function updateImage() {
  var galleryImage = document.getElementById("galleryImage");
  galleryImage.src = imageArray[currentImageIndex];
}
```

Jedna, wspólna funkcja pomocnicza wywoływana na końcu wszystkich trzech
funkcji nawigacyjnych — to jedyne miejsce w całym skrypcie, które faktycznie
dotyka elementu `<img>` na stronie. Pobiera element dużego, aktywnego
zdjęcia i ustawia jego `.src` na tę pozycję tablicy `imageArray`, na którą
akurat wskazuje `currentImageIndex`.

→ Pełne wytłumaczenie: [`04_aktualizacja_wyswietlanego_zdjecia/README.md`](./04_aktualizacja_wyswietlanego_zdjecia/README.md)

---

## Tabela referencyjna

| Plik / moduł                            | Kluczowa funkcja                  | Do czego służy                                                    |
| --------------------------------------- | --------------------------------- | ----------------------------------------------------------------- |
| `01_zmienne_globalne_i_indeks`          | zmienne globalne, tablica         | Przechowanie stanu galerii (który numer zdjęcia jest aktywny)     |
| `02_nawigacja_next_i_prev`              | `(x ± 1 [+ length]) % length`     | Zmiana zdjęcia z automatycznym zawinięciem na końcach listy       |
| `03_wybor_zdjecia_z_miniatury`          | `array.indexOf()`                 | Ustawienie jako aktywnego dokładnie tego zdjęcia, które kliknięto |
| `04_aktualizacja_wyswietlanego_zdjecia` | `element.src = imageArray[index]` | Wspólne dla wszystkich trzech funkcji odświeżenie widoku          |
