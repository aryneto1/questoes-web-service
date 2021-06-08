$(".botEditar").click(function () {
    // ajax
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: window.urlListagem,
        data: { id: $(this).data('id') },
        cache: false,
        type: "POST",
        success: function (data) {
            $("#modalAdicionar").modal({backdrop: 'static', keyboard: false});
            $("#id").val(data.id);
            $("#tituloModal").html("Editar Web Service");
            $("#idEdicao").html("ID: " + data.id);
            $("#descricao").val(data.descricao);
            $("#api_server").val(data.api_server);
            $("#api_http_user").val(data.api_http_user);
            $("#api_http_pass").val(data.api_http_pass);
            $("#chave_acesso").val(data.chave_acesso);
            $("#chave_name").val(data.chave_name);

        },
    })

});