<?php

require_once 'rockdb.php';
//require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

$allthatAndLastFM = "SELECT a.artistSpotID AS artistSpotID, a.artistMBID AS artistMBID, a.artistArt AS artistArt, a.artistName AS artistName, a.albumsTotal AS albumsTotal, p1.pop AS pop, p1.followers AS followers, f1.dataDate AS dataDate, f1.artistListeners AS artistListeners, f1.artistPlaycount AS artistPlaycount, p1.date AS date
    FROM artists a
    JOIN (SELECT p.*
			FROM popArtists p
			INNER JOIN (SELECT artistSpotID, pop, max(date) AS MaxDate
						FROM popArtists  
						GROUP BY artistSpotID) groupedp
			ON p.artistSpotID = groupedp.artistSpotID
			AND p.date = groupedp.MaxDate) p1
	ON a.artistSpotID = p1.artistSpotID
	LEFT JOIN (SELECT f.*
			FROM artistsLastFM f
			INNER JOIN (SELECT artistMBID, artistListeners, artistPlaycount, max(dataDate) AS MaxDataDate
						FROM artistsLastFM  
						GROUP BY artistMBID) groupedf
			ON f.artistMBID = groupedf.artistMBID
			AND f.dataDate = groupedf.MaxDataDate) f1
	ON a.artistMBID = f1.artistMBID
	ORDER BY a.artistName ASC;";

$getit = $connekt->query( $allthatAndLastFM );

if(!$getit){ echo 'Cursed-Crap. Did not run the query.'; }	

?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="UTF-8">
	<title>All Spotify Artists</title>
	<?php echo $stylesAndSuch; ?>
</head>

<body>

	<div class='container-fluid'>
	
	<div id="fluidCon">

	</div> <!-- end of fluidCon -->
	<!-- main -->

	<div class="panel panel-primary">

		<div class="panel-heading">
			<h3 class="panel-title">Data for All Artists</h3>
		</div>

		<div class="panel-body">

			<!-- Panel Content -->
			<!-- D3 chart goes here -->
			<?php if (!empty($getit)) { ?>

<table class="table" id="tableoartists">
	<thead>
<tr>
	<th>Pretty Face</th>	
	<th onClick="sortColumn('artistName', 'ASC')"><div class="pointyHead">Artist Name</div></th>
	<!--
	<th class="popStyle">Spotify ID</th>
	<th class="popStyle">Spotify<br>Data Date</th>
	-->	
	<th onClick="sortColumn('pop', 'unsorted')"><div class="pointyHead popStyle">Spotify<br>Popularity</div></th>
	<th onClick="sortColumn('followers', 'unsorted')"><div class="pointyHead rightNum">Spotify<br>Followers</div></th>
		<!--
	<th onClick="sortColumn('datadate', 'unsorted')"><div class="pointyHead popStyle">LastFM<br>Data Date</div></th>			
		-->
	<th onClick="sortColumn('artistListeners', 'unsorted')"><div class="pointyHead rightNum">LastFM<br>Listeners</div></th>
	<th onClick="sortColumn('artistPlaycount', 'unsorted')"><div class="pointyHead rightNum">LastFM<br>Playcount</div></th>
	<th><div class="popStyle">LastFM<br>Ratio</div></th>
</tr>
	</thead>

	<tbody>

				<?php
					while ( $row = mysqli_fetch_array( $getit ) ) {
						$artistName = $row[ "artistName" ];
						$artistSpotID = $row[ "artistSpotID" ];
						$artistMBID = $row[ "artistMBID" ];
						$artistPop = $row[ "pop" ];
						$artistFollowersNum = $row[ "followers"];
						$artistFollowers = number_format ($artistFollowersNum);
						$artistArt = $row[ "artistArt" ];
						$popDate = $row[ "date" ];
						$albumsTotal = $row[ "albumsTotal" ];
						$lastFMDate = $row[ "dataDate" ];
						$artistListenersNum = $row[ "artistListeners"];
						$artistListeners = number_format ($artistListenersNum);
						if (!$artistListeners > 0) {
							$artistListeners = "n/a";
						};
						$artistPlaycountNum = $row[ "artistPlaycount"];
						$artistPlaycount = number_format ($artistPlaycountNum);
						if (!$artistPlaycount > 0) {
							$artistPlaycount = "n/a";
						};
				?>

<tr>
	<td><a href='https://www.roxorsoxor.com/poprock/artist_Chart.php?artistSpotID=<?php echo $artistSpotID ?>&artistMBID=<?php echo $artistMBID ?>'><img src='<?php echo $artistArt ?>' class="indexArtistArt"></a></td>	
	<td><a href='https://www.roxorsoxor.com/poprock/artist_Chart.php?artistSpotID=<?php echo $artistSpotID ?>&artistMBID=<?php echo $artistMBID ?>'><?php echo $artistName ?></a></td>
	<!--
	<td class="popStyle"><?php //echo $artistSpotID ?></td>
	<td class="popStyle"><?php //echo $popDate ?></td>
	-->
		<td class="popStyle"><?php echo $artistPop ?></td>
	<td id="followers" class="rightNum"><?php echo $artistFollowers ?></td>
	<!--  
	<td class="popStyle"><?php echo $lastFMDate ?></td>		
	-->
	<td class="rightNum"><?php echo $artistListeners ?></td>
	<td class="rightNum"><?php echo $artistPlaycount ?></td>
	<td class="popStyle"><p>Coming<br>Soon</p></td>
</tr>

				<?php 
					} // end of while
				?>

				</tbody>
			</table>
			<?php 
				} // end of if
			?>

		</div>
		<!-- panel body -->

	</div>
	<!-- panel panel-primary -->

	</div>
	<!-- close container -->

	<?php echo $scriptsAndSuch; ?>
	<script src="https://www.roxorsoxor.com/poprock/functions/sort_Artists.js"></script>
	<script src="https://www.roxorsoxor.com/poprock/page_pieces/navbarIndex.js"></script>

</body>

</html>