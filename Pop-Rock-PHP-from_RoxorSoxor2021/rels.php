<?php 
    //$artistSpotID = $_GET['artistSpotID'];
    //$artistMBID = $_GET['artistMBID'];
	require_once 'page_pieces/stylesAndScripts.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Ronnie James Dio network diagram | PopRock</title>
	
	<?php echo $stylesAndSuch; ?>

</head>

<body>

<div class="container-fluid">
	
<div id="fluidCon"></div> <!-- end of fluidCon -->

    <div class="panel panel-primary">
		<div class="panel-heading">
			<h3 id="name" class="panel-title">Ronnie James Dio network diagram</h3>
		</div>
            <div class="panel-body">
                <svg width="1200" height="900"></svg>

                <script>

var nodes = [
{ id: "Black Sabbath", /* group: 0, */ label: "Black Sabbath", level: 1 },
{ id: "Rainbow", /* group: 1, */ label: "Rainbow", level: 1 }, 
{ id: "Deep Purple", /* group: 2, */ label: "Deep Purple", level: 1 }, 
{ id: "Dio", /* group: 3, */ label: "Dio", level: 1 },
//{ id: "Roger Glover and Friends", /* group: 4, */ label: "Roger Glover and Friends", level: 1 },
{ id: "Heaven & Hell", /* group: 5, */ label: "Heaven & Hell", level: 1 },
{ id: "Ozzy (band)", /* group: 6, */ label: "Ozzy (band)", level: 1 },
//{ id: "Quiet Riot", /* group: 7, */ label: "Quiet Riot", level: 1 },
//{ id: "Whitesnake", /* group: 8, */ label: "Whitesnake", level: 1 },

{ id: "Ronnie James Dio", /* group: 0, */ label: "Ronnie James Dio", level: 2 },
{ id: "Geezer Butler", /* group: 0, */ label: "Geezer Butler", level: 4 },
{ id: "Tony Iommi", /* group: 0, */ label: "Tony Iommi", level: 3 },
{ id: "Bill Ward", /* group: 0, */ label: "Bill Ward", level: 5 },
{ id: "Ozzy Osbourne", /* group: 0, */ label: "Ozzy Osbourne", level: 2 },
{ id: "Geoff Nicholls", /* group: 0, */ label: "Geoff Nicholls", level: 6 },
{ id: "Vinny Appice", /* group: 0, */ label: "Vinny Appice", level: 5 },
{ id: "Ian Gillan", /* group: 0, */ label: "Ian Gillan", level: 2 },
{ id: "Eric Singer", /* group: 0, */ label: "Eric Singer", level: 5 },
{ id: "Bob Daisley", /* group: 0, */ label: "Bob Daisley", level: 4 },
{ id: "Ray Gillen", /* group: 0, */ label: "Ray Gillen", level: 2 },
{ id: "Tony Martin", /* group: 0, */ label: "Tony Martin", level: 2 }, 
{ id: "Cozy Powell", /* group: 0, */ label: "Cozy Powell", level: 5 }, 
{ id: "Glenn Hughes", /* group: 2, */ label: "Glenn Hughes", level: 2 },      

{ id: "Ritchie Blackmore", /* group: 1, */ label: "Ritchie Blackmore", level: 3 },
//{ id: "Ronnie James Dio", /* group: 1, */ label: "Ronnie James Dio", level: 2 },
{ id: "Tony Carey", /* group: 1, */ label: "Tony Carey", level: 2 },
//{ id: "Bob Daisley", /* group: 1, */ label: "Bob Daisley", level: 2 },
{ id: "Roger Glover", /* group: 1, */ label: "Roger Glover", level: 4 },
{ id: "Joe Lynn Turner", /* group: 1, */ label: "Joe Lynn Turner", level: 2 },
{ id: "Don Airey", /* group: 1, */ label: "Don Airey", level: 6 },
//{ id: "Cozy Powell", /* group: 1, */ label: "Cozy Powell", level: 2 },

//{ id: "Ritchie Blackmore", /* group: 2, */ label: "Ritchie Blackmore", level: 2 },
{ id: "David Coverdale", /* group: 2, */ label: "David Coverdale", level: 2 },
//{ id: "Ian Gillan", /* group: 2, */ label: "Ian Gillan", level: 2 },
//{ id: "Roger Glover", /* group: 2, */ label: "Roger Glover", level: 2 },  
//{ id: "Glenn Hughes", /* group: 2, */ label: "Glenn Hughes", level: 2 },
{ id: "Ian Paice", /* group: 2, */ label: "Ian Paice", level: 5 },       
//{ id: "Joe Lynn Turner", /* group: 2, */ label: "Joe Lynn Turner", level: 2 },
{ id: "Joe Satriani", /* group: 2, */ label: "Joe Satriani", level: 3 },
//{ id: "Don Airey", /* group: 2, */ label: "Don Airey", level: 2 },

{ id: "Jake E. Lee", /* group: 3, */ label: "Jake E. Lee", level: 3 },
//{ id: "Ronnie James Dio", /* group: 3, */ label: "Ronnie James Dio", level: 2 },
{ id: "Vivian Campbell", /* group: 3, */ label: "Vivian Campbell", level: 3 },        
//{ id: "Vinny Appice", /* group: 3, */ label: "Vinny Appice", level: 2 },
//{ id: "Bob Daisley", /* group: 3, */ label: "Bob Daisley", level: 2 },
{ id: "Rudy Sarzo", /* group: 3, */ label: "Rudy Sarzo", level: 4 },

//{ id: "Roger Glover", /* group: 4, */ label: "Roger Glover", level: 2 }, 
//{ id: "Ronnie James Dio", /* group: 4, */ label: "Ronnie James Dio", level: 2 },

//{ id: "Ronnie James Dio", /* group: 5, */ label: "Ronnie James Dio", level: 2 },
//{ id: "Glenn Hughes", /* group: 5, */ label: "Glenn Hughes", level: 2 },
//{ id: "Vinny Appice", /* group: 5, */ label: "Vinny Appice", level: 2 },
//{ id: "Geezer Butler", /* group: 5, */ label: "Geezer Butler", level: 2 },
//{ id: "Tony Iommi", /* group: 5, */ label: "Tony Iommi", level: 2 },

//{ id: "Jake E. Lee", /* group: 6, */ label: "Jake E. Lee", level: 2 },
//{ id: "Rudy Sarzo", /* group: 6, */ label: "Rudy Sarzo", level: 2 },
{ id: "Randy Rhoads", /* group: 6, */ label: "Randy Rhoads", level: 3 },
//{ id: "Don Airey", /* group: 6, */ label: "Don Airey", level: 2 },
//{ id: "Ozzy Osbourne", /* group: 6, */ label: "Ozzy Osbourne", level: 2 },

//{ id: "Rudy Sarzo", /* group: 7, */ label: "Rudy Sarzo", level: 2 },
//{ id: "Randy Rhoads", /* group: 7, */ label: "Randy Rhoads", level: 2 },

//{ id: "Don Airey", /* group: 8, */ label: "Don Airey", level: 2 },
//{ id: "David Coverdale", /* group: 8, */ label: "David Coverdale", level: 2 },
//{ id: "Cozy Powell", /* group: 8, */ label: "Cozy Powell", level: 2 }
];

