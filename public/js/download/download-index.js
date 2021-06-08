$(document).ready( function(){
    $('#botao').click( function(){
        toastr.warning("Aguarde, baixando...");
    });
});
$("#botao").click(function () {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: window.rotaDownload,
        data: { id: $("#selecao").val(), disciplina: $("#disciplina").val() },
        dataType: "json",
        cache: false,
        type: "POST",
        success: function (data) {
            console.log(data);
            let contador = 0;
            let mensagemErro;
            $.each(data.arrayArqNaoVazio, function (index, arqDownload) {
                var link = document.createElement('a');
                link.href = window.urlDisciplina + arqDownload;
                link.download = arqDownload;
                link.click();
                contador++;
            });
            $.each(data.arrayArqVazio, function (index, arqVazio){
                mensagemErro += ", " + arqVazio;
            });

            toastr.success("Baixado " + contador + " arquivos com sucesso!");
            toastr.error("Ocorreu um erro no(s) arquivo(s) " + mensagemErro);
        },
        error: function () {
            toastr.error("Erro no download!");
        }
    });
})