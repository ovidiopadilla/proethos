<?
    /**
     * Institutions
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright © Pan American Health Organization, 2013. All rights reserved.
	 * @access public
     * @version v0.11.29
	 * @package Class
	 * @subpackage institutions
    */
class instituicao
{
	var $tabela = 'cep_submit_institution';
	
	function cp()
		{
			$cp = array();
			array_push($cp,array('$H8','','',Flase,True));
			array_push($cp,array('$S100','it_nome','',True,True));
			array_push($cp,array('$S20','it_nome_abrev','',True,True));
			array_push($cp,array('$S1','it_tipo','',True,True));
			array_push($cp,array('$S100','it_estrangeiro','',True,True));
			array_push($cp,array('$S60','it_endereco',msg('address'),False,True));
			array_push($cp,array('$S100','it_bairro',msg('block'),False,True));
			array_push($cp,array('$S30','it_cidade',msg('city'),False,True));
			//array_push($cp,array('$S100','it_pais','',True,True));
			array_push($cp,array('$HV','it_status','A',True,True));
			array_push($cp,array('$O 1:'.msg('yes').'&0:'.msg('no'),'it_ativo',msg('active'),True,True));
			array_push($cp,array('$S15','it_telefone','',True,True));
			array_push($cp,array('$S15','it_fax','',True,True));
			array_push($cp,array('$S100','it_email','',True,True));
			array_push($cp,array('$S100','it_site','',True,True));
			array_push($cp,array('$S100','it_obs','',True,True));
			return($cp);			
		}

	function institution_list()
		{
			$sql = "select * from ".$this->tabela." ";
			$rlt = db_query($sql);
			
			while ($line = db_read($rlt))
			{
				$sx .= '<TR>';
				$sx .= '<TD>';
				$sx .= trim($line['it_nome']);
				$sx .= '<TD>';
				$sx .= trim($line['it_nome_abrev']);
			}
		}
}
?>

