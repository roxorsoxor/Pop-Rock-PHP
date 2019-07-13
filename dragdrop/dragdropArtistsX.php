<?php 
    require_once '../rockdb.php';
    require_once '../page_pieces/stylesAndScripts.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Drag-n-Drop X</title>
    <?php echo $stylesAndSuch; ?>  
    <link rel='stylesheet' href='dragDrop.css'>
</head>

<body>

<div class="container">
<div id="fluidCon"></div> <!-- end of fluidCon -->
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Drag and Drop Artists</h3>
		</div>
		<div class="panel-body">
            <div id="forD3"></div> <!-- /for chart -->
        </div> <!-- panel body -->
	</div> <!-- close Panel Primary -->
</div> <!-- /container -->

<script>
    
const w = 850;
const h = 800;
	
const margin = {
	top: 20,
	right: 20,
	bottom: 20,
	left: 20
};
	
const spacepadding = 10;
    
const innerTo = {
    top: h/2 - margin.bottom + spacepadding,
    right: w - margin.right + spacepadding,
    left: margin.left + spacepadding,
    bottom: margin.bottom + spacepadding
};
    
const svg = d3.select("#forD3")
			  .append("svg")
			  .attr("width", w)
			  .attr("height", h);

let chosenBoxReady = false;
let choicesBoxReady = false;
let choiceItemReady = false;
let chosenItemReady = false;

const choicesBox = svg.append("rect")
					.attr("id", "choicesBox")
					.style("fill", "red")
					.attr("x", margin.left)
					.attr("y", margin.top)
					.attr("class", "choicesBox")
					.attr("width", w - (margin.left + margin.right))
					.attr("height", 240)
				    .on("mouseover", function(){
                      if (chosenItemReady == true){
                          choicesBoxReady = true;
                          //console.log("choicesBox is " + choicesBoxReady);
                      };
				    })
				    .on("mouseout", function(){
                        choicesBoxReady = false;
                        //console.log("choicesBox is " + choicesBoxReady);
				    });

    
const chosenBox = svg.append("rect")
				  .attr("id", "chosenBox")
				  .attr("fill", "blue")
				  .attr("x", margin.left)
				  .attr("y", h/2 - (margin.top + margin.bottom))
				  .attr("class", "chosenBox")
				  .attr("width", w - (margin.left + margin.right))
				  .attr("height", h/2 + margin.top)
				  .on("mouseover", function(){
                      if (choiceItemReady == true){
                          chosenBoxReady = true;
                          //console.log("chosenBox is " + chosenBoxReady);
                      };
				  })
				  .on("mouseout", function(){
					chosenBoxReady = false;
					//console.log("chosenBox is " + chosenBoxReady);
				  });
    

