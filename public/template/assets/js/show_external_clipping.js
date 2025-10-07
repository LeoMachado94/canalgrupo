function salva_etiqueta(id,id_pessoa,id_clipping)
{
	//alert('gravando');
	document.getElementById(id+'_'+id_pessoa+'_'+id_clipping).innerHTML = " Salvando registro... ";

	var div_salvamento = id+'_'+id_pessoa+'_'+id_clipping;

	ajaxHTML(div_salvamento,'inc/busca_ajax.php?tipo=etiqueta_salva&_id='+id+'&_id_pessoa='+id_pessoa+'&_id_clipping='+id_clipping);

}

function mostra_app_estado(classe,id)
{
	if(document.getElementById('mostra_app_estado_'+id).className === "mostra-app-estado-ativo")
	{
		document.getElementById('mostra_app_estado_'+id).className = "mostra-app-estado-inativo";
	}
	else
	{
		document.getElementById('mostra_app_estado_'+id).className = "mostra-app-estado-ativo";
	}

	if(document.getElementById('mostra_app_estado_'+id).innerHTML === "Mostrar no APP")
	{
		document.getElementById('mostra_app_estado_'+id).innerHTML = "Não mostrar no APP";
	}
	else
	{
		document.getElementById('mostra_app_estado_'+id).innerHTML = "Mostrar no APP";
	}
}

function controla_busca_aba(tipo)
{
	if(tipo == 'simples')
	{
		document.getElementById('busca-corpo-avancado').style.display = 'none';
		document.getElementById('busca-corpo-avancado').style.opacity = 0;
		document.getElementById('busca-avancada-aba').classList.remove('busca-avancada-aba-verde');
		document.getElementById('busca-avancada-aba').classList.add('busca-avancada-aba');

		document.getElementById('busca-corpo-simples').style.display = 'block';
		setTimeout("document.getElementById('busca-corpo-simples').style.opacity = 1",200);

		document.getElementById('busca-simples-aba').classList.add('busca-simples-aba-verde');

	}
	else
	{
		document.getElementById('busca-corpo-simples').style.display = 'none';
		document.getElementById('busca-corpo-simples').style.opacity = 0;
		document.getElementById('busca-simples-aba').classList.remove('busca-simples-aba-verde');
		document.getElementById('busca-simples-aba').classList.add('busca-simples-aba');

		document.getElementById('busca-corpo-avancado').style.display = 'block';
		setTimeout("document.getElementById('busca-corpo-avancado').style.opacity = 1",200);
		document.getElementById('busca-avancada-aba').className = 'busca-avancada-aba-verde';
	}
}

function esconde_busca_aba(tipo)
{
	if(tipo == 'simples')
	{
		document.getElementById('busca-corpo-avancado').style.display = 'none';
		document.getElementById('busca-corpo-simples').style.opacity = 1;
		document.getElementById('busca-corpo-simples').style.display = 'block';

		document.getElementById('busca-avancada-aba').classList.remove('busca-avancada-aba-verde');
		document.getElementById('busca-simples-aba').classList.add('busca-simples-aba-verde');
	}
	else
	{
		document.getElementById('busca-corpo-simples').style.display = 'none';
		document.getElementById('busca-corpo-avancado').style.opacity = 1;
		document.getElementById('busca-corpo-avancado').style.display = 'block';

		document.getElementById('busca-simples-aba').classList.remove('busca-simples-aba-verde');
		document.getElementById('busca-simples-aba').classList.add('busca-simples-aba');
		document.getElementById('busca-avancada-aba').className = 'busca-avancada-aba-verde';
	}
}


function compartilhar_clipping(campo_compartilhar,id_clipping)
{
	ajaxHTML('span_compartilhar','inc/busca_ajax.php?_id_clipping='+id_clipping+'&tipo=compartilhar_enviar&_compartilhar_email='+document.getElementById(campo_compartilhar).value);
}

function reportar(campo_reportar_erro)
{
	ajaxHTML('span_reportar','inc/busca_ajax.php?tipo=reportar_problemas_enviar&_reportar_msg='+document.getElementById(campo_reportar_erro).value);
}

function verifica_midia(check,id_clipping)
{
	if(document.getElementById('_id_midia_'+id_clipping).value == 29)
	{
		alert('Verificar: mídia Integrador.');
		document.getElementById(check).checked = false;
	}
}

function passa_valor_integrador(div,id_midia_categoria,id_midia,id_veiculo,id_clipping)
{
	ajaxHTML(div,'inc/busca_ajax.php?tipo=salva_midia_categoria_integrador&_id_midia_categoria='+ id_midia_categoria+'&_id_midia='+id_midia+'&_id_veiculo='+ id_veiculo+'&_id_clipping='+ id_clipping);
}

function forca_campo(tipo_midia)
{
	switch(tipo_midia)
	{
		case "23":
		case "8":
		case "28":
		case "4":
		case "24":
			document.getElementById("_dominio").required = true;
		break;
		default:
			document.getElementById("_dominio").required = false;
		break;
	}
}

function checar_todos_mesmo_nome() {
   var arrMarkMail = document.getElementsByName("txt_id_clippings[]");
   for (var i = 0; i < arrMarkMail.length; i++)
   {
	   if(arrMarkMail[i].checked == false)
	   {
     		arrMarkMail[i].checked = true;
	   }
	   else
	   {
		   arrMarkMail[i].checked = false;
	   }
   }
}

function muda_check(campo)
{
	if(document.getElementById(campo).className == "icone-01")
	{
		document.getElementById(campo).className = "icone-02";
	}
	else
	{
		document.getElementById(campo).className = "icone-01";
	}
}

function limpa_campo(campo)
{
	document.getElementById(campo).value = "";
}


	function valor_cor()
	{
		var r = document.getElementsByName('cmp_clipping_cor_tipo');
		var valor = "";
		for ( var i = 0; i < r.length; i++ )
		{
			if (r[i].checked)
			{
				valor = r[i].value;
			}
		}
		return valor;
	}

// Esta função instancia o objeto XMLHttpRequest
function openAjax()
{
	var ajax;
	try
	{
	ajax = new XMLHttpRequest();
	} catch(ee) {
	try {
	ajax = new ActiveXObject("Msxml2.XMLHTTP");
	} catch(e) {
	try {
	ajax = new ActiveXObject("Microsoft.XMLHTTP");
	} catch(E) {
	ajax = false;
	}
	}
	}
	return ajax;
}


//função que completa os campos
function busca_valor(input,id_veiculo,data_publicacao,cor_tipo,midia_id,centimetragem,endereco,id_clipping,atualiza_tabela_clipping)
{
	var ajax = openAjax();
	var campo = gE(input);

	ajax.open('GET',endereco+'inc/busca_ajax.php?_atualiza_tabela_clipping='+atualiza_tabela_clipping+'&_id_clipping='+id_clipping+'&_centimetragem='+centimetragem+'&_midia_id='+midia_id+'&_cor_tipo='+cor_tipo+'&_data_publicacao='+data_publicacao+'&tipo=calcula_valor_centimetragem&_id_veiculo='+id_veiculo,true);

	ajax.onreadystatechange=function()
	{
		if(ajax.readyState == 1)
		{
			campo.value = 'carregando...';
		}

		if(ajax.readyState == 4)
		{
			if(ajax.status == 200)
			{
				campo.value = ajax.responseText;
			}
		}
	}//ready
	ajax.send(null);
	return false;
}//função

function diferenca_segundos(comeco, fim)
{
	var resultado = 0;
    var total_segundos = function(value)
	{
		var t = value.length;

		if(t == 5)
		{
			value = value+":00";
		}

		var p1;
		var p2;
		var p3;

		p1 = parseInt(value.split(":")[0].toString());
		p2 = parseInt(value.split(":")[1].toString());
		p3 = parseInt(value.split(":")[2].toString());

        //var match = (/(\d{1,2}):(\d{1,2}):(\d{1,2})/g).exec(value);
		//var n1 = Number(match[1]);
		//var n2 = Number(match[2]);
		//var n3 = Number(match[3]);

        return ((p1 * 60)*60) + (p2 * 60) + p3;
    }
	resultado = (total_segundos(fim) - total_segundos(comeco));

    return resultado;
}

//função que completa os campos
function busca_valor_02(input,id_programa,data_publicacao,duracao,endereco,id_clipping)
{
	var ajax = openAjax();
	var campo = gE(input);

	ajax.open('GET',endereco+'inc/busca_ajax.php?_id_clipping='+id_clipping+'&_duracao='+duracao+'&_data_publicacao='+data_publicacao+'&tipo=calcula_valor_minutagem&_id_programa='+id_programa,true);

	ajax.onreadystatechange=function()
	{
		if(ajax.readyState == 1)
		{
			campo.value = 'carregando...';
		}

		if(ajax.readyState == 4)
		{
			if(ajax.status == 200)
			{
				campo.value = ajax.responseText;
			}
		}
	}//ready
	ajax.send(null);
	return false;
}//função

function manda_click(elemento)
{
	window.onload = function(){document.getElementById(elemento).click()}
}

function fecha(elemento)
{
	document.getElementById(elemento).style.display='none';
}

function formatar(src, mask){
  var i = src.value.length;
  var saida = mask.substring(0,1);
  var texto = mask.substring(i)
if (texto.substring(0,1) != saida)
  {
    src.value += texto.substring(0,1);
  }
}

//<![CDATA[

function avanca()
{
	var slidingDiv = document.getElementById("navegador");
	var stopPosition = 90;

	//if (parseInt(slidingDiv.style.left) < stopPosition )
	//{
		slidingDiv.style.left = parseInt(slidingDiv.style.left) + 60 + "px";
		//setTimeout(avanca, 1);
	//}
}

function recua()
{
	var slidingDiv = document.getElementById("navegador");
	var stopPosition = 0;

	//if (parseInt(slidingDiv.style.left) > stopPosition )
	//{
		slidingDiv.style.left = parseInt(slidingDiv.style.left) - 60 + "px";
		//setTimeout(recua, 1);
	//}
}

//]]>

function adiciona_editor()
{
	area = new nicEditor({fullPanel : true}).panelInstance('cmp_clipping_descricao');
}

