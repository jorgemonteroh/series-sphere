$(document).ready(function() {
    $('.select-genero').select2({
        placeholder: 'Género',
        allowClear: true,
    });
    $('.select-plataforma').select2({
        placeholder: 'Plataforma',
        allowClear: true,
    });
    $('.select-lanzamiento').select2({
        placeholder: 'Fecha de Lanzamiento',
        allowClear: true
    });
});
