function previewFile() {
  var preview = document.getElementById('imgPreview');
  var file    = document.querySelector('input[name=photoUpload]').files[0];
  var reader  = new FileReader();

  reader.addEventListener("load", function () {
    preview.src = reader.result;
  }, false);

  if (file) {
    reader.readAsDataURL(file);
  }
}

function previewHouse() {
  var preview = document.getElementById('imgPreviewHouse');
  var file    = document.querySelector('input[name=photoToUpload]').files[0];
  var reader  = new FileReader();

  reader.addEventListener("load", function () {
    preview.src = reader.result;
  }, false);

  if (file) {
    reader.readAsDataURL(file);
  }
}