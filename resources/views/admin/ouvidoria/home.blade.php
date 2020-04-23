@extends('admin.layouts.master')
@section('content')
    <h1>Home Ouvidoria</h1>
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Data de abertura</th>
				<th scope="col">Protocolo</th>
				<th scope="col">Categoria</th>
				<th scope="col">Status</th>
                <th scope="col">Setor Responsável</th>
				<th scope="col">Ações</th>
			</tr>
		</thead>
		<tbody>
            @foreach ($ouvidorias as $ocorrencia)
                @if(Auth::user()->setor_id == 4 ||$ocorrencia->setor_responsavel_id == Auth::user()->setor_id )
                    <tr>
                        <td>{{ $ocorrencia->data }}</td>
                        <td>{{ $ocorrencia->protocolo }}</td>
                        <td>{{ $ocorrencia->categoria }}</td>
                        <td>{{ $ocorrencia->status }}</td>
                        <td>{{ $ocorrencia->setor_responsavel  }}</td>
                        <td>
                            @if($ocorrencia->setor_responsavel_id == Auth::user()->setor_id)
                                <button type="button" class="btn btn-primary btn-sm" data-ocorrenciaid="{{ $ocorrencia->id }}" data-email="{{ $ocorrencia->email }}" data-toggle="modal" data-target="#modalResponderOcorrencia">Responder</button>
                                <button type="button" class="btn btn-success btn-sm" data-ocorrenciaid="{{ $ocorrencia->id }}" data-toggle="modal" data-target="#modalEncaminharOcorrencia">Encaminhar</button>
                            @else
                                <button type="button" class="btn btn-primary btn-sm">Histórico</button>
                            @endif

                        </td>
                    </tr>
                @endif
			@endforeach
		</tbody>
	</table>

<!-- Modal Responder Ocorrencia-->
<div class="modal fade" id="modalResponderOcorrencia" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Responder Ocorrência</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('ouvidoria.home.responder.email')  }}">
                    @csrf
                    <input name="_method" type="hidden" value="PUT">
                    <input type="hidden" name="ocorrencia_id" id="ocorrencia_id">
                    <input type="hidden" name="status_ocorrencia_id" value="3">
                    <input type="hidden" class="form-control" name="email" id="email" />
                    <div class="form-group">
                        <label for="mensagem">Mensagem</label>
                        <textarea class="form-control" name="mensagem" id="mensagem" rows="6"></textarea>
                    </div>

            </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
        </div>
    </div>
</div>

<!-- Modal Encaminhar Ocorrencia-->
<div class="modal fade" id="modalResponderOcorrencia" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Encaminhar Ocorrência</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('ouvidoria.home.encaminhar') }}">
                @csrf
                    <input name="_method" type="hidden" value="PUT">
                    <input type="hidden" name="ocorrencia_id" id="ocorrencia_id">
                    <input type="hidden" name="status_ocorrencia_id" value="2">
                    <div class="form-group">
                        <label for="setor">Setores</label>
                        <select name="setor_id" id="setor" class="form-control">
                            <option value="1">Técnologia da Informação</option>
                            <option value="2">Atendimento ao Aluno</option>
                            <option value="3">Financeiro</option>
                            <option value="4">Ouvidoria</option>
                        </select>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Encaminhar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#modalEncaminharOcorrencia, #modalResponderOcorrencia').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var ocorrencia_id = button.data('ocorrenciaid'); // Extract info from data-* attributes
        var email_ocorrencia = button.data('email');

        var modal = $(this)
        modal.find('.modal-body #ocorrencia_id').val(ocorrencia_id)
        modal.find('.modal-body #email').val(email_ocorrencia)
    });

</script>
@endsection
