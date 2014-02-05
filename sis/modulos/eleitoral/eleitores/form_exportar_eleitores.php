<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
// funções do modulo empreendimento
include("_function.php");
include("_ctrl.php");
$caminho = $tela->caminho;
//pr($_POST);
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:400px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    <span>Filtros</span></div>
    </div>
	<form onSubmit="return validaForm(this)" autocomplete='off' class="form_float" method="POST">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
        	<a onclick="aba_form(this,0)"><strong>Exportar Eleitores</strong></a>
        	
         </legend>
     
      <label style="width:200px;">Mes de Aniversariante
      	 	<select name="aniversariante" id="aniversariante">
            	<option value="todos">Todos</option>
                <option value="1">Janeiro</option>
                <option value="2">Fevereiro</option>
                <option value="3">Mar&ccedil;o</option>
                <option value="4">Abril</option>
                <option value="5" >Maio</option>
                <option value="6">Junho</option>
                <option value="7">Julho</option>
                <option value="8">Agosto</option>
                <option value="9">Setembro</option>
                <option value="10">Outubro</option>
                <option value="11">Novembro</option>
                <option value="12">Dezembro</option>
            </select> 
      </label>
      
      <div style="clear:both"></div>
      
      <div style="font-weight:bold;font-size:11px">FAIXA DE CEP</div>
      
      <label style="width:80px;">De
      	 	<input type="text" name="cep_inicio" id="cep_inicio" mascara="_____-___" sonumero="1" style="width:80px;"/>
      </label>
      
      <label style="width:80px;">
      				Até
                  <input type="text" name="cep_fim" id="cep_fim" mascara="_____-___" sonumero="1" style="width:80px;"/>
      </label>
      
      <div style="clear:both"></div>
      <!-- SELECT GRUPO SOCIAL -->
      <label style="width:150px;">Grupo Social
      		<select name="grupo_social_id" id="grupo_social_id">
            <option value="0">Todos</option>
            		<? 
					$sqlSocial = mysql_query(" SELECT * FROM eleitoral_grupos_sociais WHERE vkt_id = '$vkt_id'"); 
						while($grupo=mysql_fetch_object($sqlSocial)){
					?>
            	<option value="<?=$grupo->id?>"><?=$grupo->nome;?></option>
            		<?
						}
					?>
            </select>
      </label>
      
      <div style="clear:both"></div>
      <!-- SELECT REGIÃO -->
      <label style="width:150px;">Regi&atilde;o
      		<select name="regiao_id" id="regiao_id">
            	<option value="0">Todas</option>
                <?
                	$sqlRegiao = mysql_query(" SELECT * FROM eleitoral_regioes WHERE vkt_id = '$vkt_id' ");
						while($regiao=mysql_fetch_object($sqlRegiao)){
				?>
                <option value="<?=$regiao->id?>"><?=$regiao->descricao?></option>
                <?
						}
				?>
            </select>
      </label>
      
      <div style="clear:both"></div>
      <label style="width:150px;">Estado
       		<?php
             	$estados = mysql_query("SELECT DISTINCT(estado) FROM eleitoral_eleitores WHERE estado!='' AND estado!='null'");	
      		?>
			<select name="estado" id="estado">
            	<option value="">Todos</option>
                <?
                	while($estado=mysql_fetch_object($estados)){
				?>
                <option value="<?=$estado->estado?>"><?=$estado->estado?></option>
                <?
					}
				?>
            </select>
      </label>
      
      <div style="clear:both"></div>     
       <label style="width:150px;">Cidade
       		<?php
             	$cidades = mysql_query("SELECT DISTINCT(cidade) FROM eleitoral_eleitores WHERE cidade!='' AND vkt_id='$vkt_id'");	
      		?>
			<select name="cidade" id="cidade">
            	<option value="">Todas</option>
                <?
                	while($cidade=mysql_fetch_object($cidades)){
				?>
                <option value="<?=$cidade->cidade?>"><?=$cidade->cidade?></option>
                <?
					}
				?>
            </select>
      </label>
      
            
      <div style="clear:both"></div>     
      <!-- SELECT BAIRRO -->
      <label style="width:150px;">Bairro
      		<select name="bairro" id="bairro">
            	<option value="0">Todos</option>
                <?
                	$sqlBairro=mysql_query(" SELECT * FROM eleitoral_bairros WHERE vkt_id = '$vkt_id' ");
						while($bairro=mysql_fetch_object($sqlBairro)){
				?>
                <option value="<?=$bairro->nome?>"><?=$bairro->nome?></option>
                <?
						}
				?>
            </select>
      </label>
      
      <div style="clear:both"></div>     
      <!-- SELECT PROFISSAO -->
      <label style="width:150px;">Profiss&atilde;o
      		<select name="profissao_id">
            	<option value="0">Todas</option>
                <?
                		$sqlProfissao = mysql_query(" SELECT * FROM eleitoral_profissoes WHERE vkt_id = '$vkt_id'");
							while($profissao=mysql_fetch_object($sqlProfissao)){
				?>
                <option value="<?=$profissao->id?>"><?=$profissao->descricao?></option>
            	<?
							}
				?>
            </select>
      </label>
      
      <div style="clear:both"></div>         
   	  
      <label style="width:150px;">Sexo
      		<select name="sexo" id="sexo">
            	<option value=""></option>
                <option value="m">Masculino</option>
                <option value="f">Feminino</option>
            </select>
      </label>
      
      <div style="clear:both"></div> 
      
      <input type="radio" name="opcao[]" value="2" class="opcao" checked="checked">Telefone
      <input type="radio" name="opcao[]" value="1" class="opcao">Email
      
       
       <div style="clear:both;margin-bottom:10px;"></div>
       
       <div style="float:left">Exibir de</div>
       <div style="float:left;margin-left:10px;">
       <?php
	   	$qtd_registros = mysql_result(mysql_query($t="SELECT 
	COUNT(*) as qtd
	
FROM 
	eleitoral_eleitores as e
WHERE 
	e.vkt_id='$vkt_id' AND
	(telefone1 !='' OR telefone2 !=''
	OR email!='')"),0,0);
		//$qtd_eleitores = mysql_num_rows($qtd_eleitores);
	   ?>
       <label style="width:50px;">
       	<input type="text" name="qtd_registros_inicio" id="qtd_registros_inicio" value="1"/>
       </label>
       <div style="float:left;margin-right:10px;">Até</div>
       <label style="width:50px;">
       	<input type="text" name="qtd_registros" id="qtd_registros" value="<?=$qtd_registros?>"/>
       </label>
       </div>
       Registros
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
<input type="submit" name="action" value="Exportar" style="float:right">
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>