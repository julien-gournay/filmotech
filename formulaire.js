document.addEventListener('DOMContentLoaded', () => {
    const ouvrirNote = document.getElementById('ouvrirNote');
    const note = document.getElementById('popupnote');
    const fermerNote = document.getElementById('fermernote');
    ouvrirNote.addEventListener('click', () => {
        note.style.display = 'block';
    });
    fermerNote.addEventListener('click', () => {
        note.style.display = 'none';
    });
});
