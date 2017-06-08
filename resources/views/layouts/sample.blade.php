
<!DOCTYPE html>
<html lang="en">
<head>
	  <meta charset="utf-8">
	  <title>HTML5 Video Demo</title>
	  
<script src="http://127.0.0.1/TBA/public/cms/plugins/jQuery/jquery-2.2.3.min.js"></script>

</head>
<body style="background-color:#ccc;">
<video id="video" width="640" height="480" autoplay></video>
<button id="snap">Snap Photo</button>

<canvas id="canvas" width="640" height="480"></canvas>
<img id="frame" src="{{ asset('photobooth-frame-build.png') }}"  crossOrigin="Anonymous" style="display: none;">


<button type="button" id="send_server">submit</button>

<script type="text/javascript">
	// Grab elements, create settings, etc.
	var video = document.getElementById('video');

	// Get access to the camera!
	if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
	    // Not adding `{ audio: true }` since we only want video now
	    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
	        video.src = window.URL.createObjectURL(stream);
	        video.play();
	    });
	}

	/* Legacy code below: getUserMedia 
	else if(navigator.getUserMedia) { // Standard
	    navigator.getUserMedia({ video: true }, function(stream) {
	        video.src = stream;
	        video.play();
	    }, errBack);
	} else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
	    navigator.webkitGetUserMedia({ video: true }, function(stream){
	        video.src = window.webkitURL.createObjectURL(stream);
	        video.play();
	    }, errBack);
	} else if(navigator.mozGetUserMedia) { // Mozilla-prefixed
	    navigator.mozGetUserMedia({ video: true }, function(stream){
	        video.src = window.URL.createObjectURL(stream);
	        video.play();
	    }, errBack);
	}
	*/

	// Elements for taking the snapshot
	var canvas = document.getElementById('canvas');
	var context = canvas.getContext('2d');
	var video = document.getElementById('video');
	var frame = document.getElementById('frame');

	// Trigger photo take
	document.getElementById("snap").addEventListener("click", function() {
		context.drawImage(video, 0, 0, 640, 480);
		context.drawImage(frame, 0, 0, 640, 480);


		var data = canvas.toDataURL('image/png');
		$('#file_img').val(data);
        
	});

	$('body').on('click', '#send_server', function () {
		/*var data = canvas.toDataURL('image/png');
		$.ajax({
			url : "http://127.0.0.1/TBA/sample_upload",
			type : 'POST',
			data : {img : data},
			success : function (data) {
				console.log(data);
			}
		});*/

        var canvasData = canvas.toDataURL("image/png");
        var xmlHttpReq = false;       
        if (window.XMLHttpRequest) {
            ajax = new XMLHttpRequest();
        }

        else if (window.ActiveXObject) {
            ajax = new ActiveXObject("Microsoft.XMLHTTP");
        }
        ajax.open('POST', 'http://127.0.0.1/TBA/sample_upload', false);
        ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        ajax.onreadystatechange = function() {
                console.log(ajax.responseText);
            }
        ajax.send("imgData="+canvasData+"&_token={{ csrf_token() }}");
	});
	
</script>
</body>
</html>