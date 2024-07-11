    $(document).ready(function() {
        $('#categories').select2({
            placeholder: 'カテゴリーを選択してください（最大3つまで選択可能）',
            maximumSelectionLength: 3
        });
    });

    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('image_preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }