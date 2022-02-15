class Storage {
    constructor(storage_name) {
        this.storage_name = storage_name;
        this.template_note = {
            "usuario": {
                "id": false,
                "tipo": false, //empleado,proveedor,cliente
                "data": false, //Todos los datos del cliente
            },
            "productos": [
                // {
                //     "id": 1,
                //     "tipo": "materia_prima", //modelo, materia_prima
                //     "cantidad": 1,
                //     "data": {datos},
                // }
            ],
            "descuentos": {
                "tipo": "moneda",
                "cantidad": 0
            },
            "fecha": false,
            "iva": false
        };
    }

    mostrar_nota() {
        let datos = false;
        let lista;
        if (lista = localStorage.getItem(this.storage_name)) {
            datos = JSON.parse(lista);
        } else {
            datos = this.template_note;
        }
        return datos;
    }
    total_nota() {
        let nota = this.mostrar_nota();
        let resultado = { "total": 0, "iva": false, "subtotal": 0, "descuento": 0 };
        for (const producto of nota.productos) {
            resultado.subtotal = parseFloat(resultado.subtotal) + (parseFloat(producto.precio_venta) * producto.cantidad); //suma el precio
        }

        let descuento = nota.descuentos.tipo == 'moneda' ? nota.descuentos.cantidad : ((nota.descuentos.cantidad * resultado.subtotal) / 100); //calculamos el descuento, convertimos el porcentaje a moneda
        resultado.descuento = parseFloat(descuento);
        resultado.iva = nota.iva; //Indica si ya viene la nota con iva o no

        resultado.total = (resultado.subtotal - resultado.descuento);
        resultado.total = (resultado.total * (nota.iva ? 1.16 : 1));

        return resultado;
    }
    mostrar_producto(id_producto, tipo) {
        let nota = this.mostrar_nota();
        for (const producto of nota.productos) // recorre todos los productos
            if (producto.id == id_producto && producto.tipo == tipo) return producto; // solo guarda los productos que no sean el seleccionado
    }
    guardar_nota(lista) {
        localStorage.setItem(this.storage_name, lista);
    }
    agregar_productos(new_producto) {
        let nota = this.mostrar_nota();
        let productos = nota.productos;
        let encontrado = false;
        let tipo_c = nota.usuario.data ? nota.usuario.data.tipo_cliente : 'menudeo';
        new_producto.precio_venta = (tipo_c == 'menudeo' ? new_producto.precio_menudeo : new_producto.precio_mayoreo);

        for (const i_prod in productos) {
            let producto = productos[i_prod]; // Se separa el producto para acceder a el
            if (producto.id == new_producto.id && producto.tipo == new_producto.tipo) { // Evaluamos que sea el correcto
                let total = producto.data.cantidad - producto.data.vendido;
                // console.log(producto);
                encontrado = true; // Se encontró coincidencia
                producto.cantidad = (parseFloat(producto.cantidad) + parseFloat(new_producto.cantidad)); //suma las cantidades en caso de que hallá más
                producto.data = new_producto.data; // Reescribe la data del nuevo producto
                producto.precio_venta = new_producto.precio_venta;
                productos[i_prod] = producto;

                if (producto.cantidad > total)
                    return { status: false, text: "La cantidad excede el stock actual del producto seleccionado" };
            }
        }
        if (!encontrado) productos.push(new_producto); //agrega el nuevo producto en caso de que no este en la nota
        nota.productos = productos;

        this.guardar_nota(JSON.stringify(nota)); // Se guarda la nota completa despues de editar lo que se necesita

        return { status: true, text: "La nota fue actualizada correctamente" };
    }
    borrar_elemento(id, tipo) {
        let nota = this.mostrar_nota();
        let productos = [];
        for (const producto of nota.productos) // recorre todos los productos
            if (producto.id != id || producto.tipo != tipo) productos.push(producto); // solo guarda los productos que no sean el seleccionado

        nota.productos = productos; // Actualiza la lista
        this.guardar_nota(JSON.stringify(nota));
        return nota;
    }
    actualizar_producto(producto) {
        let nota = this.mostrar_nota();
        let productos = [];
        for (const prod of nota.productos) // recorre todos los productos
            if (prod.id == producto.id && prod.tipo == producto.tipo) {
                // solo guarda los productos que no sean el seleccionado
                let total = prod.data.cantidad - prod.data.vendido;
                if (producto.cantidad > total) return { status: false, text: "La cantidad excede el stock actual del producto seleccionado" };
                else if (producto.cantidad > 0) productos.push(producto);
            }
            else productos.push(prod); //Guarda los que no se modifican

        nota.productos = productos; // Actualiza la lista
        this.guardar_nota(JSON.stringify(nota));
        return { status: true, text: "La nota fue actualizada correctamente" };
    }
    borrar_nota() {
        localStorage.removeItem(this.storage_name);
    }
    borrar(){
        localStorage.removeItem('venta_notas')
    }
}