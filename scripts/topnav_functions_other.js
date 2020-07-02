// onClick functions that declare the destination are in projects.php

// make functions for colorizing and fading buttons
function greyize(id) {$('#' +id).css({"background" : "url('images/hsbg_grey.gif')" , "border-top" : "6px solid #000000"});}
function colorize(id){$('#' +id).css({"background" : "url('images/hsbg-8.png')" , "border-top" : "6px solid #FC265D"});}
function fade(id)    {$('#' +id).css({"background" : "none" , "border-top" : "6px solid #ffffff"});}

// fade all buttons except one
// if none is selected, all will fade
function fadeAllExcept(exc) {
    if(exc != "nav-show"){fade('nav-show');};
    if(exc != "nav-work"){fade('nav-work');};
    if(exc != "nav-cast"){fade('nav-cast');};
    if(exc != "nav-thtp"){fade('nav-thtp');};
}

// hover states for .nav-btn's
$("#nav-show").hover(
    function(){colorize('nav-show');}, // mouse over
    function(){fade('nav-show');}      // mouse out
);
$("#nav-work").hover(
    function(){colorize('nav-work');},
    function(){fade('nav-work');}
);
$("#nav-cast").hover(
    function(){colorize('nav-cast');},
    function(){fade('nav-cast');}
);
$("#nav-random").hover(
    function(){colorize('nav-random');},
    function(){fade('nav-random');}
);