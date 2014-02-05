<?
//Includes
// configuração inicial do sistema
include("../../../../_config.php");
// funções base do sistema
include("../../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:650px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Eventos</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Filtro de relatório de evento</strong>
		</legend>
        <label>
        Empresa
        	<select name="empresa_id" onchange="listaEventosEmpresa(this)">
            <option value="0">Todas as empresas</option>
            <?
			$empresas_q=mysql_query("SELECT *, cf.id as id FROM rh_empresas as re, cliente_fornecedor as cf WHERE re.vkt_id='$vkt_id' AND cf.id=re.cliente_fornecedor_id ORDER BY cf.razao_social ASC");
			while($empresa=mysql_fetch_object($empresas_q)){
            ?>
            <option value="<?=$empresa->id?>"><?=$empresa->razao_social?></option>
            <?
			}
            ?>
            </select>
        </label>
        <label>
        	Mês  
            <select name="mes">
            <? 
			$mes_atual = date('m');
			for($i=1;$i<13;$i++){
				if($mes_atual==$i){$sel="selected='selected'";}else{$sel='';}
			?>
            	<option <?=$sel?> value="<?=$i?>"><?=$mes_extenso[$i-1]?></option>
            <? 
			} 
			?>
            </select>
        </label>
        <label>
        	Ano<input sonumero="1" size="4" name="ano" value="<?=date('Y')?>" type="text" />
        </label>
		<div class="divisao_options">
	
	<div style="float:left; width:300px">
    <table cellspacing="0"  style="width:550px; ">
    	<thead>
        	<tr>
            	<td>Escolher</td>
            	<td>Evento</td>
                <td>Empresa</td>
                <td>Cargo</td>
                <td>Funcionário</td>
            </tr>
        </thead>
        <tbody style="background-color:white;">
    <?
	$eventos_q=mysql_query("
	SELECT 
		re.id as id,
		re.nome as nome,
		cf.nome_fantasia as empresa,
		rc.cargo as cargo,
		rf.nome as funcionario
	FROM 
		rh_eventos as re
	LEFT JOIN cliente_fornecedor as cf ON re.empresa_id=cf.id
	LEFT JOIN cargo_salario as rc ON re.cargo_id=rc.id
	LEFT JOIN rh_funcionario as rf ON re.funcionario_id=rf.id
	WHERE 
		re.vkt_id='$vkt_id' 
	ORDER BY 
		re.nome 
	ASC");
	echo mysql_error();
	while($evento=mysql_fetch_object($eventos_q)){
    ?>
    <tr>
    <td>
        <label style="clear:both;">
            <input class="evento_checkbox" data-rel="<?=$evento->empresa_id?>" name="eventos[]" value="<?=$evento->id?>" type="checkbox" >
           
        </label>
    </td>
    <td>
    	 <?
		 if($evento->nome!=''){
			echo $evento->nome;
			}else{
				echo "--";
			}
		 ?>
    </td>
    <td>
    <?
	if($evento->empresa!=''){
			echo $evento->empresa;
			}else{
				echo "--";
			}
	?>
    
    </td>
    <td>
    	<?
	if($evento->cargo!=''){
			echo $evento->cargo;
			}else{
				echo "--";
			}
	?>
    </td>
    <td>
    		<?
	if($evento->funcionario!=''){
			echo $evento->funcionario;
			}else{
				echo "--";
			}
	?>
    </td>
    </tr>
    <?
	}
    ?>
    	</tbody>
    </table>
    </div>
	
	
	<div style="clear:both"></div>
</div>
        
      
        
                
        
                
    </fieldset>
	<input name="filtro" type="hidden" value="1" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($evento->id > 0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input name="action" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>