d3.json("dragDropCompare.php", function (dataset) {

   let choices = dataset;
   let chosen = choices.splice(0,5);
    
   console.log("choices of Choices now contains");
   console.log(choices);
   console.log("Chosen chosen now contains");
	console.log(chosen);

   let test = d3.select("svg")
                 .data(chosen)
                 .enter()
                 .append("g")
                 .attr("x", function(d, i){
                  console.log("group#"+i);
                  return innerTo.left + (i * 65);
                 });
    
   let firstChoices = svg.selectAll("image")
                          .data(choices);
    
   let firstChosen = svg.selectAll("image.chosen")
                          .data(chosen); 
    
   function fillChoicesBox(whichChoices){

           whichChoices.enter()
           .append("svg:image")
           .attr("xlink:href", function(d){
                return d.artistArtSpot;
           })
           .attr("transform", function (d,i){
                xOff = (i%10) * 75 + margin.left + spacepadding;
                yOff = Math.floor(i/10) * 75 + margin.top + spacepadding;
                return "translate(" + xOff + "," + yOff + ")";
           })
           .attr("data-artistName", (d) => d.artistNameSpot)
           .attr("data-artistPop", (d) => d.pop)
           .attr("data-artistSpotID", (d) => d.artistSpotID)
           .attr("data-popDate", (d) => d.date)
           .attr("class", "choice")
           .append("title")
           .text((d) => d.artistNameSpot)
           .attr("initial-x", (d) => d.x)
           .attr("initial-y", (d) => d.y);       
   };
    
   function fillChosenBox(whichChosen){

           whichChosen.enter()
           .append("svg:image")
           .attr("xlink:href", function (d){
                return d.artistArtSpot;
           })
           .attr("x", function (d,i) {
                return innerTo.left + (i * 65);
           })
           .attr("y", function(d) {
                return h - innerTo.bottom - 64;
           })
           .attr("width", 64)
           .attr("height", 64)
           .attr("data-artistName", (d) => d.artistNameSpot)
           .attr("data-artistPop", (d) => d.pop)
           .attr("data-artistSpotID", (d) => d.artistSpotID)
           .attr("data-popDate", (d) => d.date)
           .attr("class", "chosen")
           .append("title")
           .text((d) => d.artistNameSpot)
           .attr("initial-x", (d) => d.x)
           .attr("initial-y", (d) => d.y);        
    };
    
    function makeColumns(){
        svg.selectAll("rect.column")
           .data(chosen)
           .enter()
           .append("rect")
           .attr("x", function (d,i) {
                return innerTo.left + (i * 65);
            })
           .attr("y", function(d) {
                return h - innerTo.bottom - 64 - (d.pop * 2)
           })
           .attr("width", 64)
           .attr("height", function(d) {
                return (d.pop * 2);
           })
           .attr("class", "column")
           .exit()
           .remove();
    };
    
    // Popularity text Labels atop columns
    function makeColumnLabels(){
      svg.selectAll("text")
	   .data(chosen)
	   .enter()
	   .append("text")
	   .text(function(d){
			return d.pop;
	   })
	   .attr("text-anchor", "middle")
	   .attr("x", function (d, i){
			return innerTo.left + (i * 65 + 65 / 2);
	   })
	   .attr("y", function(d){
			return h - innerTo.bottom - 64 - (d.pop * 2) - 5;
	   })
	   .attr("font-family", "sans-serif")
	   .attr("font-size", "11px")
	   .attr("fill", "white");  
    }
    
	function moveitonover(chosen){
        chosen.push(chosen);
        console.log ("Added " + chosen.artistNameSpot + " to Chosen.");
        console.log(chosen);
        let oldindex = choices.indexOf(chosen);
        choices.splice(oldindex, 1);
        console.log ("Removed " + chosen.artistNameSpot + " from choices of Choices.");
        console.log(choices);
    };
    
    function makeachoice(choice){
        choices.push(choice);
        console.log ("Added " + choice.artistNameSpot + " to choices of Choices.");
        //console.log(choices);
        let oldindex = chosen.indexOf(choice);
        chosen.splice(oldindex, 1);
        console.log ("Removed " + choice.artistNameSpot + " from Chosen.");
        //console.log(chosen);
    };

    
    // CHOICE
    
    const choiceHandler = d3.drag()
        .on("start", function (d){
            //console.log ("Picked up " + d.artistNameSpot);
            choiceItemReady = true;
            //console.log("choiceItemReady is " + choiceItemReady);
            d3.select(this)
              .attr("x", d3.event.x)
              .attr("y", d3.event.y);
        })
        .on("drag", function (d) {
            const mouse = d3.mouse(this);
            const picWidth = 64;
            const picHeight = 64;
            //console.log ("Dragging " + d.artistNameSpot);
            d3.select(this)
              // the event x and y under Start was here
              .attr("x", (mouse[0])-picWidth/2)
              .attr("y", (mouse[1])-picHeight/2)
              .attr("pointer-events", "none");
        })
        .on("end", function (d) {
            
            choiceItemReady = false;
            //console.log("choiceItemReady is " + choiceItemReady);
            
            if (chosenBoxReady == true){
                
                moveitonover(d);
                /*
                d3.select(this)
                   //.attr("class", "chosen");
                   .exit()
                   .remove();
                */
                let c = svg.selectAll(".choice")
                           .data(choices);
                
                c.enter()
                 .append("svg:image")
                 .merge(c)
                 .attr("xlink:href", function(d){
                    return d.artistArtSpot;
                 })
                 .attr("transform", function (d,i){
                    xOff = (i%10) * 75 + margin.left + spacepadding;
                    yOff = Math.floor(i/10) * 75 + margin.top + spacepadding;
                    return "translate(" + xOff + "," + yOff + ")";
                 })
                 .attr("data-artistName", (d) => d.artistNameSpot)
                 .attr("data-artistPop", (d) => d.pop)
                 .attr("data-artistSpotID", (d) => d.artistSpotID)
                 .attr("data-popDate", (d) => d.date)
                 .attr("class", "choice")
                 .append("title")
                 .text((d) => d.artistNameSpot)
                 .attr("initial-x", (d) => d.x)
                 .attr("initial-y", (d) => d.y); 
                 
                 c.exit()
                  .remove();
            
                let u = svg.selectAll(".column")
                           .data(chosen);    

                u.enter()
                 .append("rect")
                 .attr("class", "column")
                 .merge(u)
                 .attr("x", function (d,i) {
                    return innerTo.left + (i * 65);
                 })
                 .attr("y", function(d) {
                    return h - innerTo.bottom - 64 - (d.pop * 2)
                 })
                 .attr("width", 64)
                 .attr("height", function(d) {
                    return (d.pop * 2);
                 });
                
                u.exit()
                 .remove();
                /**/
                let t = svg.selectAll("text")
                           .data(chosen);
                
                t.enter()
                 .append("text")
                 .merge(t)
                 .text(function(d){
                    return d.pop;
                 })
                 .attr("text-anchor", "middle")
                 .attr("x", function (d, i){
                    return innerTo.left + (i * 65 + 65 / 2);
                 })
                 .attr("y", function(d){
                    return h - innerTo.bottom - 64 - (d.pop * 2) - 5;
                 })
                 .attr("font-family", "sans-serif")
                 .attr("font-size", "11px")
                 .attr("fill", "white");
                
                t.exit().remove();
                
                let v = svg.selectAll("image.chosen")
                           .data(chosen);

                v.enter()
                 .append("svg:image")
                 .merge(v)                
                 .attr("xlink:href", function (d){
                    return d.artistArtSpot;
                 })
                 .attr("x", function (d,i) {
                    return innerTo.left + (i * 65);
                 })
                 .attr("y", function(d) {
                    return h - innerTo.bottom - 64;
                 })
                 .attr("width", 64)
                 .attr("height", 64)
                 .attr("data-artistName", (d) => d.artistNameSpot)
                 .attr("data-artistPop", (d) => d.pop)
                 .attr("data-artistSpotID", (d) => d.artistSpotID)
                 .attr("data-popDate", (d) => d.date)
                 .attr("class", "chosen")
                 .append("title")
                 .text((d) => d.artistNameSpot)
                 .attr("initial-x", (d) => d.x)
                 .attr("initial-y", (d) => d.y); 
                
                v.exit().remove();   
                /*

                 */
                choiceHandler(svg.selectAll(".choice"));
                chosenHandler(svg.selectAll(".chosen"));
                
                } else {
                    d3.select(this)
                      .attr("x", "initial-x")
                      .attr("y", "initial-y")
                      .attr("pointer-events", "auto");
                };
	   });
 
    
    // CHOSEN
    
    const chosenHandler = d3.drag()
        .on("start", function (d){
            console.log ("Wait, what?");
            chosenItemReady = true;
            console.log("chosenItemReady is " + chosenItemReady);
        })
        .on("drag", function (d) {
            const mouse = d3.mouse(this);
            const picWidth = 64;
            const picHeight = 64;
            d3.select(this)
              // the event x and y under Start was here
              .attr("x", (mouse[0])-picWidth/2)
              .attr("y", (mouse[1])-picHeight/2)
              .attr("pointer-events", "none");
        })
        .on("end", function (d) {
            
            chosenItemReady = false;
            console.log("chosenItemReady is " + chosenItemReady);
            
            if (choicesBoxReady == true){
                
                makeachoice(d);
                /*
                let k = choices.indexOf(d);

                //let newlength = choices.length;
                console.log ("k = " + k);
                
                d3.select(this)
                    
                  .attr("x", function (d) {
                    return (k%10) * 75 + margin.left + spacepadding;
                  })
                  .attr("y", function(d) {
                    return Math.floor(k/10) * 75 + margin.top + spacepadding;
                  })
                  .attr("pointer-events", "auto")
                  .attr("class", "choice");         
                */
                let u = svg.selectAll(".column")
                           .data(chosen);    
                
                u.enter()
                 .append("rect")
                 .merge(u)
                 .attr("x", function (d,i) {
                    return innerTo.left + (i * 65);
                 })
                 .attr("y", function(d) {
                    return h - innerTo.bottom - 64 - (d.pop * 2)
                 })
                 .attr("width", 64)
                 .attr("height", function(d) {
                    return (d.pop * 2);
                 })
                 .attr("class", "column");
                
                u.exit()
                 .remove();
                /**/
                let t = svg.selectAll("text")
                           .data(chosen);
                
                t.enter()
                 .append("text")
                 .merge(t)
                 .text(function(d){
                    return d.pop;
                 })
                 .attr("text-anchor", "middle")
                 .attr("x", function (d, i){
                    return innerTo.left + (i * 65 + 65 / 2);
                 })
                 .attr("y", function(d){
                    return h - innerTo.bottom - 64 - (d.pop * 2) - 5;
                 })
                 .attr("font-family", "sans-serif")
                 .attr("font-size", "11px")
                 .attr("fill", "white");
                
                t.exit().remove();
                
                let v = svg.selectAll(".chosen")
                           .data(chosen);

                v.enter()
                 .append("svg:image")
                 .merge(v)                
                 .attr("xlink:href", function (d){
                    return d.artistArtSpot;
                 })
                 .attr("x", function (d,i) {
                    return innerTo.left + (i * 65);
                 })
                 .attr("y", function(d) {
                    return h - innerTo.bottom - 64;
                 })
                 .attr("width", 64)
                 .attr("height", 64)
                 .attr("data-artistName", (d) => d.artistNameSpot)
                 .attr("data-artistPop", (d) => d.pop)
                 .attr("data-artistSpotID", (d) => d.artistSpotID)
                 .attr("data-popDate", (d) => d.date)
                 .attr("class", "chosen")
                 .append("title")
                 .text((d) => d.artistNameSpot)
                 .attr("initial-x", (d) => d.x)
                 .attr("initial-y", (d) => d.y); 
                
                v.exit().remove();

                let c = svg.selectAll(".choice")
                           .data(choices);
                
                c.enter()
                 .append("svg:image")
                 .merge(c)
                 .attr("xlink:href", function(d){
                    return d.artistArtSpot;
                 })
                 .attr("transform", function (d,i){
                    xOff = (i%10) * 75 + margin.left + spacepadding;
                    yOff = Math.floor(i/10) * 75 + margin.top + spacepadding;
                    return "translate(" + xOff + "," + yOff + ")";
                 })
                 .attr("data-artistName", (d) => d.artistNameSpot)
                 .attr("data-artistPop", (d) => d.pop)
                 .attr("data-artistSpotID", (d) => d.artistSpotID)
                 .attr("data-popDate", (d) => d.date)
                 .attr("class", "choice")
                 .append("title")
                 .text((d) => d.artistNameSpot)
                 .attr("initial-x", (d) => d.x)
                 .attr("initial-y", (d) => d.y); 
                 
                 c.exit()
                  .remove();
                
                choiceHandler(svg.selectAll(".choice"));
                chosenHandler(svg.selectAll(".chosen"));
            } else {
                d3.select(this)
                  .attr("x", "initial-x")
                  .attr("y", "initial-y")
                  .attr("pointer-events", "auto");
            };
	   });
    
    fillChoicesBox(firstChoices);
    fillChosenBox(firstChosen);
    
    makeColumns();
    makeColumnLabels();
    
	choiceHandler(svg.selectAll(".choice"));
    chosenHandler(svg.selectAll(".chosen"));
    
});
        
</script>

<?php echo $scriptsAndSuch; ?>	
<script src="https://www.roxorsoxor.com/poprock/page_pieces/navbarIndex.js"></script>
<script src="https://www.roxorsoxor.com/poprock/dragdrop/dragdrop.js"></script>
</body>
</html>