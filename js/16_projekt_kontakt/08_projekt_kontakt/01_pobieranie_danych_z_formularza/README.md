# Kompletny przewodnik: Pobieranie wartości wpisanych w formularzu kontaktowym

Ta ściąga wytłumaczy Ci **od A do Z**, jak JavaScript odczytuje wszystko, co użytkownik wpisał lub wybrał w formularzu kontaktowym (imię, nazwisko, email, rodzaj zgłoszenia), zanim zbuduje z tego gotową wiadomość.

---

## SEC-1: Pobranie wartości z pól tekstowych i listy rozwijanej

```javascript
let imie = document.getElementById("imie").value;
let nazwisko = document.getElementById("nazwisko").value;
let email = document.getElementById("email").value;
let zgloszenie = document.getElementById("zgloszenie").value;
```

### Jak to działa?

- **`document.getElementById("imie")`** – wyszukuje w HTML pole `<input type="text" id="imie" name="imie">` po jego identyfikatorze `id="imie"`.
- **`.value`** – pobiera z tego pola aktualnie wpisaną wartość (tekst).
- **`let imie = ...`** – zapisujemy tę wartość do zmiennej `imie`, o nazwie jasno mówiącej, co przechowuje.
- Dokładnie w ten sam sposób pobieramy pozostałe trzy wartości:
  - **`nazwisko`** – z pola `<input type="text" id="nazwisko">`,
  - **`email`** – z pola `<input type="email" id="email">` (typ `email` w HTML podpowiada przeglądarce, żeby zweryfikowała format adresu, ale w JavaScript i tak odczytujemy go tą samą metodą `.value`, jako zwykły tekst),
  - **`zgloszenie`** – z listy rozwijanej `<select id="zgloszenie">`. Dla znacznika `<select>`, `.value` zwraca wartość **aktualnie wybranej opcji** — czyli zawartość atrybutu `value` z tego `<option>`, który jest w danej chwili zaznaczony (np. `"naprawa komputerów"`, jeśli użytkownik wybrał właśnie tę opcję z listy).

---

## SEC-2: Pobranie elementu, w którym pojawi się wynik

```javascript
let wynik = document.getElementById("wynik");
```

### Jak to działa?

- **`document.getElementById("wynik")`** – wyszukuje znacznik `<p id="wynik"></p>`, znajdujący się na stronie pod poziomą linią (`<hr>`) — to właśnie tam, zgodnie z wymaganiami zadania, ma pojawić się gotowy komunikat.
- Tym razem zapisujemy **cały element** (a nie jego `.value`) do zmiennej `wynik`, ponieważ w kolejnym module będziemy chcieli **ustawić jego zawartość** (a nie odczytać z niego coś, co wpisał użytkownik — to pole nie jest formularzem, tylko miejscem na wyświetlenie wyniku).

---

# Podsumowanie przepływu danych

```text
SEC-1: imie, nazwisko, email, zgloszenie = document.getElementById(...).value
       — Odczytanie wszystkiego, co użytkownik wpisał/wybrał w formularzu
                 ↓
SEC-2: wynik = document.getElementById("wynik")
       — Pobranie elementu, w którym wyświetlimy gotowy komunikat
                 ↓
       (dalej: moduł 02 — sformatowanie danych i wyświetlenie komunikatu)
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Metoda**         | **Co oznacza / Co robi?**                                                              |
| -------------------------------- | --------------------------------------------------------------------------------------------- |
| **`document.getElementById()`**  | Pobiera konkretny element z dokumentu HTML po jego atrybucie `id`.                             |
| **`.value` (pole tekstowe)**      | Pobiera aktualnie wpisany przez użytkownika tekst.                                             |
| **`.value` (lista `<select>`)**  | Pobiera wartość (`value`) aktualnie wybranej opcji `<option>`.                                 |
