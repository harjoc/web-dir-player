<html>
<title>
<?php 
$u = $_SERVER['REQUEST_URI']; 
echo substr($u, 1, -1);
?>
</title>
<head>

<script src="jquery.min.js"></script>
<script src="screenfull.js"></script>

<script type="text/javascript">

var alerted = false;

$(document).ready(function(){
	$('.isVideo').on('click',function(){
        var url = $(this).data('video');

        var isChrome = /Chrom/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
        if (!url.endsWith('.mp4') && !isChrome && !alerted) {
            alert("If playback doesn't start, Chrome is known to support mkv, mp4 and other formats.");
            alerted = true;
        }

		var video  = document.getElementById('video');
		var vidsrc = document.getElementById('vidsrc');
		
		video.style.display = "block";

		vidsrc.setAttribute('src', url);
		video.load();		
		video.play();

		if (video.requestFullscreen)
			video.requestFullscreen();
		else if (video.mozRequestFullScreen)
			video.mozRequestFullScreen();
		else if (video.webkitRequestFullscreen)
			video.webkitRequestFullscreen();
		
		return false;
	});
});

</script>

<style>

body {
    line-height: 150%;
}

</style>

</head>

<body>

<video id="video" width="600" controls style="display:none">
	<source id="vidsrc" src="" type="video/mp4">
</video>

<br/>

<a href=".." style="font-style:italic">&lt;Parent dir&gt;</a>
<br/><br/>

<?php

function endswith($haystack, $needle)
{
	$length = strlen($needle);
	if ($length == 0) return true;
	return (substr($haystack, -$length) === $needle);
}

$lst = glob('*');

usort($lst, create_function('$a,$b', 'return filemtime($b) - filemtime($a);'));

foreach($lst as $file)
{
	if (strncmp($file, "README", 6)==0 || endswith($file, ".php") || endswith($file, ".js"))
		continue;

	echo '<a href="#" class="isVideo" data-video="'.$file.'">'.$file.'</a><br/>';
    echo "\n";
}

?>

</body>
</html>
