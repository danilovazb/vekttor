<?php
//Includes
// configuração inicial do sistema
include("../../../../_config.php");
// funções base do sistema
include("../../../../_functions_base.php");
// funções do modulo empreendimento
?>
<select name="corretor_id" id="corretor_id"> 
                        	<option> Corretor </option>
                        		 <?php 
								 
	   							$sql = mysql_query(" SELECT * FROM corretor WHERE imobiliaria_id = {$_GET['imobiliario_id']} ");
										while($corretor=mysql_fetch_object($sql)){	   
	   							?>
                                <option value="<?php echo $corretor->id?>"><?php echo $corretor->nome?></option>
                                  <?php
										}
	   							  ?>
</select>