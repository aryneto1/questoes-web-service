$(document).ready(function () {
    $("#adicionar").click(function () {
        $("#modalAdicionar").modal({backdrop: 'static', keyboard: false});
    });

});
$('a.voltar').confirm({
    content: 'Todas as alterações serão perdidas.',
    buttons: {
        Voltar: {
            text: 'Voltar',
            btnClass: 'btn btn-danger',
            action: function () {
                location.href = this.$target.attr('href');
            }
        },
        Cancelar: {
            text: 'Cancelar',
            btnClass: 'btn btn-secondary',
            action: function () {
            }
        }
    }
});