const CACHE_NAME = 'offline-cache-v1';
const OFFLINE_URL = '/offline';

// 1. during install phase: cache on the phone browser the offline page
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.add(new Request(OFFLINE_URL, { cache: 'reload' }));
        })
    );
});

// 2. serve request
self.addEventListener('fetch', (event) => {
    // only HTML pages navigation
    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request).catch(() => {
                // if fetch fails (offline), return the cached offile page
                return caches.match(OFFLINE_URL);
            })
        );
    }
});
