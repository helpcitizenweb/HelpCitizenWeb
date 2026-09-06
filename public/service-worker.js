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


// 🔔 Handle clicking the Windows/Chrome notification
self.addEventListener('notificationclick', function (event) {

    console.log('🔥 NOTIFICATION CLICKED');

    event.notification.close();

    const url = event.notification.data?.url || '/';

    event.waitUntil(
        clients.matchAll({
            type: 'window',
            includeUncontrolled: true
        }).then(function (clientList) {

            // If HelpCitizen is already open, focus it and navigate to the notification URL
            for (const client of clientList) {
                if ('focus' in client) {
                    return client.focus().then(function () {
                        return client.navigate(url);
                    });
                }
            }

            // Otherwise open the notification URL
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
});