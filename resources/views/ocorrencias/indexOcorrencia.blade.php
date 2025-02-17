<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ocorrências</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-dashboard.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/favico.png') }}">
    <!-- Font Awesome KIT -->
    <script src="https://kit.fontawesome.com/7656d93ed3.js" crossorigin="anonymous"></script>
    <!--Icones bootstrap-->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
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
            <a class="navbar-brand text-dark" href="#">Lista de ocorrências</a>
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
        <table class="table" id="tabela">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Unidade</th>
                    <th>Data</th>
                    <th>Visualizar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ocorrenciasForm as $OcorrenciaForm)
                    <tr>
                        <td>{{ $OcorrenciaForm->id }}</td>
                        <td>{{ $OcorrenciaForm->descricao_ocorrencia }}</td>
                        <td>{{ $OcorrenciaForm->unidade }}</td>
                        <td>{{date("d/m/Y", strtotime($OcorrenciaForm->data_ocorrencia)) }}</td>
                        <td><button class="btn btn-dark btn-olho" onclick="getDados({{ $OcorrenciaForm->id }})"><i
                                    class="bi bi-eye-fill"></i></button></td>
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

    <script>
        function voltar() {
            document.getElementById('tabela').classList.remove('recolhida');
            document.getElementById('divExibicao').classList.remove('exibida');
        }

        document.addEventListener("DOMContentLoaded", function() {
            var btnsOlho = document.getElementsByClassName("btn-olho");
            var tabela = document.getElementById("tabela");
            var divExibicao = document.getElementById("divExibicao");

            Array.from(btnsOlho).forEach(function(btn) {
                btn.addEventListener("click", function() {
                    tabela.classList.add("recolhida");
                    divExibicao.classList.add("exibida");
                });
            });
        });
    </script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/boxicons/js/boxicons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script>
        function CriaRequest() {
            try {
                request = new XMLHttpRequest();
            } catch (IEAtual) {

                try {
                    request = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (IEAntigo) {

                    try {
                        request = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch (falha) {
                        request = false;
                    }
                }
            }

            if (!request)
                alert("Seu Navegador não suporta Ajax!");
            else
                return request;
        }

    </script>
</body>

</html>
