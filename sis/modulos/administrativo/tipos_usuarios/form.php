<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div id='aSerCarregado' >
<div>
<div >
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' style="float:right" onclick="form_x(this)"></a>
    
    <span>Tipos de Usuários</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" >
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
		<strong>Informações</strong>
		</legend>
		<label style="width:311px;">
			Tipo
			  <input type="text" id='nome' name="nome" value="<?=$usuario_tipo->nome?>" maxlength="44"/>
		</label>
        <div style="clear:both"></div>
        <? $sequencia1 = 0;
        $qasdas= mysql_query($trace="SELECT mm.* FROM usuario_tipo_modulo AS u, sis_modulos as m, sis_modulos as mm 
		WHERE u.usuario_tipo_id ='".$cliente_tipo_id."' 
		AND u.modulo_id=m.id 
		AND m.modulo_id=mm.id AND mm.modulo_id='0' group by m.modulo_id order by mm.ordem_menu ");
		//echo $trace;
		while($r=mysql_fetch_object($qasdas)){
			$sequencia1++;
			
			if($sequencia1==1){$some="";}else{$some="display:none";}
		?>
		<!--<fieldset id='campos_<?=$sequencia1?>' style="width:623px; <?=$some?>" >-->
			<!--<legend>Tipo de usuário</legend>-->
            
            <!-- INICIO ANTIGO  -->
            <!--<legend> <?
			$sequencia2=0;
			$q0= mysql_query($t="SELECT mm.* FROM usuario_tipo_modulo AS u, sis_modulos as m, sis_modulos as mm 
			WHERE u.usuario_tipo_id ='".$cliente_tipo_id."' AND u.modulo_id=m.id AND m.modulo_id=mm.id AND mm.modulo_id='0' group by m.modulo_id order by mm.ordem_menu");
			while($r0=mysql_fetch_object($q0)){
				$comparativo =$sequencia2+1;
				if($sequencia1==$comparativo){$ini='<strong>';$fim='</strong>';}else{$ini='';$fim='';}
			?>
			<a onclick="aba_form(this,<?=$sequencia2?>)"><?=$ini.$r0->nome.$fim?></a>
            <?
			$sequencia2++;
			}
			?> </legend>-->
				
               <!--<div class="divisao_options" style="display:none;">
                <!--  sempre usar um div pra dividir-->
					<!--<label style="width:259px">
						<input type="checkbox"  onclick="selall(this)" >
						Selecionar Todos
					</label><?
                $sequencia2=0;
                $q1= mysql_query($t="SELECT m.* FROM usuario_tipo_modulo AS u,sis_modulos as m WHERE u.usuario_tipo_id='$cliente_tipo_id' AND u.modulo_id=m.id AND   m.modulo_id ='$r->id'  ");
				//echo $t;
                while($r1=mysql_fetch_object($q1)){
					$seTem = @mysql_result(mysql_query($trace="SELECT modulo_id FROM usuario_tipo_modulo WHERE modulo_id ='$r1->id' AND usuario_tipo_id='$usuario_tipo->id'"),0,0);
					if($seTem>0){$check = 'checked="checked"';}else{$check ='';} ?>
					<!--<label style="width:259px">
						<input type="checkbox"  value="<?=$r1->id?>" name="modulo_id_id[]" <?=$check?> >
						<?=$r1->nome?>
					</label>-->
                <? } ?>
			  		<!--</div>-->
              <!--/.FINAL ANTIGO  -->
               
              <!-- NOVO -->
              <div style="float:left; width:200px;clear:none; background:#F2F2F2; border-radius:5px; margin-right:10px; padding:10px 0 10px 10px;" class='formcheck'>
                 <? 
                 $qasdas= mysql_query($trace="SELECT mm.* FROM usuario_tipo_modulo AS u, sis_modulos AS m, sis_modulos AS mm 
                 WHERE u.usuario_tipo_id ='".$cliente_tipo_id."' AND u.modulo_id=m.id AND m.modulo_id=mm.id AND mm.modulo_id ='0' group by m.modulo_id order by mm.ordem_menu ");
                  
                      while($modulo=mysql_fetch_object($qasdas)){ ?>
                          <a href="#" class='exibe_modulos' r='<?=$modulo->id?>'  style="text-decoration:none;color:black; display:block;"><?=$modulo->nome?></a>
                  <? } ?>
              </div> <!--/.formcheck-->
         
          	  <div class="divisao_options" style="float:left; width:380px;padding:10px; clear:none; height:380px; overflow:auto; background:#F2F2F2; border-radius:5px">
				<? // funcao submenu
                
				function submenusform($pai,$usuario_tipo_id,$nivel,$parentes=NULL){
                    global $usuario_tipo_id;
                    $nivel++;
                    $q1= mysql_query("SELECT * FROM sis_modulos WHERE modulo_id ='$pai'");
                     
                    $parentes = $parentes." sub$pai";
                    while($r1=mysql_fetch_object($q1)){
                        
                        $seTem = @mysql_result(mysql_query($t="SELECT modulo_id FROM usuario_tipo_modulo WHERE modulo_id ='$r1->id' AND usuario_tipo_id='$usuario_tipo_id'"),0,0);
                        $rs= mysql_fetch_object(mysql_query("SELECT * FROM sis_modulos WHERE modulo_id ='$r1->id' limit 1"));
                        
                        if($rs->id>0){$nome ="<strong>$r1->nome</strong>";}else{$nome ="$r1->nome";}
                        if($seTem>0){$check = 'checked="checked"';}else{$check ='';} ?>
                        
                        <label style="width:290px; margin-left:<?=(($nivel-1)*20)?>px">
                            <input type="checkbox"   value="<?=$r1->id?>" class="modulo_id <?=$parentes?>" name="modulo_id[]" <?=$check?>>
                            <?=$nome?>
                        </label>
                        <?
                        	submenusform($r1->id,$usuario_tipo_id,$nivel,$parentes);
                    }//fim while
                 }//fim funcao
    
                // chamdada submenu
                $qasdas= mysql_query($trace="SELECT * FROM sis_modulos WHERE modulo_id ='0' order by ordem_menu ");
                    while($modulo=mysql_fetch_object($qasdas)){
                        
                ?>
                <div id="div<?=$modulo->id?>" class='submodulos' style="display:none;float:left; ">
                    <div style="clear:both"></div>
                        <label style="width:159px">
                            <input type="checkbox"  id="marcarTodos">Marcar Todos
                            
                        </label>
                    <? submenusform($modulo->id,$tipo_usuario,0); ?>
                 </div>
                <? } ?>            
           </div> <!--/.FIM divisao_options -->
                
		<!--</fieldset>-->
        <?
		}
		?>
		<input name="usuario_tipo_id" type="hidden" value="<?=$usuario_tipo_id?>" />
         <div style="clear:both"></div>
          
          
        
	</fieldset>
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($usuario_tipo->id>0){
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
<script>top.openForm()</script>