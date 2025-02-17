@extends('navbar.default-navbar')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container text-center" style="color: #28a745">Você está em: <strong>{{ $unidade->name }}</strong></div>
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <h5 style="font-size: 18px;">ALTERAR INSTITUCIONAL:</h5>
            </div>
        </div><br />
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="d-flex flex-column">
            <div>
                <a class="form-control text-center bg-success text-decoration-none text-white bg-success" type="button"
                    data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                    Institucional: <i class="fas fa-check-circle"></i>
                </a>
            </div>
        </div>
        <form action="{{ \Request::route('update', $unidade->id) }}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
         <div class="form-control mt-0" style="color:black">
            <div class="form-row mt-2">
                <div class="form-group col-md-12">
                    <label><strong>Perfil:</strong></label>
                    <input type="text" class="form-control" name="owner" id="owner" readonly="true"
                        value="Sociedade Pernambucana de Combate ao Câncer" value="<?php echo $unidade->owner; ?>" required />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><strong>CNPJ: </strong></label>
                    <input type="text" maxlength="18" class="form-control" name="cnpj" id="cnpj"
                        value="<?php echo $unidade->cnpj; ?>" required />
                </div>
                <div class="form-group col-md-6">
                    <label><strong>Nome Unidade: </strong></label>
                    <input type="text" class="form-control" name="name" id="name" value="<?php echo $unidade->name; ?>"
                        required />
                </div>
            </div>
            @if (isset($unidade->further_info) || $unidade->further_info !== null)
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label><strong>CEP: </strong></label>
                        <input type="text" class="form-control" name="cep" id="cep" value="<?php echo $unidade->cep; ?>"
                            required />
                    </div>
                    <div class="form-group col-md-4">
                        <label><strong>Logradouro: </strong></label>
                        <input type="text" class="form-control" name="address" id="address" value="<?php echo $unidade->address; ?>"
                            required />
                    </div>
                    <div class="form-group col-md-2">
                        <label><strong>Número: </strong></label>
                        <input type="text" class="form-control" name="numero" id="numero" value="<?php echo $unidade->numero; ?>"
                            required />
                    </div>
                    <div class="form-group col-md-4">
                        <label><strong>Complemento: </strong> </label>
                        <input type="text" class="form-control" name="further_info" id="further_info"
                            value="<?php echo $unidade->further_info; ?>" required />
                    </div>
                </div>
            @else
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label><strong>CEP: </strong></label>
                        <input type="text" class="form-control" name="cep" id="cep" value="<?php echo $unidade->cep; ?>"
                            required />
                    </div>
                    <div class="form-group col-md-8">
                        <label><strong>Logradouro: </strong></label>
                        <input type="text" class="form-control" name="address" id="address" value="<?php echo $unidade->address; ?>"
                            required />
                    </div>
                    <div class="form-group col-md-2">
                        <label><strong>Número: </strong></label>
                        <input type="text" class="form-control" name="numero" id="numero" value="<?php echo $unidade->numero; ?>"
                            required />
                    </div>
                </div>
            @endif
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label><strong>Bairro: </strong></label>
                    <input type="text" class="form-control" name="district" id="district" value="<?php echo $unidade->district; ?>"
                        required />
                </div>
                <div class="form-group col-md-5">
                    <label><strong>Cidade:</strong></label>
                    <input type="text" class="form-control" name="city" id="city" value="<?php echo $unidade->city; ?>"
                        required />
                </div>
                <div class="form-group col-md-2">
                    <label><strong>UF: </strong></label>
                    <input type="text" class="form-control" name="uf" id="uf"
                        value="<?php echo $unidade->uf; ?>" required />
                </div>
            </div>
            @if (isset($unidade->cnes) || $unidade->cnes !== null)
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <strong>Telefone: </strong>
                        <input type="text" maxlength="13" class="form-control" name="telefone" id="telefone"
                            value="<?php echo $unidade->telefone; ?>" required />
                    </div>
                    <div class="form-group col-md-4">
                        <strong>Horário: </strong>
                        <input type="text" class="form-control" name="time" id="time"
                            value="<?php echo $unidade->time; ?>" required />
                    </div>
                    <div class="form-group col-md-4">
                        <strong>CNES:</strong>
                        <input type="text" class="form-control" name="timeCnes" id="timeCnes"
                            value="<?php echo $unidade->cnes; ?>" required />
                    </div>
                </div>
            @else
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label><strong>Telefone: </strong></label>
                        <input type="text" maxlength="13" class="form-control" name="telefone" id="telefone"
                            value="<?php echo $unidade->telefone; ?>" required />
                    </div>
                    <div class="form-group col-md-6">
                        <label><strong>Horário: </strong></label>
                        <input type="text" class="form-control" name="time" id="time"
                            value="<?php echo $unidade->time; ?>" required />
                    </div>
                </div>
            @endif
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><strong>Imagem: </strong></label>
                    <input type="text" readonly="true" class="form-control" name="path_img" id="path_img"
                        style="width:300px" value="<?php echo $unidade->path_img; ?>" required />
                    <input type="file" class="form-control" name="path_img" id="path_img"
                        value="<?php echo $unidade->path_img; ?>" />
                </div>
                <div class="form-group col-md-6">
                    <label><strong>Ícone: </strong></label>
                    <input type="text" readonly="true" class="form-control" name="icon_img" id="icon_img"
                        style="width:300px" value="<?php echo $unidade->icon_img; ?>" required />
                    <input type="file" class="form-control" name="icon_img" id="icon_img"
                        value="<?php echo $unidade->icon_img; ?>" />
                </div>
            </div>
            <div class="form-row mt-1">
                <div class="form-group col-md-12">
                    <label><strong>Google Maps: </strong></label>
                    <input type="text" placeholder="Pesquise e cole o link do mapa do google maps"
                        class="form-control" name="google_maps" id="google_maps" value="<?php echo $unidade->google_maps; ?>"
                        required />
                </div>
            </div>
            <div class="form-row mt-1">
                <div class="form-group col-md-12">
                    <label><strong>Como ser atendido: </strong></label>
                    <textarea class="form-control autoTxtArea" maxlength="2500" id="ser_atendido" name="ser_atendido"
                        cols="20" rows="1">{{ $unidade->ser_atendido }}</textarea>
                </div>
            </div>
            <div class="form-row mt-1">
                <div class="form-group col-md-12">
                    <label><strong>Resumo: </strong></label>
                    <textarea class="form-control autoTxtArea" maxlength="2500" id="resumo" name="resumo" cols="20"
                        rows="1">{{ $unidade->resumo }}</textarea>
                </div>
            </div>
            <div class="form-row mt-1">
                <div class="form-group col-md-12">
                    <label><strong>Missão: </strong></label>
                    <textarea class="form-control autoTxtArea" maxlength="2500" id="missao" name="missao" cols="20"
                        rows="1">{{ $unidade->missao }}</textarea>
                </div>
            </div>
            <div class="form-row mt-1">
                <div class="form-group col-md-12">
                    <label><strong>visão: </strong></label>
                    <textarea class="form-control autoTxtArea" maxlength="2500" id="visao" name="visao" cols="20"
                        rows="1">{{ $unidade->visao }}</textarea>
                </div>
            </div>
            <div class="form-row mt-1">
                <div class="form-group col-md-12">
                    <label><strong>Valores: </strong></label>
                    <textarea class="form-control autoTxtArea" maxlength="2500" id="valores" name="valores" cols="20"
                        rows="1">{{ $unidade->valores }}</textarea>
                </div>
            </div>
            <div class="form-row mt-1">
                <div class="form-group col-md-12">
                    <label><strong>Capacidade: </strong></label>
                    <input type="hidden" name="cont_capacidade" id="cont_capacidade" value="">
                    <div id="inativa_lista"></div>
                    <div id="inativa_item"></div>
                    <div id="capacidade_pai">

                    </div>
                    <button id="btn-add-lista-capacidade" type="button" class="btn btn-dark btn-sm mt-2 w-100 ">Adicionar
                        nova lista de capacidades</button>

                </div>
            </div>
            <div class="form-row mt-1">
                <div class="form-group col-md-12">
                    <label><strong>Especialidades: </strong></label>
                    <input type="hidden" name="cont_especialidade" id="cont_especialidade" value="">
                    <div id="inativa_lista_esp"></div>
                    <div id="inativa_item_esp"></div>
                    <div id="especialidade_pai">

                    </div>
                    <button id="btn-add-lista-especialidade" type="button"
                        class="btn btn-dark btn-sm mt-2 w-100 ">Adicionar nova lista de especialidades</button>

                </div>
            </div>

            <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id"
                value="<?php echo $unidade->id; ?>" />
            <input hidden type="text" class="form-control" id="tela" name="tela" value="institucional" />
            <input hidden type="text" class="form-control" id="acao" name="acao"
                value="alterarInstitucional" />
            <input hidden type="text" class="form-control" id="user_id" name="user_id"
                value="{{ Auth::user()->id }}" />

            <div class="form-row">
                <div class="form-group text-center col-md-6">
                    <a href="{{ route('transparenciaHome', $unidade->id) }}" id="Voltar" name="Voltar"
                        type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> 
                        <i class="fas fa-reply"></i> <b>Voltar</b> </a>
                </div>
                <div class="form-group text-center col-md-6">
                    <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar"
                        id="Salvar" name="Salvar" />
                </div>
            </div>

        </form>
    </div>

    <?php
    $objetoJSON = json_encode($Capacity);
    $objetoEspecialidadeJSON = json_encode($specialty);
    ?>
    <script>
        //Capacidades
        var qtd_capacidades = "<?php echo sizeof($Capacity_desc); ?>";
        var objetoJS = JSON.parse('<?php echo $objetoJSON; ?>');
        //Especialidades
        var qtd_especialidades = "<?php echo sizeof($specialty_desc); ?>";
        var objetoEspecialidadeJSON = JSON.parse('<?php echo $objetoEspecialidadeJSON; ?>')
    </script>
    <script src="{{ asset('js/institucional.js') }}"></script>

@endsection
