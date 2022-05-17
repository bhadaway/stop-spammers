(function() {
	showModalWindow();
	document.querySelectorAll(".open-modal").forEach(function(trigger) {
		trigger.addEventListener("click", function () {
			hideAllModalWindows();
			showModalWindow(this);
		});
	});
	document.querySelectorAll(".modal-hide").forEach(function(closeBtn) {
		closeBtn.addEventListener("click", function () {
			hideAllModalWindows();
		});
	});
	if (document.querySelector(".modal-fader")) {
		document.querySelector(".modal-fader").addEventListener("click", function() {
			hideAllModalWindows();
		});
	}
})();

function showModalWindow() {
	//var modalTarget = "#" + buttonEl.getAttribute("data-target");	
	//console.log(modalTarget);
	if (document.querySelector(".modal-fader")) {
		document.querySelector(".modal-fader").className += " active";
	}
	if (document.querySelector('#modal-1')) {
		document.querySelector('#modal-1').className += " active";
	}
}

function hideAllModalWindows() {
	var modalWindows = document.querySelectorAll(".modal-window");
	if (document.querySelector(".modal-fader")) {
		var modalFader = document.querySelector(".modal-fader");
		if(modalFader.className.indexOf("active") !== -1) {
			modalFader.className = modalFader.className.replace("active", "");
		}
	}
	modalWindows.forEach(function(modalWindow) {
		if(modalWindow.className.indexOf("active") !== -1) {
			modalWindow.className = modalWindow.className.replace("active", "");
		}
	});
}
