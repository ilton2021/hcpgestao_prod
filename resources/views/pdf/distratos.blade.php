<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Distratos</title>
    <link rel="stylesheet" href="{{ asset('pdf.css') }}" type="text/css"> 
</head>
<body class="pdf">
	<div class="head"><center><img width="250" id="img-unity" src="{{asset('img/Imagem1.png')}}" class="rounded-sm" alt="..."></center></div>
	<table class="table-sm" style="padding: 20px;">
		<tr>
            <td>
				<center><h5>INSTRUMENTO PARTICULAR DE DISTRATO</h5></center>
            </td>
        </tr>
		<tr>
            <td class="w-half">
                <p align="justify"><font size="2">Por este instrumento, <b>SOCIEDADE PERNAMBUCANA DE COMBATE AO CÂNCER – {{ $unidadeSobGestao }}</b>, situado na {{ $enderecoUnidade }}, Estado de Pernambuco, inscrita no CNPJ {{ $cnpjUnidade }}, neste ato representado por seu Superintendente Geral das Unidades sob Gestão, <b>Dr. Filipe Costa Leandro Bitu</b>, residente e domiciliado em Aldeia/PE, doravante designada simplesmente <b>DISTRATANTE</b>, e de outro lado a empresa <b>{{ $nomeEmpresa }}</b>, inscrita no CNPJ/MF sob o nº {{ $cnpjEmpresa }}, localizada na {{ $enderecoEmpresa }}, neste ato por seu representante legal, nos termos de seu contrato social, a seguir denominada <b>DISTRATADA</b>, têm entre si justa e avençada a celebração do presente Distrato, que se regerá pelas condições postas em seguida:</font></p>
            </td>
        </tr>
		<tr>
            <td class="w-half">
				<b><font size="2">CLÁUSULA PRIMEIRA – DO OBJETO DO DISTRATO:</font></b>
            </td>
        </tr>
		<tr>
            <td>
			    <p align="justify"><font size="2"><b>1.1</b> O objeto do presente distrato é a extinção da relação jurídica firmada entre as partes através contrato de {{ $resumo }}, objeto descrito na Cláusula Primeira do Contrato original, assinado entre as partes em {{ date('d/m/Y', strtotime($data_contrato)) }}.</font></p>
				<p align="justify"><font size="2"><b>1.2</b> O presente distrato terá efeitos a partir de {{ date('d/m/Y', strtotime($data_distrato)) }}, não persistindo qualquer obrigação entre as partes a partir desta data.</font></p>
		    </td>
        </tr>
		<tr>
            <td>
				<b><font size="2">CLÁUSULA SEGUNDA – DAS CONDIÇÕES DO DISTRATO:</font></b>
            </td>
        </tr>
		<tr>
            <td>
				<p align="justify"><font size="2"><b>2.1</b> As partes resolvem, em comum acordo, dissolver quaisquer direitos ou obrigações oriundas do Contrato firmado entre as partes  a  partir  da  data  indicada no item 1.2 acima.</font></p>
				<p align="justify"><font size="2"><b>2.2</b> Todas as cláusulas e condições contidas no contrato firmado entre as partes restam extintas e distratadas a partir da data de assinatura do presente distrato, momento em que encerram todas as obrigações recíprocas decorrentes do referido contrato.</font></p>
				<p align="justify"><font size="2"><b>2.3</b> Resolvem as partes na melhor forma do Direito, que darão total e irrestrita quitação sobre todos os direitos e obrigações oriundos do contrato supracitado, não havendo quaisquer pendências recíprocas a serem sanadas a partir desta data, bem como inexiste qualquer direito à indenizações ou reparações em decorrência do presente distrato, exceto direitos e obrigações constituídos na vigência contratual que não foram devidamente cumpridos à época de seu cumprimento.</font></p>
				
		    </td>
        </tr>
	</table>
	<div class="footer"><center><img width="1000" height="65" id="img-unity" src="{{asset('img/rodapes.png')}}" class="rounded-sm" alt="..."></center></div>
	<div class="head"><center><img width="250" id="img-unity" src="{{asset('img/Imagem1.png')}}" class="rounded-sm" alt="..."></center></div>
	<table class="table-sm" style="padding: 20px;">
		<tr>
			<td>
			<p align="justify"><font size="2"><b>2.4</b> As partes renunciam por este ato a pleitear judicial ou extrajudicialmente, quaisquer direitos ou obrigações oriundas do já referido contrato, exceto quanto a fatos ocorridos anteriormente ao presente instrumento particular de distrato e desconhecidos pelas partes até a assinatura deste. E, por estarem desta forma justas e de acordo, as partes assinam o presente instrumento em 02 (duas) vias de igual teor e forma, juntamente com 02 (duas) testemunhas que a tudo estiveram presentes.</font></p>
			</td>
		</tr><br><br>
		<tr>
            <td>
				<b><center>____________________________________________</center></b>
            </td>
        </tr>
		<tr>
            <td>
				<b><center><font size="2">SOCIEDADE PERNAMBUCANA DE COMBATE AO CÂNCER</font></center></b>
            </td>
        </tr>
		<tr>
            <td>
				<b><center>{{ $unidadeSobGestao }}</center></b>
            </td>
        </tr><br><br>
		<tr>
            <td>
				<b><center>____________________________________________</center></b>
            </td>
        </tr>
		<tr>
            <td>
				<b><center><font size="2">{{ $nomeEmpresa }}</font></center></b>
            </td>
        </tr>
	</table>
	<br><br>
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
	<br>
	<div class="footer"><center><img width="1000" height="65" id="img-unity" src="{{asset('img/rodapes.png')}}" class="rounded-sm" alt="..."></center></div>
</body>
</html>