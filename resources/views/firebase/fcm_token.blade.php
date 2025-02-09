<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <center>
                <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>
            </center>
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                 <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                     <form action="" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label>Body</label>
                            <textarea class="form-control" name="body"></textarea>
                          </div>
                        <button type="submit" class="btn btn-primary">Send Notification</button>
                    </form>
                 </div>
            </div>
        </div>
    </div>
 </div>
  <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
   <script>
     var firebaseConfig = {
        apiKey: "AIzaSyCctn6I3K5uuI2dk_O4sRCVzzfwsm8LKRQ",
        authDomain: "push-notification-7a0ac.firebaseapp.com",
        projectId: "push-notification-7a0ac",
        storageBucket: "push-notification-7a0ac.firebasestorage.app",
        messagingSenderId: "464463477196",
        appId: "1:464463477196:web:6ea026ff59e77bae878569",
        measurementId: "G-RZ18YP1Z6X"
    };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
     function initFirebaseMessagingRegistration() {
            messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function(token) {
                console.log("fcm_token: ", token);

             }).catch(function (err) {
                console.log('User Chat Token Error'+ err);
            });
     }

    messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(noteTitle, noteOptions);
    });

 </script>
