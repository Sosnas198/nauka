# Kompleksowy kurs JavaScript & DOM: Formularz kontaktowy — komunikat z danymi zgłoszenia

Witaj w projekcie **08_projekt_kontakt**!

Ten przewodnik prowadzi Cię **krok po kroku** przez proces budowania skryptu do strony `kontakt.html`, który:

1. pobiera wartości wpisane/wybrane w formularzu (imię, nazwisko, email, rodzaj zgłoszenia),
2. zamienia adres email na małe litery,
3. wyświetla pod poziomą linią trzywierszowy komunikat z tymi danymi,
4. dodatkowo (funkcja pomocnicza) czyści formularz po kliknięciu przycisku "Czyść".

Cały projekt został podzielony na **3 spójne moduły**.

> **Główna idea:**
> **POBIERZ DANE → SFORMATUJ I WYŚWIETL → (opcjonalnie: WYCZYŚĆ FORMULARZ)**

---

# 📁 Architektura i struktura projektu

```text
08_projekt_kontakt/
│
├── 01_pobieranie_danych_z_formularza/
│   ├── README.md
│   └── script.js
│
├── 02_formatowanie_i_wyswietlanie_wyniku/
│   ├── README.md
│   └── script.js
│
├── 03_czyszczenie_formularza/
│   ├── README.md
│   └── script.js
│
└── README.md
    └── Główny przewodnik projektu
```

> **Ważna uwaga:** Moduły 01 i 02 to fragmenty **jednej, wspólnej** funkcji `wyslij()`, wywoływanej przyciskiem `<button type="submit" onclick="wyslij()">Wyślij</button>`. Moduł 03 to natomiast **osobna, druga funkcja** `czysc()`, wywoływana przyciskiem "Czyść" — nie jest kontynuacją funkcji `wyslij()`. Pełny, złożony razem kod obu funkcji znajdziesz w sekcji "Wzorzec końcowy" na dole tego README.

---

# 🔗 Jak to się ma do wymagań zadania?

- **"Wykonywany po stronie przeglądarki na stronie kontakt.html, wywoływany przyciskiem «Wyślij»"** → cała funkcja `wyslij()` (moduły 01–02), podpięta przez `onclick="wyslij()"`
- **"Skrypt pobiera wartości wprowadzone do kontrolek"** → moduł `01_pobieranie_danych_z_formularza`
- **"Wyświetla komunikat pod linią poziomą, w paragrafie, w trzech wierszach"** → moduł `02_formatowanie_i_wyswietlanie_wyniku` (znaczniki `<p>` i `<br>`, element `#wynik` znajdujący się w HTML tuż pod `<hr>`)
- **"Imię i nazwisko"** (wiersz 1), **"adres email zapisany zawsze małymi literami"** (wiersz 2), **"Usługa: + wartość listy"** (wiersz 3) → wszystkie trzy zrealizowane w jednej linijce kodu w module `02_formatowanie_i_wyswietlanie_wyniku`, SEC-1

Moduł 03 (`czyszczenie_formularza`) nie wynika wprost z treści zadania, ale jest częścią przesłanego, kompletnego rozwiązania (obsługuje przycisk "Czyść").

---

# 🔄 Przepływ logiki

```text
┌───────────────────────────────────────────┐
│  01_pobieranie_danych_z_formularza          │
│  imie, nazwisko, email, zgloszenie          │
│      = getElementById(...).value            │
│  wynik = getElementById("wynik")             │
└──────────────────┬─────────────────────────┘
                   ▼
┌───────────────────────────────────────────┐
│  02_formatowanie_i_wyswietlanie_wyniku      │
│  email.toLowerCase()                        │
│             ↓                              │
│  wynik.innerHTML =                          │
│    "<p>" + imie + " " + nazwisko +          │
│    "<br>" + email.toLowerCase() +           │
│    "<br>Usługa: " + zgloszenie + "</p>"     │
└──────────────────┬─────────────────────────┘
                   ▼
┌───────────────────────────────────────────┐
│              WIDOK STRONY                 │
│   📩 Jan Kowalski                           │
│      jan.kowalski@firma.pl                  │
│      Usługa: wirusy                         │
└────────────────────────────────────────────┘

(niezależnie, po kliknięciu "Czyść":)
┌───────────────────────────────────────────┐
│  03_czyszczenie_formularza                  │
│  imie/nazwisko/email .value = ""            │
│  zgloszenie .value = "naprawa komputerów"   │
└────────────────────────────────────────────┘
```

---

