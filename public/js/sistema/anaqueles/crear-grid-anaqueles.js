"use strict";

let filas_anaquel = document.getElementById("filas_anaquel");
let columnas_anaquel = document.getElementById("columnas_anaquel");

let handleChangeFilas = () => {
    filas_anaquel.addEventListener("input", (evt) => {
        evt.preventDefault();
        let contenedor_filas = document.getElementById("container-filas-columnas");
        let contenedor = "";
        for (let fila = 1; fila <= filas_anaquel.value; fila++) {
            contenedor += `<div class="row p-2 mb-1 justify-content-center">`;
            for (let columna = 1; columna <= columnas_anaquel.value; columna++) {
                contenedor += `<div class="col-xs bg-info text-white rounded p-1 m-1">F${fila}C${columna}</div>`;
            }
            contenedor += `</div>`;
        }
        contenedor_filas.innerHTML = contenedor
    });
};

let handleChangeColumnas = () => {
    columnas_anaquel.addEventListener("input", (evt) => {
        evt.preventDefault();
        let contenedor_filas = document.getElementById("container-filas-columnas");
        let contenedor = "";
        for (let fila = 1; fila <= filas_anaquel.value; fila++) {
            contenedor += `<div class="row p-2 mb-1 justify-content-center">`;
            for (let columna = 1; columna <= columnas_anaquel.value; columna++) {
                contenedor += `<div class="col-xs bg-info text-white rounded p-1 m-1">F${fila}C${columna}</div>`;
            }
            contenedor += `</div>`;
        }
        contenedor_filas.innerHTML = contenedor
    });
};
handleChangeFilas();
handleChangeColumnas();