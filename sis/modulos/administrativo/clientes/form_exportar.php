<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_function_atividade.php");
include("_ctrl_atividade.php");
$caminho = $tela->caminho;
pr($_POST);
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
    <span>Filtros Clientes</span></div>
    </div>
	<form onSubmit="return validaForm(this)" action="<?=$caminho?>modulos/administrativo/clientes/relatorio_clientes.php" autocomplete='off' target="_blank" class="form_float" method="GET">
    <input type="hidden" name="tipo" value="<?=$_GET["tipo"]?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend><strong>Filtro</strong></legend>
     
      <label style="width:200px;">Mes de Aniversariante
      	 	<select name="aniversariante" id="aniversariante_1">
            	<option value="0">Todos</option>
                <option value="01">Janeiro</option>
                <option value="02">Fevereiro</option>
                <option value="03">Mar&ccedil;o</option>
                <option value="04">Abril</option>
                <option value="05" >Maio</option>
                <option value="06">Junho</option>
                <option value="07">Julho</option>
                <option value="08">Agosto</option>
                <option value="09">Setembro</option>
                <option value="10">Outubro</option>
                <option value="11">Novembro</option>
                <option value="12">Dezembro</option>
            </select> 
      </label>
      
      <div style="clear:both"></div>
      <!-- SELECT GRUPO SOCIAL -->
      <label style="width:150px;">Grupo
      		<select name="grupo_id" id="grupo_id">
            <option value="0">Todos</option>
            		<? 
					$sqlSocial = mysql_query(" SELECT * FROM cliente_fornecedor_grupo WHERE vkt_id = '$vkt_id'"); 
						while($grupo=mysql_fetch_object($sqlSocial)){
					?>
            	<option value="<?=$grupo->id?>"><?=$grupo->nome;?></option>
            		<?
						}
					?>
            </select>
      </label>
      
      <!--<div style="clear:both"></div>
      <!-- SELECT REGIÃO -->
      <!--<label style="width:150px;">Regi&atilde;o
      		<select name="regiao_id" id="regiao_id">
            	<option value="0">Todas</option>
                <?
                	/*$sqlRegiao = mysql_query(" SELECT * FROM eleitoral_regioes WHERE vkt_id = '$vkt_id' ");
						while($regiao=mysql_fetch_object($sqlRegiao)){*/
				?>
                <option value="<?$regiao->id?>"><?$regiao->descricao?></option>
                <?
						//}
				?>
            </select>
      </label>-->
      
      <div style="clear:both"></div>     
      <!-- SELECT BAIRRO -->
      <label style="width:150px;">Bairro
      		<select name="bairro" id="bairro">
            	<option value="0">Todos</option>
                <?
                	$sqlBairro=mysql_query(" SELECT DISTINCT(bairro) FROM  cliente_fornecedor WHERE cliente_vekttor_id = '$vkt_id' ");
						while($bairro=mysql_fetch_object($sqlBairro)){
				?>
                <option value="<?=$bairro->bairro?>"><?=utf8_encode($bairro->bairro)?></option>
                <?
						}
				?>
            </select>
      </label>
      
      <div style="clear:both"></div>     
      <!-- SELECT PROFISSAO -->
      <label style="width:150px;">Ramo de Atividade
      		<select name="ramo" id="ramo">
            	<option value="0">Todas</option>
                <?
                		$sqlProfissao = mysql_query(" SELECT DISTINCT(ramo_atividade) FROM cliente_fornecedor WHERE cliente_vekttor_id = '$vkt_id'");
							while($ramoAtividade=mysql_fetch_object($sqlProfissao)){
				?>
                <option value="<?=utf8_encode($ramoAtividade->ramo_atividade)?>"><?=utf8_encode($ramoAtividade->ramo_atividade)?></option>
            	<?
							}
				?>
            </select>
      </label>
      <div style="clear:both"></div>         
   	  <input type="checkbox" name="email" value="1">Email<br>
      <input type="checkbox" name="endereco" value="1">Endere&ccedil;o<br>
       <input type="checkbox" name="telefone" value="1">Telefone<br> 
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
<input type="submit" name="exibir" value="Exibir">
<input type="submit" name="etiqueta" value="Etiqueta">
<input type="submit" name="exportar" value="Exportar">
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>