# 📚 Jak uczyć się z tego projektu?

## Moduł 1 — `01_pobieranie_danych_z_formularza`
**Cel:** Odczytanie wszystkiego, co użytkownik wpisał/wybrał w formularzu.
**Czego się nauczysz:**
- **[SEC-1]** `document.getElementById().value` dla pól tekstowych i listy `<select>`
- **[SEC-2]** Pobranie elementu wynikowego (bez odczytu `.value` — będziemy ustawiać jego zawartość)

## Moduł 2 — `02_formatowanie_i_wyswietlanie_wyniku`
**Cel:** Zbudowanie trzywierszowego komunikatu i wyświetlenie go na stronie.
**Czego się nauczysz:**
- **[SEC-1]** Sklejanie tekstu operatorem `+`, `.toLowerCase()`, znacznik `<br>`, `.innerHTML`

## Moduł 3 — `03_czyszczenie_formularza`
**Cel:** Wyczyszczenie formularza po kliknięciu przycisku "Czyść" (funkcja pomocnicza).
**Czego się nauczysz:**
- **[SEC-1]** Ustawianie `.value` na pusty tekst
- **[SEC-2]** Przywracanie domyślnej opcji listy rozwijanej

---

# 🧩 Cały mechanizm krok po kroku

```text
1. Użytkownik wypełnia formularz i klika "Wyślij"
              ↓
2. imie, nazwisko, email, zgloszenie = getElementById(...).value
              ↓
3. wynik = getElementById("wynik")
              ↓
4. email.toLowerCase() — zamiana adresu email na małe litery
              ↓
5. wynik.innerHTML = "<p>imię nazwisko<br>email<br>Usługa: zgłoszenie</p>"
              ↓
6. 📩 komunikat widoczny na stronie, pod poziomą linią

(niezależnie:)
7. Użytkownik klika "Czyść"
              ↓
8. imie/nazwisko/email .value = ""
              ↓
9. zgloszenie .value = "naprawa komputerów" (powrót do domyślnej opcji)
              ↓
10. formularz jest pusty i gotowy do ponownego wypełnienia
```

---

# 🧠 Podsumowanie i wzorce do zapamiętania

| Moduł / Pojęcie                          | Kluczowa funkcja / właściwość   | Zastosowanie                                             |
| ---------------------------------------------- | ------------------------------------- | ------------------------------------------------------------------ |
| `01_pobieranie_danych_z_formularza`             | `document.getElementById().value`     | Odczyt danych z pól tekstowych i listy rozwijanej                    |
| `02_formatowanie_i_wyswietlanie_wyniku`         | `.toLowerCase()`                      | Zapisanie adresu email zawsze małymi literami                        |
| `<br>` w tekście `.innerHTML`                   | Podział komunikatu na wiersze         | Wyświetlenie trzech osobnych linii w jednym paragrafie                |
| `03_czyszczenie_formularza`                     | `element.value = "..."`               | Wyczyszczenie pól tekstowych / przywrócenie domyślnej opcji listy    |

---

# 🎯 Wzorzec końcowy do zapamiętania (kod złożony w całość)

```javascript
function czysc() {
    document.getElementById("imie").value = "";
    document.getElementById("nazwisko").value = "";
    document.getElementById("email").value = "";
    document.getElementById("zgloszenie").value = "naprawa komputerów";
}

function wyslij() {
    let imie = document.getElementById("imie").value;
    let nazwisko = document.getElementById("nazwisko").value;
    let email = document.getElementById("email").value;
    let zgloszenie = document.getElementById("zgloszenie").value;
    let wynik = document.getElementById("wynik");
    wynik.innerHTML = "<p>" + imie + " " + nazwisko + "<br>" + email.toLowerCase() + "<br>Usługa: " + zgloszenie + "</p>";
}
```

---

# 🚀 Najważniejsza logika

```text
POBIERZ DANE (getElementById().value)
   ↓
SFORMATUJ (toLowerCase dla emaila)
   ↓
ZBUDUJ KOMUNIKAT (sklejanie + <br> dla trzech wierszy)
   ↓
WYŚWIETL (innerHTML)
```

Czyli:

> **`getElementById().value` (imię, nazwisko, email, zgłoszenie) → `email.toLowerCase()` → `"<p>" + ... + "<br>" + ... + "</p>"` → `innerHTML`**

To jest cały podstawowy przepływ od **wypełnienia formularza przez użytkownika** do **wyświetlenia gotowego, trzywierszowego komunikatu na stronie**.
