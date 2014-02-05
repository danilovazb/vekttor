<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
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
<div style="width:300px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>HORA EXTRA</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es</strong>
		</legend>
        <label style="width:210px;">
            <select name="funcionario_id" id='funcionario_id'>
			<?
            
            $rs=mysql_query("SELECT * FROM 
                                    rh_funcionario
                                    
                                  WHERE
                                    empresa_id='".$_GET['empresa1id']. "' AND 
                                    status!='demitidos' AND
                                    vkt_id='$vkt_id'
                                    $filtro
                                    ORDER BY nome
                                    ");
            while($r= mysql_fetch_object($rs)){
                
                if($_GET[funcionario_id]== $r->id){$selec ='selected="selected"';}else{$selec ='';}
            ?>
					<option  value="<?=$r->id?>" <?=$selec?>><?=$r->nome?></option>
    		<?
			}
			?>
</select>
		</label>
        
        <div style="clear:both"></div>
        
        <label style="width:90px;">
        	Selecione o Mês
			<select name="mes" id="mes">
            	
                <?
					$c=1;
					foreach($mes_extenso as $mes){
						echo "<option value='$c'>".$mes."</option>";
						$c++;
					}
				?>
                
            </select>
        </label>
        
        <label style="width:90px;">
        	Ano
			<input type="text" name="ano" id="ano" />
        </label>
              
	</fieldset>
	<input name="id" type="hidden" value="<?=$inss->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($inss->id > 0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input type="button" value="Lançar" style="float:right"  onclick="location='?tela_id=442&empresa1id=<?=$_GET[empresa1id]?>&ano='+$('#ano').val()+'&mes='+$('#mes').val()+'&funcionario_id='+$('#funcionario_id').val()+'&data=<?=$_GET['data']?>'"/>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>