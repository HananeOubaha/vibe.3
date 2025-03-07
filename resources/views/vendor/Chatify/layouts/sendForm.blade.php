<div class="messenger-sendCard">
    <form id="message-form" method="POST" action="{{ route('send.message') }}" enctype="multipart/form-data">
        @csrf
        <label class="file-button">
            <span class="fas fa-paperclip"></span>
            <input disabled='disabled' type="file" class="upload-attachment" name="file"
                   accept=".{{implode(', .',config('chatify.attachments.allowed_images'))}},
                        .{{implode(', .',config('chatify.attachments.allowed_files'))}}" />
        </label>

        <button type="button" id="send-location-btn" class="location-btn">
            <span class="fas fa-map-marker-alt"></span>
        </button>

        <button class="emoji-button"><span class="fas fa-smile"></span></button>

        <textarea readonly='readonly' name="message" class="m-send app-scroll" placeholder="Type a message.."></textarea>

        <button disabled='disabled' class="send-button"><span class="fas fa-paper-plane"></span></button>
    </form>
</div>
