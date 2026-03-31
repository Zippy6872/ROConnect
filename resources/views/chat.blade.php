<!DOCTYPE html>
<html lang="nl" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Chat Interface</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-obsidian min-h-screen flex items-center justify-center p-4 grid-bg">

    <div class="w-full max-w-2xl glass-panel overflow-hidden flex flex-col h-[80vh]">
        <div class="px-8 py-6 border-b border-white/10 flex justify-between items-center bg-white/5">
            <div>
                <h2 class="text-xl font-black uppercase tracking-widest text-white">Live Chat</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="typing-dot"></span>
                    <span class="text-[10px] text-zinc-400 uppercase font-bold tracking-tighter">Systeem Online</span>
                </div>
            </div>
            <div class="interest-tag">v3.0 Pro</div>
        </div>

        <div id="messages-container" class="flex-1 overflow-y-auto p-8 space-y-4 custom-scrollbar">
            <ul id="messages" class="space-y-4">
                <li class="chat-pill self-start max-w-[80%] opacity-50 italic text-xs">
                    Welkom bij de chat. Typ een bericht om te beginnen...
                </li>
            </ul>
        </div>

        <div class="p-6 bg-white/5 border-t border-white/10">
            <div class="flex gap-4">
                <div class="relative flex-1">
                    <input 
                        type="text" 
                        id="message" 
                        placeholder="Typ je bericht..." 
                        class="pro-input"
                        onkeypress="if(event.key === 'Enter') sendMessage()"
                    >
                </div>
                <button onclick="sendMessage()" class="pro-button px-8 py-4">
                    Verstuur
                </button>
            </div>
        </div>
    </div>

    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] =
            document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function sendMessage() {
            let messageInput = document.getElementById('message');
            let message = messageInput.value;

            if (message.trim() === '') return;

            axios.post('/send-message', {
                message: message
            });

            messageInput.value = '';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const messagesContainer = document.getElementById('messages-container');
            const messagesList = document.getElementById('messages');

            window.Echo.channel('chat')
                .listen('MessageSent', (e) => {
                    console.log(e);

                    let li = document.createElement('li');
                    li.className = "chat-pill animate-float self-start max-w-[90%] break-words";
                    li.innerText = e.message;

                    messagesList.appendChild(li);
                    
                    // Automatisch naar beneden scrollen
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                });
        });
    </script>

    <style>
        /* Kleine toevoeging voor een mooie scrollbar binnen het glass-panel */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
    </style>
</body>
</html>