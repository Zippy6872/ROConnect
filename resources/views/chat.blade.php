
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @vite(['resources/js/app.js'])

</head>
<body>

<h2>Chat</h2>

<ul id="messages"></ul>

<input type="text" id="message" placeholder="Typ je bericht...">
<button onclick="sendMessage()">Verstuur</button>

<script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] =
        document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function sendMessage() {
        let message = document.getElementById('message').value;

        axios.post('/send-message', {
            message: message
        });

        document.getElementById('message').value = '';
    }

    // window.Echo.channel('chat')
    //     .listen('MessageSent', (e) => {
    //         console.log(e);
    //         let li = document.createElement('li');
    //         li.innerText = e.message;

    //         document.getElementById('messages').appendChild(li);
    //     });
    document.addEventListener('DOMContentLoaded', function () {

    window.Echo.channel('chat')
        .listen('MessageSent', (e) => {
            console.log(e);

            let li = document.createElement('li');
            li.innerText = e.message;

            document.getElementById('messages').appendChild(li);
        });

});
</script>

</body>
</html>