    function previewImage(input) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    const removeButton = document.getElementById('removeImage');

    if (input.files && input.files[0]) {
    const reader = new FileReader();

    reader.onload = function(e) {
    preview.src = e.target.result;
    previewContainer.classList.remove('hidden');
}

    reader.readAsDataURL(input.files[0]);
}

    removeButton.addEventListener('click', function() {
    input.value = '';
    previewContainer.classList.add('hidden');
});
}
