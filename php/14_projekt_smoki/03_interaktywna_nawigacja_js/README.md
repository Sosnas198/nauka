> **Krok 3 z 3** | [W Kroku 2](../02_tabela_smokow_filtr/README.md) masz tabelę w sekcji Baza. Teraz **JavaScript**: klik w nawigację przełącza sekcje i kolory.

---

# Kompletny przewodnik: nawigacja — `onclick`, `display`, MistyRose / #FFAEA5

Skrypt działa **w przeglądarce** (plik `main.js`), nie na serwerze.

---

## SEC-1: Trzy przyciski nav i trzy sekcje `main`

HTML:

```html
<nav>
    <section id="nav-baza" onclick="funkcjabaza()">Baza</section>
    <section id="nav-opisy" onclick="funkcjaopisy()">Opisy</section>
    <section id="nav-galeria" onclick="funkcjagaleria()">Galeria</section>
</nav>
```

Treść:

- `#baza` — formularz i tabela PHP
- `#opisy` — definicje `<dl>`
- `#galeria` — trzy obrazy

**`onclick="funkcjabaza()"`** — po kliknięciu (nie `mouseover`).

---

## SEC-2: Widoczność — `block` i `none`

Aktywna sekcja: **`display = "block"`**. Pozostałe: **`display = "none"`** (ukryte, nie zajmują miejsca).

```javascript
document.getElementById("baza").style.display = "block";
document.getElementById("opisy").style.display = "none";
document.getElementById("galeria").style.display = "none";
```

To samo w `funkcjaopisy()` i `funkcjagaleria()` — inna sekcja ma `block`.

---

## SEC-3: Kolory nawigacji — MistyRose i #FFAEA5

Arkusz: tło bloków nav po kliknięciu.

- **aktywny** (kliknięty) → **`MistyRose`**
- **pozostałe** → **`#FFAEA5`**

```javascript
document.getElementById("nav-baza").style.backgroundColor = "MistyRose";
document.getElementById("nav-opisy").style.backgroundColor = "#FFAEA5";
document.getElementById("nav-galeria").style.backgroundColor = "#FFAEA5";
```

Właściwość JS: **`backgroundColor`** (camelCase), nie `background-color`.

---

## SEC-4: Trzy funkcje o nazwach z HTML

Nazwy muszą **zgadzać się** z `onclick`: `funkcjabaza`, `funkcjaopisy`, `funkcjagaleria`.

Każda funkcja robi dwa zestawy: `display` trzech sekcji + `backgroundColor` trzech navów.

Na końcu `index.php`: `<script src="main.js"></script>` — **po** HTML, żeby `getElementById` znalazł elementy.

---

# Ściągawka

| **Pojęcie**            | **Co robi?**                          |
| ---------------------- | ------------------------------------- |
| **`onclick`**          | Start funkcji po kliknięciu.          |
| **`display = "block"`**| Pokazanie sekcji.                     |
| **`display = "none"`** | Ukrycie sekcji.                       |
| **`MistyRose`**        | Tło aktywnego bloku nav.              |
| **`#FFAEA5`**          | Tło nieaktywnych bloków nav.          |

---

🏠 **[Wróć do spisu](../README.md)**
