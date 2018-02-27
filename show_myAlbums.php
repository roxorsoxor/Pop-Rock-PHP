<?php

session_start();
require_once 'rockdb.php';
require_once 'navbar_rock.php';
require_once 'stylesAndScripts.php';
require_once 'albums.php';

$artistID = $_SESSION['artist'];

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
		<table class="table">
			<tr><th>Album Art</th><th>Album Name</th><th>Released</th><th>Popularity</th></tr>
			<?php
				showAlbums ($artistID);
			?>

		</table>
</div> <!-- panel body -->
<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2018</p></footer>
</div> <!-- panel panel-primary -->
    </div> <!-- closing container -->
	
<?php echo $scriptsAndSuch; ?>

</body>
</html>