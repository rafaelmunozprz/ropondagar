class Funciones {
    /**
     * 
     * @param {*} porcentaje recibe el porcentaje de la orden
     * @returns el color de la barra de color dependiendo del avance de la orden
     */
    estiloProgressBar(porcentaje) {
        let color = ''
        if (porcentaje > 0 && porcentaje <= 25) color = 'bg-primary'
        else if (porcentaje > 25 && porcentaje <= 50) color = 'bg-success'
        else if (porcentaje > 50 && porcentaje <= 75) color = 'bg-warning'
        else if (porcentaje > 75) color = 'bg-danger'
        return color
    }
    /**
     * 
     * @param {Number} progreso número identificador del proceso de un orden
     * @returns 
     */
    progreso(progreso) {
        progreso = Math.floor(parseInt(progreso) * 5.26)
        if (progreso == 99) progreso = 100
        return progreso
    }

    input_number(input = '.number_format') {
        let $input = $(`${input}`);
        $input.click(function (e) {
            $(this).attr("type", "tel")
        }).focus(function (e) {
            $(this).attr("type", "tel")
        })
            .blur(function () {
                $(this).attr("type", "text")
            });
    }
    /**
     * 
     * @param {String} hora tiempo exacto en que fue realizada una orden
     * @returns {String} hora formateada en el modo dia mes, año
     */
    HORA(hora) {
        let nueva_hora
        hora = hora.split(":")
        if (parseInt(hora[0]) >= 0 && parseInt(hora[0]) < 12) {
            let hour = ''
            switch (parseInt(hora[0])) {
                case 0:
                    hour = '12'
                    break
                case 1:
                    hour = '01'
                    break
                case 2:
                    hour = '02'
                    break
                case 3:
                    hour = '03'
                    break
                case 4:
                    hour = '04'
                    break
                case 5:
                    hour = '05'
                    break
                case 6:
                    hour = '06'
                    break
                case 7:
                    hour = '07'
                    break
                case 8:
                    hour = '08'
                    break
                case 9:
                    hour = '09'
                    break
                case 10:
                    hour = '10'
                    break
                case 11:
                    hour = '11'
                    break
            }
            nueva_hora = hour + ':' + hora[1] + ' A.M.'
        } else if (parseInt(hora[0]) >= 12) {
            nueva_hora = hora[0] + ':' + hora[1] + ' P.M.'
        }
        return nueva_hora
    }
    MESES(m) {
        let mes = {
            1: 'Enero',
            2: 'Febrero',
            3: 'Marzo',
            4: 'Abril',
            5: 'Mayo',
            6: 'Junio',
            7: 'Julio',
            8: 'Agosto',
            9: 'Septiembre',
            10: 'Octubre',
            11: 'Noviembre',
            12: 'Diciembre',
        }
        return mes[m];
    }
    rellenarCero(numero, ceros = 5) {
        let cadena = "";
        for (let i = numero.length; i < ceros; i++) {
            cadena += '0';
        }
        cadena += numero;
        return cadena;
    }
    removeSpecialChars(str) {
        return str.replace(/(?!\w|\s)./g, '')
            .replace(/\s+/g, ' ')
            .replace(/^(\s*)([\W\w]*)(\b\s*$)/g, '$2')
            .replace(/ /g, "-")
            .trim();
    }
    normalize = (function () {
        var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÇç",
            to = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuucc",
            mapping = {};

        for (var i = 0, j = from.length; i < j; i++)
            mapping[from.charAt(i)] = to.charAt(i);

        return function (str) {
            var ret = [];
            for (var i = 0, j = str.length; i < j; i++) {
                var c = str.charAt(i);
                if (mapping.hasOwnProperty(str.charAt(i)))
                    ret.push(mapping[c]);
                else
                    ret.push(c);
            }
            return ret.join('');
        }

    })();
    fechaFormato(fecha) {
        /* Recibe una fecha en el formato yyyy-mm-dd */
        let dia, mes, anio
        fecha = fecha.split("-"),
            dia = parseInt(fecha[2]),
            mes = parseInt(fecha[1]),
            anio = parseInt(fecha[0]);
        return [dia, mes, anio];
    }
    number_format(amount, decimals) {

        amount += ''; // por si pasan un numero en vez de un string
        amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

        decimals = decimals || 0; // por si la variable no fue fue pasada

        // si no es un numero o es igual a cero retorno el mismo cero
        if (isNaN(amount) || amount === 0)
            return parseFloat(0).toFixed(decimals);

        // si es mayor o menor que cero retorno el valor formateado como numero
        amount = '' + amount.toFixed(decimals);

        var amount_parts = amount.split('.'),
            regexp = /(\d+)(\d{3})/;

        while (regexp.test(amount_parts[0]))
            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

        return amount_parts.join('.');
    }
    setAlarmStock(stock) {
        stock = parseInt(stock, 10)
        let style = ''
        if (stock == 0) {
            style = `style="color: red; font-weight: bold;"`
        } else if (stock > 0 && stock < 10) {
            style = `style="color: orange; font-weight: bold;"`
        } else {
            style = `style="color: green; font-weight: bold;"`
        }
        return style
    }
    setColor(color) {
        let style = ''
        switch (color) {
            case 'blanco':
                style = `style="background-color: #e1edf0; color: black;"`
                break;
            case 'kaki':
                style = `style="background-color: #c3b091; color: black;"`
                break;
            case 'perla':
                style = `style="background-color: #eae6ca; color: black;"`
                break;
            case 'rosa':
                style = `style="background-color: #dd969c; color: black;"`
                break;
            case 'morado':
                style = `style="background-color: #d29bfd; color: black;"`
                break;
            default:
                break;
        }
        return style
    }
    EXPRESION() {
        return {
            number: /^[0-9. ]*$/,
            text: /^[a-zA-Z0-9. ]*$/,
            num_text: /^[a-zA-Z0-9. - ]*$/,
            sup_text: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ. ]*$/,
            num_sup_text: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9.·#!¡?¿@ \- _ / ]*$/,
            email: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/,
        };
    }
}