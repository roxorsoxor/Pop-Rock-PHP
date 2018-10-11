<?php 

// create new cookie
$artistID = $_POST['artist'];
$cookieExpiration = time() + 3600;
setcookie ('artistID', $artistID, $cookieExpiration, '/', 'roxorsoxor.com');

require_once 'rockdb.php';
require_once 'page_pieces/stylesAndScripts.php';
require_once 'page_pieces/navbar_rock.php';
require_once 'functions/artists.php';

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
	echo 'Darn. Did not connect.';
};

$artistInfoAll = "SELECT a.artistID, a.artistName, b.pop, b.date 
	FROM artists a
		INNER JOIN popArtists b ON a.artistID = b.artistID
			WHERE a.artistID = '$artistID'
				ORDER BY b.date DESC";

$getit = $connekt->query($artistInfoAll);

if(!$getit){
	echo 'Cursed-Crap. Did not run the query.';
}	

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>This Artist</title>
    <?php echo $stylesAndSuch; ?>
    <script src='https://d3js.org/d3.v4.min.js'></script>
</head>

<body>

    <div class="container">
        <?php echo $navbar ?>

        <!-- D3 chart goes here -->
		<?php if(!empty($getit)) { ?>
		
        <table class="table" id="artistTable">
			<thead>
				<tr>
					<th>Artist Name</th>
					<th>Popularity</th>
					<!--
					<th onClick="sortColumn('date', 'DESC')"><div class="pointyHead">Date</div></th>
					-->
					<th>Date</th>
				</tr>	
			</thead>
			<tbody>

			<?php

			while ($row = mysqli_fetch_array($getit)) {
				// $artistID = $row["artistID"];
				$artistName = $row["artistName"];
				$artistPop = $row["pop"];
				$popDate = $row["date"];
				$popDateShort = substr($popDate, 0, 10);
			?>
							
			<tr>
				<td><?php echo $artistName ?></td>
				<td><?php echo $artistPop ?></td>
				<!--
				<td><?php // echo $popDate ?></td>
			-->
				<td><?php echo $popDateShort ?></td>
			</tr>

			<?php 
				} // end of while
			?>

			</tbody>
        </table>

		<?php 
		} // end of if
		?>

    </div> <!-- close container -->
    
    <?php echo $scriptsAndSuch; ?>
	<script src="https://www.roxorsoxor.com/poprock/functions/sortThisArtist.js"></script>
</body>

</html>