// searchyTextPopupOpen
// Apre una popup di ricerca per il controllo searchyText
// Chiamata dalla renderer.php con il seguente formato:
// searchyTextPopupOpen('edi', 'via baravelli', 'amb_fk_edi_id', '1', '/');

function searchyTextPopupOpen (argSearchType, argSearchedText, argFieldsName, argFieldsIndex, argTableToSelectFrom, argUrlRoot) {
	if (argSearchedText == '' || argSearchedText == ' ' || argSearchedText == '  ') {
	   alert ('Immettere prima un testo di ricerca nella casella di testo.');
	   return false;
	   // Il seguente codice ? ignorato
	   argSearchedText = prompt(
	       'La ricerca funziona sul testo immesso nello spazio a fianco.\n' +
	       'E\' comunque possibile immettere un testo di ricerca qui di seguito.\n' +
	       'Non immettendo alcun testo e premendo Ok, verranno visualizzati tutti i valori selezionabili.\n' +
	       'Facendo click su Annulla verra\' annullata la ricerca.');
	   if (argSearchedText == null) return false;
	}
	window.open (
		argUrlRoot + 'popups/searchyTextPopup.php' +
		'?searchType=' + argSearchType +
		'&searchedText=' + argSearchedText +
		'&fieldsName=' + argFieldsName +
		'&fieldsIndex=' + argFieldsIndex +
		'&tableToSelectFrom=' + argTableToSelectFrom,
		'_blank',
		'width=800,height=500,top=100,left=100,location=no,menubar=no,toolbar=no,resizable=yes,scrollbars=yes');
}

// searchyTextPopupReturn
// Chiude la popup di ricerca e torna al controllo searchyText chiamante
// Chiamata dalla searchyTextPopup.php con il seguente formato:
// searchyTextPopupReturn('1', 'via baravelli, cesenatico', 'amb_fk_edi_id', '1');
// Si noti che qui nella funzione vengono ricomposti i nomi dei campi della form,
// e devono essere ricomposti nello stesso modo in cui sono composti nella renderer.php, cio?
//
// $sSearchQueryPartId    = $sArgFieldName.'_qry'.$iArrayIndex;
// $sSearchResultPartId   = $sArgFieldName.'_rst'.$iArrayIndex;
// $sLabelFieldId         = $sArgFieldName.'_lbl'.$iArrayIndex;
// $sValueFieldId         = $sArgFieldName.$iArrayIndex;

function searchyTextPopupReturn (argValue, argLabel, argLongLabel, argFieldsName, argFieldsIndex) {
    // Assegna i valori
    document.getElementById(argFieldsName+argFieldsIndex).value = argValue;
    document.getElementById(argFieldsName+'_lbl'+argFieldsIndex).value = argLabel;
	document.getElementById(argFieldsName+'_lnglbl'+argFieldsIndex).value = argLongLabel;
	// Mostra il risultato
	document.getElementById(argFieldsName+'_rst'+argFieldsIndex).style.display = 'block';
	document.getElementById(argFieldsName+'_qry'+argFieldsIndex).style.display = 'none';
}

// searchyTextEdit
// Annulla i valori selezionati nel searchyText e mostra nuovamente la ricerca
function searchyTextEdit (argFieldsName, argFieldsIndex) {
    // Azzera i valori
    document.getElementById(argFieldsName+argFieldsIndex).value = '';
	document.getElementById(argFieldsName+'_lbl'+argFieldsIndex).value = '';
	document.getElementById(argFieldsName+'_lnglbl'+argFieldsIndex).value = '';
	// Mostra la ricerca
	document.getElementById(argFieldsName+'_rst'+argFieldsIndex).style.display = 'none';
	document.getElementById(argFieldsName+'_qry'+argFieldsIndex).style.display = 'block';
}

// searchyTextModify
// Apre una popup per modificare i valori presenti
function searchyTextModify (argSearchType, argSelectedId, argFieldsName, argFieldsIndex, argTableToSelectFrom, argUrlRoot) {
	window.open (
		argUrlRoot + 'popups/searchyTextPopupForEdit.php' +
		'?searchType=' + argSearchType +
		'&selectedId=' + argSelectedId +
		'&fieldsName=' + argFieldsName +
		'&fieldsIndex=' + argFieldsIndex +
		'&tableToSelectFrom=' + argTableToSelectFrom,
		'searchypopup',
		'width=650,height=300,top=100,left=100,location=no,menubar=no,toolbar=no,resizable=yes,scrollbars=yes');
}