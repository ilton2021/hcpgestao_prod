@extends('navbar.default-navbar')
@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if ($errors->any())
        <div class="alert alert-success">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container text-center" style="color: #28a745">Você está em: <strong>{{ $unidade->name }}</strong></div>
    <div class="container-fluid">
        <div class="row" style="margin-top: 25px;">
            <div class="col-md-12 text-center">
                <h3 style="font-size: 18px;">INSTITUCIONAL</h3>
            </div>
        </div>
        <div class="row p-4">
            <div class="col-md-12 text-center">
                @if (Auth::check())
                    @foreach ($permissao_users as $permissao)
                        @if ($permissao->permissao_id == 1 && $permissao->user_id == Auth::user()->id)
                            @if ($permissao->unidade_id == $unidade->id)
                                <a class="btn btn-dark btn-sm m-2" href="{{ route('institucionalNovo', $unidade->id) }}">
                                    <b>Novo</b> <i class="fas fa-check"></i> </a>
                                <a class="btn btn-info btn-sm m-2" href="{{ route('institucionalAlterar', $unidade->id) }}">
                                    <b>Alterar</b> <i class="fas fa-edit"></i></a>
                                <a class="btn btn-success btn-sm m-2"
                                    href="{{ route('transparenciaInstitucionalPdf', $unidade->id) }}"
                                    target="__blank"><b>Download</b> <i class="fas fa-file-pdf"></i></a>
                            @endif
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
        <form action="{{ \Request::route('update', $unidade->id) }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">
                <div class="col-md-6" style="font-size: 13px;">
                    <table class="table table-hover table-sm table-success" style="line-height: 1.5;">
                        <tbody>
                            <tr>
                                <td style="border-top: none;"><strong>Perfil: </strong></td>
                                <td style="border-top: none;" id="txtPerfil">{{ $unidade->owner }}</td>
                            </tr>
                            <tr>
                                <td style="border-top: none;"><strong>CNPJ: </strong></td>
                                <td style="border-top: none;" id="txtCnpj">
                                    {{ preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})/', "\$1.\$2.\$3/\$4\$5-", $unidade->cnpj) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="border-top: none;"><strong>Unidade: </strong></td>
                                <td style="border-top: none;" id="txtNome">{{ $unidade->name }}</td>
                            </tr>
                            <tr>
                                <td style="border-top: none;"><strong>Logradouro: </strong></td>
                                <td style="border-top: none;" id="txtLogradouro">{{ $unidade->address }} ,
                                    {{ $unidade->numero == null ? ' s/n' : $unidade->numero }}
                                </td>
                            </tr>
                            @if (isset($unidade->further_info) || $unidade->further_info !== null)
                                <tr>
                                    <td style="border-top: none;"><strong>Complemento: </strong></td>
                                    <td style="border-top: none;" id="txtComplemento">{{ $unidade->further_info }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td style="border-top: none;"><strong>Bairro: </strong></td>
                                <td style="border-top: none;" id="txtBairro">{{ $unidade->district }}</td>
                            </tr>
                            <tr>
                                <td style="border-top: none;"><strong>Cidade: </strong></td>
                                <td style="border-top: none;" id="txtCity">{{ $unidade->city }}</td>
                            </tr>
                            <tr>
                                <td style="border-top: none;"><strong>UF: </strong></td>
                                <td style="border-top: none;" id="txtUf">{{ $unidade->uf }}</td>
                            </tr>
                            <tr>
                                <td style="border-top: none;"><strong>CEP: </strong></td>
                                <td style="border-top: none;" id="txtCep">
                                    {{ preg_replace('/(\d{2})(\d{3})/', "\$1.\$2-", $unidade->cep) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="border-top: none;"><strong>Telefone: </strong></td>
                                <td style="border-top: none;" id="txtTelefone">
                                    {{ preg_replace('/(\d{4})(\d{4})/', "\$1-\$2", $unidade->telefone) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="border-top: none;"><strong>Horário: </strong></td>
                                <td style="border-top: none;" id="txtHorario">{{ $unidade->time }}</td>
                            </tr>
                            @if (isset($unidade->cnes) || $unidade->cnes !== null)
                                <tr>
                                    <td style="border-top: none;"><strong>CNES: </strong></td>
                                    <td style="border-top: none;" id="txtCnes">{{ $unidade->cnes }}</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
            </div>
            <div class="col-md-6">
                    <div>
                        <div class="h-25 d-inline-block"></div>
                    </div>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="{{ $unidade->google_maps }}" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="font-size: 13px;">
                    <table style="line-height: 1.5;" class="table table-hover table-sm table-success">
                        <tbody>
                            @if($unidade->id != 8)
                            <tr>
                                <td class="text-justify" style="border-top: none;" colspan="2" id="txtResumo">
                                    <h6><strong>Resumo: </strong></h6>
                                    @if (isset($unidade->resumo) || $unidade->resumo !== null)
                                        <br>{!! $unidade->resumo !!}<br>
                                    @endif
                                    <ul>
                                        @if (isset($unidade->missao) || $unidade->missao !== null)
                                            <li><strong>Missão: </strong></li>
                                            <label>{{ $unidade->missao }}</label>
                                        @endif
                                        @if (isset($unidade->visao) || $unidade->visao !== null)
                                            <li><strong>Visão: </strong></li>
                                            <label>{{ $unidade->visao }}</label>
                                        @endif
                                        @if (isset($unidade->valores) || $unidade->valores !== null)
                                            <li><strong>Valores: </strong></li>
                                            <label>{{ $unidade->valores }}</label>
                                        @endif
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            </tr>
                            @if (isset($unidade->ser_atendido) || $unidade->ser_atendido !== null)
                                <tr>
                                    <td class="text-justify" style="border-top: none;" colspan="2" id="txtResumo">
                                        <h6><strong>Como ser atendido: </strong></h6>
                                        <br>
                                        <?php
                                            $conteudo = "Primeira linha\nSegunda linha\nTerceira linha";
                                            $conteudoComQuebras = nl2br($unidade->ser_atendido);
                                        ?>
                                       <?php echo $conteudoComQuebras; ?>
                                        <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td><br></td>
                                </tr>
                            @endif
                            @endif
                            @if($unidade->id != 8)
                            @if (isset($undCapacity) || $undCapacity !== null)
                                <tr>
                                    <td class="text-justify" style="border-top: none;" colspan="2" id="txtCapacity">
                                        <h6><strong>Capacidades: </strong></h6>
                                        <?php $desc = ''; ?>
                                        <?php $total = 0; ?>
                                        <?php $totalOk = false; ?>
                                        @foreach ($undCapacity as $undC)
                                            @if ($undC->descricao !== $desc)
                                                <?php $total = 0; ?>
                                <tr>
                                    <td class="text-justify" style="border-top: none;" colspan="2" id="txtCapacity">
                                        <strong>{{ strpos($undC->descricao, 'SEM_DESC_') !== false ? '' : $undC->descricao }}</strong>
                                        <ul>
                                            <br>
                                            @foreach ($undCapacity as $undI)
                                                @if ($undC->descricao == $undI->descricao && $undI->desc_quantidades !== null)
                                                    <li>{{ $undI->quantidades }}
                                                        ({{ numeroPorExtenso($undI->quantidades) }})
                                                        -
                                                        {{ $undI->desc_quantidades }}</li>
                                                    <?php $total = $total + $undI->quantidades; ?>
                                                @endif
                                            @endforeach
                                            @if ($total > 0 && $totalOk === false)
                                                <li style="list-style-type: none"><strong>Total:
                                                        {{ $total }}</strong></li>
                                                <?php $totalOk = true; ?>
                                            @endif
                                        </ul>
                                    </td>
                                </tr>
                                <?php $desc = $undC->descricao; ?>
                            @else
                                <?php $totalOk = false; ?>
                            @endif
                            @endforeach
                            </td>
                            </tr>
                            <tr>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            </tr>
                            @endif 
                            @endif
                            @if($unidade->id != 8)
                            @if (isset($undSpecialty) || $undSpecialty !== null)
                                <tr>
                                    <td class="text-justify" style="border-top: none;" colspan="2" id="txtSpecialty">
                                        <h6> <strong> Especialidades:<strong> </h6>
                                        <?php $esp = ''; ?>
                                        @foreach ($undSpecialty as $undE)
                                            @if ($undE->description !== $esp)
                                <tr>
                                    <td class="text-justify" style="border-top: none;" colspan="2" id="txtSpecialty">
                                        <strong>{{ strpos($undE->description, 'SEM_DESC_') !== false ? '' : $undE->description }}</strong>
                                        <ul>
                                            @foreach ($undSpecialty as $undI)
                                                @if ($undE->description == $undI->description && $undI->specialty !== null)
                                                    <li>{{ $undI->specialty }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                                <?php $esp = $undE->description; ?>
                            @endif
                            
                            @endforeach
                            </td>
                            </tr>
                            <tr>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            </tr>
                            @endif
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="col-md-8 table table-hover table-sm table-success">
                @if ($unidade->id == 8) <br>
                    <h3 style="font-size: 16px;">INFORMAÇÕES SOBRE A UNIDADE DE SAÚDE: (HOSPITAL DE CAMPANHA AURORA - HCA)</h3><br>
                    <p style="color: black; bold;"><b>1. INTRODUÇÃO:</b></p>

                    <p align="justify" style="color: black; font-size: 14px;">O modelo de Organização Social de Saúde, a ser adotado para
                        gestão do HOSPITAL DE CAMPANHA AURORA,
                        busca a modernidade e o aprimoramento da eficiência na prestação dos serviços públicos de saúde,
                        tendo por objetivos: </p>
                    <p align="justify" style="color: black; font-size: 14px;">• Potencializar a qualidade na execução dos serviços de
                        saúde
                        e atendimento à população
                        com suspeita ou diagnosticada com o novo Coronavírus (Covid - 19 / Síndrome
                        Respiratória Aguda Grave - SRAG). </p>
                    <p align="justify" style="color: black; font-size: 14px;">• Ampliar a capacidade de atendimento, com oferta de leitos
                        clínicos e de unidade de
                        terapia intensiva exclusivos para atendimentos aos pacientes com suspeita ou
                        diagnosticados com o novo Coronavírus (Covid - 19 / Síndrome Respiratória Aguda
                        Grave - SRAG);</p>
                    <p align="justify" style="color: black; font-size: 14px;">• Melhorar o serviço ofertado ao usuário SUS com assistência
                        humanizada. </p>

                    <p style="color: black; bold;">2. INFORMAÇÕES SOBRE A UNIDADE A SER GERIDA PELA OSS: (HOSPITAL DE CAMPANHA AURORA - HCA)</p>

                    <p align="justify" style="color: black; font-size: 14px;">O HOSPITAL DE CAMPANHA AURORA, situado na Rua da Aurora,
                        1675,
                        Santo Amaro, Recife/PE.</p>

                    <p style="color: black; bold;">3. SERVIÇOS: </p>

                    <p align="justify" style="color: black; font-size: 14px;">0 HOSPITAL DE CAMPANHA AURORA será estruturado com perfil de
                        hospital de grande porte, 160 leitos aptos a realizar procedimentos de média e alta
                        complexidade para atendimento exclusivo aos pacientes suspeitos ou diagnosticados com o
                        novo Coronavírus (Covid - 19/ Síndrome Respiratória Aguda Grave - SRAG) através de Cuidados
                        Intensivos e Internação, em regime de demanda regulada pelo Município do Recife. </p>
                    <p align="justify" style="color: black; font-size: 14px;">3.1. Serviço de Apoio Diagnóstico e Terapêutico - SADT A
                        unidade hospitalar deverá
                        disponibilizar exames e ações de apoio diagnóstico e terapêutico a pacientes atendidos em
                        regime de Internação em leitos clínicos e de unidade terapia intensiva. </p>
                    <p style="color: black; font-size: 14px;">3.2. Internação </p>

                    <p align="justify" style="color: black; font-size: 14px;">O hospital funcionará com capacidade operacional para 160
                        leitos de internação assim
                        distribuídos:</p>
                    <p style="color: black; font-size: 14px;">• 60 leitos clínicos de enfermaria de isolamento; </p>
                    <p style="color: black; font-size: 14px;">• 100 leitos de Unidade de Terapia Intensiva — UTI Geral. </p>
                    <p align="justify" style="color: black; font-size: 14px;">Todos os leitos do hospital deverão estar disponibilizados
                        para a Central de Regulação Leitos do
                        Estado. </p>

                    <p style="color: black; font-size: 14px;">3.2.1. ASSISTÊNCIA HOSPITALAR</p>

                    <p align="justify" style="color: black; font-size: 14px;">A assistência à saúde prestada em regime de hospitalização
                        compreende o conjunto de
                        atendimentos oferecidos ao paciente suspeito ou diagnosticado com o novo Coronavírus (Covid
                        - 19/ Síndrome Respiratória Aguda Grave - SRAG), desde sua admissão no hospital até sua alta
                        hospitalar, incluindo-se aí todos os atendimentos e procedimentos necessários para obter ou
                        completar o diagnóstico e as terapêuticas necessárias para o tratamento no âmbito hospitalar.
                        No processo de hospitalização estão incluídos: </p>
                    <p align="justify" style="color: black; font-size: 14px;">3.2.2. Tratamento das possíveis complicações que possam
                        ocorrer ao longo do processo
                        assistencial, tanto na fase de tratamento, quanto na fase de recuperação. </p>
                    <p align="justify" style="color: black; font-size: 14px;">3.2.3. Tratamentos concomitantes, diferentes daquele
                        classificado como diagnóstico
                        principal que motivaram a internação do paciente, que podem ser necessários,
                        adicionalmente, devido às condições especiais do paciente e/ou outras causas. </p>
                    <p align="justify" style="color: black; font-size: 14px;">3.2.4. Tratamento medicamentoso que seja requerido durante o
                        processo de internação.</p>
                    <p align="justify" style="color: black; font-size: 14px;">3.2.5. Procedimentos e cuidados de enfermagem, necessários
                        durante o processo de
                        internação.</p>
                    <p align="justify" style="color: black; font-size: 14px;">3.2.6. Alimentação, incluída a assistência nutricional,
                        alimentação enteral e parenteral. </p>
                    <p align="justify" style="color: black; font-size: 14px;">3.2.7. Assistência por equipe médica especializada, pessoal
                        de enfermagem e pessoal técnico. </p>
                    <p align="justify" style="color: black; font-size: 14px;">3.2.8. O material descartável necessário para os cuidados de
                        enfermagem e tratamentos. </p>

                    <p align="justify" style="color: black; font-size: 14px;">3.2.9. Diárias de hospitalização em quarto compartilhado ou
                        individual, quando necessário,
                        devido às condições especiais do paciente e quarto de isolamento. </p>
                    <p style="color: black; font-size: 14px;">3.2.10. Sangue e hemoderivados. </p>
                    <p style="color: black; font-size: 14px;">3.2.11. Hemodiálise para os pacientes internados. </p>
                    <p style="color: black; font-size: 14px;">3.2.12. Fornecimento de roupas hospitalares. </p>
                    <p align="justify" style="color: black; font-size: 14px;">3.2.13. Procedimentos especiais que se fizerem necessários
                        ao adequado atendimento e
                        tratamento do paciente, de acordo com a capacidade instalada, respeitando a
                        complexidade e o perfil estabelecido para o HOSPITAL DE CAMPANHA AURORA. </p>
                @endif
            </div>
            <br>
            <table>
                <tr>
                    <td>
                        <a href="{{ route('transparenciaInstitucionalPdf', $unidade->id) }}" target="__blank"
                            class="btn btn-success btn-sm" style="margin-top: 10px;"><b>Download</b> <i
                                class="fas fa-file-pdf"></i></a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    </div>
    </div>

    <?php
    
    function numeroPorExtenso($numero)
    {
        $unidades = ['', 'um', 'dois', 'três', 'quatro', 'cinco', 'seis', 'sete', 'oito', 'nove'];
        $dezADezenove = ['dez', 'onze', 'doze', 'treze', 'quatorze', 'quinze', 'dezesseis', 'dezessete', 'dezoito', 'dezenove'];
        $dezenas = ['', '', 'vinte', 'trinta', 'quarenta', 'cinquenta', 'sessenta', 'setenta', 'oitenta', 'noventa'];
        $centenas = ['', 'cento', 'duzentos', 'trezentos', 'quatrocentos', 'quinhentos', 'seiscentos', 'setecentos', 'oitocentos', 'novecentos'];
    
        if ($numero === 0) {
            return 'zero';
        }
    
        if ($numero < 0 || $numero > 9999) {
            return 'Número fora da faixa suportada.';
        }
    
        $extenso = '';
    
        if ($numero >= 1000) {
            $milhares = floor($numero / 1000);
            $extenso .= $unidades[$milhares] . ' mil ';
            $numero %= 1000;
        }
    
        if ($numero > 100) {
            $centena = floor($numero / 100);
            $extenso .= $centenas[$centena] . ' ';
            $numero %= 100;
        } elseif ($numero == 100) {
            $centenas = ['', 'cem', 'duzentos', 'trezentos', 'quatrocentos', 'quinhentos', 'seiscentos', 'setecentos', 'oitocentos', 'novecentos'];
            $centena = floor($numero / 100);
            $extenso .= $centenas[$centena] . ' ';
            $numero %= 100;
        }
    
        if ($numero >= 10 && $numero <= 19) {
            $extenso .= $dezADezenove[$numero - 10];
        } else {
            $dezena = floor($numero / 10);
            $unidade = $numero % 10;
    
            $extenso .= $dezenas[$dezena] . ' ';
            $extenso .= $unidades[$unidade];
        }
    
        return trim($extenso);
    }
    ?>

@endsection
