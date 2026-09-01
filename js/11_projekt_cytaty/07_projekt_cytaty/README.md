# Projekt JavaScript + DOM: karuzela cytatów (jedna funkcja parametrowa + nasłuchiwacze zdarzeń)

**Słowa kluczowe:** funkcja parametrowa, porównanie ścisłe (`===`), ukrywanie/pokazywanie elementu (`style.display = 'none' / 'block'`), nasłuchiwacz zdarzenia (`addEventListener('click', ...)`), funkcja anonimowa, wzorzec cykliczny "karuzeli" (1 → 2 → 3 → 1 → ...).

Projekt uczy, jak **jedna** funkcja parametrowa może obsłużyć wiele podobnych
przypadków (kliknięcie w jeden z trzech cytatów), zamiast pisać osobną
funkcję dla każdego z nich — oraz jak podpiąć taką funkcję pod zdarzenia
kliknięcia na kilku elementach naraz. Kliknięcie w widoczny cytat ukrywa go i
pokazuje kolejny w kolejce, tworząc efekt karuzeli cyklicznie wracającej do
pierwszego cytatu. Całość jest zebrana w dwóch działających plikach:
`index.html` i `skrypt.js`. Poniżej znajdziesz **esencję każdego wzorca** —
jeśli tylko chcesz sobie przypomnieć jak coś działało, masz to tutaj.

## Struktura projektu

```text
07_projekt_cytaty/
├── index.html    -> strona: trzy cytaty, na starcie widoczny tylko pierwszy
└── skrypt.js     -> funkcja toggleQuotes() + trzy nasłuchiwacze kliknięć
```

> **Uwaga:** kod odwołuje się do plików `styl.css`, `logo.png`, `osoba1.jpg`,
> `osoba2.jpg` i `osoba3.jpg`, których nie było w treści zadania — trzeba je
> samodzielnie dodać, żeby strona wyglądała poprawnie. Na starcie tylko
> pierwszy cytat jest widoczny — pozostałe dwa mają `style="display: none;"`
> ustawione na stałe w HTML.

---

## Ściągawka wzorców

### 1. Jedna funkcja obsługująca wszystkie trzy przypadki

```javascript
function toggleQuotes(clickedId) {
  const quote1 = document.getElementById("osoba1");
  const quote2 = document.getElementById("osoba2");
  const quote3 = document.getElementById("osoba3");

  if (clickedId === "osoba1") {
    quote1.style.display = "none";
    quote2.style.display = "block";
  } else if (clickedId === "osoba2") {
    quote2.style.display = "none";
    quote3.style.display = "block";
  } else if (clickedId === "osoba3") {
    quote3.style.display = "none";
    quote1.style.display = "block";
  }
}
```

Funkcja przyjmuje parametr `clickedId` — identyfikator klikniętego cytatu —
dzięki czemu jedna funkcja obsługuje wszystkie trzy przypadki, zamiast trzech
niemal identycznych funkcji. Na początku pobierane są wszystkie trzy
kontenery cytatów naraz, niezależnie od tego, który akurat został kliknięty.
`===` to porównanie ścisłe (sprawdza wartość **i** typ) — bezpieczniejsze niż
`==`. Każda gałąź robi dokładnie dwie rzeczy: ukrywa kliknięty cytat
(`display = 'none'`) i pokazuje następny w kolejce (`display = 'block'`).
Cykliczność widać w ostatniej gałęzi — po kliknięciu w cytat 3 z powrotem
pokazywany jest cytat 1, zamykając pętlę 1 → 2 → 3 → 1 → ...

### 2. Nasłuchiwanie kliknięć na każdym cytacie

```javascript
document.getElementById("osoba1").addEventListener("click", function () {
  toggleQuotes("osoba1");
});
document.getElementById("osoba2").addEventListener("click", function () {
  toggleQuotes("osoba2");
});
document.getElementById("osoba3").addEventListener("click", function () {
  toggleQuotes("osoba3");
});
```

`addEventListener('click', funkcja)` podpina do elementu nasłuchiwacz, który
wykonuje się automatycznie przy każdym kliknięciu w ten element. Druga
przekazana wartość to funkcja anonimowa (bez własnej nazwy) — jej jedynym
zadaniem jest wywołanie `toggleQuotes()` z identyfikatorem elementu, do
którego akurat jest podpięta. Ten sam wzorzec powtórzony trzykrotnie —
osobno dla każdego cytatu — sprawia, że kliknięcie w którykolwiek z nich
uruchamia tę samą funkcję, tylko z innym parametrem.

---

## Tabela referencyjna

| Pojęcie / funkcja                               | Co robi                                                                     |
| ----------------------------------------------- | --------------------------------------------------------------------------- |
| Funkcja parametrowa (`toggleQuotes(clickedId)`) | Jeden blok kodu obsługujący wiele przypadków dzięki argumentowi wejściowemu |
| `===` (porównanie ścisłe)                       | Sprawdza wartość **i** typ danych naraz                                     |
| `style.display = 'none'`                        | Ukrywa element — nie zajmuje miejsca na stronie                             |
| `style.display = 'block'`                       | Pokazuje element jako blok, zajmujący całą dostępną szerokość               |
| `addEventListener('click', funkcja)`            | Podpina funkcję wykonującą się automatycznie przy kliknięciu w element      |
| Funkcja anonimowa (`function() {...}`)          | Funkcja bez nazwy, zdefiniowana bezpośrednio jako argument                  |
| Wzorzec "karuzeli" (1 → 2 → 3 → 1 → ...)        | Cykliczne przełączanie, gdzie ostatni element wraca do pierwszego           |
