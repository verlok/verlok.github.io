/* 
NOTES:
1) This should be accomplished on the server BEFORE the page html is rendered,
to avoid double image loading
2) I didn't choose to use a pngfix to avoid more problems, as the contest
requires the page to render without errors
*/

var imageReplaceIE6 = [
	['#obstacles .tank figure img', 'img/obstacles/theTank.gif'],
	['#obstacles .sundae figure img', 'img/obstacles/sundaeSlide.gif'],
	['#obstacles .wheel figure img', 'img/obstacles/humanHamsterWheel.gif'],
	['#obstacles .hatch figure img', 'img/obstacles/downTheHatch.gif'],
	['#obstacles .pick figure img', 'img/obstacles/pickIt.gif'],
	['#obstacles .wringer figure img', 'img/obstacles/theWringer.gif'],
	['#prizes .spaceCamp img', 'img/prizes/spaceCamp.gif'],
	['#prizes .keyboard img', 'img/prizes/keyboard.gif'],
	['#prizes .skateboard img', 'img/prizes/skateboard.gif'],
	['#prizes .tvVcrCombo img', 'img/prizes/tvVcrCombo.gif'],
	['#alarmClock img', 'img/objects/clock.gif'],
	['#siteFooter img.logo', 'img/logos/kn.gif'],
	['#licence img', 'img/logos/creativeCommons.gif']
];

$(document).ready(function(){
	for (i=0; i<imageReplaceIE6.length; i++) {
		$(imageReplaceIE6[i][0]).attr('src', imageReplaceIE6[i][1]);
	}
});