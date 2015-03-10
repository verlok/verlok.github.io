<?php
// Funzione PHP che restituisce l'indirizzo completo, da inserire nel fumetto e nell'elenco a lato
function sGetIndirizzoCompleto ($aArgDistributore) {
	extract ($aArgDistributore);
	return $dst_citta . ' ('. $dst_fk_prv_key . '), ' . $dst_indirizzo;
}

// Funzione PHP che restituisce la descrizione completa, in formato solo testo (no HTML!)
function sGetDistrTextDescription ($aArgDistributore, $iLimit = null) {
	extract ($aArgDistributore);
	$aDistrDescription = array();
	if ($dst_note) $aDistrDescription[] = 'Note: '.$dst_note;
	if ($dst_allevatore) $aDistrDescription[] = 'Allevatore: '.$dst_allevatore;
	if ($dst_telefono) $aDistrDescription[] = 'Tel: '.$dst_telefono;
	if ($dst_cellulare) $aDistrDescription[] = 'Cell: '.$dst_cellulare;
	$sDistrDescription = implode("\n",$aDistrDescription);
	if (count($aDistrDescription)) $sDistrDescription = implode("\n",$aDistrDescription); else $sDistrDescription = 'Nessuna informazione aggiuntiva.';
	if (!empty($iLimit) && strlen($sDistrDescription)>$iLimit) $sDistrDescription = substr($sDistrDescription, 0, $iLimit).'...';
	return $sDistrDescription;
}

// Funzione PHP che restituisce la descrizione completa, in formato HTML (per fumetto!)
function sGetDistrHtmlDescription ($aArgDistributore) {
	
	extract ($aArgDistributore);
	$dst_note = htmlentities($dst_note);
	$dst_allevatore = htmlentities($dst_allevatore);
	$aDistrDescription = array();
	if ($dst_foto) $aDistrDescription[] = '<img class="distr_pic" src="'.URL_ROOT.'images/aziende/distributori/'.$dst_foto.'">';
	if ($dst_note) $aDistrDescription[] = '<p>Note: '.$dst_note.'</p>';
	if ($dst_logo) $aDistrDescription[] = '<img class="az_logo" src="'.URL_ROOT.'images/aziende/loghi/'.$dst_logo.'">';
	if ($dst_allevatore) $aDistrDescription[] = '<p>Allevatore: '.$dst_allevatore.'</p>';
	if ($dst_telefono) $aDistrDescription[] = '<p>Telefono: '.$dst_telefono.'</p>';
	if ($dst_cellulare) $aDistrDescription[] = '<p>Cellulare: '.$dst_cellulare.'</p>';
	if ($dst_email) $aDistrDescription[] = '<p>Email: <a href="mailto:'.$dst_email.'?subject=Contatto da www.milkmaps.com">'.$dst_email.'</a></p>';
	if ($dst_sito) $aDistrDescription[] = '<p>Sito internet: <a href="http://'.str_replace('http://','',$dst_sito).'?referer=www.milkmaps.com" target="_blank">'.$dst_sito.'</a></p>';
	$sDistrDescription = (count($aDistrDescription)) ? implode("\n",$aDistrDescription) : '<p>Nessuna informazione aggiuntiva.</p>';
	$sCommands = '<p>'.
		'<a href="#" onclick="myZoomTo('.$dst_id.'); myShowZoomLink('.$dst_id.', \'out\'); return false;" style="margin-right:0.5em;" id="in'.$dst_id.'">Ingrandisci qui &raquo;</a>'.
		'<a href="#" onclick="myAutoZoom(aDistributori); myShowZoomLink('.$dst_id.', \'in\'); return false;" style="margin-right:0.5em; display:none;" id="out'.$dst_id.'">&laquo; Visualizza tutti</a>'.
		'<a href="#" onclick="getDirections('.$dst_id.'); return false;" style="margin-right:0.5em;">Indicazioni stradali</a>' .
		'</p>';
	return $sDistrDescription . $sCommands;
}