function remove_editor()
{
	area.removeInstance('cmp_clipping_descricao');
}

	var tagAlvo = new Array('p');
	var tamanhos = new Array( '9px','11px','13px','15px','17px','19px' );
	var tamanhoInicial = 2;

	function mudaTamanho( idAlvo,acao )
	{
		if (!document.getElementById) return
			var selecionados = null,tamanho = tamanhoInicial,i,j,tagsAlvo;
			tamanho += acao;
			if ( tamanho < 0 ) tamanho = 0;
			if ( tamanho > 6 ) tamanho = 6;
			tamanhoInicial = tamanho;

			if ( !( selecionados = document.getElementById( idAlvo ) ) )
			selecionados = document.getElementsByTagName( idAlvo )[ 0 ];
			selecionados.style.fontSize = tamanhos[ tamanho ];

			for ( i = 0; i < tagAlvo.length; i++ )
			{
				tagsAlvo = selecionados.getElementsByTagName( tagAlvo[ i ] );
				for ( j = 0; j < tagsAlvo.length; j++ )
					tagsAlvo[ j ].style.fontSize = tamanhos[ tamanho ];
			}
	}

function desabilita()
{
	if(checa_campos('clipping'))
	{
		//document.getElementById('cmp_clipping_formatacao_02').click();
		//document.getElementById('cmp_clipping_formatacao_01').click();
		document.getElementById('btn_salvar').disabled = true;
		document.getElementById('btn_salvar').style.display = 'none';
		document.formulario.submit();

		//alert('botao desabilitado');

		return true;
	}
	else
	{
		//alert('para mas deixa botão habilitado');
		//document.getElementById('btn_salvar').disabled = true;
		return false;
	}
}


function muda_envio()
{
	if(document.formulario.cmp_midia_id[document.formulario.cmp_midia_id.selectedIndex].value == 26)
	{
		document.formulario._acao_upload.value = 'enviado_video_audio';
		document.formulario.pasta_destino.value = 'http://www.mogambo.com.br';
		//alert(document.formulario.pasta_destino.value);
	}
	else
	{
		document.formulario.pasta_destino.value = 'imagens/clippings';
		document.formulario._acao_upload.value = 'enviar_imagem';
	}
}


function detalhe_classificacao()
{

	var id_classificacao = document.formulario.cmp_classificacao_id[document.formulario.cmp_classificacao_id.selectedIndex].value;
	var id_pessoa = document.getElementById('cmp_pessoa_id').value;

	id_classificacao = id_classificacao.split("_");
	id_pessoa = id_pessoa.split("_");

	ajaxHTML('div_detalhe_classificacao','inc/busca_ajax.php?combo=1&quero=&tipo=detalhe_classificacao&id_classificacao='+ id_classificacao[0]+'&id_pessoa='+id_pessoa[0]);
}

function muda_texto(id)
{
	switch(id)
	{
		case '4':
		case '8':
		case '23':
			document.getElementById('cor_pagina_tipo').innerHTML = "Tipo de página";
			document.getElementById('colorido_home').innerHTML = "Home";
			document.getElementById('pb_dentro').innerHTML = "Interna";
		break;

		default:
			document.getElementById('cor_pagina_tipo').innerHTML = "Cor tipo";
			document.getElementById('colorido_home').innerHTML = "Colorido";
			document.getElementById('pb_dentro').innerHTML = "Preto e Branco";
		break;
	}
}

//selecionar multipos itens sem control

var arrOldValues;

function SelectAllList(CONTROL){
for(var i = 0;i < CONTROL.length;i++){
CONTROL.options[i].selected = true;
}
}

function DeselectAllList(CONTROL){
for(var i = 0;i < CONTROL.length;i++){
CONTROL.options[i].selected = false;
}
}

function FillListValues(CONTROL){
var arrNewValues;
var intNewPos;
var strTemp = GetSelectValues(CONTROL);
arrNewValues = strTemp.split(",");
for(var i=0;i<arrNewValues.length-1;i++){
if(arrNewValues[i]==1){
intNewPos = i;
}
}

for(var i=0;i<arrOldValues.length-1;i++){
if(arrOldValues[i]==1 && i != intNewPos){
CONTROL.options[i].selected= true;
} else if(arrOldValues[i]==0 && i != intNewPos){
CONTROL.options[i].selected= false;
}

if(arrOldValues[intNewPos]== 1){
CONTROL.options[intNewPos].selected = false;
} else {
CONTROL.options[intNewPos].selected = true;
}
}
}

function GetSelectValues(CONTROL){
var strTemp = "";
for(var i = 0;i < CONTROL.length;i++){
if(CONTROL.options[i].selected == true){
strTemp += "1,";
} else {
strTemp += "0,";
}
}
return strTemp;
}

function GetCurrentListValues(CONTROL){
var strValues = "";
strValues = GetSelectValues(CONTROL);
arrOldValues = strValues.split(",")
}

//termina selecionar multiplos itens csem control

function valida_check(formulario)
{
	var controle = 0;
	for (i=0;i<document.formulario.elements.length;i++)
	{
		if (document.formulario.elements[i].type == "radio")
		{
			if (document.formulario.elements[i].checked == true)
			{
			controle++;
			}
		}
	}

	if (controle <= 0)
	{
		alert("Selecione uma das opções");
		return false;
	}
}


function gera_nome()
{
	var currentTime = new Date();
	var month = currentTime.getMonth() + 1;
	var day = currentTime.getDate();
	var year = currentTime.getFullYear();

	var nome = document.getElementById('cmp_veiculo_id')[document.getElementById('cmp_veiculo_id').selectedIndex].text+'__'+document.formulario.cmp_clipping_data_publicacao.value;

	nome = nome.replace("&","e");
	nome = nome.replace(" ","_");
	nome = nome.replace("-","_");
	nome = nome.replace("Ã","a");
	nome = nome.replace("Á","a");
	nome = nome.replace("Â","a");
	nome = nome.replace("É","e");
	nome = nome.replace("Ê","e");
	nome = nome.replace("Ó","o");
	nome = nome.replace("Õ","o");
	nome = nome.replace("Ô","o");
	nome = nome.replace("Ú","u");
	nome = nome.replace("Û","u");
	nome = nome.replace("(","_");
	nome = nome.replace(")","_");

	return nome;
}

function randomico(min, max)
{
  return Math.floor(Math.random() * (max - min + 1) + min);
}

function trata_txto(entrada)
{

	saida = entrada.replace("Ã","a");
	saida = saida.replace("Á","a");
	saida = saida.replace("Â","a");

	saida = saida.replace("É","e");
	saida = saida.replace("Ê","e");

	saida = saida.replace("Í","i");
	saida = saida.replace("í","i");

	saida = saida.replace("Ó","o");
	saida = saida.replace("Õ","o");
	saida = saida.replace("Ô","o");

	saida = saida.replace("Ú","u");
	saida = saida.replace("Û","u");

	saida = saida.replace("Ç","c");
	saida = saida.replace("ç","c");

	saida = saida.replace(/[^a-zA-Z0-9]/g,'_');
	saida = saida.toLowerCase();
	return saida;
}

function gera_nome_02()
{
	//data
	var data = new Date().toISOString().slice(0,10);
	var nome = data+'_'+document.getElementById('cmp_pessoa_id')[document.getElementById('cmp_pessoa_id').selectedIndex].text+'_'+randomico(1,999);

	//randomico

	document.getElementById('_data_nome_cliente').value = trata_txto(nome);
}


/*
function tamanho_tela()
{
	var winl = (screen.width)
	var wint = (screen.height)

	pxHeight = window.document.body.clientHeight;
	pxWidth = window.document.body.clientWidth;

	tela = document.getElementById('corpo').offsetHeight;

	quero = screen.availHeight;

	document.getElementById('lista_clippings').style.height = (quero - 330)+"px";;
	//alert(quero);
}
*/

function clipping_acao_gerar_impresso(pessoa_id)
{

	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if (document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}

	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{
		window.open('utilitarios/clipping_impresso_gerar.php?acao=enviar_email','pop_impresso','width=800,height=500,location=yes,scrollbars=yes,resizable=yes');
		document.getElementById('acao').value='clipping_impresso';
		document.getElementById('formulario_resultados').target='pop_impresso';
		document.getElementById('formulario_resultados').action='utilitarios/clipping_impresso_gerar.php?acao=clipping_impresso&pessoa_id='+pessoa_id;
		document.getElementById('formulario_resultados').submit();
	}
}


function calculo_multiplo(pessoa_id)
{

	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if (document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}

	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{
		document.getElementById('acao').value='xxx';
		document.getElementById('formulario_resultados').target='_blank';
		document.getElementById('formulario_resultados').action='utilitarios/calculo_multiplo.php?_id_pessoa='+pessoa_id;
		document.getElementById('formulario_resultados').submit();
	}
}
function clipping_acao_gerar_xml(pessoa_id,data)
{

	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if (document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}

	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{
		window.open('utilitarios/gerar_xml.php','pop_evia_email','width=800,height=500,location=yes,scrollbars=yes,resizable=yes');
		document.getElementById('acao').value='gerar_xml';
		document.getElementById('formulario_resultados').target='pop_evia_email';
		document.getElementById('formulario_resultados').action='utilitarios/gerar_xml.php?pessoa_id='+pessoa_id+'&data='+data;
		document.getElementById('formulario_resultados').submit();
	}
}

function clipping_acao_gerar_xml_02(pessoa_id,data)
{

	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if (document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}

	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{
		window.open('utilitarios/gerar_xml_02.php','pop_evia_email','width=800,height=500,location=yes,scrollbars=yes,resizable=yes');
		document.getElementById('acao').value='gerar_xml';
		document.getElementById('formulario_resultados').target='pop_evia_email';
		document.getElementById('formulario_resultados').action='utilitarios/gerar_xml_02.php?pessoa_id='+pessoa_id+'&data='+data;
		document.getElementById('formulario_resultados').submit();
	}
}

function clipping_acao_imprimir(pessoa_id)
{

	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if (document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}

	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{
		document.getElementById('acao').value='enviar_email';
		document.getElementById('formulario_resultados').action='utilitarios/imprimir_clipping.php?pessoa_id='+pessoa_id;
		document.getElementById('formulario_resultados').submit();
	}
}

