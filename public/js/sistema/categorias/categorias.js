class Categorias {
  categorias(contenedor, active=false) {
    $.ajax({
      type: "POST",
      url: RUTA+"back/categorias",
      data: "opcion=mostrar_categorias_prima",
      dataType: "JSON",
      error: function (xhr,status) {console.log(xhr.responseText);},
      success: function (data) {
        if (data.response == "success") {
          let options = "";
          for (const categoria of data.data) {
            options += `<option value="${categoria.id_categoria}" ${active==categoria.id_categoria?"selected":""}>${categoria.nombre}</option>`;
          }
          contenedor.html(`<label for="categoria">Categoria</label>
                           <select class="form-control form-control-sm" name="id_categoria">${options}</select>`);
        }
      },
    });
  }
}
