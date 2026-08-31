self.addEventListener('push', function (event) {

    console.log('🔥 REAL PUSH RECEIVED BY SERVICE WORKER');

    const data = event.data ? event.data.json() : {};

    console.log('Push data:', data);

    const title = data.title || 'HelpCitizen';

    const options = {
        body: data.body || 'You have a new notification.',
        icon: '/favicon.ico',
        badge: '/favicon.ico',
        requireInteraction: true,
        data: {
            url: data.url || '/'
        }
    };

    event.waitUntil(
        self.registration.showNotification(title, options)
            .then(() => {
                console.log('🔥 NOTIFICATION DISPLAY REQUESTED');
            })
            .catch(error => {
                console.error('🔥 NOTIFICATION DISPLAY FAILED:', error);
            })
    );
});