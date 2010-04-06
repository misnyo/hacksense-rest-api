<svg width="100%" height="100%" version="1.1"
     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
  <desc>Hacksense - history svg
  </desc>
  <?
	for($i=0;$i<count($history);$i++) {
		$sc = $history[$i]['StateChange'];
		if($sc['what']) {
			$nextsc = $history[++$i]['StateChange'];
			while($nextsc['what']) {
				$nextsc = $history[++$i]['StateChange'];
			}
			$firstDate = date_parse($sc['when']);
			$nextDate = date_parse($nextsc['when']);
			if($firstDate['day'] == $nextDate['day']) {
				drawRect($firstDate['hour']*60+$firstDate['minute'], $nextDate['hour']*60+$nextDate['minute']);
			} else {
				drawRect($firstDate['hour']*60+$firstDate['minute'], 1440);
				$refDate = new DateTime($sc['when']);
				while($firstDate['day'] != ($nextDate['day'] - 1)
					&& $firstDate['month'] != $nextDate['month']
					&& $firstDate['year'] != $nextDate['year']) {
					$refDate->add(new DateInterval("P1D"));
					$firstDate = date_parse($refDate);
					drawRect(0, 1440);
				}
				drawRect(0, $nextDate['hour']*60+$nextDate['minute']);
			}
		}
	}
	
	function drawRect($startMin, $endMin) {
		$fullWidth = 600;
		$start = (600 / (24 * 60)) * $startMin;
		$width = (600 / (24 * 60)) * $endMin - $start;
				print("<rect x=\"$start\" y=\"0\" width=\"$width\" height=\"100\" style=\"fill:rgb(0,0,255);stroke-width:1;
stroke:rgb(0,0,0)\" opacity=\".1\" />");
	}
?>
</svg>
