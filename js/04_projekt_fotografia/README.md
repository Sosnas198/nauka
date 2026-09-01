# Kompleksowy kurs JavaScript & DOM: Fotografia artystyczna

Witaj w czwartym module projektowym JS! Ten przewodnik prowadzi Cię przez skrypt obsługujący formularz zamówienia zdjęć: **pobranie danych z kontrolek**, **obliczenie ceny** wg liczby kopii i rodzaju papieru oraz **dodanie pozycji do koszyka** przez tworzenie elementów DOM.

Całość łączy plik **`main.js`**, podpięty do **`fotografia.html`**.

---

## 📁 Architektura

```text
04_projekt_fotografia/
│
├── 01_pobieranie_danych_z_kontrolek/
├── 02_obliczanie_ceny/
├── 03_tworzenie_elementow_koszyka/
├── README.md
├── fotografia.html
└── main.js
```

`style.css` pochodzi z arkusza (w HTML tylko `<link>`).

---

## 🔄 Przepływ

```text
     Kliknięcie przycisku "Dodaj do koszyka" → dodaj()
                         │
                         ▼
     [ 01_pobieranie_danych_z_kontrolek ]   plik, liczba kopii, rodzaj papieru
                         │
     [ 02_obliczanie_ceny ]                 cena jednostkowa × liczba kopii
                         │
     [ 03_tworzenie_elementow_koszyka ]     <article> z obrazem i paragrafami
                         ▼
                 cart.appendChild(position)
```

Funkcja `dodaj()` wykonuje trzy moduły po kolei, w jednym wywołaniu, po kliknięciu przycisku w sekcji lewej.

---

# 🎓 Moduły

| Moduł | README | Treść |
| ----- | ------ | ----- |
| 01 | [pobieranie danych z kontrolek](./01_pobieranie_danych_z_kontrolek/README.md) | plik, liczba kopii, rodzaj papieru |
| 02 | [obliczanie ceny](./02_obliczanie_ceny/README.md) | cennik, cena jednostkowa, cena łączna |
| 03 | [tworzenie elementów koszyka](./03_tworzenie_elementow_koszyka/README.md) | `createElement`, `appendChild` |

Połączenie modułów jak w kontrolce: jedna funkcja `dodaj()` w `main.js`, wywoływana atrybutem `onclick` przycisku w `fotografia.html`.
