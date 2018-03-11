<?php

include 'sesh.php';
require_once 'auth.php';
require_once 'rockdb.php';
require_once 'navbar_rock.php';
require_once 'stylesAndScripts.php';
require_once 'artists.php';
require_once 'artists_arrays_objects.php';

$session = new SpotifyWebAPI\Session($myClientID, $myClientSecret);

$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();

// I don't think the cron needs this next line 
$_SESSION['accessToken'] = $accessToken;
// and I don't think the cron needs this next line either
$accessToken = $_SESSION['accessToken'];

$GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api']->setAccessToken($accessToken);

?>

<!DOCTYPE html><html>
<head><meta charset="UTF-8"><title>Artists and Such</title><?php echo $stylesAndSuch; ?></head>
<body>

<div class="container">
    <?php echo $navbar ?>
    <table class="table">
    <tr><th>Artist Name</th><th>Popularity</th></tr>

        <?php 
            inserttArtistsAndPop ($newbies);
        ?>
    </table>

</div> <!-- closing container -->

<?php echo $scriptsAndSuch; ?>
<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2017</p></footer>
</body>
</html>