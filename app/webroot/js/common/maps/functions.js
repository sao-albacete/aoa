function kmlColor (kmlIn) {
	var kmlColor = {};
	if (kmlIn) {
		aa = kmlIn.substr(0,2);
		bb = kmlIn.substr(2,2);
		gg = kmlIn.substr(4,2);
		rr = kmlIn.substr(6,2);
		kmlColor.color = "#" + rr + gg + bb;
		kmlColor.opacity = parseInt(aa,16)/256;
	} else {
		// defaults
		kmlColor.color = randomColor();
		kmlColor.opacity = 0.45;
	}
		return kmlColor;
}


function randomColor(){ 
	var color="#";
	var colorNum = Math.random()*8388607.0;  // 8388607 = Math.pow(2,23)-1
	var colorStr = colorNum.toString(16);
	color += colorStr.substring(0,colorStr.indexOf('.'));
	return color;
};

function removeCloseTooltips() {
	var tooltips = document.querySelectorAll('.ui-tooltip');
	tooltips.forEach(function(tooltip) {
		if (tooltip.querySelector('.ui-tooltip-content') && 
			tooltip.querySelector('.ui-tooltip-content').textContent === 'Cerrar') {
			tooltip.remove();
		}
	  });
	}
	
removeCloseTooltips();
setInterval(removeCloseTooltips, 500);