var links = [
    { target: "Black Sabbath", source: "Ronnie James Dio", strength: 0.7 },
    { target: "Black Sabbath", source: "Geezer Butler", strength: 0.7 },
{ target: "Black Sabbath", source: "Tony Iommi", strength: 0.7 },
{ target: "Black Sabbath", source: "Bill Ward", strength: 0.7 },
    { target: "Black Sabbath", source: "Ozzy Osbourne", strength: 0.7 },
    { target: "Black Sabbath", source: "Geoff Nicholls", strength: 0.7 },
{ target: "Black Sabbath", source: "Vinny Appice", strength: 0.7 },
{ target: "Black Sabbath", source: "Ian Gillan", strength: 0.7 },
    { target: "Black Sabbath", source: "Eric Singer", strength: 0.7 },
    { target: "Black Sabbath", source: "Bob Daisley", strength: 0.7 },
{ target: "Black Sabbath", source: "Ray Gillen", strength: 0.7 },
{ target: "Black Sabbath", source: "Tony Martin", strength: 0.7 },
{ target: "Black Sabbath", source: "Cozy Powell", strength: 0.7 },

{ target: "Rainbow", source: "Ronnie James Dio", strength: 0.7 },
{ target: "Rainbow", source: "Bob Daisley", strength: 0.7 },
{ target: "Rainbow", source: "Cozy Powell", strength: 0.7 },
{ target: "Rainbow", source: "Tony Carey", strength: 0.7 },
{ target: "Rainbow", source: "Roger Glover", strength: 0.7 },
{ target: "Rainbow", source: "Joe Lynn Turner", strength: 0.7 },  
{ target: "Rainbow", source: "Don Airey", strength: 0.7 },
{ target: "Rainbow", source: "Ritchie Blackmore", strength: 0.7 },

{ target: "Deep Purple", source: "Ritchie Blackmore", strength: 0.7 },
{ target: "Deep Purple", source: "Ian Gillan", strength: 0.7 },
{ target: "Deep Purple", source: "David Coverdale", strength: 0.7 },
{ target: "Deep Purple", source: "Roger Glover", strength: 0.7 },
{ target: "Deep Purple", source: "Glenn Hughes", strength: 0.7 },
{ target: "Deep Purple", source: "Ian Paice", strength: 0.7 },
{ target: "Deep Purple", source: "Joe Lynn Turner", strength: 0.7 },
{ target: "Deep Purple", source: "Joe Satriani", strength: 0.7 },
{ target: "Deep Purple", source: "Don Airey", strength: 0.7 },

{ target: "Dio", source: "Jake E. Lee", strength: 0.7 },
{ target: "Dio", source: "Ronnie James Dio", strength: 0.7 },
{ target: "Dio", source: "Vinny Appice", strength: 0.7 },
{ target: "Dio", source: "Vivian Campbell", strength: 0.7 },
{ target: "Dio", source: "Bob Daisley", strength: 0.7 },
{ target: "Dio", source: "Rudy Sarzo", strength: 0.25 },  

//{ target: "Roger Glover and Friends", source: "Roger Glover", strength: 0.7 },
//{ target: "Roger Glover and Friends", source: "Ronnie James Dio", strength: 0.7 },

{ target: "Heaven & Hell", source: "Glenn Hughes", strength: 0.7 },
{ target: "Heaven & Hell", source: "Vinny Appice", strength: 0.7 },
{ target: "Heaven & Hell", source: "Ronnie James Dio", strength: 0.7 },
    { target: "Heaven & Hell", source: "Geezer Butler", strength: 0.7 },
{ target: "Heaven & Hell", source: "Tony Iommi", strength: 0.7 },

{ target: "Ozzy (band)", source: "Ozzy Osbourne", strength: 0.7 },
{ target: "Ozzy (band)", source: "Rudy Sarzo", strength: 0.7 },
{ target: "Ozzy (band)", source: "Jake E. Lee", strength: 0.7 },
{ target: "Ozzy (band)", source: "Randy Rhoads", strength: 0.7 },
{ target: "Ozzy (band)", source: "Don Airey", strength: 0.7 },

//{ target: "Quiet Riot", source: "Rudy Sarzo", strength: 0.7 },
//{ target: "Quiet Riot", source: "Randy Rhoads", strength: 0.7 },

//{ target: "Whitesnake", source: "David Coverdale", strength: 0.7 },
//{ target: "Whitesnake", source: "Cozy Powell", strength: 0.7 },
//{ target: "Whitesnake", source: "Don Airey", strength: 0.7 }

];
/*
function getNeighbors(node) {
return links.reduce(function (neighbors, link) {
    if (link.target.id === node.id) {
        neighbors.push(link.source.id)
    } else if (link.source.id === node.id) {
        neighbors.push(link.target.id)
    }
    return neighbors
    },
    [node.id]
)
}

function isNeighborLink(node, link) {
return link.target.id === node.id || link.source.id === node.id
}
*/
function initNodeColor(node) {
if (node.level === 1) {
    return 'gray'
}
if (node.level === 2) {
    return 'red'
}
if (node.level === 3) {
    return 'magenta'
}
if (node.level === 4) {
    return 'blue'
}
if (node.level === 5) {
    return 'green'
}
if (node.level === 6) {
    return 'orange'
}
}
/*
function getNodeColor(node, neighbors) {
if (Array.isArray(neighbors) && neighbors.indexOf(node.id) > -1) {
    return node.level === 1 ? 'blue' : 'green'
}
return node.level === 1 ? 'red' : 'gray'
}

function getLinkColor(node, link) {
return isNeighborLink(node, link) ? 'green' : '#E5E5E5'
}

function getTextColor(node, neighbors) {
return Array.isArray(neighbors) && neighbors.indexOf(node.id) > -1 ? 'green' : 'black'
}
*/

