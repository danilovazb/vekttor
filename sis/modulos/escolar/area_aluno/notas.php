<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho;

include ("_functions.php");
include ("_ctrl.php");

$professor = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_professor WHERE usuario_id = '$usuario_id'"));
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="conteudo">
<script>
$("select#options").live('change',function(){
	        var tela            = $(this).val();
			
			var turma      = $(this).parents().find('#sala_turma').val();
			var materia    = $(this).parents().find('#materia_id').val();
			var periodo_id = $(this).parents().find('#periodo_id').val();
			var sala_materia       = $(this).parents().find('#sala_materia').val();
				//alert(periodo_materia);
				location.href='?tela_id='+tela+'&materia='+materia+'&periodo_id='+periodo_id+'&sala='+turma+'&sala_materia='+sala_materia;
})

function selmatricula(mat){
			location.href='?tela_id=<?=$_GET['tela_id']?>&matricula='+mat.value;
}
</script>
<style>
	blockquote{margin-top:0; margin-bottom:0; margin-right:0; margin-left:15px; padding:0;}
	tbody td{ vertical-align:top; line-height:14px;}
	.cz{ color:#999999; cursor:default}
</style>
<?
//pr($_POST);
?>
	<!--
        ///////////////////////////////////////
        Barra de Navegação
        ///////////////////////////////////////
    -->
    <div id="navegacao">
        
       <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s1'>Escolare</a>
        <a href="./" class='s2'>Área do Aluno</a>
        <a href="./?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo">Notas<span></span></a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
     <form method="get">
     <label>
	 <?php
	 	//selecionar os cursos do aluno
	 	echo "<select name='matricula' onchange='selmatricula(this)'>";
		echo "<option value='0'>SELECIONE UMA MATRÍCULA</option>";
		while($m=mysql_fetch_object($mat)){
			if($m->idmatricula==$_GET['matricula']){
				$selected='selected=selected';
			}else{
				$selected='';
			}
			echo "<option value='$m->idmatricula' $selected>$m->idmatricula - $m->escola - $m->curso - $m->modulo - $m->sala</option>";
		}
		echo "</select>";
		
	 ?>
     </label>
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
                <td width="100">Matériasssss</td>
                <?php
				if(($notas)>0){
					//armazena as sala_materia_professor_id
					$sala_mat_pro=array();
					$cont_d=0;
					
					//armazena os períodos normais
					$periodos=array();
					$cont_p=0;
					
					while($nota=mysql_fetch_object($notas)){
						if(!in_array($nota->periodicidade_id,$periodos)){
							$periodos[$cont_p]=$nota->periodicidade_id;
							$cont_p++;
						}
					}
					
					foreach($periodos as $p){
						$periodo=mysql_fetch_object(mysql_query("SELECT * FROM escolar_periodicidade_avaliacao WHERE id=$p"));
						echo "<td width='150'>$periodo->nome</td>";

					}

				?>
                <td width="50">Média</td>
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
    	<?php
        	$aluno=mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_matriculas WHERE aluno_id=$aluno_id AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));	
			 echo $t;
			$materias=mysql_query("SELECT * FROM escolar_materias WHERE modulo_id=$aluno->modulo_id")
		?>
	  <script>resize()</script><!-- Isso é Necessário para a criação o resize -->
        <table cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            	<?
					while($m=mysql_fetch_object($materias)){
						//armazena a media dos períodos
						$media=array();
						$cont_m=0;
						//armazena a media dos periodos de recuperaçao
						$media_r=array();
						$cont_r=0;
						//$c=0;
						echo "<tr>";
						echo "<td width='100'>$m->nome</td>";
						foreach($periodos as $p){
							$nota=mysql_query($t="SELECT * FROM escolar_notas en
											INNER JOIN escolar_avaliacao ea ON en.avaliacao_id=ea.id
											INNER JOIN escolar_sala_materia_professor smp ON ea.sala_materia_professor_id=smp.id
											INNER JOIN escolar_materias m ON smp.materia_id=m.id
											INNER JOIN escolar_periodicidade_avaliacao epa ON ea.periodicidade_id = epa.id  
											WHERE m.id=$m->id AND en.matricula_aluno_id=$aluno_id
											AND ea.periodicidade_id=$p");
								//echo $t."<br>";			
								echo "<td width='150'>";
							$qtd_notas=0;
							$not=0;
							while($n=mysql_fetch_object($nota)){
								echo number_format($n->nota,1)." ";
								$not+=$n->nota;
								//$c++;
								$qtd_notas++;
								$recuperacao=$n->recuperacao;
							}
							echo "</td>";
							if($recuperacao==0&&$qtd_notas>0){
								$media[$cont_m]=$not/$qtd_notas;
								//echo $media[$cont_m];
								$cont_m++;
								
							}else if($qtd_notas>0){
								$media_r[$cont_r]=$not/$qtd_notas;
								//echo $media_r[$cont_r];
								$cont_r++;
																
							}
						}
						if(sizeof($media_r)>0){
							$media_final=(array_sum($media)/sizeof($media)+array_sum($media_r)/sizeof($media_r))/2;
						}else if(sizeof($media)>0){
							$media_final=array_sum($media)/sizeof($media);
						}
						if($media_final!=0){
							echo "<td width='50'>".number_format($media_final,1)."</td>";
							$media_final='';
						}						
						echo "<td></td>";
						echo "</tr>";
					//}
				}
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
               <td width="100%"></td>
            </tr>
        </thead>
    </table>
    <script>
    $("tr:odd").addClass('al');
    </script>
</div>

<!--
    ///////////////////////////////////////
    Rodapé
    ///////////////////////////////////////
-->
<div id="rodape">
</div>