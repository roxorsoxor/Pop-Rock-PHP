<?php

require_once '../rockdb.php';
//require_once '../page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo '<p>Darn. Did not connect because ' . mysqli_connect_error() . '.</p>';
};

// if any of these did not come through, the defaults are the basic starting sort from the sql query
$artistMBID = "artistMBID";
$artistSpotID = "artistSpotID";
$columnName = "trackName";
$currentOrder = "ASC";
$source = $_POST[ "source" ];

// If POSTed columnNames came through, use them
if ( !empty( $_POST[ "artistSpotID" ] ) ) {
	$artistSpotID = $_POST[ "artistSpotID" ];
}

if ( !empty( $_POST[ "artistMBID" ] ) ) {
	$artistMBID = $_POST[ "artistMBID" ];
}

if ( !empty( $_POST[ "columnName" ] ) ) {
	$columnName = $_POST[ "columnName" ];
}

if ( !empty( $_POST[ "currentOrder" ] ) ) {
	$currentOrder = $_POST[ "currentOrder" ];
}

// Toggle sorting order

if ( $currentOrder == "DESC" ) {
	$newOrder = "ASC";
}

if ( $currentOrder == "ASC" ) {
	$newOrder = "DESC";
}

$albumNameNewOrder = "DESC";

if ( $columnName == "albumName" and $currentOrder == "DESC" ) {
	$albumNameNewOrder = "ASC";
}

$trackNameNewOrder = "DESC";

if ( $columnName == "trackName" and $currentOrder == "ASC" ) {
	$trackNameNewOrder = "DESC";
}

$popNewOrder = "ASC";

if ( $columnName == "pop" and $currentOrder == "ASC" ) {
	$popNewOrder = "DESC";
}
/*
$OLDgatherTrackInfo = "SELECT t.trackSpotID, t.trackName, a.albumName, a.artistSpotID, p1.pop, p1.date, f1.dataDate, f1.trackListeners, f1.trackPlaycount
						FROM tracks t
						INNER JOIN albums a ON a.albumSpotID = t.albumSpotID
						JOIN (SELECT p.* FROM popTracks p
								INNER JOIN (SELECT trackSpotID, pop, max(date) AS MaxDate
											FROM popTracks  
											GROUP BY trackSpotID) groupedp
								ON p.trackSpotID = groupedp.trackSpotID
								AND p.date = groupedp.MaxDate) p1 
						ON t.trackSpotID = p1.trackSpotID
							LEFT JOIN (SELECT f.*
								FROM tracksLastFM f
								INNER JOIN (SELECT trackMBID, trackListeners, trackPlaycount, max(dataDate) AS MaxDataDate
											FROM tracksLastFM  
											GROUP BY trackMBID) groupedf
								ON f.trackMBID = groupedf.trackMBID
								AND f.dataDate = groupedf.MaxDataDate) f1
							ON t.trackMBID = f1.trackMBID
						WHERE a.artistSpotID = '$artistSpotID'
						ORDER BY " . $columnName . " " . $newOrder . ";";

$gatherTrackInfoLastFM = "SELECT v.artistName, v.trackName, v.albumName, v.trackListeners, v.trackPlaycount, max(v.dataDate) AS MaxDataDate
					FROM (
						SELECT z.trackMBID, z.trackName, z.albumName, z.artistName, p.dataDate, p.trackListeners, p.trackPlaycount
							FROM (
								SELECT t.*, r.albumName, a.artistName
									FROM tracksMB t
									INNER JOIN albumsMB r ON r.albumMBID = t.albumMBID
									JOIN artistsMB a ON r.artistMBID = a.artistMBID
									WHERE a.artistMBID = '$artistMBID'
							) z
						JOIN tracksLastFM p 
							ON z.trackMBID = p.trackMBID					
					) v
					GROUP BY v.trackMBID
					ORDER BY " . $columnName . " " . $newOrder . ";";
*/
$gatherTrackInfoSpot = "SELECT v.trackSpotID, v.artistName, v.trackName, v.albumName, v.pop, max(v.date) AS MaxDate
					FROM (
						SELECT z.artistName, z.trackSpotID, z.trackName, z.albumName, p.date, p.pop
							FROM (
								SELECT t.*, r.albumName, a.artistName
									FROM tracks t
									INNER JOIN albums r ON r.albumSpotID = t.albumSpotID
									JOIN artists a ON r.artistSpotID = a.artistSpotID
									WHERE a.artistSpotID = '$artistSpotID'
							) z
						JOIN popTracks p 
							ON z.trackSpotID = p.trackSpotID					
					) v
					GROUP BY v.trackSpotID
					ORDER BY " . $columnName . " " . $newOrder . ";";
