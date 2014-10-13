<?php
/**
 * Submit protocol
 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
 * @copyright Copyright (c) 2011 - sisDOC.com.br
 * @access public
 * @version v0.11.29
 * @package Class
 * @subpackage submit
 */
class submit {
	var $id_doc;
	var $doc_protocolo;
	var $doc_1_titulo;
	var $doc_autor_principal;
	var $author_name;
	var $doc_tipo;

	var $doc_clinic;
	var $doc_data;
	var $doc_hora;
	var $doc_dt_atualizado;
	var $doc_status;
	var $doc_xml;
	var $amendment_type;

	var $tabela = 'cep_submit_documento';

	function status_show($sta, $cor = 1) {
		$sta = trim($sta);
		$sx = msg('status_' . trim($this -> doc_status));
		if ($cor == 1) {
			switch ($sta) {
				case '@' :
					$sx = '<font color="green"><B>' . $sx . '</B></font>';
					break;
				case 'X' :
					$sx = '<font color="red">' . $sx . '</font>';
					break;
			}
		}
		return ($sx);
	}

	function protocolo_cancel() {
		$sql = "update " . $this -> tabela . " set doc_status = 'X' 
					where doc_protocolo = '" . $this -> doc_protocolo . "' ";
		$rlt = db_query($sql);
		return (1);
	}

	function mostra_titulo_anaconico() {
		$sx .= $this -> doc_anacronico;
		return ($sx);
	}

	function protocolo_mostrar() {
		$sx .= '<fieldset><legend>' . msg('project_about_cap') . '</legend>';
		
		$sx .= '<table width="100%" class="lt0">';
		$sx .= '<TR valign="top">';
		$sx .= '<TD rowspan=4 width="40">';

		$size_image = '80';

		$sx .= '<img src="images/icone_submit.png" width="'.$size_image.'">';
		/* Ensaio clinico */
		$clinic = $this -> doc_clinic;
		if ($clinic == 1) {
			$sx .= '<img src="images/icone_clinical_trial.png" width="'.$size_image.'">';
		}

		$sx .= '</td>';
		$sx .= '<TD colspan=2 valign="top" >' . msg('title') . '</td>';
		$sx .= '<TD align="right">' . msg('protocolo');
		$sx .= '<TR class="lt2">';

		/* Titulo do trabalho */
		$sx .= '<TD colspan=2 ><div style="min-height: 80px;"><B>';
		$sx .= $this -> doc_1_titulo;

		/* Anacronico */
		$sx .= $this -> mostra_titulo_anaconico();

		$sx .= '</div></td>';

		/* Protocolo */
		$sx .= '<TD align="right" valign="top">' . $this -> doc_protocolo;

		/* Header */
		$sx .= '<TR>';
		$sx .= '<TD width="60%">' . msg('main_author') . '</td>';
		$sx .= '<TD width="20%">' . msg('main_type') . '</td>';
		$sx .= '<TD width="15%" align="right">' . msg('last_update') . '</td>';

		/* TR */
		$sx .= '<TR class="lt2">';

		/* Autor */
		$sx .= '<TD><B>';
		$sx .= $this -> author_name;

		/* Estudo Clinico */
		if ($clinic == 1) {
			$sx .= '<TD class="lt2" align="left"><I>';
			$sx .= '<B>' . msg('clinic_study') . '</B>';
		} else {
			$sx .= '<TD></TD>';
		}

		$sx .= '<TD align="right">' . stodbr($this -> doc_dt_atualizado);

		$sx .= '</table>';
		$sx .= '</fieldset>';
		return ($sx);
	}

	function protocolos_todos($sta) {
		$rst = $this -> protocolo_status($sta);
		return ($rst);
	}

	function protocolos_em_submissao() {
		$rst = $this -> protocolo_status('@');
		return ($rst);
	}


