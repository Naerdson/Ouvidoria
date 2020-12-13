@extends('admin.layouts.master')
@section('titulo', 'Ouvidoria')
@section('content')
    <div class="d-flex justify-content-between">
        <h4 class="title-h">Gerenciamento de Ouvidorias</h4>
        <div class="row">
            <form action="{{ route('ouvidoria.home') }}">
                <div class="col d-flex">
                    <input type="text" name="filtro" class="form-control form-control-sm" placeholder="Pesquise pelo protocolo">
                    <button class="btn btn-info btn-sm ml-1"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body p-1">
                    @can('isOuvidoria')
                        <div class="row p-2">
                            <div class="col-md-6 col-lg-3 col-xlg-3">
                                <a href="?status=todas">
                                    <div class="card">
                                        <div class="box text-center bg-info">
                                            <h1 class="text-white"
                                                style="font-weight: 300;">{{ $countOuvidoria['total'] }}</h1>
                                            <h6 class="text-white">Total de ocorrências</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-lg-3 col-xlg-3">
                                <a href="?status=encaminhado">
                                    <div class="card">
                                        <div class="box text-center bg-warning">
                                            <h1 class="text-white"
                                                style="font-weight: 300;">{{ $countOuvidoria['encaminhado'] }}</h1>
                                            <h6 class="text-white">Encaminhadas</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-lg-3 col-xlg-3">
                                <a href="?status=concluido">
                                    <div class="card">
                                        <div class="box text-center bg-success">
                                            <h1 class="text-white"
                                                style="font-weight: 300;">{{ $countOuvidoria['concluido'] }}</h1>
                                            <h6 class="text-white">Concluídas</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-lg-3 col-xlg-3">
                                <a href="?status=aberto">
                                    <div class="card">
                                        <div class="box text-center bg-dark">
                                            <h1 class="text-white"
                                                style="font-weight: 300;">{{ $countOuvidoria['aberto'] }}</h1>
                                            <h6 class="text-white">Aberto</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endcan
                    @if(Session::has('message') && Session::has('type'))
                        <div class="alert alert-{{ Session::get('type') }} text-center mt-3">{{ Session::get('message') }}</div>
                    @endif
                    <div class="table-responsive mt-3 p-2">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-black-50">Status</th>
                                    <th class="text-black-50">Data de abertura</th>
                                    <th class="text-black-50">Protocolo</th>
                                    <th class="text-black-50">Categoria</th>
                                    <th class="text-black-50">Setor Responsável</th>
                                    <th class="text-black-50">Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach ($ouvidorias as $ocorrencia)
                                <tr>
                                    <td class="text-dark">
                                        @if($ocorrencia->status->nome == 'Encaminhado')
                                            <span class="span bg-warning">Encaminhado</span>
                                        @elseif($ocorrencia->status->nome == 'Aberto')
                                            <span class="span bg-dark">Aberto</span>
                                        @elseif($ocorrencia->status->nome == 'Concluido')
                                            <span class="span bg-success">Concluido</span>
                                        @elseif($ocorrencia->status->nome = 'Respondido por email')
                                            <span class="span bg-secondary">Respondido por email</span>
                                        @endif
                                    </td>
                                    <td class="text-dark">{{ date("d/m/Y H:i", strtotime($ocorrencia['created_at'])) }}</td>
                                    <td class="text-dark">{{ $ocorrencia['protocolo'] }}</td>
                                    <td class="text-dark">{{ $ocorrencia->categoria->nome }}</td>
                                    <td class="text-dark">{{ $ocorrencia->setor_responsavel->nome  }}</td>
                                    <td>
                                        @if ($ocorrencia->status->id == 3 && $ocorrencia->setor_responsavel->id == auth()->user()->setor_id)
                                            <form method="post"
                                                  action="{{ route('ouvidoria.home.encerrar', $ocorrencia['id']) }}"
                                                  style="display: inline"
                                                  onsubmit="return confirm('Deseja encerrar esta ocorrência?');">
                                                @csrf
                                                <input name="_method" type="hidden" value="PUT">
                                                <button class="btn btn-sm" style="background: #006767; color: #fff;">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if ($ocorrencia->status->id <= 3)
                                            @if($ocorrencia['tipo_contato_id'] == 1 && $ocorrencia->setor_responsavel->id == auth()->user()->setor_id)
                                                <button type="button" class="btn btn-primary btn-sm"
                                                        data-ocorrenciaid="{{ $ocorrencia['id'] }}"
                                                        data-email="{{ $ocorrencia['contato'] }}" data-toggle="modal"
                                                        data-target="#modalResponderOcorrencia">
                                                        <i class="fas fa-envelope"></i>
                                                </button>
                                            @elseif($ocorrencia->setor_responsavel->id == auth()->user()->setor_id)
                                                <a href="https://wa.me/55{{$ocorrencia['contato']}}" target="_blank" class="btn btn-success btn-sm">
                                                    <i class="fab fa-whatsapp"></i>
                                                </a>
                                                <form method="post"
                                                  action="{{ route('ouvidoria.home.encerrar', $ocorrencia['id']) }}"
                                                  style="display: inline"
                                                  onsubmit="return confirm('Deseja encerrar esta ocorrência?');">
                                                @csrf
                                                    <input name="_method" type="hidden" value="PUT">
                                                    <button class="btn btn-sm"  style="background: #006767; color: #fff;">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if($ocorrencia->status->id == 1 && $ocorrencia->setor_responsavel->id == 19 || $ocorrencia->status->id >= 2 && $ocorrencia->setor_responsavel->id == auth()->user()->setor_id)
                                                <button type="button" class="btn btn-warning btn-sm"
                                                        data-ocorrenciaid="{{ $ocorrencia['id'] }}"
                                                        data-toggle="modal"
                                                        data-target="#modalEncaminharOcorrencia">
                                                        <i class="fas fa-forward"></i>
                                                </button>
                                            @endif
                                        @endif
                           
                                        @if($ocorrencia['status']['id'] >= 2  && auth()->user()->setor_id == 19)
                                            <a href="{{ route('ouvidoria.historico', $ocorrencia['id']) }}">
                                                <button type="button" class="btn btn-info btn-sm">
                                                    <i class="fas fa-history"></i>
                                                </button>
                                            </a>
                                        @endif
                                        <button type="button" class="btn btn-dark btn-sm"
                                            data-toggle="modal" data-target="#modalDescricaoOcorrencia"
                                            data-nome="{{ $ocorrencia['nome'] }}"
                                            data-email="{{ $ocorrencia['contato'] }}"
                                            data-categoria="{{ $ocorrencia->categoria->nome }}"
                                            data-demandante="{{ $ocorrencia->demandante->nome }}"
                                            data-campus="{{ $ocorrencia->campus->nome }}"
                                            data-descricao="{{ $ocorrencia['descricao'] }}">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-md-flex justify-content-between pl-2 pr-2">
                        <div class="d-flex flex-md-row">
                            <p class="pr-3">
                                <i class="fas fa-history" style="color: #17a2b8;"></i> 
                                - Histórico
                            </p>
                            <p class="pr-3">
                                <i class="fas fa-envelope" style="color: #007bff;"></i>
                                - Responder por email
                            </p>
                            <p class="pr-3">
                                <i class="fab fa-whatsapp" style="color: #28a745;"></i>
                                - Responder por telefone
                            </p>
                            <p class="pr-3">
                                <i class="fas fa-check" style="color: #006767;"></i> 
                                - Encerrar
                            </p>
                            <p class="pr-3">
                                <i class="fas fa-forward" style="color: #e0a800;"></i> 
                                - Encaminhar
                            </p>
                            <p class="pr-3">
                                <i class="fas fa-info-circle" style="color: #23272B"></i> 
                                - Descrição da ocorrência
                            </p>
                        </div>
                        {{ $ouvidorias->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Responder Ocorrencia-->
    <div class="modal fade" id="modalResponderOcorrencia" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="title-h" id="exampleModalLabel">Responder Ocorrência</h5>
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
                        <div class="form-group">
                            <label for="mensagem">Responder para: </label>
                            <input type="text" class="form-control" name="email" id="email" disabled/>
                        </div>
                        <div class="form-group">
                            <label for="mensagem">Mensagem</label>
                            <textarea class="form-control" name="mensagem" id="mensagem" rows="6" required></textarea>
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
    <div class="modal fade" id="modalEncaminharOcorrencia" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="title-h" id="exampleModalLabel">Encaminhar Ocorrência</h5>
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
                            <label for="setor">Selecione o setor</label>
                            <select name="setor_id" id="setor" class="form-control">
                                <option disabled selected>Selecione</option>
                                @foreach($setores as $setor)
                                    @if($setor->id != 1 && $setor->id != 28)
                                        <option value="{{ $setor->id }}">{{ $setor->nome }}</option>
                                    @endif;
                                @endforeach
                            </select>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Encaminhar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="modalDescricaoOcorrencia">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="title-h">Descrição da ocorrência</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <span>Nome do demandante</span>
                        </div>
                        <div class="col-6">
                            <span>Contato</span>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <input type="text" id="nomeDemandante" class="form-control border-0" disabled>
                        </div>
                        <div class="col-6">
                            <input type="text" id="email" class="form-control border-0" disabled>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <span>Demandante</span>
                        </div>
                        <div class="col-6">
                            <span>Campus</span>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <input type="text" id="demandante" class="form-control border-0" disabled>
                        </div>
                        <div class="col-6">
                            <input type="text" id="campus" class="form-control border-0" disabled>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <span>Descrição</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <textarea id="descricao" class="form-control border-0" rows="6" disabled></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#modalResponderOcorrencia').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var ocorrencia_id = button.data('ocorrenciaid'); // Extract info from data-* attributes
            var email_ocorrencia = button.data('email');

            var modal = $(this)
            modal.find('.modal-body #ocorrencia_id').val(ocorrencia_id)
            modal.find('.modal-body #email').val(email_ocorrencia)
        });

        $('#modalEncaminharOcorrencia').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var ocorrencia_id = button.data('ocorrenciaid'); // Extract info from data-* attributes

            var modal = $(this)
            modal.find('.modal-body #ocorrencia_id').val(ocorrencia_id)
        });

        $('#modalDescricaoOcorrencia').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var nomeDemandante = (button.data('nome').length <= 0) ? 'Confidencial' : button.data('nome');
            var emailDemandante = button.data('email');
            var demandante = button.data('demandante');
            var campus = button.data('campus');
            var descricao = button.data('descricao');


            var modal = $(this)
            modal.find('.modal-body #nomeDemandante').val(nomeDemandante)
            modal.find('.modal-body #email').val(emailDemandante)
            modal.find('.modal-body #demandante').val(demandante)
            modal.find('.modal-body #campus').val(campus)
            modal.find('.modal-body #descricao').val(descricao)
        });
    </script>
@endsection
