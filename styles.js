//Constants
	const MOBILE_CUTOFF = 700;

$(document).ready(function() { 
	
	//Page objects
	var menuButton = document.getElementById('menu-button');
	var list = document.getElementById('list');
	var controlPanel = document.getElementById('list-controls');

	CalcHeights();
	SetDisplays(controlPanel);

	// var listControls = 
	menuButton.onclick = function(){
		// alert("click");
		if (document.getElementById('list').style.display == "none") {
			controlPanel.style.display = "none";
			list.style.display = "block";
		} else {
			controlPanel.style.display = "block";
			list.style.display = "none";
		}
	}

});

function SetDisplays (targetDiv) {
	if ($(window).width() <= MOBILE_CUTOFF) {
		targetDiv.style.display = "none";
	}
}

function CalcHeights () {

	//Page objects
	var menuButton = document.getElementById('menu-button');
	var list = document.getElementById('list');
	var controlPanel = document.getElementById('list-controls');

	var bannerHeight = document.getElementById('banner').offsetHeight;
	var bannerOffset = 10;
	// alert(bannerHeight);
	controlPanel.style.paddingTop = (bannerHeight + bannerOffset) + "px";
	list.style.paddingTop = (bannerHeight + bannerOffset) + "px";
	menuButton.style.height = (bannerHeight - 2*bannerOffset) + "px";
	menuButton.style.width = (bannerHeight - 2*bannerOffset) + "px";
}

$(window).resize(function() {

	//Page objects
	var menuButton = document.getElementById('menu-button');
	var list = document.getElementById('list');
	var controlPanel = document.getElementById('list-controls');

	if ($(window).width() > MOBILE_CUTOFF) {
		controlPanel.style.display = "block";
		list.style.display = "block";
	}
	if ($(window).width() <= MOBILE_CUTOFF) {
		controlPanel.style.display = "none";
		list.style.display = "block";
	}
});
