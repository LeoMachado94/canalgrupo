<!-- Modal -->
<div class="modal fade" id="createSubjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Cadastrar Assunto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form groups used in grid -->
                <form class="form-save-subject" method="POST" action="{{ route('subjects.store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-control-label" for="ClientModal">Cliente</label>
                            <select class="form-control" name="client_id"
                                    id="ClientModal" data-toggle="select">
                                <option>Selecione o Cliente</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="Active">Situação</label>
                                <select class="form-control" name="active"
                                        id="Active" data-toggle="select">
                                    <option value="1">Ativo</option>
                                    <option value="0">Inativo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label" for="Title">Título</label>
                                <input type="text" name="title" class="form-control"
                                       value="" id="Title" placeholder="Qual o Título do Assunto ?">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger error-messages"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-salvar btn-save-subject">Salvar</button>
            </div>
        </div>
    </div>
</div>
