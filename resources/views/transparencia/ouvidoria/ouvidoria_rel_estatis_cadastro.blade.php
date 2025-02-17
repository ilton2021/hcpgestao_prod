@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid" style="margin-top: 25px;">
    <div class="d-flex justify-content-around align-items-center">
        <a class="btn btn-warning btn-sm" href="{{route('transparenciaOuvidoria', $unidade->id)}}" style="color:white;"><i class="fas fa-reply"></i> <b>Voltar</b></a>
        <h5 class="m-1" style="font-size: 18px;">Relatório estastístico - PAI</h5>
        <a class="btn btn-dark btn-sm" href="{{route('novoOVRelatorioES', $unidade->id)}}"><b>Novo</b> <i class="fas fa-check"></i></a>
    </div>
    @if ($errors->any())
    <div class="alert alert-success text-center">
        <ul style="list-style: none;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-1 col-sm-0"></div>
        <div class="col-md-10 col-sm-12 text-center">
            @foreach ($relatoriosEs->pluck('ano')->unique() as $ano)
            <div class="d-inline-flex flex-wrap">
                <div class="p-2">
                    <a class="btn btn-success" data-toggle="collapse" href="#{{$ano}}" role="button" aria-expanded="false" aria-controls="{{$ano}}">{{$ano}}</a>
                </div>
            </div>
            @endforeach
            @if(sizeof($relatoriosEs) > 0)
            @foreach ($relatoriosEs->pluck('ano')->unique() as $RF)
            <div class="collapse border border-success m-2 rounded" id="{{$RF}}">
                <div class="card card-body border-0" style="background-color: #fafafa">
                    @foreach ($relatoriosEs as $item)
                    @if ($item->ano == $RF)
                    <div class="d-flex flex-column justify-content-center border-bottom border-success">
                        <div class="d-md-inline-flex justify-content-between align-items-center">
                            <div class="p-1" style="font-size:16px;">
                                <b>Relatório estastístico - </b>
                                <span class="badge badge-secondary"><b>{{$item->mes}}/{{$item->ano}}</b></span>
                            </div>
                            <div class="d-inline-flex">
                                <div class="p-2 mt-2">
                                    <a title="Alterar" href="{{route('alterarOVRelatorioES', array($unidade->id,$item->id))}}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                </div>
                                <div class="p-2 mt-2">
                                    @if($item->status_ouvi_rel_estas == 0)
                                      <a title="Ativar" class="btn btn-success btn-sm" style="color: #FFFFFF;" href="{{route('telaInativarOVRelatorioES', array($unidade->id,$item->id))}}"><i class="fas fa-times-circle"></i></a>
                                    @else
                                      <a title="Inativar" class="btn btn-warning btn-sm" href="{{route('telaInativarOVRelatorioES', array($unidade->id,$item->id))}}"><i class="fas fa-times-circle"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endforeach
            @else
            <div class="container" style="margin-top: 15px;">
                <h2 style="font-size: 80px; color:#65b345"><i class="fas fa-file-pdf"></i></h2>
            </div>
            @endif
        </div>
        <div class="col-md-1 col-sm-0"></div>
    </div>

</div>
@endsection