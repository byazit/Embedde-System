<html>
<head><title>Tweets</title>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css" />
<style>
#tweets {
    width: 500px;
    font-family: Helvetica, Arial, sans-serif;
}
#tweets li {
    background-color: #E5EECC;
    margin: 2px;
    list-style-type: none;
}
.author {
    font-weight: bold
}
.date {
    font-size: 10px;
}
</style>

<script>
jQuery(document).ready(function() {
    setInterval("showNewTweets()", 7000);
});

function showNewTweets() {
    $.getJSON("feed.php", null, function(data) {
        if (data != null) {
            $("#tweets").prepend($("<li><span class=\"author\">" + data.author + "</span> " +  data.tweet + "<br /><span class=\"date\">" + data.date + "</span></li>").fadeIn("slow"));
        }
    });
}
</script>

</head>
<body>
	<div class="commanDiv">
		<?php
			$output = shell_exec('who');
			$cpu = shell_exec('cat /sys/devices/system/cpu/cpu0/cpufreq/scaling_cur_freq && free -h && sync && echo 3 > /proc/sys/vm/drop_caches && free -h');
			echo "<pre>$output</pre>";
			echo "<pre>$cpu</pre>";
		?>
	</div>
	<div><ul id="tweets"></ul></div>

</body>
</html>
