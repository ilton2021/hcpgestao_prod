<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Renovação da Vigência</title>
    <link rel="stylesheet" href="{{ asset('pdf.css') }}" type="text/css"> 
</head>
<body class="pdf">
	<div class="head"><center><img width="250" id="img-unity" src="{{asset('img/Imagem1.png')}}" class="rounded-sm" alt="..."></center></div>
	<table class="table-sm" style="padding: 20px;">
		<tr>
            <td class="w-half">
			  <center><h5>{{ $numeracaoAditivo }} TERMO ADITIVO AO INSTRUMENTO PARTICULAR DE CONTRATO DE PRESTAÇÃO DE SERVIÇOS, NA FORMA ABAIXO:</h5></center>
            </td>
        </tr>
		<tr>
            <td class="w-half">
                <p align="justify"><font size="2">Por este instrumento, <b>SOCIEDADE PERNAMBUCANA DE COMBATE AO CÂNCER – {{ $unidadeSobGestao }}</b>, situado na {{ $unidadeEndereco }}, Estado de Pernambuco, inscrita no CNPJ {{ $cnpjUnidade }}, neste ato representado por seu Superintendente Geral das Unidades sob Gestão, <b>Dr. Filipe Costa Leandro Bitu</b>, residente e domiciliado em Aldeia/PE, doravante designada simplesmente CONTRATANTE, e de outro lado a empresa <b>{{ $nomeEmpresa }}</b>, inscrita  no CNPJ/MF sob o nº {{ $cnpjEmpresa }}, localizada na(o) {{ $enderecoEmpresa }}, neste ato assinado por seu representante legal, nos termos de seu contrato social, a seguir denominada <b>CONTRATADA</b>, têm entre si justo e avançado o presente aditivo ao contrato de prestação de serviços de médicos, que se regerá pelas cláusulas e condições postas em seguida:</font></p>
            </td>
        </tr>
		<tr>
            <td class="w-half">
				<b><font size="2">CLÁUSULA PRIMEIRA – DO OBJETO:</font></b>
            </td>
        </tr>
		<tr>
            <td>
			    <p align="justify"><font size="2">1.1 – As partes resolvem renovar o prazo de vigência contratual, conforme permitido em contrato, pelo período de {{ date('d/m/Y', strtotime($prazoVigencia)) }}, tendo início em {{ date('d/m/Y', strtotime($dataInicioContrato)) }} e término previsto para {{ date('d/m/Y', strtotime($dataTerminoContrato)) }}, podendo ser novamente renovado por iguais e sucessivos períodos, desde que de comum acordo entre as partes e através da formalização do competente aditivo contratual.</p>
		    </td>
        </tr>
        <tr>
            <td class="w-half">
				<b><font size="2">CLÁUSULA SEGUNDA – DAS RATIFICAÇÕES</font></b>
            </td>
        </tr>
        <tr>
            <td>
			    <p align="justify"><font size="2">2.1 – Permanecem inalteradas e em pleno vigor, todas as demais disposições do Contrato e termos aditivos que não tenham sido alteradas ou modificadas por este instrumento no todo ou em parte. E, por estarem desta forma justas e de acordo, as partes assinam o presente instrumento em 02 (duas) vias de igual teor e forma, juntamente com 02 (duas) testemunhas que a tudo estiveram presentes.</p>
		    </td>
        </tr>
	</table>
    <br><br><br><br><br><br>
	<div class="footer"><center><img width="1000" height="65" id="img-unity" src="{{asset('img/rodapes.png')}}" class="rounded-sm" alt="..."></center></div>
	<div class="head"><center><img width="250" id="img-unity" src="{{asset('img/Imagem1.png')}}" class="rounded-sm" alt="..."></center></div>
        <p>
            <center><b>Recife/PE, {{ date('d/m/Y', strtotime($dataAssinatura)) }}.</b></center>
        </p>
	<br><br><br>
    <h4><center><b>SOCIEDADE PERNAMBUCANA DE COMBATE AO CÂNCER – {{ $unidadeSobGestao }}</b></center></h4>
    <br><br>
    <h4><center><b>{{ $nomeEmpresa }}</b></center></h4>
	<table class="table-sm" style="padding: 20px;" border="0">
        
		<tr>
            <td colspan="2"> 
				<b><font size="2">Testemunhas:</font></b>
            </td>
        </tr> <br><br>
		<tr>
            <td style="width: 500px;">
				<b><font size="2">  Nome: _________________________________________________________</font></b>
            </td>
			<td style="width: 500px;">
				<b><font size="2">  Nome: _________________________________________________________</font></b>
            </td>
        </tr><br>
		<tr>
            <td>
				<b><font size="2">CPF/MF: </font></b>
            </td>
			<td>
				<b><font size="2">CPF/MF: </font></b>
            </td>
        </tr>
    </table>
    <br><br><br><br><br><br>
    <div class="footer"><center><img width="1000" height="65" id="img-unity" src="{{asset('img/rodapes.png')}}" class="rounded-sm" alt="..."></center></div>
</body>
</html>