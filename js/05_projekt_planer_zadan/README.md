> **Krok 2 z 2** | [Krok 1](../01_oznaczanie_wykonane/README.md) obsłużył przekreślanie zadań. Teraz **Skrypt 2**: tworzenie nowego zadania na końcu listy.

---

# Kompletny przewodnik: Skrypt 2 — dodawanie nowego zadania (`createElement`, `appendChild`)

---

## Wprowadzenie — o co chodzi w tej części zadania?

Ten moduł odpowiada za drugą, ostatnią funkcjonalność planera zadań: możliwość dopisania własnego zadania na końcu listy. Użytkownik wpisuje treść w polu tekstowym, klika „Dodaj”, a na dole listy pojawia się nowy element `<li>` — wyglądający i zachowujący się dokładnie tak samo, jak sześć zadań, które były na stronie od początku, łącznie z działającym przyciskiem „Wykonane”.

To jest dobry moment, żeby przypomnieć sobie zastrzeżenie z treści zadania: elementy **mogą być dodawane, ale nie są usuwane**. Właśnie dlatego ten skrypt w ogóle nie musi martwić się o usuwanie zadań — wystarczy, że umie dokładać nowe elementy na końcu listy, korzystając z tych samych mechanizmów DOM, które poznajesz też w innych projektach: `createElement` (tworzenie nowego elementu HTML "w locie", z poziomu JavaScriptu) oraz `appendChild` (doczepienie nowo utworzonego elementu do istniejącego rodzica).

---

## SEC-1: Funkcja dodająca nowe zadanie

Arkusz: funkcja wywoływana po kliknięciu „Dodaj” tworzy nowy element listy na jej końcu, składający się z treści pobranej z pola edycyjnego oraz przycisku „Wykonane”, sformatowanego tak samo jak pozostałe przyciski i reagującego na kliknięcie tak samo jak one.

```js
function dodajZadanie() {
	const trescZadania = poleZadania.value.trim();
	if (!trescZadania) {
		return;
	}
	const nowyElement = document.createElement('li');
	nowyElement.textContent = trescZadania + ' ';
	const nowyPrzycisk = document.createElement('button');
	nowyPrzycisk.type = 'button';
	nowyPrzycisk.textContent = 'Wykonane';
	nowyPrzycisk.addEventListener('click', oznaczJakoWykonane);
	nowyElement.appendChild(nowyPrzycisk);
	listaZadan.appendChild(nowyElement);
	poleZadania.value = '';
}
```

Rozłóżmy tę funkcję na mniejsze, łatwiejsze do zrozumienia kroki:

**1. Odczyt i sprawdzenie treści zadania**

```js
const trescZadania = poleZadania.value.trim();
if (!trescZadania) {
	return;
}
```

- `poleZadania.value` — aktualna zawartość pola tekstowego, w którym użytkownik wpisał treść nowego zadania (przypomnienie: `poleZadania` zostało pobrane już w Skrypcie 1, w SEC-1).
- `.trim()` — usuwa białe znaki (spacje, tabulatory) z początku i końca tekstu. Dzięki temu, jeśli użytkownik przez pomyłkę wpisze same spacje albo zostawi je na końcu, nie potraktujemy tego jako "prawdziwej" treści zadania.
- `if (!trescZadania) { return; }` — jeżeli po przycięciu białych znaków zostanie pusty tekst (czyli `trescZadania` jest pustym stringiem, a `!trescZadania` jest wtedy `true`), funkcja natychmiast kończy działanie przez `return`, nie tworząc żadnego nowego elementu listy. To zabezpieczenie przed dodawaniem "pustych" zadań.

**2. Utworzenie nowego elementu listy**

```js
const nowyElement = document.createElement('li');
nowyElement.textContent = trescZadania + ' ';
```

- `document.createElement('li')` — tworzy zupełnie nowy, "pusty" jeszcze element `<li>`, który na razie istnieje tylko w pamięci JavaScriptu i nie jest jeszcze widoczny na stronie (dopiero dalej zostanie "doczepiony" do listy).
- `nowyElement.textContent = trescZadania + ' '` — ustawia tekst wewnątrz tego elementu na treść wpisaną przez użytkownika. Dodatkowa spacja na końcu (`+ ' '`) zapewnia, że tekst zadania nie "zlepi się" wizualnie z przyciskiem „Wykonane”, który zostanie dodany zaraz po nim (identycznie jak w kodzie HTML sześciu początkowych elementów, gdzie po treści zadania jest spacja przed tagiem `<button>`).

