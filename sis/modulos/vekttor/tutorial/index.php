<?php
	//$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
	//$caminho = $tela->caminho; 
	//Includes
	// configuração inicial do sistema
	$sis_modulo_id = $_GET['id'];
	$tutoriais = mysql_query("SELECT * FROM sis_modulos_tutorial WHERE sis_modulo_id='$sis_modulo_id' ORDER BY id");

	$modulo = mysql_fetch_object(mysql_query("SELECT * FROM sis_modulos WHERE id='$sis_modulo_id'"));
	$pai = $modulo->modulo_id;	
	echo mysql_error();
	while($modulo->modulo_id!=0){
		$modulo = mysql_fetch_object(mysql_query("SELECT * FROM sis_modulos WHERE id='$modulo->modulo_id'"));
		$pai = $modulo->modulo_id;
	}
?>
<link rel="stylesheet" href="style.css" type="text/css" />
<script src="../../../../fontes/js/jquery.min.js"></script>
<script src="../../../../fontes/js/sis.js"></script>
<script>
		//$('#form_arquivo').live('submit',function(){
                //checaprogresso();
            //});
            
            
		
		$(".t").live("click",function(){
			tutorial_id = $(this).parent().find(".tutorial_id").val();
			$("#tutorial").text('');
			$("#tutorial").load('buscaTutorial.php?id='+tutorial_id+'&tela_id=<?php echo $sis_modulo_id?>');
			
			
			
			
		});	
	$(document).ready(function(){
			tutorial_id = $(".primeiro").val();
			$("#tutorial").text('');
			$("#tutorial").load('buscaTutorial.php?id='+tutorial_id+'&tela_id=<?php echo $sis_modulo_id?>');
	});	
	

</script>
<div id="pagina">
	<div id="menu">
		<ul>
        	<?php 
				while($tutorial = mysql_fetch_object($tutoriais)){
					$x++;
					if($x==1){$primeiro='primeiro';}else{$primeiro='';}
					echo "<li><a href='#' class='t'>
							$tutorial->titulo</a>
						 	<input type='hidden' class='tutorial_id $primeiro' name='tutorial_id' value='$tutorial->id'/>
						 </li>";
				}
    		?>
		</ul>
	</div>
	
    <?php
    	//seleciona primeiro tutorial
		$tutorial1 = mysql_fetch_object(mysql_query("SELECT * FROM sis_modulos_tutorial WHERE sis_modulo_id=$sis_modulo_id ORDER BY id LIMIT 1"));
	?>
    <div id="tutorial">
   </div>   
</div>
