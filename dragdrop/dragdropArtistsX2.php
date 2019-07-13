<?php 
    require_once '../rockdb.php';
    require_once '../page_pieces/stylesAndScripts.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Drag-n-Drop X2</title>
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

   let thechoices = dataset;
   let thechosen = thechoices.splice(0,5);
    
   console.log("Choices now contains");
   console.log(thechoices);
   console.log("Chosen now contains");
   console.log(thechosen);
/*
   let test = d3.select("svg")
                 .data(thechosen)
                 .enter()
                 .append("g")
                 .attr("x", function(d, i){
                  console.log("group#"+i);
                  return innerTo.left + (i * 65);
                 });
   */ 
   let firstChoices = svg.selectAll(".choice")
                          .data(thechoices);
    
   let firstChosen = svg.selectAll(".chosen")
                          .data(thechosen); 
    
    function fillChoicesBox(whichChoices){

        whichChoices.enter()
                    .append("svg:image")
                    .attr("xlink:href", function(d){
                        return d.artistArtSpot;
                    })
                    .attr("x", function (d,i){
                        x = (i%10) * 75 + margin.left + spacepadding;
                        return x;
                    })
                    .attr("y", function (d,i){
                        y = Math.floor(i/10) * 75 + margin.top + spacepadding;
                        return y;
                    })                    
                    /*
                    .attr("transform", function (d,i){
                        xOff = (i%10) * 75 + margin.left + spacepadding;
                        yOff = Math.floor(i/10) * 75 + margin.top + spacepadding;
                        return "translate(" + xOff + "," + yOff + ")";
                    })
                    */
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
        svg.selectAll(".column")
           .data(thechosen)
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
	   .data(thechosen)
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
    
	function choicetochosen(aChoice){
        // Add this artist to theChosen
        thechosen.push(aChoice);
        console.log ("Added " + aChoice.artistNameSpot + " to Chosen.");
        console.log(thechosen);
        // Remove this artist from theChoices
        let oldindex = thechoices.indexOf(aChoice);
        thechoices.splice(oldindex, 1);
        console.log ("Removed " + aChoice.artistNameSpot + " from Choices.");
        console.log(thechoices);
    };
    
    function chosentochoice(aChosen){
        // Add this artist to theChoices
        thechoices.push(aChosen);
        console.log ("Added " + aChosen.artistNameSpot + " to Choices.");
        console.log(thechoices);
        // Remove this artist from theChosen
        let oldindex = thechosen.indexOf(aChosen);
        thechosen.splice(oldindex, 1);
        console.log ("Removed " + aChosen.artistNameSpot + " from Chosen.");
        console.log(thechosen);
    };

    
    // CHOICE HANDLER
    const choiceHandler = d3.drag()
        .on("start", function (d){
            console.log ("Picked up " + d.artistNameSpot + " from Choices");
            choiceItemReady = true;
            console.log("choiceItemReady is " + choiceItemReady);
        })
        .on("drag", function (d) {
            const mouse = d3.mouse(this);
            const picWidth = 64;
            const picHeight = 64;
            console.log ("Dragging " + d.artistNameSpot);
            d3.select(this)
              // the event x and y under Start was here
              .attr("x", (mouse[0])-picWidth/2)
              .attr("y", (mouse[1])-picHeight/2)
              .attr("pointer-events", "none");
        })
        // CHOICE TO CHOSEN END
        .on("end", function (d) {
            
            choiceItemReady = false;
            // I think above needs to go last. APPARENTLY NOT!
            console.log("choiceItemReady is " + choiceItemReady);
            
            if (chosenBoxReady == true){
                
                choicetochosen(d);

                // Update images in Choices, remove from Choices and move others over
                let aa = svg.selectAll(".choice")
                            .data(thechoices);
                
                aa.enter()
                 .append("svg:image")
                 .merge(aa)
                 .attr("xlink:href", function(d){
                    return d.artistArtSpot;
                 })
                 .attr("x", function (d,i){
                    x = (i%10) * 75 + margin.left + spacepadding;
                    return x;
                })
                .attr("y", function (d,i){
                    y = Math.floor(i/10) * 75 + margin.top + spacepadding;
                    return y;
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
                 
                 aa.exit()
                  .remove();
            
                // Update Columns, Remove Column from theChosen and move others over
                let ac = svg.selectAll(".column")
                           .data(thechosen);    

                ac.enter()
                 .append("rect")
                 .merge(ac)
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
                
                ac.exit()
                 .remove();
                
                // Update text labels, Remove label from theChosen and move others over
                let ad = svg.selectAll("text")
                           .data(thechosen);
                
                ad.enter()
                 .append("text")
                 .merge(ad)
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
                
                ad.exit().remove();
                
                // Update images in theChosen, Remove image from theChosen and move others over
                let ab = svg.selectAll(".chosen")
                           .data(thechosen);

                ab.enter()
                 .append("svg:image")
                 .merge(ab)                
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
                
                ab.exit().remove();   
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
 
    
    // CHOSEN HANDLER
    const chosenHandler = d3.drag()
        .on("start", function (d){
            console.log ("Picked up " + d.artistNameSpot + " from theChosen");
            chosenItemReady = true;
            console.log("chosenItemReady is " + chosenItemReady);
        })
        .on("drag", function (d) {
            const mouse = d3.mouse(this);
            const picWidth = 64;
            const picHeight = 64;
            console.log ("Dragging " + d.artistNameSpot);
            d3.select(this)
              // the event x and y under Start was here
              .attr("x", (mouse[0])-picWidth/2)
              .attr("y", (mouse[1])-picHeight/2)
              .attr("pointer-events", "none");
        })
        // CHOSEN TO CHOICE END
        .on("end", function (d) {
            
            chosenItemReady = false;
            // I think above needs to go last. APPARENTLY NOT!
            console.log("chosenItemReady is " + chosenItemReady);
            
            if (choicesBoxReady == true){
                
                chosentochoice(d);

                // Update images in Choices, Add image to end of theChoices
                let ba = svg.selectAll(".choice")
                           .data(thechoices);
                
                ba.enter()
                 .append("svg:image")
                 .merge(ba)
                 .attr("xlink:href", function(d){
                    return d.artistArtSpot;
                 })
                 .attr("x", function (d,i){
                    x = (i%10) * 75 + margin.left + spacepadding;
                    return x;
                })
                .attr("y", function (d,i){
                    y = Math.floor(i/10) * 75 + margin.top + spacepadding;
                    return y;
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
                 
                 ba.exit()
                  .remove();

                // Update Columns, Remove Column from theChosen and move others over
                let bc = svg.selectAll(".column")
                           .data(thechosen);    
                
                bc.enter()
                 .append("rect")
                 .merge(bc)
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
                
                bc.exit()
                 .remove();
                
                // Update text labels, Remove label from theChosen and move others over
                let bd = svg.selectAll("text")
                           .data(thechosen);
                
                bd.enter()
                 .append("text")
                 .merge(bd)
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
                
                bd.exit().remove();
                
                // Update images in theChosen, Remove image from theChosen and move others over
                let bb = svg.selectAll(".chosen")
                           .data(thechosen);

                bb.enter()
                 .append("svg:image")
                 .merge(bb)                
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
                
                bb.exit().remove();
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