**3. Utworzenie przycisku „Wykonane” dla nowego zadania**

```js
const nowyPrzycisk = document.createElement('button');
nowyPrzycisk.type = 'button';
nowyPrzycisk.textContent = 'Wykonane';
nowyPrzycisk.addEventListener('click', oznaczJakoWykonane);
```

- `document.createElement('button')` — tworzy nowy element `<button>`, analogicznie jak wcześniej dla `<li>`.
- `nowyPrzycisk.type = 'button'` — ustawia atrybut `type` na `"button"`. To ważne w kontekście przycisków wewnątrz formularzy (żeby przycisk **nie** próbował wysłać żadnego formularza), i jest to dokładnie ten sam typ, jaki mają przyciski „Wykonane” w oryginalnym kodzie HTML.
- `nowyPrzycisk.textContent = 'Wykonane'` — ustawia widoczny tekst przycisku, dokładnie taki sam jak na pozostałych przyciskach „Wykonane”. Dzięki temu nowy przycisk **wygląda i nazywa się** dokładnie tak samo jak reszta — spełnia to wymaganie z arkusza, że przycisk ma być "formatowany tak jak reszta przycisków w liście".
- `nowyPrzycisk.addEventListener('click', oznaczJakoWykonane)` — to najważniejsza linijka z punktu widzenia działania przycisku: podłączamy do niego dokładnie tę samą funkcję `oznaczJakoWykonane`, którą poznałeś w Skrypcie 1. Dzięki temu, że `oznaczJakoWykonane` "domyśla się" swojego elementu `<li>` przez `event.currentTarget.closest('li')`, nie musimy pisać żadnej nowej, osobnej funkcji dla nowo dodawanych zadań — ten sam kod obsłuży zarówno stare, jak i nowe przyciski.

**4. Złożenie nowego elementu i dodanie go do listy**

```js
nowyElement.appendChild(nowyPrzycisk);
listaZadan.appendChild(nowyElement);
poleZadania.value = '';
```

- `nowyElement.appendChild(nowyPrzycisk)` — umieszcza utworzony przycisk **wewnątrz** nowego elementu `<li>`, dokładnie tak, jak w oryginalnym HTML-u przycisk „Wykonane” znajduje się wewnątrz swojego `<li>`.
- `listaZadan.appendChild(nowyElement)` — dopiero w tym momencie nowo utworzony element `<li>` (razem z przyciskiem w środku) zostaje faktycznie doczepiony do widocznej na stronie listy `<ul>`, i to zawsze **na jej końcu** — `appendChild` zawsze dodaje nowy element jako ostatnie dziecko danego rodzica, co dokładnie odpowiada wymaganiu z arkusza ("tworzy nowy element listy na jej końcu").
- `poleZadania.value = ''` — na koniec czyścimy pole tekstowe, ustawiając jego wartość na pusty tekst, żeby użytkownik od razu widział, że zadanie zostało dodane, i mógł łatwo wpisać kolejne.

---

## SEC-2: Podłączenie funkcji do przycisku „Dodaj”

```js
przyciskDodaj.addEventListener('click', dodajZadanie);
```

Podobnie jak w Skrypcie 1 dla przycisków „Wykonane”, sama funkcja `dodajZadanie` musi zostać **podłączona** do konkretnego przycisku, żeby w ogóle mogła zostać wywołana. Tym razem podłączenie jest znacznie prostsze niż w SEC-3 Skryptu 1 — nie potrzebujemy tu żadnej pętli `forEach`, bo przycisk „Dodaj” jest tylko **jeden** na całej stronie (`przyciskDodaj`, pobrany wcześniej w Skrypcie 1, SEC-1). Wystarczy więc pojedyncze wywołanie `addEventListener`.

Od tego momentu każde kliknięcie przycisku „Dodaj” wywoła funkcję `dodajZadanie`, opisaną w SEC-1 powyżej.

---

🏠 **[Spis treści](../README.md)**
