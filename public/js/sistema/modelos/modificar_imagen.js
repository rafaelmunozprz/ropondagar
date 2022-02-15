function modificar_imagen(modelo, modal_activo, imagen_antigua) {
    var avatar = document.getElementById('avatar');
    var image = document.getElementById('image');
    var input = document.getElementById('input');
    var $progress = $('.progress');
    var $progressBar = $('.progress-bar');
    var $alert = $('.alert');
    var $modal = $('#modal');
    var cropper;

    $('[data-toggle="tooltip"]').tooltip();
    $("#input").off();
    var name = "imagen.jpg";
    $("#input").off().change(function (e) {
        e.preventDefault();
        modal_activo.modal("hide");
        var files = e.target.files;
        var done = function (url) {
            input.value = '';
            image.src = url;
            $alert.hide();
            $modal.modal({ backdrop: 'static', keyboard: false });
            $modal.modal('show');
        };
        var reader;
        var file;
        var url;
        if (files && files.length > 0) {
            file = files[0];
            name = file.name;
            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });
    $modal.off().on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
            aspectRatio: 16 / 17,
            viewMode: 1,
        });
    }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
    });

    $("#crop").off().click(function (e) {
        e.preventDefault();
        var initialAvatarURL;
        var canvas;

        $modal.modal('hide');
        modal_activo.modal("show");

        if (cropper) {
            canvas = cropper.getCroppedCanvas({
                width: 980,
                height: 980,
            });
            initialAvatarURL = avatar.src;
            avatar.src = canvas.toDataURL();
            $progress.show();
            $alert.removeClass('alert-success alert-warning');
            canvas.toBlob(function (blob) {
                var formData = new FormData();

                formData.append('imagen', blob, name);
                formData.append('opcion', 'cargar_imagen');
                formData.append('id_modelo', modelo.id_modelo);

                let attr_val = "";
                if (attr_val = $("#editar_modelo").find("img").attr("data-id-image")) {
                    formData.append('id_galeria_modelo', attr_val);
                }

                $.ajax(RUTA + `back/modelos/galeria`, {
                    method: 'POST',
                    data: formData,
                    processData: false,
                    dataType: 'JSON',
                    contentType: false,

                    xhr: function () {
                        var xhr = new XMLHttpRequest();

                        xhr.upload.onprogress = function (e) {
                            var percent = '0';
                            var percentage = '0%';

                            if (e.lengthComputable) {
                                percent = Math.round((e.loaded / e.total) * 100);
                                percentage = percent + '%';
                                $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
                            }
                        };

                        return xhr;
                    },

                    success: function (data) {
                        $alert.show().addClass('alert-success').text(data.text);
                        modal_activo.modal("show");
                        $("#editar_modelo").find("img").attr("src", `${RUTA + data.imagen}`).attr("data-id-image", data.id_modelo_imagen); //Cambia la imagen del formulario
                        imagen_antigua.attr("src", `${RUTA + data.imagen}`); //Cambia la imagen de la targeta
                        setTimeout(() => {
                            $alert.hide();
                        }, 3500);
                    },

                    error: function (xhr, status) {
                        console.log(xhr.responseText);
                        $alert.show().addClass('alert-warning').text('Upload error');
                    },

                    complete: function () {
                        $progress.hide();
                    },
                });
            });
        }
    });
    // document.getElementById('crop').addEventListener('click', function () {

    // });
}