<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Library Management Dashboard</title>



    <link rel="shortcut icon" href="{{ asset('assets/auth/static/images/logo/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/auth/static/images/logo/favicon.png') }}" type="image/png">

    <link rel="stylesheet" href="{{ asset('assets/auth/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/auth/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/auth/compiled/css/iconly.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/auth/extensions/toastify-js/src/toastify.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/auth/extensions/sweetalert2/sweetalert2.min.css') }}">

    @yield('styles')
</head>

<body>
    <script src="{{ asset('assets/auth/static/js/initTheme.js') }} "></script>
    <script src="{{ asset('assets/auth/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/auth/static/js/pages/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/auth/jquery-3.6.0.min.js') }}"></script>
    <div id="app">
        @include('partials.sidebarStudent')
        <div id="main">
            <header>
                @include('partials.navbar')
            </header>
            @yield('content')

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2024 &copy; RaZoR</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                            by <a href="https://razorisuru.com">Isuru</a></p>
                    </div>
                </div>


                <style>
                    #chat-popup {
                        position: fixed;
                        bottom: 80px;
                        right: 30px;
                        width: 350px;
                        max-width: 90%;
                        background-color: white;
                        border: 1px solid #dee2e6;
                        border-radius: 15px;
                        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                        display: none;
                        flex-direction: column;
                        height: 500px;
                        overflow: hidden;
                        z-index: 9999;
                        opacity: 0;
                        transition: opacity 0.3s ease-in-out;
                    }

                    #chat-container {
                        flex: 1;
                        overflow-y: auto;
                        padding: 15px;
                    }

                    .chat-message {
                        margin-bottom: 15px;
                    }

                    .user-message {
                        text-align: right;
                    }

                    .user-message .message-content {
                        display: inline-block;
                        background-color: #0d6efd;
                        color: white;
                        padding: 10px 15px;
                        border-radius: 20px;
                        max-width: 70%;
                    }

                    .ai-message {
                        text-align: left;
                    }

                    .ai-message .message-content {
                        display: inline-block;
                        background-color: #e9ecef;
                        color: #212529;
                        padding: 10px 15px;
                        border-radius: 20px;
                        max-width: 70%;
                    }

                    /* Floating chat button */
                    #chat-toggle {
                        position: fixed;
                        bottom: 20px;
                        right: 30px;
                        z-index: 10000;
                    }
                </style>

                <!-- Chat Popup -->
                {{-- <div id="chat-popup" class="d-flex flex-column">
                    <div class=" p-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">AI Chatbot</h5>
                        <button id="close-chat" class="btn btn-light btn-sm">X</button>
                    </div>
                    <div id="chat-container"></div>
                    <div class="p-2 border-top">
                        <div class="input-group">
                            <input type="text" id="chat-input" class="form-control"
                                placeholder="Type your message...">
                            <button id="send-button" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </div> --}}
                <!-- Floating Button -->
                <button id="chat-toggle" class="btn btn-primary rounded-circle p-3">
                    💬
                </button>

                <script>
                    $(document).ready(function() {
                        const chatPopup = $("#chat-popup");
                        const chatContainer = $("#chat-container");

                        function addMessage(content, isUser = true) {
                            const messageClass = isUser ? "user-message" : "ai-message";
                            const messageHtml = `
                                    <div class="chat-message ${messageClass}">
                                        <div class="message-content">${content}</div>
                                    </div>
                                `;
                            chatContainer.append(messageHtml);
                            chatContainer.scrollTop(chatContainer.prop("scrollHeight"));
                        }

                        $("#send-button").click(function() {
                            const userInput = $("#chat-input").val().trim();
                            if (userInput) {
                                addMessage(userInput, true);
                                $("#chat-input").val("");

                                // Call your backend
                                $.ajax({
                                    url: "{{ route('chat.bot') }}",
                                    type: "POST",
                                    contentType: "application/json",
                                    data: JSON.stringify({
                                        text: userInput,
                                        _token: "{{ csrf_token() }}",
                                    }),
                                    success: function(response) {
                                        const responseText = response.message;
                                        addMessage(responseText, false);
                                    },
                                    error: function(xhr) {
                                        addMessage("Something went wrong.", false);
                                    },
                                });
                            }
                        });

                        $("#chat-input").keypress(function(e) {
                            if (e.which === 13) {
                                e.preventDefault();
                                $("#send-button").click();
                            }
                        });

                        // Toggle chat popup
                        $("#chat-toggle").click(function() {
                            chatPopup.toggle();
                            if (chatPopup.is(":visible")) {
                                chatPopup.css("opacity", "1");
                            } else {
                                chatPopup.css("opacity", "0");
                            }
                        });

                        // Close button inside popup
                        $("#close-chat").click(function() {
                            chatPopup.css("opacity", "0");
                            setTimeout(function() {
                                chatPopup.hide();
                            }, 300); // Wait for animation to complete
                        });
                    });
                </script>


            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/auth/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assets/auth/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>


    <script src="{{ asset('assets/auth/compiled/js/app.js') }}"></script>

    <script>
        // If you want to use tooltips in your project, we suggest initializing them globally
        // instead of a "per-page" level.
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        }, false);
    </script>

    @yield('scripts')





</body>

</html>
