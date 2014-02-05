<?
//Funções 

//Cadastra Vendedor
function cadastra($campos){
				global $vkt_id;
				
				$SqlUsuTipo = " INSERT INTO usuario_tipo SET 
					          					vkt_id = '$vkt_id',
												nome   = '$campos[nome]'
							  ";
							  
				$SqlUsuario = " INSERT INTO usuario SET
							  				cliente_vekttor_id = '$campos[cliente_vekttor_id]',
											usuario_tipo_id    = '$campos[usuario_tipo_id]',
											nome               = '$campos[nome]',
											login			   = '$campos[login]',
											senha			   = '$campos[senha]'
							  ";
				
				
				
				$Insert = " INSERT INTO vendedor SET 
									cliente_fornecedor_id = '$campos[cliente_fornecedor]',
									usuario_id            = '$campos[s]',
									cliente_vekttor_id    = '$campos[cliente_vekttor]',
									porcent_implantacao   = '$campos[s]',
									porcent_servico       = '$campos[s]'
				";
	
}


function update(){
				$Update = " INSERT INTO vendedor SET 
									cliente_fornecedor_id = '$campos[s]',
									usuario_id            = '$campos[s]',
									cliente_vekttor_id    = '$campos[s]',
									porcent_implantacao   = '$campos[s]',
									porcent_servico       = '$campos[s]'
								WHERE 
									id = '$campos[s]'
				";
}

function excluir($id){
	
			$Delete = " DELETE FROM vendedor WHERE id = '$id' ";
}

?>