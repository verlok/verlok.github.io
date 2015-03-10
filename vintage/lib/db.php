<?php
require_once ('MDB2.php');

function oConnect($sArgDsn) {
  $oConn =& MDB2::connect($sArgDsn);
  if (PEAR::isError($oConn)) {
      die($oConn->getMessage());
  }
  $oConn->setFetchMode(MDB2_FETCHMODE_ASSOC);
  $oConn->options['seqname_format'] = '%s';
  return $oConn;
}

function rsGetAll($mdb2, $sql) {
    $res =& $mdb2->query($sql);
    if (PEAR::isError($res))
        die($res->getMessage() . " SQL: <pre>$sql</pre>");
    return $res->fetchAll();
}

function rstGetCol($mdb2, $sql) {
    $res =& $mdb2->query($sql);
    if (PEAR::isError($res))
        die($res->getMessage() . " SQL: <pre>$sql</pre>");
    return $res->fetchCol(0);
}

function mGetOne($mdb2, $sql) {
    $res =& $mdb2->query($sql);
    if (PEAR::isError($res))
        die($res->getMessage() . " SQL: <pre>$sql</pre>");
    return $res->fetchOne(0);
}

function rowGetRow($mdb2, $sql) {
    $res =& $mdb2->query($sql);
    if (PEAR::isError($res))
        die($res->getMessage() . " SQL: <pre>$sql</pre>");
    return $res->fetchRow();
}

function iExecuteQuery($mdb2, $sql, $bGestisciErrore = false) {
  $affected =& $mdb2->exec($sql);
  if (PEAR::isError($affected)) {
    // Errore
    if ($bGestisciErrore) {
      // Errore gestito
      return $affected;
    } else {
      // Errore non gestito
      die($affected->getMessage() . " SQL: <pre>$sql</pre>");
    }
  } else {
  	//Nessun errore
  	return $affected;
  }
}

function sGetWhereClause($aFilter = array(), $sOperator = 'and') {
	// USCITA RAPIDA: array vuoto
	if (empty($aFilter)) return '';

	// COMPOSIZIONE DELLA WHERE CLAUSE
	// Formato di $aFilter: array. 0: nome del campo, 1: valore da filtrare, 2: operatore (se non specificato viene considerato "=")
	global $oConnFb;
	$aWhereClauses = array();
	foreach ($aFilter as $sFilterClauseKey => $sFilterClauseValue) {
		$sWhereClause = $sFilterClauseKey . '=' . $oConnFb->quote($sFilterClauseValue);
		$aWhereClauses[] = $sWhereClause;
	}
	return 'where '.implode(' '.$sOperator.' ', $aWhereClauses);
}

function sGetOrderByClause($aOrder = array()) {
	// USCITA RAPIDA: array vuoto
	if (empty($aOrder)) return '';

	// COMPOSIZIONE DELLA ORDER BY CLAUSE
	// Formato di $aOrder: array: NomeDelCampo => Ordine (se non specificato viene considerato "asc")
	$aOrderByClauses = array();
	foreach ($aOrder as $sOrderClauseField => $sOrderClauseValue) {
		//Definizione
		$sOrderClause = $sOrderClauseField;
		if (!empty($sOrderClauseValue)) $sOrderClause .= ' '.$sOrderClauseValue;
		//Assegnazione
		$aOrderByClauses[] = $sOrderClause;
	}
	return 'order by '.implode(',', $aOrderByClauses);
}

/*function sRaddoppiaApici($parStr) {
  return str_replace("'", "''", $parStr);
}*/

$oConnFb = oConnect(DSN_SIMMG);
?>