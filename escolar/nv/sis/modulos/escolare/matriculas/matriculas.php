<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho; 

include ("_functions.php");
include ("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(function(){
some_menu();	
});

</script>
<script type="text/javascript">

/*
function ld(xml,destino,url){
	try{xml = new XMLHttpRequest();}catch(ee){try{xml = new ActiveXObject("Msxml2.XMLHTTP");} catch(e){try{xml = new ActiveXObject("Microsoft.XMLHTTP");}catch(E){xml = false;}}}
	d= new Date();
	url = '<?=$tela->caminho?>'+url+"&temp="+d.getMilliseconds();
	
	xml.open("GET",url  ,true);
	xml.onreadystatechange=function() {
		if (xml.readyState==4){
			var texto=xml.responseText;
			texto=texto.replace(/\+/g," ")
			texto=unescape(texto);
			destino.innerHTML=texto;
		}
	}
	xml.send(null);
}
*/
function verifica_idade(t){
	ultima = t.value.substr(9,1);
	if(ultima!='_' && t.value.length=='10' ){
		ano_nascimento = t.value.substr(6,4)*1;
		mes_nascimento = t.value.substr(3,2)*1;
		dia_nascimento = t.value.substr(0,2)*1;
		var d = new Date();
		var ano = d.getFullYear();
		var mes = d.getMonth()+1;
		var dia = d.getDate();
		idade_ano  = ano-ano_nascimento;
		idade = idade_ano;
		if(mes_nascimento>mes){
			idade = idade_ano-1
		}
		if(mes_nascimento==mes&& dia_nascimento>=dia){
			idade = idade_ano-1
		}
		if(idade>=18){
			$(t.parentNode.parentNode).find('#cpf').attr('valida_cpf','1');
			$(t.parentNode.parentNode).find('#cpf').attr('retorno','focus|Digite o CPF corretamente do aluno');
		}else{
			$(t.parentNode.parentNode).find('#cpf').removeAttr('valida_cpf');
			$(t.parentNode.parentNode).find('#cpf').removeAttr('retorno');
			$(t.parentNode.parentNode).find('#cpf').parent().removeClass('valida_error');
		}
	}
	
}

function checa_cpf(t){
	ultima = t.value.substr(13,1);
	if(ultima!='_' && t.value.length=='14' ){
		window.open('<?=$caminho?>form.php?cnpj_cpf='+t.value,'carregador')	
		
	}
}
$('.al,.dl').live('click',function (){
	xabi=$(this).attr('id');
	window.open('<?=$caminho?>form.php?matricula_id='+xabi,'carregador')	
});



$(".avancar").live('click',function(){
	pagina = $(this).attr('pagina')*1;
	pagina = pagina+1;
	
	 $(this).attr('pagina',pagina);
	 
	 $('.paginamatricula').hide();
	 
	 $('#pagina_id_'+pagina).show();
	if(pagina>1){
		$('.voltar').show();
	}
	alunos_descartaveis = $(".alunodescartavel").size();
	total_paginas = alunos_descartaveis+2;
	if(total_paginas== pagina){
		
		$(this).hide();
		$('.salvar').show();
	}else{
		$(".avancar").show();
		$('.salvar').hide();
	}
});
$(".voltar").live('click',function(){
	pagina = $(".avancar").attr('pagina')*1;
	pagina = pagina-1;
	
	$(".avancar").attr('pagina',pagina);
	
	$('.paginamatricula').hide(); 
	$('#pagina_id_'+pagina).show();
	if(pagina==1){
		$('.voltar').hide();
	}
	if(total_paginas== pagina){
		$(".avancar").hide();
		$('.salvar').show();
	}else{
		$(".avancar").show();
		$('.salvar').hide();
	}
});

$(".alunos_a_ser_matriculados").live('change',function(){
	
	alunos =$(this).val();
	d_html = $(".axluml:first").html();
	alunos_descartaveis = $(".alunodescartavel").size();
	alunos_amais = alunos_descartaveis+1;
	if(alunos<alunos_amais){
		diferenca_alunos = alunos_amais-alunos;
		
		for(i=alunos_descartaveis;i>=alunos;i--){
			pagina = i+2;
			$('#pagina_id_'+pagina).remove();
		}
		
	}else{
		for(i=1;i<alunos;i++){
			pagina=i+2;
			if($('#pagina_id_'+pagina).attr('criado')!=1){
				inner = "<div id='pagina_id_"+pagina+"' criado='1' class='paginamatricula alunodescartavel' style='width:770px;  display:none'>"+d_html+'</div>';
				
				$('#paidaspaginas').append(inner);
			}
		}
	}
});

