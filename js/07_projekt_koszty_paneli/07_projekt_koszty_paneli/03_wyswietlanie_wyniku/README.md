> **Krok 3 z 3** | [Krok 2](../02_obliczanie_pola_i_kosztu/README.md) obliczył pole i koszt. Teraz **Skrypt (część 3)**: sformatowanie i wyświetlenie wyniku w paragrafie.

---

# Kompletny przewodnik: Skrypt (część 3) — wyświetlenie wyniku (szablon literałów, `textContent`)

---

## Wprowadzenie — o co chodzi w tej części zadania?

To ostatni, najkrótszy etap całego skryptu — mamy już policzone pole powierzchni (Moduł 2, SEC-1) i koszt montażu (Moduł 2, SEC-3), więc pozostaje tylko złożyć z nich czytelny komunikat i pokazać go użytkownikowi w paragrafie pod przyciskiem „Oblicz”. Arkusz bardzo dokładnie precyzuje, jak ten komunikat ma wyglądać — dlatego warto zwrócić uwagę na dokładną treść i interpunkcję poniższego kodu.

---

## SEC-1: Zbudowanie i wyświetlenie komunikatu z wynikiem

Arkusz: w paragrafie pod przyciskiem skrypt wyświetla napis „Pole powierzchni pomieszczenia: `<pole>`, koszt montażu `<koszt>`”, gdzie pola w nawiasach oznaczają wartości obliczone skryptem.

```js
wynik.textContent = `Pole powierzchni pomieszczenia: ${pole} m², koszt montażu ${koszt} zł`;
```

- Znaki `` ` `` (tzw. backticki, a nie zwykłe cudzysłowy) tworzą w JavaScripcie **szablon literału** (ang. *template literal*) — specjalny rodzaj tekstu, do którego można "wstrzykiwać" wartości zmiennych bezpośrednio wewnątrz tekstu, bez konieczności "sklejania" go operatorem `+`.
- **`${pole}`** oraz **`${koszt}`** — to właśnie ten mechanizm wstrzykiwania: w miejscu `${...}` JavaScript automatycznie wstawia aktualną wartość podanej zmiennej. `${pole}` zostanie zastąpione obliczonym wcześniej polem powierzchni (Moduł 2, SEC-1), a `${koszt}` — obliczonym kosztem montażu (Moduł 2, SEC-3). Bez szablonów literałów trzeba by to zapisać znacznie bardziej "toporowo", np. `"Pole powierzchni pomieszczenia: " + pole + " m², koszt montażu " + koszt + " zł"` — efekt końcowy byłby identyczny, ale zapis z backtickami jest znacznie czytelniejszy.
- Zwróć uwagę na jednostki dopisane "na sztywno" wewnątrz szablonu: `m²` zaraz po wartości pola powierzchni oraz `zł` zaraz po wartości kosztu — to stałe fragmenty tekstu, niezależne od żadnej zmiennej, dodane po to, żeby wynik był zrozumiały dla użytkownika (sama liczba `20` nic by mu nie powiedziała bez jednostki).
- **`wynik.textContent = ...`** — ustawiamy tak zbudowany tekst jako zawartość paragrafu `<p id="wynik">` (pobranego jeszcze w Module 1, SEC-1). Używamy tu `textContent`, a nie `innerHTML`, ponieważ ten komunikat nie zawiera żadnych znaczników HTML do zinterpretowania — jest to czysty, zwykły tekst (w przeciwieństwie np. do wcześniej widzianego znacznika `<sub>` w innych projektach, gdzie potrzebne było `innerHTML`).

Po wykonaniu tej linijki użytkownik zobaczy na stronie dokładnie taki komunikat, jakiego wymaga arkusz — np. dla pomieszczenia 4×5 metrów z panelami laminowanymi: „Pole powierzchni pomieszczenia: 20 m², koszt montażu 240 zł”.

---

🏠 **[Spis treści](../README.md)**
