<?php

session_start();
require_once 'rockdb.php';
require_once 'navbar_rock.php';
require_once 'stylesAndScripts.php';
require_once 'albums.php';

// Fetch saved access token
$accessToken = $_SESSION['accessToken'];
// $GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
// $GLOBALS['api']->setAccessToken($accessToken);
$artistID = $_SESSION['artist'];
// temporarily commenting out next line and using previous line
// $artistID = $_POST['artist'];
// $_SESSION['artist'] = $artistID;

?>

<!DOCTYPE html><html>
<head><meta charset="UTF-8"><title>Album Info</title><?php echo $stylesAndSuch; ?></head>
<body>

<div class="container">

	<?php echo $navbar ?>
	
	<!-- main -->
	
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Albums</h3>
	</div>
	<div class="panel-body"> 
		
		<!-- Panel Content --> 
		<?php echo '<p>' . $artistID . '</p>'; ?>

	<?php
	echo '<table class="table">';
	echo '<tr><th>Album Art</th><th>Album Name</th><th>Released</th><th>Popularity</th></tr>';
	// echo '<tr><th>Album Name</th><th>Released</th><th>Popularity</th></tr>';
	showAlbums ($artistID);
	?>

	</table>
	</div> <!-- panel body -->
	<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2018</p></footer>
</div> <!-- closing container -->
	
<?php echo $scriptsAndSuch; ?>

</body>
</html>