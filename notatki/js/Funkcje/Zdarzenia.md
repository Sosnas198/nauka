## 1. Zdarzenia myszy (Mouse Events)

Reagują na ruchy i akcje wykonywane wskaźnikiem myszy lub panelem dotykowym.

- **`ondblclick`** **(Double Click):**
  - **Jak to działa po ludzku:** Działa dokładnie wtedy, gdy użytkownik kliknie dany element **szybko dwa razy z rzędu**.
  - **Kod HTML:**

    ```HTML
    <div ondblclick="alert('Kliknięto dwa razy!')">Kliknij mnie szybko dwukrotnie</div>
    ```

- **`onmouseover`**:
  - **Jak to działa po ludzku:** To moment, w którym kursor myszy **wkracza na dany element** (po prostu wjeżdża nad niego).
  - **Kod HTML:**

    ```HTML
    <div onmouseover="this.style.backgroundColor='yellow'">Najedź na mnie myszką</div>
    ```

- **`onmouseout`**:
  - **Jak to działa po ludzku:** Przeciwieństwo powyższego – zachodzi wtedy, gdy kursor myszy **opuszcza dany element** (zjeżdża z niego).
  - **Kod HTML:**

    ```HTML
    <div onmouseout="this.style.backgroundColor='white'">Zjedź ze mnie myszką</div>
    ```

## 2. Zdarzenia formularzy i wprowadzania danych (Form & Input Events)

Kluczowe zdarzenia do obsługi pól tekstowych, list rozwijanych i checkboxów.

- **`oninput`**:
  - **Jak to działa po ludzku:** Odpala się **natychmiast**, gdy wartość w polu tekstowym ulegnie jakiejkolwiek zmianie. Każde wpisanie lub usunięcie pojedynczej litery od razu uruchamia skrypt.
  - **Kod HTML:**

    ```HTML
    <input type="text" oninput="console.log('Tekst się zmienił!')">
    ```

- **`onchange`**:
  - **Jak to działa po ludzku:** Czeka z reakcją dopóki zmiana nie zostanie **„zatwierdzona”**. Dla pól tekstowych (`<input type="text">`) oznacza to, że wpisujesz tekst, a skrypt odpala się dopiero, gdy **klikasz poza pole** i straci ono tzw. _focus_.
  - **Kod HTML:**

    ```HTML
    <input type="text" onchange="alert('Zatwierdzono zmianę w polu!')">
    ```
