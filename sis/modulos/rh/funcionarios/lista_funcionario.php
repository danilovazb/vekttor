<?
include("_function_funcionario.php");
include("_ctrl_funcionario.php"); 
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id='form_documento'></div>
<div id="some">«</div>
<a href="?" class='s1'>
  	Sistema
</a>
<a href="?" class='s2'>
  	RH
</a>
<a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
</a>
<style>
.btf{ display:block; float:left; width:15px; height:15px; background-image:url(../fontes/img/formatacao.gif);margin-top:5px;text-decoration:none;}
	.bold{ background-position:-2px -17px;}
	.italic{ background-position:-20px -17px; }
	.underline{ background-position:-58px -16px;}
	.justifyleft{ background-position:-2px 0px;margin-left:50px}
	.justifycenter{ background-position:-20px 0px;}
	.justifyright{ background-position:-38px 0px;}
	.justifyfull{ background-position:-57px 0px;}
	.insertunorderedlist{background-position:-19px -51px;margin-left:50px;}
	.insertorderedlist{ background-position:-37px -51px;}
	#horario_escolaridade{width:600px;margin-top:17px;}
	
</style>
<script>

	function rteInsertHTML(html) {
	 rteName = 'ed';
		if (document.all) {
			document.getElementById(rteName).contentWindow.document.body.focus();
			var oRng = document.getElementById(rteName).contentWindow.document.selection.createRange();
			oRng.pasteHTML(html);
			oRng.collapse(false);
			oRng.select();
		} else {
			document.getElementById(rteName).contentWindow.document.execCommand('insertHTML', false, html);
		}
	}
	
	function ti(m,v){
		
    w= document.getElementById('ed').contentWindow.document
	if(m=='InsertHTML' ){
		rteInsertHTML(v);
	}else{
		
	if(m == "backcolor"){
		if(navigator.appName =='Netscape'){
				w.execCommand('hilitecolor',false,v);
			}else{
				w.execCommand('backcolor',false,v);
			}
		}else{
		
			w.execCommand(m, false, v);
		}
		}
	}

	function html_to_form(ed,tx_html){
	
		document.getElementById(tx_html).value = document.getElementById(ed).contentWindow.document.body.innerHTML
		
		document.getElementById(ed).contentWindow.document.body.innerHTML.replace("\n","");
}


function insere_txt(txt) {
    var myQuery = document.getElementById("ed").contentWindow.document.body;
    var chaineAj = txt;
	//IE support
	if (document.selection) {
		myQuery.focus();
		sel = document.selection.createRange();
		sel.innerHTML = chaineAj;
	}
	//MOZILLA/NETSCAPE support
	else if (document.getElementById("ed").selectionStart || document.getElementById("ed").selectionStart == "0") {
		var startPos = document.getElementById("ed").selectionStart;
		var endPos = document.getElementById("ed").selectionEnd;
		var chaineSql = document.getElementById("ed").innerHTML;

		myQuery.innerHTML = chaineSql.substring(0, startPos) + chaineAj + chaineSql.substring(endPos, chaineSql.length);
	} else {
		myQuery.innerHTML += chaineAj+'++aaa++';
	}
}




