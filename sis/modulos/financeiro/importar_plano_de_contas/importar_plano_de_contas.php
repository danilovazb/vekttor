<?
$caminho =$tela->caminho; 
include("modulos/financeiro/_functions_financeiro.php");

include("_functions.php"); 
include("_ctrl.php"); 

	if($_GET[ano]){$ano=$_GET[ano];}else{$ano=date('Y');}
	if($_GET[mes]){$mes=$_GET[mes];if($_GET[mes]<10){$mes='0'.$mes;}}else{$mes=date('m');}
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
#container_grafico{position:absolute; top:10%; left:22%;display:none; border:1px solid #999; background:#FFF; margin-top:4px;width:790px;max-height:650px;-moz-box-shadow: 0 0 5px #888;-webkit-box-shadow: 0 0 5px#888;box-shadow: 0 0 5px #888;}
#container_grafico .close{color:#CCC;float:right;padding-right:10px;font-size:16px;}
#container_grafico .close:hover{cursor:pointer;}
#container_grafico span { color:#CCC; }
.btn-group{position: relative; display: inline-block;*display: inline;*margin-left: .3em;font-size: 0;white-space: nowrap;vertical-align: middle;*zoom: 1;}
.btn-group:first-child {*margin-left: 0;}
.btn-group + .btn-group {margin-left: 5px;}
.btn-group .btn{margin-left: 5px; padding:2px;}
.btn-group > .btn {position: relative;-webkit-border-radius: 0;-moz-border-radius: 0;border-radius: 0;}
.btn-group > .btn + .btn {margin-left: -1px;}
.btn-group + .btn-group {margin-left: 5px;}
.btn-group > .btn:last-child {-webkit-border-top-right-radius: 4px;border-top-right-radius: 4px;-webkit-border-bottom-right-radius: 4px;border-bottom-right-radius: 4px;-moz-border-radius-topright: 4px;-moz-border-radius-bottomright: 4px;}
.btn-group > .btn:first-child {margin-left: 0;-webkit-border-bottom-left-radius: 4px;border-bottom-left-radius: 4px;-webkit-border-top-left-radius: 4px;border-top-left-radius: 4px;-moz-border-radius-bottomleft: 4px;
 -moz-border-radius-topleft: 4px;}
.btn-group > .btn:hover,
.btn-group > .btn:focus,
.btn-group > .btn:active,
.btn-group > .btn.active {z-index: 3;}

/* para outra tela*/
@media only screen
and (min-width : 1440px) {
	#container_grafico{
		width:1100px;
		left:20%;
	}
}
</style>
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="?" class='s2'>
  	Financeiro
</a>
<a href="#" class='navegacao_ativo'>
<span></span>    Importar Plano de Contas
</a>
</div>
<div id="barra_info">
<input type="button" id="realizar_importacao" onclick="submitFormImportar();" name="action" value="Realizar Importação" style="float:right; " />
<form method="GET" id="form_grupos">
<label>
Modelos de Plano de Contas:
<select name="id_grupo" onchange="submitFormFiltro()" id="financeiro_centro_custo_modelo_grupo_id" >
	<option value="0">Selecionar grupo</option>
    <?
	$modelos_q=mysql_query("SELECT * FROM financeiro_centro_custo_modelo_grupo ");
    while($modelo=mysql_fetch_object($modelos_q)){
	?>
    <option <?=$select[$modelo->id]?> value="<?=$modelo->id?>"><?=$modelo->nome?></option>
    <?
	}
	?>
</select>
</label>
<input type="hidden" name="tela_id" value="<?=$tela->id?>" />
</label>

</form>
    
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
        	<td width="100">Importar</td>
            <td width="500"><?=linkOrdem("Identificação","nome",1)?></td>

          	<td class="wp"></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<div id="info_filtro">
</div>


