# 🧩 Działanie z elementami DOM – Kompletny przewodnik dla amatora

## 1. Czym jest DOM i `document`?

- **DOM (Document Object Model):** Sposób, w jaki przeglądarka przedstawia stronę HTML jako strukturę obiektów, którymi może sterować JavaScript. Stronę można wyobrazić sobie jak drzewo.
- **`document`:** Cała strona HTML załadowana w przeglądarce; główny obiekt startowy do pracy z DOM.
- **`document.body`:** Część strony zawierająca widoczną treść (`<body>`).
- **Zasada kropki (`.`):** Oznacza dostęp do czegoś w obiekcie (np. `obiekt.coś`).

---

## 2. Pola (Properties) a Metody (Methods)

- **Pola (Właściwości):** Przechowują dane lub stan obiektu (np. tekst, wartość). **Nie mają nawiasów `()`**.
  - Przykłady: `element.textContent`, `element.innerHTML`, `input.value`, `element.style.color`, `document.title`.

- **Metody:** Funkcje należące do obiektu, które wykonują konkretne działanie (np. szukają elementu, usuwają go). **Zawsze mają nawiasy `()`** i mogą przyjmować argumenty.
  - Przykłady: `document.getElementById("id")`, `element.remove()`, `element.appendChild(nowy)`.

---

## 3. Znajdowanie elementów na stronie

Aby wykonać jakąkolwiek operację, najpierw trzeba pobrać element z HTML:

- `document.getElementById("id")` – szuka elementu po unikalnym ID.
- `document.querySelector(".klasa")` – szuka pierwszego elementu pasującego do selektora CSS.
- `document.querySelectorAll("p")` – szuka wszystkich elementów pasujących do selektora (zwraca listę `NodeList`).

**Przykład:**

### JavaScript

```javascript
let tytul = document.getElementById("title");
```

---

## 4. Modyfikacja treści i stylów

- **Zmiana tekstu:**
  - `element.textContent = "Nowy tekst";` (bezpieczny czysty tekst).
  - `element.innerHTML = "Nowy tekst";` (pozwala wstawiać znaczniki HTML).

- **Zmiana stylów CSS:**

### JavaScript

```javascript
element.style.color = "red";
element.style.fontSize = "30px";
```

---

## 5. Dodawanie i usuwanie elementów

### Dodawanie nowego elementu krok po kroku

1. **Tworzenie:** `let p = document.createElement("p");`
2. **Dodanie tekstu:** `p.textContent = "Nowy paragraf";`
3. **Wrzucenie na stronę:** `document.body.appendChild(p);` (dodaje na samym końcu `<body>` lub wskazanego kontenera).

### Usuwanie elementu

### JavaScript

```javascript
element.remove();

// Przykład:
document.getElementById("reklama").remove();
```

---

## 6. Klasy CSS

- **Dodanie klasy:** `element.classList.add("active");`
- **Usunięcie klasy:** `element.classList.remove("active");`

---

## 7. Zdarzenia (Events)

Zdarzenie to akcja użytkownika lub przeglądarki (np. kliknięcie, najechanie myszką, wpisywanie tekstu), na którą JavaScript może zareagować.

### Zalecany sposób w JavaScript (`addEventListener`)

### JavaScript

```javascript
let btn = document.getElementById("btn");

btn.addEventListener("click", function () {
  alert("Kliknijęto!");
});
```

### Najczęstsze zdarzenia

- `onclick` – kliknięcie elementu
- `onmouseover` / `onmouseout` – najechanie / zjechanie myszką
- `onchange` / `oninput` – zmiana wartości lub wpisywanie tekstu w polach formularza
- `onsubmit` – wysłanie formularza
- `onload` – załadowanie strony

---

## 8. NodeList kontra HTMLCollection

- **`NodeList`** (np. z `document.querySelectorAll`) – **statyczny snapshot** z momentu wywołania. Jeśli dodasz nowy element do strony później, lista **nie zaktualizuje się** sama.
- **`HTMLCollection`** (np. z `document.getElementsByClassName`) – **dynamiczna kolekcja**,
