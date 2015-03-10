<?php
require_once('../../config/config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//IT" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/pagina_standard.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Hi-dea Design, men&ugrave; del sito</title>
<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="head" -->
<meta name="Description" content="Spiegazione della realizzazione del men&ugrave; del sito di hi-dea design" />
<meta name="Keywords" content="Hi-dea, Design, Men&ugrave;, Sito, Macromedia, Flash, ActionScript, Interattivit&agrave;" />
<meta name="author" content="Andrea Verlicchi" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php $sPageKey="PORTFOLIO" ?>
<!--#include virtual="/lib/utils.php" -->
<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_controlShockwave(objStr,x,cmdName,frameNum) { //v3.0
  var obj=MM_findObj(objStr);
  if (obj) eval('obj.'+cmdName+'('+((cmdName=='GotoFrame')?frameNum:'')+')');
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<!-- InstanceEndEditable -->
<link href="<?php echo URL_ROOT ?>css/common.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
	<?php include(FS_ROOT . 'italiano/includes/header.php'); ?>
	<div id="contents"><!-- InstanceBeginEditable name="Contents" -->
		<div class="pagePath"><img src="<?php echo URL_ROOT ?>images/pathFolder.gif" alt="Percorso" width="15" height="13" /><a href="<?php echo URL_ROOT ?>index.php">Web Portfolio</a> &gt; Hi-dea design, men&ugrave; del sito </div>
		<div class="clearer"></div>
		<h1>Hi-dea design, men&ugrave; del sito</h1>
		<p><strong><a href="javascript:;" onclick="MM_openBrWindow('../../swf/hidea_sitemenu.swf','job','width=800,height=600')">Visualizza il men&ugrave; del sito di hi-dea design</a></strong></p>
		<p>S&igrave;, lo so che &egrave; scuro e che non c'&egrave; abbastanza contrasto tra gli elementi grafici e lo sfondo ma, ahim&egrave;, questo sito &egrave; incompleto.</p>
		<p>Ho inserito comunque questo men&ugrave; del sito perch&eacute; &egrave; un'efficace dimostrazione di quanto Flash sia flessibile quando si usa ActionScript.</p>
		<p>Le lettere che ruotano dentro il vortice sono sempre le stesse e, anche se apparentemente non hanno un significato, quando il mouse passa sopra uno degli 8 pulsanti attorno al cerchio, esse si allineano formando il titolo dell'elemento di men&ugrave; selezionato.</p>
		<p>Un'altra creazione geniale dell'accoppiata Andrea Verlicchi &amp; Paolo Malorgio. ;) </p>
		<div class="clearer"></div>
<!--#include virtual="/italiano/includes/back_webportfolio.php" -->
	<!-- InstanceEndEditable --></div>
	<div id="footer">Pagina progettata e realizzata interamente da Andrea Verlicchi in <!-- InstanceBeginEditable name="TipoDiPagina" -->XHTML 1.0 Strict, senza l'uso di tabelle html<!-- InstanceEndEditable --></div>
</div>
</body>
<!-- InstanceEnd --></html>