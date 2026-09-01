# Kompletny przewodnik: Dodawanie nowej gry do bazy danych (zapytanie przygotowane INSERT)

Ten przewodnik tłumaczy **od A do Z**, jak Skrypt #4 obsługuje formularz "Dodaj nową grę" — pobiera dane wpisane przez użytkownika i bezpiecznie zapisuje je jako nowy rekord w bazie danych.

---

## 🎯 Cel skryptu

Po wysłaniu formularza z sekcji prawej, pobrać wpisane dane (nazwa, opis, cena, zdjęcie) i wstawić je jako nowy wiersz do tabeli `gry`, z liczbą punktów ustawioną na `0` (nowa gra zaczyna ranking od zera).

> ℹ️ **Ważne umiejscowienie w kodzie:** Ten skrypt znajduje się na **samej górze** głównego pliku projektu, **jeszcze przed** znacznikiem `<!DOCTYPE html>`. Dzieje się tak dlatego, że operacje na formularzu (zapis do bazy) powinny wykonać się **zanim** przeglądarka zacznie wyświetlać jakąkolwiek treść strony — to standardowa, dobra praktyka w PHP.
>
> Ten skrypt korzysta ze zmiennej `$conn` (połączenia z bazą danych), tworzonej dosłownie linijkę wcześniej.

---

## SEC-1: Sprawdzenie, czy formularz "Dodaj" został wysłany (`isset`)

```php
if (isset($_POST['dodaj'])) {
    // ... (patrz SEC-2, SEC-3)
}
```

### Jak to działa?

- **`isset($_POST['dodaj'])`** — podobnie jak w Skrypcie #3, sprawdzamy istnienie w `$_POST` klucza o nazwie takiej, jak `name` przycisku submitującego (`<button type="submit" name="dodaj">DODAJ</button>`). Dzięki temu ten kod uruchamia się **tylko** po kliknięciu przycisku "DODAJ", a nie np. po kliknięciu "Pokaż opis" w stopce.

---

## SEC-2: Pobranie i oczyszczenie danych z formularza (`trim` + operator `??`)

```php
$nazwa = trim($_POST['nazwa'] ?? '');
$opis = trim($_POST['opis'] ?? '');
$cena = trim($_POST['cena'] ?? '0');
$zdjecie = trim($_POST['zdjecie'] ?? '');
```

### Jak to działa?

- **`$_POST['nazwa'] ?? ''`** — operator `??` to tzw. **operator koalescencji null** (*null coalescing operator*). Oznacza: *"jeśli `$_POST['nazwa']` istnieje i nie jest `null`, użyj tej wartości; w przeciwnym razie użyj wartości domyślnej po prawej stronie"* (tutaj: pusty tekst `''`, a dla ceny — `'0'`). To dodatkowe zabezpieczenie na wypadek, gdyby jakieś pole nie zostało w ogóle przesłane.
- **`trim(...)`** — funkcja `trim()` usuwa **białe znaki** (spacje, tabulatory, znaki nowej linii) z **początku i końca** tekstu. Jest to przydatne, gdy użytkownik przez przypadek wpisze np. spację przed lub po nazwie gry — dzięki `trim()` taka spacja nie trafi do bazy danych.
- Wynik każdej z tych operacji zapisywany jest w osobnej, czytelnie nazwanej zmiennej (`$nazwa`, `$opis`, `$cena`, `$zdjecie`), gotowej do użycia w zapytaniu SQL.

---

## SEC-3: Bezpieczne wstawienie nowego rekordu do bazy danych (zapytanie przygotowane — `INSERT`)

```php
$stmt = $conn->prepare("INSERT INTO gry (nazwa, opis, punkty, cena, zdjecie) VALUES (?, ?, 0, ?, ?)");
$stmt->bind_param("ssss", $nazwa, $opis, $cena, $zdjecie);
$stmt->execute();
$stmt->close();
```

### Jak to działa?

- **`$conn->prepare("INSERT INTO gry (...) VALUES (?, ?, 0, ?, ?)")`** — przygotowujemy zapytanie SQL dodające nowy wiersz do tabeli `gry`. W nawiasie po `INSERT INTO gry` wymieniamy **nazwy kolumn**, do których wstawiamy dane: `nazwa`, `opis`, `punkty`, `cena`, `zdjecie`. Zwróć uwagę, że kolejność znaków zapytania `?` musi **dokładnie odpowiadać** kolejności kolumn — pierwszy `?` trafi do `nazwa`, drugi do `opis`, trzeci (już nie znak zapytania, tylko na sztywno wpisane `0`) do `punkty`, a kolejne dwa `?` do `cena` i `zdjecie`.
- **Dlaczego `punkty` ma wartość `0`, a nie `?`** — bo zgodnie z treścią zadania, **każda nowo dodana gra zaczyna z zerem punktów** w rankingu. Nie potrzebujemy tej wartości od użytkownika, więc wpisujemy ją na stałe wprost w zapytaniu, zamiast tworzyć dla niej kolejne "puste miejsce" (`?`).
- **`$stmt->bind_param("ssss", $nazwa, $opis, $cena, $zdjecie);`** — podstawia cztery zmienne w miejsce czterech pozostałych znaków `?`. Litera `"ssss"` oznacza, że **wszystkie cztery** wartości mają być traktowane jako tekst (*string*) — nawet `$cena`, mimo że reprezentuje liczbę, jest tu wpisywana jako tekst (co jest zgodne z tym, że pole formularza `cena` to zwykły `<input type="text">`, a nie pole liczbowe).
- **`$stmt->execute();`** — wykonuje zapytanie, czyli faktycznie **zapisuje nowy wiersz** w tabeli `gry`. Kolumna `id` (klucz główny) zostanie uzupełniona automatycznie przez bazę danych, ponieważ nie podajemy jej w liście kolumn w `INSERT INTO gry (...)`.
- **`$stmt->close();`** — zamyka przygotowane zapytanie po jego wykonaniu, zwalniając zasoby.

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Funkcja**             | **Co oznacza / Co robi?**                                                                     |
| ------------------------------------ | ----------------------------------------------------------------------------------------------- |
| `??` (operator koalescencji null)    | Zwraca wartość po lewej stronie, jeśli istnieje i nie jest `null`; w przeciwnym razie wartość po prawej stronie (domyślną). |
| `trim()`                               | Usuwa białe znaki (spacje, tabulatory, znaki nowej linii) z początku i końca tekstu.              |
| `INSERT INTO tabela (kol1, kol2, ...) VALUES (...)` | Zapytanie SQL dodające nowy wiersz do tabeli, z podaniem wartości dla wskazanych kolumn. |
| `bind_param("ssss", ...)`             | Podstawia zmienne w miejsce znaków `?` w przygotowanym zapytaniu; `"s"` oznacza typ tekstowy (*string*) dla każdej z nich. |
| Stała wartość w `VALUES` (np. `0`)   | Wartość wpisana na sztywno w zapytaniu SQL, gdy nie pochodzi ona od użytkownika (tu: startowa liczba punktów). |
