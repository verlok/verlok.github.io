<?php
/**
 * Rende un valore stringa passato pronto per essere dato in pasto ad una stringa SQL.
 * - Il parametro iArgWhere consente di decidere dove ricercare nel campo
 */
function sMakeSearchable($sArgSearch = '', $iArgWhere = MTC_WHOLE) {
	$sBaseSearch = str_replace("'", "''", strtolower(stripslashes($sArgSearch)));
	switch ($iArgWhere) {
		case MTC_WHOLE:
			return "'$sBaseSearch'";
		case MTC_START:
			//col percento alla fine
			return "'$sBaseSearch%'";
		case MTC_MIDDLE:
			//col percento su entrambi i lati
			return "'%$sBaseSearch%'";
		case MTC_END:
			//col percento all'inizio
			return "'%$sBaseSearch'";
		default:
			return "'$sBaseSearch'";
	}
}

// Converte la data italiana in formato mysql
function sDateMySql ($argDateIt) {
	$aData = explode ('/', $argDateIt);
	if (count($aData) != 3) return '0000-00-00';
	$sGiorno = $aData[0];
	$sMese = $aData[1];
	$sAnno = $aData[2];
	return ("$sAnno-$sMese-$sGiorno");
}

function sMakeSqlable($sArgString = '', $iArgType = SQL_TYPE_STRING, $sArgDecimalSep = ',') {
	$sBaseString = str_replace("'", "''", stripslashes($sArgString));
	switch ($iArgType) {
		case SQL_TYPE_STRING:
			return '\''.utf8_decode($sBaseString).'\'';
		case SQL_TYPE_NUMBER:
			if ($sBaseString == '')
				return "null";
			else
				// Se il separatore decimale è la virgola (default, italiano) vengono eliminati i punti
				if ($sArgDecimalSep == ',') $sBaseString = str_replace('.', '', $sBaseString);
				// Il separatore dei decimali, qualunque esso sia, viene sostituito con il punto
				$sBaseString = str_replace($sArgDecimalSep, '.', $sBaseString);
				return "$sBaseString";
		case SQL_TYPE_DATE:
			$sDate = sDateMySql($sArgString);
			return "'$sDate'";
		default:
			return "'$sBaseString'";
	}
}


function sMakeScriptable($sArgString = '') {
	return str_replace("'", "\'", $sArgString);
}

function nPrintDebug($mArgVariable, $sArgTitle = null) {
	echo "<div class=\"debug\">\n";
	if ($sArgTitle)
		echo "<p>$sArgTitle</p>\n";
	echo "<pre>\n";
	print_r($mArgVariable);
	echo "</pre>\n" .
		"</div>\n";
}

function iTranslateIdIfNeeded ($iArgId, $sArgIndex, $aArgIdTranslation) {
	// Se iArgId e' minore di zero, lo traduce nel nuovo, altrimenti ritorna iArgId stesso
	if ($iArgId < 0)
		return $aArgIdTranslation[$sArgIndex][$iArgId];
	else
		return $iArgId;
}

function redirect_header($sUrl) {
	header ('Location: ' . $sUrl);
}

/* Funzione che tira fuori un nuovo amb_id */
function iGetNewId($sArgSessionIndex) {
	// Se era gi&agrave; settato il valore, lo decremento, altrimento lo imposto a -1;
	if (isset($_SESSION[$sArgSessionIndex])) {
		$_SESSION[$sArgSessionIndex]--;
	} else {
		$_SESSION[$sArgSessionIndex] = -1;
	}
	// Ritorna il valore
	return $_SESSION[$sArgSessionIndex];
}

function sDecodificaMese($sMese) {
	$iMese = intval($sMese);
	$aMesi = array(1 => 'Gennaio', 2 => 'Febbraio', 3 => 'Marzo', 4 => 'Aprile', 5 => 'Maggio', 6 => 'Giugno', 7 => 'Luglio', 8 => 'Agosto', 9 => 'Settembre', 10 => 'Ottobre', 11 => 'Novembre', 12 => 'Dicembre');
	return $aMesi[$iMese];
}

function rstGetAllMonths() {
	$aReturn = array();
	for ($i=1; $i<13; $i++) {
		$aReturn[] = array('value' => $i, 'label' => sDecodificaMese($i));
	}
	return $aReturn;
}

function rstGetAllYears() {
	$aReturn = array();
	for ($i=2006; $i<2011; $i++) {
		$aReturn[] = array('value' => $i, 'label' => $i);
	}
	return $aReturn;
}

function aGetMonthVariables($aArgGet) {
	return array(
	'iMese' => $aArgGet['m'],
	'sMese' => sDecodificaMese($aArgGet['m']),
	'iAnno' => $aArgGet['a'],
	'sDataDa' => $aArgGet['a'].'-'.$aArgGet['m'].'-01',
	'sDataA' => $aArgGet['a'].'-'.$aArgGet['m'].'-31'
	);
}

//function sGetMysqlDateFrom($iArgDay, $iArgMonth, $iArgYear) {
//	return $iArgYear.'-'.$iArgMonth.'-'.$iArgDay;
//}

function rstGetProvince($oArgConn) {
	$sSql = "SELECT prv_key as value, prv_provincia as label FROM e_province ORDER BY prv_provincia";
	$rstRS = rsGetAll($oArgConn, $sSql);
	return $rstRS;
}

function sH($sArgString) {
	return nl2br(htmlentities($sArgString));
}

function echoh($sArgString) {
	echo sH($sArgString);
	}

?>