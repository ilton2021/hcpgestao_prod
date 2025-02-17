@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
  <div class="row" style="margin-top: 25px;">
    <div class="col-md-12 text-center">
      @if($integridade[0]->status_integridade == 0)
        <h3 style="font-size: 18px;"> ATIVAR CERTIFICADO DO PROGRAMA DE INTEGRIDADE:</h3>
      @else
        <h3 style="font-size: 18px;">INATIVAR CERTIFICADO DO PROGRAMA DE INTEGRIDADE:</h3>
      @endif
    </div>
  </div>
  @if($errors->any())
    <div class="alert alert-danger" style="font-size:16px;">
      <ul class="list-unstyled text-center">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <div class="row" style="margin-top: 25px; margin-left: auto; margin-right: auto; display: flex; justify-content: center">
		<div class="col-md-10 col-sm-4 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
            Certificado do Programa de Integridade: <i class="fas fa-check-circle"></i>
					</a>
				</div>
			</div>
      <form method="POST" action="{{route('telaInativarCI',array($unidade->id,$integridade[0]->id))}}" enctype="multipart/form-data" id="formid">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-control mt-0" style="color:black">
            <div class="form-row mt-3">
              <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                <div class="col-md-3 mr-2">
                  <label><strong>Nome:</strong></label>
                </div>
                <div class="col-md-8 mr-2"> 
                  <input class="form-control form-control-sm" readonly id='name' type='text' name="name" value="<?php echo $integridade[0]->name; ?>" required />
                </div>
              </div>
            </div>
            <div class="form-row mt-3">
              <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                <div class="col-md-3 mr-2">
                  <label><strong>Arquivo:</strong></label>
                </div>
                <div class="col-md-8 mr-2"> 
                  <input class="form-control form-control-sm" readonly id='file_path' type='text' name="file_path" value="<?php echo $integridade[0]->path_file; ?>" required />
                </div>
              </div>
            </div>
            <div class="form-row mt-3">
              <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                <div class="col-md-12 mr-2"> 
                  <center>
                    <iframe class="embed-responsive-item" src="{{asset('storage/')}}/{{$integridade[0]->path_file}}"></iframe>
                  </center>
                </div>
              </div>
            </div>
            <div class="form-row mt-2">
              <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                <div class="col-md-12 mr-2">
                  <center>
                    <a href="{{route('cadastroCI',$unidade->id)}}" class="btn btn-warning btn-sm" style="color:white;"> <i class="fas fa-reply"></i> <b>Voltar</b></a>
                    @if($integridade[0]->status_integridade == 0)
                      <input type="submit" value="Ativar" id="Ativar" name="Ativar" class="btn btn-success btn-sm" />
                    @else
                      <input type="submit" value="Inativar" id="Excluir" name="Excluir" class="btn btn-primary btn-sm" />
                    @endif
                  </center>
                </div>
              </div>
            </div>
            <div class="form-row mt-2">
              <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                <div class="col-md-10 mr-2">
                  <input hidden type="text" class="form-control" id="tela" name="tela" value="CertificadoIntegridade" />
                  @if($integridade[0]->status_integridade == 0)
                    <input hidden type="text" class="form-control" id="acao" name="acao" value="AtivarCertificadoIntegridade" />
                  @else
                    <input hidden type="text" class="form-control" id="acao" name="acao" value="InativarCertificadoIntegridade" />
                  @endif
                  <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" />
                </div>
              </div>
            </div>
          </div>
        </form>
    </div>
  </div>
@endsection