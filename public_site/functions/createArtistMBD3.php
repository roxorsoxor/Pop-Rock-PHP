<?php

$artistMBID = $_GET['artistMBID'];

require_once '../rockdb.php';
require( "class.artist.php" );

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
	echo 'Darn. Did not connect. Screwed up like this: ' . mysqli_error($connekt) . '</p>';
};

$artistInfoAll = "SELECT a.artistMBID, a.artistNameMB, a.artistArtMB
	FROM artistsMB a
	WHERE a.artistMBID = '$artistMBID'";

$getit = mysqli_query($connekt, $artistInfoAll);

if(!$getit){
	echo 'Cursed-Crap. Did not run the query.';
}	

if (mysqli_num_rows($getit) > 0) {
	$rows = array();
	while ($row = mysqli_fetch_array($getit)) {
		$rows[] = $row;
	}
	echo json_encode($rows);
}

else {
	echo "Nope. Nothing to see here.";
}

mysqli_close($connekt);

?>