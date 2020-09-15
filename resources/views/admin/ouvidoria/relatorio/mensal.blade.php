@extends('admin.pdf.layout')

@section('content')
    @section('title')
        <h4 class="text-center text-uppercase mt-3 mb-1">RELATÓRIO OUVIDORIA - {{ strftime('%B', strtotime('today')) }}</h4>
    @endsection

    <div class="content">
        <div class="mb-2">
            <h5>DEMANDANTES</h5>
        </div>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Quantidade</th>
                    <th>Porcentagem</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['DEMANDANTES'] as $relatorio)
                    <tr>
                        <td>{{ $relatorio->DEMANDANTES }}</td>
                        <td>{{ $relatorio->QTD_DEMANDANTE }}</td>
                        <td>{{ $relatorio->PORCENTAGEM }}%</td>
                    </tr>
                @endforeach
                <tr>
                    <td><b>Totais</b></td>
                    <td><b>{{$data['DEMANDANTES'][0]->TOTAL_OCORRENCIAS}}</b></td>
                    <td><b>{{ str_replace(".", "", substr($data['DEMANDANTES'][0]->PORCENTAGEM_TOTAL,0, 3)) }}%</b></td>
                </tr>
            </tbody>
        </table>

        <div class="mb-2">
            <h5>DEMANDAS</h5>
        </div>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Quantidade</th>
                    <th>Porcentagem</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['DEMANDAS'] as $relatorio)
                    <tr>
                        <td>{{ $relatorio->CATEGORIAS }}</td>
                        <td>{{ $relatorio->QTD_CATEGORIA }}</td>
                        <td>{{ $relatorio->PORCENTAGEM }}%</td>
                    </tr>
                @endforeach
                <tr>
                    <td><b>Totais</b></td>
                    <td><b>{{$data['DEMANDANTES'][0]->TOTAL_OCORRENCIAS}}</b></td>
                    <td><b>{{ str_replace(".", "", substr($data['DEMANDAS'][0]->PORCENTAGEM_TOTAL,0, 3)) }}%</b></td>
                </tr>
            </tbody>
        </table>

        <div class="mb-2">
            <h5>RECLAMAÇÕES</h5>
        </div>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Demandante</th>
                    <th>Descrição</th>
                    <th>Campus</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['RECLAMACOES'] as $reclamacao)
                    <tr>
                        <td>{{ $reclamacao->demandante->nome }}</td>
                        <td>{{ $reclamacao->descricao }}</td>
                        <td>{{ $reclamacao->campus->nome }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection