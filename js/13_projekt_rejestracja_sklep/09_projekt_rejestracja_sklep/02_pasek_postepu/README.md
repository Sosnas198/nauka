# Kompletny przewodnik: Pasek postępu zwiększany po opuszczeniu pola formularza (zdarzenie `blur`)

Ten przewodnik tłumaczy **od A do Z**, jak działa pasek postępu, który zwiększa swoją szerokość o 12 punktów procentowych za każdym razem, gdy użytkownik "opuści" (przestanie edytować) dowolne pole formularza — z zabezpieczeniem, żeby nigdy nie przekroczyć 100%.

---

## 🎯 Cel skryptu

Za każdym razem, gdy dowolne pole tekstowe/liczbowe/telefoniczne/daty **traci fokus** (użytkownik kliknie gdzie indziej albo przejdzie do następnego pola), zwiększyć szerokość wewnętrznego bloku paska postępu o 12%, aż do maksymalnie 100%.

> ℹ️ **Uwaga:** Zgodnie z treścią zadania, ta funkcja jest **celowo uproszczona** — nie sprawdza, czy w polu faktycznie coś wpisano, czy może zostało wyczyszczone. Każda utrata fokusa (`blur`) liczy się jako "krok naprzód" w pasku postępu.

---

## SEC-1: Zmienna przechowująca aktualną wartość paska postępu

```javascript
let postepWartosc = 0;
```

### Jak to działa?

- **`let postepWartosc = 0;`** — tworzymy zmienną globalną (zdefiniowaną poza jakąkolwiek funkcją), która przechowuje **aktualną szerokość** paska postępu w procentach. Zaczynamy od `0`, bo na początku pasek jest pusty (użytkownik nie wypełnił jeszcze żadnego pola). Użyto `let`, bo ta wartość będzie się zmieniać.

---

## SEC-2: Funkcja `aktualizujPostep()` — zwiększanie paska z zabezpieczeniem przed przekroczeniem 100%

```javascript
function aktualizujPostep() {
    if (postepWartosc < 100) {
        postepWartosc += 12;
        if (postepWartosc > 100) {
            postepWartosc = 100;
        }
        document.querySelector('#postep > div').style.width = postepWartosc + '%';
    }
}
```

### Jak to działa?

- **`if (postepWartosc < 100) { ... }`** — to jest **zewnętrzne zabezpieczenie**: cały kod zwiększający pasek wykonuje się tylko wtedy, gdy pasek **nie jest jeszcze pełny**. Jeśli `postepWartosc` wynosi już `100`, funkcja nic nie robi — kolejne utraty fokusa nie mają żadnego efektu.
- **`postepWartosc += 12;`** — operator **`+=`** dodaje `12` do aktualnej wartości paska. Np. jeśli `postepWartosc` wynosiło `4`, po tej linijce będzie wynosić `16` — dokładnie zgodnie z przykładem z treści zadania (*"za pierwszym razem wartość wynosi 16%"*, co wynika z tego, że pasek startuje od 4%, ustawionego na sztywno w CSS, a nie od 0 — patrz uwaga w sekcji "Ciekawostka" niżej).
- **`if (postepWartosc > 100) { postepWartosc = 100; }`** — to jest **wewnętrzne, drugie zabezpieczenie**, tym razem chroniące przed sytuacją, w której dodanie `12` spowodowałoby **przekroczenie** 100% (np. `92 + 12 = 104`). Gdyby tak się stało, wartość jest "przycinana" z powrotem do równych `100`, zamiast pokazywać nielogiczne "104% wypełnienia".
- **`document.querySelector('#postep > div').style.width = postepWartosc + '%';`** — na końcu funkcji faktycznie **zmieniamy wygląd paska na stronie**. Selektor CSS **`'#postep > div'`** oznacza: *"znajdź element `<div>`, który jest **bezpośrednim dzieckiem** elementu o `id="postep"`"* (znak `>` w selektorze CSS oznacza właśnie relację "bezpośredni potomek", w odróżnieniu od zwykłej spacji, która oznaczałaby "dowolny potomek, na dowolnej głębokości"). To ten pusty, wewnętrzny `<div>` z kodu HTML (`<div id="postep"><div></div></div>`), którego szerokość wizualnie reprezentuje postęp.
- Łącząc liczbę `postepWartosc` z tekstem `'%'` (np. `40 + '%'` daje `'40%'`), ustawiamy właściwość CSS `width` tego wewnętrznego bloku na odpowiedni procent — im większy procent, tym szerszy (dłuższy wizualnie) pasek.

