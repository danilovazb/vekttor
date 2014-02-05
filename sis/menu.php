<?
	// menu aluno
	if($_SESSION['usuario_tipo']=='aluno'){
		//pr($_SESSION);	
		echo $menu_inner[]='<a  id="m271" onclick="submenu(271)" style="background-image:url(../fontes/img/iconvkt2.png); background-repeat:no-repeat;background-position: 7px 2px; padding-left:28px;" ><strong>Área do Aluno</strong></a>'."\n";
		$q2 = mysql_query("SELECT * FROM sis_modulos WHERE modulo_id='271' order by ordem_menu,nome ");
		
		//print_r($_GET);
		$n2 = mysql_num_rows($q2);
		if($n2>0){echo $menu_inner[]="	<span id=\"sub271\" class='smen'  >\n";}
		$liberado=0;
		while($r2 = mysql_fetch_object($q2)){
			$liberado++;
			if($_GET[tela_id]==$r2->id){
				$selecionado = 'class="menu_selected"';
			}else{
				$selecionado = '';
			}
		echo $menu_inner[]="	<a $selecionado href=''>$r2->nome</a>";
		}
		echo $menu_inner[]="		</span>\n";
	}else{
	
	
	
	/// menu  normal
	//if(!$_SESSION[menu]){
	$q = mysql_query("SELECT * FROM sis_modulos WHERE modulo_id='$modulo_id' order by ordem_menu,nome ");
	//print_r($_GET);
	while($r = mysql_fetch_object($q)){
		if($vkt_id == 1){
			$strong = "<span class='badge-important radius' style='float:right;color:#FFF; font-size:9px; padding-bottom:2px; padding-left:5px; padding-right:5px;'> Novo </span>";	
		}
		if($_GET[tela_id]==$r->id){
			$selecionado = 'class="menu_selected"';
		}else{
			$selecionado = '';
		}
		
		
		if($r->acao_menu =='expande'){
			
			if($r->id=='159'){
				echo $menu_inner[]='<a '.$selecionado.' class="pr" id="m'.$r->id.'" onclick="submenu('.$r->id.')" style="background-image:url(../fontes/img/iconvkt2.png); " ><strong>'.$r->nome. '</strong></a>'."\n";
			}elseif($r->id=='89'){
				echo $menu_inner[]='<a '.$selecionado.' class="pr" id="m'.$r->id.'" onclick="submenu('.$r->id.')" style="background-image:url(../fontes/img/timer.png); " ><strong>'.$r->nome. '</strong></a>'."\n";
			}elseif($r->id=='1'){
				echo $menu_inner[]='<a '.$selecionado.' class="pr" id="m'.$r->id.'" onclick="submenu('.$r->id.')" style="background-image:url(../fontes/img/adm.png); " ><strong>'.$r->nome. '</strong></a>'."\n";
			}elseif($r->id=='6'){
				echo $menu_inner[]='<a '.$selecionado.' class="pr" id="m'.$r->id.'" onclick="submenu('.$r->id.')" style="background-image:url(../fontes/img/config.png); " ><strong>'.$r->nome. '</strong></a>'."\n";
			}elseif($r->id=='5'){
				echo $menu_inner[]='<a '.$selecionado.' class="pr" id="m'.$r->id.'" onclick="submenu('.$r->id.')" style="background-image:url(../fontes/img/efinancy.png); " ><strong>'.$r->nome. '</strong></a>'."\n";
			}elseif($r->id=='99'){
				echo $menu_inner[]='<a '.$selecionado.' class="pr" id="m'.$r->id.'" onclick="submenu('.$r->id.')" style="background-image:url(../fontes/img/cozinha.png); " ><strong>'.$r->nome. '</strong></a>'."\n";
			}elseif($r->id=='8'){
				echo $menu_inner[]='<a '.$selecionado.' class="pr" id="m'.$r->id.'" onclick="submenu('.$r->id.')" style="background-image:url(../fontes/img/imobiliaria.png); " ><strong>'.$r->nome. '</strong></a>'."\n";
			}elseif($r->id=='3'){
				echo $menu_inner[]='<a '.$selecionado.' class="pr" id="m'.$r->id.'" onclick="submenu('.$r->id.')" style="background-image:url(../fontes/img/estoque.png); " ><strong>'.$r->nome. '</strong></a>'."\n";
			}elseif($r->id=='204'||$r->id=='454'){
				echo $menu_inner[]='<a '.$selecionado.' class="pr" id="m'.$r->id.'" onclick="submenu('.$r->id.')" style="background-image:url(../fontes/img/escola.png); " ><strong>'.$r->nome. '</strong></a>'."\n";
			}elseif($r->id=='303'){
				echo $menu_inner[]='<a '.$selecionado.' class="pr" id="m'.$r->id.'" onclick="submenu('.$r->id.')" style="background-image:url(../fontes/img/aluguel.png);" ><strong>'.$r->nome. '</strong></a>'."\n";
			}elseif($r->id=='275'){
				echo $menu_inner[]='<a '.$selecionado.' class="pr" id="m'.$r->id.'" onclick="submenu('.$r->id.')" style="background-image:url(../fontes/img/os.png); " ><strong>'.$r->nome. '</strong></a>'."\n";
			}elseif($r->id=='93'){
				echo $menu_inner[]='<a '.$selecionado.' class="pr" id="m'.$r->id.'" onclick="submenu('.$r->id.')" style="background-image:url(../fontes/img/rh.png); " ><strong>'.$r->nome. '</strong></a>'."\n";
			}elseif($r->id=='368'){
				echo $menu_inner[]='<a '.$selecionado.' class="pr" id="m'.$r->id.'" onclick="submenu('.$r->id.')" style="background-image:url(../fontes/img/mn/368.png); " ><strong>'.$r->nome. '</strong></a>'."\n";
			}elseif($r->id=='370'){
				echo $menu_inner[]='<a '.$selecionado.' class="pr" id="m'.$r->id.'" onclick="submenu('.$r->id.')" style="background-image:url(../fontes/img/mn/370.png); " ><strong>'.$r->nome. '</strong></a>'."\n";
			}else{				
				echo $menu_inner[]='<a '.$selecionado.' class="pr" id="m'.$r->id.'" onclick="submenu('.$r->id.')" style="background-image:url(../fontes/img/mn/0.png); "><strong>'.$r->nome. '</strong></a>'."\n";

			}
			
		}
		
		
		$q2 = mysql_query("SELECT * FROM sis_modulos WHERE modulo_id='$r->id' order by ordem_menu,nome ");
		
		//print_r($_GET);
		$n2 = mysql_num_rows($q2);
		if($n2>0){echo $menu_inner[]="	<span id=\"sub$r->id\" class='smen'  style='display:none'>\n";}
		$liberado=0;
		while($r2 = mysql_fetch_object($q2)){
			$paide[$r2->id]= $r;
		  if(array_search($r2->id,$_SESSION[acesso])){
			$liberado++;
			if($_GET[tela_id]==$r2->id){
				$selecionado = 'class="menu_selected"';
				echo $menu_inner[]="<script>$('#sub$r->id').show()</script>";
			}else{
				$selecionado = '';
			}

				if($r2->acao_menu =='expande'){
					echo $menu_inner[]='		<a '.$selecionado.' onclick="submenu('.$r2->id.')" ><img src="../fontes/img/sd.png" width="8" height="8" style="margin:0 2px 0 -10px" /><strong>'.$r2->nome. '</strong></a>'."\n";
				}elseif($r2->acao_menu =='blank'){
						echo $menu_inner[]="			<a $selecionado href='$r2->caminho/$r2->tela' target='_blank'>$r2->nome </a>\n";
				}else{
					
						echo $menu_inner[]="			<a $selecionado href=''>$r2->nome </a>\n";
					//echo $menu_inner[]="		<a $selecionado href=''>$r2->nome</a>\n";
					
				}
				
				
			
			
			$q3 = mysql_query($trace="SELECT * FROM sis_modulos WHERE modulo_id='$r2->id' order by ordem_menu,nome ");
			//echo "$trace";
			$n3 = mysql_num_rows($q3);
			if($n3>0){echo $menu_inner[]="		<span id=\"sub$r2->id\" class='smen' style='display:none'>\n";}
			while($r3 = mysql_fetch_object($q3)){
				$paide[$r3->id]= $r;

				if($_GET[tela_id]==$r3->id){
					$selecionado = 'class="menu_selected"';
					echo  $menu_inner[]="<script>$('#sub$r->id').show();$('#sub$r2->id').show()</script>";
				}else{
					$selecionado = '';
				}
				if($r3->acao_menu =='expande'){
					
					
					
					echo $menu_inner[]='			<a '.$selecionado.'  onclick="submenu('.$r3->id.')" ><img src="../fontes/img/sd.png" width="8" height="8" style="margin:0 2px 0 -10px" /><strong>'.$r3->nome. '</strong></a>';
					
					
					
				}elseif($r3->acao_menu =='abre'){
					
						echo $menu_inner[]="			<a $selecionado href=''>$r3->nome</a>\n";
				}if($r2->acao_menu =='blank'){
						echo $menu_inner[]="			<a $selecionado href='$r2->caminho/$r2->tela' target='_blank'>$r2->nome $strong </a>\n";
				}elseif($r3->acao_menu =='interno'&&$_GET[tela_id]==$r3->id){
				  
					if($cliente_id==13){
					  
					if($r3->id==229){
							echo $menu_inner[]="<a $selecionado href=''>Alunos</a>\n";
						}else{
							echo $menu_inner[]="			<a $selecionado href=''>$r3->nome</a>\n";
						}
					}else{
					  echo $menu_inner[]="			<a $selecionado href='#'>$r3->nome</a>\n";
					}
				}
				  
					
					
				
			}
			if($n3>0){echo $menu_inner[]="		</span>\n";}
		}
		}
		if($liberado==0){
			echo $menu_inner[]="<script>$('#m$r->id').hide()</script>";
		}
		if($n2>0){echo $menu_inner[]="	</span>\n";}

		
		
		
	}
	$menu= implode("",$menu_inner) ;
	$_SESSION[menu] =$menu;
	}
?>