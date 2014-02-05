<?php
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//pr($_POST);
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:700px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Itens do Menu</span></div>
    </div>
	<form onSubmit="return validaForm(this)" autocomplete='off' class="form_float" method="post">
    <input type="hidden" name="sys_modulos_id" id="sys_modulos_id" value="<?=$modulo->id?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1'>
		<legend>
			<a onclick="aba_form(this,0)"><strong>Informa&ccedil;&otilde;es</strong></a>
            <?php
				if($modulo->id>0){
            		echo "<a onclick='aba_form(this,1)'>Tutorial</a>";
				}
			?>
		</legend>
        
		<label style="width:250px;">
			Modulo
			 <select name="modulo_id" id="modulo_id">
             		
                    
                    <?
					
	function menu_submenu($modulo_id,$ident,$id){
		$sql = mysql_query("SELECT * FROM sis_modulos WHERE modulo_id='$modulo_id' ORDER BY ordem_menu ");
		
		$identador = $ident*10;
		$ident++;
		
		while($r=mysql_fetch_object($sql)){
				if($id ==$r->id && $r->id!='0'){$sel='selected="selected"';}else{$sel='';}
			
	?>
    <option <?=$sel;?>  value="<?=$r->id;?>" style="margin-left:<?=$identador?>px">
     <?
			echo $r->nome;
	
	?> 
    
    </option>
<?php
		menu_submenu($r->id,$ident,$id);
		}
	}	
	if($modulo->modulo_id=='0'){
		$selecionado='selected="selected"';
	}else{$selecionado='';}
	?>
    <option <?=$selecionado?> style="font-weight:bold;" value="0">
    Módulo Principal
    </option>
    <?
		if(isset($modulo->modulo_id))
			$id=$modulo->modulo_id;
	menu_submenu(0,0,$id);

                    		
					?>
                    	
             </select>
		</label>      
        
 		<div style="clear:both"></div>
        <label style="width:250px;">
          Nome Item
          	<input type="text" name="nome_item" id="nome_item" size="20" value="<?=$modulo->nome?>">
		</label>
        <div style="clear:both"></div>
         <label style="width:250px;">
          Tela:
          	<input type="text" name="tela" id="tela" size="20" value="<?=$modulo->tela?>">
		</label>
        <div style="clear:both"></div>
         <label style="width:250px;">
          Caminho
          	<input type="text" name="caminho" id="caminho" size="20" value="<?=$modulo->caminho?>" />
		 </label>
         <div style="clear:both"></div>
          <label style="width:100px;">
          Ordem Menu
          	<input type="text" name="ordem_menu" id="ordem_menu" size="20" value="<?=$modulo->ordem_menu?>" />
		 </label>
         <label style="width:100px;">
          A&ccedil;&atilde;o do Item
          	<select name="acao_menu" id="acao_menu">
            	<?php 
						if($modulo->acao_menu == "expande"){$sel_acao1 = 'selected="selected"';}
						if($modulo->acao_menu == "abre"){$sel_acao2 = 'selected="selected"';}
						if($modulo->acao_menu == "form"){$sel_acao3 = 'selected="selected"';}
						if($modulo->acao_menu == "interno"){$sel_acao4 = 'selected="selected"';}
						if($modulo->acao_menu == "blank"){$sel_acao5 = 'selected="selected"';}
				?>
            	<option <?=$sel_acao1?> value="expande">Expande</option>
                <option <?=$sel_acao2?> value="abre">Abre</option>
                <option <?=$sel_acao3?> value="form">Form</option>
                <option <?=$sel_acao4?> value="interno">Interno</option>
                <option <?=$sel_acao5?> value="blank">Blank</option>
            </select>
		</label>
                <div style="clear:both"></div>

        <label>
        
        <input type="checkbox" name="menu_escondido" value="1" <? if($modulo->menu_escondido==1){echo 'checked="checked"';}?> style="display:inline; width:20px"  /> Abrir com menu escondido
        </label>
		<div style="clear:both"></div>
	</fieldset>
    <fieldset  id='campos_2' style="display:none">
		<legend>
			<a onclick="aba_form(this,0)">Informa&ccedil;&otilde;es</a>
            <a onclick="aba_form(this,1)"><strong>Tutorial</strong></a>
            
		</legend>
         <!-- <label>
          	Nome
            <input type="text" name="nome_arquivo" id="nome_arquivo"/>
          </label>    
          <label>
          	Descriçao
            <input type="text" name="descricao_arquivo" id="descricao_arquivo"/>
          </label>
          <label style="width:150px;">
          	Arquivo
            <input type="file" name="arquivo" id="arquivo"/>
          </label>-->
          
		  <table cellpadding="0" cellspacing="0" width="100%" >
                <thead>
                        <tr>
                          <td width="80">Sequencia</td>
                          <td width="250">Titulo</td>
                          <td width="100">Arquivo 1</td>
                          <td width="100">Arquivo 2</td>                         
                          <td ><img src="../fontes/img/mais.png" id="add_arquivo"></td>                          
                        </tr>
               </thead>
			</table>
            <?php
				//selecina Tutorial do modulo
				$arquivos = mysql_query($t="SELECT * FROM sis_modulos_tutorial WHERE sis_modulo_id='$modulo->id'");				
			?>
            <div style="height:200px;">
            		<table cellpadding="0" cellspacing="0" width="100%" height="10%" id="tbl_arquivos">
                <tbody id="tbody">
                	   <?php
					  	while($arquivo=mysql_fetch_object($arquivos)){
													
					   ?>
                        <tr tutorial_id="<?php echo $arquivo->id?>" >
                          <td width="80" onclick="window.open('modulos/vekttor/item_menu/form_tutorial.php?id=<?php echo $modulo->id?>&tutorial_id=<?php echo $arquivo->id?>','carregador')">
						  	<?=$arquivo->sequencia?>
                          	<input type="hidden" name="tutorial_id[]" id="tutorial_id" value="<?php echo $arquivo->id?>" />
                          </td>
                          <td width="250" onclick="window.open('modulos/vekttor/item_menu/form_tutorial.php?id=<?php echo $modulo->id?>&tutorial_id=<?php echo $arquivo->id?>','carregador')"><?=$arquivo->titulo?></td>
                          <td width="100" onclick="window.open('modulos/vekttor/item_menu/form_tutorial.php?id=<?php echo $modulo->id?>&tutorial_id=<?php echo $arquivo->id?>','carregador')"><?=substr($arquivo->extensao1,-3)?></td>
                         <td width="100" onclick="window.open('modulos/vekttor/item_menu/form_tutorial.php?id=<?php echo $modulo->id?>&tutorial_id=<?php echo $arquivo->id?>','carregador')"><?=substr($arquivo->extensao2,-3)?></td>
                          <td><img src="../fontes/img/menos.png" id="remove_arquivo"></td>                          
                        </tr>
                   		<?php
						 }
						?>
                </tbody>
             </table>
            </div>
            <table cellpadding="0" cellspacing="0" width="100%" >
                <thead>
                        <tr>
                          <td width="80"></td>
                          <td width="250"><?=$arquivo->titulo?></td>
                          <td width="100"></td>
                          <td width="100"></td>
                          
                          <td></td>                          
                        </tr>
               </thead>
			</table>
           
	</fieldset>
       
	<input name="id" type="hidden" value="" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >


		<input name="action" type="submit" value="Excluir" style="float:left" />	

<input name="action" type="submit"  value="Salvar" style="float:right"  />
<?php  // $user = isset($db->user) ? $db->user : NULL;

?>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>