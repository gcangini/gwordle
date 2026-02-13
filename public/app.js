/**
 * PRIVATE WORDLE PWA Logic
 */

// Configurazione Colori Helper (rispetta l'ordine originale: Gray -> Yellow -> Green)
const COLORS = ["gray", "yellow", "green"];
// Mappatura per il valore nascosto dell'input (0, 1, 2)
const COLOR_MAP = { "gray": 0, "yellow": 1, "green": 2 };

/**
 * Gestione Navigazione SPA (Single Page Application)
 * @param {string} viewName - Nome della vista da mostrare ('game', 'helper', 'list', etc.)
 */
function router(viewName) {
    // Nascondi tutte le sezioni
    document.querySelectorAll('main > section').forEach(el => {
        el.classList.remove('active-view');
        el.classList.add('hidden-view');
    });

    let targetId = 'view-game'; // Default

    // Mappa i nomi delle rotte agli ID delle sezioni
    if (viewName === 'helper') {
        targetId = 'view-helper';
    } else if (viewName === 'list') {
        targetId = 'view-lists';
    }

    // Mostra la sezione target
    const targetEl = document.getElementById(targetId);
    targetEl.classList.remove('hidden-view');
    targetEl.classList.add('active-view');

    // Scrolla in cima
    window.scrollTo(0, 0);
}

/**
 * Toggle Menu Hamburger
 */
function toggleMenu() {
    const menu = document.getElementById('side-menu');
    menu.classList.toggle('open');
}

/**
 * Condivisione WhatsApp (Presa dal codice originale)
 */
function shareWhatsApp() {
    // Nota: i dati qui sono statici come esempio, in produzione andrebbero presi dinamicamente
    const text = '🤖 3/6*\n\n⬜🟩⬜⬜🟨\n⬜🟩⬜🟩⬜\n🟩🟩🟩🟩🟩\n';
    const url = "https://wa.me/?text=" + encodeURIComponent(text);
    window.open(url, "_blank");
}

/**
 * Logica Helper: Cambio Colore
 * @param {HTMLElement} element - Il div del tassello cliccato
 * @param {number} index - L'indice della lettera (0-4)
 * @param {string} inputId - L'ID dell'input hidden che contiene la stringa "01201"
 */
function cycleColor(element, index, inputId) {
    // Determina il colore attuale
    let currentColor = COLORS.find(c => element.classList.contains(c)) || "gray";
    let currentIndex = COLORS.indexOf(currentColor);

    // Calcola il prossimo colore
    let nextIndex = (currentIndex + 1) % COLORS.length;
    let nextColor = COLORS[nextIndex];

    // Aggiorna classi CSS
    element.classList.remove(currentColor);
    element.classList.add(nextColor);

    // Aggiorna il valore nell'input hidden
    const inputEl = document.getElementById(inputId);
    if (inputEl) {
        let currentVal = inputEl.value; // es. "01002"
        // Sostituisci il carattere all'indice specificato
        let chars = currentVal.split('');
        chars[index] = nextIndex;
        inputEl.value = chars.join('');
        // console.log(`Aggiornato ${inputId}: ${inputEl.value}`);
    }
}

/**
 * Service Worker
 */
// Controlla se il browser supporta i service worker
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/sw.js')
      .then(registration => {
        console.log('ServiceWorker registrato con scope:', registration.scope);
      })
      .catch(error => {
        console.log('Registrazione ServiceWorker fallita:', error);
      });
  });
}

// bottone per l'installazione
let deferredPrompt;
const installBtn = document.getElementById('btn-install');

window.addEventListener('beforeinstallprompt', (e) => {
	// Impedisce al browser di mostrare il suo mini-infobar
	e.preventDefault();
	// Salva l'evento per usarlo dopo
	deferredPrompt = e;
	// Mostra il tuo bottone personalizzato
	installBtn.style.display = 'block';
});

installBtn.addEventListener('click', async () => {
	if (deferredPrompt) {
		// Mostra il prompt d'installazione nativo
		deferredPrompt.prompt();
		const { outcome } = await deferredPrompt.userChoice;
		console.log(`L'utente ha ${outcome} l'installazione`);
		deferredPrompt = null;
		installBtn.style.display = 'none';
	}
});
