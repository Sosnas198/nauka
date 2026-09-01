# Kompletny przewodnik: Skrypt 1 — zmiana dużego obrazu po kliknięciu miniatury

Ta ściąga wytłumaczy Ci **od A do Z**, jak JavaScript po stronie klienta podmienia atrybut **`src`** elementu `#duzyObraz`, gdy użytkownik kliknie `1m.bmp` albo `2m.bmp`.

---

## SEC-1: Funkcja `wybierzTrojkat()` — duży obraz na `1d.bmp`

Arkusz: gdy kliknięto w obraz **`1m.bmp`**, duży obraz powyżej ustawiany jest na **`1d.bmp`**.

W HTML miniatura ma atrybut zdarzenia:

```html
<img src="1m.bmp" alt="Wybierz trójkąt" class="wybierz" onclick="wybierzTrojkat()">
```

**`onclick`** — skrypt po **kliknięciu** (nie `onmouseover` jak w projekcie paznokci).

```javascript
function wybierzTrojkat() {
    document.getElementById("duzyObraz").src = "1d.bmp";
}
```

- **`document.getElementById("duzyObraz")`** — jeden element z `id="duzyObraz"` (duża grafika nad miniaturami).
- **`.src = "1d.bmp"`** — podmiana pliku; przeglądarka od razu pokazuje trójkąt.

Litera **`d`** = duży, **`m`** = miniatura. Para: `1m` → `1d` (trójkąt).

---

## SEC-2: Funkcja `wybierzProstokat()` — duży obraz na `2d.bmp`

Arkusz: klik w **`2m.bmp`** → duży obraz **`2d.bmp`**.

```html
<img src="2m.bmp" alt="Wybierz prostokąt" class="wybierz" onclick="wybierzProstokat()">
```

```javascript
function wybierzProstokat() {
    document.getElementById("duzyObraz").src = "2d.bmp";
}
```

Para: `2m` → `2d` (prostokąt).

Obie funkcje **tylko zmieniają obraz**. Nie liczą pola — to Skrypt 2, po kliknięciu „Oblicz”.

---

## SEC-3: Stan początkowy HTML (zanim klikniesz)

W `index.html` duży obraz startuje tak:

```html
<img src="1d.bmp" alt="Figura" id="duzyObraz">
```

To **trójkąt**. Jeśli użytkownik od razu wciśnie „Oblicz” (Skrypt 1 ani razu), Skrypt 2 i tak ma liczyć **pole trójkąta**. Dlatego w Skrypcie 2 warunek prostokąta to „czy `src` zawiera `2d.bmp`”, a **wszystko inne** (w tym `1d.bmp`) to trójkąt.

---

# Podsumowanie przepływu danych

```text
Klik 1m.bmp → wybierzTrojkat() → #duzyObraz.src = "1d.bmp"
Klik 2m.bmp → wybierzProstokat() → #duzyObraz.src = "2d.bmp"
Bez kliknięcia → src zostaje "1d.bmp" z HTML
```

---

# Ściągawka

| **Pojęcie**                    | **Co robi?**                                      |
| ------------------------------ | ------------------------------------------------- |
| **`onclick`**                  | Uruchamia funkcję po kliknięciu.                  |
| **`getElementById("duzyObraz")`** | Pobiera dużą grafikę.                          |
| **`.src`**                     | Ścieżka pliku obrazu (odczyt i zapis).            |
| **`1d.bmp` / `2d.bmp`**        | Trójkąt / prostokąt (wersje duże).                |
| **`1m.bmp` / `2m.bmp`**        | Miniatury do kliknięcia.                          |

---

### Co dalej?

Obraz pokazuje wybraną figurę. Teraz **Skrypt 2** odczyta boki i policzy pole.

👉 **[Przejdź do Kroku 2: Obliczanie pola](../02_obliczenia_geometria_dom/README.md)**
