let secciones_NUEVO_BURRO = document.getElementById("secciones_NUEVO_BURRO");
let niveles_NUEVO_BURRO = document.getElementById("niveles_NUEVO_BURRO");

let handleChangeSecciones = () => {
    secciones_NUEVO_BURRO.addEventListener("input", (evt) => {
        evt.preventDefault();
        let contenedor_GRID_NUEVO_BURRO = document.getElementById("contenedor_GRID_NUEVO_BURRO");
        let contenido_GRID_NUEVO_BURRO = "";
        for (let fila = 1; fila <= secciones_NUEVO_BURRO.value; fila++) {
            contenido_GRID_NUEVO_BURRO += `<div class="row p-2 mb-1 justify-content-center">`;
            for (let columna = 1; columna <= niveles_NUEVO_BURRO.value; columna++) {
                contenido_GRID_NUEVO_BURRO += `<div class="col-xs bg-info text-white rounded p-1 m-1">N${columna}S${fila}</div>`;
            }
            contenido_GRID_NUEVO_BURRO += `</div>`;
        }
        contenedor_GRID_NUEVO_BURRO.innerHTML = contenido_GRID_NUEVO_BURRO
    });
};

let handleChangeNiveles = () => {
    niveles_NUEVO_BURRO.addEventListener("input", (evt) => {
        evt.preventDefault();
        let contenedor_GRID_NUEVO_BURRO = document.getElementById("contenedor_GRID_NUEVO_BURRO");
        let contenido_GRID_NUEVO_BURRO = "";
        for (let fila = 1; fila <= secciones_NUEVO_BURRO.value; fila++) {
            contenido_GRID_NUEVO_BURRO += `<div class="row p-2 mb-1 justify-content-center">`;
            for (let columna = 1; columna <= niveles_NUEVO_BURRO.value; columna++) {
                contenido_GRID_NUEVO_BURRO += `<div class="col-xs bg-info text-white rounded p-1 m-1">N${columna}S${fila}</div>`;
            }
            contenido_GRID_NUEVO_BURRO += `</div>`;
        }
        contenedor_GRID_NUEVO_BURRO.innerHTML = contenido_GRID_NUEVO_BURRO
    });
};
handleChangeSecciones();
handleChangeNiveles();