	function le($id = '') {
		if (strlen($id) > 0) { $this -> doc_protocolo = $id;
		}
		$this -> doc_protocolo = strzero(round($this -> doc_protocolo), 7);

		$sql = "select * from " . $this -> tabela;
		$sql .= " left join usuario on doc_autor_principal = us_codigo ";
		$sql .= " where doc_protocolo = '" . $this -> doc_protocolo . "'";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			$this -> id_doc = $line['id_doc'];
			$this -> doc_1_titulo = $line['doc_1_titulo'];
			$this -> doc_anacronico = trim($line['doc_anacronico']);
			$this -> doc_protocolo = strzero(round($line['doc_protocolo']), 7);
			$this -> doc_tipo = $line['doc_tipo'];
			$this -> doc_clinic = $line['doc_clinic'];
			$this -> doc_data = $line['doc_data'];
			$this -> doc_hora = $line['doc_hora'];
			$this -> doc_dt_atualizado = $line['doc_dt_atualizado'];
			$this -> doc_autor_principal = $line['doc_autor_principal'];
			$this -> doc_status = $line['doc_status'];
			$this -> doc_xml = $line['doc_xml'];
			$this -> doc_type = $line['doc_type'];
			$this -> author_name = trim($line['us_nome']);
			$this -> amendment_type = trim($line['doc_type']);

			if (strlen($this -> doc_1_titulo) == 0) { $this -> doc_1_titulo = msg('not_defined');
			}
		}
		return (1);
	}

	function protocolo_acoes() {
		$sta = $this -> doc_status;
		$opc = array();
		if ($sta == '@') {
			array_push($opc, array(msg('acao_edit'), 'protocolo_sel.php?dd0=' . $this -> doc_protocolo . '&dd90=' . checkpost($this -> doc_protocolo)));
			array_push($opc, array(msg('acao_cancel'), 'protocolo_cancel.php?dd0=' . $this -> doc_protocolo . '&dd90=' . checkpost($this -> doc_protocolo)));
		}
		return ($opc);
	}

	function protocolo_acoes_botoes($acoes) {
		$sx = '';
		$sj = "";
		for ($r = 0; $r < count($acoes); $r++) {
			$sx .= '<input type="button" value="' . $acoes[$r][0] . '" onclick="acao' . $r . '();">';
			chr(13);
			$sj .= "function acao" . $r . '()' . chr(13);
			$sj .= "{ window.self.location.href = " . '"' . $acoes[$r][1] . '"; }' . chr(13);
		}
		$sj = '<script>' . chr(13) . $sj . '</script>' . chr(13);
		$sx = chr(13) . chr(13) . $sx . chr(13) . $sj;
		return ($sx);
	}

	function protocolo_cancelar() {
		global $dd;
		$this -> le($dd[0]);
		$_SESSION['protocolo'] = '';
		$sql = "update " . $this -> tabela . " set doc_status = 'X', doc_dt_atualizado = " . date("Ymd") . " where doc_protocolo = '" . $this -> doc_protocolo . "'";
		$rlt = db_query($sql);
		return (1);
	}

	function protocolo_to_submit() {
		global $dd;
		$this -> le($dd[0]);
		$_SESSION['protocolo'] = '';
		$sql = "update " . $this -> tabela . " set doc_status = '@', doc_dt_atualizado = " . date("Ymd") . " where doc_protocolo = '" . $this -> doc_protocolo . "'";
		$rlt = db_query($sql);
		return (1);
	}

	function protocolo_seleciona() {
		global $dd;
		$this -> le($dd[0]);
		$_SESSION['protocolo'] = $this -> dpc_protocolo;
		$_SESSION['id'] = $this -> doc_autor_principal;
		return (1);
	}

	function protocolo_dados() {
		global $tab_max, $date, $messa;
		$sx .= '<table width="' . $tab_max . '">';
		$sx .= '<TR><TD>';
		$sx = '<fieldset><legend>' . msg('protocol_data') . '</legend>';
		$sx .= '<table width="' . $tab_max . '" border=0>';
		$sx .= '<TR><TD class="lt0" colspan=4 >' . msg('titulo');
		$sx .= '<TR><TD class="lt2" colspan=4 ><B>' . $this -> doc_1_titulo . '</B>';
		$sx .= '<TR>';
		$sx .= '<TD class="lt0" colspan=1 >' . msg('data');
		$sx .= '<TD class="lt0" colspan=1 >' . msg('time');
		$sx .= '<TD class="lt0" colspan=1 >' . msg('update');
		$sx .= '<TD class="lt0" colspan=1 >' . msg('status');

		/**
		 * Status
		 */

		$sta = 'status_' . trim($this -> doc_status);

		$sx .= '<TR>';
		$sx .= '<TD class="lt2" colspan=1 >' . $date -> stod($this -> doc_data);
		$sx .= '<TD class="lt2" colspan=1 >' . $this -> doc_hora;
		$sx .= '<TD class="lt2" colspan=1 >' . $date -> stod($this -> doc_dt_atualizado);
		$sx .= '<TD class="lt2" colspan=1 >' . msg($sta);

		$sx .= '</table>';
		$sx .= '</fieldset>';
		$sx .= '</table>';
		return ($sx);
	}

	function protocolo_log($proto, $cod) {
		$data = date("Ymd");
		$hora = date("H:i:s");
		$sql = "insert into cep_protocol_log ";
		$sql .= "(cl_data, cl_hora, cl_protocol, cl_cod) ";
		$sql .= " values ";
		$sql .= "($data,'$hora','$proto','$cod')";
		$rlt = db_query($sql);
	}

	function protocolo_status($sta) {
		$sql = "select * from " . $this -> tabela;
		$sql .= " where doc_autor_principal = '" . $this -> doc_autor_principal . "' ";
		if ($sta != '') { $wh = " and doc_status = '" . $sta . "' ";
		}
		if ($sta == 'B') { $wh = " and (doc_status = 'B' or doc_status='H') ";
		}

		$sql .= $wh;
		$sql .= " and ((doc_status <> 'X') and (doc_status <> 'Z'))";
		$sql .= " order by doc_status, doc_protocolo desc ";

		$rlt = db_query($sql);
		$rst = array();
		while ($line = db_read($rlt)) { array_push($rst, $line);
		}
		return ($rst);
	}

	function protocolo_altera_status($proto, $de, $para) {
		$sql = "select * from " . $this -> tabela;
		$sql .= " where doc_autor_principal = '" . $this -> doc_autor_principal . "' ";
		$sql .= " and doc_protocolo = '" . $proto . "' ";
		$sql .= " and doc_status = '" . $de . "' ";

		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			$this -> protocolo_log($proto, '#status_' . $para);

			$sql = "update " . $this -> tabela . " set doc_status = '" . $para . "' ";
			$sql .= " where doc_autor_principal = '" . $this -> doc_autor_principal . "' ";
			$sql .= " and doc_protocolo = '" . $proto . "' ";
			$sql .= " and doc_status = '" . $de . "' ";

			$rlt = db_query($sql);
		}
		return ($rst);
	}

	function protocolos_mostrar($rst) {
		global $colunas;
		$sx = '';
		$sx .= '<table class="tabela00 lt1" width="100%">';
		$sx .= '<TR><TH width="10%">' . msg('caae');
		$sx .= '<TH>' . msg('protocol_title');
		$sx .= '<TH width="7%"><nobr>' . msg('last_update');
		$sx .= '<TH width="7%">' . msg('status');
		$xsta = "X";
		$id = 0;
		//$sx .= '<TR bgcolor="#B0B0B0"><TD colspan=4 align="center"><font class="lt3">'.msg('approved_protocols').'</font>';
		for ($r = 0; $r < count($rst); $r++) {
			$id++;
			$line = $rst[$r];
			$sta = trim($line['doc_status']);
			$asta = '';
			if (strlen($sta == '')) { $sta = '@';
			}
			if ($sta == '$') { $asta = '<font color="red">' . msg('problem') . '</font>';
			}
			if ($sta == '@') { $asta = '<font color="green">' . msg('status_@');
			}
			if ($sta == 'A') { $asta = msg('status_A');
			}
			if ($sta == 'X') { $asta = msg('status_X');
			}
			if ($sta == '$') { $asta = msg('status_$');
			}
			if ($sta == 'H') { $asta = msg('status_H');
			}

			$cor = '';

			$page_link = '';
			if ($sta == '@') { $page_link = 'protocol_submit.php';
			}
			if ($sta == 'A') { $page_link = 'protocol_detalhe.php';
			}
			if ($sta == '$') { $page_link = 'protocol_submit_detalhe.php';
				$cor = '<font color="red">';
			}

			$id = $line['id_doc'];

			$link = '<a href="' . $page_link . '?dd0=' . $id . '&dd90=' . checkpost($id) . '" class="link">';

			$tit = trim($line['doc_1_titulo']);
			if (strlen($tit) == 0) { $tit = msg('not_definid');
			}

			$sx .= '<TR valign="top	">';
			$sx .= '<TD>' . $line['doc_protocolo'];
			$sx .= '<TD>';
			$sx .= $link . $cor;
			$sx .= $tit;
			$sx .= '<TD>';
			$sx .= '<font class="lt0">';
			$sx .= msg('update') . ' ' . stodbr($line['doc_dt_atualizado']);

			$sx .= '<TD><nobr>' . $link . $cor;
			$sx .= $asta;
		}
		if (count($rst) == 0) { $sx = '';
		}

		return ($sx);
	}

	function updatex() {
		global $base;
		$c = 'doc';
		$c1 = 'id_' . $c;
		$c2 = $c . '_protocolo';
		$c3 = 7;
		$sql = "update " . $this -> tabela . " set $c2 = lpad($c1,$c3,0) where $c2='' ";
		if ($base == 'pgsql') { $sql = "update " . $this -> tabela . " set $c2 = trim(to_char(id_" . $c . ",'" . strzero(0, $c3) . "')) where $c2='' ";
		}
		$rlt = db_query($sql);
	}

}