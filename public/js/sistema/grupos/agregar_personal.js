
/**
 * 
 * @param {Array.<string>} users lista de usuarios que seraán agregados al grupo seleccionado
 * @param {Number} id_grupo_trabajo identificador del grupo que será relacionado con el personals
 */
function agregar(users, id_grupo_trabajo){    
        let GRUPOS = new Grupos()
        GRUPOS.agregar_personal(users, id_grupo_trabajo)
}