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
            let mensagemErro = "";
            if (data.arrayArqNaoVazio != undefined) {
                $.each(data.arrayArqNaoVazio, function (index, arqDownload) {
                    var link = document.createElement('a');
                    link.href = window.urlDisciplina + arqDownload;
                    link.download = arqDownload;
                    link.click();
                    contador++;
                });
            }
            if (data.arrayArqVazio != undefined) {
                $.each(data.arrayArqVazio, function (index, arqVazio){
                    mensagemErro += ", " + arqVazio;
                });
            }
            if(contador != 0)
                toastr.success("Baixado " + contador + " arquivos com sucesso!");

            if(mensagemErro != "")
                toastr.error("Ocorreu um erro no(s) arquivo(s) " + mensagemErro);
        },
        error: function () {
            toastr.error("Erro no download!");
        }
    });
})