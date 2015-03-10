<?php

// Inizializzazione dell'array di sessione per i campi obbligatori omessi e di tipo errato
if (!isset($_SESSION['mm_omitted']))
	$_SESSION['mm_omitted'] = array();
if (!isset($_SESSION['mm_wrongtype']))
	$_SESSION['mm_wrongtype'] = array();

function sGetHtmlField (
	$sArgFieldName, 					//nome del campo html
	$sArgDescription, 				//etichetta
	$iArgType = FLD_TYPE_TXT, 		//tipo di campo (combo, options, ecc)
	$iArgRequired = OBB_FACOLTATIVO, 	//obbligatorietˆ
	$iArgMaxLenght = 50, 				//lunghezza massima
	$mArgOptions = null, 				//valori in lista (per options e combo)
	$mArgSelectedValues = null, 		//valore o valori selezionati
	$bNoEmptyVal	= false,				//flag che non fa apparire il valore vuoto
	$sArgLongDescription = '', 		//descrizione lunga
	$sArgHtmlFieldCssClass = '', 		//classe css da associare in particolare
	$iArgArrayIndex = -1 			//indice, se fa parte di un array di controlli
) {

	// Inizializzo
	$sCssClass = '';
	$sHtmlField = '';

	// Imposto $sArrayIndex a seconda che il campo faccia parte o meno di un array di controlli
	if (is_null($iArgArrayIndex)) $iArgArrayIndex = -1;
	switch ($iArgArrayIndex) {
		case -1:
			$sArrayIndex = '';
			$iArrayIndex = null;
			break;
		case -2:
			$sArrayIndex = '[]';
			$iArrayIndex = null;
			break;
		default:
			$sArrayIndex = "[$iArgArrayIndex]";
			$iArrayIndex = "$iArgArrayIndex";
			break;
	}

	switch ($iArgType) {
		case FLD_TYPE_TXT:
		case FLD_TYPE_NUMBER:
		case FLD_TYPE_PWD:
			/* TEXTBOX */
			$mArgSelectedValues = stripslashes($mArgSelectedValues);
			if ($iArgType != FLD_TYPE_PWD) $sHtmlType = 'text'; else $sHtmlType = 'password';
			$sHtmlField .= "<input type=\"$sHtmlType\" name=\"{$sArgFieldName}{$sArrayIndex}\" id=\"{$sArgFieldName}{$iArrayIndex}\" value=\"$mArgSelectedValues\" maxlength=\"$iArgMaxLenght\" class=\"$sArgHtmlFieldCssClass\" />";
			$sHtmlField .= $sArgLongDescription;
			break;
		case FLD_TYPE_LONG_TXT:
			/* LARGE TEXTBOX */
			$mArgSelectedValues = stripslashes($mArgSelectedValues);
			$sHtmlField .= "<textarea rows=\"5\" cols=\"80\" name=\"{$sArgFieldName}{$sArrayIndex}\" id=\"{$sArgFieldName}{$iArrayIndex}\" class=\"$sArgHtmlFieldCssClass\">$mArgSelectedValues</textarea>";
			$sHtmlField .= $sArgLongDescription;
			break;
		case FLD_TYPE_CMB:
			/* COMBOBOX (SELECT) */
			$sSelectNone = (is_null($mArgSelectedValues) || $mArgSelectedValues == 'null')?'selected="selected"':'';
			$sHtmlField .= "<select name=\"$sArgFieldName$sArrayIndex\" id=\"$sArgFieldName$iArrayIndex\">";
			if (!$bNoEmptyVal) $sHtmlField .= "<option value=\"null\" $sSelectNone>(selezionare)</option>";
			if (is_array($mArgOptions)) {
				foreach ($mArgOptions as $rowArgOption) {
					$sSelected = (!is_null($mArgSelectedValues) && ($rowArgOption['value'] == $mArgSelectedValues))?'selected="selected"':'';
					$sHtmlField .= "<option value=\"{$rowArgOption['value']}\" $sSelected>{$rowArgOption['label']}</option>";
				}
			}
			$sHtmlField .= "</select>";
			$sHtmlField .= $sArgLongDescription;
			$sCssClass = "combo";
			break;
		case FLD_TYPE_OPT:
			/* OPTIONS (RADIOBUTTON) */
			$sCheckNone = (is_null($mArgSelectedValues) || $mArgSelectedValues == 'null')?'checked="checked"':'';
			if (!$bNoEmptyVal) $sHtmlField .= "<label><input type=\"radio\" name=\"$sArgFieldName$sArrayIndex\" id=\"{$sArgFieldName}_null{$iArrayIndex}\" $sCheckNone value=\"null\" /> (selezionare)</label>\n";
			//print_r($sArgFieldName . '<br>');
			if (is_array($mArgOptions)) {
				foreach ($mArgOptions as $rowArgOption) {
					//print_r($rowArgOption['value'] . ' == ' . $mArgSelectedValues . '<br>');
					$sChecked = (!is_null($mArgSelectedValues) && ($rowArgOption['value'] == $mArgSelectedValues))?'checked="checked"':'';
					$sHtmlField .= "<label><input type=\"radio\" name=\"{$sArgFieldName}{$sArrayIndex}\" id=\"{$sArgFieldName}_{$rowArgOption['value']}{$iArrayIndex}\" $sChecked value=\"{$rowArgOption['value']}\" /> {$rowArgOption['label']}</label>\n";
				}
			}
			$sHtmlField .= "<div class=\"clearer\"></div>";
			$sHtmlField .= $sArgLongDescription;
			$sCssClass = "option";
			break;
		case FLD_TYPE_CHK:
			/* CHECK BOX */
			if (is_array($mArgOptions)) {
				$bSelectedValuesIsArray = is_array($mArgSelectedValues);
				foreach ($mArgOptions as $rowArgOption) {
					if (is_null($mArgSelectedValues)) {
						$bChecked = false;
					} else {
						// Valuto diversamente a seconda che i valori preselezionati siano array o no
						if ($bSelectedValuesIsArray) {
							$bChecked = in_array($rowArgOption['value'], $mArgSelectedValues);
						} else {
							$bChecked = $rowArgOption['value'] == $mArgSelectedValues;
						}
					}
					$sChecked = ($bChecked) ? 'checked="checked"' : '';
					$sHtmlField .= "<label><input type=\"checkbox\" name=\"{$sArgFieldName}{$sArrayIndex}\" id=\"{$sArgFieldName}_{$rowArgOption['value']}{$iArrayIndex}\" $sChecked value=\"{$rowArgOption['value']}\" /> {$rowArgOption['label']}</label>\n";
				}
			}
			$sHtmlField .= "<div class=\"clearer\"></div>";
			$sHtmlField .= $sArgLongDescription;
			$sCssClass = "option";
			break;
		case FLD_TYPE_SRCH_TXT:
			/* SEARCHYTEXT */
			// Inizializzazione variabili di nome
			$sSearchFieldId        = $sArgFieldName.'_src'.$iArrayIndex;
			$sSearchButtonId       = $sArgFieldName.'_btn'.$iArrayIndex;
			$sSearchQueryPartId    = $sArgFieldName.'_qry'.$iArrayIndex;
			$sSearchResultPartId   = $sArgFieldName.'_rst'.$iArrayIndex;
			$sLabelFieldName       = $sArgFieldName.'_lbl'.$sArrayIndex;
			$sLabelFieldId         = $sArgFieldName.'_lbl'.$iArrayIndex;
			$sLongLabelFieldName   = $sArgFieldName.'_lnglbl'.$sArrayIndex;
			$sLongLabelFieldId     = $sArgFieldName.'_lnglbl'.$iArrayIndex;
			$sEditButtonId         = $sArgFieldName.'_edt'.$iArrayIndex;
			$sModifyButtonId       = $sArgFieldName.'_mod'.$iArrayIndex;
			$sValueFieldName       = $sArgFieldName.$sArrayIndex;
			$sValueFieldId         = $sArgFieldName.$iArrayIndex;
			// Inizializzazione della tabella per la select dei valori
			switch ($mArgOptions) {
				case 'edi': $sTableToSelectFrom = 'v_edifici_popup'; break;
				case 'aas': $sTableToSelectFrom = 'v_medicine_di_gruppo_popup'; break;
				case 'cpu': $sTableToSelectFrom = 'v_computers_popup'; break;
				case 'col': $sTableToSelectFrom = 'v_collaboratori_popup'; break;
				case 'ret': $sTableToSelectFrom = 'v_reti_popup'; break;

			}
			// Guardo se il campo dev'essere gi&agrave; valorizzato oppure no
			if ($mArgSelectedValues != null) {
				// Campo gi&agrave; valorizzato
				global $oConnFb;
				$sSql = "select * from $sTableToSelectFrom t where t.value = $mArgSelectedValues";
				$rstValori = rsGetAll($oConnFb, $sSql);
				$sInitialLabel = htmlentities($rstValori[0]['label']);
				$sInitialLongLabel = str_replace('\n', chr(13), htmlentities($rstValori[0]['longlabel']));
				$sInitialValue = htmlentities($rstValori[0]['value']);
				$sSearchyResultPartStyle = "";
				$sSearchyQueryPartStyle = "display:none";
			} else {
				// Campo non valorizzato
				$sInitialLabel = '';
				$sInitialValue = '';
				$sInitialLongLabel = '';
				$sSearchyResultPartStyle = "display:none";
				$sSearchyQueryPartStyle = "";
			}
			// Composizione dell'html del campo
			$sHtmlField .=
				"<div class=\"searchyQueryPart\" id=\"$sSearchQueryPartId\" style=\"$sSearchyQueryPartStyle\">" .
				"<div>$sArgLongDescription</div>" .
				"<input type=\"text\" id=\"$sSearchFieldId\" class=\"searchySearch\" onkeypress=\"if (event.which==13) {getElementById('$sSearchButtonId').click(); return false;}\" />" .
				"<input type=\"button\" id=\"$sSearchButtonId\" value=\"Cerca\" class=\"searchySearchBtn\" onclick=\"searchyTextPopupOpen('$mArgOptions', $sSearchFieldId.value, '$sArgFieldName', '$iArrayIndex', '$sTableToSelectFrom', '".URL_ROOT."')\" />" .
				"</div>" .
				"<div class=\"searchyResultPart\" id=\"$sSearchResultPartId\" style=\"$sSearchyResultPartStyle\">" .
				"<textarea name=\"$sLongLabelFieldName\" id=\"$sLongLabelFieldId\" class=\"searchyLongLabel\" readonly=\"readonly\">$sInitialLongLabel</textarea>" .
				"<input type=\"hidden\" name=\"$sLabelFieldName\" id=\"$sLabelFieldId\" value=\"$sInitialLabel\" />" .
				"<input type=\"hidden\" name=\"$sValueFieldName\" id=\"$sValueFieldId\" value=\"$sInitialValue\" />" .
				"<input type=\"button\" id=\"$sEditButtonId\" value=\"&lsaquo; Seleziona Altro\" class=\"searchyEditBtn\" onclick=\"searchyTextEdit('$sArgFieldName', '$iArrayIndex')\" />" .
				"<input type=\"button\" id=\"$sModifyButtonId\" value=\"&lsaquo; Modifica Questo\" class=\"searchyModifyBtn\" onclick=\"searchyTextModify('$mArgOptions', $sValueFieldId.value, '$sArgFieldName', '$iArrayIndex', '$sTableToSelectFrom', '".URL_ROOT."')\" />" .
				"</div>";
			break;
	}

	/*
	 * Imposto il livello di obbligatoriet&agrave;
	 * */
	$sCodedFieldName = (is_null($iArrayIndex)) ? $sArgFieldName : $sArgFieldName.'|'.$iArrayIndex;
	switch ($iArgRequired) {
		case OBB_OBBLIGATORIO:
			$sRequiredDescription = 'Campo obbligatorio';
			$sRequiredSymbol = '*';
			$sRequiredField = '<input type="hidden" name="campiObbligatori[]" value="'.$sCodedFieldName.'" />';
			break;
		case OBB_FACOLTATIVO:
			$sRequiredDescription = 'Campo facoltativo';
			$sRequiredSymbol = '&nbsp;';
			$sRequiredField = '';
			break;
	}
	
	/*
	 * Imposto il tipo di dato
	 * */
	switch ($iArgType) {
		case FLD_TYPE_TXT:
			$sType = 'TEXT';
			break;
		case FLD_TYPE_NUMBER:
			$sType = 'NUMERIC';
			break;
	}
	$sTypeField = '<input type="hidden" name="campiTipi['.$sCodedFieldName.']" value="'.$sType.'" />';

	/*
	 * Controllo che il campo che sto renderizzando non sia stato omesso in precedenza
	 * */

	// Check e assegnazione della classe CSS
	if (in_array($sArgFieldName.$sArrayIndex, $_SESSION['mm_omitted'])) {
		$sClasseCampoOmesso = 'campoOmesso';
	} elseif (in_array($sArgFieldName.$sArrayIndex, $_SESSION['mm_wrongtype'])) {
		$sClasseCampoOmesso = 'campoOmesso';
	} else {
		$sClasseCampoOmesso = '';
	}

	/*
	 * Qua compongo la megastringona per renderizzare il campo, e la ritorno
	 * */

//	return "<!-- $sArgFieldName | $sArgDescription -->\n" .
//		"<div class=\"fieldRow $sClasseCampoOmesso\">\n" .
//		"<label class=\"label\" for=\"$sArgFieldName\">$sArgDescription</label>\n" .
//		"<div class=\"required\"><abbr title=\"$sRequiredDescription\">$sRequiredSymbol</abbr>$sRequiredField</div>\n" .
//		"<div class=\"$sCssClass field\">$sHtmlField</div>\n" .
//		"<div class=\"clearer\"></div>\n" .
//		"</div>";

	return "<!-- $sArgFieldName | $sArgDescription -->\n" .
		"<tr class=\"$sClasseCampoOmesso\">\n" .
		"<td class=\"label\"><label for=\"$sArgFieldName\">$sArgDescription</label></td>\n" .
		"<td class=\"required\"><abbr title=\"$sRequiredDescription\">$sRequiredSymbol</abbr>$sRequiredField $sTypeField</td>\n" .
		"<td class=\"$sCssClass field\">$sHtmlField</td>\n" .
		"</tr>";
}
?>