/*
$gathering = "";

if ( $source == "musicbrainz" ) {
	$gathering = $gatherTrackInfoLastFM;
};

if ( $source == "spotify" ) {
	$gathering = $gatherTrackInfoSpot;
};
*/
$sortit = $connekt->query( $gatherTrackInfoSpot );

if ( !$sortit ) {
	echo '<p>Cursed-Crap. Did not run the query because ' . mysqli_error($connekt) . '.</p>';
}

if(!empty($sortit)) { ?>

<table class="table" id="tableotracks">
<thead>
<tr>
	<th onClick="sortColumn('albumName', '<?php echo $albumNameNewOrder; ?>', '<?php echo $artistSpotID ?>', '<?php echo $source ?>')"><div class="pointyHead">Album Title</div></th>
	<!--
	<th>Spotify<br>trackSpotID</th>
	<th>Spotify<br>Data Date</th>
	-->
	<th onClick="sortColumn('trackName', '<?php echo $trackNameNewOrder; ?>', '<?php echo $artistSpotID ?>', '<?php echo $source ?>')"><div class="pointyHead">Track Title</div></th>
	
	
	<th class="popStyle" onClick="sortColumn('pop', '<?php echo $popNewOrder; ?>', '<?php echo $artistSpotID ?>', '<?php echo $source ?>')"><div class="pointyHead">Spotify<br>Popularity</div></th>
	<!--
	<th>LastFM<br>Data Date</th>
	<th class="rightNum pointyHead">LastFM<br>Listeners</th>
	<th class="rightNum pointyHead">LastFM<br>Playcount</th>
-->
</tr>
</thead>

	<tbody>
	<?php
		while ( $row = mysqli_fetch_array( $sortit ) ) {
			$albumName = $row[ "albumName" ];
			$trackName = $row[ "trackName" ];
			$trackSpotID = $row[ "trackSpotID" ];
			$trackPop = $row[ "pop" ];
			$popDate = $row[ "MaxDate" ];
/*
			$lastFMDate = $row[ "dataDate" ];
			$trackListenersNum = $row["trackListeners"];
			$trackListeners = number_format ($trackListenersNum);
			if (!$trackListeners > 0) {
				$trackListeners = "n/a";
			};
			$trackPlaycountNum = $row["trackPlaycount"];
			$trackPlaycount = number_format ($trackPlaycountNum);
			if (!$trackPlaycount > 0) {
				$trackPlaycount = "n/a";
			};
			*/
	?>
			<tr>
				<td><?php echo $albumName ?></td>
				<td><?php echo $trackName ?></td>
				<td class="popStyle"><?php echo $trackPop ?></td>
<!--
				<td><?php //echo $trackSpotID ?></td>
				<td><?php //echo $popDate ?></td>
				<td class="popStyle"><?php //echo $lastFMDate ?></td>
				<td class="rightNum"><?php //echo $trackListeners ?></td>
				<td class="rightNum"><?php //echo $trackPlaycount ?></td>
-->				
			</tr>
	<?php 
		} // end of while
	?>

	</tbody>
</table>
<?php 
	} // end of if
?>