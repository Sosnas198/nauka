# Kompletny przewodnik: Bezpieczne pobieranie nazwy pliku z inputa w JS

Ta ściąga wytłumaczy Ci **od A do Z** jak JavaScript pobiera pliki wybrane przez użytkownika, dlaczego zwykłe `.value` zwraca błąd `fakepath` oraz jak bezpiecznie odczytać czystą nazwę pliku.

---

## SEC-1: Pobieranie elementu formularza z HTML (`getElementById`)

Zanim odczytamy jakikolwiek plik, musimy uchwycić w kodzie cały obiekt pola typu `<input type="file">`.

```javascript
const inputPliku = document.getElementById("plikInput");
```

### Jak to działa?

- **`document.getElementById("plikInput")`** – wyszukuje w drzewie HTML pole wyboru pliku po jego unikalnym identyfikatorze `id`.
- **Obiekt zamiast wartości** – pobieramy cały element (zmienna `inputPliku`), a nie samą właściwość `.value`, aby zyskać dostęp do jego specjalnego obiektu `files`.

---

## SEC-2: Walidacja obecności pliku (`files.length`)

Dostęp do pliku bez wcześniejszego sprawdzenia, czy użytkownik w ogóle cokolwiek wybrał, spowoduje błąd w konsoli przeglądarki (`TypeError`).

```javascript
if (inputPliku.files.length > 0) {
  // Plik został wybrany - bezpiecznie przechodzimy dalej
} else {
  console.log("Nie wybrano żadnego pliku!");
}
```

### Wyjaśnienie zapisu krok po kroku

1. **`inputPliku.files`** – to wbudowana w przeglądarkę lista (kolekcja) przechowywanych plików w danym inpucie.
2. **`.length > 0`** – sprawdza długość tej listy. Jeśli wynosi `0`, oznacza to, że użytkownik kliknął przycisk akcji bez wcześniejszego wskazania pliku z dysku.

---

## SEC-3: Odczyt czystej nazwy pliku (`files[0].name`)

Próba odczytania pliku przez `inputPliku.value` zwraca ze względów bezpieczeństwa sztuczną ścieżkę (np. `C:\fakepath\smok.png`).

Aby uzyskać samą nazwę pliku, musimy sięgnąć do tablicy `files`.

```javascript
const nazwaPliku = inputPliku.files[0].name;
```

### Jak to działa?

- **`files[0]`** – wybiera pierwszy plik wskazany przez użytkownika (pamiętaj, że w programowaniu liczymy od indeksu `0`).
- **`.name`** – wyciąga z obiektu pliku wyłącznie jego czystą nazwę wraz z rozszerzeniem (np. `"smok.png"`), całkowicie ignorując sztuczny przedrostek `C:\fakepath\`.

---

# Podsumowanie przepływu danych

```text
SEC-1: const inputPliku = document.getElementById("plikInput")
       — Pobranie obiektu inputa
                 ↓
SEC-2: if (inputPliku.files.length > 0)
       — Warunek ochronny (sprawdzamy, czy plik istnieje)
                 ↓
SEC-3: const nazwaPliku = inputPliku.files[0].name
       — Pobranie czystej nazwy z tablicy
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Metoda**            | **Co oznacza / Co robi?**                                                                   |
| ------------------------------- | ------------------------------------------------------------------------------------------- |
| **`document.getElementById()`** | Pobiera konkretny element z dokumentu HTML po jego atrybucie `id`.                          |
| **`.files`**                    | Lista (kolekcja) przechowywana w obiekcie `<input type="file">` zawierająca wybrane pliki.  |
| **`.files.length`**             | Liczba plików wybranych przez użytkownika (służy do sprawdzania, czy input nie jest pusty). |
| **`.files[0].name`**            | Zwraca czystą nazwę pierwszego wybranego pliku (np. `obraz.jpg`) bez sztucznej ścieżki.     |
