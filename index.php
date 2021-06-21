    
<!DOCTYPE html>
<html>
	<head>
		<title>Stress Test</title>
	</head>
	<body>
		<?php
			$PID = exec("pidof stress");
			$stresskill = $_GET["stress"];
			if (strlen($stresskill) > 0) {
				if ($stresskill == "start") {
					echo("<h2>Generating Load</h2>");
					exec("stress --cpu 4 --io 1 --vm 1 --vm-bytes 128M > /dev/null 2>/dev/null &");
				} elseif ($stresskill == "stop") {
					echo("<h2>Killed stress</h2>");
					exec("kill -9 $PID");
				} else {}
			}
		?>
		<center>
			<h2>Generate Load</h2>
			<table>
				<tr>
					<td>
						<form action="index.php">
							<input type="hidden" name="stress" value="start" />
							<input type="submit" value="Start Stress" />
						</form>
					</td>
					<td>
						<form>
							<input type="hidden" name="stress" value="stop" />
							<input type="submit" value="Stop Stress" />
						</form>
					</td>
				</tr>
			</table>
		</center>
	</body>
</html>