<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
include("_functions.php");
include("_ctrl.php");
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
</style>
<script type="text/javascript">
$(function(){
	$("tr:odd").addClass('al');
	/*.:some barra lateral :.*/
	some_menu();
	/*.: carrega janela :.*/
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		var exibe = $("#ModoExibe").val();
		window.open('modulos/escolar/aulas/form.php?id='+id+'&exibe='+exibe,'carregador');
	});
});
</script>
<div id='conteudo'>
<div id='navegacao'>
<div id="some">&laquo;</div>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>

<a href="" class='s1'>
  	Sistema NV
</a>
<a href="#" class='s2'>
    Escolar 
</a>
<a href="#" class="navegacao_ativo">
<span></span>Todas Aulas
</a>
</div>
<div id="barra_info">
<form action="" method="get">
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
    <input type="hidden" name="ModoExibe" id="ModoExibe" value="<?=$_GET['modo_exibe']?>">
    <!--<input type="text" name="dtaInicio" style="width:75px;"> &agrave; <input type="text" name="dtaFim" style="width:75px;">-->
    <!-- SELECT PARA AULA / AVALIAÇÕES -->
    <select name="modo_exibe">
    	<option <? if($_GET['modo_exibe'] == 1){echo 'selected="selected"';} ?> value="1">Aulas</option>
        <option <? if($_GET['modo_exibe'] == 2){echo 'selected="selected"';} ?> value="2">Avalia&ccedil;&otilde;es</option>
    </select>
    <!-- SELECT PARA TURMA -->
    <select name="turma_id" style="width:130px;">
        <option value="0">Turma</option>
		<?
        	$sqlTurma = mysql_query(" SELECT * FROM escolar_salas WHERE vkt_id = '$vkt_id' ORDER BY nome ASC");
			while($turmas=mysql_fetch_object($sqlTurma)){
				if($_GET['turma_id'] == $turmas->id){ $selt = 'selected="selected"';} else{$selt = "";}
		?>
        <option value="<?=$turmas->id?>" <?=$selt?>><?=$turmas->nome?></option>
        <?
			}
		?>    
    </select>
    <!-- SELECT PROFEESSOR --->
    <select name="professor_id" style="width:130px;">
        <option value="0">Professor</option>
        <?
        $sqlProf = mysql_query(" SELECT *,professor.id AS prof_id FROM escolar_professor AS professor JOIN cliente_fornecedor AS cliente ON professor.cliente_fornecedor_id = cliente.id  WHERE professor.vkt_id = '$vkt_id'");
			while($professores = mysql_fetch_object($sqlProf)){
				if($_GET['professor_id'] == $professores->prof_id){ $self = 'selected="selected"';} else{$self = "";}
		?>
        <option value="<?=$professores->prof_id?>" <?=$self?>><?=$professores->nome_fantasia?></option>
        <?
			}
		?>
    </select> 
    <!-- SELECT MATERIA -->
    <select name="materia_id" style="width:130px;" >
        <option value="0">Mat&eacute;ria</option>
        	<?
            	$sqlMateia = mysql_query(" SELECT DISTINCT nome,id FROM escolar_materias WHERE vkt_id = '$vkt_id' ORDER BY nome ASC");
				while($materias=mysql_fetch_object($sqlMateia)){
						if($_GET['materia_id'] == $materias->id){ $selm = 'selected="selected"';} else{$selm = "";}
			?>
            <option value="<?=$materias->id?>" <?=$selm?> ><?=$materias->nome?></option>
            <?
				}
			?>
    </select>
     -
    <input type="submit" value="Filtrar">
