<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contratos Serviço Médicos Consultas</title>
    <link rel="stylesheet" href="{{ asset('pdf.css') }}" type="text/css"> 
</head>
<body class="pdf">
	<div class="head"><center><img width="250" id="img-unity" src="{{asset('img/Imagem1.png')}}" class="rounded-sm" alt="..."></center></div>
	<table class="table-sm" style="padding: 20px;">
		<tr>
            <td class="w-half">
			  <center><h5>INSTRUMENTO PARTICULAR DE CONTRATO DE PRESTAÇÃO DE SERVIÇOS MÉDICOS, NA FORMA ABAIXO:</h5></center>
            </td>
        </tr>
		<tr>
            <td class="w-half">
                <p align="justify"><font size="2">Por este instrumento, <b>SOCIEDADE PERNAMBUCANA DE COMBATE AO CANCER – {{ $unidadeSobGestao }}</b>, entidade sem fins lucrativos, com sede na {{ $unidadeEndereco }}, inscrita no CNPJ sob o nº {{ $cnpjUnidade }}, representada por seu Superintendente Geral das Unidade sob Gestão, <b>Dr. Filipe Costa Leandro Bitu</b>, residente e domiciliado em Aldeia/PE, doravante designada simplesmente <b>CONTRATANTE</b>, e de outro, <b>{{ $nomeEmpresa }}</b>, inscrita no CNPJ sob o nº {{ $cnpjEmpresa }}, localizada na {{ $enderecoEmpresa }}, neste ato por seu representante legal, nos termos de seu contrato social, a seguir denominada <b>CONTRATADA</b>, têm entre si justo e avençado o presente contrato de prestação de serviços médicos, que se regerá pelas cláusulas e condições postas em seguida:</font></p>
            </td>
        </tr>
		<tr>
            <td class="w-half">
				<b><font size="2">CLÁUSULA PRIMEIRA – OBJETO CONTRATUAL:</font></b>
            </td>
        </tr>
		<tr>
            <td>
			    <p align="justify"><font size="2">1.1 A <b>CONTRATANTE</b>, por este instrumento, e na melhor forma de direito, contrata os serviços médicos da <b>CONTRATADA</b>, na especialidade médica de {{ $especialidade }}, para realização de {{ $numConsultasMes }} consultas ambulatoriais por mês, serviços a serem prestados nas instalações hospitalares da <b>CONTRATANTE</b>.</font></p>
				<p align="justify"><font size="2">1.2 As escalas dos turnos dos serviços ora contratados serão previamente designadas pela <b>CONTRATANTE</b>, de acordo com a demanda necessária, que apresentará cronograma mensal à <b>CONTRATADA</b>.</font></p>
				<p align="justify"><font size="2">1.3 A <b>CONTRATADA</b> alocará profissionais em número necessário e suficiente para a execução do presente contrato, às suas expensas, e, ainda, de acordo com a natureza e complexidade dos serviços prestados, pactuando-se desde já que o número de profissionais e o regime de atuação poderão variar ao longo do tempo em função da prestação dos serviços, conforme solicitado pela <b>CONTRATANTE</b>.</font></p>
				<p align="justify"><font size="2">1.4 Poderá a <b>CONTRATANTE</b> determinar o bloqueio da agenda de consultas por turno de 6 (seis) horas para participação dos profissionais da empresa <b>CONTRATADA</b> nas ações de educação permanente e do PlanificaSUS, onde estes deverão realizar as atividades necessárias para execução deste projeto.</font></p>
				<p align="justify"><font size="2">1.4.1 Nestes casos, a <b>CONTRATADA</b> fará jus ao recebimento do valor equivalente a 25 (vinte e cinco) consultas médicas por turno de 6 (seis) horas bloqueado, com base no valor unitário da consulta previsto no item 2.1 deste contrato, mediante a participação efetiva de seus profissionais nas atividades do projeto PlanificaSUS.</font></p>
		  </td>
        </tr>
	</table>
	<div class="footer"><center><img width="1000" height="65" id="img-unity" src="{{asset('img/rodapes.png')}}" class="rounded-sm" alt="..."></center></div>
	<br><br>
	<div class="head"><center><img width="250" id="img-unity" src="{{asset('img/Imagem1.png')}}" class="rounded-sm" alt="..."></center></div>
	<table class="table-sm" style="padding: 20px;">
		<tr>
            <td class="w-half">
				<b><font size="2">CLÁUSULA SEGUNDA – REMUNERAÇÃO E FORMA DE PAGAMENTO</font></b>
            </td>
        </tr>
		<tr>
            <td>
				<p align="justify"><font size="2">2.1 Pelos serviços ora contratados, a <b>CONTRATANTE</b> pagará à <b>CONTRATADA</b> o valor unitário de {{ $valorUniCons }} por consulta.</font></p>
				<p align="justify"><font size="2">2.1.1 Caso a <b>CONTRATADA</b> não atinja a quantidade de consultas especificada no item 1.1 da Cláusula Primeira do presente Contrato, ou realize o trabalho em menos turnos do que o efetivamente contratado, o valor será pago com desconto dos valores unitários descritos no item 2.1, acima, sem prejuízo de demais penalidades aplicadas ao caso.</font></p>
				<p align="justify"><font size="2">2.2 A <b>CONTRATADA</b> deverá apresentar, mensalmente, as faturas e notas fiscais relativas a seus serviços, devidamente acompanhada de relatório discriminado que deverá conter a totalidade dos serviços prestados e demais informações necessárias à comprovação, pela <b>CONTRATANTE</b>, da exatidão da prestação dos serviços. Tais documentos deverão ser encaminhados até o dia 5 (cinco) do mês subsequente ao da prestação dos serviços, com o pagamento até o dia 20 (vinte) do mesmo mês subsequente.</font></p>
				<p align="justify"><font size="2">2.2.1 Caso sejam constatadas falhas no relatório ou na nota fiscal dos serviços, o pagamento ficará sobrestado até que as falhas sejam corrigidas, de modo que o prazo para pagamento voltará a fluir do instante em que as informações sejam avaliadas e aprovadas pela <b>CONTRATANTE</b>.</font></p>
				<p align="justify"><font size="2">2.2.2 Poderá a <b>CONTRATANTE</b> glosar o pagamento de qualquer serviço discriminado no relatório acima indicado que  não  esteja  em  compatibilidade com o presente contrato ou diante da  ausência  da  documentação respectivamente necessária.</font></p>
				<p align="justify"><font size="2">2.2.3 Caso seja constatado que o contrato não foi cumprido em sua integralidade, a <b>CONTRATANTE</b> irá realizar o pagamento das respectivas consultas cuja execução foi comprovada, sem prejuízo de demais penalidades, caso cabível.</font></p>
				<p align="justify"><font size="2">2.3 A realização dos serviços objeto deste contrato, assim como suas respectivas contas, será acompanhada e avaliada pelo Diretor Médico e validada pela Coordenação Multidisciplinar, ou outras designadas pela <b>CONTRATANTE</b> para tal finalidade. A <b>CONTRATADA</b> deverá proporcionar as condições necessárias para que esse acompanhamento possa ocorrer de forma plena.</font></p>
				<p align="justify"><font size="2">2.4 O preço acordado neste instrumento compreende as obrigações tributárias vigentes que sobre ele incidam, as quais ficarão a cargo da <b>CONTRATADA</b>, compreendendo todos os custos para realização dos serviços, cabendo a <b>CONTRATANTE</b> realizar, tão-somente, os descontos previstos na legislação tributária.</font></p>
				
		    </td>
        </tr>
		<br>
		<br>
		<tr>
			<div class="footer"><center><img width="1000" height="65" id="img-unity" src="{{asset('img/rodapes.png')}}" class="rounded-sm" alt="..."></center></div>
		</tr>
		<div class="head"><center><img width="250" id="img-unity" src="{{asset('img/Imagem1.png')}}" class="rounded-sm" alt="..."></center></div>
	</table>
	<table class="table-sm" style="padding: 20px;">
		<tr>
			<td>
				<p align="justify"><font size="2">2.5 Tendo em vista que o pagamento da contraprestação decorre de verbas recebidas através do contrato de gestão firmado com o Estado de Pernambuco, em eventual atraso no pagamento, não incidirá juros ou multa.</font></p>
				<p align="justify"><font size="2">2.6 O quantitativo mensal de consultas apresentado na Cláusula Primeira do presente contrato é estimativo e o valor total do pagamento mensal será realizado de acordo com a demanda efetivamente executada pela <b>CONTRATADA</b>, levando-se em consideração o valor unitário especificado no item 2.1.</font></p>
				<p align="justify"><font size="2">2.7 A demanda mensal da <b>CONTRATADA</b> será apurada mediante relatório emitido através do sistema de controle da <b>CONTRATANTE</b>.</font></p>
			</td>
		</tr>
		<tr>
            <td class="w-half">
				<b><font size="2">CLÁUSULA TERCEIRA – DAS OBRIGAÇÕES DA CONTRATANTE:</font></b>
            </td>
        </tr>
		<tr>
            <td class="w-half">
				<p align="justify"><font size="2">3.1 Fornecer previamente à <b>CONTRATADA</b> todas as normas internas, técnicas ou administrativas que deverão orientar os serviços ora contratados.</font></p>
				<p align="justify"><font size="2">3.2 Manter a <b>CONTRATADA</b> informada sobre quaisquer decisões de caráter gerencial, técnico ou administrativo que de alguma forma possam afetar a operacionalização dos serviços objeto deste contrato.</font></p>
				<p align="justify"><font size="2">3.3 Notificar por escrito a <b>CONTRATADA</b>, sobre qualquer irregularidade verificada na prestação dos serviços objeto deste contrato.</font></p>
				<p align="justify"><font size="2">3.4 Cumprir todas as obrigações previstas neste Contrato, inclusive o que se refere aos procedimentos de pagamento, nas formas e prazos ali previstos.</font></p>
		    </td>
        </tr>
		<tr>
            <td class="w-half">
				<b><font size="2">CLÁUSULA QUARTA – DAS OBRIGAÇÕES DA CONTRATADA:</font></b>
            </td>
        </tr>
		<tr>
			<td>
				<p align="justify"><font size="2">4.1 Prestar os serviços objeto deste contrato observando o mais alto padrão técnico profissional e de qualidade, inclusive utilizando apenas profissionais médicos devidamente habilitados para executarem o serviço objeto  deste contrato.</font></p>
				<p align="justify"><font size="2">4.2 Disponibilizar profissionais para atender à demanda da <b>CONTRATANTE</b>, mediante apresentação do nome e documentos pessoais dos prestadores e colaboradores.</font></p>
			</td>
		</tr>
		<br><br>
		<tr>
			<div class="footer"><center><img width="1000" height="65" id="img-unity" src="{{asset('img/rodapes.png')}}" class="rounded-sm" alt="..."></center></div>
		</tr>
		<div class="head"><center><img width="250" id="img-unity" src="{{asset('img/Imagem1.png')}}" class="rounded-sm" alt="..."></center></div>
		<tr>
			<td>
				<p align="justify"><font size="2">4.3 Substituir, a qualquer tempo, mediante solicitação, mesmo que injustificada, da <b>CONTRATANTE</b>, quaisquer de seus profissionais que estiverem desenvolvendo suas funções no cumprimento do presente contrato.</font></p>
				<p align="justify"><font size="2">4.4 Fornecer à <b>CONTRATANTE</b>, sempre que solicitada e em tempo hábil, todos os esclarecimentos e informações necessários ao perfeito entendimento dos serviços executados.</font></p>
				<p align="justify"><font size="2">4.5 Zelar pela integridade dos pacientes que estiverem sob seus cuidados, mesmo que indiretamente, em razão da prestação dos serviços contratados, respondendo por quaisquer danos e/ou prejuízos causados à <b>CONTRATANTE</b>, aos pacientes ou a terceiros, salvo quando decorrentes de força maior.</font></p>
				<p align="justify"><font size="2">4.6 Remunerar seus médicos associados e/ou empregados envolvidos na prestação dos serviços objeto deste contrato, bem como efetuar o recolhimento de todos os tributos e demais encargos trabalhistas, fundiários, cíveis ou de qualquer outra natureza que venham a incidir, direta ou indiretamente, sobre o presente contrato, tudo em consonância com a legislação pátria, apresentando, sempre que por este solicitado, cópia dos comprovantes de pagamento.</font></p>
				<p align="justify"><font size="2">4.7 Apresentar à <b>CONTRATANTE</b>, sempre que por este solicitado, no prazo de 10 (dez) dias úteis, certidões comprobatórias de regularidade com a Fazenda Federal, Estadual e Municipal, e certidões comprobatórias de regularidade com o Instituto Nacional do Seguro Social (INSS) e Fundo de Garantia Por Tempo de Serviço (FGTS).</font></p>
				<p align="justify"><font size="2">4.8 A <b>CONTRATADA</b> deverá apresentar à <b>CONTRATANTE</b>, até o dia 31 de março de cada ano, a certidão de regularidade com o Conselho Regional de Medicina do Estado de Pernambuco – CREMEPE, por meio da qual comprove a habilitação legal para o exercício da medicina e a quitação das obrigações financeiras de cada um dos seus médicos perante o referido Conselho.</font></p>
				<p align="justify"><font size="2">4.9 Tendo em vista que a prestação dos serviços envolve a utilização de documentos que compõem prontuário médico, resguardado pelo sigilo profissional, compromete-se a <b>CONTRATADA</b> em zelar pela inviolabilidade deste sigilo, responsabilizando-se, quando der causa, por todos os prejuízos decorrentes de eventual violação.</font></p>
				<p align="justify"><font size="2">4.10 Os profissionais médicos utilizados pela <b>CONTRATADA</b> na prestação dos serviços deverão possuir assinatura eletrônica, digital e/ou certificado digital, compatível com os sistemas utilizados pela <b>CONTRATADA</b>.</font></p>
				<p align="justify"><font size="2">4.10.1 Caso os profissionais utilizados pela <b>CONTRATADA</b> não atendam ao requisito acima, caberá a esta arcar imediatamente com todos os custos necessários para adequação/criação da assinatura eletrônica, digital e/ou certificado digital.</font></p>
			</td>
		</tr>
		<br><br>
		<tr>
			<div class="footer"><center><img width="1000" height="65" id="img-unity" src="{{asset('img/rodapes.png')}}" class="rounded-sm" alt="..."></center></div>
		</tr>
		<div class="head"><center><img width="250" id="img-unity" src="{{asset('img/Imagem1.png')}}" class="rounded-sm" alt="..."></center></div>
		<tr>
            <td class="w-half">
				<b><font size="2">CLÁUSULA QUINTA – DA RESPOSABILIDADE NA PRESTAÇÃO DOS SERVIÇOS:</font></b>
            </td>
        </tr>
		<tr>
			<td class="w-half">
				<p align="justify"><font size="2">5.1 A <b>CONTRATADA</b> é a única e exclusiva responsável pelas obrigações tributárias, trabalhistas, sociais, fundiárias e quaisquer outras direta ou indiretamente relativas a cada um de seus associados ou empregados, que venham a prestar serviços para a <b>CONTRATANTE</b>, especialmente por possíveis reclamações trabalhistas, arcando exclusivamente com possíveis acordos e/ou condenações na Justiça do Trabalho, não cabendo à <b>CONTRATANTE</b> qualquer vínculo ou responsabilidade, solidária, subsidiária ou de qualquer outra natureza nesse sentido.</font></p>
				<p align="justify"><font size="2">5.2 A <b>CONTRATADA</b> responsabilizar-se-á perante a <b>CONTRATANTE</b> por todos os processos, danos e/ou despesas concernentes à violação de direito de terceiros e por estes reclamados judicial ou extrajudicialmente, a qualquer título, eventualmente oriundos da presente prestação de serviços e indenizará a <b>CONTRATANTE</b> das possíveis e respectivas despesas, no prazo máximo de 30 (trinta) dias contados da comunicação por escrito da <b>CONTRATANTE</b> à <b>CONTRATADA</b> do valor devido.</font></p>
				<p align="justify"><font size="2">5.3 A <b>CONTRATADA</b> se compromete ainda a assumir o polo passivo em qualquer demanda judicial decorrente dos fatos narrados nesta Cláusula, isentando a <b>CONTRATANTE</b> de qualquer responsabilidade na lide e ressarcindo prontamente toda e qualquer despesa em que venha a incorrer a <b>CONTRATANTE</b>, como honorários advocatícios, custas processuais, indenizações e todas as demais.</font></p>
	        </td>
        </tr>
		<tr>
			<td class="w-half">
				<b><font size="2">CLÁUSULA SEXTA – DA VIGÊNCIA E HIPÓTESES DE RESCISÃO:</font></b>
            </td>
        </tr>
		<tr>
			<td class="w-half">
				<p align="justify"><font size="2">6.1 O presente contrato terá vigência pelo período de {{ date('d/m/Y', strtotime($prazoVigencia)) }} meses, contados a partir de {{ date('d/m/Y', strtotime($inicioContrato)) }}, podendo ser rescindido por qualquer das partes, a qualquer tempo, mediante notificação por escrito com 30 (trinta) dias de antecedência, sem que em decorrência disto seja devido qualquer tipo de multa ou indenização, podendo ser renovado sucessivamente por iguais períodos por meio de aditivo contratual celebrado entre as partes.</font></p>
				<p align="justify"><font size="2">6.2 O presente contrato será, também, rescindido, de imediato, na hipótese de ocorrer a rescisão ou término de vigência do contrato de gestão firmado entre a <b>CONTRATANTE</b> e a Secretaria de Saúde do Estado de Pernambuco/SES.</font></p>
				<p align="justify"><font size="2">6.3 O presente contrato também poderá ser rescindido imediatamente pela CONTRATANTE diante de falta contratual grave cometida pela CONTRATADA, garantindo o direito ao contraditório no prazo de 3 (três) dias.</font></p>
				
            </td>
        </tr>
		<br><br><br><br>
		<tr>
			<div class="footer"><center><img width="1000" height="65" id="img-unity" src="{{asset('img/rodapes.png')}}" class="rounded-sm" alt="..."></center></div>
		</tr>
		<div class="head"><center><img width="250" id="img-unity" src="{{asset('img/Imagem1.png')}}" class="rounded-sm" alt="..."></center></div>
        <tr>
			<td class="w-half">
				<b><font size="2">CLAÚSULA SÉTIMA – DA PROTEÇÃO GERAL DE DADOS (LGPD)</font></b>
            </td>
        </tr>
		<tr>
			<td class="w-half">
				<p align="justify"><font size="2">7.1 Sempre que houver necessidade no tratamento de dados pessoais as PARTES se obrigam a seguir os ditames da Lei 13.709 de 2018 (Lei Geral de Proteção de Dados), garantindo os meios adequados ao tratamento de dados dos titulares tanto no meio digital como no meio físico, tanto na coleta, como no armazenamento, observando as seguintes condições:</font></p>
				<p align="justify"><font size="2">7.2 O tratamento de dados pessoais deverá ser pautado por finalidades legítimas diretamente relacionadas à execução do objeto contratual e ao cumprimento de suas obrigações frente a ele, tratando somente o essencial; garantindo o livre acesso dos dados aos titulares; garantindo a clareza e integridade dos dados dos titulares; empregando meios aptos para garantir a proteção dos dados quando do armazenamento; prezando pela tomada de medidas preventivas e não discriminatórias;</font></p>
				<p align="justify"><font size="2">7.3 Nenhum dado pessoal será tratado sem o devido enquadramento em pelo menos uma das hipóteses legais previstas nos artigos 7º e 11º, da LGPD, bem como em respeito aos princípios norteadores do artigo 6º, da LGPD;</font></p>
				<p align="justify"><font size="2">7.4 O tratamento de dados deverá observar medidas técnicas e organizacionais adequadas para garantir a segurança e a confidencialidade dos dados pessoais tratados, de acordo com as melhores práticas de tecnologia e segurança da informação;</font></p>
				<p align="justify"><font size="2">7.5 Caso ocorra um incidente envolvendo dados pessoais que possa acarretar um risco ou dano relevante aos titulares afetados, a parte lesada deverá ser notificada no prazo máximo de 48 (quarenta e oito) horas a contar da ciência do incidente, descrevendo, pelo menos, a natureza dos dados pessoais afetados; as informações sobre os titulares envolvidos; as medidas técnicas e de segurança utilizadas para a proteção dos dados, observados os segredos comercial e industrial; os riscos relacionados ao incidente; os motivos da demora, no caso de a comunicação não ter sido imediata; e as medidas que foram ou que serão adotadas para reverter ou mitigar os efeitos do prejuízo;</font></p>
				<p align="justify"><font size="2">7.6 O compartilhamento de dados pessoais para terceiros somente será permitido para atender as finalidades previstas neste Contrato, mediante consentimento do titular de dados ou nas hipóteses previstas na LGPD. Ressalta- se que a parte que compartilhou os dados assumirá todos os ônus decorrentes do referido compartilhamento;</font></p>
				<p align="justify"><font size="2">7.7 Após a rescisão do Contrato, a parte que realizou o tratamento de dados pessoais deverá eliminá-lo de seu banco de dados, ressalvando as hipóteses previstas na LGPD, bem como observando os prazos de retenção de dados conforme legislação específica.</font></p>
		    </td>
        </tr>
		<br><br><br><br><br><br>
		<tr>
			<div class="footer"><center><img width="1000" height="65" id="img-unity" src="{{asset('img/rodapes.png')}}" class="rounded-sm" alt="..."></center></div>
		</tr>
		<div class="head"><center><img width="250" id="img-unity" src="{{asset('img/Imagem1.png')}}" class="rounded-sm" alt="..."></center></div>
        <tr>
			<td class="w-half">
				<b><font size="2">CLÁUSULA OITAVA – DAS SANÇÕES</font></b>
            </td>
        </tr>
		<tr>
			<td class="w-half">
				<p align="justify"><font size="2">8.1 Em caso de descumprimento das disposições contratuais ou das orientações apresentadas pela <b>CONTRATANTE</b> para a boa execução do contrato, a <b>CONTRATADA</b> será notificada por escrito para correção do descumprimento no prazo de até 5 (cinco) dias úteis.</font></p>
				<p align="justify"><font size="2">8.1.1 Caso não ocorra a correção do descumprimento ou mesmo no caso de reincidência, a <b>CONTRATANTE</b> aplicará multa por inexecução contratual a ser aplicada no percentual de até vinte por cento (20%) do valor total do contrato.</font></p>
				<p align="justify"><font size="2">8.1.2 Caso não seja possível aferir o valor total do contrato por se tratar de pagamento por produção ou eventual, será utilizada a média das 3 (três) últimas faturas pagas à <b>CONTRATADA</b> multiplicada pelo prazo de vigência contratual.</font></p>
				<p align="justify"><font size="2">8.2 Em caso de aplicação de multa, que pode ser aplicada cumulativamente por cada caso de descumprimento contratual, a <b>CONTRATANTE</b> poderá realizar desconto em valores a serem pagos à <b>CONTRATADA</b>, realizando o pagamento apenas do valor sobejante, caso exista.</font></p>
				<p align="justify"><font size="2">8.3 As multas previstas têm caráter de sanção administrativa e sua aplicação não exime a <b>CONTRATADA</b> da reparação de eventuais perdas e danos que seus atos venham a acarretar à <b>CONTRATANTE</b> ou a terceiros.</font></p>
		    </td>
        </tr>
        <tr>
			<td class="w-half">
				<b><font size="2">CLAÚSULA NONA – DISPOSIÇÕES DIVERSAS:</font></b>
            </td>
        </tr>
		<tr>
			<td>
				<p align="justify"><font size="2">9.1 O eventual acesso ao prontuário médico ou de documentos que o integrem será feito sob sigilo e de acordo com o estabelecido no Código de Ética Médica.</font></p>
				<p align="justify"><font size="2">9.2 O presente contrato não importa em exclusividade de serviços para com a <b>CONTRATANTE</b>, por parte da <b>CONTRATADA</b>, nem implica vínculo empregatício, de qualquer espécie.</font></p>
				<p align="justify"><font size="2">9.3 Trimestralmente, a <b>CONTRATADA</b> deverá apresentar à <b>CONTRATANTE</b>, declarações que comprovem que efetivamente prestam serviços a outras entidades, devidamente acompanhada dos documentos fiscais comprobatórios.</font></p>
				<p align="justify"><font size="2">9.4 Eventual tolerância de uma das partes em relação a qualquer infração ou inadimplência cometida pela outra parte, em relação a qualquer cláusula ou obrigação contemplada por este contrato, será considerada como mera liberalidade e não constituirá perdão, renúncia ou novação, podendo a parte tolerante, a qualquer momento, exigir o fiel cumprimento das obrigações ora assumidas.</font></p>
				<p align="justify"><font size="2">9.5 Este instrumento revoga qualquer outro acordo firmado entre as partes.</font></p>
				
		    </td>
        </tr>
		<tr>
			<div class="footer"><center><img width="1000" height="65" id="img-unity" src="{{asset('img/rodapes.png')}}" class="rounded-sm" alt="..."></center></div>
		</tr>
		<div class="head"><center><img width="250" id="img-unity" src="{{asset('img/Imagem1.png')}}" class="rounded-sm" alt="..."></center></div>
		<tr>
			<td><p align="justify"><font size="2">9.6 As partes elegem, com expressa renúncia de qualquer outro, por mais privilegiado que seja, o foro da Comarca de Recife, Estado de Pernambuco, para dirimir quaisquer questões que decorram, direta ou indiretamente, do presente contrato.</font></p></td>
		</tr>
		<tr>
			<td>
				<p align="justify"><font size="2">E por estarem, assim, justas e acordadas, assinam o presente instrumento, em duas vias de igual teor, na presença das testemunhas que a tudo assistiram, para que produza seus efeitos jurídicos e legais.</font></p>
			</td>
		</tr>
		<br><br><br>
		<tr>
            <td><center><b>Recife/PE, {{ $dataAssinatura }}.</b></center></td>
        </tr>
		<p><center><b> _________________________________________________________</b></center></p>
		<p><center><b>SOCIEDADE PERNAMBUCANA DE COMBATE AO CÂNCER {{ $unidadeSobGestao }}</b></center></p>
		<br>
		<p><center><b> _________________________________________________________</b></center></p>
		<p><center><b>{{ $nomeEmpresa }}</b></center></p>
		<br><br><br><br>
		<tr>
		<div class="footer"><center><img width="1000" height="65" id="img-unity" src="{{asset('img/rodapes.png')}}" class="rounded-sm" alt="..."></center></div>
	</tr>
	<div class="head"><center><img width="250" id="img-unity" src="{{asset('img/Imagem1.png')}}" class="rounded-sm" alt="..."></center></div>
    </table>
	<table class="table-sm" style="padding: 20px;" border="0">
		<br><br><br><br>
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
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<div class="footer"><center><img width="1000" height="65" id="img-unity" src="{{asset('img/rodapes.png')}}" class="rounded-sm" alt="..."></center></div>
</body>
</html>