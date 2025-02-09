importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyCctn6I3K5uuI2dk_O4sRCVzzfwsm8LKRQ",
    authDomain: "push-notification-7a0ac.firebaseapp.com",
    projectId: "push-notification-7a0ac",
    storageBucket: "push-notification-7a0ac.firebasestorage.app",
    messagingSenderId: "464463477196",
    appId: "1:464463477196:web:6ea026ff59e77bae878569",
    measurementId: "G-RZ18YP1Z6X"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
    /* Customize notification here */
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});
