<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CIPA</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-dashboard.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/favico.png') }}">
    <style>
        .table.recolhida {
            display: none;
        }

        .div-exibicao {
            display: none;
        }

        .div-exibicao.exibida {
            display: block;
        }

        .btn-voltar {
            margin-bottom: 10px;
        }
    </style>
    <script type="text/javascript">
        function condicoes_ins(){
            value = document.getElementById('condicoes_inseguras').value;

            if (value == "outros") {
                document.getElementById('condicoes_inseguras_text').hidden = false;
            } else {
                document.getElementById('condicoes_inseguras_text').hidden = true;
            }
        }
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-ligth">
        <div class="container">
            <a class="navbar-brand text-dark" href="#">CIPA</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
					<th><center><a class="btn btn-warning" href="{{ route('transparenciaCipa') }}">Voltar</a></center></th>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
	  <form action="{{ route('storeCipaCadastro') }}" method="post" id="formID">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <table class="table" id="tabela">
            <thead>
                <tr>
                    <th colspan="2"><center>FALE COM A CIPA</center></th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td><b>CONDIÇÕES INSEGURAS:</b></td>
                    </tr>
                    <tr>
                        <td>
                            <select class="form-control" id="condicoes_inseguras" name="condicoes_inseguras" required onchange="condicoes_ins(this)">
                                <option value="">Selecione...</option>
                                <option value="piso_molhado_danificado_sem_sinalizacao">Piso molhado/danificado sem sinalização</option>
                                <option value="falta_epi">Falta de EPI</option>
                                <option value="falta_iluminacao">Falta de iluminação</option>
                                <option value="falta_extintores">Falta de extintores</option>
                                <option value="moveis_danificados">Móveis danificados</option>
                                <option value="outros">Outros</option>
                            </select>
                            <input type="text" class="form-control form-control-sm" name="condicoes_inseguras_text" id="condicoes_inseguras_text" value="{{ old('condicoes_inseguras_text') }}" required hidden />
                        </td>
                    </tr>
					<tr>
                        <td>
							<b>Local da condição insegura:</b> 
							<input type="text" class="form-control form-control-sm" name="local_condicoes" id="local_condicoes" value="{{ old('local_condicoes') }}" required />
						</td>
                    </tr>
					<tr>
                        <td>
							<b>Expresse sua opinião:</b>
							<textarea class="form-control form-control-sm" type="textarea" cols="6" rows="6" id="observacao" name="observacao" value="" required>{{ old('observacao') }}</textarea>
						</td>
                    </tr>
					<tr>
						<td><center><input class="btn btn-sm btn-success" type="submit" aria-label=".form-control-sm" name="submit" id="submit"></center></td>
					</tr>
            </tbody>
        </table>
		</form>
        <div class="div-exibicao" id="divExibicao">
            <button class="btn btn-dark btn-voltar" onclick="voltar()">Voltar</button>
            <div id="Resultado">

            </div>
        </div>
    </div>
</body>
</html>
