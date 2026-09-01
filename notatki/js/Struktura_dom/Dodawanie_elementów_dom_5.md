# Projekt czatu w JavaScript – Przewodnik od A do Z

Ten dokument w prosty sposób wyjaśnia, jak działa kod prostej aplikacji czatu stworzonej przy użyciu HTML i JavaScript.

## 1. Wygląd i struktura strony (HTML)

Zanim napiszemy jakikolwiek skrypt w JavaScript, musimy przygotować fundamenty strony – czyli strukturę HTML.

```html
<body>
  <main>
    <section id="chat">
      <section class="blokj">
        <img src="Jolka.jpg" alt="Jolka" />
        <p>Cześć idziesz jutro do kina?</p>
      </section>
      <section class="blokk">
        <img src="Krzysiek.jpg" alt="Krzysiek" />
        <p>Tak! A ty?</p>
      </section>
    </section>

    Wpisz wiadomość:
    <input type="text" id="tekst" placeholder="Napisz coś..." />
    <button type="button" onclick="funkcja()">Wyślij</button>

    <br /><br />

    <button type="button" onclick="funkcja2()">Generuj losową odpowiedź</button>
  </main>
</body>
```

## 2. Wysyłanie wiadomości przez użytkownika: funkcja()

Ta funkcja uruchamia się w momencie, gdy użytkownik wpisze coś w pole tekstowe i kliknie przycisk „Wyślij”.

### Krok A: Pobranie wartości i „Odkurzaczy” (.trim())

```javascript
var poleTekstowe = document.getElementById("tekst");
var tekst = poleTekstowe.value;

if (tekst.trim() === "") return;
```

**Pobieranie tekstu:** Najpierw łapiemy cały element input za pomocą jego ID, a następnie wyciągamy z niego wpisany tekst za pomocą właściwości `.value`.

**Metoda .trim() (Odkurzacz do spacji):** Służy do usuwania niewidocznych spacji (oraz tabulacji i znaków nowej linii) z samego początku i z samego końca tekstu. Nie rusza ona spacji w środku słów.

**Przykład:** Jeśli użytkownik wcisnie spację 5 razy i kliknie „Wyślij”, bez `.trim()` komputer uzna spacje za tekst i stworzy pusty dymek. Z użyciem `.trim()` skrajne spacje zostają zjedzone i zostaje pusty string `""`.

**Słowo kluczowe return (Hamulec awaryjny):** Działa jak natychmiastowe przerwanie działania funkcji. Jeśli pole po „odkurzeniu” jest puste, komputer mówi: „Zatrzymuję się w tym miejscu!”, ignoruje dalsze linijki kodu i dymek nie powstaje.

**Skrócony zapis if:** Ponieważ wewnątrz instrukcji warunkowej mamy do wykonania tylko jedną linijkę (`return;`), możemy wyrzucić klamry `{}` i zapisać wszystko w jednej linii dla czystszego kodu.

### Krok B: Tworzenie dymku (innerHTML)

```javascript
var chat = document.getElementById("chat");
var jolka = document.createElement("section");
jolka.classList.add("blokj");
jolka.innerHTML = "<img src='Jolka.jpg'><p>" + tekst + "</p>";
```

**Tworzenie elementu:** Łapiemy główne okno czatu (`#chat`), a następnie tworzymy w pamięci komputera nową, pustą sekcję (`<section>`) i przypisujemy ją do zmiennej `jolka`.

**classList.add() (Elegancki menedżer):** Pozwala dokładać pojedyncze klasy CSS (w tym przypadku `"blokj"`, żeby nadać dymkowi odpowiednie tło) bez niszczenia innych klas. Jest bezpieczniejszy niż `className`, który nadpisuje wszystko na sztywno.

**Wstrzykiwanie przez innerHTML:** Pakujemy do wnętrza nowej sekcji gotowy szablon HTML – zdjęcie Jolki oraz zmienną `tekst` wpisaną przez użytkownika.

### Krok C: Wrzucenie na stronę i przewinięcie

```javascript
chat.appendChild(jolka);
jolka.scrollIntoView({ behavior: "smooth" });
poleTekstowe.value = "";
```

**Metoda appendChild() (Dolewanie do szklanki):** Dokleja nowy element na samym końcu wewnątrz elementu-rodzica (`#chat`), nie kasując przy tym starszych wiadomości.

**scrollIntoView():** Wydaje przeglądarce rozkaz płynnego przewinięcia ekranu do nowo dodanego elementu, aby użytkownik zawsze widział najnowszą wiadomość na dole czatu.

**Czyszczenie pola:** Na samym końcu przypisujemy pusty ciąg znaków do `poleTekstowe.value`, przygotowując pole na kolejną wiadomości.

## 3. Generowanie losowej odpowiedzi: funkcja2()

Ta funkcja symuluje odpowiedź drugiej osoby (Krzyśka) i uruchamia się po kliknięciu drugiego przycisku.

### Krok A: Magazynek i losowanie indeksu

```javascript
var tablica = [
  "Świetnie!",
  "Kto gra główną rolę?",
  "Lubisz filmy tego reżysera?",
  "Będę 10 minut wcześniej",
  "Może kupimy sobie popcorn?",
  "Ja wolę Colę",
  "Zaproszę jeszcze Grześka",
  "Tydzień temu też byłem w kinie na Diunie",
  "Ja funduję bilety",
];

var los = Math.floor(Math.random() * tablica.length);
```

**Tablica:** Magazynek zawierający 9 gotowych zdań (o indeksach od 0 do 8).

**Losowanie:** `Math.random()` daje losową liczbę ułamkową od 0 do prawie 1. Mnożymy ją przez długość tablicy (`tablica.length`, czyli 9). `Math.floor()` brutalnie obcina ułamek i zaokrągla w dół (np. z liczby 4.77 robi czwórkę), dzięki czemu otrzymujemy poprawny indeks elementu z tablicy.

### Krok B i C: Budowanie dymku Krzyśka i publikacja

```javascript
var chat = document.getElementById("chat");
var sekcja = document.createElement("section");

sekcja.className = "blokk";
sekcja.innerHTML = "<img src='Krzysiek.jpg'><p>" + tablica[los] + "</p>";

chat.appendChild(sekcja);
sekcja.scrollIntoView({ behavior: "smooth" });
```

Używamy właściwości `className = "blokk"`, ponieważ element jest całkowicie nowy i pusty, więc możemy bezpiecznie przypisać mu klasę na sztywno.

Wstrzykujemy wylosowane zdanie z tablicy za pomocą zapisu `tablica[los]`.

Wpychamy dymek na czat za pomocą `appendChild()` i wywołujemy automatyczne przewinięcie ekranu (`scrollIntoView`).