function insertValueQuery() {
    var myQuery = document.sqlform.sql_query;
    var myListBox = document.sqlform.dummy;

    if(myListBox.options.length > 0) {
        sql_box_locked = true;
        var chaineAj = "";
        var NbSelect = 0;
        for(var i=0; i<myListBox.options.length; i++) {
            if (myListBox.options[i].selected){
                NbSelect++;
                if (NbSelect > 1)
                    chaineAj += ", ";
                chaineAj += myListBox.options[i].value;
            }
        }

        //IE support
        if (document.selection) {
            myQuery.focus();
            sel = document.selection.createRange();
            sel.text = chaineAj;
            document.sqlform.insert.focus();
        }
        //MOZILLA/NETSCAPE support
        else if (document.sqlform.sql_query.selectionStart || document.sqlform.sql_query.selectionStart == "0") {
            var startPos = document.sqlform.sql_query.selectionStart;
            var endPos = document.sqlform.sql_query.selectionEnd;
            var chaineSql = document.sqlform.sql_query.value;

            myQuery.value = chaineSql.substring(0, startPos) + chaineAj + chaineSql.substring(endPos, chaineSql.length);
        } else {
            myQuery.value += chaineAj;
        }
        sql_box_locked = false;
    }
}


	$(".link_form").live("click",function(){
		
		var aba = $(this).text();
		var id = $("#id").val();
						
		if(id<=0){
			alert('Por favor, Digite os dados do Funcionário e clique em Salvar');
		}else{
			
			
			
			$(".form_float").css("display","none");
			
				
			if(aba=="Dados"){ 
				
				$("#form_cliente").css("display","block");
				$("#dados_funcionario").css("display","block");
				$("#dados_pis").css("display","none");
		
			}
			
			if(aba=="PIS"){ 
				$("#form_cliente").css("display","block");
				$("#dados_funcionario").css("display","none");
				$("#dados_pis").css("display","block");
		
			}
		
			if(aba=="Documentos"){ 
													
				$("#form_documentos").css("display","block");
		
			}
			
			if(aba=="Dependentes"){ 
													
				$("#form_dependentes").css("display","block");
		
			}	
			
			if(aba=="Contrato"){ 
													
				$("#form_contrato").css("display","block");
		
			}
			
			if(aba=="Social"){
				$("#form_perfil_social").css("display","block");
			}
			
			if(aba=="Avaliação"){
				$("#form_avaliacao").css("display","block");
			}
			
			
		}
		
	});
	
	$("#adicionar_documento").live("click",function(){
		
		//alert('oi');
		
		$("#form_documentos").submit();
		$("#documento_descricao").val('');
		$("#documento_arquivo").val('');
		
		
	});
	
	$("#remove_documento").live('click',function(){
		var documento_id=$(this).parent().parent().attr("id_documento");
		var funcionario_id   =$("#id").val();
		//var empresa_id   =$("#cliente_fornecedor_id").val();
				
						//alert(numparcelas);		
		var dados = "funcionario_id="+funcionario_id+"&documento_id="+documento_id+"&remove_documento=1";
		//alert(dados);			
		$("#dados_documentos").load("modulos/rh/funcionarios/tabela_documentos.php?"+dados);		
	});
	
	function replaceAll(string, token, newtoken) {
		while (string.indexOf(token) != -1) {
 			string = string.replace(token, newtoken);
		}
		return string;
	}
	
	$("#adicionar_dependente").live("click",function(){
	
					
				var funcionario_id   =$("#id").val();
				var nome   =replaceAll($("#nome_dependente").val()," ","_");
											
				var data_nascimento   =$("#data_nascimento_dependente").val();
				var grau_parentesco_dependente   =$("#grau_parentesco_dependente").val();
				var grau_escolaridade_dependente = $("#grau_escolaridade_dependente").val();
				var plano_saude;
				
				
				if($("#dependente_plano_saude").is(":checked")){
					var plano_saude = "sim";
				}else{
					var plano_saude = "nao";
				}
				
				//alert(numparcelas);		
				var dados = "plano_saude="+plano_saude+"&funcionario_id="+funcionario_id+'&nome='+nome+"&data_nascimento="+data_nascimento+"&grau_parentesco_dependente="+grau_parentesco_dependente+"&adicionar_dependente=1&grau_escolaridade_dependente="+grau_escolaridade_dependente;
			
				$("#nome_dependente").val('');
				$("#data_nascimento_dependente").val('');
				$("#dependente_plano_saude").removeAttr("checked");
								
				$("#dados_dependentes").load("modulos/rh/funcionarios/tabela_dependentes.php?"+dados);		
											
	
	});
	
	$("#remove_dependente").live('click',function(){
		var dependente_id=$(this).parent().parent().attr("id_dependente");
		var funcionario_id   =$("#id").val();
		//var empresa_id   =$("#cliente_fornecedor_id").val();
				
						//alert(numparcelas);		
		var dados = "funcionario_id="+funcionario_id+"&dependente_id="+dependente_id+"&remove_dependente=1";
		//alert(dados);			
				$("#dados_dependentes").load("modulos/rh/funcionarios/tabela_dependentes.php?"+dados);		
	});
	
	$("#f_quando_estrangeiro").live('change',function(){
		
		if($(this).val()=="sim"){
			$("#estrangeiro").css("display","block");			
		}else{
			$("#estrangeiro").css("display","none");	
		}
	});
	
	$("#modelo_id").live("change",function(){
	//alert(numparcelas);	
	var modelo_id = $(this).val();
		
	var dados = "modelo_id="+modelo_id+"&acao=busca_modelo";
														
	$.ajax({
		url: 'modulos/rh/empresa/busca_modelo_contrato.php',
		type: 'POST',
		data: dados,
		success: function(data) {
			//alert(data);
			document.getElementById("ed").contentWindow.document.body.innerHTML = data;
		
		},
	});	
	

});
	$("#imprimir_contrato").live('click',function(){
		//alert('oi');
			
		
		var id=$("#id").val();
		window.open('modulos/rh/funcionarios/impressao_contrato_experiencia.php?id='+id);
	});
	$(".imprimir_relatorio").live('click',function(){
		
		var id=$("#id").val();
		var relatorio = $(this).val();
		
		
		switch(relatorio){
			case 'Ficha Frente': window.open('modulos/rh/funcionarios/ficha_registro_empregado.php?id='+id);break;
			case 'Ficha Costa': window.open('modulos/rh/funcionarios/ficha_registro_empregado2.php?id='+id);break;
			case 'PIS': window.open('modulos/rh/funcionarios/ficha_pis.php?id='+id);break;
			case 'Termo de Opçao': window.open('modulos/rh/funcionarios/termo_opcao.php?id='+id);break;
			
			case 'Termo de Transporte': window.open('modulos/rh/funcionarios/termo_transporte.php?id='+id);break;
			
			case 'ASO': window.open('modulos/rh/funcionarios/atestado_saude.php?id='+id);break;
			
			case 'Entrega de Carteira': window.open('modulos/rh/funcionarios/impressao_comprovante_carteira.php?id='+id+'&acao=entrega');break;
			
			case 'Devolução de Carteira': window.open('modulos/rh/funcionarios/impressao_comprovante_carteira.php?id='+id+'&acao=devolucao');break;
		}
		//window.open('modulos/rh/funcionarios/impressao_contrato_experiencia.php?id='+id);
	});
	
	$('.imprimir_documentos').live('click',function(){
		var id =  $(this).parent().parent().attr('id_documento');
		
		window.open("modulos/rh/funcionarios/download_documento.php?id="+id);
	});
	
	$("#f_estado_civil").live('change',function(){
		
		estado_civil = $(this).val();
		
		if(estado_civil=='Casado'){
			$("#conjugue").css('display','block');
		}else{
			$("#conjugue").css('display','none');
		}
	});
	
	$(".modelo").live('click',function(){
		//alert('oi');
	});
	
	$("#possui_deficiencia").live('change',function(){
		
		if($(this).val()=='1'){
			$("#div_tipo_deficiencia").css('display','block');
		}
		
		if($(this).val()=='2'){
			$("#div_tipo_deficiencia").css('display','none');
		}
		
	});
	
	$("#mora_com").live('change',function(){
		
		if($(this).val()=='parentes'){
			$("#divmoracom").show();
		}else{
			$("#divmoracom").hide();
		}		
	});
	
	$("#bebe").live('change',function(){
		
		if($(this).val()=='sim'){
			$("#frequencia_bebe").show();
		}else{
			$("#frequencia_bebe").hide();
		}		
	});
	
	$("#fuma").live('change',function(){
		
		if($(this).val()=='sim'){
			$("#circunstancia_fuma").show();
		}else{
			$("#circunstancia_fuma").hide();
		}		
	});
	
	$("#medicacao").live('change',function(){
		
		if($(this).val()=='sim'){
			$("#descricao_medicacao").show();
		}else{
			$("#descricao_medicacao").hide();
		}		
	});
	
	$("#tratamento").live('change',function(){
		
		if($(this).val()=='sim'){
			$("#descricao_tratamento").show();
		}else{
			$("#descricao_tratamento").hide();
		}		
	});
	$("#outro_problema_saude").live('click',function(){
		
		if($(this).is(':checked')){
			$("#descricao_doenca").show();
		}else{
			$("#descricao_doenca").hide();
			$("#textdescricao_doenca").val('');
		}		
	});	
	$("#estuda").live('change',function(){
	
		if($(this).val()=="sim"){
			
			$(".escolaridade").show();
			
		}else{
			$(".escolaridade").hide();
		}
	});
	$("#situacao_escolaridade").live('change',function(){
	
		if($(this).val()=="i"||$(this).val()=="cur"){			
			$("#lblserie_escolaridade").show();
		}else{
			$("#lblserie_escolaridade").hide();
		}
	});
	
	$("#mora_em").live('change',function(){
		
		if($(this).val()=="outros"){
			$("#divmoraem").show();
		}else{
			$("#divmoraem").hide();
		}
	});
	
	$(".remover_foto").live('click',function(){
		var id = $("#id").val();
		
		window.open('modulos/rh/funcionarios/_ctrl_funcionario.php?acao=remover_foto&id_foto='+id,'carregador');
		$(".foto").html('');
	});
	
	$("#tipo_avaliacao").live('change',function(){
		funcionario_id = $("#id").val();
		tipo_avaliacao = $(this).val();
		
		$.post('modulos/rh/funcionarios/_ctrl_funcionario.php',{acao:'consulta_avaliacao', funcionario_id:funcionario_id, tipo_avaliacao:tipo_avaliacao},function(data){
			
			resultado = JSON.parse(data);
			
			$("#avaliacao").val(resultado.avaliacao);
			$("#avaliacao_id").val(resultado.id);
		
		});
		
		
	});
	
	$("#f_dias_experiencia").live('change',function(){
		calcula_periodo_experiencia();
	});
	$("#f_data_admissao").live('blur',function(){
		calcula_periodo_experiencia();
	});
	
	function calcula_periodo_experiencia(){
		periodo_experiencia = $("#f_dias_experiencia").val();
		data_admissao       = $("#f_data_admissao").val();
		
		$.post('modulos/rh/funcionarios/_ctrl_funcionario.php',{acao:'calcula_data', periodo_experiencia:periodo_experiencia, data_admissao:data_admissao},function(data){
			
			resultado = JSON.parse(data);
			
			$("#prazo_experiencia_1").val(resultado.prazo1);
			$("#prazo_experiencia_2").val(resultado.prazo2);
			$("#avaliacao_id").val(resultado.id);
		
		});
	};
