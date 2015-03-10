<?php
require_once(FS_ROOT.'lib/db.php');

/**
 * Funzione che fa una query standard (select * from tabella where order)
 * @return Array recordset ritornato
 * @param $sTable Nome della tabella in cui cercare
 * @param $aFilter Filtro da applicare nomecampo->valore
 * @param $aOrder Campi per cui ordinare
 */
function rsStandardQuery($sTable, $aFilter = array(), $aOrder = array()) {
	global $oConnFb;
	$sWhereClause = sGetWhereClause($aFilter);
	$sOrderByClause = sGetOrderByClause($aOrder);
	$sSql = "select * from $sTable $sWhereClause $sOrderByClause";
	return rsGetAll($oConnFb, $sSql);
}

function rsGetProvince($aFilter = array(), $aOrder = array()) {
	return rsStandardQuery('e_province', $aFilter, $aOrder);
}

function rsGetProvince_tutte() {
	$aOrders = array('prv_key' => 'asc');
	return rsGetProvince(
		array(), //filter
		$aOrders //order
	);
}

function rsGetProvince_una($sArgPrvKey) {
	$aFilters = array('prv_key' => $sArgPrvKey);
	return rsGetProvince($aFilters);
}


function rsGetDistributori($aFilter = array(), $aOrder = array()) {
	return rsStandardQuery('e_distributori', $aFilter, $aOrder);
}

function mGetCountDistributori($oArgConn, $aFilter = array()) {
	$sWhereClause = sGetWhereClause($aFilter);
	$sSql = "SELECT COUNT(e_distributori.dst_id) AS count_dst_id
		FROM e_distributori $sWhereClause";
	return mGetOne($oArgConn, $sSql);
}

function mGetCountProvinceConDistributore($oArgConn) {
	$sSql = "SELECT COUNT(distinct e_distributori.dst_fk_prv_key) AS count_prv_key
		FROM e_distributori";
	return mGetOne($oArgConn, $sSql);
}

function mGetCountDistributoriInProvincia($oArgConn, $sArgProvincia) {
	$sWhereClause = sGetWhereClause(array('dst_fk_prv_key' => $sArgProvincia));
	$sSql = "SELECT COUNT(e_distributori.dst_id) AS count_dst_id
		FROM e_distributori $sWhereClause";
	return mGetOne($oArgConn, $sSql);
}

function rsGetProvinceEConteggioDistributori ($oArgConn) {
	$sSql = 'SELECT COUNT(e_distributori.dst_id) AS count_dst_id,
		e_province.prv_key,
		e_province.prv_provincia,
		e_province.prv_lat,
		e_province.prv_lng
	FROM e_province LEFT OUTER JOIN e_distributori ON e_province.prv_key = e_distributori.dst_fk_prv_key
	GROUP BY e_distributori.dst_fk_prv_key, e_province.prv_provincia, e_province.prv_lat, e_province.prv_lng
	ORDER BY e_province.prv_provincia ASC';
	return rsGetAll($oArgConn, $sSql);
}

function rsGetSegnalazioni($aFilter = array(), $aOrder = array()) {
	return rsStandardQuery('e_segnalazioni_nuovi', $aFilter, $aOrder);
}

function rsGetSegnalazioni_una($sArgSgnId) {
	$aFilters = array('sgn_id' => $sArgSgnId);
	return rsGetSegnalazioni($aFilters);
}

function iUpdateSegnalazioni($aFieldsAndValues, $aFilter) {
	global $oConnFb;
	$sWhereClause = sGetWhereClause($aFilter);
	$aTemp = array();
	foreach ($aFieldsAndValues as $sField => $sValue) {
		$aTemp[] = $sField.' = '.$sValue;
	}
	$sAssegnazioni = implode(', ',$aTemp);
	$sSql = "update e_segnalazioni_nuovi set $sAssegnazioni $sWhereClause";
	return iExecuteQuery($oConnFb, $sSql);
}

function rsGetSegnalazioniVarie($aFilter = array(), $aOrder = array()) {
	return rsStandardQuery('e_segnalazioni_varie', $aFilter, $aOrder);
}

function rsGetRegistrazioni($aFilter = array(), $aOrder = array()) {
	return rsStandardQuery('e_aziende', $aFilter, $aOrder);
}
?>