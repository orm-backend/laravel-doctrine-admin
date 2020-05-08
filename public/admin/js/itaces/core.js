"use strict";
if (typeof openPopupWindow === "undefined") {
	function openPopupWindow(url, width, height) {
		var w, h;
		
		if (!width && !height) {
			width = 900;
			height = 700;
		}
		
		if (window.navigator.userAgent.indexOf("Opera")) {
			w = document.body.offsetWidth;
			h = document.body.offsetHeight;
		} else {
			w = screen.width;
			h = screen.height;
		}
		
		return window.open(url, '', 'status=no,scrollbars=yes,resizable=yes,width='+width+',height='+height+',top='+Math.floor((h - height)/2-14)+',left='+Math.floor((w - width)/2-5));
	}
	
	window.openPopupWindow = openPopupWindow;
}

if (typeof getRequestParam === "undefined") {
	function getRequestParam(name) {
		if (name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search)) {
			return decodeURIComponent(name[1]);
		}
		
		return null;
	}
	
	window.getRequestParam = getRequestParam;
}

if (typeof String.endsWith === "undefined") {
	Object.defineProperty(String.prototype, 'endsWith', {
		value: function(searchString, position) {
			var subjectString = this.toString();
			
			if (position === "undefined" || position > subjectString.length) {
				position = subjectString.length;
			}

			position -= searchString.length;
			var lastIndex = subjectString.indexOf(searchString, position);
			
			return lastIndex !== -1 && lastIndex === position;
		}
	});
}

if (typeof String.startsWith === "undefined") {
	Object.defineProperty(String.prototype, 'startsWith', {
		enumerable: false,
		configurable: false,
		writable: false,
		value: function(searchString, position) {
			position = position || 0;
			return this.lastIndexOf(searchString, position) === position;
		}
	});
}

if (typeof Array.isArray === "undefined") {
	Array.isArray = function(obj) {
		return Object.prototype.toString.call(obj) === '[object Array]';
	}
}

if (typeof Array.unique === "undefined") {
	Array.prototype.unique = function() {
		return this.filter(function (value, index, self) { 
			return self.indexOf(value) === index;
		});
	}
}

if (typeof Array.remove === "undefined") {
	Array.prototype.remove = function(arr) {
	    var what, L = arr.length, index;
	    while (L && this.length) {
	        what = arr[--L];
	        while ((index = this.indexOf(what)) !== -1) {
	            this.splice(index, 1);
	        }
	    }
	    
	    return this;
	};
}

if (typeof toggleFullscreen === "undefined") {
	function toggleFullscreen(target) {
		let isFullscreen = !!(document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement);
		
		if (!isFullscreen) {
			var elem = document.documentElement;
			
			if (elem.requestFullscreen) {
		        elem.requestFullscreen();
		    } else if (elem.mozRequestFullScreen) { //Firefox
		        elem.mozRequestFullScreen();
		    } else if (elem.webkitRequestFullscreen) { //Chrome, Safari and Opera
		        elem.webkitRequestFullscreen();
		    } else if (elem.msRequestFullscreen) { //IE/Edge
		        elem.msRequestFullscreen();
		    } else {
		    	console.log("Fullscreen not supported");
		    }
		} else {
			if (document.exitFullscreen) {
		        document.exitFullscreen();
		    } else if (document.mozCancelFullScreen) { //Firefox
		    	document.mozCancelFullScreen();
		    } else if (document.webkitExitFullscreen) { //Chrome, Safari and Opera
		        document.webkitExitFullscreen();
		    } else if (document.msExitFullscreen) { //IE/Edge
		        document.msExitFullscreen();
		    } else {
		    	console.log("Fullscreen not supported");
		    }
		}
	}
	
	window.toggleFullscreen = toggleFullscreen;
}

$(document).on('webkitfullscreenchange mozfullscreenchange fullscreenchange', function(e) {
	let isFullscreen = !!(document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement);
	
	if (isFullscreen) {
		$('body').addClass("fullscreen");
		$(document).trigger( "kfc-fullscreen:opened" );
	} else {
		$('body').removeClass("fullscreen");
		$(document).trigger( "kfc-fullscreen:closed" );
	}
	
	console.log("Fullscreen: " + isFullscreen);
});
