<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notificação de ocorrência</title>
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
    <h3 class="text-center">Notificação de Ocorrência</h3>
    @if ($errors->any())
        <div id="error-message" class="alert alert-success text-center">
            @foreach ($errors->all() as $error)
                <h3>{{ $error }}</h3>
            @endforeach
        </div>
    @endif
    <form action="{{ route('storeOcorrencia') }}" method="post" id="formID">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="row m-2">
            <div class="col-12 col-sm-6  p-4">
                <label class="fw-bold mt-1" for="data_ocorrencia" class="form-label">Data da Ocorrência:<span
                        style="color:red">*</span></label>
                <input class="form-control form-control-sm" type="date" name="data_ocorrencia" id="data_ocorrencia"
                    aria-label=".form-control-sm" required>
                <label class="fw-bold mt-1" for="data_relato" class="form-label">Data do relato:<span
                        style="color:red">*</span></label>
                <input class="form-control form-control-sm" type="date" name="data_relato" id="data_relato"
                    aria-label=".form-control-sm" required>
                <label class="fw-bold mt-1" for="processo" class="form-label">Processo (Setor Notificante):<span
                        style="color:red">*</span></label>
                <select class="js-example-basic-single form-control form-control-sm" name="processo"
                    id="processo" aria-label=".form-select-sm example" required>
                    <option value="">Selecione</option>
                    <option value='AGÊNCIA TRANSFUSIONAL - AGT'>AGÊNCIA TRANSFUSIONAL - AT</option>
                    <option value='ALMOXARIFADO - ALM'>ALMOXARIFADO - ALM</option>
                    <option value='AMBULATÓRIO - AMB'>AMBULATÓRIO - AMB</option>
                    <option value='ANESTESIOLOGIA - ANS'>ANESTESIOLOGIA - ANS</option>
                    <option value='ASSISTÊNCIA FARMACÊUTICA - FAR'>ASSISTÊNCIA FARMACÊUTICA - FAR</option>
                    <option value='ASSISTÊNCIA NUTRICIONAL - NUT'>ASSISTÊNCIA NUTRICIONAL - NUT</option>
                    <option value='AUDITORIA CLÍNICA - AUD'>AUDITORIA CLÍNICA - AUD</option>
                    <option value='BANCO DE LEITE HUMANO - BLH'>BANCO DE LEITE HUMANO - BLH</option>
                    <option value='CASA DA GESTANTE DO BEBÊ E DA PUÉRPERA - CGBP'>CASA DA GESTANTE DO BEBÊ E DA PUÉRPERA - CGBP</option>
                    <option value='CASA DAS BOLSAS - CSB'>CASA DAS BOLSAS - CSB</option>
                    <option value='CENTRAL DE MAQUEIRO - MAQ'>CENTRAL DE MAQUEIRO - MAQ</option>
                    <option value='CENTRAL DE MATERIAL ESTERILIZADO - CME'>CENTRAL DE MATERIAL ESTERILIZADO - CME</option>
                    <option value='CENTRO CIRÚRGICO - CCI'>CENTRO CIRÚRGICO - CCI</option>
                    <option value='CENTRO DE ABASTECIMENTO FARMACÊUTICO - CAF'>CENTRO DE ABASTECIMENTO FARMACÊUTICO - CAF</option>
                    <option value='CENTRO DE ATENÇÃO À MULHER VÍTIMA DE VIOLÊNCIA SONY SANTOS - CAMVV'>CENTRO DE ATENÇÃO À MULHER VÍTIMA DE VIOLÊNCIA SONY SANTOS - CAMVV</option>
                    <option value='CENTRO DE PARTO NORMAL - CPN'>CENTRO DE PARTO NORMAL - CPN</option>
                    <option value='CENTRO DIAGNÓSTICO DE IMAGEM - CDI'>CENTRO DIAGNÓSTICO DE IMAGEM - CDI</option>
                    <option value='COMISSÃO DE CONTROLE DE INFECÇÃO HOSPITALAR – CCIH'>COMISSÃO DE CONTROLE DE INFECÇÃO HOSPITALAR – CCIH</option>
                    <option value='COMISSÃO DE DOCUMENTAÇÃO MÉDICA E ESTATÍSTICA - CDME'>COMISSÃO DE DOCUMENTAÇÃO MÉDICA E ESTATÍSTICA - CDME</option>
                    <option value='COMISSÃO DE ÉTICA DE ENFERMAGEM - CEE'>COMISSÃO DE ÉTICA DE ENFERMAGEM - CEE</option>
                    <option value='COMISSÃO DE ÉTICA MÉDICA - CEM'>COMISSÃO DE ÉTICA MÉDICA - CEM</option>
                    <option value='COMISSÃO DE FARMACÊUTICA E TERAPÊUTICA – CFT'>COMISSÃO DE FARMACÊUTICA E TERAPÊUTICA – CFT</option>
                    <option value='COMISSÃO DE INVESTIGAÇÃO DISCUSSÃO E PREVENÇÃO DA MORTALIDADE MATERNA E NEONATAL - CIDPMMN'>COMISSÃO DE INVESTIGAÇÃO DISCUSSÃO E PREVENÇÃO DA MORTALIDADE MATERNA E NEONATAL - CIDPMMN</option>
                    <option value='COMISSÃO DE REVISÃO DE PRONTUÁRIOS MÉDICOS – CRPM'>COMISSÃO DE REVISÃO DE PRONTUÁRIOS MÉDICOS – CRPM</option>
                    <option value='COMISSÃO DE VERIFICAÇÃO DE ÓBITOS – CVO'>COMISSÃO DE VERIFICAÇÃO DE ÓBITOS – CVO</option>
                    <option value='COMISSÃO INTERNA DE PREVENÇÃO DE ACIDENTES - CIPA'>COMISSÃO INTERNA DE PREVENÇÃO DE ACIDENTES - CIPA</option>
                    <option value='COMISSÃO INTRA HOSPITALAR DE DOAÇÃO DE ÓRGÃOS E TECIDOS PARA TRANSPLANTE - CIHDOTT'>COMISSÃO INTRA HOSPITALAR DE DOAÇÃO DE ÓRGÃOS E TECIDOS PARA TRANSPLANTE - CIHDOTT</option>
                    <option value='COMITÊ DE ÉTICA E PESQUISA - CEP'>COMITÊ DE ÉTICA E PESQUISA - CEP</option>
                    <option value='COMUNICAÇÃO E MARKETING - CMK'>COMUNICAÇÃO E MARKETING - CMK</option>
                    <option value='CONTABILIDADE'>CONTABILIDADE</option>
                    <option value='CONTAS MÉDICAS - CMD'>CONTAS MÉDICAS - CMD</option>
                    <option value='DIRETORIA ADMINISTRATIVA FINANCEIRA - DAF'>DIRETORIA ADMINISTRATIVA FINANCEIRA - DAF</option>
                    <option value='DIRETORIA GERAL - DIG'>DIRETORIA GERAL - DIG</option>
                    <option value='DIRETORIA MULTIDISCIPLINAR - DMT'>DIRETORIA MULTIDISCIPLINAR - DMT</option>
                    <option value='DIRETORIA TÉCNICA - DIT'>DIRETORIA TÉCNICA - DIT</option>
                    <option value='EDUCAÇÃO PERMANENTE - EP'>EDUCAÇÃO PERMANENTE - EP</option>
                    <option value='EMERGÊNCIA - EMG'>EMERGÊNCIA - EMG</option>
                    <option value='ENFERMAGEM - ENF'>ENFERMAGEM - ENF</option>
                    <option value='ENFERMARIA ALTO RISCO - ALR'>ENFERMARIA ALTO RISCO - ALR</option>
                    <option value='ENFERMARIA GINECOLÓGICA - GIN'>ENFERMARIA GINECOLÓGICA - GIN</option>
                    <option value='ENFERMARIA ALOJAMENTO CONJUNTO - ALC'>ENFERMARIA ALOJAMENTO CONJUNTO - ALC</option>
                    <option value='ENGENHARIA CLÍNICA - ENC'>ENGENHARIA CLÍNICA - ENC</option>
                    <option value='ENSINO E PESQUISA - ESP'>ENSINO E PESQUISA - ESP</option>
                    <option value='FATURAMENTO - FAT'>FATURAMENTO - FAT</option>
                    <option value='FISIOTERAPIA - FIS'>FISIOTERAPIA - FIS</option>
                    <option value='GESTÃO DA TECNOLOGIA DA INFORMAÇÃO - GTI'>GESTÃO DA TECNOLOGIA DA INFORMAÇÃO - GTI</option>
                    <option value='HIGIENE E LIMPEZA - HIG'>HIGIENE E LIMPEZA - HIG</option>
                    <option value='LABORATÓRIO - LAB'>LABORATÓRIO - LAB</option>
                    <option value='LACTÁRIO - LAC'>LACTÁRIO - LAC</option>
                    <option value='MANUTENÇÃO PREDIAL - MAP'>MANUTENÇÃO PREDIAL - MAP</option>
                    <option value='NECROTÉRIO - NEC'>NECROTÉRIO - NEC</option>
                    <option value='NÚCLEO DE EPIDEMIOLOGIA - NEPI'>NÚCLEO DE EPIDEMIOLOGIA - NEPI</option>
                    <option value='NÚCLEO INTERNO DE REGULAÇÃO - NIR'>NÚCLEO INTERNO DE REGULAÇÃO - NIR</option>
                    <option value='OUVIDORIA - OUV'>OUVIDORIA - OUV</option>
                    <option value='PATRIMÔNIO - PAT'>PATRIMÔNIO - PAT</option>
                    <option value='PORTARIA - POR'>PORTARIA - POR</option>
                    <option value='PSICOLOGIA - PSI'>PSICOLOGIA - PSI</option>
                    <option value='RECEPÇÃO - REC'>RECEPÇÃO - REC</option>
                    <option value='ROUPARIA - ROP'>ROUPARIA - ROP</option>
                    <option value='SEGURANÇA PATRIMONIAL - SPT'>SEGURANÇA PATRIMONIAL - SPT</option>
                    <option value='SERVIÇO ARQUIVO MÉDICO ESTATÍSTICO (SAME) - ARQ'>SERVIÇO ARQUIVO MÉDICO ESTATÍSTICO (SAME) - ARQ</option>
                    <option value='SERVIÇO DE CONTROLE DE INFECÇÃO HOSPITALAR - SCIH'>SERVIÇO DE CONTROLE DE INFECÇÃO HOSPITALAR - SCIH</option>
                    <option value='SISTEMA DE GESTÃO DA QUALIDADE - SGQ'>SISTEMA DE GESTÃO DA QUALIDADE - SGQ</option>
                    <option value='SISTEMA DE GESTÃO DE PESSOAS - SGP'>SISTEMA DE GESTÃO DE PESSOAS - SGP</option>
                    <option value='SERVIÇO DE TERCEIROS - SVT'>SERVIÇO DE TERCEIROS - SVT</option>
                    <option value='SERVIÇO ESPECIALIZADO EM ENG. SEGURANÇA MEDICINA DO TRAB - SESMT'>SERVIÇO ESPECIALIZADO EM ENG. SEGURANÇA MEDICINA DO TRAB - SESMT</option>
                    <option value='SERVIÇO SOCIAL - SESO'>SERVIÇO SOCIAL - SESO</option>
                    <option value='SUPRIMENTOS -SUP'>SUPRIMENTOS -SUP</option>
                    <option value='UNIDADE DE CUIDADOS INTERMEDIÁRIOS CANGURU - UCA'>UNIDADE DE CUIDADOS INTERMEDIÁRIOS CANGURU - UCA</option>
                    <option value='UNIDADE DE CUIDADOS INTERMEDIÁRIOS CONVENCIONAL - UCI'>UNIDADE DE CUIDADOS INTERMEDIÁRIOS CONVENCIONAL - UCI</option>
                    <option value='UTI MULHER - UMU'>UTI MULHER - UMU</option>
                    <option value='UTI NEONATAL - UNE'>UTI NEONATAL - UNE</option>
                    <option value='VACINA - VAC'>VACINA - VAC</option>
                </select>
                <label class="fw-bold mt-1" for="origem" class="form-label">Origem (Setor Notificado):<span
                        style="color:red">*</span></label>
                <select class="js-example-basic-single form-control form-control-sm" name="origem"
                    id="origem"aria-label=".form-select-sm example" required>
                    <option value="">Selecione</option>
                    <option value="">Selecione</option>
                    <option value='AGÊNCIA TRANSFUSIONAL - AGT'>AGÊNCIA TRANSFUSIONAL - AT</option>
                    <option value='ALMOXARIFADO - ALM'>ALMOXARIFADO - ALM</option>
                    <option value='AMBULATÓRIO - AMB'>AMBULATÓRIO - AMB</option>
                    <option value='ANESTESIOLOGIA - ANS'>ANESTESIOLOGIA - ANS</option>
                    <option value='ASSISTÊNCIA FARMACÊUTICA - FAR'>ASSISTÊNCIA FARMACÊUTICA - FAR</option>
                    <option value='ASSISTÊNCIA NUTRICIONAL - NUT'>ASSISTÊNCIA NUTRICIONAL - NUT</option>
                    <option value='AUDITORIA CLÍNICA - AUD'>AUDITORIA CLÍNICA - AUD</option>
                    <option value='BANCO DE LEITE HUMANO - BLH'>BANCO DE LEITE HUMANO - BLH</option>
                    <option value='CASA DA GESTANTE DO BEBÊ E DA PUÉRPERA - CGBP'>CASA DA GESTANTE DO BEBÊ E DA PUÉRPERA - CGBP</option>
                    <option value='CASA DAS BOLSAS - CSB'>CASA DAS BOLSAS - CSB</option>
                    <option value='CENTRAL DE MAQUEIRO - MAQ'>CENTRAL DE MAQUEIRO - MAQ</option>
                    <option value='CENTRAL DE MATERIAL ESTERILIZADO - CME'>CENTRAL DE MATERIAL ESTERILIZADO - CME</option>
                    <option value='CENTRO CIRÚRGICO - CCI'>CENTRO CIRÚRGICO - CCI</option>
                    <option value='CENTRO DE ABASTECIMENTO FARMACÊUTICO - CAF'>CENTRO DE ABASTECIMENTO FARMACÊUTICO - CAF</option>
                    <option value='CENTRO DE ATENÇÃO À MULHER VÍTIMA DE VIOLÊNCIA SONY SANTOS - CAMVV'>CENTRO DE ATENÇÃO À MULHER VÍTIMA DE VIOLÊNCIA SONY SANTOS - CAMVV</option>
                    <option value='CENTRO DE PARTO NORMAL - CPN'>CENTRO DE PARTO NORMAL - CPN</option>
                    <option value='CENTRO DIAGNÓSTICO DE IMAGEM - CDI'>CENTRO DIAGNÓSTICO DE IMAGEM - CDI</option>
                    <option value='COMISSÃO DE CONTROLE DE INFECÇÃO HOSPITALAR – CCIH'>COMISSÃO DE CONTROLE DE INFECÇÃO HOSPITALAR – CCIH</option>
                    <option value='COMISSÃO DE DOCUMENTAÇÃO MÉDICA E ESTATÍSTICA - CDME'>COMISSÃO DE DOCUMENTAÇÃO MÉDICA E ESTATÍSTICA - CDME</option>
                    <option value='COMISSÃO DE ÉTICA DE ENFERMAGEM - CEE'>COMISSÃO DE ÉTICA DE ENFERMAGEM - CEE</option>
                    <option value='COMISSÃO DE ÉTICA MÉDICA - CEM'>COMISSÃO DE ÉTICA MÉDICA - CEM</option>
                    <option value='COMISSÃO DE FARMACÊUTICA E TERAPÊUTICA – CFT'>COMISSÃO DE FARMACÊUTICA E TERAPÊUTICA – CFT</option>
                    <option value='COMISSÃO DE INVESTIGAÇÃO DISCUSSÃO E PREVENÇÃO DA MORTALIDADE MATERNA E NEONATAL - CIDPMMN'>COMISSÃO DE INVESTIGAÇÃO DISCUSSÃO E PREVENÇÃO DA MORTALIDADE MATERNA E NEONATAL - CIDPMMN</option>
                    <option value='COMISSÃO DE REVISÃO DE PRONTUÁRIOS MÉDICOS – CRPM'>COMISSÃO DE REVISÃO DE PRONTUÁRIOS MÉDICOS – CRPM</option>
                    <option value='COMISSÃO DE VERIFICAÇÃO DE ÓBITOS – CVO'>COMISSÃO DE VERIFICAÇÃO DE ÓBITOS – CVO</option>
                    <option value='COMISSÃO INTERNA DE PREVENÇÃO DE ACIDENTES - CIPA'>COMISSÃO INTERNA DE PREVENÇÃO DE ACIDENTES - CIPA</option>
                    <option value='COMISSÃO INTRA HOSPITALAR DE DOAÇÃO DE ÓRGÃOS E TECIDOS PARA TRANSPLANTE - CIHDOTT'>COMISSÃO INTRA HOSPITALAR DE DOAÇÃO DE ÓRGÃOS E TECIDOS PARA TRANSPLANTE - CIHDOTT</option>
                    <option value='COMITÊ DE ÉTICA E PESQUISA - CEP'>COMITÊ DE ÉTICA E PESQUISA - CEP</option>
                    <option value='COMUNICAÇÃO E MARKETING - CMK'>COMUNICAÇÃO E MARKETING - CMK</option>
                    <option value='CONTABILIDADE'>CONTABILIDADE</option>
                    <option value='CONTAS MÉDICAS - CMD'>CONTAS MÉDICAS - CMD</option>
                    <option value='DIRETORIA ADMINISTRATIVA FINANCEIRA - DAF'>DIRETORIA ADMINISTRATIVA FINANCEIRA - DAF</option>
                    <option value='DIRETORIA GERAL - DIG'>DIRETORIA GERAL - DIG</option>
                    <option value='DIRETORIA MULTIDISCIPLINAR - DMT'>DIRETORIA MULTIDISCIPLINAR - DMT</option>
                    <option value='DIRETORIA TÉCNICA - DIT'>DIRETORIA TÉCNICA - DIT</option>
                    <option value='EDUCAÇÃO PERMANENTE - EP'>EDUCAÇÃO PERMANENTE - EP</option>
                    <option value='EMERGÊNCIA - EMG'>EMERGÊNCIA - EMG</option>
                    <option value='ENFERMAGEM - ENF'>ENFERMAGEM - ENF</option>
                    <option value='ENFERMARIA ALTO RISCO - ALR'>ENFERMARIA ALTO RISCO - ALR</option>
                    <option value='ENFERMARIA GINECOLÓGICA - GIN'>ENFERMARIA GINECOLÓGICA - GIN</option>
                    <option value='ENFERMARIA ALOJAMENTO CONJUNTO - ALC'>ENFERMARIA ALOJAMENTO CONJUNTO - ALC</option>
                    <option value='ENGENHARIA CLÍNICA - ENC'>ENGENHARIA CLÍNICA - ENC</option>
                    <option value='ENSINO E PESQUISA - ESP'>ENSINO E PESQUISA - ESP</option>
                    <option value='FATURAMENTO - FAT'>FATURAMENTO - FAT</option>
                    <option value='FISIOTERAPIA - FIS'>FISIOTERAPIA - FIS</option>
                    <option value='GESTÃO DA TECNOLOGIA DA INFORMAÇÃO - GTI'>GESTÃO DA TECNOLOGIA DA INFORMAÇÃO - GTI</option>
                    <option value='HIGIENE E LIMPEZA - HIG'>HIGIENE E LIMPEZA - HIG</option>
                    <option value='LABORATÓRIO - LAB'>LABORATÓRIO - LAB</option>
                    <option value='LACTÁRIO - LAC'>LACTÁRIO - LAC</option>
                    <option value='MANUTENÇÃO PREDIAL - MAP'>MANUTENÇÃO PREDIAL - MAP</option>
                    <option value='NECROTÉRIO - NEC'>NECROTÉRIO - NEC</option>
                    <option value='NÚCLEO DE EPIDEMIOLOGIA - NEPI'>NÚCLEO DE EPIDEMIOLOGIA - NEPI</option>
                    <option value='NÚCLEO INTERNO DE REGULAÇÃO - NIR'>NÚCLEO INTERNO DE REGULAÇÃO - NIR</option>
                    <option value='OUVIDORIA - OUV'>OUVIDORIA - OUV</option>
                    <option value='PATRIMÔNIO - PAT'>PATRIMÔNIO - PAT</option>
                    <option value='PORTARIA - POR'>PORTARIA - POR</option>
                    <option value='PSICOLOGIA - PSI'>PSICOLOGIA - PSI</option>
                    <option value='RECEPÇÃO - REC'>RECEPÇÃO - REC</option>
                    <option value='ROUPARIA - ROP'>ROUPARIA - ROP</option>
                    <option value='SEGURANÇA PATRIMONIAL - SPT'>SEGURANÇA PATRIMONIAL - SPT</option>
                    <option value='SERVIÇO ARQUIVO MÉDICO ESTATÍSTICO (SAME) - ARQ'>SERVIÇO ARQUIVO MÉDICO ESTATÍSTICO (SAME) - ARQ</option>
                    <option value='SERVIÇO DE CONTROLE DE INFECÇÃO HOSPITALAR - SCIH'>SERVIÇO DE CONTROLE DE INFECÇÃO HOSPITALAR - SCIH</option>
                    <option value='SISTEMA DE GESTÃO DA QUALIDADE - SGQ'>SISTEMA DE GESTÃO DA QUALIDADE - SGQ</option>
                    <option value='SISTEMA DE GESTÃO DE PESSOAS - SGP'>SISTEMA DE GESTÃO DE PESSOAS - SGP</option>
                    <option value='SERVIÇO DE TERCEIROS - SVT'>SERVIÇO DE TERCEIROS - SVT</option>
                    <option value='SERVIÇO ESPECIALIZADO EM ENG. SEGURANÇA MEDICINA DO TRAB - SESMT'>SERVIÇO ESPECIALIZADO EM ENG. SEGURANÇA MEDICINA DO TRAB - SESMT</option>
                    <option value='SERVIÇO SOCIAL - SESO'>SERVIÇO SOCIAL - SESO</option>
                    <option value='SUPRIMENTOS -SUP'>SUPRIMENTOS -SUP</option>
                    <option value='UNIDADE DE CUIDADOS INTERMEDIÁRIOS CANGURU - UCA'>UNIDADE DE CUIDADOS INTERMEDIÁRIOS CANGURU - UCA</option>
                    <option value='UNIDADE DE CUIDADOS INTERMEDIÁRIOS CONVENCIONAL - UCI'>UNIDADE DE CUIDADOS INTERMEDIÁRIOS CONVENCIONAL - UCI</option>
                    <option value='UTI MULHER - UMU'>UTI MULHER - UMU</option>
                    <option value='UTI NEONATAL - UNE'>UTI NEONATAL - UNE</option>
                    <option value='VACINA - VAC'>VACINA - VAC</option>
                </select>
                <label class="fw-bold mt-1" for="unidade" class="form-label">Unidade:<span
                        style="color:red">*</span></label>
                <select class="js-example-basic-single form-control form-control-sm" name="unidade"
                    id="unidade"aria-label=".form-select-sm example" required>
                    <option selected>Hospital da Mulher do Recife</option>
                </select>
                 <label class="fw-bold mt-1" for="unidade" class="form-label">Esta notificação é ?<span
                        style="color:red">*</span></label>
                <select class="js-example-basic-single form-control form-control-sm" name="notificacao"
                    id="notificacao"aria-label=".form-select-sm example" required>
                    <option value="" selected>Selecione..</option>
                    <option value="Notificação Voluntária">Notificação Voluntária</option>
                    <option value="Revisão de Prontuário">Revisão de Prontuário</option>
                    <option value="Auditoria Clínica">Auditoria Clínica</option>
                    <option value="Ouvidoria">Ouvidoria</option>
                </select>
            </div>
            <div class="col-12 col-sm-6  p-4">
                <label class="fw-bold mt-1" for="nome_paciente" class="form-label">Nome do paciente:</label>
                <input class="form-control form-control-sm" type="text" aria-label=".form-control-sm"
                    name="nome_paciente" id="nome_paciente">
                <label class="fw-bold mt-1" for="registro" class="form-label">Registro:</label>
                <input class="form-control form-control-sm" type="text" aria-label=".form-control-sm" name="registro"
                    id="registro">
                <label class="fw-bold mt-1" for="data_nascimento" class="form-label">Data de nascimento:</label>
                <input class="form-control form-control-sm" type="date" aria-label=".form-control-sm"
                    name="data_nascimento" id="data_nascimento">
                <label class="fw-bold mt-1" for="tipoocorrencia" class="form-label">Tipo:<span
                        style="color:red">*</span></label>
                <select class="js-example-basic-single form-control form-control-sm" name="tipoocorrencia"
                    id="tipoocorrencia" aria-label=".form-select-sm example" required>
                    <option value="">Selecione</option>
                    <option value="1">Real (Já ocorrida)</option>
                    <option value="2">Potencial (pode ocorrer)</option>
                    <option value="3">Oportunidade de melhoria</option>
                </select>
                <label class="fw-bold mt-1" for="ocorrencia" class="form-label">Ocorrência:<span
                        style="color:red">*</span></label>
                <select class="form-control form-control-sm js-example-basic-single" name="ocorrencia"
                    id="ocorrencia" aria-label=".form-select-sm example" onchange="ocorrencia_itens()" required>
                    <option value="">Selecione a ocorrência</option>
                    @foreach ($ocorrencias as $o)
                        <option value="{{ $o->id }}">{{ $o->descricao }}</option>
                    @endforeach
                </select>
                <label class="fw-bold mt-1" for="descricao_ocorrencia" class="form-label">Descrição da
                    ocorrência:<span style="color:red">*</span></label>
                <select class="js-example-basic-single form-control form-control-sm" name="descricao_ocorrencia"
                    id="descricao_ocorrencia" aria-label=".form-select-sm example" required>
                    <option value="">Selecione a descrição da ocorrência</option>
                </select>
            </div>
        </div>
        <hr>
        <div class="row m-2">
            <div class="col-12 col-sm-6 p-3">
                <label class="fw-bold mt-1" for="descricao_evento" class="form-label">Descrição do evento<span
                        style="color:red">*</span></label>
                <textarea class="form-control" name="descricao_evento" id="descricao_evento" rows="1" maxlength="700"
                    required></textarea>
                <div class="mt-1" id="contador"></div>
            </div>
            <div class="col-12 col-sm-6 p-3">
                <label class="fw-bold mt-1" for="acao_imediata" class="form-label">Ação corretiva<span
                        style="color:red">* </span>(Imediata)</label>
                <textarea class="form-control" name="acao_imediata" id="acao_imediata" rows="1" maxlength="700" required></textarea>
                <div class="mt-1" id="contador_2"></div>
                <div class="d-sm-flex justify-content-between">
                    <div class="d-flex flex-column">
                        <label class="fw-bold mt-1" for="data_acao_corretiva" class="form-label">Data (Data da Ação Corretiva):<span
                                style="color:red">*</span></label>
                        <input class="form-control form-control-sm" type="date" name="data_acao_corretiva"
                            id="data_acao_corretiva" aria-label=".form-control-sm" required>
                    </div>
                    <div class="d-flex flex-column">
                        <label class="fw-bold mt-1" for="responsavel_acao" class="form-label">Responsável pela
                            Ação:</label>
                        <input class="form-control form-control-sm" type="text" aria-label=".form-control-sm"
                            name="responsavel_acao" id="responsavel_acao">
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row m-2">
            <div class="col-8 col-sm-4 p-3">
                <label class="fw-bold mt-1" for="classificacao_ocorrencia" class="form-label">Classificação da
                    ocorrência:<span style="color:red">*</span></label>
                <select class="js-example-basic-single form-control form-control-sm" name="classificacao_ocorrencia"
                    id="classificacao_ocorrencia" aria-label=".form-select-sm example" required>
                    <option value=""></option>
                    <option value="NÃO CONFORMIDADE">NÃO CONFORMIDADE</option>
                    <option value="INCIDENTE SEM DANO">INCIDENTE SEM DANO</option>
                    <option value="INCIDENTE COM DANO">INCIDENTE COM DANO</option>
                    <option value="QUASE ERRO (NEAR MISS)">QUASE ERRO (NEAR MISS)</option>
                    <option value="CIRCUNSTÂNCIA DE RISCO">CIRCUNSTÂNCIA DE RISCO</option>
                    <option value="EVENTO ADVERSO GRAVE">EVENTO ADVERSO GRAVE</option>
                </select>
            </div>
            <div class="col-8 col-sm-4 p-3">
                <label class="fw-bold mt-1" for="classificacao_dano" class="form-label">Classificação do Dano:<span style="color:red">*</span></label>
                <select class="js-example-basic-single form-control form-control-sm" name="classificacao_dano"
                    id="classificacao_dano"aria-label=".form-select-sm example" required>
                    <option value=""></option>
                    <option value="SEM DANO">SEM DANO</option>
                    <option value="DANO LEVE">DANO LEVE</option>
                    <option value="DANO MODERADO">DANO MODERADO</option>
                    <option value="DANO GRAVE">DANO GRAVE</option>
                    <option value="ÓBITO">ÓBITO</option>
                </select>
            </div>
            <div class="col-8 col-sm-4 p-3">
                <label class="fw-bold mt-1" for="tipo_incidente" class="form-label">Classificar o Tipo de Incidente:<span style="color:red">*</span></label>
                <select class="form-control form-control-sm js-example-basic-single" name="tipo_incidente"
                    id="tipo_incidente" aria-label=".form-select-sm example" onchange="tipo_incidentes()">
                    <option value="">Selecione o Tipo de Incidente</option>
                    @foreach ($tiposIncidentes as $ti)
                        <option value="{{ $ti->id }}">{{ $ti->nome }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row m-2">
            <div class="col-8 col-sm-4 p-3"></div>
            <div class="col-8 col-sm-4 p-3"></div>
            <div class="col-8 col-sm-4 p-3">
                <label class="fw-bold mt-1" for="processo_incidente" class="form-label">Processo (Tipo de Incidente):</label>
                <select class="js-example-basic-single form-control form-control-sm" name="processo_incidente"
                    id="processo_incidente" aria-label=".form-select-sm example" onchange="processo_tipos_incidentes()">
                    <option value="">Selecione o Processo do Tipo de Incidente</option>
                    @foreach ($processoTiposIncidentes as $pti)
                        <option value="{{ $pti->id_ti }}">{{ $pti->nome }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row m-2">
            <div class="col-8 col-sm-4 p-3"></div>
            <div class="col-8 col-sm-4 p-3"></div>
            <div class="col-12 col-sm-4 p-3">
                <label class="fw-bold mt-1" for="problema_incidente" class="form-label">Problema (Tipo de Incidente):</label>
                <select class="js-example-basic-single form-select form-select-sm" name="problema_incidente"
                    id="problema_incidente" aria-label=".form-select-sm example">
                    <option value="">Selecione o Problema do Tipo de Incidente</option>
                    <option value=""></option>
                </select>
            </div>
        </div>
        <hr>
        <div class="row m-2"></div>
        <div class="row m-2 p-3">
            <input class="btn btn-success" type="submit" aria-label=".form-control-sm" name="submit" id="submit">
        </div>
    </form>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.0.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/multiple-select.min.js') }}"></script>
    <script src="{{ asset('js/ocorrencia_form.js') }}"></script>
    <script>
        function ocorrencia_itens() {
            var select = document.getElementById("ocorrencia");
            var dados = <?php echo json_encode($tiposOcorrencias); ?>;
            var select_desc = document.getElementById("descricao_ocorrencia");
            select_desc.innerHTML = "";
            var option   = document.createElement("option");
            option.text  = "Selecione a descricao da ocorrência";
            option.value = "";
            select_desc.appendChild(option);
            dados.forEach(function(ocorrencia) {
                if (ocorrencia.ocorrencias_id == select.value) {
                    var option = document.createElement("option");
                    option.text  = ocorrencia.descricao;
                    option.value = ocorrencia.descricao;
                    select_desc.appendChild(option);
                }
            });
        }

        function tipo_incidentes() {
            var select = document.getElementById("tipo_incidente"); 
            var dados  = <?php echo json_encode($processoTiposIncidentes); ?>;
            var select_desc = document.getElementById("processo_incidente");
            select_desc.innerHTML = "";
            var option   = document.createElement("option");
            option.text  = "Selecione o processo do Tipo de Incidente"; 
            option.value = "";
            select_desc.appendChild(option);
            dados.forEach(function(tipo_incidentes) {
                if (tipo_incidentes.id_ti == select.value) {
                    var option   = document.createElement("option");
                    option.text  = tipo_incidentes.nome;
                    option.value = tipo_incidentes.nome;
                    select_desc.appendChild(option);
                }
            });

            document.getElementById("selct1").hidden = true;
            document.getElementById("selct2").hidden = true;
            document.getElementById("selct3").hidden = true;
            document.getElementById("selct4").hidden = true;
            document.getElementById("selct5").hidden = true;
            document.getElementById("selct6").hidden = true;
            document.getElementById("selct7").hidden = true;
            document.getElementById("selct8").hidden = true;
            document.getElementById("selct9").hidden = true;
            document.getElementById("selct10").hidden = true;
            document.getElementById("selct11").hidden = true;
            document.getElementById("selct12").hidden = true;
            document.getElementById("selct13").hidden = true;
            document.getElementById("selct14").hidden = true;
            document.getElementById("selct15").hidden = true;
            document.getElementById("selct16").hidden = true;
            document.getElementById("selct17").hidden = true;
            document.getElementById("selct18").hidden = true;
            document.getElementById("selct19").hidden = true;
            document.getElementById("selct20").hidden = true;
            document.getElementById("selct21").hidden = true;
            document.getElementById("selct22").hidden = true;
        }

        function processo_tipos_incidentes() {
            var nomeTI = document.getElementById("tipo_incidente").value; 
            var nome = document.getElementById("processo_incidente").value; 
            if (nomeTI == "1") {
                document.getElementById("selct1").hidden = false;
            } else if (nomeTI == "2") {
                document.getElementById("selct2").hidden = false;
            } else if (nomeTI == "3") {
                document.getElementById("selct3").hidden = false;
            } else if (nomeTI == "4") {
                document.getElementById("selct4").hidden = false;
            } else if (nomeTI == "5") {
                document.getElementById("selct5").hidden = false;
            } else if (nomeTI == "6") {
                document.getElementById("selct6").hidden = false;
            } else if (nomeTI == "7") {
                document.getElementById("selct7").hidden = false;
            } else if (nomeTI == "8") {
                document.getElementById("selct8").hidden = false;
            } else if (nomeTI == "9") {
                document.getElementById("selct9").hidden = false;
            } else if (nomeTI == "10") {
                document.getElementById("selct10").hidden = false;
            } else if (nomeTI == "11" && nome == "FORÇA CONTUNDENTE") {
                document.getElementById("selct11").hidden = false;
                document.getElementById("selct12").hidden = true;
                document.getElementById("selct13").hidden = true;
                document.getElementById("selct14").hidden = true;
                document.getElementById("selct15").hidden = true;
                document.getElementById("selct16").hidden = true;
                document.getElementById("selct17").hidden = true;
                document.getElementById("selct18").hidden = true;
                document.getElementById("selct19").hidden = true;
                document.getElementById("selct20").hidden = true;
            } else if (nomeTI == "11" && nome == "FORÇA PERFURANTE / PENETRANTE") {
                document.getElementById("selct11").hidden = true;
                document.getElementById("selct12").hidden = false;
                document.getElementById("selct13").hidden = true;
                document.getElementById("selct14").hidden = true;
                document.getElementById("selct15").hidden = true;
                document.getElementById("selct16").hidden = true;
                document.getElementById("selct17").hidden = true;
                document.getElementById("selct18").hidden = true;
                document.getElementById("selct19").hidden = true;
                document.getElementById("selct20").hidden = true;
            } else if (nomeTI == "11" && nome == "OUTRA FORÇA MECÂNICA") {
                document.getElementById("selct11").hidden = true;
                document.getElementById("selct12").hidden = true;
                document.getElementById("selct13").hidden = false;
                document.getElementById("selct14").hidden = true;
                document.getElementById("selct15").hidden = true;
                document.getElementById("selct16").hidden = true;
                document.getElementById("selct17").hidden = true;
                document.getElementById("selct18").hidden = true;
                document.getElementById("selct19").hidden = true;
                document.getElementById("selct20").hidden = true;
            } else if (nomeTI == "11" && nome == "MECANISMO TÉRMICO") {
                document.getElementById("selct11").hidden = true;
                document.getElementById("selct12").hidden = true;
                document.getElementById("selct13").hidden = true;
                document.getElementById("selct14").hidden = false;
                document.getElementById("selct15").hidden = true;
                document.getElementById("selct16").hidden = true;
                document.getElementById("selct17").hidden = true;
                document.getElementById("selct18").hidden = true;
                document.getElementById("selct19").hidden = true;
                document.getElementById("selct20").hidden = true;
            } else if (nomeTI == "11" && nome == "AMEAÇA À RESPIRAÇÃO") {
                document.getElementById("selct11").hidden = true;
                document.getElementById("selct12").hidden = true;
                document.getElementById("selct13").hidden = true;
                document.getElementById("selct14").hidden = true;
                document.getElementById("selct15").hidden = false;
                document.getElementById("selct16").hidden = true;
                document.getElementById("selct17").hidden = true;
                document.getElementById("selct18").hidden = true;
                document.getElementById("selct19").hidden = true;
                document.getElementById("selct20").hidden = true;
            } else if (nomeTI == "11" && nome == "EXPOSIÇÃO À SUBSTÂNCIA QUÍMICA OU OUTRA") {
                document.getElementById("selct11").hidden = true;
                document.getElementById("selct12").hidden = true;
                document.getElementById("selct13").hidden = true;
                document.getElementById("selct14").hidden = true;
                document.getElementById("selct15").hidden = true;
                document.getElementById("selct16").hidden = false;
                document.getElementById("selct17").hidden = true;
                document.getElementById("selct18").hidden = true;
                document.getElementById("selct19").hidden = true;
                document.getElementById("selct20").hidden = true;
            } else if (nomeTI == "11" && nome == "OUTRO TIPO DE MECANISMO DE LESÃO ESPECÍFICO") {
                document.getElementById("selct11").hidden = true;
                document.getElementById("selct12").hidden = true;
                document.getElementById("selct13").hidden = true;
                document.getElementById("selct14").hidden = true;
                document.getElementById("selct15").hidden = true;
                document.getElementById("selct16").hidden = true;
                document.getElementById("selct17").hidden = false;
                document.getElementById("selct18").hidden = true;
                document.getElementById("selct19").hidden = true;
                document.getElementById("selct20").hidden = true;
            } else if (nomeTI == "11" && nome == "EXPOSIÇÃO A (EFEITO DE) CONDIÇÃO CLIMATÉRICA, DESASTRES NATURAIS OU OUTRAS FORÇAS DA NATUREZA") {
                document.getElementById("selct11").hidden = true;
                document.getElementById("selct12").hidden = true;
                document.getElementById("selct13").hidden = true;
                document.getElementById("selct14").hidden = true;
                document.getElementById("selct15").hidden = true;
                document.getElementById("selct16").hidden = true;
                document.getElementById("selct17").hidden = true;
                document.getElementById("selct18").hidden = false;
                document.getElementById("selct19").hidden = true;
                document.getElementById("selct20").hidden = true;
            } else if (nomeTI == "11" && nome == "QUEDAS") {
                document.getElementById("selct11").hidden = true;
                document.getElementById("selct12").hidden = true;
                document.getElementById("selct13").hidden = true;
                document.getElementById("selct14").hidden = true;
                document.getElementById("selct15").hidden = true;
                document.getElementById("selct16").hidden = true;
                document.getElementById("selct17").hidden = true;
                document.getElementById("selct18").hidden = true;
                document.getElementById("selct19").hidden = false;
                document.getElementById("selct20").hidden = true;
            } else if (nomeTI == "11" && nome == "LESÃO POR PRESSÃO") {
                document.getElementById("selct11").hidden = true;
                document.getElementById("selct12").hidden = true;
                document.getElementById("selct13").hidden = true;
                document.getElementById("selct14").hidden = true;
                document.getElementById("selct15").hidden = true;
                document.getElementById("selct16").hidden = true;
                document.getElementById("selct17").hidden = true;
                document.getElementById("selct18").hidden = true;
                document.getElementById("selct19").hidden = true;
                document.getElementById("selct20").hidden = false;
            } else if (nomeTI == "12") {
                document.getElementById("selct21").hidden = false;
            } else if (nomeTI == "13") {
                document.getElementById("selct22").hidden = false;
            }
        }
    </script>
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
