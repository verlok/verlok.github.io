<?php
function getPageFromSearchyType($sArgSearchyType) {
	switch ($sArgSearchyType) {
		case 'edi': return 'edificio.php';
		case 'aas':	return 'gruppo.php';
		case 'col':	return 'collaboratore.php';
		case 'cpu':	return 'computer.php';
		case 'ret':	return 'rete.php';
		default: return 'NOMATCH';
	}
}

function sGetPopupBadMessageHtml($oArgPearError) {
	$sHtml  = "<p class=\"warning\">";
	switch ($oArgPearError->code) {
		case -3:
			$sHtml .= "<strong>Indirizzo gi&agrave; esistente</strong>, non &egrave; necessario inserirlo di nuovo.";
			break;
		default:
			$sHtml .= "<strong>Si e' verificato un problema. L'indirizzo non e' stato inserito/modificato.";
			break;
	}
	$sHtml .= "</p>\n";
	$sHtml .= "\n<!-- ". $oArgPearError->message ." -->\n";
	return $sHtml;
}

function sGetPopupGoodMessageHtml() {
	return "<p class=\"information\">Operazione eseguita con successo.</p>";
}

function sGetPopupReturnScriptFunctionCall($rowArgValues) {
	return "returnValues('".sMakeScriptable($rowArgValues['value'])."', '".sMakeScriptable($rowArgValues['label'])."', '".sMakeScriptable($rowArgValues['longlabel'])."');";
}

function sGetPopupReturnScript($rowArgValues) {
	$sHtml  = "<script type=\"text/javascript\" language=\"javascript\">\n";
	$sHtml .= sGetPopupReturnScriptFunctionCall($rowArgValues);
	$sHtml .= "\n</script>\n";
	return $sHtml;
}

function sGetPopupReturnScriptFunction($sArgFieldsName, $sArgFieldsIndex) {
	$sHtml  = "<script language=\"JavaScript\" type=\"text/javascript\">\n";
	$sHtml .= 	"function returnValues(argValue, argLabel, argLongLabel) {\n";
	$sHtml .= 	"window.opener.searchyTextPopupReturn(argValue, argLabel, argLongLabel, '$sArgFieldsName', '$sArgFieldsIndex');\n";
	$sHtml .= 	"window.close();\n";
	$sHtml .= "}\n";
	$sHtml .= "</script>\n";
	return $sHtml;
}

function sGetPopupButtonsHtml($sArgAction, $sCallerUrl) {
	if ($sArgAction=='insert') {
		$sBtnLabel = 'Annulla';
		$sBtnOnClick = "window.location='$sCallerUrl'";
		$sSubmitLabel = 'Inserisci';
	} else {
		$sBtnLabel = 'Chiudi';
		$sBtnOnClick = 'window.close()';
		$sSubmitLabel = 'Modifica';
	}
	// Inizio il ritorno
	$sHtml  = "<input type=\"button\" name=\"btnCancel\" value=\"$sBtnLabel\" onclick=\"$sBtnOnClick\" />\n";
	$sHtml .= "<input type=\"submit\" name=\"btnSubmit\" value=\"$sSubmitLabel\" />\n";
	return $sHtml;
}
?>
