<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cadastro de Documentos</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/favico.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Dosis:300,400,500,,600,700,700i|Lato:300,300i,400,400i,700,700i"
        rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <style>
        .js-example-basic-single {
            width: 100%;
        }

        .js-example-basic-multiple {
            width: 100%;
        }
    </style>
</head>

<body> 
    <br>
    <h3 class="text-center">Cancelar/Inativar Controle Documental:</h3>
    @if ($errors->any())
        <div id="error-message" class="alert alert-success text-center">
            @foreach ($errors->all() as $error)
                <h3>{{ $error }}</h3>
            @endforeach
        </div>
    @endif
    <form action="{{ route('updateDocStatus', array($unidade->id, $documentos[0]->id, $id)) }}" method="post" id="formID">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="row m-2">
            <div class="col-12 col-sm-6  p-4">
                <label class="fw-bold mt-1" for="tipo_documento" class="form-label">Tipo do Documento:<span
                        style="color:red">*</span></label>
                <input class="form-control form-control-sm" type="text" name="tipo_documento" id="tipo_documento"
                        aria-label=".form-control-sm" required value="<?php echo $documentos[0]->tipo_documento; ?>" readonly>        
                <label class="fw-bold mt-1" for="nome" class="form-label">Nome do Documento:<span
                        style="color:red">*</span></label>
                <input class="form-control form-control-sm" type="text" aria-label=".form-control-sm"
                        name="nome" id="nome" value="<?php echo $documentos[0]->nome; ?>" readonly>
                <label class="fw-bold mt-1" for="data_inicio" class="form-label">Data Validade Início:<span
                        style="color:red">*</span></label>
                <input class="form-control form-control-sm" type="date" name="data_inicio" id="data_inicio"
                        aria-label=".form-control-sm" required value="<?php echo $documentos[0]->data_inicio; ?>" readonly>    
            </div>
            <div class="col-12 col-sm-6  p-4">
                <label class="fw-bold mt-1" for="orgao" class="form-label">Órgão:<span style="color:red">*</span></label>
                <input class="form-control form-control-sm" type="text" name="orgao" id="orgao"
                    aria-label=".form-control-sm" required value="<?php echo $documentos[0]->orgao; ?>" readonly>    
                <label class="fw-bold mt-1" for="email" class="form-label">E-mail Responsável:<span
                    style="color:red">*</span></label>
                <input class="form-control form-control-sm" type="text" aria-label=".form-control-sm" name="email"
                    id="email" value="<?php echo $documentos[0]->email; ?>" readonly>
                <label class="fw-bold mt-1" for="data_fim" class="form-label">Data Validade Fim:<span style="color:red">*</span></label>
                <input class="form-control form-control-sm" type="date" aria-label=".form-control-sm"
                    name="data_fim" id="data_fim" value="<?php echo $documentos[0]->data_fim; ?>" readonly>
            </div>
            <div class="col-12 col-sm-12 p-4">
                <label class="fw-bold mt-1" for="email" class="form-label">Observacao:</label>
                <textarea class="form-control" id="observacao" name="observacao" rows="6">{{ $documentos[0]->observacao }}</textarea> 
            </div>
        </div>
        <hr>
        <div class="row m-2 p-3">
            <input class="btn btn-success" type="submit" aria-label=".form-control-sm" name="submit" value="Alterar Status"
                id="submit">
        </div>
        <div class="row m-2 p-3">
            <a href="javascript:history.back();" class="btn btn-warning btn-sm" aria-label=".form-control-sm"><strong>VOLTAR</strong></a>
        </div>
        <table>
		    <tr>     
			    <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
				<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="alterar_documental" /> </td>
		    	<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="alterarDocumentos" /> </td>
		    </tr>
		</table>
    </form>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.0.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/multiple-select.min.js') }}"></script>
    <script>
        //Função para bloquear botão enviar depois de clicado uma vez
        var formID = document.getElementById("formID");
        var send = $("#submit");

        $(formID).submit(function(event) {
            if (formID.checkValidity()) {
                send.attr("disabled", "disabled");
            }
        });
        //
    </script>
    <script>
        // Função para ocultar div depois de timer
        setTimeout(function() {
            document.getElementById("error-message").style.display = "none";
        }, 5000);
        //
    </script>
</body>

</html>
