<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CIPA - LISTAGEM</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-dashboard.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/favico.png') }}">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bibliotecas/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('bibliotecas/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bibliotecas/popper.min.js') }}"></script>
    <script src="{{ asset('bibliotecas/bootstrap.bundle.min.js') }}"></script>
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
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-ligth">
        <div class="container">
            <a class="navbar-brand text-dark" href="#">Lista</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="dropdown-item text-dark" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Sair') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="ocorrencia" value="ocorrencia" />
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <table class="table table-striped" id="tabela">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Condições Inseguras</th>
                    <th>Local</th>
                    <th><center>Visualizar</center></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cipas as $cipa)
                    <tr>
                        <td>{{ $cipa->id }}</td>
                        <td>
                            <?php if($cipa->condicoes_inseguras == "piso_molhado_danificado_sem_sinalizacao") { ?>
                                {{ 'Piso molhado/danificado sem sinalização' }}
                            <?php } else if ($cipa->condicoes_inseguras == "falta_epi") { ?>
                                {{ 'Falta de EPI' }}
                            <?php } else if ($cipa->condicoes_inseguras == "falta_iluminacao") { ?>
                                {{ 'Falta de iluminação' }}
                            <?php } else if ($cipa->condicoes_inseguras == "falta_extintores") { ?>
                                {{ 'Falta de extintores' }}
                            <?php } else if ($cipa->condicoes_inseguras == "moveis_danificados") {  ?>
                                {{ 'Móveis danificados' }}
                            <?php } else { ?>
                                {{ $cipa->condicoes_inseguras }}
                            <?php } ?>
                        </td>
                        <td>{{ $cipa->local_condicoes }}</td>
                        <td>   
                            <center>
                            <button title="Condições Inseguras" type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop_<?php echo $cipa->id; ?>">
                                Visualizar
                            </button>
                            <div class="modal fade bd-example-modal-xl" id="staticBackdrop_<?php echo $cipa->id; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog modal-xl" width="1000px;">
                                <div class="modal-content">
                                  <div class="modal-header">
                                     <b>Condições Inseguras:</b>
                                     <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <table class="table table-success" id="tabela">
                                      <tr>
                                        <td>Condições Inseguras:</td>
                                      </tr>
                                      <tr>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" name="condicoes_inseguras" id="condicoes_inseguras" value="<?php if($cipa->condicoes_inseguras == 'piso_molhado_danificado_sem_sinalizacao') { echo 'Piso molhado/danificado sem sinalização'; } else if ($cipa->condicoes_inseguras == 'falta_epi') { echo 'Falta de EPI'; } else if ($cipa->condicoes_inseguras == 'falta_iluminacao') { echo 'Falta de iluminação'; } else if ($cipa->condicoes_inseguras == 'falta_extintores') { echo 'Falta de extintores'; } else if ($cipa->condicoes_inseguras == 'moveis_danificados') { echo 'Móveis danificados'; } else { echo $cipa->condicoes_inseguras; } ?>" />
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>Local da Condição insegura:</td>
                                      </tr>
                                      <tr>
                                        <td><input type="text" class="form-control form-control-sm" name="local_condicoes" id="local_condicoes" value="<?php echo $cipa->local_condicoes; ?>" /></td>
                                      </tr>
                                      <tr>
                                        <td>Observação:</td>
                                      </tr>
                                      <tr>
                                        <td><textarea type="text" class="form-control form-control-sm" name="observacao" id="observacao">{{ $cipa->observacao; }}</textarea></td>
                                      </tr>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            </center>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="div-exibicao" id="divExibicao">
            <button class="btn btn-dark btn-voltar" onclick="voltar()">Voltar</button>
            <div id="Resultado">

            </div>
        </div>
    </div>
</body>
</html>