function clipping_acao_enviar_email_rs(pessoa_id,tipo)
{
	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if (document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}

	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{
		document.getElementById('acao').value='enviar_email';
		document.getElementById('formulario_resultados').target='_blank';
		document.getElementById('formulario_resultados').action='utilitarios/clipping_envio_rs.php?acao=enviar_email&_id_pessoa='+pessoa_id+'&_tipo='+tipo;
		document.getElementById('formulario_resultados').submit();
	}
}

/*
==========================================================================

==========================================================================
*/
function clipping_excluir_lote()
{
	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if (document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}

	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{
		document.getElementById('acao').value='excluir_lote';
		document.getElementById('formulario_resultados').target='_blank';
		document.getElementById('formulario_resultados').action='index.php?acao_adm=clipping_adm&acao=excluir_lote';
		document.getElementById('formulario_resultados').submit();
	}
}
http:
/*
==========================================================================

==========================================================================
*/
function clipping_acao_enviar_email(pessoa_id,tipo,avulso,acao)
{
	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if (document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}

	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{
		document.getElementById('acao').value=''+acao+'';
		document.getElementById('formulario_resultados').target='_blank';
		document.getElementById('formulario_resultados').action='utilitarios/clipping_envio.php?acao='+acao+'&_id_pessoa='+pessoa_id+'&_tipo='+tipo+'&_avulso='+avulso;
		document.getElementById('formulario_resultados').submit();
	}
}


/*
==========================================================================

==========================================================================
*/

function gerar_lista_clipping_url(id_pessoa)
{
	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if (document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}

	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{
		var lista_ids = '';
		var ids = document.getElementsByName('txt_id_clippings[]');
		for(var i = 0; i < ids.length; i++)
		{
			if(ids[i].checked)
			{
				lista_ids += ids[i].value+',';
			}
		}

		ajaxHTML('div_lista_clipping_url','inc/busca_ajax.php?tipo=lista_clipping_url&_lista_ids='+lista_ids+'&_id_pessoa='+id_pessoa);
	}
}

/*
==========================================================================

==========================================================================
*/

function recortador_lista(id_pessoa)
{
	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if (document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}

	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{
		document.getElementById('acao').value='enviar_email';
		document.getElementById('formulario_resultados').target='_blank';
		document.getElementById('formulario_resultados').action='utilitarios/recortador_lista.php?acao=enviar_email&_id_pessoa='+id_pessoa;
		document.getElementById('formulario_resultados').submit();

	}
}

/*
==========================================================================

==========================================================================
*/

function etiquetador(id_pessoa)
{
	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if (document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}

	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{
		document.getElementById('acao').value='enviar_email';
		document.getElementById('formulario_resultados').target='_blank';
		document.getElementById('formulario_resultados').action='utilitarios/etiqueta.php?_id_pessoa='+id_pessoa;
		document.getElementById('formulario_resultados').submit();

	}
}
/*
==========================================================================

==========================================================================
*/
function clipping_acao_gerar_pdf(pessoa_id)
{
	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if (document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}

	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{
		window.open('utilitarios/clipping_envio.php?acao=enviar_email','pop_gera_relatorio','width=800,height=500,location=yes,scrollbars=yes,resizable=yes');
		document.getElementById('acao').value='enviar_email';
		document.getElementById('formulario_resultados').target='pop_gera_relatorio';
		document.getElementById('formulario_resultados').action='utilitarios/clipping_envio.php?acao=enviar_email&pessoaId='+pessoa_id;
		document.getElementById('formulario_resultados').submit();
	}
}


function clipping_acao_excluir(pessoa_id)
{
	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if (document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}

	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{
		var r=confirm("Está certo que deseja deletar os itens selecionados?");
		if (r==true)
		{
		  	document.getElementById('acao').value='excluir';
			document.getElementById('formulario_resultados').action='index.php?acao=excluir&acao_adm=clipping_adm&pessoa_id='+pessoa_id;
			document.getElementById('formulario_resultados').submit();
		}
		else
		{
		  //alert("You pressed Cancel!");
		}
	}

}

function gerar_PDF(tipo,id_pessoa)
{
	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if(document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}
	if(controle>200)
	{
		alert("Você só pode gerar PDF de 200 clippings por vez. Você está selecionando: "+controle+" matérias.");
		return false;
	}
	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{
		if(tipo == 'imagem_texto')
		{
		document.getElementById('formulario_resultados').action="utilitarios/gerar_varios_pdf.php?_id_pessoa="+id_pessoa;
		}

		if(tipo == 'texto')
		{
		document.getElementById('formulario_resultados').action="utilitarios/gerar_varios_pdf_texto.php?_id_pessoa="+id_pessoa;
		}

		if(tipo == 'imagem')
		{
		document.getElementById('formulario_resultados').action="utilitarios/gerar_varios_pdf_imagem.php?_id_pessoa="+id_pessoa;
		}

		document.getElementById('formulario_resultados').submit();
	}

}

function gerar_word(){
	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if (document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}
	if(controle>200){
		alert("Você só pode gerar PDF de vinte clippings por vez.");
		return false;
	}
	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{

		document.getElementById('formulario_resultados').target='utilitarios/gerar_varios_word.php';
		document.getElementById('formulario_resultados').action="utilitarios/gerar_varios_word.php";
		document.getElementById('formulario_resultados').submit();
	}

}


function clipping_acao_gerar_cd(id_pessoa,data_inicial,data_final)
{
	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if (document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}

	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{
	document.getElementById('formulario_resultados').target='_blank';
	document.getElementById('formulario_resultados').method='post';
	document.getElementById('formulario_resultados').action='utilitarios/gerar_cd.php?id_pessoa='+id_pessoa+'&_data_inicial='+data_inicial+'&_data_final='+data_final;
	document.getElementById('formulario_resultados').submit();
	}
}

/*
function clipping_acao_gerar_cd_pdf()
{
	    var test = false;
    var objRadio = document.forms[1].elements['txt_id_clippings[]'];
    for(i=0; i < objRadio.length; i++ )
	{
        if (objRadio[i].checked == true) test = true;
    }

    if (test == false)
	{
		alert("Você deve marcar ao menos um dos clippings");
	}
	else
	{
	document.getElementById('formulario_resultados').target='_blank';
	document.getElementById('formulario_resultados').method='post';
	document.getElementById('formulario_resultados').action='utilitarios/gerar_cd_pdf.php';
	document.getElementById('formulario_resultados').submit();
	}
}
*/

function clipping_acao_gerar_word()
{
	window.open('modulos/clipping_gerar_documentos.php?acao=gerar_word','gerar_word','width=300,height=300,location=yes,resizable=yes');
	document.getElementById('acao').value='gerar_word';
	document.getElementById('formulario_resultados').target='gerar_word';
	document.getElementById('formulario_resultados').action='modulos/clipping_gerar_documentos.php?acao=gerar_word';
	document.getElementById('formulario_resultados').submit();
}



function selecionar_tudo(categoria)
{
   for (i=0;i<document.form_envia_email.elements.length;i++)
      if(document.form_envia_email.elements[i].type == "checkbox")
	  {
	  	if(document.form_envia_email.elements[i].name == categoria)
		{
		 	if(document.form_envia_email.elements[i].checked)
				document.form_envia_email.elements[i].checked=0
			else
				document.form_envia_email.elements[i].checked=1
	    }
	  }
}


function selecionar_tudo_mail(nome)
{
   for (i=0;i<document.formulario_envio_mensagem.elements.length;i++)
      if(document.formulario_envio_mensagem.elements[i].type == "checkbox")
	  {
	  	if(document.formulario_envio_mensagem.elements[i].name == nome)
		{
		 	if(document.formulario_envio_mensagem.elements[i].checked)
				document.formulario_envio_mensagem.elements[i].checked=0
			else
				document.formulario_envio_mensagem.elements[i].checked=1
	    }
	  }
}

function selecionar_tudo_02(formulario,nome_campo)
{
	for (var i = 1; i < 600; i++)
	{
		if (document.getElementById('txt_id_clippings_'+nome_campo+'_'+i))
		{
			if(document.getElementById('txt_id_clippings_'+nome_campo+'_'+i).checked == 1)
			{
				document.getElementById('txt_id_clippings_'+nome_campo+'_'+i).checked = 0;
			}
			else
			{
				document.getElementById('txt_id_clippings_'+nome_campo+'_'+i).checked = 1;
			}
		}
	}
}

function muda_noticia(arg,noticia,id){

	inicio = 0;
	if (arg == 'menos'){
		if ( Number(document.formulario.num_imagem.value) <= 0 )
		{
			document.formulario.num_imagem.value  = 0;
			inicio = 0;
		}
		else{
			document.formulario.num_imagem.value  = Number(document.formulario.num_imagem.value) - 1;
			inicio = Number(document.formulario.num_imagem.value);
		}
	}
	else // mais
	{
		document.formulario.num_imagem.value = Number(document.formulario.num_imagem.value) + 1;
		inicio = Number(document.formulario.num_imagem.value);
	}

	var noticia_pieces=noticia.split(',');
	retorno=  '';
	j = 0;

	for(i=inicio;i<noticia_pieces.length;i++){
		j = j + 1;
		retorno+=  '<IMG SRC="thumbs/'+noticia_pieces[i]+'" onclick=open_noticia(\''+ id +'\',\'' + noticia_pieces[i] + '\')';
		retorno+= ' border=0>&nbsp;&nbsp;';
		if (j >= 3)
			break;
	}

	document.getElementById('noticias_thumbs').innerHTML = retorno;
}

	function abre_fecha(n,menu)
	{
		var troca = (document.getElementsByName(menu)[n].style.display == 'inline')?1:0;
		for (x=0;x<document.getElementsByName(menu).length;x++)
		{
			document.getElementsByName(menu)[x].style.display = 'none';
		}
		document.getElementsByName(menu)[n].style.display = (troca)?'none':'inline';
	}


function mostra(valor)
{
	var valor = valor;
	document.getElementById(valor).style.display = '';
}

function esconde(valor)
{
	var valor = valor;
	document.getElementById(valor).style.display = 'none';
}

