<?
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage user
 */
require("cab.php");

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok==0) {
	redirecina('main.php');
}


require($include.'sisdoc_data.php');
require($include.'_class_form.php');
$form = new form;
require("form_css.php");
$uss = new users;
$cp = $uss->cp_myaccount();

$ss->id = $dd[0];
$ss->le($dd[0]);
$ss->user_codigo = $ss->codigo;
$tabela = 'usuario';

echo '<h2>'.msg('account').'</h2>';
echo '<table width="'.$tab_max.'" class="lt0">';
echo '<TR><TD>';
echo $ss->mostrar();
echo '</table>';

echo '<h2>'.msg('profile').'</h2>';
echo $perfil->display();

echo '<form action="admin_user.php"><input type="submit" value="'.strip_tags(msg("back")).'" class="bt_back"></form>';

echo '</div>';

?>
<script>
	
</script>
