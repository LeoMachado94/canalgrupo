<!-- Modal -->
<div class="modal fade" id="sendMailModal" tabindex="-1" role="dialog" aria-labelledby="exSendMailModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exSendMailModalTitle">Enviar Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form groups used in grid -->
                <form class="form-send-email" method="POST" action="{{ route('ajax.reports.sendMail', ['ID', 'CLIENT']) }}" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            Será enviado um email para cada endereço cadastrado do cliente.
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-salvar btn-send-email">Enviar</button>
            </div>
        </div>
    </div>
</div>
