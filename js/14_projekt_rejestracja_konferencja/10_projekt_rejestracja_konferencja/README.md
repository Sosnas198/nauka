# Kompleksowy kurs JavaScript: Rejestracja konferencji – wieloetapowy formularz z walidacją

Witaj w module projektowym **Formularz rejestracyjny konferencji "Nasze Kwiaty"**!

Ten projekt to trzykartowy, wieloetapowy formularz rejestracyjny, który:

1. przełącza się z pierwszej karty (dane osobowe) na drugą (dane kontaktowe), sprawdzając wcześniej, czy imię i nazwisko są wypełnione,
2. przełącza się z drugiej karty na trzecią (hasła), sprawdzając e-mail i telefon,
3. po kliknięciu "Zatwierdź" porównuje oba wpisane hasła i — jeśli się zgadzają — wypisuje w konsoli powitanie zbudowane z danych osobowych podanych na samym początku.

Cały projekt został podzielony na **3 spójne submoduły**, odpowiadające trzem funkcjom (a właściwie: trzem nasłuchiwaczom zdarzeń) opisanym w treści zadania.

---

## 📁 Architektura i struktura projektu

```text
10_projekt_rejestracja_konferencja/
│
├── index.html                                  ← pełny, oryginalny plik HTML
├── skrypt.js                                   ← pełny, oryginalny plik JS (wszystko razem)
│
├── 01_przejscie_blok1_do_blok2/
│   ├── README.md
│   └── script.js                               ← funkcja pomocnicza showFormBlock() + nasłuchiwacz next1
│
├── 02_przejscie_blok2_do_blok3/
│   ├── README.md
│   └── script.js                               ← nasłuchiwacz next2 (korzysta z tej samej showFormBlock())
│
├── 03_zatwierdzanie_formularza/
│   ├── README.md
│   └── script.js                               ← nasłuchiwacz submit (porównanie haseł + powitanie)
│
└── README.md                                   ← ten plik, główny przewodnik projektu
```

> ⚠️ **Uwaga:** Kod odwołuje się do plików `styl.css` i `motyl.mp4`, których nie było w treści zadania — musisz sam dodać je do folderu, aby strona wyglądała i działała poprawnie.

> 📌 **Ważna uwaga o funkcji `showFormBlock()`:** Ta funkcja pomocnicza jest zdefiniowana **tylko raz** w pełnym pliku `skrypt.js`, ale korzystają z niej **oba** przejścia między kartami (submoduł 1 i 2). W plikach `script.js` submodułów 1 i 2 jest ona powtórzona dla kompletności (żeby każdy fragment był samodzielnie zrozumiały), ale w rzeczywistym, połączonym projekcie istnieje jako jedna, wspólna definicja.

---

## 🎓 Ścieżka edukacyjna

### 📁 01_przejscie_blok1_do_blok2 — pierwsze przejście między kartami

**Cel:** Sprawdzenie, czy pola "imię" i "nazwisko" są wypełnione, i jeśli tak — przełączenie widocznej karty z pierwszej na drugą.

**Najważniejsze pojęcia:** funkcja pomocnicza `showFormBlock()`, `classList.add()` / `classList.remove()`, wartości *truthy*/*falsy* w warunku `if`.

### 📁 02_przejscie_blok2_do_blok3 — drugie przejście, ten sam wzorzec

**Cel:** Sprawdzenie pól "e-mail" i "telefon", i przełączenie karty z drugiej na trzecią, tym samym wzorcem co w submodule 1.

**Najważniejsze pojęcia:** powtarzalny szablon walidacji + przełączania karty, współdzielenie jednej funkcji pomocniczej.

### 📁 03_zatwierdzanie_formularza — porównanie haseł i powitanie

**Cel:** Porównanie dwóch pól haseł; jeśli się zgadzają — pobranie imienia i nazwiska **z pierwszej karty** (mimo że jest ukryta) i wypisanie powitania w konsoli.

**Najważniejsze pojęcia:** dane w ukrytej karcie wciąż dostępne, `===`, szablon literału, `console.log()`.

---

## 🔄 Jak submoduły łączą się ze sobą?

```text
        KARTA 1 (dane osobowe)
      imie, nazwisko wpisane
              │
     01_przejscie_blok1_do_blok2
   (walidacja + showFormBlock)
              ▼
        KARTA 2 (dane kontaktowe)
      email, telefon wpisane
              │
     02_przejscie_blok2_do_blok3
   (ta sama showFormBlock,
    inne argumenty)
              ▼
        KARTA 3 (hasła)
    haslo1, haslo2 wpisane
              │
     03_zatwierdzanie_formularza
  (porównanie haseł + odczyt
   imie/nazwisko z KARTY 1,
   mimo że jest już ukryta!)
              ▼
   console.log("Witaj imię nazwisko")
```

---

## 🧠 Podsumowanie i wzorce do zapamiętania

| Submoduł                          | Kluczowa technika                                     | Zastosowanie                                          |
| -------------------------------------- | ----------------------------------------------------------- | ------------------------------------------------------- |
| `01_przejscie_blok1_do_blok2`           | `showFormBlock()` + `classList` + walidacja *truthy*/*falsy* | Bezpieczne przejście na kolejną kartę formularza          |
| `02_przejscie_blok2_do_blok3`            | ten sam wzorzec co wyżej, inne pola i karty                   | Powtarzalność wzorca w wieloetapowym formularzu            |
| `03_zatwierdzanie_formularza`            | `===`, szablon literału, dane z ukrytej karty                 | Finalna walidacja haseł i zebranie danych z całego formularza |
