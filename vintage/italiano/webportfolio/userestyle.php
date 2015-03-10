<?php
require_once('../../config/config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//IT" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/pagina_standard.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Migliorare l'usabilit&agrave;</title>
<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="head" -->
<meta name="Description" content="Spiegazione della realizzazione del miglioramento dell'usabilit&agrave; della pagina dei prodotti di un sito" />
<meta name="Keywords" content="Miglioramento, Usabilit&agrave;, Pagina, Prodotti" />
<meta name="author" content="Andrea Verlicchi" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php $sPageKey="PORTFOLIO" ?>
<!--#include virtual="/lib/utils.php" -->
<script type="text/JavaScript">
<!--
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
		<div class="pagePath"><img src="<?php echo URL_ROOT ?>images/pathFolder.gif" alt="Percorso" width="15" height="13" /><a href="<?php echo URL_ROOT ?>index.php">Web Portfolio</a> &gt; Miglioramento dell'usabilit&agrave;</div>
		<div class="clearer"></div>
		<h1>Migliorare l'usabilit&agrave; di un sito <a name="top" id="top"></a></h1>
		<p><strong>Usabilit&agrave;: propriet&agrave; di un sito web che ne indica la facilit&agrave; di essere utilizzato, navigato, compreso.</strong></p>
		<div class="siteThumb"><a href="javascript:;" onclick="MM_openBrWindow('/italiano/webportfolio/userestyle/enlargements/product_page_original.php','pagezoom','status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=1010,height=800')"><img src="<?php echo URL_ROOT ?>images/webportfolio/userestyle/previews/medium/quick_comp_before.gif" alt="home page" width="148" height="246" /></a>
			<p>Prima del miglioramento</p>
		</div>
		<a href="javascript:;" onclick="MM_openBrWindow('/italiano/webportfolio/userestyle/enlargements/product_page_original.php','pagezoom','status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=1010,height=800')"></a>
		<div class="siteThumb"><a href="javascript:;" onclick="MM_openBrWindow('/italiano/webportfolio/userestyle/enlargements/product_page_restyled.php','pagezoom','status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=1010,height=800')"><img src="<?php echo URL_ROOT ?>images/webportfolio/userestyle/previews/medium/quick_comp_after.gif" alt="home page" width="150" height="195" /></a>
			<p>Dopo il miglioramento</p>
		</div>
		<div class="clearer"></div>
		<p>In questa pagina viene illustrato, passo dopo passo, un miglioramento dell'usabilt&agrave; apportato da me ad una pagina di un sito. <br />
	Si tratta di un sito che vende DVD e film in genere. La pagina &egrave; quella che illustra un articolo <em>cofanetto</em>. Un <em>cofanetto</em> &egrave; un articolo contenente pi&ugrave; film.</p>
		<h2>Indice dei miglioramenti contenuti della pagina</h2>
		<div class="leftLeft" style="width:33%"> Alla lettura
			<ul>
				<li><a href="#skim">Facilit&agrave; di skim dei contenuti</a></li>
				<li><a href="#glance">Prodotti a colpo d'occhio </a></li>
				<li><a href="#highlights">Evidenziazione delle informazioni pi&ugrave; importanti </a></li>
			</ul>
		</div>
		<div class="leftLeft"  style="width:33%"> Alla comprensione
			<ul>
				<li><a href="#boxes">Layout dei prodotti &quot;cofanetto&quot; pi&ugrave; usabile </a></li>
				<li><a href="#dirsandacts">Layout del cast pi&ugrave; usabile </a></li>
			</ul>
		</div>
		<div class="leftLeft" style="width:33%"> Alla navigazione
			<ul>
				<li><a href="#similar">Pannello prodotti simili a destra </a></li>
				<li><a href="#byname">Click su un membro del cast per ricercare per esso</a></li>
			</ul>
		</div>
		<div class="clearer"></div>
		<h2>Facilit&agrave; di skim dei contenuti<a name="SKIM" id="SKIM"></a></h2>
		<div class="siteThumb"><img src="<?php echo URL_ROOT ?>images/webportfolio/userestyle/previews/medium/skimming_after.gif" alt="home page" width="150" height="48" />
			<p> Formato lineare</p>
			<img src="<?php echo URL_ROOT ?>images/webportfolio/userestyle/previews/medium/skimming_before.gif" alt="home page" width="150" height="52" />
			<p>Formato originale </p>
		</div>
		<h4>Informazioni che attraggono l'occhio </h4>
		<p> Mentre prima era il titolo di ogni riga ad essere in grassetto, ora &egrave; la parte che rappresenta il valore. La miglioria consiste nel fatto che in questo modo l'occhio dell'utente &egrave; attratto dal valore (es: dvd) e potrebbe anche evitare di leggere il titolo della riga (es: supporto) per comprenderne il significato.</p>
		<h4>Scorrimento della pagina pi&ugrave; facile</h4>
		<p>Le parti di ogni riga che contengono i valori, ora in grassetto, sono ora tutte allineate tra loro, cos&igrave; da consentire all'utente di leggerle senza spostare l'occhio orizzontalmente durante l'operazione di scorrimento della pagina.</p>
		<p>Di conseguenza, le parti di ogni riga contenenti il titolo sono state allineate a destra, cos&igrave; da rimanere vicine ai valori ed evitare all'occhio dell'utente di dover attraversare molto spazio bianco, rischiando di perdere la linea della riga.</p>
		<div class="clearer"></div>
		<h2>Prodotti a colpo d'occhio<a name="glance" id="glance"></a></h2>
		<div class="siteThumb"> <img src="<?php echo URL_ROOT ?>images/webportfolio/userestyle/previews/medium/product_rows_after.gif" alt="home page" width="150" height="73" />
			<p> Ordinamento righe usabile</p>
			<img src="<?php echo URL_ROOT ?>images/webportfolio/userestyle/previews/medium/product_rows_before.gif" alt="home page" width="150" height="121" />
			<p><span class="pictureThumbDescription"> Ordinamento righe originale</span></p>
		</div>
		<h4>Dati significativi in alto</h4>
		<p>Le righe pi&ugrave; significative del prodotto sono state spostate in cima alla pagina, cos&igrave; da consentire all'utente di ottenere i dati pi&ugrave; significativi senza dover scorrere la pagina verso il basso. </p>
		<p>Questo rende la navigazione dell'utente pi&ugrave; semplice, specialmente a coloro che utilizzano una risoluzione di 800x600 o meno.</p>
		<p>Ad esempio: le righe &quot;supporto&quot;, &quot;prezzo&quot; e &quot;disponibilit&agrave;&quot; sono state spostate in cima alla pagina, cos&igrave; che l'utente possa sapere subito: se si tratta di un DVD o di un VHS, il suo prezzo, la sua disponibilit&agrave;, ecc.</p>
		<div class="clearer"></div>
		<h2>Evidenziazione delle informazioni pi&ugrave; importanti<a name="highlights" id="highlights"></a></h2>
		<div class="siteThumb"> <img src="<?php echo URL_ROOT ?>images/webportfolio/userestyle/previews/medium/highlights_after.gif" alt="home page" width="150" height="29" />
			<p> Informazioni importanti evidenziate</p>
			<img src="<?php echo URL_ROOT ?>images/webportfolio/userestyle/previews/medium/highlights_before.gif" alt="home page" width="150" height="27" />
			<p> Formato originale </p>
		</div>
		<h4>Miglior utilizzo del carattere</h4>
		<p>Il prezzo del prodotto &egrave; ora pi&ugrave; grande, e la sua disponibilit&agrave; diventa verde quando il prodotto &egrave; disponibile.</p>
		<p>Questo significa che il prezzo cattura subito l'occhio dell'utente, cosa che succede anche per la disponibilit&agrave;, ma solo quando necessario. Col prolungarsi della navigazione, l'utente capir&agrave; il meccanismo e non dovr&agrave; pi&ugrave; leggere la scritta verde, sapendo che il suo colore indica l'immediata disponibilit&agrave; del prodotto.</p>
		<div class="clearer"></div>
		<h2>Layout dei prodotti &quot;cofanetto&quot; pi&ugrave; usabile<a name="boxes" id="boxes"></a></h2>
		<div class="siteThumb"><img src="<?php echo URL_ROOT ?>images/webportfolio/userestyle/previews/medium/products_in_product_after.gif" alt="home page" width="150" height="151" />
			<p> Layout pi&ugrave; usabile</p>
			<img src="<?php echo URL_ROOT ?>images/webportfolio/userestyle/previews/medium/products_in_product_before.gif" alt="home page" width="150" height="114" />
			<p> Layout originale </p>
		</div>
		<h4>Miglior indentazione, lettura pi&ugrave; facile </h4>
		<p>Quando il prodotto visualizzato nella pagina &egrave; un cofanetto (es: Star Wars - La Saga Completa), ci sono pi&ugrave; prodotti da visualizzare nella stessa pagina prodotto (es: Guerre Stellari, L'impero colpisce ancora, Il ritorno dello Jedi).</p>
		<p>Nel nuovo layout, ogni film mostra: titolo in italiano, anno di produzione, titolo originale, cast. Il cast &egrave; stato indentato, cos&igrave; da disegnare un blocco per ogni prodotto senza disegnare alcuna linea.</p>
		<p>Nel vecchio layout, tutto era un blocco singolo, e l'utente doveva leggere molto testo per trovare la separazione tra un film ed il successivo.</p>
		<p>Le immagini qui a sinistra parlano da sole, ad ogni modo se volete &quot;provare per credere&quot;, andate <a href="#top">in cima alla pagina</a> e fate clic su entrambe le immagini nella confronto rapido. Resterete sorpresi di vedere quanto la posizione del testo sia importante per migliorare la facilit&agrave; di lettura.</p>
		<div class="clearer"></div>
		<h2>Layout del cast pi&ugrave; usabile<a name="dirsandacts" id="dirsandacts"></a></h2>
		<div class="siteThumb"><img src="<?php echo URL_ROOT ?>images/webportfolio/userestyle/previews/medium/directors_actors_after.gif" alt="home page" width="150" height="60" />
			<p> Layout pi&ugrave; usabile</p>
			<img src="<?php echo URL_ROOT ?>images/webportfolio/userestyle/previews/medium/directors_actors_before.gif" alt="home page" width="150" height="52" />
			<p> Layout originale</p>
		</div>
		<h4>Facilit&agrave; di lettura del cast</h4>
		<p>Ciascun membro del cast &egrave; stato messo in una nuova riga, ed appare in un colore diverso per via del link su di esso.</p>
		<p>Questo rende pi&ugrave; facile fare lo skimming dei membri del cast, ossia la possibilit&agrave; di sapere se un determinato artista &egrave; membro del cast di un determinato film, senza leggere i nomi di tutti gli altri artisti.</p>
		<p>I link di ogni membro del cast, inoltre, rendono possibile la <a href="#byname">ricerca di prodotti per cast</a>.</p>
		<div class="clearer"></div>
		<h2>Pannello &quot;prodotti simili&quot; a destra<a name="similar" id="similar"></a></h2>
		<div class="siteThumb"><img src="<?php echo URL_ROOT ?>images/webportfolio/userestyle/previews/medium/similar_products_after.gif" alt="home page" width="150" height="109" />
			<p> Prodotti simili a destra</p>
			<img src="<?php echo URL_ROOT ?>images/webportfolio/userestyle/previews/medium/similar_products_before.gif" alt="home page" width="150" height="56" />
			<p> Prodotti simili sotto </p>
		</div>
		<h4>Un solo clic per navigare verso i prodotti simili </h4>
		<p>Mentre prima i prodotti simili erano elencati in fondo alla pagina (quindi praticamente invisibili), ora la pagina mostra tali prodotti in un riquadro posizionato a destra della pagina.</p>
		<p>Questo aiuta:</p>
		<p>1) L'utente, perch&eacute; potrebbe trovarsi nella pagina prodotto sbagliata (es: supporto VHS invece che supporto DVD), e voler navigare alla giusta pagina prodotto, senza dover ripetere l'operazione di ricerca.</p>
		<p>2) L'azienda, perch&eacute; l'utente potrebbe essere interessato a comprare un cofanetto contenente lo stesso prodotto insieme qualcun altro, e questo acquisto renderebbe pi&ugrave; denaro.</p>
		<div class="clearer"></div>
		<h2>Ricerca prodotti per cast facendo clic su un membro del cast<a name="byname" id="byname"></a></h2>
		<div class="siteThumb"><img src="<?php echo URL_ROOT ?>images/webportfolio/userestyle/previews/medium/search_by_name_after.gif" alt="home page" width="150" height="31" />
			<p> Link &quot;blu standard&quot;</p>
			<img src="<?php echo URL_ROOT ?>images/webportfolio/userestyle/previews/medium/search_by_name_before.gif" alt="home page" width="150" height="22" />
			<p> Link originali </p>
		</div>
		<h4>Un ottimo punto di partenza per navigare</h4>
		<p> Facendo clic su un qualsiasi membro del cast, attore o registra che sia, l'utente pu&ograve; ricercare tutti i prodotti contenenti nel cast il membro sul quale ha fatto clic.</p>
		<p>Dopo questo miglioramento dell'usabilit&agrave;, i link sono nel loro tipico colore blu (standard del browser) gi&agrave; conosciuto come link alla maggior parte degli utenti.</p>
		<p>&nbsp;</p>
		<div class="clearer"></div>
<!--#include virtual="/italiano/includes/back_webportfolio.php" -->
		<!-- InstanceEndEditable --></div>
	<div id="footer">Pagina progettata e realizzata interamente da Andrea Verlicchi in <!-- InstanceBeginEditable name="TipoDiPagina" -->XHTML 1.0 Strict, senza l'uso di tabelle html<!-- InstanceEndEditable --></div>
</div>
</body>
<!-- InstanceEnd --></html>
