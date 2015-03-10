/**
 * @author averlicchi
 */

// Funzione JS che restituisce il punto GLatLng in base al parametro passato
function myGetPoint(aElement) {
	return new GLatLng(aElement[1], aElement[2]);
}

// Funzione JS che aggiunge un overlay marker alla mappa gMap in base al parametro passato e lo restituisce
function myAddMarker(aElement) {
	var point = myGetPoint(aElement);
	var marker = new GMarker(point, markerOptions);
	marker.myHtml = aElement[3];
	marker.bindInfoWindowHtml(marker.myHtml, myInfoWindowOptions);
	gMap.addOverlay(marker);
	return marker;
}

// Funzione JS che aggiunge TUTTI gli overlay marker alla mappa in base al RS passato e centra/zoomma la mappa
function myAddAllMarkers(aArgElements) {
	gMarkers = new Array();
	var iLen = aArgElements.length;
	var aIthElement;
	for (iInd=0; iInd<iLen; iInd++) {
		aIthElement = aArgElements[iInd];
		gMarkers[aIthElement[0]] = myAddMarker(aArgElements[iInd]);
	}
	myAutoZoom(aArgElements);
}

function myAutoZoom(aArgElements) {
	var bounds = new GLatLngBounds();
	var iLen = aArgElements.length;
	var aIthElement;
	for (iInd=0; iInd<iLen; iInd++) {
		aIthElement = aArgElements[iInd];
		bounds.extend (myGetPoint(aIthElement));
	}
	gMap.setCenter(bounds.getCenter(), gMap.getBoundsZoomLevel(bounds));
}

// Funzione JS che inizializza la mappa e la centra in Italia
function initialize() {
  if (GBrowserIsCompatible()) {
    gMap = new GMap2(document.getElementById("map_canvas"));
    gMap.addControl(new GSmallMapControl());
	gMap.addControl(new GMapTypeControl());
	gMap.setCenter(new GLatLng(41.277806, 13.64502), 6);
  } else {
  	alert('Attenzione: il vostro browser non &egrave; compatibile con il sistema di mappe di Google utilizzato in questo sito. Aggiornare il browser ad una versione compatibile se si desidera utilizzare Milk Maps.');
  }
}

function aGetElementByDbId(iArgId, aArgElements) {
	iLen = aArgElements.length;
	for (iInd=0; iInd<iLen; iInd++) {
		//alert('iind='+iInd+' ilen='+iLen+' aArgElements[iInd][0]=' + aArgElements[iInd][0] + ' iArgId='+iArgId);
		if (aArgElements[iInd][0] == iArgId) return aArgElements[iInd];
	}
	return null;
}

// Funzione JS che apre la infowindow del marker corrispondente all'ID (DB) passato
function myOpenInfo (iId) {
	var myMarker = gMarkers[iId];
	var myElement = aGetElementByDbId(iId, aDistributori);
	gMap.openInfoWindowHtml(myGetPoint(myElement), myMarker.myHtml, myInfoWindowOptions);
	return false;
}

function getDirections(iId) {
	var argAddressFrom = prompt('Indirizzo di partenza', '[Citta\', Indirizzo, CAP]');
	if (argAddressFrom != null) {
		var aDistributore = aGetElementByDbId(iId, aDistributori);
		var argAddressTo = aDistributore[4] + ' @' + aDistributore[1] + ', ' + aDistributore[2];
		window.open('http://maps.google.it/maps?f=d&hl=it&saddr=' + argAddressFrom + '&daddr=' + argAddressTo);
	}
}

function myZoomTo(iId) {
	var aDistributore = aGetElementByDbId(iId, aDistributori);
	gMap.setCenter(new GLatLng(aDistributore[1], aDistributore[2]), 17);
}

function myShowZoomLink(iId, sDirection) {
	var eHide;
	var eShow;
	if (sDirection == 'out') {
		eHide = document.getElementById('in'+iId);
		eShow = document.getElementById('out'+iId);
	} else {
		eHide = document.getElementById('out'+iId);
		eShow = document.getElementById('in'+iId);
	}
	eShow.style.display = 'inline';
	eHide.style.display = 'none';
}

function myGetMilkMapsIcon() {
	var myIcon = new GIcon();
	myIcon.image = "http://www.milkmaps.com/images/mrkDistrLatte.png";
	myIcon.shadow = "http://www.milkmaps.com/images/mrkShadow.png";
	myIcon.iconSize = new GSize(20, 34);
	myIcon.shadowSize = new GSize(34, 34);
	myIcon.iconAnchor = new GPoint(10, 33);
	myIcon.infoWindowAnchor = new GPoint(5, 1);
	return myIcon;
}