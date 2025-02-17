@extends('navbar.default-navbar')
@section('content')
    <div class="container text-center" style="color: #28a745">Você está em: <strong>{{ $unidade->name }}</strong></div>
    <div class="container-fluid">
        <div class="row" style="margin-top: 25px;">
            <div class="col-md-12 text-center">
                <h4>Recursos Humanos</h4>
                <h5>Cadastro de Regulamentos</h5>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-success text-center" style="font-size:16px;">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row" style="margin-top: 25px;">
            <div class="col-md-12 col-sm-12 text-center">
               
                <div class="d-flex justify-content-between">
                    <a class="btn btn-warning m-1" href="{{route('transparenciaRecursosHumanos',$unidade->id)}}" ><strong>Voltar </strong><i class="fas fa-reply"></i></a>
                     <a class="btn btn-dark m-1" href="{{route('regulamentosRhCreate',$unidade->id)}}">Novo Regulamento <i class="fas fa-check" aria-hidden="true"></i></a>
                </div>
               
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <a class="card-header bg-success text-decoration-none text-white bg-success" type="button"
                            data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                            Regulamentos: <i class="fas fa-check-circle"></i>
                        </a>
                       
                    </div>
                     
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Regulamento</th>
                                <th>Mês/Ano</th>
                                <th>Alterar</th>
                                <th>Visualizar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($regulamentoRh as $regulaRh)
                            <tr>
                                <td>{{$regulaRh->regulamentorh}}</td>
                                <td>{{$regulaRh->mes}}/{{$regulaRh->ano}}</td>
                                <td><a class="btn btn-primary" href="{{route('regulamentosRhEdit',[$regulaRh->id,$unidade->id])}}"><i class="bi bi-pencil-square"></i></a></td>
                                <td><a class="btn btn-dark" target="_blank" href="{{asset('storage')}}/{{$regulaRh->file_path}}"><i class="bi bi-eye"></i></a></td>
                                <td>
                                    <button type="button" class="btn btn-{{$regulaRh->status_regula_rh == 1 ? 'success' : 'danger'}}" data-toggle="modal" data-target="#inativarModal_{{$regulaRh->id}}">
                                        <i class="bi bi-power"> {{$regulaRh->status_regula_rh == 1 ? 'Ativo' : 'Inativo'}} </i>
                                    </button>
                                </td>
                                
                                <div class="modal fade" id="inativarModal_{{$regulaRh->id}}" tabindex="-1" role="dialog" aria-labelledby="inativarModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Mudança de status</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                                @if($regulaRh->status_regula_rh == 1)
                                                Ao <b class="text-danger" >desativar</b> o documento, ele não estará mais acessível ao público que visita o portal de transparência. Você tem certeza de que deseja proceder com a inativação do documento?
                                                @else
                                                 Ao <b class="text-success" >ativar</b> o documento, ele estará acessível ao público que visita o portal de transparência. Você tem certeza de que deseja proceder com a ativação do documento?
                                                @endif
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                                            <form method="POST" action="{{ route('regulamentosRhStatus', [$regulaRh->id,$unidade->id]) }}">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-{{$regulaRh->status_regula_rh == 1 ? 'danger' : 'success'}}">
                                                    @if($regulaRh->status_regula_rh == 1)
                                                        Inativar
                                                    @else
                                                        Ativar
                                                    @endif
                                                    </button>
                                            </form>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
@endsection