</form>  
</div>
<!--<div id="result"></div>-->
<input type="hidden" name="aula" id="aula" value="<?=$aula?>">
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	 <tr>
               <td width="50">N&ordm;</td>
               <td width="180">Descri&ccedil;&atilde;o</td>
               <td width="90">Turma</td>
               <td width="90">Mat&eacute;ria</td>
               <td width="90">Professor</td>
               <td width="70">Data</td>
               <td width="70">Aula</td>
               <td width="70">Per&iacute;odo</td>
               <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
      <?
	  	
		/*.: FILTRO PARA AULAS :.*/
		$filter = "";
      	if(!empty($_GET['dtaInicio']) and !empty($_GET['dtaFim'])){
			//$mes = " BETWEEN data  ";	
		}
		
		//filter materia
		if(!empty($_GET['materia_id'])){
			$filter .= " JOIN escolar_sala_materia_professor AS smp ON smp.id = currentTABLE.sala_materia_professor_id AND smp.materia_id = '".$_GET['materia_id']."' ";	
		}
		
		//filter professor
		if(!empty($_GET['professor_id'])){
				if($_GET['materia_id'] > 0)
						$filter .= " AND smp.professor_id = '".$_GET['professor_id']."' ";
				else
						$filter .= " JOIN escolar_sala_materia_professor AS smp ON smp.id = currentTABLE.sala_materia_professor_id AND smp.professor_id = '".$_GET['professor_id']."' ";	
		}
		
		//filter turma
		if(!empty($_GET['turma_id'])){
				if($_GET['materia_id'] > 0 || $_GET['professor_id'] > 0)
						$filter .= " AND smp.sala_id = '".$_GET['turma_id']."' ";
				else
						$filter .= " JOIN escolar_sala_materia_professor AS smp ON smp.id = currentTABLE.sala_materia_professor_id AND smp.sala_id = '".$_GET['turma_id']."' ";
		}
		
		$filtermes = " AND month(currentTABLE.data) = '".date('m')."' ";
		$filtervkt = " AND currentTABLE.vkt_id = '$vkt_id' ";
		
		/*.: FIM AULAS :.*/
		
		/*.:SQL:.*/
		$sql = " SELECT *,currentTABLE.id AS currentID FROM escolar_aula AS currentTABLE $filter WHERE 1 $filtermes $filtervkt ";
				
		if(!empty($_GET['modo_exibe'])){
				$exibicao = $_GET['modo_exibe'];
				if($_GET['modo_exibe'] == 2){
					$sql = " SELECT *,currentTABLE.id AS currentID FROM escolar_avaliacao AS currentTABLE $filter WHERE 1 $filtermes $filtervkt ";
				} else{
					$sql = " SELECT *,currentTABLE.id AS currentID FROM escolar_aula AS currentTABLE $filter WHERE 1 $filtermes $filtervkt ";			
				}	
		}
		
		
		$rows = mysql_query($sql);
			
		while($aulas=mysql_fetch_object($rows)){
			/* .:nome da turma :. */
			$smp = mysql_fetch_object(mysql_query($t=" SELECT * FROM escolar_sala_materia_professor AS smp 
													   JOIN escolar_salas AS sala ON smp.sala_id = sala.id 
													   WHERE smp.id = '$aulas->sala_materia_professor_id'"));
			/* .:outros:. */							   
			$professor_id = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_professor WHERE id = '$smp->professor_id'"));
			$professor = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$professor_id->cliente_fornecedor_id'")); 
			$periodo = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_periodicidade_avaliacao WHERE id = '$aulas->periodicidade_id'"));
			$materia = mysql_fetch_object(mysql_query(" SELECT * FROM  escolar_materias WHERE id = '$smp->materia_id'"));
			/*.::.*/
			if($aulas->status == 0){
				$cor =  "#09F";
			} else{ $cor = "#096";}
			
															
	  ?>
      <tr id="<?=$aulas->currentID?>">
          <td width="50"><?=$aulas->currentID?></td>
          <td width="180"><?=LimitarString($aulas->descricao,31);?></td>
          <td width="90"><?=LimitarString($smp->nome,14);?></td>
          <td width="90"><?=LimitarString($materia->nome,14);?></td>
          <td width="90"><?=LimitarString($professor->razao_social,15);?></td>
          <td width="70"><?=dataUsaToBr($aulas->data);?></td>
          <td width="70" style="color:<?=$cor?>;"><? if($aulas->status == 0){ echo "Aberta"; } else{ echo "Finalizada";} ?></td>
          <td width="70"><?=LimitarString($periodo->nome,11);?></td>
          <td></td>
      </tr>
      <?
		}
	  ?>
    </tbody>
</table>
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
	<?=$registros?> Registros 
    <?
	if($_GET[limitador]<1){
		$limitador= 30;	
	}else{
		$limitador= $_GET[limitador];
	}
    $qtd_selecionado[$limitador]= 'selected="selected"'; 
	?>
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador])?>
    </div>
</div>
