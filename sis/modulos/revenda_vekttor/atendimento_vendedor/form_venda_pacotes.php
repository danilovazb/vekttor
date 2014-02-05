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
<div style="width:710px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Venda de Pacotes</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" autocomplete='off'>
    <input type="hidden" name="id" id="id" value="<?=$equipamento->equipamento_id?>">
    
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset>
		 <legend>
            <a onclick="aba_form(this,0)"><strong>Pacote 1</strong></a>
    	 </legend>
	
    	   <div style="float:left; width:200px;clear:none">
           <?
            $qasdas= mysql_query($trace="SELECT * FROM sis_modulos WHERE modulo_id ='0' order by ordem_menu ");
            	while($modulo=mysql_fetch_object($qasdas)){
					
			?>
			<a href="#" class='exibe_modulos' r='<?=$modulo->id?>'  style="text-decoration:none;color:black; display:block;"><?=$modulo->nome?></a>
           	<?
				}
			?>
            </div>
            <div class="divisao_options" style="float:left; width:400px; clear:none">
  			<?
            $qasdas= mysql_query($trace="SELECT * FROM sis_modulos WHERE modulo_id ='0' order by ordem_menu ");
            	while($modulo=mysql_fetch_object($qasdas)){
					
			?>
            <div id="div<?=$modulo->id?>" class='submodulos' style="display:none;float:left; ">
            	<?
                $q1= mysql_query($t="SELECT * FROM sis_modulos WHERE modulo_id ='$modulo->id'");
                //alert($t);
				while($r1=mysql_fetch_object($q1)){
					
					$seTem = @mysql_result(mysql_query($t="SELECT modulo_id FROM usuario_tipo_modulo WHERE modulo_id ='$r1->id' AND usuario_tipo_id='$tipo_usuario->id'"),0,0);
					//echo $t;
					if($seTem>0){$check = 'checked="checked"';}else{$check ='';}
                ?>
					<label style="width:159px">
						<!--<input type="checkbox"  value="<?=$r1->id?>" class="modulo_id" name="modulo_id[]" <?=$check?>>-->
						<?=$r1->nome?>
					</label>
                    
                <?
				}
				
				?>
                <div style="clear:both"></div>
                    <label style="width:159px">
						<!--<input type="checkbox"  id="marcarTodos">Marcar Todos-->
						
					</label>
            </div>
           	<?
				}
			?>            
            </div>
      </fieldset>
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($equipamento->id > 0){
?>
<input name="action" type="submit" value="Excluir" id="Excluir" style="float:left" />
<?
}

?>

<input name="action" type="submit"  value="Salvar" id="Salvar" style="float:right"/>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>