---

## SEC-3: Podpięcie zdarzenia `blur` do wszystkich odpowiednich pól formularza

```javascript
document.querySelectorAll('input[type="text"], input[type="date"], input[type="number"], input[type="tel"]').forEach(function (input) {
    input.addEventListener('blur', aktualizujPostep);
});
```

### Jak to działa?

- **`document.querySelectorAll('input[type="text"], input[type="date"], input[type="number"], input[type="tel"]')`** — metoda **`querySelectorAll()`** (w odróżnieniu od `querySelector()`, który zwraca tylko **pierwszy** pasujący element) zwraca **listę wszystkich** elementów pasujących do selektora. Tutaj selektor łączy przecinkami cztery różne typy pól: `input[type="text"]` (pola tekstowe, np. imię), `input[type="date"]` (pole daty), `input[type="number"]` (pole liczbowe, np. numer domu), `input[type="tel"]` (pole numeru telefonu). Przecinek w selektorze CSS oznacza *"lub"* — pasuje każdy element spełniający **którykolwiek** z wymienionych warunków.
- **Dlaczego nie ma tu pola `checkbox` (`rodo`)?** Bo zaznaczenie/odznaczenie checkboxa nie jest traktowane jako "wpisywanie danych do pola edycyjnego" w rozumieniu tego zadania — pasek postępu reaguje tylko na pola tekstowe/liczbowe/data/telefon.
- **`.forEach(function (input) { ... })`** — metoda `forEach()` **iteruje** (przechodzi po kolei) przez każdy element z listy zwróconej przez `querySelectorAll()`. Dla każdego pojedynczego pola (przekazanego jako parametr `input` do funkcji anonimowej) wykonujemy kod znajdujący się w środku.
- **`input.addEventListener('blur', aktualizujPostep);`** — dla **każdego** znalezionego pola podpinamy nasłuchiwacz zdarzenia **`'blur'`**. Zdarzenie `blur` (dosłownie "rozmycie", czyli "utrata ostrości/fokusa") uruchamia się dokładnie wtedy, gdy pole **przestaje być aktywne** — np. użytkownik kliknął w inne pole, nacisnął Tab, albo kliknął gdziekolwiek indziej na stronie. Gdy to nastąpi, automatycznie wywołana zostanie funkcja `aktualizujPostep` (patrz SEC-2).
- Zwróć uwagę, że tutaj przekazujemy do `addEventListener` **samą nazwę funkcji** (`aktualizujPostep`, bez nawiasów `()`) — a nie funkcję anonimową wywołującą ją w środku (jak w niektórych innych projektach z tego kursu). Jest to możliwe, bo `aktualizujPostep` nie potrzebuje żadnego dodatkowego argumentu — sama "wie", co ma zrobić, korzystając wyłącznie ze zmiennej globalnej `postepWartosc`.

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Funkcja**                | **Co oznacza / Co robi?**                                                                       |
| ---------------------------------------- | -----------------------------------------------------------------------------------------------------|
| Zdarzenie `blur`                            | Uruchamia się, gdy element (np. pole formularza) traci fokus (przestaje być aktywnie edytowany).       |
| `+=`                                          | Dodaje wskazaną wartość do istniejącej zmiennej (skrót od `zmienna = zmienna + wartość`).               |
| Podwójne zabezpieczenie zakresu (`if` zewnętrzny + `if` wewnętrzny) | Dwa niezależne warunki chroniące przed przekroczeniem górnej granicy (100%) z dwóch różnych stron problemu. |
| `querySelector('#id > tag')`                  | Znak `>` w selektorze CSS oznacza "bezpośredni potomek" — węższe dopasowanie niż zwykła spacja.        |
| `querySelectorAll('selektor1, selektor2, ...')` | Zwraca listę **wszystkich** elementów pasujących do **któregokolwiek** z selektorów oddzielonych przecinkiem. |
| `.forEach(function (element) {...})`           | Wykonuje podany kod dla **każdego** elementu z listy (np. zwróconej przez `querySelectorAll`).           |
| `addEventListener('blur', nazwaFunkcji)`        | Podpina istniejącą funkcję (bez wywoływania jej od razu) jako reakcję na zdarzenie.                     |
