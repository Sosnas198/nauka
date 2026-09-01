# Projekt JavaScript + DOM: salon paznokci (galeria wzorów + przełączanie sekcji)

**Słowa kluczowe:** pętla `for`, tworzenie elementu (`createElement("img")`), atrybuty `.src` / `.className` / `.title`, dodanie do DOM (`appendChild`), zdarzenie najechania (`onmouseover` / `mouseover`), ukrywanie i pokazywanie (`style.display`), zaznaczenie aktywnego przycisku (`querySelectorAll`, kolory Salmon / Crimson).

Projekt uczy dwóch wzorców pracujących na jednej stronie: generowania serii
elementów HTML pętlą oraz przełączania widoczności bloków treści w reakcji na
zdarzenie myszy (nie kliknięcie). Całość jest zebrana w jednym działającym
pliku: `paznokcie.html`. Poniżej znajdziesz **esencję każdego wzorca** — jeśli
tylko chcesz sobie przypomnieć jak coś działało, masz to tutaj. Pełne,
powolne tłumaczenie "od zera" (z podziałem na sekcje SEC-1, SEC-2...) znajduje
się w README każdego podfolderu.

## Struktura projektu

```text
02_projekt_paznokcie/
├── 01_generowanie_obrazow/                   -> pętla for + 10 obrazów (1.jpg...10.jpg)
├── 02_przelaczanie_sekcji_i_przyciskow/      -> mouseover + display + kolory przycisków
└── paznokcie.html                            -> pełna strona: HTML + oba skrypty razem
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.js`
(czysta implementacja wzorca, z komentarzami odsyłającymi do konkretnych
sekcji README). `paznokcie.html` łączy oba wzorce w działającą stronę salonu.

---

## Ściągawka wzorców

### 1. Generowanie obrazów pętlą

```javascript
for (let i = 1; i <= 10; i++) {
  const obraz = document.createElement("img");
  obraz.src = i + ".jpg";
  obraz.className = "wzory";
  obraz.title = i;

  document.getElementById("sekcja3").appendChild(obraz);
}
```

Pętla `for` liczy od `1` do `10`, a w każdym obrocie tworzy nowy element
`<img>` przez `createElement()`. Nazwa pliku (`.src`) budowana jest przez
doklejenie numeru obrotu pętli do `.jpg`, dzięki czemu jedna pętla generuje
kolejno `1.jpg`, `2.jpg`, ..., `10.jpg`. `.className = "wzory"` nadaje każdemu
obrazowi tę samą klasę CSS ze stylami miniatur, a `.title = i` ustawia dymek
przeglądarki na sam numer obrazu (nie pełną nazwę pliku). Każdy gotowy
element trafia od razu do kontenera `#sekcja3` przez `appendChild()`.

→ Pełne wytłumaczenie: [`01_generowanie_obrazow/README.md`](./01_generowanie_obrazow/README.md)

### 2. Przełączanie sekcji i przycisków na najechanie kursorem

```javascript
function kolor() {
  document.getElementById("sekcja1").style.display = "block";
  document.getElementById("sekcja2").style.display = "none";
  document.getElementById("sekcja3").style.display = "none";

  const przyciski = document.querySelectorAll("nav button");
  przyciski.forEach((p) => (p.style.backgroundColor = "Crimson"));
  przyciski[0].style.backgroundColor = "Salmon";
}
```

Zdarzenie startuje na `onmouseover` (najechanie kursorem), a nie na kliknięcie
— reakcja pojawia się od razu przy przesunięciu myszy nad przycisk. Funkcja
pokazuje jedną sekcję (`style.display = "block"`) i chowa pozostałe
(`style.display = "none"`), więc na stronie zawsze widoczny jest tylko jeden
blok treści naraz. `querySelectorAll("nav button")` pobiera wszystkie
przyciski nawigacji naraz, żeby jednym przebiegiem ustawić im domyślny kolor
Crimson, a dopiero potem podświetlić Salmon ten jeden, który odpowiada
aktywnej sekcji.

→ Pełne wytłumaczenie: [`02_przelaczanie_sekcji_i_przyciskow/README.md`](./02_przelaczanie_sekcji_i_przyciskow/README.md)

---

## Tabela referencyjna

| Plik / moduł                          | Kluczowa funkcja                                            | Do czego służy                                             |
| ------------------------------------- | ----------------------------------------------------------- | ---------------------------------------------------------- |
| `01_generowanie_obrazow`              | `for`, `createElement("img")`, `.src`/`.className`/`.title` | Wygenerowanie 10 obrazów wzorów pętlą                      |
| `02_przelaczanie_sekcji_i_przyciskow` | `onmouseover`, `style.display`, `querySelectorAll`          | Przełączanie widocznej sekcji i koloru aktywnego przycisku |
| `paznokcie.html`                      | moduły 1 + 2                                                | Pełna strona salonu paznokci                               |
