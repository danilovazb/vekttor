<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho; 

include ("_functions.php");
include ("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
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

function om(id){
	window.open('modulos/escolar/matriculas/form.php?matricula_id='+id,'carregador');
}

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
        
        <a href="./" class='s2'>Administrativo</a>
        <a href="?tela_id=217" class="navegacao_ativo"><span></span>Matrículas</a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
    


<div style="float:left; "><a target="_blank" href="modulos/financeiro/retorno_banco/arquivos_retorno/<?=$_GET[retorno_id]?>.ret">Aquivo</a>  </div>  
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
                <td>HorarioDia Selec</td>
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
            
            <?php
            
				
		  /*
		  filtro
		  periodo,$periodo->id
		  escola,$escola->escola_id,$periodo->id
		  curso,$curso->curso_id,$escola->escola_id,$periodo->id
		  modulo,$modulos->modulo_id,$curso->curso_id,$escola->escola_id,$periodo->id
		  horario,$horarios->id
		  */
            $q = mysql_query ($t="SELECT
			COUNT(*)
FROM
	escolar_matriculas m
WHERE
	m.vkt_id='$vkt_id'
	AND
	m.arquivo_retorno_id ='".$_GET[retorno_id]."'
 
 ")or die(mysql_error());
// echo $t.'<br><br>';
            $registros = mysql_result ($q,0,0);
            
            if( $_GET['ordem'] ){
                $ordem = $_GET['ordem'];
            } else {
                $ordem = "m.escola_id ,m.curso_id , m.modulo_id , m.horario_id, m.sala_id  ";
            }
            
            // colocar a funcao da paginação no limite
            $q= mysql_query($t="
SELECT
	m.*,
	m.id matricula_id,
	m.pago matricula_pago, 
	m.sala_id sala,
	m.tipo_matricula tipo,
	m.sala_id
FROM
	escolar_matriculas m
WHERE

	m.vkt_id='$vkt_id'	
	AND
	m.arquivo_retorno_id ='".$_GET[retorno_id]."'

") or die ( mysql_error() );
// echo "<PRE>$t</PRE>";
 			$alteralinha ="0";



           while( $r=mysql_fetch_object($q)){
			   $l++;
				if($l%2){
					$cl= 'class="al"';
				}else{
					$cl= 'class="dl"';
				}
				
				$aluno 		= mysql_fetch_object(mysql_query("select a.*,	a.data_nascimento,
		(YEAR(CURDATE())-YEAR(a.data_nascimento))
		- (RIGHT(CURDATE(),5)< RIGHT(a.data_nascimento,5))
		AS age
 from escolar_alunos as a WHERE a.id='$r->aluno_id'"));
				$escola		= mysql_fetch_object(mysql_query("select * from escolar_escolas 	WHERE id='$r->escola_id'"));
				$curso		= mysql_fetch_object(mysql_query("select * from escolar_cursos 		WHERE id='$r->curso_id'"));
				$modulo		= mysql_fetch_object(mysql_query("select * from escolar_modulos 	WHERE id='$r->modulo_id'"));
				$horario	= mysql_fetch_object(mysql_query("select * from escolar_horarios 	WHERE id='$r->horario_id'"));
				$responsavel= mysql_fetch_object(mysql_query("select * from cliente_fornecedor 	WHERE id='$r->responsavel_id'"));
				$sala		= mysql_fetch_object(mysql_query("select * from escolar_salas 		WHERE id='$r->sala_id'"));
				
           ?><tr <?php echo $cl; ?> id='<?=$r->matricula_id?>' onclick="om(<?=$r->matricula_id?>)">
            <td><?=substr($r->tipo,0,1); ?></td>
            <td ><?php echo $r->matricula_id; ?></td>
            <td ><?php echo $aluno->nome; ?></td><td><?php echo $r->aluno_cpf; ?></td><td><?php echo $aluno->age ?></td><td><?=dataUsaToBr($r->data_vencimento)?> :  <?=$escola->nome." - ".$curso->nome." - ".$modulo->nome." - $sala->nome - ".$horario->nome ?></td></tr>
<?php
            }
            ?>	
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
<div id="rodape" >

    </div>
