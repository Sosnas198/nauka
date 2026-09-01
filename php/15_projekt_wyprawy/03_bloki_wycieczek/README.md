> **Krok 3 z 3** | [Krok 2](../02_symulacja_kosztu/README.md) liczy koszt w aside. Teraz **Skrypt 3**: karty wycieczek w `<section>`.

---

# Kompletny przewodnik: Skrypt 3 — bloki `class="wycieczka"`

---

## SEC-1: Zapytanie — nazwa, cena, obraz

```sql
SELECT nazwa, cena, link_obraz FROM miejsca;
```

Kolumna **`link_obraz`** to nazwa pliku (np. `gory.jpg`), nie pełny URL.

Zwykłe `$conn->query()` — bez filtra POST.

---

## SEC-2: Szablon bloku

Arkusz: dla każdego rekordu **`<div class="wycieczka">`**: obraz, **`<h2>`** z nazwą, cena.

```php
while ($row = $query->fetch_assoc()) {
    echo "<div class='wycieczka'>";
    echo "<img src='" . $row["link_obraz"] . "' alt='zdjęcie z wycieczki'>";
    echo "<h2>" . $row["nazwa"] . "</h2>";
    echo "<p>" . $row["cena"] . " zł</p>";
    echo "</div>";
}
```

Klasa **`wycieczka`** (nie `wycieczki`) — tak jak w CSS z arkusza.

`alt` w kontrolce: `zdjęcie z wycieczki`.

---

## SEC-3: Gdzie w HTML?

Bloki w **`<section>`** pod `h3` „Wycieczki”. Aside (formularz) ich nie zawiera.

Skrypt 3 działa **zawsze**, niezależnie od POST.

---

🏠 **[Spis treści](../README.md)**
