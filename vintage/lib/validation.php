<?php
// Fa il controllo dei campi obbligatori nella form
function bPostIsValid ($aArgPost) {
	// Azzero la session dei campi omessi e di tipo errrato
	$_SESSION['mm_omitted'] = array();
	$_SESSION['mm_wrongtype'] = array();
	// Se non ci sono campi obbligatori da controllare, torno true (form valido!)
	if (!isset($aArgPost['campiObbligatori'])) return true;
	// Controllo ogni singolo campo per l'obbligatorietà
	foreach ($aArgPost['campiObbligatori'] as $campoObbligatorio) {
		// Divido il nome dall'indice
		$aDivision = explode('|', $campoObbligatorio);
		$sFieldName = $aDivision[0];
		$sFieldIndex = (isset($aDivision[1])) ? $aDivision[1] : null;
		// Setto il campo da verificare
		if (is_null($sFieldIndex)) {
			if ((empty($aArgPost[$sFieldName]) && $aArgPost[$sFieldName] != "0") || $aArgPost[$sFieldName] == 'null') {
				$_SESSION['mm_omitted'][] = $sFieldName;
			}
		} else {
			if ((empty($aArgPost[$sFieldName][$sFieldIndex]) && $aArgPost[$sFieldName][$sFieldIndex] != "0") || $aArgPost[$sFieldName][$sFieldIndex] == 'null') {
				$_SESSION['mm_omitted'][] = $sFieldName."[$sFieldIndex]";
			}
		}
	}
	
	// Controllo i tipi di dato dei campi
	foreach ($aArgPost['campiTipi'] as $campoNome => $campoTipo) {
		
		// Divido il nome dall'indice
		$aDivision = explode('|', $campoNome);
		$sFieldName = $aDivision[0];
		$sFieldIndex = (isset($aDivision[1])) ? $aDivision[1] : null;
		
		if ($campoTipo == 'NUMERIC') {
			if (is_null($sFieldIndex)) {
				if (!is_numeric($aArgPost[$sFieldName])) {
					$_SESSION['mm_wrongtype'][] = $sFieldName;
				}
			} else {
				if (!is_numeric($aArgPost[$sFieldName][$sFieldIndex])) {
					$_SESSION['mm_wrongtype'][] = $sFieldName."[$sFieldIndex]";
				} 
			}
		}
	}
	
	// Ritorno TRUE se il count dei campi omessi e' ZERO
	return (count($_SESSION['mm_omitted']) + count($_SESSION['mm_wrongtype']) == 0);
}
?>
