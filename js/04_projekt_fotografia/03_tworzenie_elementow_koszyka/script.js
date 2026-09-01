// UNIWERSALNY WZORZEC: Skrypt 3 — tworzenie elementów DOM i dodawanie do koszyka
// -----------------------------------------------------------------------------

// --- KROK 1: Kontener koszyka i wrapper pozycji ---
// [ZOBACZ W README: SEC-1]
const cart = document.querySelector('#prawy .skrypt')
const position = document.createElement('article')
position.className = 'pozycja'

// --- KROK 2: Element DOM dla obrazu z ustaloną nazwą pliku ---
// [ZOBACZ W README: SEC-2]
const preview = document.createElement('img')
const previewUrl = URL.createObjectURL(selectedFile)
preview.src = previewUrl
preview.alt = selectedFile.name
preview.onload = () => URL.revokeObjectURL(previewUrl)

// --- KROK 3: Paragrafy z liczbą kopii i ceną ---
// [ZOBACZ W README: SEC-3]
const copiesInfo = document.createElement('p')
copiesInfo.textContent = `Liczba kopii: ${copies}`
const priceInfo = document.createElement('p')
priceInfo.textContent = `Cena: ${totalPrice}`

// --- KROK 4: Dodanie elementów do DOM ---
// [ZOBACZ W README: SEC-4]
position.appendChild(preview)
position.appendChild(copiesInfo)
position.appendChild(priceInfo)
cart.appendChild(position)
