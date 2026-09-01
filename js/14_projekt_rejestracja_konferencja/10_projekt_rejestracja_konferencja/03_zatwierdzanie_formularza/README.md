# Kompletny przewodnik: Porównanie haseł i powitanie użytkownika w konsoli (szablon literału)

Ten przewodnik tłumaczy **od A do Z**, jak przycisk "Zatwierdź" w trzecim bloku formularza sprawdza, czy oba wpisane hasła są identyczne, i — jeśli tak — wypisuje w konsoli powitanie zbudowane z imienia i nazwiska pobranych z **pierwszego** bloku formularza.

---

## 🎯 Cel skryptu

Po kliknięciu przycisku `submit`, porównać wartości dwóch pól haseł. Jeśli **różnią się** — pokazać okienko z komunikatem "Podane hasła różnią się". Jeśli są **identyczne** — pobrać imię i nazwisko (wpisane wcześniej, w zupełnie innym bloku formularza) i wypisać w konsoli powitanie w formacie "Witaj [imię] [nazwisko]".

---

## SEC-1: Pobranie wartości haseł oraz danych osobowych z pierwszego bloku

```javascript
document.getElementById('submit').addEventListener('click', function() {
    const haslo1 = document.getElementById('haslo1').value;
    const haslo2 = document.getElementById('haslo2').value;
    const imie = document.getElementById('imie').value;
    const nazwisko = document.getElementById('nazwisko').value;
    // ...
});
```

### Jak to działa?

- **`document.getElementById('submit').addEventListener('click', function() { ... })`** — podpinamy nasłuchiwacz kliknięcia do przycisku "Zatwierdź" (`id="submit"`), znajdującego się w trzecim bloku formularza.
- **`const haslo1 = ...` / `const haslo2 = ...`** — odczytujemy wartości obu pól haseł z **trzeciego** bloku (`form3`), w którym aktualnie znajduje się użytkownik.
- **`const imie = ...` / `const nazwisko = ...`** — tutaj dzieje się coś ciekawego: te dwie zmienne odczytują pola **`imie`** i **`nazwisko`**, które fizycznie znajdują się w **pierwszym** bloku formularza (`form1`), a nie w tym, w którym użytkownik właśnie kliknął przycisk! Jest to możliwe z tego samego powodu, o którym wspomniano w innych projektach tego kursu: **ukrycie karty przez `classList.remove('active')` nie usuwa jej zawartości** — wartości wpisane wcześniej w polach `imie` i `nazwisko` pozostają dostępne przez cały czas trwania sesji na stronie, niezależnie od tego, która karta jest aktualnie widoczna.

---

## SEC-2: Porównanie haseł i rozgałęzienie logiki (`if`/`else`)

```javascript
if (haslo1 === haslo2) {
    // ... (patrz SEC-3)
}
else {
    alert('Podane hasła różnią się');
}
```

### Jak to działa?

- **`if (haslo1 === haslo2)`** — porównujemy oba hasła operatorem **ścisłej równości** `===` (sprawdzającym zarówno wartość, jak i typ danych — choć tutaj oba pola i tak zwracają tekst, więc różnica praktyczna względem `==` jest niewielka, ale `===` to zalecana, bezpieczniejsza praktyka).
- Jeśli hasła są **identyczne** — przechodzimy do sekcji powitania (SEC-3).
- Jeśli hasła **różnią się** — wykonuje się blok `else`, wyświetlający `alert('Podane hasła różnią się');` — dokładnie ten komunikat, który był wymagany w treści zadania.

---

## SEC-3: Wypisanie powitania w konsoli za pomocą szablonu literału

```javascript
console.log(`Witaj ${imie} ${nazwisko}`);
alert('Formularz zakończony');
```

### Jak to działa?

- **`` `Witaj ${imie} ${nazwisko}` ``** — to **szablon literału** (tekst otoczony znakami `` ` ``, tzw. *backtick*), w którym `${imie}` i `${nazwisko}` zostają automatycznie zastąpione aktualnymi wartościami tych zmiennych. Jeśli np. `imie` to `"Anna"`, a `nazwisko` to `"Kowalska"`, końcowy tekst będzie brzmiał: `"Witaj Anna Kowalska"`.
- **`console.log(...)`** — wypisuje ten tekst w konsoli przeglądarki, dokładnie zgodnie z wymaganiem zadania: *"wyświetlone w konsoli jako napis o treści »Witaj [imię] [nazwisko]«"*.
- **`alert('Formularz zakończony');`** — dodatkowo (choć nie było to jawnie wymagane w treści zadania dla tego konkretnego komunikatu, to naturalne uzupełnienie procesu) wyświetlane jest okienko informujące użytkownika, że cały, wieloetapowy formularz został pomyślnie ukończony.

---

## 🧩 Cały mechanizm krok po kroku

```text
1. Użytkownik wypełnił formularz na wszystkich trzech kartach i klika "Zatwierdź"
              ↓
2. Odczyt haslo1, haslo2 (z bieżącej, trzeciej karty)
   Odczyt imie, nazwisko (z pierwszej karty — nadal dostępne mimo że ukryta)
              ↓
3. if (haslo1 === haslo2)
              ↓                              ↓
          PRAWDA                            FAŁSZ
              ↓                              ↓
console.log(`Witaj ${imie} ${nazwisko}`)   alert('Podane hasła różnią się')
alert('Formularz zakończony')
```

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Funkcja**              | **Co oznacza / Co robi?**                                                                        |
| -------------------------------------- | -------------------------------------------------------------------------------------------------- |
| Dane w ukrytej karcie                     | Pola formularza w karcie bez klasy `active` (czyli ukrytej) nadal przechowują swoje wartości.        |
| `===` (ścisła równość)                     | Porównuje wartość **i** typ danych dwóch zmiennych.                                                   |
| Szablon literału (`` `tekst ${zmienna}` ``) | Sposób budowania tekstu z automatycznym wstawianiem wartości zmiennych, bez ręcznego łączenia operatorem `+`. |
| `console.log(...)`                          | Wypisuje wartość w konsoli przeglądarki (narzędzie deweloperskie).                                     |
| `alert('tekst')`                             | Wyświetla systemowe okienko z komunikatem.                                                             |
