class Anaqueles {
    Anaqueles(contenedor, active = false) {
        $.ajax({
            type: "POST",
            url: RUTA + "back/anaqueles",
            data: "opcion=mostrar_anaqueles",
            dataType: "JSON",
            error: function (xhr, status) {
                console.log(xhr.responseText)
            },
            success: function (data) {
                if(data.response == "success"){
                    let options = ""
                    for(const anaquel of data.data){
                        options += `<option value="${anaquel.codigo_anaquel}" ${active==anaquel.codigo_anaquel?"selected":""}>${anaquel.codigo_anaquel}</option>`
                    }
                    contenedor.html(`   <label for="Anaquel">Anaquel</label>
                                        <select class="form-control form-control-sm" name="codigo_anaquel">"${options}"</select>`)
                }
            }
        });
    }
}