<?php
// load Zend Gdata libraries
	$clientLibraryPath = '/home/vhosts/chili/inc/ZendGdata/library';
	$oldPath = set_include_path(get_include_path() . PATH_SEPARATOR . $clientLibraryPath);
	require_once '/home/vhosts/chili/inc/ZendGdata/library/Zend/Loader.php';
	Zend_Loader::loadClass('Zend_Gdata_Spreadsheets');
	Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

// set credentials for ClientLogin authentication
    $user = "username@yourgoogledomain.com";
    $pass = "accountpassword";
    
// try to login and fail if something goes wrong
      // connect to API
		  $spreadsheetService = Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME;
		  $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $spreadsheetService);
		  $spreadsheetService = new Zend_Gdata_Spreadsheets($client);

      // set target spreadsheet and worksheet
		  $spreadsheetKey = 'spreadsheetid';
		  $worksheetId = 'od7';
	
	//Get the spreadsheet data
		$query = new Zend_Gdata_Spreadsheets_CellQuery();
		$query->setSpreadsheetKey($spreadsheetKey);
		$query->setWorksheetId($worksheetId);
		$query->setMinCol(2);
		$query->setMaxCol(5);
		$query->setMinRow(2);
		$query_results = $spreadsheetService->getCellFeed($query);
		
	//Turn the spreadsheet data into 3 arrays for each voting category
		$unique_leaderboard = array();
		$hot_leaderboard = array();
		$best_leaderboard = array();
		$count = 0;
		$column_count = 1;
		$array_count = 0;
		foreach($query_results as $cellEntry) {
			$value = $cellEntry->cell->getText();
			if ($column_count == 1) {
		 	$chili_name = $value;
		 	$column_count++;
		 	} else if ($column_count == 2) {
			$unique_leaderboard[$chili_name] = $value;
			$column_count++;
			} else if ($column_count == 3) {
			$hot_leaderboard[$chili_name] = $value;
			$column_count++;
			} else if ($column_count == 4) {
			$best_leaderboard[$chili_name] = $value;
			$column_count = 1;
			}
		$count++;
	}
?>
		
<div id="post">
	<div id="unique_leaderboard">
	<div class="leaderboard_title">Most Unique<br /><br /></div>
	<table>
	<?php
	//print our unique leaderboard
		$count = 1;
		arsort($unique_leaderboard);
		foreach($unique_leaderboard as $chili => $vote) {
		  echo "<tr>";
		  echo "<td>";
		  if ($count < 10) { 
		  echo "&nbsp;&nbsp;";
		  };
		  echo "$count/</td>";
		  echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;$chili</td>";
		  echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;$vote</td>";
		  echo "</tr>";
		  $count++;
		}
 		?>
 	</table>
	</div>


	<div id="hot_leaderboard">
	<div class="leaderboard_title">Hot as F*ck!<br /><br /></div>
	<table>
	<?php
	//print our hot leaderboard
		$count = 1;
		arsort($hot_leaderboard);
		foreach($hot_leaderboard as $chili => $vote) {
		 echo "<tr>";
		  echo "<td>";
		  if ($count < 10) { 
		  echo "&nbsp;&nbsp;";
		  };
		  echo "$count/</td>";
		  echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;$chili</td>";
		  echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;$vote</td>";
		  echo "</tr>";
		  $count++;
		}
 		?>
 	</table>
	</div>
	
	<div id="best_leaderboard">
	<div class="leaderboard_title">Best Overall<br /><br /></div>
	<table>
	<?php
	//print our best leaderboard
		$count = 1;
		arsort($best_leaderboard);
		foreach($best_leaderboard as $chili => $vote) {
		  echo "<tr>";
		  echo "<td>";
		  if ($count < 10) { 
		  echo "&nbsp;&nbsp;";
		  };
		  echo "$count/</td>";
		  echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;$chili</td>";
		  echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;$vote</td>";
		  echo "</tr>";
		  $count++;
		}
 		?>
 	</table>
	</div>
 	</div>
</div>
