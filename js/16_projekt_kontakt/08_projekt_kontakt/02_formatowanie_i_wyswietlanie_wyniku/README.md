# Kompletny przewodnik: Budowanie trzywierszowego komunikatu z danymi kontaktowymi

Ta ściąga wytłumaczy Ci **od A do Z**, jak JavaScript sklejał gotowy komunikat z imienia, nazwiska, adresu email (zawsze zapisanego małymi literami) oraz wybranej usługi, i jak wyświetla go w trzech osobnych wierszach.

---

## SEC-1: Budowa i wyświetlenie komunikatu (`toLowerCase`, `<br>`, `innerHTML`)

```javascript
wynik.innerHTML = "<p>" + imie + " " + nazwisko + "<br>" + email.toLowerCase() + "<br>Usługa: " + zgloszenie + "</p>";
```

### Jak to działa? Rozłóżmy tę linijkę na kawałki

Cała ta linijka to jedno, długie sklejenie (konkatenacja) wielu fragmentów tekstu i wartości zmiennych, operatorem `+`. Przeanalizujmy to część po części, w kolejności, w jakiej pojawiają się w finalnym komunikacie:

1. **`"<p>"`** – otwiera znacznik akapitu, w którym zmieści się cały komunikat.
2. **`imie + " " + nazwisko`** – sklejamy imię, spację i nazwisko w jeden ciąg, np. `"Jan Kowalski"`. To odpowiada wymaganiu: *"imię i nazwisko"* w pierwszym wierszu.
3. **`"<br>"`** – znacznik HTML oznaczający **złamanie linii** (*break*), czyli przejście do nowej linii bez zaczynania nowego akapitu. To właśnie dzięki `<br>` komunikat wyświetla się w **trzech osobnych wierszach**, mimo że cały tekst jest technicznie jednym akapitem `<p>`.
4. **`email.toLowerCase()`** – tutaj realizujemy kluczowe wymaganie zadania: *"adres email – zapisany zawsze małymi literami"*. Metoda **`.toLowerCase()`** jest wbudowana w każdy tekst (string) w JavaScript i zwraca jego kopię, w której **wszystkie wielkie litery zamieniono na małe** (np. `"Jan.Kowalski@Firma.PL"` stanie się `"jan.kowalski@firma.pl"`). Ważne: ta metoda **nie zmienia** oryginalnej zmiennej `email` — zwraca nową wartość, którą od razu wstawiamy do komunikatu, niezależnie od tego, jak użytkownik faktycznie wpisał swój adres (małymi, wielkimi, czy mieszanymi literami).
5. **`"<br>"`** – kolejne złamanie linii, przed trzecim wierszem.
6. **`"Usługa: " + zgloszenie`** – sklejamy stały tekst `"Usługa: "` z wartością wybraną przez użytkownika z listy rozwijanej (np. `"naprawa komputerów"`). To odpowiada dokładnie wymaganiu: *"napis «Usługa: », następnie wartość wybranego pola listy rozwijalnej"*.
7. **`"</p>"`** – zamyka akapit.

- **`wynik.innerHTML = ...`** – tak zbudowany, kompletny tekst (z wplecionymi znacznikami `<p>` i `<br>`) wstawiamy do elementu `wynik` (pobranego w module 01) za pomocą `.innerHTML`. Używamy właśnie `.innerHTML`, a nie np. `.textContent`, ponieważ potrzebujemy, żeby przeglądarka **zinterpretowała** znaczniki `<p>` i `<br>` jako prawdziwe elementy HTML (podział na wiersze), a nie wyświetliła je jako zwykły, widoczny tekst.

> **Efekt końcowy na stronie**, dla przykładowych danych `imie = "Jan"`, `nazwisko = "Kowalski"`, `email = "Jan.Kowalski@Firma.PL"`, `zgloszenie = "wirusy"`:
> ```
> Jan Kowalski
> jan.kowalski@firma.pl
> Usługa: wirusy
> ```

---

# Podsumowanie przepływu danych

```text
SEC-1: wynik.innerHTML =
           "<p>" + imie + " " + nazwisko +
           "<br>" + email.toLowerCase() +
           "<br>Usługa: " + zgloszenie + "</p>"
       — Sklejenie trzech wierszy komunikatu (z emailem zamienionym na małe litery)
       i wstawienie ich do elementu wynikowego na stronie
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Metoda**    | **Co oznacza / Co robi?**                                                                 |
| ---------------------------- | --------------------------------------------------------------------------------------------- |
| **operator `+` (sklejanie)**  | Łączy ze sobą kawałki tekstu i wartości zmiennych w jeden ciąg znaków.                         |
| **`.toLowerCase()`**          | Zwraca kopię tekstu z wszystkimi literami zamienionymi na małe (nie zmienia oryginału).        |
| **`<br>`**                    | Znacznik HTML wymuszający przejście do nowej linii, bez zaczynania nowego akapitu.              |
| **`.innerHTML`**              | Ustawia zawartość elementu, interpretując wstawione znaczniki HTML (np. `<br>`) jako prawdziwe elementy, a nie zwykły tekst. |
