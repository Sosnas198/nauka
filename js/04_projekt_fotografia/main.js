// POŁĄCZONY WZORZEC (Moduły 01–03)
// -----------------------------------------------------------------------------

// Moduł 02: [SEC-1] Cennik za kopię wg rodzaju papieru
const pricePerCopy = {
    blyszczacy: 1.5,
    matowy: 2
}

function dodaj() {
    // Moduł 01: [SEC-1] Plik obrazu z pierwszego pola edycyjnego
    const fileInput = document.getElementById('obraz')
    const selectedFile = fileInput.files[0]
    if (!selectedFile) {
        alert('Wybierz plik z listy obrazów.')
        return
    }

    // Moduł 01: [SEC-2] Liczba kopii
    const copiesInput = document.getElementById('kopie')
    const copies = Number(copiesInput.value)
    if (!copies || copies < 1) {
        alert('Podaj liczbę kopii (min. 1).')
        copiesInput.focus()
        return
    }

    // Moduł 01: [SEC-3] Rodzaj papieru
    const paperOption = document.querySelector('input[name="papier"]:checked')
    const paperType = paperOption ? paperOption.value : 'blyszczacy'

    // Moduł 02: [SEC-2] Cena jednostkowa i cena całkowita
    const unitPrice = pricePerCopy[paperType] ?? pricePerCopy.blyszczacy
    const totalPrice = (copies * unitPrice)

    // Moduł 03: [SEC-1] Kontener koszyka i wrapper pozycji
    const cart = document.querySelector('#prawy .skrypt')
    const position = document.createElement('article')
    position.className = 'pozycja'

    // Moduł 03: [SEC-2] Element obrazu (podgląd pliku)
    const preview = document.createElement('img')
    const previewUrl = URL.createObjectURL(selectedFile)
    preview.src = previewUrl
    preview.alt = selectedFile.name
    preview.onload = () => URL.revokeObjectURL(previewUrl)

    // Moduł 03: [SEC-3] Paragrafy z liczbą kopii i ceną
    const copiesInfo = document.createElement('p')
    copiesInfo.textContent = `Liczba kopii: ${copies}`
    const priceInfo = document.createElement('p')
    priceInfo.textContent = `Cena: ${totalPrice}`

    // Moduł 03: [SEC-4] Dodanie elementów do DOM
    position.appendChild(preview)
    position.appendChild(copiesInfo)
    position.appendChild(priceInfo)
    cart.appendChild(position)
}