var width = 1200
var height = 1200

var svg = d3.select('svg')

svg.attr('width', width).attr('height', height)

// simulation setup with all forces
var linkForce = d3
.forceLink()
.id(function (link) { return link.id })
.strength(function (link) { return link.strength })

var simulation = d3
.forceSimulation()
.force('link', linkForce)
.force('charge', d3.forceManyBody().strength(-600))
.force('center', d3.forceCenter(width / 2, height / 2))

var dragDrop = d3.drag().on('start', function (node) {
node.fx = node.x
node.fy = node.y
}).on('drag', function (node) {
simulation.alphaTarget(0.7).restart()
node.fx = d3.event.x
node.fy = d3.event.y
}).on('end', function (node) {
if (!d3.event.active) {
    simulation.alphaTarget(0)
}
node.fx = null
node.fy = null
})

/*
function selectNode(selectedNode) {
var neighbors = getNeighbors(selectedNode)
// we modify the styles to highlight selected nodes
nodeElements.attr('fill', function (node) { return getNodeColor(node) })
textElements.attr('fill', function (node) { return getTextColor(node, neighbors) })
linkElements.attr('stroke', function (link) { return getLinkColor(selectedNode, link) })
}
*/

var linkElements = svg.append("g")
.attr("class", "links")
.selectAll("line")
.data(links)
.enter().append("line")
    .attr("stroke-width", 1)
    .attr("stroke", "rgba(250, 250, 250, 0.2)")

