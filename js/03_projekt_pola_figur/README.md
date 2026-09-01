# Projekt JavaScript + DOM: pola figur (trójkąt / prostokąt)

**Słowa kluczowe:** obsługa kliknięcia (`onclick`), zmiana źródła obrazu (`.src`), pobranie elementu (`getElementById`), konwersja na liczbę (`Number()`), sprawdzenie fragmentu tekstu (`.includes()`), warunkowy wybór wzoru pola, wypisanie wyniku (`textContent`).

Projekt uczy dwóch powiązanych wzorców: podmiany dużego obrazu po kliknięciu
miniatury oraz obliczenia pola figury na podstawie tego, **jaki obraz jest
akurat wyświetlony** — bez osobnej zmiennej trzymającej wybraną figurę, tylko
przez odczytanie bieżącego `src`. Całość jest zebrana w jednym pliku
`skrypt.js`, dołączanym do `index.html`. Poniżej znajdziesz **esencję każdego
wzorca** — jeśli tylko chcesz sobie przypomnieć jak coś działało, masz to
tutaj. Pełne, powolne tłumaczenie "od zera" (z podziałem na sekcje SEC-1,
SEC-2...) znajduje się w README każdego podfolderu.

## Struktura projektu

```text
03_projekt_pola_figur/
├── 01_zmiana_obrazow_dom/           -> klik miniatury zmienia duży obraz
├── 02_obliczenia_geometria_dom/     -> odczyt a, b + wybór wzoru pola
├── skrypt.js                        -> moduł 1 + moduł 2 razem
├── index.html                       -> strona: trójkąt/prostokąt + pole
└── kolo.html                        -> druga podstrona menu (bez skryptów z arkusza)
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.js`
(czysta implementacja wzorca, z komentarzami odsyłającymi do konkretnych
sekcji README). `skrypt.js` łączy oba wzorce i jest dołączany do
`index.html`. Zdarzenia są podpięte bezpośrednio w HTML przez `onclick="..."`
— nie przez `addEventListener` — zgodnie z wymaganiami arkusza.

---

## Ściągawka wzorców

### 1. Zmiana dużego obrazu po kliknięciu miniatury

```javascript
function wybierzTrojkat() {
  document.getElementById("duzyObraz").src = "1d.bmp";
}

function wybierzProstokat() {
  document.getElementById("duzyObraz").src = "2d.bmp";
}
```

Każda funkcja odpowiada jednej miniaturze (`onclick="wybierzTrojkat()"` /
`onclick="wybierzProstokat()"` w HTML) i po prostu podmienia atrybut `.src`
tego samego elementu `<img id="duzyObraz">` na inny plik graficzny. Stan
początkowy strony to `src="1d.bmp"` — czyli trójkąt — jeszcze zanim
użytkownik cokolwiek kliknie.

→ Pełne wytłumaczenie: [`01_zmiana_obrazow_dom/README.md`](./01_zmiana_obrazow_dom/README.md)

### 2. Obliczenie pola na podstawie aktualnego obrazu

```javascript
function obliczPole() {
  const a = Number(document.getElementById("a").value);
  const b = Number(document.getElementById("b").value);
  const src = document.getElementById("duzyObraz").src;

  let pole;
  if (src.includes("2d.bmp")) {
    pole = a * b;
  } else {
    pole = (a * b) / 2;
  }

  document.getElementById("wynik").textContent = pole;
}
```

`Number()` zamienia tekstowe wartości pól `a` i `b` na liczby, na których
można wykonywać działania matematyczne. Kluczowy trik: skrypt **nie**
pamięta, którą figurę wybrał użytkownik w osobnej zmiennej — zamiast tego
sprawdza `.includes("2d.bmp")` na aktualnym `src` dużego obrazu. Jeśli
wyświetlony jest prostokąt (`2d.bmp`), liczone jest pole `a * b`; w każdym
innym przypadku — również w stanie początkowym, gdy nic jeszcze nie
kliknięto — liczone jest pole trójkąta `(a * b) / 2`. Wynik trafia do
elementu `#wynik` przez `textContent`.

→ Pełne wytłumaczenie: [`02_obliczenia_geometria_dom/README.md`](./02_obliczenia_geometria_dom/README.md)

---

## Tabela referencyjna

| Plik / moduł                  | Kluczowa funkcja                                 | Do czego służy                                              |
| ----------------------------- | ------------------------------------------------ | ----------------------------------------------------------- |
| `01_zmiana_obrazow_dom`       | `.src`, `onclick`, `getElementById("duzyObraz")` | Podmiana dużego obrazu po kliknięciu miniatury              |
| `02_obliczenia_geometria_dom` | `Number()`, `.includes("2d.bmp")`, `textContent` | Wybór wzoru pola i wypisanie wyniku                         |
| `skrypt.js`                   | moduł 1 + 2                                      | Skrypt strony głównej                                       |
| `index.html`                  | miniatury + pola `a`/`b` + `#wynik`              | Strona z arkusza                                            |
| `kolo.html`                   | drugi link w menu                                | Podstrona okręgu i koła (nawigacja, bez skryptów z arkusza) |