function fc_endereco_mesmo(){
	$('#telefone1').val($('#f_telefone1').val());
	$('#endereco').val($('#f_endereco').val());
	$('#bairro').val($('#f_bairro').val());
	$('#complemento').val();
	$('#cep').val($('#f_cep').val());
	$('#cidade').val($('#f_cidade').val());
	$('#uf').val($('#f_estado').val());
	$('#codigo_interno').val();
	
}



$('.endereco_mesmo').live('click',function(){
	fc_endereco_mesmo();

})

$('.aluno_mesmo').live('click',function(){
	$('#nome').val($('#f_nome_contato').val());
	$('#data_nascimento').val($('#f_nascimento').val());
	$('#escolaridade').val($('#f_grau_instrucao').val());
	$('#profissao').val($('#f_ramo_atividade').val());
	$('#cpf').val($('#f_cnpj_cpf').val());
	$('#rg').val($('#f_rg').val());
	$('#rg_dt_expedicao').val($('#f_data_emissao').val());
	$('#email').val($('#f_email').val());
	$('#telefone2').val($('#f_telefone2').val());
	fc_endereco_mesmo();
	$(this.parentNode).hide();
})


$(".periodo_id").live('change',function(){
	periodo_id=$(this).val();
	$(this.parentNode.parentNode).find('.lb_escola_id').load('<?=$tela->caminho?>select_escolas.php?periodo_id='+periodo_id)
	
})


$(".escola_id").live('change',function(){
	periodo_id=$(this.parentNode.parentNode).find(".periodo_id").val();
	escola_id=$(this.parentNode.parentNode).find(".escola_id").val();
	
	$(this.parentNode.parentNode).find('.lb_curso_id').load('<?=$tela->caminho?>select_cursos.php?periodo_id='+periodo_id+'&escola_id='+escola_id);
	
})

$(".curso_id").live('change',function(){
	periodo_id=$(this.parentNode.parentNode).find(".periodo_id").val();
	escola_id=$(this.parentNode.parentNode).find(".escola_id").val();
	curso_id=$(this.parentNode.parentNode).find(".curso_id").val();
	
	$(this.parentNode.parentNode).find('.lb_modulo_id').load('<?=$tela->caminho?>select_modulos.php?periodo_id='+periodo_id+'&escola_id='+escola_id+'&curso_id='+curso_id);
	
})


$(".modulo_id").live('change',function(){
	periodo_id=$(this.parentNode.parentNode).find(".periodo_id").val();
	escola_id=$(this.parentNode.parentNode).find(".escola_id").val();
	curso_id=$(this.parentNode.parentNode).find(".curso_id").val();
	modulo_id=$(this.parentNode.parentNode).find(".modulo_id").val();
	
	$(this.parentNode.parentNode).find('.lb_horario_id').load('<?=$tela->caminho?>select_horarios.php?periodo_id='+periodo_id+'&escola_id='+escola_id+'&curso_id='+curso_id+'&modulo_id='+modulo_id);
	
})

$(".horario_id").live('change',function(){
	horario_id=$(this.parentNode.parentNode).find(".horario_id").val();
	valor =  $(this).find("option:selected").attr('valor');
	valor_bolsista =  $(this).find("option:selected").attr('valor');
	
	$(this.parentNode.parentNode).find('.lb_valor span').html(valor);
	
	$(this.parentNode.parentNode).find('.valor').val(valor);
	$(this.parentNode.parentNode).find('.lb_sala_id').load('<?=$tela->caminho?>select_salas.php?horario_id='+horario_id);
	
	
	
})
$(".remove_imagem").live("click", function(){
	aluno_id= $(this).attr('aluno_id');
	window.open('?tela_id=215&deleta_imagem='+aluno_id,'carregador');
	
	$("#img_curso").hide(200);
	
});

//--- Codigo Gerar senha

var Password = function() {
	this.pass = "";

	this.generate = function(chars) {
	  for (var i= 0; i<chars; i++) {
		this.pass += this.getRandomChar();
	  }
	  return this.pass;
}

	this.getRandomChar = function() {
		/* 
		*	matriz contendo em cada linha indices (inicial e final) da tabela ASCII para retornar alguns caracteres.
		*	[48, 57] = numeros;
		*	[64, 90] = "@" mais letras maiusculas;
		*	[97, 122] = letras minusculas;
		*/
		var ascii = [[48, 57],[97,122]];
		var i = Math.floor(Math.random()*ascii.length);
		return String.fromCharCode(Math.floor(Math.random()*(ascii[i][1]-ascii[i][0]))+ascii[i][0]);
	} 
}

function newPass(destino) {
	var pwd = new Password();
	senha =  pwd.generate(6);
	
	document.getElementById(destino).value = senha;
}
$('#val-matricula').live('click',function(){
		window.open('modulos/escolar/matriculas/form_valor.php','carregador');
});

