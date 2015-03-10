<?php
require_once('../../config/config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//IT" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/pagina_standard.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Comunica/Brasil, sito demo</title>
<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="head" -->
<meta name="Description" content="Spiegazione della realizzazione del sito demo di Comunica/Brasil" />
<meta name="Keywords" content="Comunica, Brasil, Sito, Demo, Macromedia, Flash" />
<meta name="author" content="Andrea Verlicchi" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php $sPageKey="PORTFOLIO" ?>
<style type="text/css">
div#flashjob {
	left:100px;
	width:550px;
	height:400px;
}
</style>
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
<script src="../../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<!-- InstanceEndEditable -->
<link href="<?php echo URL_ROOT ?>css/common.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
	<?php include(FS_ROOT . 'italiano/includes/header.php'); ?>
	<div id="contents"><!-- InstanceBeginEditable name="Contents" -->
		<div class="pagePath"><img src="<?php echo URL_ROOT ?>images/pathFolder.gif" alt="Percorso" width="15" height="13" /><a href="<?php echo URL_ROOT ?>index.php">Web Portfolio</a> &gt; Comunica/Brasil, sito demo </div>
		<div class="clearer"></div>
		<h1>Comunica/Brasil, sito demo</h1>
		<p>Sito dimostrativo di un'agenzia di comunicazione e marketing con sede in Brasile.</p>
		<div id="flashjob">
			<script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0','width','550','height','400','src','../../swf/comunicabrasil_demosite','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','movie','../../swf/comunicabrasil_demosite' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="550" height="400">
				<param name="movie" value="../../swf/comunicabrasil_demosite.swf" />
				<param name="quality" value="high" />
				<embed src="../../swf/comunicabrasil_demosite.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="550" height="400"></embed>
			</object>
		</noscript></div>
		<p>Lo scopo di questo sito demo, realizzato da me e <a href="http://www.paolomalorgio.com" target="_blank" class="linkEsterno">Paolo Malorgio</a> poco prima di trasferirci in Brasile, &egrave; stato quello di trovare lavoro pi&ugrave; in fretta possibile, presentandoci alle web agencies brasiliane come creativi, con questo &quot;portfolio&quot; su CD-ROM. Nel giro di un mese, abbiamo trovato lavoro entrambi.</p>
		<p>Ogni elemento del men&ugrave; principale (company, staff, services, portfolio, customers, news) contiene una diversa animazione e, quando viene cliccato, si posiziona in primo piano, a creare lo sfondo del nuovo ambiente, dove poi ritorna il logo aziendale a generare il men&ugrave; sulla destra, ed a seguire il movimento del mouse sugli elementi di men&ugrave;.</p>
		<p>Se, da qui, l'utente clicca nuovamente il pulsante &quot;home&quot;, il logo torna in primo piano e si divide nuovamente nei 6 elementi di men&ugrave;, ritornando cos&igrave; al punto di partenza.</p>
		<div class="clearer"></div>
<!--#include virtual="/italiano/includes/back_webportfolio.php" -->
		<!-- InstanceEndEditable --></div>
	<div id="footer">Pagina progettata e realizzata interamente da Andrea Verlicchi in <!-- InstanceBeginEditable name="TipoDiPagina" -->XHTML 1.0 Strict, senza l'uso di tabelle html<!-- InstanceEndEditable --></div>
</div>
</body>
<!-- InstanceEnd --></html>