</script>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" /><input type="hidden" name="empresa1id" value="<?=$_GET['empresa1id']?>" />
   
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>
<div id="barra_info">    
EMPRESA: <strong><?=$cliente_fornecedor->razao_social?></strong> CNPJ:<strong><?=$cliente_fornecedor->cnpj_cpf?></strong>
  <a href="modulos/rh/funcionarios/form.php?empresa1id=<?=$cliente_fornecedor->id?>" target="carregador" class="mais"></a>
  </div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
        	<td width="30"><?=linkOrdem("Nº","numero_sequencial_empresa",1)?></td>
            <td width="350"><?=linkOrdem("Funcionário","nome",1)?></td>
            <td width="90" >R$ Salário</td>
          	<td width="220" >Cargo</td>
       	 
          	<td width=""></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <?
	//$empresa_id=$_GET['empresa_id'];
	
	if(!empty($_GET['busca'])){
		$filtro = " AND nome like '%".$_GET['busca']."%'";
	}
	if(isset($_GET['tempo1'])&&$_GET['tempo2']>0){
		$filtro = "AND data_admissao > (SELECT DATE_SUB( NOW( ) , INTERVAL ".$_GET['tempo2']." DAY)) 
						AND data_admissao <= (SELECT DATE_SUB( NOW( ) , INTERVAL ".$_GET['tempo1']." DAY ))";	
	}else if(isset($_GET['tempo1'])){
		$filtro = "AND data_admissao < (SELECT DATE_SUB( NOW() , INTERVAL ".$_GET['tempo1']." DAY))";
	}
	if($_GET[limitador]<1){
		$_GET[limitador]	=100;
	}
	if(strlen($_GET[ordem])>0){
		$ordem = $_GET[ordem];
	}else{
		$ordem =  'nome';
	}
	$registros= mysql_result(mysql_query($t="SELECT count(*) FROM 
					  	rh_funcionario f
					  WHERE 
					  	empresa_id='".$cliente_fornecedor->id."' AND
						status != 'demitidos' AND
					  	vkt_id='$vkt_id'
						$filtro"),0,0);
						
	$q = mysql_query($t="SELECT * FROM 
					  	rh_funcionario
					  	
					  WHERE 
					  	empresa_id='".$cliente_fornecedor->id."' AND
						status != 'demitidos' AND
						vkt_id='$vkt_id'						
						$filtro
						ORDER BY $ordem
						LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	
	
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		$ultimo_salario = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_alteracao_salario WHERE funcionario_id='$r->id' ORDER BY data DESC LIMIT 1"));

		if($ultimo_salario->salario>0){
			$salario = $ultimo_salario->salario;
		}else{
			$salario = $r->salario;
		}
	?>       
    	<tr <?=$sel ?> onclick="window.open('<?=$tela->caminho?>/form.php?id=<?=$r->id?>&empresa1id=<?=$cliente_fornecedor->id?>','carregador')" >
                	<td width="30"><?=$r->numero_sequencial_empresa?></td>

          	<td width="350" ><?=$r->nome?></td>
          	<td width="90" align="right" ><span style="float:left">R$</span><?=moedaUsaToBr($salario)?></td>
          	<td width="220" ><?=$r->cargo?></td>
            <td></td>
        </tr>
      
<?
	}
?>
    	
    </tbody>
</table>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
                	<td width="30"><?=$r->nome?></td>
            <td width="220"align="right"></td>
            <td width=""></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	<?=$registros?> Registros 
    <?
	if($_GET[limitador]<1){
		$limitador= 30;	
	}else{
		$limitador= $_GET[limitador];
	}
    $qtd_selecionado[$limitador]= 'selected="selected"'; 
	?>
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value+'&empresa1id=<?=$cliente_fornecedor->id?>'">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador],array("empresa1id"=>"$cliente_fornecedor->id"))?>
    </div>
</div>
<script>
$('#sub93').show();
$('#sub418').show()
</script>