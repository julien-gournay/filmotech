const ouvrirPopup3 = document.getElementById('ouvrir-popup3');
const fermerPopup3 = document.getElementById('fermer-popup3');
const popup3 = document.getElementById('popup3');

ouvrirPopup3.addEventListener('click', () => {
    popup3.style.display = 'block';
});

fermerPopup3.addEventListener('click', () => {
    popup3.style.display = 'none';
});