<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<form method="post" id="form_planos_modelo">
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_valores">
    <tbody>
    
    <?
		function retornaFilhos($id,$tipo){
			
			$filho[]=$id;
			$q=mysql_query($tt="SELECT id FROM financeiro_centro_custo_modelo WHERE plano_ou_centro='$tipo' AND centro_custo_id='$id' ") or die(mysql_error());
			while($f=mysql_fetch_object($q)){
				$filho[]=$f->id;
				/*
				*/
				$filhos=mysql_query($t="SELECT id FROM financeiro_centro_custo_modelo WHERE centro_custo_id='{$f->id}' ");
				if(mysql_num_rows($filhos)>0){
					$filho=array_merge($filho,retornaFilhos($f->id,$tipo));
					
				}
				
			}
			return array_unique($filho);
		}	
	// necessario para paginacao
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="nome";
	}
	
	function listarCentros($id,$nivel,$pai,$filtro_modelo=""){
	global $total_entrada;
	global $total_saida;
	global $caminho;
	global $tabela; 
	global $plano_ou_centro;
	global $total;
	global $mes;
	global $ano;
	global $valorentrada;
	global $valorentrada_pai;
	global $valorsaida;
	global $valorsaida_pai;
	global $valorsaldo;
	global $valorsaldo_pai;
	global $valorsaldo_filho;
	global $valorplanejado;
	global $valorplanejado_pai;
	global $nomea;
	global $nomepai;
	global $nomefilho;
	global $valorplanejado_filho;
	global $pl_saldo;
	global $pl_planejado;
	
	$filtro_centro_custo=" AND centro_custo_id='$id' "; 
	// colocar a funcao da paginação no limite
	$q= mysql_query($trace="
	SELECT 
	 *
	FROM
		$tabela
	WHERE
		plano_ou_centro='$plano_ou_centro' 
	AND 
		cliente_id ='1'
	$filtro_centro_custo
	$filtro_modelo
	ORDER BY 
		ordem,nome") or die(mysql_error());
	while($r=mysql_fetch_object($q)){
		
		$temfilhos = count(retornaFilhos($r->id,'plano'));
		$pais_e_filhos=implode(',',retornaFilhos($r->id,'plano'));
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		
		if($_GET['centro']!=0){
			$filhos=implode(', ',retornaFilhos($_GET['centro'],'centro'));
		}
		
		?>
		
    	<tr <?=$sel?> >
        <td width="100">
        	<input type="checkbox" class="seleciona" name="selecionado[]" data-rel="<?=$r->centro_custo_id?>" value="<?=$r->id?>" />
            <input type="hidden"   name="plano_conta_id[]" value="<?=$r->id?>" />
            <input type="hidden"   name="plano_conta_pai_id[]" value="<?=$r->centro_custo_id?>" />
        </td>
          <td width="500" ><span style="margin-left:<?=$nivel*20?>px">
		 <?
                  $nomea[] = $r->nome;echo  $r->ordem." - ".$r->nome
                  ?> </span>
          </td>
<?
			
		$filhos_query=mysql_query($conta="
		SELECT 
			COUNT(*) as qtd 
		FROM 
			$tabela 
		WHERE 
			
			plano_ou_centro='$plano_ou_centro' 
		AND 
			cliente_id ='1'
		AND 
			centro_custo_id='{$r->id}' 
		");
		$filhos=mysql_fetch_object($filhos_query);
		
		?>
        	<td class="wp"></td>
        </tr>
		<?
			if($filhos->qtd>0){
				if(strlen($pai)>0){
					$ordenacao =$pai.'.'.$r->ordem;
				}else{
					$ordenacao =$r->ordem;
				}
				listarCentros($r->id,$nivel+1,$ordenacao);
			}
		
		
	}
	
	
}//fim function listarCentros

listarCentros(0,0,''," AND modelo_grupo_id='$modelo_grupo->id'");

?>
    	
    </tbody>
</table>
<input type="hidden" name="modelo_id" value="<?=$id_grupo?>" />
<input type="hidden" name="action" value="Realizar Importação" />
</form>
<table cellpadding="0" cellspacing="0" width="100%" >
    <thead>
    	<tr>
	        <td width="100"></td>
            <td width="500"></td>
          	<td class="wp"></td>
      </tr>
    </thead>
</table>
</div>

<div id="rodape_plano_contas">
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
	        <td width="100"></td>
            <td width="500">&nbsp;</td>
          	<td width=""></td>
      </tr>
    </thead>
</table>
</div>
</div>
<div id='rodape'>
	
</div>
<script>
$(".seleciona").change(seleciona);

function seleciona(){
	id=$(this).val()
	pai_id=$(this).attr('data-rel');
	filhos=$(".seleciona[data-rel='"+id+"']");
	pai=$(".seleciona[value='"+pai_id+"']");
	
	if($(this).is(':checked')){
		pai.each(recursivaMarcaPais);
		filhos.each(recursivaMarcaFilhos);
	}else{
		irmaos=$(".seleciona:checked[data-rel='"+pai_id+"']")
		console.log(irmaos.length)
		if(irmaos.length==0){
			pai.each(recursivaDesmarcaPais);
		}
		filhos.each(recursivaDesmarcaFilhos);
	}
}
function recursivaMarcaPais(){
	$(this).attr('checked',true)
	id=$(this).val()
	pai_id=$(this).attr('data-rel');
	pai=$(".seleciona[value='"+pai_id+"']");
	pai.each(recursivaMarcaPais);
}
function recursivaMarcaFilhos(){
	$(this).attr('checked',true)
	id=$(this).val()
	pai_id=$(this).attr('data-rel');
	filhos=$(".seleciona[data-rel='"+id+"']");
	filhos.each(recursivaMarcaFilhos);
}
function recursivaDesmarcaPais(){
	$(this).attr('checked',false)
	id=$(this).val()
	pai_id=$(this).attr('data-rel');
	pai=$(".seleciona[value='"+pai_id+"']");
	irmaos=$(".seleciona:checked[data-rel='"+pai_id+"']")
	if(irmaos.length==0){
		pai.each(recursivaDesmarcaPais);
	}
}

function recursivaDesmarcaFilhos(){
	$(this).attr('checked',false)
	id=$(this).val()
	pai_id=$(this).attr('data-rel');
	filhos=$(".seleciona[data-rel='"+id+"']");
	filhos.each(recursivaDesmarcaFilhos);
}

function submitFormImportar(){
	$("#form_planos_modelo").submit();
}
function submitFormFiltro(){
	if($("#financeiro_centro_custo_modelo_grupo_id").val()!='0'){
		$("#form_grupos").submit();
	}else{
		window.open("<?=$caminho?>form_grupo.php",'carregador')
	}
}
</script>