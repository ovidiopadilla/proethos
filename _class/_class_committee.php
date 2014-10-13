<?php
    /**
     * BreadCrumbs
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright Copyright (c) 2011 - sisDOC.com.br
	 * @access public
     * @version v0.14.02
	 * @package Class
	 * @subpackage Committee
    */
class committee
	{
		var $tabela = '_committee';
		var $file = '';
		var $id;
		
		function config_exist()
			{
				$sql = "select * from ".$this->tabela." limit 1";
				echo $sql;
				$rlt = db_query($sql);
				if ($line = db_read($rlt))
					{
						$this->id = $line['id_cm'];
						return(1);
					} else {
						$this->id = '';
						return(0);
					}
			}

		function config_exist_file()
			{
				$ip = $_SERVER['SERVER_ADDR'];
				if ($ip == '::1') { $ip = 'localhost'; }
				$file = 'db_mysql_'.$ip;
				$file = troca($file,'.','_').'.php';
				$this->file = $file;
				
				if (file_exists($file))
					{
						return(1);
					} else {
						return(0);
					}
			}
		function cp()
			{
				global $dd;
				$cp = array();
				if (strlen($dd[2]) < 4) { $msgcode = '<font color="red"></font>'; }
				$tp = ' : ';
				$tp .= '&MAIL:'.msg('send_by_email');
				$tp .= '&AUTH:'.msg('send_by_email_authentic');
				
				array_push($cp,array('$H8','id_cm','',False,True));
				array_push($cp,array('${','',msg('about_committee'),False,True));
				
				array_push($cp,array('$S8','cm_committe',msg('committee_id'),True,True));
				
				array_push($cp,array('$S100','cm_name',msg('committee_name'),True,True));
				array_push($cp,array('$S100','cm_site',msg('committe_site'),True,True));
				
				array_push($cp,array('$M','',msg('committee_id_info'),False,True));
				
				array_push($cp,array('$A','',msg('address_committee'),False,True));
				array_push($cp,array('$T60:7','cm_address',msg('address'),False,True));
				array_push($cp,array('$S40','cm_city',msg('city'),True,True));
				array_push($cp,array('$Q pais_nome:pais_nome:select * from ajax_pais order by pais_nome','cm_country',msg('country'),True,True));
				
				array_push($cp,array('$A','',msg('address_geo'),False,True));
				array_push($cp,array('$M','',msg('address_geo_info'),false,True));
				array_push($cp,array('$S10','cm_lat',msg('coord_x'),True,True));
				array_push($cp,array('$S10','cm_long',msg('coord_y'),True,True));
				array_push($cp,array('$}','','',False,True));

				array_push($cp,array('${','',msg('contact_committee'),False,True));
				array_push($cp,array('$S40','cm_phone',msg('phone'),True,True));
				array_push($cp,array('$S100','cm_admin_name',msg('admin_name'),True,True));
				array_push($cp,array('$S100','cm_admin_email',msg("admin_email"),True,True));
				array_push($cp,array('$O '.$tp,'cm_admin_email_tipo',msg("admin_email_tipo"),True,True));
				array_push($cp,array('$P20','cm_admin_email_pass',msg("admin_email_password"),False,True));
				array_push($cp,array('$}','','',False,True));
				
				array_push($cp,array('${','',msg('contact_param'),False,True));
				
				$ol = 'es:Español&en_US:English&pt_BR:Portugues&fr:Français';
				//$ol = utf8_encode($ol);
				array_push($cp,array('$O '.$ol,'cm_language',msg('language_preference'),True,True));
				array_push($cp,array('$O CEP:CEP&CEUA:CEUA','cm_type',msg('committee_type'),True,True));
				array_push($cp,array('$}','','',False,True));
				
				array_push($cp,array('${','',msg('harvesting'),False,True));
				array_push($cp,array('$O : &1:'.msg('yes').'&0:'.msg('no'),'cm_admin_key',msg('harvesting'),True,True));
				array_push($cp,array('$S40','cm_admin_key_harveting',msg('harvesting_key'),False,True));
				array_push($cp,array('$M','',msg('harvesting_info'),false,True));
				array_push($cp,array('$}','','',False,True));
				array_push($cp,array('$O utf-8:utf-8','cm_charcode','Encoding Char Type',True,True));
				
				array_push($cp,array('$B8','',msg('update'),False,True));
				
				return($cp);	
			}
		function save_arq()
			{
				$sql = "select * from _committee limit 1";
				$rlt = db_query($sql);
				if ($line = db_read($rlt))
				{
					$site  = trim($line['cm_site']);
					$namei = trim($line['cm_name']);
					$name  = trim($line['cm_admin_name']);
					$email  = trim($line['cm_admin_email']);
					$addr  = trim($line['cm_address']);
					$city  = trim($line['cm_city']);
					$coun  = trim($line['cm_country']);
					
					$phon  = trim($line['cm_phone']);
					$code  = trim($line['cm_committe']);
					$harvk = trim($line['cm_admin_key_harveting']);
					$harv  = trim($line['cm_admin_key']);
					$chas  = trim($line['cm_charcode']);
					
					$lang  = trim($line['cm_language']);
					$type  = trim($line['cm_type']);
				}
				$sx = "<?php	
				#site='".$site."';
				#institution_name='".$namei."';
				#institution_site='".$site."';
				#institution_address='".$addr."';
				#institution_city='".$city."';
				#institution_country='".$coun."';
				#institution_phone='".$phon."';
				
				#harvestig='".$harv."';
				#harvesting_key='".$harvk."';
				#institution_logo='".''."';
				#admin_nome='".$name."';
				#admin_email='".$email."';
				#email_adm='".$email."';
				#committe='".$code."';
				
				#language='".$lang."';
				#commite_type='".$type."';

				/* Screen - Config */
				#tab_max='98%';
				#charset='".$chas."';
				".chr(13).chr(10).'?>';
				$sx = troca($sx,'#','$');
				$file = $this->config_exist_file();
				$file = $this->file;
				$flt = fopen($file,'w');
				fwrite($flt,$sx);
				fclose($flt);
				
			}
	}
	