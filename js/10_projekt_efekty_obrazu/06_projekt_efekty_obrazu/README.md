# Kompleksowy kurs JavaScript & CSS: Efekty na obrazach (filtr CSS sterowany z JS)

Witaj w module projektowym **Efekty obrazu**!

Ten projekt to strona z czterema niezależnymi blokami, z których każdy pokazuje inny sposób sterowania właściwością CSS `filter` za pomocą JavaScriptu:

1. łączenie kilku filtrów naraz na podstawie zaznaczonych pól wyboru,
2. przełączanie między dwoma stałymi stanami (kolor / czarno-biały) dwoma przyciskami,
3. płynna regulacja przezroczystości suwakiem,
4. płynna regulacja jasności suwakiem o innym zakresie wartości.

Cały projekt został podzielony na **4 spójne submoduły**, z których każdy odpowiada za jedną z czterech "Transformacji obrazu" opisanych w treści zadania.

---

## 📁 Architektura i struktura projektu

```text
06_projekt_efekty_obrazu/
│
├── index.html                          ← pełny, oryginalny plik HTML
├── skrypt.js                           ← pełny, oryginalny plik JS (wszystkie 4 funkcje razem)
│
├── 01_filtry_obrazu1/
│   ├── README.md
│   └── script.js                       ← funkcja zastosuj() (Transformacja obrazu 1)
│
├── 02_szarosc_obrazu2/
│   ├── README.md
│   └── script.js                       ← funkcje kolorowy() i czarnobialy() (Transformacja obrazu 2)
│
├── 03_przezroczystosc_obrazu3/
│   ├── README.md
│   └── script.js                       ← funkcja przezroczystosc() (Transformacja obrazu 3)
│
├── 04_jasnosc_obrazu4/
│   ├── README.md
│   └── script.js                       ← funkcja jasnosc() (Transformacja obrazu 4)
│
└── README.md                           ← ten plik, główny przewodnik projektu
```

> ⚠️ **Uwaga:** Kod odwołuje się do plików `styl.css`, `pszczola.jpg`, `pomarancza.jpg`, `owoce.jpg` i `zolw.jpg`, których nie było w treści zadania — musisz sam dodać je do folderu, aby strona wyglądała i działała poprawnie.

---

## 🎓 Ścieżka edukacyjna

### 📁 01_filtry_obrazu1 — łączenie wielu filtrów naraz

**Cel:** Sprawdzenie stanu trzech pól wyboru (Blur, Sepia, Negatyw) i zbudowanie jednego, złożonego tekstu filtra CSS, który może zawierać kilka efektów jednocześnie.

**Najważniejsze pojęcia:** `.checked`, dopisywanie do tekstu operatorem `+=`, `.trim()`, kilka niezależnych `if` (bez `else`).

### 📁 02_szarosc_obrazu2 — dwa proste, niezależne przełączniki

**Cel:** Dwie osobne funkcje, z których każda ustawia **jedną, stałą** wartość filtra — bez żadnych warunków.

**Najważniejsze pojęcia:** `style.filter = 'none'`, `grayscale(100%)`.

### 📁 03_przezroczystosc_obrazu3 — suwak sterujący przezroczystością

**Cel:** Odczytanie aktualnej wartości suwaka (zakres 0–100) i zastosowanie na jej podstawie filtra `opacity`.

**Najważniejsze pojęcia:** `querySelector()` z selektorem potomka (`'#blok3 img'`), `.value` suwaka, szablony literałów (`` ` `` + `${...}`).

### 📁 04_jasnosc_obrazu4 — suwak sterujący jasnością (inny zakres)

**Cel:** Odczytanie wartości suwaka (zakres 0–250, bez wartości domyślnej) i zastosowanie filtra `brightness`, pozwalającego rozjaśnić obrazek ponad jego normalny poziom.

**Najważniejsze pojęcia:** `brightness(N%)`, różnice w konfiguracji `<input type="range">` (inny `max`, brak `value`).

---

## 🔄 Wspólny wzorzec wszystkich submodułów

Mimo że każdy blok realizuje inny efekt wizualny, wszystkie cztery funkcje opierają się na tym samym, uniwersalnym schemacie:

```text
1. Pobierz element <img>, na który ma zadziałać efekt
              ↓
2. Odczytaj stan sterowania (pole wyboru .checked / suwak .value)
              ↓
3. Zbuduj (lub wybierz gotowy) tekst filtra CSS
              ↓
4. Przypisz go do img.style.filter
              ↓
5. Przeglądarka natychmiast przerysowuje obrazek z nowym efektem
```

---

## 🧠 Podsumowanie i wzorce do zapamiętania

| Submoduł                     | Kluczowa właściwość / filtr CSS | Zastosowanie                                     |
| -------------------------------- | ---------------------------------- | --------------------------------------------------- |
| `01_filtry_obrazu1`              | `blur()`, `sepia()`, `invert()`     | Łączenie wielu filtrów naraz na podstawie checkboxów |
| `02_szarosc_obrazu2`              | `'none'`, `grayscale(100%)`         | Dwa proste, stałe przełączniki stylu                 |
| `03_przezroczystosc_obrazu3`      | `opacity(N%)`                       | Płynna regulacja przezroczystości suwakiem            |
| `04_jasnosc_obrazu4`               | `brightness(N%)`                    | Płynna regulacja jasności suwakiem o szerszym zakresie |
