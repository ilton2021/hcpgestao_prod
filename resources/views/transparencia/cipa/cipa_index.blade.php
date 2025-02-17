<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CIPA - INDEX</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style-dashboard.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/favico.png') }}">
    <script src="https://kit.fontawesome.com/7656d93ed3.js" crossorigin="anonymous"></script>
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
            <a class="navbar-brand text-dark" href="">CIPA</a>
			<th><center><a class="btn btn-dark btn-olho" href="{{ route('transparenciaCipaCadastro') }}">Novo<i class="bi bi-eye-fill"></i></a></center></th>
        </div>
    </nav>
    @if ($errors->any())
        <div id="error-message" class="alert alert-success text-center">
            @foreach ($errors->all() as $error)
                <h4>{{ $error }}</h4>
            @endforeach
        </div>
    @endif
    <div class="container mt-4">
        <table class="table table-success" id="tabela">
            <thead>
                <tr>
                    <th><center>LGPD</center></th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td>
							<p align="justify"><font size="2" color="#000000"><b>De acordo com a Lei Geral de Proteção de Dados nº 13.709/18 e legislação vigente aplicável, o titular dos dados pessoais declara estar ciente e de acordo com as disposições aqui descritas e autoriza, de forma livre e expressa, o tratamento de dados pessoais e informações pelo HCP Gestão, respeitando os princípios de transparência, necessidade, adequação e finalidade para os dados aqui coletados.</b></font></p>
							<p align="justify"><font size="2" color="#000000"><b>O HCP Gestão respeita e garante ao titular a possibilidade de exercer seus direitos: (i) Confirmação da existência de tratamento; (ii) o acesso aos dados, (iii) a correção de dados incompletos, (iv) inexatos ou desatualizados, (v) a anonimização, (vi) bloqueio ou eliminação de dados desnecessários, excessivos ou tratados em desconformidade, (vii) a portabilidade de seus dados a outro fornecedor de serviço ou produto, mediante requisição expressa pelo titular, (viii) a eliminação dos dados tratados com consentimento do titular, (ix) a informação sobre a possibilidade de não fornecer o seu consentimento, bem como de ser informado sobre as consequências, em caso de negativa e a (x) revogação do consentimento.</b></font></p>
							<p align="justify"><font size="2" color="#000000"><b>Para exercer seus direitos relacionados à Lei Geral de Proteção de Dados entre em contato com o Encarregado de Dados no e-mail dpo@hcp.org.br.</b></font></p>
							<p align="justify"><font size="2" color="#000000"><b>Para informações detalhadas sobre como tratamos os seus dados pessoais consulte a política de privacidade em <a href="https:\\www.hcpgestao.org.br\privacidade" target="_blank">https:\\www.hcpgestao.org.br\privacidade</b></a></font></p>
						</td>
                    </tr>
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
