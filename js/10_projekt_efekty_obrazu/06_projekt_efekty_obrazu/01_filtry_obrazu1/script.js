function zastosuj() {
    const img = document.getElementById('pszczola');
    const blur = document.getElementById('blur').checked;
    const sepia = document.getElementById('sepia').checked;
    const negatyw = document.getElementById('negatyw').checked;
    
    let filterValue = '';
    if (blur) {
        filterValue += 'blur(6px) ';
    }
    if (sepia) {
        filterValue += 'sepia(100%) ';
    }
    if (negatyw) {
        filterValue += 'invert(100%) ';
    }
    img.style.filter = filterValue.trim();
}
