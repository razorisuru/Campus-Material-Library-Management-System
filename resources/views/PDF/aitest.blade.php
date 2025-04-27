<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Chatbot</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        /* Chatbot popup */
        #chat-popup {
            position: fixed;
            bottom: 80px;
            right: 30px;
            width: 350px;
            max-width: 90%;

            border: 1px solid #dee2e6;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
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

            padding: 10px 15px;
            border-radius: 20px;
            max-width: 70%;
        }
        .ai-message {
            text-align: left;
        }
        .ai-message .message-content {
            display: inline-block;

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
</head>
<body>

<!-- Chat Popup -->
<div id="chat-popup" class="d-flex flex-column">
    <div class="bg-primary text-white p-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">AI Chatbot</h5>
        <button id="close-chat" class="btn btn-light btn-sm">X</button>
    </div>
    <div id="chat-container"></div>
    <div class="p-2 border-top">
        <div class="input-group">
            <input type="text" id="chat-input" class="form-control" placeholder="Type your message...">
            <button id="send-button" class="btn btn-primary">Send</button>
        </div>
    </div>
</div>

<!-- Floating Button -->
<button id="chat-toggle" class="btn btn-primary rounded-circle p-3">
    💬
</button>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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

</body>
</html>