function mostra_esconde(valor)
{
	var valor = valor;

	if(document.getElementById(valor).style.display == 'none')
	{
		document.getElementById(valor).style.display = '';
	}
	else
	{
		document.getElementById(valor).style.display = 'none';
	};

}

function abre_fecha_ajax_02(div_id,endereco_ajax_01,endereco_ajax_02,objeto,titulo_01,titulo_02)
{
	if(document.getElementById(objeto).src == titulo_01)
	{
		document.getElementById(objeto).src = titulo_02;
		ajaxHTML(div_id,endereco_ajax_01);
	}
	else
	{
		document.getElementById(objeto).src = titulo_01;
		ajaxHTML(div_id,endereco_ajax_02);
	};
}

function abre_fecha_ajax(div_id,endereco_ajax_01,endereco_ajax_02,objeto,titulo_01,titulo_02)
{


	if(document.getElementById(objeto).value == titulo_01)
	{
		document.getElementById(objeto).value = titulo_02;
		ajaxHTML(div_id,endereco_ajax_01);

	}
	else
	{
		document.getElementById(objeto).value = titulo_01;
		ajaxHTML(div_id,endereco_ajax_02);

	};

}

function controla_colunas()
{
	//fecha aba esquerda
	if(document.getElementById("mostra_esconde").value == "esconder")
	{
	document.getElementById("formulario").style.display = 'none'
	document.getElementById("div02").style.marginLeft = 20 + "px" ;
	document.getElementById("mostra_esconde").value = "mostrar";
	}
	else
	{
	document.getElementById("formulario").style.display = ''
	document.getElementById("div02").style.marginLeft = 300 + "px";
	document.getElementById("mostra_esconde").value = "esconder";
	}
}

function controla_coluna_direita()
{
	//fecha aba esquerda
	if(document.getElementById("mostra_esconde_02").value == "esconder")
	{
	//document.getElementById("formulario").style.width = 80;
	document.getElementById("noticias").style.display = 'none'
	document.getElementById("div02").style.marginRight = 20 + "px" ;
	document.getElementById("mostra_esconde_02").value = "mostrar";
	}
	else
	{
	//document.getElementById("formulario").style.width = 240;
	document.getElementById("noticias").style.display = ''
	document.getElementById("div02").style.marginRight = 170 + "px";
	document.getElementById("mostra_esconde_02").value = "esconder";
	}
}

function mostra_esconde_muda_titulo(objeto_01,objeto_02,titulo_01,titulo_02)
{
	if(document.getElementById(objeto_02).value == titulo_01)
	{
		document.getElementById(objeto_02).value = titulo_02;
	}
	else
	{
		document.getElementById(objeto_02).value = titulo_01;
	};


	if(document.getElementById(objeto_01).style.display == 'none')
	{
		document.getElementById(objeto_01).style.display = '';
	}
	else
	{
		document.getElementById(objeto_01).style.display = 'none';
	};
}

//carrega combos

function mostra_clipping(id,clip,tipo,id_clipping)
{
	switch(tipo)
	{
		case "audio":
			ajaxHTML('div_clips','inc/busca_ajax.php?tipo=mostra_clipping_audio&parametro='+ clip);
		break;

		case "video":
			ajaxHTML('div_clips','inc/busca_ajax.php?tipo=mostra_clipping_video&parametro='+ clip);
		break;

		default:
			ajaxHTML('div_clips','inc/busca_ajax.php?id_clipping='+id_clipping+'&id_imagem='+id+'&tipo=mostra_clipping_img&parametro='+ clip);
		break;
	}
}

//apenas carrega ajax vazio
function ajax_vazio(div)
{
ajaxHTML(div,'inc/busca_ajax.php');
}

//carrega combos

function carrega_editoria_coluna_jornalista(campo)
{

objeto = eval("document.formulario."+campo);

ajaxHTML('div_editoria','inc/busca_ajax.php?combo=1&tipo=editoria&parametro='+ objeto.options[objeto.selectedIndex].value);

//ajaxHTML('div_coluna','inc/busca_ajax.php?combo=1&tipo=coluna&parametro='+ objeto.options[objeto.selectedIndex].value);

//ajaxHTML('div_jornalista','inc/busca_ajax.php?combo=1&tipo=jornalista&parametro='+ objeto.options[objeto.selectedIndex].value);

}

function carrega_programa(tipo_midia,campo,layout)
{
	objeto = eval("document.formulario."+campo);
	ajaxHTML('div_editoria','inc/busca_ajax.php?tipo_midia='+tipo_midia+'&layout='+layout+'&combo=1&tipo=editoria&parametro='+ objeto.options[objeto.selectedIndex].value);
}

function carrega_combo(tipo,campo,quero,div,monta_combo,layout,tipo_midia)
{
	objeto = eval("document.formulario."+campo);
	ajaxHTML(div,'inc/busca_ajax.php?tipo_midia='+tipo_midia+'&layout='+layout+'&combo='+monta_combo+'&quero='+quero+'&tipo='+tipo+'&parametro='+ objeto.options[objeto.selectedIndex].value);
}

function carrega_combo_02(tipo,campo,quero,div,formulario)
{
	objeto = eval("document."+formulario+"."+campo);
	ajaxHTML(div,'inc/busca_ajax.php?quero='+quero+'&tipo='+tipo+'&parametro='+ objeto.options[objeto.selectedIndex].value);
}


function checkaTodos(formulario,algumAlterado)
{
f = document.getElementById(formulario);
if (algumAlterado)
{
if (algumAlterado.checked == false)
	f.br.checked = false;
}

else

for (i=0; i<f.length; i++)

if (f.elements[i].type == "checkbox")

if (f.br.checked) f.elements[i].checked = true

else f.elements[i].checked = false

}

function checa_todos(formulario)
{
f = document.getElementById(formulario);

	for (i=0; i<f.length; i++)
	{
		if (f.elements[i].type == "checkbox")
		{
			if(f.elements[i].checked == true)
			{
				f.elements[i].checked = false;
			}
			else
			{
				f.elements[i].checked = true;
			}
		}
	}
}

function checa_todos_02(formulario)
{
f = document.getElementById(formulario);

	for (i=0; i<f.length; i++)
	{
		if (f.elements[i].type == "checkbox")
		{
			if(f.elements[i].checked == true)
			{
				f.elements[i].checked = false;
				f.elements[i].onchange();
			}
			else
			{
				f.elements[i].checked = true;
				f.elements[i].onchange();
				//document.getElementById("test").onchange()
			}
		}
	}
}

function adiciona_classificacao(limpa)
{
	var cadena_ids;
	if(valida_txt("_id_classificacao","Classificação para este Clipping"))
	{
		classificacao_id = document.formulario._id_classificacao.value.split('_');
		if(document.formulario.cpm_lista_classificacao.value == '')
		{
			document.formulario.cpm_lista_classificacao.value = classificacao_id[1];
			document.formulario.cpm_lista_classificacao_ids.value = classificacao_id[0];
		}
		else
		{
			document.formulario.cpm_lista_classificacao.value = document.formulario.cpm_lista_classificacao.value + "," + classificacao_id[1];
			document.formulario.cpm_lista_classificacao_ids.value = document.formulario.cpm_lista_classificacao_ids.value + "," + classificacao_id[0];
		}
	}
	if(limpa == "sim")
	{
		//alert('excluye');
		document.formulario._id_classificacao.value = "";
	}
	monta_lista_classificacao();
}

function monta_lista_classificacao()
{
	arr1=document.formulario.cpm_lista_classificacao.value.split(",");
	retorno='';
	if(arr1[0] != '' )
	{
		retorno+='';
		for(i=0;i<arr1.length;i++)
		{
			retorno += '<input title="Excluir" type="button" name="'+i+'" value="&times; '+arr1[i]+'" class="btn_mini" onclick="deleta_classificacao(this)">';
			retorno += '';
		}
	}
	document.getElementById('div_lista_classificacaos').innerHTML=retorno;
}

function deleta_classificacao(obj){

	//número do objeto a ser excluido
	numero_objeto = obj.name;

	//cria array com itens listados no campo hidden
	array_itens = document.formulario.cpm_lista_classificacao.value.split(",");

	//retiva o item selecionado
	array_itens.splice(numero_objeto,1);

	//monta novamente a lista de classificações e pessoas para o hidden
	document.formulario.cpm_lista_classificacao.value = array_itens.toString();

	//monta novamente a lista de classificações e pessoas
	monta_lista_classificacao();
}

// Adiciona item no formulário clipping no campo pessoa

function adiciona_pessoa(limpa)
{
	if(valida_txt("cmp_classificacao_id","Classificação para este Clipping")&&valida_txt("cmp_pessoa_id","Pessoa que deseja visualizar o Clipping") )
	{
		classificacao_id = document.formulario.cmp_classificacao_id.value.split('_');
		pessoa_id = document.formulario.cmp_pessoa_id.value.split('_');

		if (document.formulario.cpm_lista_pessoa_classificacao.value == '')
		{
			document.formulario.cpm_lista_pessoa_classificacao.value = classificacao_id[1]+'__'+classificacao_id[0]+'';
		}
		else
		{
			document.formulario.cpm_lista_pessoa_classificacao.value = document.formulario.cpm_lista_pessoa_classificacao.value + "," + classificacao_id[1]+'__'+classificacao_id[0]+'';
		}
	}
	if(limpa == "sim")
	{
		document.formulario.cmp_classificacao_id.value = "";
		document.formulario.cmp_pessoa_id.value = "";
	}
	monta_lista_pessoa_classificacao();
}

// Recupera as informações dos campos escondidos e monta tabela para visualização

function monta_lista_pessoa_classificacao()
{
	arr1=document.formulario.cpm_lista_pessoa_classificacao.value.split(",");
	retorno='';
	if(arr1[0] != '' )
	{
		retorno+='<br>Classificações já inclusas:<br><br>';
		for(i=0;i<arr1.length;i++)
		{
			retorno+='<input type="button" name="'+i+'" value="deletar" class="btn_mini" onclick="deleta_pessoa_classificacao(this)"> ';
			retorno+=arr1[i]+'<br>';
		}
	}
	document.getElementById('div_lista_classificacao_pessoa').innerHTML=retorno;
}