</script>
<style>


tbody td:nth-child(1){width:30px;}
tbody td:nth-child(2){width:60px;}
tbody td:nth-child(3){width:200px;}
tbody td:nth-child(4){width:90px;}
tbody td:nth-child(5){width:60px;}
</style>
<div id="conteudo">

	<!--
        ///////////////////////////////////////
        Barra de Navegação
        ///////////////////////////////////////
    -->
    <div id="navegacao">
        <form class='form_busca' action="" method="get">
             <a></a>
            <input type="hidden" name="limitador" value="<?php echo $_GET['limitador']; ?>" />
            <input type="hidden" name="tela_id" value="<?php echo $_GET['tela_id']; ?>" />
            <input type="hidden" name="pagina" value="<?php echo $_GET['pagina']; ?>" />
            <input type="text" id='busca' value="<?php echo $_GET[busca]; ?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
        </form>
         <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="?tela_id=217" class="navegacao_ativo"><span></span>Matrículas</a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
      <label style="width:90%">
            	
                <select name="filtro_x" id="filtro_x"  onchange="location='?tela_id=<?=$_GET[tela_id]?>&filtro='+this.value+'&pago='+document.getElementById('pago').value+'&tipo_matricula='+document.getElementById('tipo_matricula').value+'&busca='+document.getElementById('busca').value">
                	<? 
					/*
					periodo,$periodo->id
					escola,$escola->escola_id,$periodo->id
					curso,$curso->curso_id,$escola->escola_id,$periodo->id
					modulo,$modulos->modulo_id,$curso->curso_id,$escola->escola_id,$periodo->id
					horario,$horarios->id
					*/
$s_periodo = (mysql_query(" SELECT * FROM escolar_periodos WHERE vkt_id='$vkt_id' ORDER BY inicio_aulas  "));
while($periodo=mysql_fetch_object($s_periodo)){
	$ultimp_periodo = $periodo->id;
  if($_GET[filtro]=="periodo,$periodo->id"){$select='selected=selected';}else{$select='';}
  echo "<option value='periodo,$periodo->id' style='margin-left:0' $select>".$periodo->nome."</option>";
  
  $s_escola = (mysql_query($t="SELECT distinct(h.escola_id),e.nome FROM escolar_horarios as h, escolar_escolas as e WHERE h.escola_id =e.id AND h.periodo_id='$periodo->id'  AND h.vkt_id='$vkt_id' "));
  while($escola=mysql_fetch_object($s_escola)){
    if($_GET[filtro]=="escola,$escola->escola_id,$periodo->id"){$select='selected=selected';}else{$select='';}
    echo "<option value='escola,$escola->escola_id,$periodo->id' style='margin-left:10px' $select>".$escola->nome."</option>";
	
	$s_cursos = (mysql_query(" SELECT distinct(h.curso_id),c.nome FROM escolar_horarios as h, escolar_cursos as c WHERE h.curso_id=c.id  AND h.periodo_id='$periodo->id' AND escola_id='$escola->escola_id'"));		
	while($curso=mysql_fetch_object($s_cursos)){
      if($_GET[filtro]=="curso,$curso->curso_id,$escola->escola_id,$periodo->id"){$select='selected=selected';}else{$select='';}
	  echo "<option value='curso,$curso->curso_id,$escola->escola_id,$periodo->id' style='margin-left:20px' $select>".$curso->nome."</option>";
	
	  $s_modulos =mysql_query($t =" SELECT distinct(h.modulo_id),m.nome FROM escolar_horarios as h, escolar_modulos  as m  WHERE  h.modulo_id=m.id AND h.periodo_id='$periodo->id' AND escola_id='$escola->escola_id' AND h.curso_id='$curso->curso_id'");
	  while($modulos=mysql_fetch_object($s_modulos)){
	    if($_GET[filtro]=="modulo,$modulos->modulo_id,$curso->curso_id,$escola->escola_id,$periodo->id"){$select='selected=selected';}else{$select='';}
		echo "<option value='modulo,$modulos->modulo_id,$curso->curso_id,$escola->escola_id,$periodo->id' style='margin-left:30px' $select>".$modulos->nome."</option>";
	
		$s_horario = mq($t=" SELECT * FROM escolar_horarios WHERE modulo_id = '$modulos->modulo_id' AND periodo_id='$periodo->id' AND curso_id='$curso->curso_id' AND escola_id='$escola->escola_id'");
		while($horarios=mf($s_horario)){
	    	if($_GET[filtro]=="horario,$horarios->id"){$select='selected=selected';}else{$select='';}
					 if(strlen($horarios->nome)>0){
						 $nome_h = $horarios->nome; 
					 }else{
					 	$nome_h = converte_numeros_comvirgula_em_dias_semanas($horarios->dias_semana ,$semana_abreviado)." ".substr($horarios->horario_inicio,0,5)." às ".substr($horarios->horario_fim ,0,5); 
					 }

			echo "<option value=horario,".$horarios->id." $select style='margin-left:40px'>".$nome_h."</option>";
		}
	  }
	}
  }
}
					?>
                </select>
                
                <script>
				<?
				if(strlen($_GET[filtro])==0){
				?>
                $("#filtro_x").val("periodo,<?=$ultimp_periodo?>");
				<?
				}
				?>
                </script>
            </label>
      
      <select name="tipo_matricula" class="tipo_matricula" id='tipo_matricula' style="margin-top:3px;" onchange="location='?tela_id=<?=$_GET[tela_id]?>&tipo_matricula='+this.value+'&filtro='+document.getElementById('filtro_x').value+'&pago='+document.getElementById('pago').value+'&busca='+document.getElementById('busca').value">
        <option value="Matricula" <? if($_GET[tipo_matricula]=='Matricula'){echo "selected='selected'";}?>>Matricula</option>
        <option value="Rematricula" <? if($_GET[tipo_matricula]=='Rematricula'){echo "selected='selected'";}?>>Rematricula</option>
      </select>
       
      <a href="<?php echo $caminho; ?>form.php?curso_id=<?php echo $_GET['curso_id']; ?>&modulo_id=<?php echo $_GET['modulo_id']; ?>" target="carregador" class="mais"></a>
      </div>
        
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
              <td width="30"><?php echo linkOrdem( "Tipo", "m.tipo_matricula", 0 ); ?></td>
                <td width="60">Matricula</td>
                <td width="200"><?php echo linkOrdem( "Nome", "a.nome", 1 ); ?></td>
                <td width="90"><?php echo linkOrdem( "CPF", "a.cpf", 0 ); ?></td>
                <td width="60">Idade</td>
                <td width="250">Escola</td>
                <td>Série</td>
            </tr>
        </thead>
    </table>
    
    
    <!--
        ///////////////////////////////////////
        Tabela de Dados
        ///////////////////////////////////////
    -->
