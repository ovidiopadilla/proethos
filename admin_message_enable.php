<?php
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2015 -  Pan-American Health Organization / World Health Organization (PAHO/WHO)
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage Messages
 */
require("cab.php");
$mess = new message;
$edit_mode = 0;

echo '<META HTTP-EQUIV=Refresh CONTENT="4; URL=admin.php">';

if (($perfil->valid('#ADM')) or ($perfil->valid('#MAS'))) 
	{
		$rs = $mess->edit_mode($dd[1]);
		echo '<H2>'.msg($rs).'</H2>';
		$_SESSION['editmode'] = $dd[1];
			
	}
echo '</div>';

echo $hd->foot();
?>