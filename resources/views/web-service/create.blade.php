<div class="modal fade" id="modalAdicionar" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header" style="padding: 35px 50px;">
                <h4 id="tituloModal">Cadastro novo Web Service</h4><h4 id="idEdicao"></h4>
            </div>
            <div class="modal-body" style="padding: 40px 50px;">
                <form role="form" action="/listagem/adicionar" method="post">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <input type="text" class="form-control" name="descricao" id="descricao" placeholder="Descreva o Web Service" required>
                    </div>
                    <div class="form-group">
                        <label for="api_server">Api Server</label>
                        <input type="text" class="form-control" name="api_server" id="api_server" placeholder="Api Server do Web Service" required>
                    </div>
                    <div class="form-group">
                        <label for="api_http_user">Api Http User</label>
                        <input type="text" class="form-control" name="api_http_user" id="api_http_user" placeholder="Digite o User" required>
                    </div>
                    <div class="form-group">
                        <label for="api_http_pass">Api Http Pass</label>
                        <input type="text" class="form-control" name="api_http_pass" id="api_http_pass" placeholder="Digite a senha do User" required>
                    </div>
                    <div class="form-group">
                        <label for="chave_acesso">Chave acesso</label>
                        <input type="text" class="form-control" name="chave_acesso" id="chave_acesso" placeholder="Digite a chave acesso" required>
                    </div>
                    <div class="form-group">
                        <label for="chave_name">Chave name</label>
                        <input type="text" class="form-control" name="chave_name" id="chave_name" placeholder="Digite a chave name" required>
                    </div>
                    <a class="voltar btn btn-danger" data-title="Deseja realmente voltar?" href="/listagem">Voltar</a>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/web-service/webservice-create.js') }}"></script>


