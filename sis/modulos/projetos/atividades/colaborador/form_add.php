<?
//Includes
// configuração inicial do sistema
include("../../../../_config.php");
// funções base do sistema
include("../../../../_functions_base.php");
// funções do modulo empreendimento
include("../_function_atividade.php");
include("../_ctrl_atividade.php"); 
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:700px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Atividade</span></div>
    </div>
	<form onSubmit="return validaForm(this)" autocomplete='off' class="form_float" method="post" target="carregador" action='modulos/projetos/atividades/colaborador/form_add.php?projeto_id=<?=$_GET[projeto_id]?>'>
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
            <a onclick="aba_form(this,0)" id='marcadoraba'><strong>Informa&ccedil;&otilde;es</strong></a>

		</legend>
        <input type="hidden" id="id" name="id" value="<?=$registro->id?>" />
        

        <label style="width:150px;">
			<strong style="display:block;">Cliente</strong>
<span><?=$razao_social?></span>
		</label>
        <label style="width:250px; " > Nome do Projeto
            
            <select name= 'projeto_id'>
            <?
$q=mysql_query($as="SELECT * FROM projetos WHERE vkt_id ='$vkt_id' ");
$i=0;
while($r= mysql_fetch_object($q)){
			if($r->id===$_GET[projeto_id]){ $select="selected='selected'";}else{$select='';}
	?>
    <option value="<?=$r->id?>"<?=$select?>><?=$r->nome?></option>
    <?
}
	?>
            </select>
     </label>
        
        
        <label style="width:150px; margin-right:0px;"   >Tipo Atividade
        	<select name="tipo_atividade_id">
            
            <? 
			$a_q = mysql_query("SELECT nome,id FROM projetos_atividades_tipos ");
			while($a=mysql_fetch_object($a_q)){ 
			
			if($a->id==$registro->atividade_tipo_id){ $select="selected='selected'";}else{$select='';}
			?>
            <option <?=$select?> value="<?=$a->id?>"><?=$a->nome?></option>
            <? } ?>
            </select>
        </label>
        

<!-- 
background:url(../fontes/img/st2.png);  -->
<div style="clear:both;"></div>
        <div id='formstar' style="<? if($registro->prioridade==1){echo "background:url(../fontes/img/st.png);";}else{echo "background:url(../fontes/img/st2.png);";}?> float: left; margin-top:14px; "><input style="width:auto" type="hidden" name="prioridade" value='<?=$registro->prioridade?>'></div><label style="width:590px; margin-right: 0px;display:block;" >Atividade<br>
          
          <input name="nome_atividade" id="nome_atividade" value="<?=$registro->nome;?>" style="font-size:16px;  width:564px; float:left" />
        </label>
        <div style="clear:both; width:100%"></div>
        <label style="width:600px;">
          Descricao
          <textarea name="descricao_atividade" id="descricao_atividade"><?=$registro->descricao;?></textarea>
		</label>
		<label style="width:50px;" >Tempo
               <input name="tempo" value="01:00" />
        </label>

        <label style="width:100px;" >
	Situa&ccedil;&atilde;o
       
       <select name="situacao">
<option <? if($registro->situacao=='0'){echo 'selected';} ?> value="0">Para ser executada</option>
 <option <? if($registro->situacao=='2'){echo 'selected';} ?> value="2">Em Andamento</option>
   <option <? if($registro->situacao=='2'){echo 'selected';} ?> value="3">Em Espera por alguem</option>
   <option <? if($registro->situacao=='1'){echo 'selected';} ?> value="1">Completo</option>
    
       </select>
		</label>
        
        
        <label style="width:150px;" >
        Quem executar&aacute;
          <select name="funcionario_id">
        <?
        $funcionarios_q=mysql_query("SELECT * FROM usuario WHERE cliente_vekttor_id ='$vkt_id'");
		while($f=mysql_fetch_object($funcionarios_q)){
			if($usuario_id==$f->id){ $select="selected='selected'";}else{$select='';}

		?>
        <option value="<?=$f->id?>"<?=$select?>><?=$f->nome?></option>
        <? } ?>
        </select>
        </label>
        <label style="width:150px;" >
        Quem &eacute; o Respons&aacute;vel
          <select name="usuario_id_cadastrou">
        <?
        $funcionarios_q=mysql_query("SELECT * FROM usuario WHERE cliente_vekttor_id ='$vkt_id'");
		while($f=mysql_fetch_object($funcionarios_q)){
			if($usuario_id==$f->id){ $select="selected='selected'";}else{$select='';}

		?>
        <option value="<?=$f->id?>"<?=$select?>><?=$f->nome?></option>
        <? } ?>
        </select>
        <div style="color:#CCC; font-size:10px">Somente o respons&aacute;vel poder&aacute; alterar os dados</div>
        </label>

        
        
        
        
        <label style="width:70px; margin-left:0px" >Data Limite
          <input name="data_limite" id="data_limite" value="<?=dataUsaToBr($registro->data_limite);  ?>" mascara='__/__/____' calendario='1' />
        </label>
            <input type="hidden" name="ordenacao_funcionario" id="ordenacao_funcionario" value="" />
      <div style="clear:both; width:100%"></div>
        <?
        if($registro->situacao==1){ 
		 ?>       
         Atividade concluida em 
		 <? if($registro->dias_concluidas>0){ 
		 		
		 ?> 
		      <strong><?=$registro->dias_concluidas;?></strong>   dias e 
         <? } ?>
		 <strong><?=substr($registro->horas_concluidas,0,5);?></strong> horas depois de ser cadastrada
         <?
		}
		 ?>
	</fieldset>
	<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($registro->id>0){
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
<script>
top.openForm();
top.document.getElementById('nome_atividade').focus();
top.document.getElementById('ordenacao_funcionario').value= top.document.getElementById('data_conclusao').getAttribute('ultima_ordem');
</script>