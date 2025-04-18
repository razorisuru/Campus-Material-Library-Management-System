@extends('layouts.auth')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/auth/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/auth/compiled/css/table-datatable.css') }}">
    <style>
        #chat-container {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
            /* border: 1px black solid; */
        }

        #chat-input-container {
            /* position: fixed;
                            bottom: 0; */
        }

        .chat-message {
            margin-bottom: 10px;
        }

        .user-message {
            text-align: right;
        }

        .ai-message {
            text-align: left;
        }
    </style>
@endsection

@section('content')
    <div id="chat-container" class="container-fluid">
        <!-- Messages will be appended here -->
    </div>

    <!-- Chat Input -->
    <div id="chat-input-container" class="container-fluid mt-3 mb-3">
        <div class="input-group">
            <input type="text" id="chat-input" class="form-control" placeholder="Type your message here...">
            <button id="send-button" class="btn btn-primary">Send</button>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const chatContainer = $("#chat-container");

            // Function to append a new message to the chat
            function addMessage(content, isUser = true) {
                const messageClass = isUser ? "user-message" : "ai-message";
                const messageHtml = `<div class="chat-message ${messageClass}"><h3>${content}</h3></div>`;
                chatContainer.append(messageHtml);
                chatContainer.scrollTop(chatContainer.prop("scrollHeight"));
            }

            // Function to format and structure the AI response
            function formatAIResponse(responseText) {
                const paragraphs = responseText.split("\n\n");
                let formattedHTML = "";

                paragraphs.forEach((paragraph) => {
                    if (paragraph.startsWith("**") && paragraph.endsWith("**")) {
                        // Heading
                        formattedHTML += `<h3>${paragraph.replace(/\*\*/g, "")}</h3>`;
                    } else if (paragraph.startsWith("*")) {
                        // List items
                        const listItems = paragraph
                            .split("\n")
                            .map((item) => `<li>${item.replace(/^\*+\s*/, "")}</li>`)
                            .join("");
                        formattedHTML += `<ul>${listItems}</ul>`;
                    } else if (paragraph.startsWith("```java")) {
                    // Code block
                    const code = paragraph.replace(/```java/g, "");
                        formattedHTML += `<pre><code>${code}</code></pre>`;
                    } else {
                        // Regular paragraph
                        formattedHTML += `<p>${paragraph}</p>`;
                    }
                });

                return formattedHTML;
            }

            // Handle send button click
            $("#send-button").click(function() {
                const userInput = $("#chat-input").val().trim();
                if (userInput) {
                    addMessage(userInput, true); // Add user message
                    $("#chat-input").val(""); // Clear input

                    // Simulate AI response with AJAX
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
                            console.log("AI Response:", responseText);
                            const formattedResponse = formatAIResponse(responseText);
                            addMessage(formattedResponse, false); // Add formatted AI message
                        },
                        error: function(xhr, status, error) {
                            let errorMessage = "Error: " + xhr.status + " " + xhr.statusText;
                            if (xhr.responseText) {
                                try {
                                    const responseJson = JSON.parse(xhr.responseText);
                                    if (responseJson.error && responseJson.error.message) {
                                        errorMessage += " - " + responseJson.error.message;
                                    }
                                } catch (e) {
                                    errorMessage += " - " + xhr.responseText;
                                }
                            }
                            addMessage(errorMessage, false);
                            console.error("Detailed error:", xhr);
                        },
                    });
                }
            });

            // Handle Enter key for sending messages
            $("#chat-input").keypress(function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $("#send-button").click();
                }
            });
        });
    </script>
@endsection

@section('scripts')
    <script src="{{ asset('assets/auth/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/auth/static/js/pages/simple-datatables.js') }}"></script>
@endsection
