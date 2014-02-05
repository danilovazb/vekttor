<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
include("../../../../_config.php");
include("../../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<script>
	function checa_cpf(t){
		
	ultima = t.value.substr(13,1);
	
	//alert(id);
		if(ultima!='_' && t.value.length=='14' ){
			window.open('modulos/escolar/professor/form.php?cnpj_cpf='+t.value,'carregador')	
		}
	}
</script>
<style>
table#tabela_dados tbody tr td:hover{background:none; color:inherit;}
table#tabela_dados tbody tr td{margin:0px; padding:0px; font-size:14px;}
table#tabela_dados tbody tr{
	background:#7F7F7F;
	color:#FDFDFD;
   /*background-image: -webkit-gradient(linear, 0 top, 0 bottom, from(#CCC), to(#666));*/
}
table#tabela_dados tbody tr#pergunta{background:#F4F4EA; color:#F7F7EE;  color:#333333; }
table#tabela_dados tbody tr#pergunta div strong{padding-left:3px; font-size:13px;}
</style>
<a href="?tela_id=232" class='s2'>
    Escolar 
</a>
<a href="?tela_id=294" class="navegacao_ativo">
<span></span>Mensagens Privadas
</a>
</div>
<div id="barra_info">
	<input type="button" value="<<" onclick="location.href='?tela_id=294'">	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
   <td ></td>
   
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" style="margin:0px;">
    <tbody>
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND u.nome like '%{$_GET[busca]}%'";
	}
	
	
	// necessario para paginacao
    $registros= @mysql_result(mysql_query($t="SELECT p.*,p.id as id,c.*,u.* FROM escolar_professor p 
						INNER JOIN cliente_fornecedor c ON p.cliente_fornecedor_id =c.id
						INNER JOIN usuario u ON p.usuario_id =u.id
						WHERE p.vkt_id='$vkt_id' $busca_add"),0,0);
   //echo $t;

	// colocar a funcao da paginação no limite
	$q= mysql_query($t="SELECT * FROM escolar_mensagens_privadas
					WHERE  mensagem_origem_id=".$_GET['id']."
					OR id=".$_GET['id']." AND vkt_id='$vkt_id' ORDER BY id");
	//echo $t;
	//if(mysql_num_rows($q)>0){
	while($r=mysql_fetch_object($q)){
		 $hora=explode(" ",$r->data_envio);
		 $hora=$hora[1];
		 echo "<tr>
               <td>
               	<div style='padding:6px; float:left;'>
                	<strong>Postada em :</strong> ".DataUsaToBr($r->data_envio)." - <strong>Hora</strong>:$hora 
				</div>
				";
		if(!empty($r->extensao)){
		echo "<a href='modulos/escolar/area_aluno/aulas/arquivos/$r->id$r->extensao' style='float:right;color:white' target='_blank' 
				>Baixar Arquivo</a>";
		}
		echo"
                </td>
            </tr>";
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		echo "<tr id='pergunta' style=' border:1px solid #CCC;'>";
		if($r->aluno_id==$r->de){	
		    echo "<td style='border:1px solid #CCC;'><strong>Voce:</strong> ".$r->mensagem."
			
			<div style='float:left; width:140px; height:160px; border-right:1px solid #CDCDCD; padding:8px; margin:8px;'>
            
			<div style='background:url(modulos/escolar/alunos_inscritos/img/$aluno->id.$aluno->extensao) 50px; width:110px; height:140px; 	                                   background-position:center;  box-shadow:1px 1px 1px #666;'>
			
			</div>
			</td>";
		
		}else{
			echo "<td style='border:1px solid #CCC;'><strong>$professor->razao_social: </strong>".$r->mensagem."
			
			<div style='float:left; width:140px; height:160px; border-right:1px solid #CDCDCD; padding:8px; margin:8px;'>
            
			<div style='width:130px;  margin-left:-8px; text-align:center'>
				
			</div>
			
			</div>
			
			</td>";
		}
		echo "</tr>";
	}		
	?>	
    </tbody>
</table>
	<br><br><br>
    <form onsubmit="return validaForm(this)" class="form_float"  method="post" enctype="multipart/form-data">
	
	Enviar<br>
	<textarea rows="10" cols="50" name="mensagem"></textarea>
    <br>
    Anexo
     <input type="file" name="arquivo" id="arquivo" value="<?=$mensagem->extensao?>" />
     <input type="hidden" name="aula_id" value="<?php echo $aula->id ?>" />
      <input type="hidden" name="materia_id" value="<?php echo $materia->id ?>" />
      <input type="hidden" name="professor_id" value="<?php echo $professor->id ?>" />
      <input type="hidden" name="aula" value="<?php echo $aula->descricao ?>" />
      <input type="hidden" name="sala_id" value="<?php echo $mensagem->sala_id?>" />
      <input type="hidden" name="mensagem_id" value="<?php echo $_GET['id']?>" />
      <input type="hidden" name="aluno_id" value="<?php echo $aluno->id?>" />  
	<br>
	<input name="acao" type="submit" value="Salvar"/>  
	<input type="hidden" name="mensagem_origem" value="<?=$_GET['id'];?>" />
    </form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">&nbsp;</td>
           <td width="230"><a>Total: <?=$total?></a></td>
           <td width="130">&nbsp;</td>
           <td width="110">&nbsp;</td>
           <td width="80">&nbsp;</td>
		   <td width="110">&nbsp;</td>
           <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
</div>