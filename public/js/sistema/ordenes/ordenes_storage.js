class OrdenesStorage {

    /**
     * 
     * @param {Number} id_modelo idetificador del producto en la base de datos
     * @param {String} codigo identificador de nombre del producto
     * @param {Number} cantidad cantidad de productos para agregar a la lista de la orden
     */
    guardar_en_lista(id_modelo, codigo, cantidad) {
        let orden = this.cargar_orden()
        if (orden.length == 0) {
            orden.push({ "id_modelo": `${id_modelo}`, "codigo": codigo, "cantidad": cantidad })
            localStorage.setItem('nueva_orden', JSON.stringify(orden))
        } else {
            let index = orden.findIndex(modelo => modelo.id_modelo === id_modelo)
            if (index == -1) {
                orden.push({ "id_modelo": `${id_modelo}`, "codigo": codigo, "cantidad": cantidad })
                localStorage.setItem('nueva_orden', JSON.stringify(orden))
            } else {
                let last = parseInt(orden[index].cantidad)
                let now = parseInt(cantidad)
                orden[index].cantidad = `${(last + now)}`
                localStorage.setItem('nueva_orden', JSON.stringify(orden))
            }
        }
    }

    /**
     * 
     * @returns Carga en memoria el objeto "nueva_orden"
     */
    cargar_orden() {
        let nueva_orden = Array()
        if (localStorage.getItem('nueva_orden')) {
            nueva_orden = localStorage.getItem('nueva_orden')
        } else {
            localStorage.setItem('nueva_orden', JSON.stringify(nueva_orden))
            nueva_orden = localStorage.getItem('nueva_orden')
        }
        nueva_orden = JSON.parse(nueva_orden)
        return nueva_orden
    }

    /**
     * 
     * @param {String} codigo codigo de identificación del producto para eliminar del item "nueva_orden"
     */
    eliminar_articulo(codigo) {
        let orden = this.cargar_orden(), nueva_orden = []
        for (const articulo of orden) {
            if (articulo.codigo != codigo) nueva_orden.push(articulo)
        }
        localStorage.removeItem('nueva_orden')
        localStorage.setItem('nueva_orden', JSON.stringify(nueva_orden))
    }

    /**
     * Elimina, el item "nueva_orden" y lo vuelve a crear en un estado vacío
     */
    limpiar_orden_nueva() {
        let orden = []
        localStorage.removeItem('nueva_orden')
        localStorage.setItem('nueva_orden', JSON.stringify(orden))
    }
}