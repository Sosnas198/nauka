# Kompleksowy kurs JavaScript: Rejestracja w sklepie – zakładki, pasek postępu, zatwierdzanie danych

Witaj w module projektowym **Rejestracja w sklepie**!

Ten projekt to wieloetapowy formularz rejestracyjny, który:

1. dzieli dane na trzy zakładki ("Klient", "Adres", "Kontakt"), pokazując zawsze tylko jedną naraz,
2. pokazuje wizualny pasek postępu, rosnący za każdym razem, gdy użytkownik opuści pole formularza,
3. po kliknięciu "Zatwiedź dane" zbiera wszystkie wpisane wartości i wypisuje je w konsoli przeglądarki.

Cały projekt został podzielony na **3 spójne submoduły**, z których każdy odpowiada za jedną z trzech funkcji opisanych w treści zadania: *Funkcja aktywująca*, *Funkcja zmieniająca wartość paska postępu* oraz *Funkcja zatwierdzająca*.

---

## 📁 Architektura i struktura projektu

```text
09_projekt_rejestracja_sklep/
│
├── index.html                        ← pełny, oryginalny plik HTML
├── skrypt.js                         ← pełny, oryginalny plik JS (wszystkie funkcje razem)
│
├── 01_aktywacja_zakladek/
│   ├── README.md
│   └── script.js                     ← Funkcja aktywująca (aktywujZakladke, klient, adres, kontakt)
│
├── 02_pasek_postepu/
│   ├── README.md
│   └── script.js                     ← Funkcja zmieniająca pasek postępu (aktualizujPostep + nasłuchiwacze blur)
│
├── 03_zatwierdzanie_danych/
│   ├── README.md
│   └── script.js                     ← Funkcja zatwierdzająca (zatwierdz)
│
└── README.md                         ← ten plik, główny przewodnik projektu
```

> ⚠️ **Uwaga:** Kod odwołuje się do plików `styl.css` i `obraz.png`, których nie było w treści zadania — musisz sam dodać je do folderu, aby strona wyglądała poprawnie.

---

## 🎓 Ścieżka edukacyjna

### 📁 01_aktywacja_zakladek — przełączanie widocznej zakładki

**Cel:** Ukrycie wszystkich trzech bloków formularza i pokazanie tylko tego, którego przycisk kliknięto.

**Najważniejsze pojęcia:** funkcja parametrowa (`aktywujZakladke`), `style.display`, funkcje "opakowujące" (`klient`, `adres`, `kontakt`).

### 📁 02_pasek_postepu — wizualny wskaźnik wypełnienia formularza

**Cel:** Zwiększanie szerokości paska postępu o 12% za każdym opuszczeniem pola formularza (zdarzenie `blur`), z podwójnym zabezpieczeniem przed przekroczeniem 100%.

**Najważniejsze pojęcia:** zdarzenie `blur`, `querySelectorAll()` + `forEach()`, selektor "bezpośredni potomek" (`#postep > div`), zabezpieczenie zakresu wartości.

### 📁 03_zatwierdzanie_danych — zebranie i wypisanie wszystkich danych

**Cel:** Odczytanie wartości wszystkich pól formularza (również tych w ukrytych zakładkach) i wypisanie ich w konsoli przeglądarki po kliknięciu "Zatwiedź dane".

**Najważniejsze pojęcia:** `.value`, fakt że ukryty element zachowuje swoje dane, operator warunkowy (`? :`), `console.log()`.

---

## 🔄 Jak submoduły łączą się ze sobą?

Wszystkie trzy submoduły działają na **tym samym formularzu**, ale każdy odpowiada za inny aspekt jego zachowania — są od siebie logicznie niezależne (żaden nie wywołuje bezpośrednio drugiego), lecz razem tworzą spójne doświadczenie użytkownika:

```text
                     Użytkownik wypełnia formularz
                                │
        ┌───────────────────────┼───────────────────────┐
        ▼                       ▼                       ▼
01_aktywacja_zakladek    02_pasek_postepu        03_zatwierdzanie_danych
(przełącza widoczność    (rośnie po każdym        (na końcu, po kliknięciu
 bloku po kliknięciu      opuszczeniu pola,        "Zatwiedź dane", zbiera
 przycisku zakładki)      niezależnie od            WSZYSTKIE dane, także
                          aktywnej zakładki)         z ukrytych zakładek)
```

---

## 🧠 Podsumowanie i wzorce do zapamiętania

| Submoduł                     | Kluczowa technika                                    | Zastosowanie                                        |
| -------------------------------- | -------------------------------------------------------- | -------------------------------------------------------- |
| `01_aktywacja_zakladek`           | funkcja parametrowa + `style.display`                     | Przełączanie widocznej sekcji formularza                  |
| `02_pasek_postepu`                 | zdarzenie `blur` + `querySelectorAll().forEach()`          | Wizualny wskaźnik postępu wypełniania formularza           |
| `03_zatwierdzanie_danych`          | `.value` + operator warunkowy `? :` + `console.log()`       | Zebranie i wypisanie wszystkich danych formularza          |
