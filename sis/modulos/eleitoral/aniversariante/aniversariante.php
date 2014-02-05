<?php
$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho; 

//include ("_functions.php");
//include ("_ctrl.php");
$mes_corrente = "AND MONTH(ea.data_nascimento) = '".date('m')."'";
$ano_corrente = date('Y');
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){
			$("tr:odd").addClass('al');
});

$(".remove_imagem").live("click", function(){
	aluno_id= $(this).attr('aluno_id');
	window.open('?tela_id=215&deleta_imagem='+aluno_id,'carregador');
	
	$("#img_curso").hide(200);
	
});

$("#exportar_aniversariantes").live('click',function(){
	data_ini = $("#data_ini").val();
	data_fim = $("#data_fim").val();
	window.open('modulos/eleitoral/aniversariante/exportar_aniversariantes.php?data_ini='+data_ini+'&data_fim='+data_fim);	
});
</script>

<div id="conteudo">
	<!--
        ///////////////////////////////////////
        Barra de Navegação
        ///////////////////////////////////////
    -->
    <div id="navegacao">
        <form class='form_busca' action="" method="get">
             <a></a>
            <input type="hidden" name="limitador" value="<?php echo $_GET['limitador']; ?>" />
            <input type="hidden" name="tela_id" value="<?php echo $_GET['tela_id']; ?>" />
            <input type="hidden" name="pagina" value="<?php echo $_GET['pagina']; ?>" />
            <input type="text" value="<?php echo $_GET[busca]; ?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
        </form>
        
         <div id="some">&laquo;</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="../../../../../inscricao_online/sis/modulos/administrativo/alunos_inscritos/?tela_id=221" class="navegacao_ativo"><span></span>Aniversariantes</a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
        <!--<a href="modulos/escolar/alunos_inscritos/form.php" target="carregador" class="mais"></a>-->	
 <form  method="get">
<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
        <label>De: 
	<input name="data_ini" id="data_ini" style="width:80px; height:12px;" mascara='__/__/____' type="text" value="<?=$_GET['data_ini']?>" calendario='1' sonumero='1' />
</label> 
<label>At&eacute;: 
	<input name="data_fim" id="data_fim" type="text" style="width:80px; height:12px;" mascara='__/__/____' sonumero='1' calendario='1' value="<?=$_GET['data_fim']?>" />
</label> 

<input type="submit" value="Filtrar" />

<?php
if(!empty($_GET['data_ini'])&&!empty($_GET['data_fim'])){
	echo "Per&iacute;odo: ".$_GET['data_ini']." &agrave; ".$_GET['data_fim'];
}else{
	echo "Per&iacute;odo: ". date('d')."/".date('m');
}
?> 
<input type="button" id="exportar_aniversariantes"  value="Exportar Telefones" style="float:right;margin-top:3px;"/>
</form>
    </div>
        
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="260"><?php echo linkOrdem( "Nome", "nome", 1 ); ?></td>
                <td width="250"><?php echo linkOrdem( "E-mail", "E-mail", 0); ?></td>
                <td width="90"><?php echo linkOrdem( "CPF", "cpf", 0 ); ?></td>
                <td width="80"><?php echo linkOrdem( "Nascimento", "data_nascimento", 0); ?></td>
                <td width="80"><?php echo linkOrdem( "Telefone", "Telefone", 0); ?></td>
                <td width="50">Idade</td>
                <td></td>
            </tr>
        </thead>
    </table>
    
    
    <!--
        ///////////////////////////////////////
        Tabela de Dados
        ///////////////////////////////////////
    -->
    <div id="dados">
    
		<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
        <table cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            
            <?php
				if(empty($_GET['limitador'])){
					$limitador_p = 100;
				}else{
					$limitador_p = $_GET['limitador'];
				}
				
				if(!empty($_GET['data_ini'])&&!empty($_GET['data_fim'])){
					$data_inicio = explode("/",$_GET['data_ini']);
					$data_fim    = explode("/",$_GET['data_fim']);
					$dia_inicio  = $data_inicio[0];
					$mes_inicio  = $data_inicio[1];
					$dia_fim     = $data_fim[0];
					$mes_fim     = $data_fim[1];
					
					$filtro = "AND MONTH(data_nascimento) BETWEEN $mes_inicio AND $mes_fim AND DAY(data_nascimento) BETWEEN $dia_inicio AND $dia_fim";
				}else{
					$dia = date('d');
					$mes = date('m');
					$filtro = " AND day(data_nascimento) = '$dia' AND month(data_nascimento) = '$mes'";
			}
           		
				 $registros= mysql_result(mysql_query($t="SELECT COUNT(*) FROM eleitoral_eleitores WHERE vkt_id = '$vkt_id' $filtro "),0,0);
				$sql = mysql_query($t="SELECT * FROM  eleitoral_eleitores WHERE vkt_id = '$vkt_id' $filtro ORDER BY data_nascimento LIMIT ".paginacao_limite($registros,$_GET[pagina],$limitador_p));
				//echo $t;
           		//echo $t;
            // colocar a funcao da paginação no limite
            /*$q= mysql_query("SELECT * FROM alunos $busca_add ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador])) or die ( mysql_error() );*/
            
            while($r=mysql_fetch_object($sql)){
				$nascimento = explode("-",$r->data_nascimento);
				$idade = ($ano_corrente - $nascimento[0]);
                
            ?>
            
                <tr <?php echo $cl; ?>>
                    <td width="260"><?php echo $r->nome;?></td>
                    <td width="250"><?php  echo $r->email; ?></td>
                    <td width="90"><?php echo $r->cpf; ?></td>
                    
                    <td width="80"><?php echo dataUsaToBr($r->data_nascimento)?></td>
                    <td width="80"><?php  if(!empty($r->telefone1)){ echo $r->telefone1;}else{echo $r->telefone2;} ?></td>
                    <td width="50"><?php echo $idade;?></td>
                    <td></td>
                </tr>
            <?php
              }
            ?>	
            </tbody>
        </table>
        
    </div>
    
    <!--
        ///////////////////////////////////////
        Linha de layout
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
               <td width="100%">&nbsp;</td>
            </tr>
        </thead>
    </table>

</div>

<!--
    ///////////////////////////////////////
    Rodapé
    ///////////////////////////////////////
-->
<div id='rodape'>
	<?=$registros?> Registros 
    <?
	
	if($_GET[limitador]<1){
		$limitador= 100;	
	}else{
		$limitador= $_GET[limitador];
	}
    $qtd_selecionado[$limitador]= 'selected="selected"'; 
	if(!isset($_GET['estoque_minimo'])){
		$estoque_minimo='false';
	}else{
		$estoque_minimo=$_GET['estoque_minimo'];
	}
	
	?>
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&data_ini=<?=$_GET['data_ini']?>&data_fim=<?=$_GET['data_fim']?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina.  <?=ceil($registros/$limitador)?> Total P&aacute;ginas
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador],array('data_ini'=>$_GET['data_ini'],'data_fim'=>$_GET['data_fim']))?>
    </div>