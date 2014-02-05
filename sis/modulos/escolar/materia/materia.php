<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho; 

include ("_functions.php");
include ("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>

$(".adiciona").live("click", function(){

	conteudo =$("#multiplicador label:first-child").html();
	$("#multiplicador").append( '<label>'+conteudo.replace('mais.png','menos.png').replace('adiciona','remove')+'</label>');
	$("#multiplicador label:last-child").find('input').val('');
});
$(".remove").live("click", function(){
	materia_id= $(this).attr('materia_id');
	curso_id = $('#curso_id').val();
	modulo_id = $('#modulo_id').val()
	//alert(modulo_id);
	window.open('?tela_id=234&remove_materia='+materia_id+'&curso_id='+curso_id+'&modulo_id='+modulo_id,'carregador');
	$(this.parentNode).remove();
});


$(".undade_escolar").live('click',function(){
	if($(this).is(":checked")){
			$(this.parentNode.parentNode).find("select").removeAttr( "disabled");
	}else{
			$(this.parentNode.parentNode).find("select").attr( "disabled",'disabled');	
	}
});

function selcurso(curso){
	window.open("modulos/escolar/materia/form.php?curso="+curso.value,"carregador");
}

function selmodulos(curso,modulo){
	window.open("modulos/escolar/materia/form.php?curso="+curso.value+"&modulo="+modulo.value,"carregador");
}
</script>
<style>
.adiciona{ margin-top:0px; float:right}
.remove{ margin-top:0px; float:right}
</style>
<div id="conteudo">

	<!--
        ///////////////////////////////////////
        Barra de Navegação
        ///////////////////////////////////////
    -->
    <?
  //  pr($_POST);
	?>
    <div id="navegacao">
        <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo"><span></span>Materias</a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
          <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
    </div>
        
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="200">Curso</td>
                <td width="200">Materias</td>
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
            
			
            if( strlen( $_GET[busca]) > 0 ){
                $busca_add = "AND m.nome LIKE '%{$_GET[busca]}%'";
            }
            
            
            // necessario para paginacao
            $q = mysql_query ("SELECT count(*) FROM $tabela WHERE vkt_id='$vkt_id' ORDER BY nome");
            $registros = mysql_result ($q,0,0);
            
            if( $_GET['ordem'] ){
                $ordem = $_GET['ordem'];
            } else {
                $ordem = "id";
            }
            
            // colocar a funcao da paginação no limite
            $q= mysql_query("SELECT * FROM  $tabela WHERE vkt_id='$vkt_id' ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador])) or die ( mysql_error() );
            
           while( $r = mysql_fetch_object($q) ){
				// Vagas totais no curso
				$q1 = mysql_query("SELECT sum(vagas_total_horario) FROM horarios WHERE curso_id = '$r->id'");
				$d1 = @mysql_result($q1, 0);
				if(empty($d1)) { $d1 = 0; }
                $total++;
                if( $total % 2 ){ $cl = "class='al'"; } else { $cl = ''; }
				
				
			$qm = mq($t="SELECT * FROM escolar_modulos WHERE vkt_id='$vkt_id' AND curso_id='$r->id'");
			$modulos =mysql_num_rows($qm);
			if($modulos<1){
				$qm = mq("SELECT 1=1");
			}
			$modulo=$r->nome;
			$modulocount=0;
			while($m=mf($qm)){
				$modulocount++;
				if($modulocount>1){
					$modulo='&nbsp;';
				}            						
			?>
                <tr <?php echo $cl; ?>>
                   <td width="200"><?php echo substr($modulo, 0, 40); ?></td>                  
                   <td width="200"></td>
                   <td></td>
                </tr>
                       
            <?php
				
				$materias = mysql_query($qs="SELECT m.* FROM escolar_materias m WHERE m.modulo_id='$m->id' AND m.vkt_id='$vkt_id' $busca_add");
				//echo $qs."<br>";
				$cont=0;
				
				//Executa if caso módulo nao tenha matéria
				if(mysql_num_rows($materias)==0){
			?>
            
            	<tr <?php echo $cl; ?> 	onclick="window.open('<?php echo $caminho; ?>/form.php?curso_id=<?php echo $r->id; ?>&modulo_id=<?php echo $m->id?>                    ','carregador')">
                	<td width="200"><strong><? echo "&nbsp;&nbsp;&nbsp;&nbsp;".$m->nome; ?></strong></td>
                   	<td width="200"></td>
                   	<td></td>
                </tr>
                
            <?php
				}else{
					while($rc=mysql_fetch_object($materias)){
			?>
            
            <tr <?php echo $cl; ?> onclick="window.open('<?php echo $caminho; ?>/form.php?curso_id=<?php echo $r->id; ?>&modulo_id=<?php echo $m->id?>','carregador')">
               	<td width="200"><strong><? if($cont==0){ echo "&nbsp;&nbsp;&nbsp;&nbsp;".$m->nome;} ?></strong></td>
                <td width="200"><? echo $rc->nome?></td>
                <td></td>
            </tr>
                
           <?php
						$cont++;
					}//$rc
				}//$materias
			}//$m
			}//$r
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
               <td width="260">&nbsp;</td>
               <td width="260">&nbsp;</td>
               <td >&nbsp;</td>
            </tr>
        </thead>
    </table>

</div>

<!--
    ///////////////////////////////////////
    Rodapé
    ///////////////////////////////////////
-->
<div id="rodape">

	    
</div>