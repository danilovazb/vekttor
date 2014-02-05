<?
//Includes
include("../../../../_config.php");
include("../../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>

<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div style="width:600px;">
<div>
	<div class='t3'></div>	
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Cálculo da média final</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
	<fieldset  id='campos_1' >
    <legend>
    <?
	$unidade=mysql_fetch_object(mysql_query("SELECT id,nome, formula_media FROM escolar2_unidades WHERE id='$unidade_id'")); 
	?>
			<a onclick="aba_form(this,0); document.getElementById('tipo_cadastro').value='Jurídico';"><strong><?=$unidade->nome?></strong></a>
		</legend>
        
        Defina a fórmula para o cálculo da média final dos alunos, utilizando os códigos referentes às médias dos períodos de avaliação e operações simples de matemática ( + - / * ).<br /><br />
		<? 	
		$periodos_avaliacao_q=mysql_query("SELECT * FROM escolar2_periodos_avaliacao WHERE vkt_id='$vkt_id' AND unidade_id='$unidade_id' ORDER BY nome ASC");
		while($p=mysql_fetch_object($periodos_avaliacao_q)){
			$ex[]='{'.$p->id.'}';
			$pa[$p->id]=$p->nome;
		}
		if(count($ex)>0){
		$formula_exemplo=@implode('+',$ex);
		foreach($pa as $i=>$v){
			
			?>
			média do <?=$v?>={<?=$i?>}<input type="hidden" class="periodo_avaliacao" value="<?=$i?>" title="<?=$v?>" /><br />
            <?
         }
		
		?>	<br />
        
		<label style="width:500px;">
        Exemplo: ( <?=$formula_exemplo?> )/<?=count($ex)?><br />
        	<input name="formula_media" value="<?=$unidade->formula_media?>" type="text">
        </label>
	</fieldset>
    
    
    
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($periodo->id>0){
	?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
	<?
	}
	?>
	<input name="id" type="hidden" value="<?=$unidade->id?>"/>
    <input name="action" type="submit"  value="Salvar Cálculo" style="float:right"  />
    <?
	}else{
		?>
        Para definir o cálculo da média final, é necessário <a href="#" onclick="window.open('modulos/escolar2/cadastros/periodos_avaliacao/form.php','carregador')">cadastrar no mínimo 1 período letivo</a>.
            <?
	}
	?>
	<div style="clear:both"></div>
	</div>
    
    
</form>
</div>
</div>
</div>
<script>top.openForm()</script>