// Recupera as informações dos campos escondidos para eliminar o elemento escolhido
function deleta_pessoa_classificacao(obj)
{
	//número do objeto a ser excluido
	numero_objeto = obj.name;

	//cria array com itens listados no campo hidden
	array_itens = document.formulario.cpm_lista_pessoa_classificacao.value.split(",");

	//retiva o item selecionado
	array_itens.splice(numero_objeto,1);

	//monta novamente a lista de classificações e pessoas para o hidden
	document.formulario.cpm_lista_pessoa_classificacao.value = array_itens.toString();

	//monta novamente a lista de classificações e pessoas
	monta_lista_pessoa_classificacao();
}

// Recupera as informações dos campos escondidos para eliminar o elemento escolhido
function deleta_pessoa_classificacao_todos()
{
	//limpa
	document.formulario.cpm_lista_pessoa_classificacao.value = "";
	document.getElementById('div_lista_classificacao_pessoa').innerHTML="";
}


// Valida Campo Text

function valida_txt(campo,msg){

	obj=eval("document.formulario."+campo);


	if(obj.value!="")
	{
		return true;
	}

	if(msg!='')
	{
		alert("O campo '"+msg+"' é obrigatório.");
	}

	obj.focus();
	return false;

}


// Carrega Formulário pessoa

function load_clipping_alteracao(veiculo,veiculo_id,editoria,editoria_id,coluna,jornalista){


	retorno='';

	retorno+='<select name="cmp_veiculo_id" size=1>';

	retorno+='<option value=""></option>';

	retorno+='<option value="';

	retorno+=veiculo_id;

	retorno+='" selected>';

	retorno+=veiculo;

	retorno+='</option>';

	retorno+='</select>';

	document.getElementById('div_veiculo').innerHTML = retorno;



	retorno='';

	retorno+='<select name="cmp_editoria_id" size=1>';

	retorno+='<option value="">Selecione...</option>';

	retorno+='<option value="';

	retorno+=editoria_id;

	retorno+='" selected>';

	retorno+=editoria;

	retorno+='</option>';

	retorno+='</select>';



	retorno+='<br>';



	retorno+='<select name="cmp_coluna_id" size=1>';

	retorno+='<option value="">Selecione...</option>';

	retorno+='<option value="';

	retorno+=coluna;

	retorno+='" selected>';

	retorno+=coluna;

	retorno+='</option>';

	retorno+='</select>';



	retorno+='<br>';



	retorno+='<select name="cmp_jornalista_id" size=1>';

	retorno+='<option value="">Selecione...</option>';

	retorno+='<option value="';

	retorno+=jornalista;

	retorno+='" selected>';

	retorno+=jornalista;

	retorno+='</option>';

	retorno+='</select>';





	document.getElementById('div_editoria').innerHTML = retorno;



}





// carrega combo de cidades//

function carrega_cidades(tipo,campo,div){



	obj=eval("document.formulario."+campo);

	parametro = obj.options[obj.selectedIndex].value;



	//chama função ajax que varregará resultados na página

	ajax('inc/busca_ajax.php?tipo='+tipo+'&parametro='+parametro, div );

}



// carrega combo de cidades edita

function carrega_cidades_02(tipo,uf,div,quero){

	//chama função ajax que varregará resultados na página

	ajax('inc/busca_ajax.php?quero='+quero+'&tipo='+tipo+'&parametro='+uf, div );

}

// Adiciona item no formulário clipping no campo
function addItem()
{
	if (document.formulario.hidden_cmp_clipping_imagem_nome.value == '')
	{
		document.formulario.hidden_cmp_clipping_imagem_nome.value = document.formulario.cmp_clipping_imagem_nome.value;
	}
	else
	{
		document.formulario.hidden_cmp_clipping_imagem_nome.value = document.formulario.hidden_cmp_clipping_imagem_nome.value + "," + document.formulario.cmp_clipping_imagem_nome.value;
	}
	document.formulario.cmp_clipping_imagem_nome.value = "";
	montaItem();
}

// Recupera as informações dos campos escondidos e monta tabela apenas para visualização
function montaItem(){

	arr1 = document.formulario.hidden_cmp_clipping_imagem_nome.value.split(",");

	retorno='';

	if(arr1[0] != '')
	{
		retorno+='<fieldset>';
		retorno+='<legend>Itens(ns) já incluso(s)</legend>';

		for(i=0;i<arr1.length;i++)
		{
			retorno+='<input title="excluir" type="button" name=xxItem'+i+' value=" x " class="botao_input" onclick="xxItem(this)"> ';
			retorno+=arr1[i];
			retorno+='  <br>';
		}
		retorno+='</fieldset>';
	}
	document.getElementById('divItem').innerHTML=retorno;
}

// Recupera as informações dos campos escondidos para eliminar o elemento escolhido

function xxItem(obj)
{
	//número do objeto a ser excluido
	numero_objeto = obj.name;

	//cria array com itens listados no campo hidden
	array_itens = document.formulario.hidden_cmp_clipping_imagem_nome.value.split(",");

	//retiva o item selecionado
	array_itens.splice(numero_objeto,1);

	//monta novamente a lista de classificações e pessoas para o hidden
	document.formulario.hidden_cmp_clipping_imagem_nome.value = array_itens.toString();

	//monta novamente a lista de classificações e pessoas
	montaItem();
}

// -- COMBO CALENDÁRIO

// construindo o calendário

function popdate(obj,div,tam,ddd)
{
    if (ddd)
    {
        day = ""
        mmonth = ""
        ano = ""
        c = 1
        char = ""
        for (s=0;s<parseInt(ddd.length);s++)
        {
            char = ddd.substr(s,1)
            if (char == "-")
            {
                c++;
                s++;
                char = ddd.substr(s,1);
            }
//            if (c==1) day    += char
//            if (c==2) mmonth += char
//            if (c==3) ano    += char
            if (c==1) ano    += char
            if (c==2) mmonth += char
            if (c==3) day    += char
		}
        ddd = mmonth + "/" + day + "/" + ano
    }

    if(!ddd) {today = new Date()} else {today = new Date(ddd)}
    date_Form = eval (obj)
    if (date_Form.value == "") { date_Form = new Date()} else {date_Form = new Date(date_Form.value)}

    ano = today.getFullYear();
    mmonth = today.getMonth ();
    day = today.toString ().substr (8,2)

    umonth = new Array ("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro")

    days_Feb = (!(ano % 4) ? 29 : 28)

    days = new Array (31, days_Feb, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31)


    if ((mmonth < 0) || (mmonth > 11))  alert(mmonth)

    if ((mmonth - 1) == -1) {month_prior = 11; year_prior = ano - 1} else {month_prior = mmonth - 1; year_prior = ano}

    if ((mmonth + 1) == 12) {month_next  = 0;  year_next  = ano + 1} else {month_next  = mmonth + 1; year_next  = ano}

    txt  = "<table class='calendario' cellspacing='0' cellpadding='3' border='0' width='"+tam+"' height='"+tam*1.1 +"'>"

    txt += "<tr><td colspan='7'><table class='calendario_navega' border='0' cellpadding='0' width='100%'><tr>"


    txt += "<td><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+((ano-1).toString()+"-"+(mmonth+1).toString() +"-01")+"')  title='Ano Anterior'><<</a></td>"

    txt += "<td><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+(year_prior.toString()+"-"+(month_prior+1).toString())+"-01"+"') title='Mês Anterior'><</a></td>"

    txt += "<td><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+( year_next.toString()+"-"+(month_next+1).toString()+"-01")+"')  title='Próximo Mês'>></a></td>"

    txt += "<td><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+((ano+1).toString())+"-"+(mmonth+1).toString() +"-01"+"')  title='Próximo Ano'>>></a></td>"

	txt += "<td><a href=javascript:force_close('"+div+"') title='Fechar Calendário'><b>x</b></a></td></tr></table></td></tr>"

    txt += "<tr><td colspan='7' class='mes'><span class='mes'>" + ano.toString() + "</span>"

    txt += " <span class='mes'>" + umonth[mmonth] + "</span> <div id='popd' style='position:absolute'></div></td></tr>"

	txt += "<tr class='dia'><td><b>Dom</b></td><td><b>Seg</b></td><td><b>Ter</b></td><td><b>Qua</b></td><td><b>Qui</b></td><td><b>Sex<b></td><td><b>Sab</b></td></tr>"

    today1 = new Date((mmonth+1).toString() +"/01/"+ano.toString());
    diainicio = today1.getDay() + 1;

    week = d = 1;
    start = false;

    for (n=1;n<= 42;n++)
    {
        if (week == 1)
		{
			txt += "<tr class='dias'>";
		}

        if (week == diainicio)
		{
			start = true;
		}

        if (d > days[mmonth])
		{
			start = false;
		}

        if(start)
        {
            dat = new Date((mmonth+1).toString() + "/" + d + "/" + ano.toString());
            day_dat   = dat.toString().substr(0,10);
            day_today  = date_Form.toString().substr(0,10);
            year_dat  = dat.getFullYear ();
            year_today = date_Form.getFullYear ();
            colorcell = ((day_dat == day_today) && (year_dat == year_today) ? " bgcolor='#000000' " : "" );

            txt += "<td"+colorcell+" align='center'><a href=javascript:block('"+  ano.toString() + "-" + (mmonth+1).toString() + "-" + d +"','"+ obj +"','" + div +"') class='data'>"+ d.toString() + "</a></td>";
  			d ++
        }
        else
        {
            txt += "<td class='data' align=center> </td>";
        }

        week ++

        if (week == 8)
        {
            week = 1; txt += "</tr>"}
        }

        txt += "</table>"

		document.getElementById(div).innerHTML = txt

}



// função para exibir a janela com os meses