// Funzione PHP che restituisce la descrizione completa, in formato HTML (per fumetto!)
function sGetProvHtmlDescription ($aArgProvincia) {
	
	extract ($aArgProvincia);
	$aProvDescription = array();
	if ($count_dst_id) {
		$aProvDescription[] = '<p>In questa provincia sono presenti '.$count_dst_id.' distributori di latte crudo.</p>';
		$aProvDescription[] = '<p><a href="?z='.$prv_key.'#down">Entra e visualizza distributori</a></p>';
	} else {
		$aProvDescription[] = '<p>In questa provincia non sono presenti distributori di latte crudo. :-(</p>';
		$aProvDescription[] = '<p><a href="?z='.$prv_key.'#down">Entra comunque</a></p>';
	}
	return implode("\n",$aProvDescription);
}

// Funzione PHP che restituisce una stringa adatta all'inserimento nel javascript
function sGetJsString ($sArgString) {
	$sRet = $sArgString;
	$sRet = str_replace("'", "\'", $sRet);
	$sRet = str_replace("\n", ' ', $sRet);
	return $sRet;
}

// Funzione PHP che restituisce un array contenente le coordinate dei distributori nel recordset passato
function sGetJsCodeArrayDistributori($rsArgDistributori) {
	$sOutput = 'aDistributori = new Array();'; 
	$i=0;
	foreach ($rsArgDistributori as $aDistributore) {
		extract($aDistributore);
		$sOutput .= "aDistributori[$i] = new Array($dst_id, $dst_lat, $dst_lng, '" . 
		'<h3>' . sGetJsString(sH(sGetIndirizzoCompleto($aDistributore))) . '</h3>' . 
		'<div>' . sGetJsString(sGetDistrHtmlDescription($aDistributore)) . '</div>' .
		"', '".sGetJsString(sH(sGetIndirizzoCompleto($aDistributore)))."');\n";
		$i++;
	}
	return $sOutput;
}

// Funzione PHP che restituisce un array contenente le coordinate delle province nel recordset passato
function sGetJsCodeArrayProvince($rsArgProvince) {
	$sOutput = 'aProvince = new Array();'; 
	$i=0;
	foreach ($rsArgProvince as $aProvincia) {
		extract($aProvincia);
		if ($count_dst_id) {
			$sOutput .= "aProvince[$i] = new Array('$prv_key', $prv_lat, $prv_lng, '" . 
			'<h3>' . sGetJsString('Provincia di '.$prv_provincia) . '</h3>' . 
			'<div>' . sGetJsString(sGetProvHtmlDescription($aProvincia)) . '</div>' .
			"');\n";
			$i++;
		}
	}
	return $sOutput;
}

// Funzione PHP che restituisce il JUMPER combo per saltare alla provincia direttamente
function sGetJumperProvince($rsArgProvince) {
	$aRet = array();
	$aRet[] = '<select name="cmbProvince" onchange="window.location=\'index.php?z=\'+this.value+\'#down\'" id="cmbProvince">';
	$aRet[] = '<option value="">-Selezione rapida-</option>';
	foreach ($rsArgProvince as $aProvincia) {
		extract ($aProvincia);
		$aRet[] = '<option value="'. $prv_key .'">';
		$aRet[] = sH($prv_provincia);
		if ($count_dst_id) {
			$aRet[] = ' ('.$count_dst_id.')';
		}
		$aRet[] = '</option>';
	}
	$aRet[] = '</select>';
	return implode ("\n", $aRet);
}

function nInsertMapsFunctions() {
?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAjAW3kWDtpiBAxlfB2N6oUxTTUupzMTQd8FcimyFFkB6g44OfIhSFq58aqUzThB4tqT3YbhFv-PLDUA" type="text/javascript"></script>
<script src="<?= URL_ROOT ?>lib/js/maps.js" type="text/javascript"></script>
<?php
}
?>
