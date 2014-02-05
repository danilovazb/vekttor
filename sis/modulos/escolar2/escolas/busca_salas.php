<?php
include("../../../_config.php");
include("../../../_functions_base.php");

global $vkt_id;
	
$id = $_POST['id'];
$qtd_salas = $_POST['qtd_salas'];

$salas = mysql_query($t="SELECT * FROM escolar2_salas WHERE vkt_id='$vkt_id' AND unidade_id = '$id' ORDER BY id LIMIT $qtd_salas");
//alert($t);
$numero_salas = mysql_num_rows($salas);

while($sala = mysql_fetch_object($salas)){
	
	echo "<div class='sala'>
                        	<label style='width:100px;'>
                            	Nome da sala
                                <input name='nome[]' type='text' value='$sala->nome'/>
                                <input name='sala_id[]' type='hidden' value='$sala->id'/>
                           </label>
                           <label style='width:110px;'>
                           		Capacidade m&aacute;xima
                                <input name='capacidade_max[]' type='text' value='$sala->capacidade_maxima'/>
                           </label>
                           <label style='width:130px;'>
                           		Capacidade Pedag&oacute;gica
                                <input name='capacidade_ped[]' type='text' value='$sala->capacidade_pedagogica'/>
                           </label>
                       	</div>";
	
}

if($qtd_salas > $numero_salas){
	
	for($i=$numero_salas+1;$i<=$qtd_salas;$i++){
		
		echo "<div class='sala'>
                        	<label style='width:100px;'>
                            	Nome da sala
                                <input name='nome[]' type='text' value=''/>
                                <input name='sala_id[]' type='hidden' value=''/>
                           </label>
                           <label style='width:110px;'>
                           		Capacidade m&aacute;xima
                                <input name='capacidade_max[]' type='text' value=''/>
                           </label>
                           <label style='width:130px;'>
                           		Capacidade Pedag&oacute;gica
                                <input name='capacidade_ped[]' type='text' value=''/>
                           </label>
                       	</div>";
		
	}
	
}

?>