<div id="dados">
    
	<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
    <?
    //pr($_POST);
	?>
        <table cellpadding="0" cellspacing="0" width="100%" id="lista">
            <tbody>
            
           <tr onclick="window.open('modulos/escolare/matriculas/form.php','carregador')">
            <td>R</td>
            <td onclick="o(815)">00815</td>
            <td>Gilvandro de Souza Silva</td>
            <td>732.735.722-53</td>
            <td>06</td>
            <td width="250">Escola  Municipal  Victorino Monteiro da Silva </td>
            <td>1º ano do 1º cilco</td>
            </tr>
           <tr  onclick="window.open('modulos/escolare/matriculas/form.php','carregador')">
             <td>M</td>
             <td onclick="o(815)">0516</td>
             <td onclick="l(Gilvandro de Souza Silva)">Dernando Cabral</td>
             <td>232.535.752-83</td>
             <td>06</td>
             <td>Escola Municipal Pedro Teixeira</td>
             <td>1º ano do 1º cilco</td>
           </tr>
            </tbody>
        </table>        
        
    </div>
    
    <!--
        ///////////////////////////////////////
        Linha de layout
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
               <td width="100%">&nbsp;</td>
            </tr>
        </thead>
    </table>

</div>

<!--
    ///////////////////////////////////////
    Rodapé
    ///////////////////////////////////////
-->
<?
/*

		$file = "modulos/administrativo/matriculas/arquivos/exportado".date('YMD')."_.csv";
		@unlink("$file");
		$handle = fopen($file, 'a');
		$infos = implode($linha_xls);
		fwrite($handle,$infos);
		fclose($handle);
*/

		

?>
<script>
function mudaTipo(t){
	tipo=t.value;
	if(tipo=='Jurídico'){
		$("#cpf").css('display','none');
		$("#cpf input").attr('disabled','disabled');
		$("#cpf input").removeAttr('retorno');
		$("#cpf input").removeAttr('valida_cpf');
		
		$("#cnpj").css('display','');
		$("#cnpj input").removeAttr('disabled');
	}
	if(tipo=='Físico'){
		$("#cnpj").css('display','none');
		$("#cnpj input").removeAttr('retorno');
		$("#cnpj input").attr('disabled','disabled');
		
		$("#cpf").css('display','');
		$("#cpf input").removeAttr('disabled');
	}
	
}
</script>
<div id="rodape" >

    
    </div>
