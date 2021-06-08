<style>
    .alerta {
        margin-right: 184px;
        margin-left: 184px;
    }
</style>
@if(!empty($mensagem))
    <div class="alert alert-success alerta">
        {{ $mensagem }}
    </div>
@endif
