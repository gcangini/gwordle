const CACHE_NAME = 'offline-cache-v1';
const OFFLINE_URL = '/offline';

// 1. In fase di installazione, mettiamo in cache la pagina offline
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.add(new Request(OFFLINE_URL, { cache: 'reload' }));
        })
    );
});

// 2. Gestione delle richieste
self.addEventListener('fetch', (event) => {
    // Gestiamo solo le navigazioni (pagine HTML)
    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request).catch(() => {
                // Se il fetch fallisce (offline), restituisci la pagina in cache
                return caches.match(OFFLINE_URL);
            })
        );
    }
});
