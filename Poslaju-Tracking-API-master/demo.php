<!DOCTYPE html>
<html>
<head>
	<title>Poslaju API Demo</title>
</head>
<body>

	<form action="./demo.php" method="get">
		<input type="text" id="TrackNo" maxlength="50">
			<input type="button" value="TRACK" onclick="inputTrack()">
			<script src="//www.tracking.my/track-button.js"></script>
			<script>
			  function inputTrack() {
			    var num = document.getElementById("TrackNo").value;
			    if(num===""){
			      alert("Please enter tracking number");
			      return;
			    }
			    TrackButton.track({
			      tracking_no: num
			    });
			  }
			</script>
	</form>

	<?php

	if(isset($_GET['trackingNo']))
	{

		$trackingNo = $_GET['trackingNo']; # your tracking number
		$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/api.php?trackingNo=".$trackingNo; # the full URL to the API
		$getdata = file_get_contents($url); # use files_get_contents() to fetch the data, but you can also use cURL, or javascript/jquery json
		$parsed = json_decode($getdata,true); # decode the json into array. set true to return array instead of object

		$httpcode = $parsed["http_code"];
		$message = $parsed["message"];

		echo "<br><b>Status: ".$message . "</b><br>";

		if($message == "Record Found" && $httpcode == 200)
		{
			?>

			<table border=1>
				<tr>
					<th>Date/Time</th>
					<th>Process</th>
					<th>Event</th>
				</tr>
				<?php

					# iterate through the array
					for($i=0;$i<count($parsed['data']);$i++)
					{
						# access each items in the JSON
						echo "
							<tr>
								<td>".$parsed['data'][$i]['date_time']."</td>
								<td>".$parsed['data'][$i]['process']."</td>
								<td>".$parsed['data'][$i]['event']."</td>
							</tr>
							";
					}
			?>

			</table>

			<br><br>

			<b>JSON output:</b><br>
			<pre style="height:500px;width:700px;border:1px solid #ccc;overflow:auto;">
				<?php
					$json_pretty = json_encode(json_decode($getdata), JSON_PRETTY_PRINT);
					echo $json_pretty;
				?>
			</pre>

			<?php
		}

	}

	?>

</body>
</html>
