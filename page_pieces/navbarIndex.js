const navbarIndex = "<nav class='navbar navbar-default'><div id='header' class='container-fluid'><ul class='nav navbar-nav'><li><a href='https://roxorsoxor.com/poprock/index.php'>Artists Spot</a></li><li><a href='https://roxorsoxor.com/poprock/indexLastFM.php'>Artists LastFM</a></li><li><a href='https://roxorsoxor.com/poprock/multiArtists_albumsChart.php'>Group Chart</a></li><li><a href='https://roxorsoxor.com/poprock/multiArtists_popTimeLines.php'>Compare Time</a></li><li><a href='https://roxorsoxor.com/poprock/multiArtists_popCurrentColumns.php'>Compare Current Popularity</a></li><li><a href='https://roxorsoxor.com/poprock/multiArtists_followersCurrentColumns.php'>Compare Current Followers</a></li><li><a href='https://roxorsoxor.com/poprock/genres.php'>Genres</a></li></ul></div> <!-- /container-fluid --></nav> <!-- /navbar -->";

const fluidCon = document.getElementById('fluidCon');

$(document).ready(function(){
    fluidCon.innerHTML = navbarIndex;
});