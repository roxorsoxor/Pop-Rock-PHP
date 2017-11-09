<?php

session_start();

require 'vendor/autoload.php';
require_once 'stylesAndScripts.php';
require_once 'albums8.php';
require_once 'tracks6.php';

// Fetch saved access token
$accessToken = $_SESSION['accessToken'];

// put these in api.php and require that
$GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api']->setAccessToken($accessToken);

// could next line go in artist class?
$artistID = $_POST['artist'];
// could these be methods in the artist class?    
$artist = $GLOBALS['api']->getArtist($artistID);
$artistName = $artist->name;
$artistPop = $artist->popularity;

?>

<!DOCTYPE html><html>
<head><meta charset="UTF-8"><title>Ye Olde Popularity de Tracks</title><?php echo $stylesAndSuch; ?></head>
<body>

<div class="container">

<?php
// echo "<h2>" . $artistName . "</h2>"; 
// echo "<p>" . $artistName . "'s popularity is " . $artistPop . ".</p>";
echo '<table class="table">';
echo '<tr><th>Album Name</th><th>Track Name</th><th>Track Popularity</th></tr>';

$discography = $GLOBALS['api']->getArtistAlbums($artistID, [
	'market' => 'us',
	// 'album_type' => 'album',
	'limit' => '50'
]);

// should be method in albums class
foreach ($discography->items as $album) {
	
	// Get each albumID for requesting Full Album Object with popularity
	$albumID = $album->id;
	
	// Put albumIDs in array for requesting several at a time (far fewer requests)
	$artistAlbums [] = $albumID;
	
}

divideCombineAlbumsForTracks ($artistAlbums);

?>

</table>
    </div> <!-- closing container -->
<?php echo $scriptsAndSuch; ?>
<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2017</p></footer>
</body>
</html>