var nodeElements = svg.append("g")
.attr("class", "nodes")
.selectAll("circle")
.data(nodes)
.enter().append("circle")
    .attr("r", 10)
    .attr("fill", initNodeColor)
    .call(dragDrop)
    //.on('click', selectNode)

var textElements = svg.append("g")
.attr("class", "texts")
.selectAll("text")
.data(nodes)
.enter().append("text")
    .text(function (node) { return  node.label })
    .attr("font-size", 15)
    .attr("dx", 15)
    .attr("dy", 4)

/**/
simulation.nodes(nodes).on('tick', () => {
nodeElements
    .attr('cx', function (node) { return node.x })
    .attr('cy', function (node) { return node.y })  
textElements
    .attr('x', function (node) { return node.x })
    .attr('y', function (node) { return node.y })
linkElements
    .attr('x1', function (link) { return link.source.x })
    .attr('y1', function (link) { return link.source.y })
    .attr('x2', function (link) { return link.target.x })
    .attr('y2', function (link) { return link.target.y })
})


simulation.force("link").links(links)

</script>
            </div>
		</div> <!-- panel body -->
	</div> <!-- close Panel Primary -->

</div> <!-- close container-fluid -->


	



<?php echo $scriptsAndSuch; ?>

<script src="https://www.roxorsoxor.com/poprock/page_pieces/navbarIndex.js"></script>
</body>

</html>