const ouvrirPopup1 = document.getElementById('ouvrir-popup1');
const fermerPopup1 = document.getElementById('fermer-popup1');
const popup1 = document.getElementById('popup1');

ouvrirPopup1.addEventListener('click', () => {
    popup1.style.display = 'block';
});

fermerPopup1.addEventListener('click', () => {
    popup1.style.display = 'none';
});




const ouvrirPopup2 = document.getElementById('ouvrir-popup2');
const fermerPopup2 = document.getElementById('fermer-popup2');
const popup2 = document.getElementById('popup2');

ouvrirPopup2.addEventListener('click', () => {
    popup2.style.display = 'block';
});

fermerPopup2.addEventListener('click', () => {
    popup2.style.display = 'none';
});