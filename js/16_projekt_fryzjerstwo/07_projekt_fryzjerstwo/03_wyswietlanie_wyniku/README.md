# Kompletny przewodnik: Wyświetlenie wyliczonej ceny promocyjnej na stronie

Ta ściąga wytłumaczy Ci **od A do Z**, jak JavaScript wstawia gotowy wynik (obliczoną w module 02 cenę promocyjną) do paragrafu na stronie, w formacie wymaganym przez zadanie.

---

## SEC-1: Wstawienie wyniku do paragrafu (`innerHTML`)

```javascript
wynik.innerHTML = "<p>cena promocyjna: " + cena + "</p>";
```

### Jak to działa?

- **`wynik`** – to zmienna z modułu 01, przechowująca element `<p id="wynik"></p>`, czyli miejsce na stronie, w którym ma się pojawić wynik.
- **`.innerHTML = ...`** – ustawia **całą zawartość** tego elementu na podaną wartość. Dzięki `.innerHTML` (a nie np. `.textContent`) możemy wstawić nie tylko czysty tekst, ale też dodatkowe znaczniki HTML.
- **`"<p>cena promocyjna: " + cena + "</p>"`** – budujemy tekst wyniku, sklejając (operatorem `+`) trzy fragmenty:
  - **`"<p>cena promocyjna: "`** – stały, niezmienny początek tekstu, dokładnie zgodny z wymaganym wzorem z treści zadania.
  - **`cena`** – zmienna z modułu 02, zawierająca wyliczoną liczbę (np. `15`, `20`, `30` albo `40`, w zależności od wybranej opcji). Doklejenie liczby do tekstu operatorem `+` automatycznie zamienia tę liczbę na tekst przy sklejaniu.
  - **`"</p>"`** – zamyka znacznik akapitu.
- Efekt końcowy: wewnątrz elementu `<p id="wynik">` pojawia się **kolejny, zagnieżdżony** znacznik `<p>` z treścią np. `cena promocyjna: 15`. Choć umieszczenie `<p>` wewnątrz innego `<p>` nie jest zgodne z formalnymi zasadami HTML (paragrafy nie powinny się zagnieżdżać), przeglądarki i tak wyświetlą to poprawnie — dlatego kod działa bez problemu, mimo tej drobnej nieścisłości.

> **Skąd wiadomo, że ta linijka wykona się po module 02?** Ponieważ w oryginalnej, pełnej funkcji `odkryj()` ten fragment kodu znajduje się **na samym końcu** — a JavaScript wykonuje instrukcje w kolejności, w jakiej są zapisane. Zanim dojdzie do tej linijki, zmienna `cena` ma już przypisaną właściwą wartość (ustaloną w module 02, na podstawie zaznaczonego przycisku radio).

---

# Podsumowanie przepływu danych

```text
SEC-1: wynik.innerHTML = "<p>cena promocyjna: " + cena + "</p>"
       — Wstawienie gotowego tekstu z wyliczoną ceną do paragrafu na stronie
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Metoda**   | **Co oznacza / Co robi?**                                                              |
| -------------------------- | -------------------------------------------------------------------------------------------- |
| **`.innerHTML`**            | Ustawia zawartość elementu HTML, z możliwością wstawienia dodatkowych znaczników.             |
| **operator `+` (sklejanie)**| Łączy ze sobą kawałki tekstu i wartości zmiennych w jeden ciąg znaków.                        |
