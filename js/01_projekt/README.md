# Projekt JavaScript + DOM: od pobrania pliku do dynamicznej galerii

**Słowa kluczowe:** pobranie elementu (`getElementById`), lista wybranych plików (`.files`), sprawdzenie wyboru (`.files.length`), nazwa pliku (`files[0].name`), tworzenie elementu (`createElement`), atrybuty `.src` / `.alt`, klasa CSS (`classList.add`), wyszukanie kontenera (`querySelector`), dodanie do DOM (`appendChild`).

Projekt uczy dwóch podstawowych operacji na DOM w czystym JavaScripcie:
odczytania danych z elementu formularza (`<input type="file">`) oraz
wykorzystania tych danych do dynamicznego utworzenia i wstawienia nowego
elementu HTML na stronę. Całość jest zebrana w prostym, dwuetapowym
przepływie: najpierw dane wchodzą, potem powstaje z nich widoczny element.
Poniżej znajdziesz **esencję każdego wzorca** — jeśli tylko chcesz sobie
przypomnieć jak coś działało, masz to tutaj. Pełne, powolne tłumaczenie "od
zera" (z podziałem na sekcje SEC-1, SEC-2...) znajduje się w README każdego
podfolderu.

## Struktura projektu

```text
01_projekt_js/
├── 01_pobieranie_nazwy_pliku/       -> odczyt pliku z <input type="file">
└── 02_dynamiczne_tworzenie_dom/     -> stworzenie <img> i wstawienie do DOM
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.js`
(czysta implementacja wzorca). Moduł 1 dostarcza dane (nazwę pliku), a moduł
2 wykorzystuje je do zbudowania nowego elementu — działają razem jako jeden
przepływ: **POBIERZ → SPRAWDŹ → ODCZYTAJ → STWÓRZ → USTAW → WKLEJ**.

---

## Ściągawka wzorców

### 1. Pobranie nazwy wybranego pliku

```javascript
const inputPliku = document.getElementById("plikInput");

if (inputPliku.files.length > 0) {
  const nazwaPliku = inputPliku.files[0].name;
}
```

`getElementById()` pobiera sam element `<input type="file">` z DOM.
`.files` to lista plików wybranych przez użytkownika — `.files.length > 0`
sprawdza, czy w ogóle coś wybrano, zanim spróbujemy to odczytać. `files[0]`
to pierwszy (tu: jedyny) wybrany plik, a `.name` zwraca jego czystą nazwę —
w przeciwieństwie do `input.value`, które potrafi zwrócić sztuczną ścieżkę
typu `C:\fakepath\...`.

→ Pełne wytłumaczenie: [`01_pobieranie_nazwy_pliku/README.md`](./01_pobieranie_nazwy_pliku/README.md)

### 2. Dynamiczne tworzenie i wstawianie elementu

```javascript
const nowyObraz = document.createElement("img");

nowyObraz.src = nazwaPliku;
nowyObraz.alt = nazwaPliku;
nowyObraz.classList.add("miniatury");

const galeria = document.querySelector("section");

galeria.appendChild(nowyObraz);
```

`createElement("img")` tworzy nowy element `<img>` w pamięci — na razie
niewidoczny na stronie. `.src` i `.alt` ustawiają jego atrybuty, a
`classList.add()` dopina klasę CSS odpowiadającą za stylowanie miniatur.
`querySelector("section")` znajduje kontener galerii, a `appendChild()`
dopiero wtedy faktycznie wstawia gotowy element do drzewa DOM — dopiero ten
krok sprawia, że obraz staje się widoczny na stronie.

→ Pełne wytłumaczenie: [`02_dynamiczne_tworzenie_dom/README.md`](./02_dynamiczne_tworzenie_dom/README.md)

---

## Tabela referencyjna

| Plik / moduł                  | Kluczowa funkcja                                                                        | Do czego służy                                    |
| ----------------------------- | --------------------------------------------------------------------------------------- | ------------------------------------------------- |
| `01_pobieranie_nazwy_pliku`   | `getElementById()`, `.files.length`, `files[0].name`                                    | Odczyt pliku wybranego przez użytkownika          |
| `02_dynamiczne_tworzenie_dom` | `createElement()`, `.src`/`.alt`, `classList.add()`, `querySelector()`, `appendChild()` | Utworzenie i wstawienie nowego elementu do strony |
