# Kompletny przewodnik: Karuzela cytatów sterowana kliknięciem (jedna funkcja parametrowa + nasłuchiwacze zdarzeń)

Ten przewodnik tłumaczy **od A do Z**, jak działa skrypt przełączający trzy cytaty pracowników — kliknięcie w widoczny cytat ukrywa go i pokazuje kolejny w kolejce, tworząc efekt "karuzeli" cyklicznie wracającej do pierwszego cytatu.

---

## 📁 Zawartość projektu

```text
07_projekt_cytaty/
│
├── README.md         ← ten plik, teoria krok po kroku
├── index.html         ← pełny, oryginalny plik HTML
└── skrypt.js           ← pełny, oryginalny plik JS
```

> ⚠️ **Uwaga:** Kod odwołuje się do plików `styl.css`, `logo.png`, `osoba1.jpg`, `osoba2.jpg` i `osoba3.jpg`, których nie było w treści zadania — musisz sam dodać je do folderu, aby strona wyglądała poprawnie.

---

## 🎯 Cel skryptu

Na stronie widoczny jest w danym momencie **tylko jeden** z trzech cytatów (pozostałe dwa są ukryte przez `style="display: none;"` wpisane na stałe w HTML). Kliknięcie w widoczny cytat ma:
1. ukryć **ten** cytat, w który kliknięto,
2. pokazać **kolejny** cytat w cyklicznej kolejności: cytat 1 → cytat 2 → cytat 3 → z powrotem cytat 1.

> **Główna idea:**
> **KLIKNIĘCIE → ROZPOZNAJ, KTÓRY CYTAT KLIKNIĘTO → UKRYJ TEN CYTAT → POKAŻ NASTĘPNY W KOLEJCE**

---

## SEC-1: Jedna funkcja obsługująca wszystkie trzy przypadki (`toggleQuotes`)

```javascript
function toggleQuotes(clickedId) {
    const quote1 = document.getElementById('osoba1');
    const quote2 = document.getElementById('osoba2');
    const quote3 = document.getElementById('osoba3');

    if (clickedId === 'osoba1') {
        quote1.style.display = 'none';
        quote2.style.display = 'block';
    } else if (clickedId === 'osoba2') {
        quote2.style.display = 'none';
        quote3.style.display = 'block';
    } else if (clickedId === 'osoba3') {
        quote3.style.display = 'none';
        quote1.style.display = 'block';
    }
}
```

### Jak to działa?

- **`function toggleQuotes(clickedId) { ... }`** — to jest **funkcja parametrowa**, czyli funkcja, która przyjmuje jeden argument wejściowy — tutaj nazwany `clickedId`. Dzięki temu **jedna** funkcja potrafi obsłużyć wszystkie trzy przypadki (kliknięcie w cytat 1, 2 lub 3), zamiast pisać trzy osobne, niemal identyczne funkcje. To właśnie ten wariant, o którym wspomniano w treści zadania: *"Skrypt może być zorganizowany w dowolny sposób, może być to jedna funkcja parametrowa lub trzy osobne dla każdego cytatu"*.
- **`const quote1 = document.getElementById('osoba1');`** (i analogicznie `quote2`, `quote3`) — na początku funkcji pobieramy **wszystkie trzy** kontenery cytatów (elementy `<div id="osoba1">`, `<div id="osoba2">`, `<div id="osoba3">`) i zapisujemy je w osobnych zmiennych. Robimy to za każdym razem, gdy funkcja jest wywoływana, żeby mieć do nich dostęp niezależnie od tego, który cytat został kliknięty.
- **`if (clickedId === 'osoba1') { ... }`** — sprawdzamy, **który konkretnie** cytat został kliknięty, porównując przekazany parametr `clickedId` z identyfikatorem `'osoba1'`. Operator **`===`** to porównanie **ścisłe** (sprawdza zarówno wartość, jak i typ danych) — dobra praktyka w JavaScript, bezpieczniejsza niż zwykłe `==`.
- Wewnątrz każdego bloku `if`/`else if` dzieją się dokładnie **dwie rzeczy**:
  1. **`quoteN.style.display = 'none';`** — ukrywamy cytat, który został kliknięty, ustawiając jego właściwość CSS `display` na `'none'` (czyli "nie wyświetlaj tego elementu wcale — zajmuje zero miejsca na stronie").
  2. **`quoteN+1.style.display = 'block';`** — pokazujemy **kolejny** cytat w kolejce, ustawiając jego `display` na `'block'` (czyli "wyświetl ten element jako blok", czyli normalnie, zajmując całą dostępną szerokość).
