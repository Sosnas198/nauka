# Kompletny przewodnik: Skrypt 1 — pętla `for` i 20 grafik w nagłówku

---

## SEC-1: Połączenie — baza `biblioteka`

```php
$mysqli = mysqli_connect("localhost", "root", "", "biblioteka");
```

Zmienna **`$mysqli`** (nie `$conn`) — tak w kontrolce. Na końcu: **`$mysqli->close()`**.

Skrypt 1 **nie** używa bazy — tylko pętli PHP w `<header>`.

---

## SEC-2: Instrukcja iteracyjna — 20 obiegów

Arkusz: wyświetl **20 razy** grafikę `obraz.png`. Należy użyć **pętli**.

```php
for ($i = 0; $i < 20; $i++) {
    echo '<img src="obraz.png" alt="grafika">';
}
```

- **`$i = 0`**, **`$i < 20`** — obiegi 0…19, czyli **20** obrazów.
- Ten sam plik **`obraz.png`**, `alt="grafika"`.
- Nie kopiujesz 20 tagów ręcznie.

Równie poprawne: `for ($i = 1; $i <= 20; $i++)`.

---

👉 **[Krok 2: Listy gatunków](../02_lista_rozwijana_gatunkow/README.md)**
