# Projekt JavaScript + DOM: fotografia artystyczna (koszyk zamówień)

**Słowa kluczowe:** odczyt kontrolek formularza (`.value`, `.files`), obliczenie ceny (cennik + liczba kopii), tworzenie elementu (`createElement`), budowa struktury `<article>`, dodanie do koszyka (`appendChild`), jedna funkcja spinająca (`dodaj()`).

Projekt uczy trzyetapowego przepływu obsługi formularza zamówienia: odczytania
danych z kontrolek, przeliczenia ceny na podstawie liczby kopii i rodzaju
papieru, a na końcu zbudowania i wstawienia nowej pozycji do koszyka jako
gotowego elementu DOM. Wszystkie trzy etapy wykonują się jedna po drugiej w
jednym wywołaniu funkcji `dodaj()`. Całość jest zebrana w jednym pliku
`main.js`, podpiętym do `fotografia.html`. Poniżej znajdziesz **esencję
każdego wzorca** — jeśli tylko chcesz sobie przypomnieć jak coś działało, masz
to tutaj. Pełne, powolne tłumaczenie "od zera" (z podziałem na sekcje SEC-1,
SEC-2...) znajduje się w README każdego podfolderu.

## Struktura projektu

```text
04_projekt_fotografia/
├── 01_pobieranie_danych_z_kontrolek/     -> odczyt pliku, liczby kopii, rodzaju papieru
├── 02_obliczanie_ceny/                   -> cennik + cena jednostkowa × liczba kopii
├── 03_tworzenie_elementow_koszyka/       -> <article> z obrazem i paragrafami
├── fotografia.html                       -> strona: formularz + koszyk
└── main.js                               -> funkcja dodaj() łącząca wszystkie moduły
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.js`
(czysta implementacja wzorca). `main.js` łączy te trzy wzorce w jedną funkcję
`dodaj()`, wywoływaną atrybutem `onclick` przycisku "Dodaj do koszyka" w
`fotografia.html`. Plik `style.css` pochodzi z arkusza zadania — w HTML jest
tylko do niego link.

---

## Ściągawka wzorców

### 1. Pobranie danych z kontrolek

```javascript
const plik = document.getElementById("plik").files[0];
const liczbaKopii = Number(document.getElementById("kopie").value);
const rodzajPapieru = document.getElementById("papier").value;
```

Trzy różne rodzaje kontrolek, trzy różne sposoby odczytu: `.files[0]` dla
pola wyboru pliku, `.value` przekonwertowane przez `Number()` dla pola
liczbowego (bo `.value` zawsze zwraca tekst), i samo `.value` dla listy
wyboru rodzaju papieru. Wszystkie trzy wartości są potrzebne w kolejnych
dwóch krokach.

→ Pełne wytłumaczenie: [`01_pobieranie_danych_z_kontrolek/README.md`](./01_pobieranie_danych_z_kontrolek/README.md)

### 2. Obliczenie ceny

```javascript
const cennik = {
  matowy: 2,
  blyszczacy: 3,
};

const cenaJednostkowa = cennik[rodzajPapieru];
const cenaLaczna = cenaJednostkowa * liczbaKopii;
```

Obiekt `cennik` trzyma cenę jednostkową dla każdego rodzaju papieru pod
kluczem odpowiadającym wartości z listy wyboru — dzięki temu
`cennik[rodzajPapieru]` od razu daje właściwą cenę bez łańcucha `if/else`.
Cena łączna to prosty iloczyn ceny jednostkowej i liczby zamówionych kopii.

→ Pełne wytłumaczenie: [`02_obliczanie_ceny/README.md`](./02_obliczanie_ceny/README.md)

### 3. Utworzenie pozycji koszyka

```javascript
const pozycja = document.createElement("article");

const obraz = document.createElement("img");
obraz.src = URL.createObjectURL(plik);

const opis = document.createElement("p");
opis.textContent = `${rodzajPapieru}, ${liczbaKopii} szt. — ${cenaLaczna} zł`;

pozycja.appendChild(obraz);
pozycja.appendChild(opis);

document.getElementById("koszyk").appendChild(pozycja);
```

Nowa pozycja koszyka to `<article>` zbudowany z mniejszych elementów:
podglądu obrazu (`URL.createObjectURL()` tworzy tymczasowy adres do
wybranego pliku, bez wysyłania go na serwer) oraz paragrafu z opisem
zamówienia. Elementy dokłada się do `<article>` przez `appendChild()`, a
gotowy `<article>` — dopiero na końcu — trafia do kontenera `#koszyk`.

→ Pełne wytłumaczenie: [`03_tworzenie_elementow_koszyka/README.md`](./03_tworzenie_elementow_koszyka/README.md)

---

## Tabela referencyjna

| Plik / moduł                       | Kluczowa funkcja                                      | Do czego służy                               |
| ---------------------------------- | ----------------------------------------------------- | -------------------------------------------- |
| `01_pobieranie_danych_z_kontrolek` | `.files[0]`, `.value`, `Number()`                     | Odczyt pliku, liczby kopii i rodzaju papieru |
| `02_obliczanie_ceny`               | obiekt `cennik`, mnożenie                             | Wyliczenie ceny jednostkowej i łącznej       |
| `03_tworzenie_elementow_koszyka`   | `createElement`, `URL.createObjectURL`, `appendChild` | Zbudowanie i wstawienie pozycji do koszyka   |
| `main.js`                          | funkcja `dodaj()` = moduły 1 + 2 + 3                  | Skrypt strony głównej                        |