function pop_month(obj, div, tam, ano)
{

  txt  = "<table bgcolor='#DEEAE6' border='0' width=80>"

  for (n = 0; n < 12; n++) { txt += "<tr><td align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+("01-" + (n+1).toString() + "-" + ano.toString())+"')>" + umonth[n] +"</a></td></tr>" }

  txt += "</table>"

  popd.innerHTML = txt

}

// função para exibir a janela com os anos
function pop_year(obj, div, tam, umonth)
{
  txt  = "<table bgcolor='#DEEAE6' border='0' width=160>";
  l = 1;

	for (n=1991; n<2012; n++)
	{
		if (l == 1)
		 txt += "<tr>";

		 txt += "<td align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+(umonth.toString () +"-01-" + n) +"')>" + n + "</a></td>";

		 l++;

		if (l == 4);
        {
			txt += "</tr>"; l = 1;
		}
  }

  txt += "</tr></table>"

  popd.innerHTML = txt
}

// função para fechar o calendário

function force_close(div)
{
	//div2 = eval (div);
	//div2.innerHTML = '';
	document.getElementById(div).innerHTML = '' ;
}

// função para fechar o calendário e setar a data no campo de data associado
function block(data, obj, div)
{
    force_close (div)
    obj2 = eval(obj)
    obj2.value = data
}


///=======================================



function MM_jumpMenu(targ,selObj,restore)
{ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

////////////////////////

function confirma(pagina_deleta,registro)
{
	if (confirm("Tem certeza de que deseja deletar :\n"+registro+" ?"))
	{
		location.href = pagina_deleta;
	}
}

function confirma_status(destino,registro)
{
	if (confirm("Tem certeza de que deseja alterar status de :\n"+registro+" ?"))
	{
		location.href = destino;
	}
}



function confirmar(mensagem)
{
	var agree=confirm(mensagem);
	if (agree)
	{
		return true ;
	}
	else
	{
		return false ;
	}
}



function abre_janela(theURL,winName,features)
{
	window.open(theURL,winName,features);
}



// verificar a função -----------------------------------------------------------------

function confirma_inserir(pagina_insere,registro_01,registro_02)

{

if (confirm("Tem certeza de que os dados a seguir estão corretos :\n"+registro_01+" ?"))

    location.href = pagina_insere;

}



//



function addBookmark(){

if (window.external)

external.AddFavorite('http://www.atw.com/painel/logar.php','Atende Web - Painel de Controle')

else

alert("Seu navegador não suporta este aplicativo, favor adicionar manualmente.");

}

/////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////// validação de campos ////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////


function checa_campos(pagina)
{
var mensagem_erro = new String();


switch(pagina)
{
	case "clipping":

	if(sem_conteudo(document.formulario.cpm_lista_pessoa_classificacao.value)){ mensagem_erro += "\n\n- Por escolha ao menos uma classificação e um pessoa para este clipping."; }
	if(WithoutSelectionValue(document.formulario.cmp_midia_id)){ mensagem_erro += "\n\n- Por favor escolha uma Mídia."; }

	//if(NoneWithCheck(document.form.radioOne)){ mensagem_erro += "\n\nPlease click one radio button of the set of three."; }
	//if(NoneWithCheck(document.formulario.cmp_clipping_cor_tipo)){ mensagem_erro += "\n\n- Por favor escolha se é colorido ou branco e preto/home ou interna."; }

	//if(NoneWithCheck(document.formulario.cmp_clipping_tipo_midia)){ mensagem_erro += "\n\n- Por favor escolha o tipo de mídia."; }

	//if(NoneWithCheck(document.form.checkOne)){ mensagem_erro += "\n\nPlease check one or more check boxes of the set of three."; }
	//if(WithoutCheck(document.formulario.aceito_contrato)){ mensagem_erro += "\n\n- O campo \"Privacidade\" deve estar marcado."; }
	//verifica se campo existe
	if(document.formulario.cmp_midia_categoria_id)
	{
		if(WithoutSelectionValue(document.formulario.cmp_midia_categoria_id))
		{
			mensagem_erro += "\n\n- Por favor escolha uma sub-mídia.";
		}
	}
	else
	{
		mensagem_erro += "\n\n- Por favor escolha um valor no campo Mídia para que possa ser mostrado o campo Sub-mídia.";
	}

	//verifica se campo existe
	if(document.formulario.cmp_veiculo_id)
	{
		if(WithoutSelectionValue(document.formulario.cmp_veiculo_id)){ mensagem_erro += "\n\n- Por favor escolha um Veículo."; }
	}
	else
	{
		mensagem_erro += "\n\n- Por favor escolha um valor no campo Mídia para que possa ser mostrado o campo Veículos.";
	}

	//editoria
	if(document.formulario.cmp_editoria_id)
	{
	if(WithoutSelectionValue(document.formulario.cmp_editoria_id)){ mensagem_erro += "\n\n- Por favor escolha uma Editoria."; }
	}
	else
	{
	mensagem_erro += "\n\n- Por favor escolha um valor no campo Veículo para que possa ser mostrado o campo Editoria.";
	}
	//coluna
	// jornalista

	if(sem_conteudo(document.formulario.cmp_clipping_pagina.value))    { mensagem_erro += "\n\n- Por favor digite a página."; }
	if(sem_conteudo(document.formulario.cmp_clipping_data_publicacao.value))    { mensagem_erro += "\n\n- Por favor digite a data de publicação."; }
	if(sem_conteudo(document.formulario.cmp_clipping_data_materia.value))    { mensagem_erro += "\n\n- Por favor digite a data de inserção."; }
	if(NoneWithCheck(document.formulario.cmp_clipping_status)){ mensagem_erro += "\n\n- Por Favor escolha o Status Inativo."; }

	//if(sem_conteudo(document.formulario.usuario_cidade.value)){ mensagem_erro += "\n\n- Por favor digite sua cidade."; }

	//if(sem_conteudo(document.formulario.usuario_telefone.value))    { mensagem_erro += "\n\n- Por favor digite seu telefone."; }

	//if(sem_conteudo(document.formulario.usuario_senha.value)){ mensagem_erro += "\n\n- Por favor digite uma senha."; }

	//if(ChecaSenha(document.formulario.usuario_senha.value,document.form.usuario_senha_re.value)){ mensagem_erro += "\n\n- Por favor confirme sua senha corretamente."; }

	//if(cpf_cnpj(document.form.usuario_senha.value)){ mensagem_erro += "\n\n- Por favor digite uma senha."; }
	//if(NoneWithContent(document.exampleform.oneOrTheOther)){ mensagem_erro += "\n\nSomething must be he set of form text fields."; }
	//if(sem_conteudo(document.form.usuario_.value)){ mensagem_erro += "\n\n- Digite a descrição de sua máquina."; }
	//if(sem_conteudo(document.exampleform.FileGet.value)){ mensagem_erro += "\n\nA file name must be provided for uploading."; }
	//if(WithoutSelectionValue(document.form.maquina_comissao)){ mensagem_erro += "\n\n- Por favor, se pretende dar uma comissão."; }

 break;


	case "clipping_rtv":

	if(sem_conteudo(document.formulario.cpm_lista_pessoa_classificacao.value)){ mensagem_erro += "\n\n- Por escolha ao menos uma classificação e um pessoa para este clipping."; }

	//verifica se campo existe
	if(document.formulario.cmp_midia_categoria_id)
	{
		if(WithoutSelectionValue(document.formulario.cmp_midia_categoria_id))
		{
			mensagem_erro += "\n\n- Por favor escolha uma sub-mídia.";
		}
	}
	else
	{
		mensagem_erro += "\n\n- Por favor escolha um valor no campo Mídia para que possa ser mostrado o campo Sub-mídia.";
	}

	//verifica se campo existe
	if(document.formulario.cmp_veiculo_id)
	{
		if(WithoutSelectionValue(document.formulario.cmp_veiculo_id)){ mensagem_erro += "\n\n- Por favor escolha uma Emissora."; }
	}
	else
	{
		mensagem_erro += "\n\n- Por favor escolha um valor no campo Mídia para que possa ser mostrado o campo Emissora.";
	}

	//editoria
	if(document.formulario.cmp_editoria_id)
	{
	if(WithoutSelectionValue(document.formulario.cmp_editoria_id)){ mensagem_erro += "\n\n- Por favor escolha um Programa."; }
	}
	else
	{
	mensagem_erro += "\n\n- Por favor escolha um valor no campo Emissora para que possa ser mostrado o campo Programa.";
	}


 break;


case "coluna":

//if(NoneWithCheck(document.form.radioOne))
//    { mensagem_erro += "\n\nPlease click one radio button of the set of three."; }
//if(WithoutCheck(document.form.radioLoner))
//    { mensagem_erro += "\n\nThe \"Loner\" radio button must be clicked."; }
//if(NoneWithCheck(document.form.checkOne))
//    { mensagem_erro += "\n\nPlease check one or more check boxes of the set of three."; }
//if(WithoutCheck(document.formulario.aceito_contrato)){ mensagem_erro += "\n\n- O campo \"Privacidade\" deve estar marcado."; }

//verifica se campo existe
if(document.formulario.cmp_veiculo_id)
{
	if(WithoutSelectionValue(document.formulario.cmp_veiculo_id)){ mensagem_erro += "\n\n- Por favor escolha um Veículo."; }
}
else
{
	mensagem_erro += "\n\n- Por favor escolha um valor no campo Mídia para que possa ser mostrado o campo Veículos.";
}

if(sem_conteudo(document.formulario.cmp_coluna_nome.value)){ mensagem_erro += "\n\n- Por favor digite seu nome."; }
//if(sem_conteudo(document.formulario.usuario_email.value))    { mensagem_erro += "\n\n- Por favor digite seu email."; }
//if(sem_conteudo(document.formulario.usuario_endereco.value))    { mensagem_erro += "\n\n- Por favor digite seu endereço."; }
//if(sem_conteudo(document.formulario.usuario_numero.value))    { mensagem_erro += "\n\n- Por favor número."; }
//if(sem_conteudo(document.formulario.usuario_cep.value))    { mensagem_erro += "\n\n- Por favor digite o seu cep."; }
//if(sem_conteudo(document.formulario.usuario_cidade.value)){ mensagem_erro += "\n\n- Por favor digite sua cidade."; }
//if(sem_conteudo(document.formulario.usuario_telefone.value))    { mensagem_erro += "\n\n- Por favor digite seu telefone."; }
//if(sem_conteudo(document.formulario.usuario_senha.value)){ mensagem_erro += "\n\n- Por favor digite uma senha."; }
//if(ChecaSenha(document.formulario.usuario_senha.value,document.form.usuario_senha_re.value)){ mensagem_erro += "\n\n- Por favor confirme sua senha corretamente."; }

//if(cpf_cnpj(document.form.usuario_senha.value)){ mensagem_erro += "\n\n- Por favor digite uma senha."; }
//if(NoneWithContent(document.exampleform.oneOrTheOther)){ mensagem_erro += "\n\nSomething must be he set of form text fields."; }
//if(sem_conteudo(document.form.usuario_.value)){ mensagem_erro += "\n\n- Digite a descrição de sua máquina."; }
//if(sem_conteudo(document.exampleform.FileGet.value)){ mensagem_erro += "\n\nA file name must be provided for uploading."; }
//if(WithoutSelectionValue(document.form.maquina_comissao)){ mensagem_erro += "\n\n- Por favor, se pretende dar uma comissão."; }
break;

//-----------------------------------------------------------------
case "grupo_emails":

if(sem_conteudo(document.formulario.cmp_pessoa_email_grupo_nome.value)){ mensagem_erro += "\n\n- Por favor digite o nome do grupo."; }
if(sem_conteudo(document.formulario.cmp_pessoa_id.value)){ mensagem_erro += "\n\n- Por favor escolha uma pessoa."; }
break;

//-----------------------------------------------------------------
case "controle_clipping":
//verifica se campo existe
if(sem_conteudo(document.formulario._id_veiculo.value)){ mensagem_erro += "\n\n- Por favor escolha um veículo."; }
if(sem_conteudo(document.formulario.cmp_pessoa_id.value)){ mensagem_erro += "\n\n- Por favor escolha um representante."; }
if(sem_conteudo(document.formulario.cmp_usuario_id.value)){ mensagem_erro += "\n\n- Por favor escolha um usuário."; }
if(WithoutSelectionValue(document.formulario._hora_recebimento)){ mensagem_erro += "\n\n- Por favor escolha um horário de recebimento."; }
if(WithoutSelectionValue(document.formulario._id_periodo)){ mensagem_erro += "\n\n- Por favor escolha um período de recebimento."; }
if(WithoutSelectionValue(document.formulario._id_estado)){ mensagem_erro += "\n\n- Por favor escolha um status."; }
break;

//-----------------------------------------------------------------
case "ambiente":
//verifica se campo existe
if(sem_conteudo(document.formulario.cmp_ambiente_nome.value)){ mensagem_erro += "\n\n- Por favor digite o nome do ambiente."; }
break;
//-----------------------------------------------------------------

case "permissoes":
//verifica se campo existe
if(sem_conteudo(document.formulario.cmp_usuario_id.value)){ mensagem_erro += "\n\n- Por favor digite o nome do ambiente."; }
break;

//-----------------------------------------------------------------

case "editoria":

//verifica se campo existe

if(document.formulario.cmp_veiculo_id)

{

if(WithoutSelectionValue(document.formulario.cmp_veiculo_id)){ mensagem_erro += "\n\n- Por favor escolha um Veículo."; }
}
else
{
mensagem_erro += "\n\n- Por favor escolha um valor no campo Mídia para que possa ser mostrado o campo Veículos.";
}

if(sem_conteudo(document.formulario.cmp_editoria_nome.value)){ mensagem_erro += "\n\n- Por favor digite o nome da editoria."; }


break;

//-----------------------------------------------------------------------------

case "jornalista":
//verifica se campo existe
if(document.formulario.cmp_veiculo_id)
{
if(WithoutSelectionValue(document.formulario.cmp_veiculo_id)){ mensagem_erro += "\n\n- Por favor escolha um Veículo."; }
}
else
{
mensagem_erro += "\n\n- Por favor escolha um valor no campo Mídia para que possa ser mostrado o campo Veículos.";
}

if(sem_conteudo(document.formulario.cmp_jornalista_nome.value)){ mensagem_erro += "\n\n- Por favor digite o nome do jornalista."; }

break;

//-----------------------------------------------------------------------------

case "login":

if(sem_conteudo(document.formulario_de_logar.nome_usuario.value)){ mensagem_erro += "\n\n- Por favor digite o nome do usuário."; }
if(sem_conteudo(document.formulario_de_logar.senha_usuario.value)){ mensagem_erro += "\n\n- Por favor digite a senha do usuário."; }

break;
//-----------------------------------------------------------------------------

case "comentario":
if((document.formulario.cmp_clipping_comentario_titulo.value !="")||(document.formulario.cmp_clipping_comentario_corpo.value !="")||(!NoneWithCheck(document.formulario.cmp_clipping_comentario_classificacao)))
{
	if(sem_conteudo(document.formulario.cmp_clipping_comentario_titulo.value)){ mensagem_erro += "\n\n- Por favor digite um título para seu comentário."; }
	if(sem_conteudo(document.formulario.cmp_clipping_comentario_corpo.value)){ mensagem_erro += "\n\n- Por favor digite o corpo de seu comentário."; }

	if(NoneWithCheck(document.formulario.cmp_clipping_comentario_classificacao)) { mensagem_erro += "\n\n- Por favor classifique este comentário."; }
}else if((document.formulario.cmp_clipping_comentario_titulo.value =="")&&(document.formulario.cmp_clipping_comentario_corpo.value =="")&&(NoneWithCheck(document.formulario.cmp_clipping_comentario_classificacao))&&(document.formulario.hdClippingTipo.value =="")){
	alert('Nenhum item a ser salvo.\n-Faça um comentário ou classifique o tipo de seu clipping.');
	return false;
}
break;
//-----------------------------------------------------------------------------

case "login_recupera":

if(sem_conteudo(document.form_senha_perdida.usuario_senha_perdida.value)){ mensagem_erro += "\n\n- Por favor digite o nome do usuário."; }

break;

//-----------------------------------------------------------------------------

default:

  alert('falta validação');

}

// Junta mensagens de erro.

if(mensagem_erro.length > 2)
{
    alert('AVISO:' + mensagem_erro);
    return false;
}

return true;

} // fim da função de checar campos

function confirmar_data(mensagem)
{
	data_ano = document.formulario.data_a_ano.value;
	a1 = document.formulario.a1.value;
	a2 = document.formulario.a2.value;
	d1 = document.formulario.d1.value;
	d2 = document.formulario.d2.value;
	if(a1.length == 2){
		a1 = "20"+a1;
	}
	if(a2.length == 2){
		a2 = "20"+a2;
	}
	if(d1.length == 1){
		d1 = "0"+d1;
	}
	if(d2.length == 1){
		d2 = "0"+d2;
	}
	data_inicio = a1+document.formulario.m1.value+d1;
	data_fin = a2+document.formulario.m2.value+d2;

	if(document.formulario.m1.value == "00" || document.formulario.m2.value == "00"){
		alert("AVISO:\n\n- Por favor escolha o Mês.");
		return false;
	}
	else{
		var agree=confirm(mensagem);

		if (agree)
		{
			if(parseInt(data_ano) < parseInt(data_inicio) || parseInt(data_ano) < parseInt(data_fin))
			{
				alert("AVISO:\n\n- Não é possivel apagar registros anteriores a 1 ano!");
				return false;
			}else{
				return true;
			}
		}
		else
		{
			return false;
		}
	}

}

//checa se tem conteudo

function sem_conteudo(ss) {

if(ss.length > 0) { return false; }

return true;

}



function cpf_cnpj(ss) {

if(ss.length > 0) { return false; }

return true;

}



function ChecaSenha(ss,sss) {

if(ss == sss) { return false; }

return true;

}



function NoneWithContent(ss) {

for(var i = 0; i < ss.length; i++) {

    if(ss[i].value.length > 0) { return false; }

    }

return true;

}



function NoneWithCheck(ss)
{
	for(var i = 0; i < ss.length; i++)
	{
		if(ss[i].checked)
		{
			return false;
		}
	}

	return true;
}

function WithoutCheck(ss)
{
	if(ss.checked) { return false; }
	return true;
}

function WithoutSelectionValue(ss) {

for(var i = 0; i < ss.length; i++) {

    if(ss[i].selected) {

        if(ss[i].value.length) { return false; }

        }

    }

return true;

}

////////////////////////////////////////////////////////////////////////////////////

// scrol de imagens pequenas dos clippings
scrollStep=1

timerLeft=""
timerRight=""

function toLeft(id){
  document.getElementById(id).scrollLeft=0
}

function scrollDivLeft(id){
  clearTimeout(timerRight)
  document.getElementById(id).scrollLeft+=scrollStep
  timerRight=setTimeout("scrollDivLeft('"+id+"')",10)
}

function scrollDivRight(id){
  clearTimeout(timerLeft)
  document.getElementById(id).scrollLeft-=scrollStep
  timerLeft=setTimeout("scrollDivRight('"+id+"')",10)
}

function toRight(id){
  document.getElementById(id).scrollLeft=document.getElementById(id).scrollWidth
}

function stopMe(){
  clearTimeout(timerRight)
  clearTimeout(timerLeft)
}


//-->
//Clipping Tipo
function verificarCampoTxt(campoTxt)
{
	if(document.getElementById(campoTxt).value == ""){
		alert("Informe o nome do tipo por favor.");
		return false;
	}else{
		return true;
	}
}

function editarClippingTipo(Id,Nome,Descricao)
{
	document.getElementById('cliId').value = Id;
	document.getElementById('txtNome').value = Nome;
	document.getElementById('txtDescricao').value = Descricao;
}

function limpaCamposClippingTipo()
{
	document.getElementById('cliId').value = 0;
	document.getElementById('txtNome').value = "";
	document.getElementById('txtDescricao').value = "";
}

function confirmaDinamico(pagina_deleta,registro,msg)
{
	if (confirm(msg+":\n"+registro+" ?"))
	{
		location.href = pagina_deleta;
	}
}

function ContatenaHdClippingTipo(item1,value1,item2,value2)
{
	//Valida itens Repitidos
	if((value2 != '0' )&&(value2!='N')){
	var testeRepete = false;
	if(document.formulario.hdClippingTipo.value !=""){
		arr1 = document.formulario.hdClippingTipo.value.split(",");

		for(i=0;i<arr1.length;i++)
		{
			arr2 = arr1[i].split("-");
			for(a=0;a<arr2.length;a++)
			{

				if(eval(a%2)!=0){
					palavra = arr2[a].replace("]","");
					arr3 = palavra.split("[");
					for(b=0;b<arr3.length;b++)
					{
						if(arr3[1] == value2)
						{
							testeRepete = true;
						}
					}

				}
			}
		}

	}
	//---------------------

	if((value1!='0')&&(value2!= '0')&&(!testeRepete)){
		if(document.getElementById('hdClippingTipo').value == ""){
			document.getElementById('hdClippingTipo').value = item1+'['+value1+']-'+item2+'['+value2+']';
		}else{
			document.getElementById('hdClippingTipo').value = item1+'['+value1+']-'+item2+'['+value2+'],'+document.getElementById('hdClippingTipo').value;
		}
		monta_lista_ClippingTipo();
	}else{
		if(testeRepete == true)
		{
			alert('Item de classificação já adicionado.');
		}
		else
		{
			alert('Selecione os itens corretamente.');
		}
	}
	}else{
		alert('Esse item não pode ser adicionado');
	}
}

function relatorio_clipping_personalizado(pessoa_id,acao,ordenador)
{
	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if (document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}

	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{	window.open('utilitarios/relatorio_clipping_personalizado_dinamico.php','relatorio_personalizado','width=400,height=600,scrollbars=yes,location=yes,resizable=yes');
		document.getElementById('formulario_resultados').target='relatorio_personalizado';
		document.getElementById('formulario_resultados').action='utilitarios/relatorio_clipping_personalizado_dinamico.php?ordenador='+ordenador+'&acao_relatorio='+acao+'&pessoa_id='+pessoa_id;
		document.getElementById('formulario_resultados').submit();
	}
}

function relatorio_clipping_personalizado_excel(pessoa_id,acao,ordenador)
{
	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if (document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}

	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{
		window.open('utilitarios/relatorio_clipping_personalizado_dinamico_excel.php','relatorio_personalizado','width=400,height=600,scrollbars=yes,location=yes,resizable=yes');
		document.getElementById('formulario_resultados').target='relatorio_personalizado';
		document.getElementById('formulario_resultados').action='utilitarios/relatorio_clipping_personalizado_dinamico_excel.php?ordenador='+ordenador+'&acao_relatorio='+acao+'&pessoa_id='+pessoa_id;
		document.getElementById('formulario_resultados').submit();
	}
}

function relatorio_clipping_personalizado_excel_1685(pessoa_id,acao,ordenador)
{
	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if (document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}

	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{
		window.open('utilitarios/relatorio_clipping_personalizado_dinamico_excel_1685.php','relatorio_personalizado','width=400,height=600,scrollbars=yes,location=yes,resizable=yes');
		document.getElementById('formulario_resultados').target='relatorio_personalizado';
		document.getElementById('formulario_resultados').action='utilitarios/relatorio_clipping_personalizado_dinamico_excel_1685.php?ordenador='+ordenador+'&acao_relatorio='+acao+'&pessoa_id='+pessoa_id;
		document.getElementById('formulario_resultados').submit();
	}
}

function relatorio_clipping_personalizado_excel_rs(pessoa_id,acao,ordenador)
{
	var controle = 0;
	for (i=0;i<document.formulario_resultados.elements.length;i++)
	{
		if (document.formulario_resultados.elements[i].type == "checkbox")
		{
			if (document.formulario_resultados.elements[i].checked == true)
			{
			controle++;
			}
		}
	}

	if (controle <= 0)
	{
		alert("Você deve marcar ao menos um dos clippings");
		return false;
	}
	else
	{
		document.getElementById('formulario_resultados').target='_blank';
		document.getElementById('formulario_resultados').action='utilitarios/relatorio_clipping_personalizado_dinamico_excel_rs.php?ordenador='+ordenador+'&acao_relatorio='+acao+'&pessoa_id='+pessoa_id;
		document.getElementById('formulario_resultados').submit();
	}
}

/*Funções Relatório de Inserções Modelo 2 - INICIO*/

//selecionar multipos itens sem control

function verificaUsuariosSelecionado(arrOldValuesPost)
{
	arrOldValuesT = arrOldValuesPost.split(",");
	for(var i = 0;i <= arrOldValuesT.length;i++){
		if(arrOldValuesT[i] == '1'){

		}
	}
	for (i=0;i<document.getElementById("cmp_usuario_id[]").length;i++){

		for(var x = 0;x <= arrOldValuesT.length;x++)
		{
			variavel = document.getElementById("cmp_usuario_id[]").options[i].value.substr(0,document.getElementById("cmp_usuario_id[]").options[i].value.indexOf('_'))
			if(variavel == arrOldValuesT[x])
			{
				document.getElementById("cmp_usuario_id[]").options[i].selected = true;
			}
		}
	}
}

//termina selecionar multiplos itens csem control

function selectedDpD(pessoaTipo,acao)
{

	for (i=0;i<document.getElementById("cmp_usuario_id[]").length;i++){
			variavel = document.getElementById("cmp_usuario_id[]").options[i].value.substr(document.getElementById("cmp_usuario_id[]").options[i].value.indexOf('_')+1,1);
			if(variavel == pessoaTipo)
			{
				document.getElementById("cmp_usuario_id[]").options[i].selected = acao;
			}

	}

}



function verificaDataDias(iDia,eDia,dias)
{

}

function mudarAcao(acaoValor){
	if(document.getElementById("chkGerarExcel").checked == true){
			document.getElementById("formRelInsercao").action = 'modulos/'+acaoValor+'.php';
	}else{
		document.getElementById("formRelInsercao").action = "index.php?acao_adm=clipping_relatorio_insercao_mod2";
	}
}

function SomarData(txtData,DiasAdd)
{
        var d = new Date();

         d.setTime(Date.parse(txtData.split("/").reverse().join("/"))+(86400000*(DiasAdd)));

        // Crio a var da DataFinal
        var DataFinal;

        // Aqui comparo o dia no objeto d.getDate() e vejo se é menor que dia 10.
        if(d.getDate() < 10)
        {
            // Se o dia for menor que 10 eu coloca o zero no inicio
            // e depois transformo em string com o toString()
            // para o zero ser reconhecido como uma string e não
            // como um número.
            DataFinal = "0"+d.getDate().toString();
        }
        else
        {
            // Aqui a mesma coisa, porém se a data for maior do que 10
            // não tenho necessidade de colocar um zero na frente.
            DataFinal = d.getDate().toString();
        }

        // Aqui, já com a soma do mês, vejo se é menor do que 10
        // se for coloco o zero ou não.
        if((d.getMonth()+1) < 10){
            DataFinal += "/0"+(d.getMonth()+1).toString()+"/"+d.getFullYear().toString();
        }
        else
        {
            DataFinal += "/"+((d.getMonth()+1).toString())+"/"+d.getFullYear().toString();
        }
		//alert(DataFinal);
        return DataFinal;
}


function gE(idElemento)
{
    return document.getElementById(idElemento);
}

    function dataMaior(dt1,dt2){

        // dt1 e dt2: Devem ser tipo String, para evitar confusao de tipos
        if(typeof dt1 != "string" ||
           typeof dt2 != "string"){
            alert("As datas devem ser passadas como strings");
            return false;
        }

        // Instanciamos as datas, para poder usar getTime();
        data1 = new Date(dt1);
        data2 = new Date(dt2);
        if(!data1 || !data2){
            alert("Erro ao criar objetos");
            return false;
        }

        // milliSegundos1: irá conter a quantidade de segundos corridos desde 1/1/1970 0h ate dt1
        milliSegundos1 = data1.getTime();
        // milliSegundos2: irá conter a quantidade de segundos corridos desde 1/1/1970 0h ate dt2
        milliSegundos2 = data2.getTime();

        // Comparando millisegundos para retornar a conclusão de quem é maior que quem...
        if(milliSegundos1 == milliSegundos2){
            return false;
        } else if(milliSegundos1 > milliSegundos2){
            return false;
        } else if(milliSegundos1 < milliSegundos2){
            return true;
        } else return false;
    }
function verificaData31Dias()
{
	var dia1 = document.getElementById("cmp_clipping_insercao_data_dia_01").value;
	var dia2 = document.getElementById("cmp_clipping_insercao_data_dia_02").value;

	var mes1 = document.getElementById("cmp_clipping_insercao_data_mes_01").value;
	var mes2 = document.getElementById("cmp_clipping_insercao_data_mes_02").value;

	if((mes1 != mes2)&&(dia2 >= dia1)){
		return false;
	}
	return true;
}

function validarFormularioRelatorio(){
			dt1 = document.getElementById("cmp_clipping_insercao_data_ano_01").value+'/'+document.getElementById("cmp_clipping_insercao_data_mes_01").value+'/'+document.getElementById("cmp_clipping_insercao_data_dia_01").value;
			dt1Br =	document.getElementById("cmp_clipping_insercao_data_dia_01").value+'/'+document.getElementById("cmp_clipping_insercao_data_mes_01").value+'/'+document.getElementById("cmp_clipping_insercao_data_ano_01").value;
			dt2Br =	document.getElementById("cmp_clipping_insercao_data_dia_02").value+'/'+document.getElementById("cmp_clipping_insercao_data_mes_02").value+'/'+document.getElementById("cmp_clipping_insercao_data_ano_02").value;
		dt2 =document.getElementById("cmp_clipping_insercao_data_ano_02").value+'/'+document.getElementById("cmp_clipping_insercao_data_mes_02").value+'/'+document.getElementById("cmp_clipping_insercao_data_dia_02").value;
				if(!dataMaior(dt1,dt2))
			  	{
					document.getElementById("relatorioMontado").style.display = "none";
					alert("data final deve ser maior que data inicial");
				  return false;
				}
				if(document.getElementById("cmp_usuario_id[]").value == ''){
					document.getElementById("relatorioMontado").style.display = "none";
					alert("selecione um funcionario");
					return false;
				}
				var novaData = SomarData(dt1Br,31);
				//alert(novaData);
				if(!verificaData31Dias())
			  	{
					document.getElementById("relatorioMontado").style.display = "none";
					alert("E possivel tirar um relatorio de no maximo 1 mes");
				  return false;
				}
			  	return true;
}
/*Funções Relatório de Inserções Modelo 2 - FIM*/
