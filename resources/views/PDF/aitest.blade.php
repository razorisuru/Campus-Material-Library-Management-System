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
        #chat-container {
            height: 500px;
            overflow-y: auto;
            padding: 15px;
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            margin-bottom: 20px;
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
    </style>
</head>
<body>

<div class="container py-5">
    <h2 class="text-center mb-4">AI Chatbot</h2>

    <div id="chat-container"></div>

    <div class="input-group">
        <input type="text" id="chat-input" class="form-control" placeholder="Type your message...">
        <button id="send-button" class="btn btn-primary">Send</button>
    </div>
</div>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
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
    });
</script>

</body>
</html>
