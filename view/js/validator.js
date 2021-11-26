$(document).ready(function () {
    $('#eje3').bootstrapValidator({
        message: 'Este valor no es valido',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nombre: {
                message: 'Nombre no valido',
                validators: {
                    notEmpty: {
                        message: ' Se requiere el nombre de usuario'
                    },
                    regexp: {
                        regexp: /^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/,
                        message: ' La primer letra en mayúscula. Solo letras.'
                    }
                }
            },
            apellido: {
                message: 'Apellido no valido',
                validators: {
                    notEmpty: {
                        message: ' El apellido es obligatorio'
                    },
                    regexp: {
                        regexp: /^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/,
                        message: ' La primer letra en mayúscula. Solo letras.'
                    }
                }
            },
            edad: {
                message: 'Edad no valida',
                validators: {
                    notEmpty: {
                        message: ' La edad es obligatoria'
                    }
                }
            },
            direccion: {
                message: 'Dirección invalida',
                validators: {
                    notEmpty: {
                        message: ' Se requiere una dirección'
                    }
                }
            }
        },

    });
});



$(document).ready(function () {
    $('#tp3eje2').bootstrapValidator({
        message: 'Este valor no es valido',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            archivo: {
                validators: {
                    notEmpty: {
                        message: ' Envie un archivo'
                    },
                    file: {
                        maxSize: 1024 * 1024 * 2,
                        extension: 'txt',
                        type: 'txt',
                        message: ' Solo se permiten archivos .txt'
                    }
                }
            },
            nacion: {
                validators: {
                    notEmpty: {
                        message: ' La nacionalidad es obligatoria'
                    },
                    regexp: {
                        regexp: /^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/,
                        message: ' La primer letra en mayúscula. Solo letras.'
                    }
                }
            }
        },
    });
});