- **Cykliczność karuzeli** widać najlepiej w ostatnim bloku (`clickedId === 'osoba3'`): po kliknięciu w **trzeci** cytat, ukrywany jest cytat 3, ale pokazywany jest **z powrotem cytat 1** (`quote1.style.display = 'block';`) — zamykając cały cykl w pętlę: 1 → 2 → 3 → 1 → 2 → 3 → ...

---

## SEC-2: Nasłuchiwanie kliknięć na każdym z trzech cytatów (`addEventListener`)

```javascript
document.getElementById('osoba1').addEventListener('click', function() {
    toggleQuotes('osoba1');
});
document.getElementById('osoba2').addEventListener('click', function() {
    toggleQuotes('osoba2');
});
document.getElementById('osoba3').addEventListener('click', function() {
    toggleQuotes('osoba3');
});
```

### Jak to działa?

- **`document.getElementById('osoba1')`** — pobieramy kontener pierwszego cytatu.
- **`.addEventListener('click', function() { ... })`** — metoda **`addEventListener`** "podpina" do elementu **nasłuchiwacz zdarzenia** (*event listener*). Pierwszy argument, `'click'`, mówi, na jaki rodzaj zdarzenia mamy reagować (tutaj: kliknięcie myszką). Drugi argument to **funkcja**, która wykona się **za każdym razem**, gdy to zdarzenie nastąpi (czyli za każdym kliknięciem w ten element).
- **`function() { toggleQuotes('osoba1'); }`** — to tzw. **funkcja anonimowa** (bez własnej nazwy), przekazana bezpośrednio jako argument do `addEventListener`. Jej jedynym zadaniem jest wywołanie naszej głównej funkcji `toggleQuotes()`, przekazując jej **informację o tym, który konkretnie element został kliknięty** — w tym przypadku na stałe `'osoba1'`, bo ten konkretny nasłuchiwacz jest podpięty właśnie do elementu `osoba1`.
- Ten sam wzorzec (pobierz element → podepnij nasłuchiwacz → w środku wywołaj `toggleQuotes` z odpowiednim identyfikatorem) powtórzony jest **trzykrotnie** — raz dla każdego z trzech cytatów. Dzięki temu kliknięcie w **którykolwiek** z trzech cytatów uruchomi tę samą funkcję `toggleQuotes()`, tylko z innym parametrem, co pozwala jednej funkcji poprawnie zareagować na każdy z trzech możliwych przypadków.

---

## 🧩 Cały mechanizm krok po kroku

```text
1. Strona ładuje się — widoczny jest tylko cytat #1 (pozostałe mają display: none w HTML)
              ↓
2. Użytkownik klika w widoczny cytat (np. cytat #1)
              ↓
3. Uruchamia się nasłuchiwacz addEventListener podpięty do osoba1
              ↓
4. Wywołanie: toggleQuotes('osoba1')
              ↓
5. Wewnątrz funkcji: if (clickedId === 'osoba1')
              ↓
6. quote1.style.display = 'none'   (ukryj cytat #1)
   quote2.style.display = 'block'  (pokaż cytat #2)
              ↓
7. Użytkownik widzi teraz cytat #2 i może w niego kliknąć,
   co uruchomi ten sam mechanizm dla 'osoba2' → pokaże cytat #3
              ↓
8. Kliknięcie w cytat #3 → z powrotem pokazuje cytat #1 (cykl się zamyka)
```

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Funkcja**              | **Co oznacza / Co robi?**                                                                          |
| -------------------------------------- | -------------------------------------------------------------------------------------------------------|
| Funkcja parametrowa                     | Funkcja przyjmująca argument (tu: `clickedId`), dzięki czemu jeden blok kodu obsługuje wiele przypadków. |
| `===` (porównanie ścisłe)                | Sprawdza, czy dwie wartości są sobie równe **i** mają ten sam typ danych.                                |
| `style.display = 'none'`                 | Ukrywa element całkowicie — nie zajmuje miejsca na stronie.                                              |
| `style.display = 'block'`                | Pokazuje element jako blok — zajmuje całą dostępną szerokość, tak jak zwykły `<div>`.                     |
| `addEventListener('click', funkcja)`      | Podpina funkcję, która wykona się automatycznie za każdym kliknięciem w dany element.                     |
| Funkcja anonimowa (`function() {...}`)    | Funkcja bez własnej nazwy, zdefiniowana bezpośrednio w miejscu, gdzie jest używana (tu: jako argument `addEventListener`). |
| Wzorzec "karuzeli" (1 → 2 → 3 → 1 → ...)   | Cykliczne przełączanie między elementami, gdzie ostatni element "zawija się" z powrotem do pierwszego.    |
