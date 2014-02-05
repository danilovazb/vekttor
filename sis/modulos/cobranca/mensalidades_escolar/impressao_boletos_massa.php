<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>
<script src="<?=$caminho?>/mensalidade_escolar.js"></script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<a href="./" class='s1'>
  	Sistema NV
</a>
<a href="./" class='s2'>
    Cobrança 
</a>
<a href="?tela_id=37" class="navegacao_ativo">
<span></span><?=$tela->nome?> 
</a>
</div>
<div id="barra_info">
<form method="get" target="_blank" action="<?=$caminho?>/tela_impressao_massa.php">
<label style="width:90%">
            	
                <select name="filtro_x" id="filtro_x"  onchange="location='?tela_id=<?=$_GET[tela_id]?>&filtro='+this.value;">
                <option value="0" selected="selected">Seleciona o filtro</option>
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
  echo "<option value='periodo,$periodo->id' style='margin-left:0' $select>".$periodo->nome." </option>";
  
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
                
                
            </label>
            </form>
	
</div>
<?
	if($_GET[limitador]<1){
		$limitador= 30;	
	}else{
		$limitador= $_GET[limitador];
	}
    $qtd_selecionado[$limitador]= 'selected="selected"'; 
	
	if(strlen($_GET['filtro'])>0){
				
				$if = explode(',',$_GET[filtro]);
				//echo "entrou no filtro";
				if($if[0]=='periodo'){
					$add2.= "AND m.periodo_id = '{$if[1]}'  ";
					//echo "entrou no no filtro periodo";

				}
				if($if[0]=='escola'){
					$add2.= "AND m.periodo_id = '{$if[2]}' AND m.escola_id='{$if[1]}' ";
				}
				if($if[0]=='curso'){
					$add2.= "AND m.periodo_id = '{$if[3]}'  AND m.escola_id='{$if[2]}' AND m.curso_id='{$if[1]}' ";
				}
				if($if[0]=='modulo'){
					$add2.= "AND m.periodo_id = '{$if[4]}'  AND m.escola_id='{$if[3]}' AND m.curso_id='{$if[2]}'  AND m.modulo_id='{$if[1]}'";
				}
				if($if[0]=='horario'){
					$add2.= "AND m.horario_id = '{$if[1]}'  ";
				}
				
				 $busca_pago = " AND m.pago='N'";
            
				// necessario para paginacao
				$q = mysql_query ($t="
				SELECT
					COUNT(*)
				FROM
					financeiro_movimento as fm,
					(SELECT DISTINCT(id) as id FROM escolar_matriculas as m WHERE vkt_id='$vkt_id' $add2) as m
				WHERE
					fm.doc IN (m.id)
				")or die(mysql_error());
				 //echo $t;
				 $qtd=@mysql_result($q,0);
				
				
			}else{
//					$add2.= "AND m.periodo_id = '$ultimp_periodo'  	";
					$dis="disabled='disabled'";
				
			}
			
           
 ?>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="150">Número de boletos</td>
            <td width="200" align="center">Páginas a serem imprimidas</td>
            <td></td>
        </tr>
    </thead>
</table>
<script type="text/javascript">
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<form action="<?=$caminho?>/tela_impressao_massa.php" method="get" target="_blank">
<input type="hidden" name="filtro" value="<?=$_GET['filtro']?>" />
<table cellpadding="0" cellspacing="0" width="100%">
	<tbody>
   
    <tr>
    	<td width="150"><?=$qtd?></td>
        <td width="200" align="center"><input size="2" value="1" name="de" style="height:9px;" type="text"> a  <input size="2" style="height:9px;" name="ate" value="<?=ceil($qtd/3)?>" type="text"> de <? if($qtd<=3){echo 1;}else{echo ceil($qtd/3);}?></td>
        <td><input type="submit" name="cmd" value="Imprimir Boletos" <?=$dis?>></td>
        <td></td>
    </tr>
    </tbody>
</table>
</form>
</div>
</div>
<div id='rodape'>
	<?=$registros?> Registros 
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
