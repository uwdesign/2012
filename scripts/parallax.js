// vertical scrolling variable declarations

var pdiv1 = $('#plax-elem1'); // set div to apply the parallax to
var pdiv2 = $('#plax-elem2');
var pdiv3 = $('#plax-elem3');
var pdiv4 = $('#plax-elem4');

var set1 = -1800; // set values for the beginning position of the images
var set2 = -400;  // these need to match the CSS
var set3 = 1000;
var set4 = 2400;
var set5 = 1436;  // value for side-scrolling top val (set3 + 436)

var mod1 = 0.76923; // set modifiers for how much each scrolls
var mod2 = 0.23077;
var mod3 = -0.30769;
var mod4 = -0.846;


// horizontal scrolling variables

var pdiv5 = $('#plax-info1'); // divs to come in sideways
var pdiv6 = $('#plax-info2');

var het1 = 30;  // set values for side-scrolling left vals
var het2 = 480;

var hod1 = 0; // modifiers for side-scrollers
var hod2 = 0; // they don't move at the beginning


$(document).ready(function() {
    
    layer1 = set1; // create a variable that contains the starting position .png's
    layer2 = set2;
    layer3 = set3;
    layer4 = set4;
    layer5 = set5;
    layer6 = set5;
    
    // apply CSS positioning values based on the initial set
    pdiv1.css({"top" : +layer1+ "px"});
    pdiv2.css({"top" : +layer2+ "px"});
    pdiv3.css({"top" : +layer3+ "px"});
    pdiv4.css({"top" : +layer4+ "px"});
    pdiv5.css({"top" : +layer5+ "px"});
    pdiv6.css({"top" : +layer6+ "px"});
    
    // function to be called whenever the window is scrolled
    function parallax(){
        pos = $(window).scrollTop(); // get the position of the scrollbar
        
	// check to see where the scrollbar is (allow to pause between 1500 and 2500)
	// mod3, set3 and set5 never change
	if (pos <= 2600) {
	    mod1 = 0.76923;
	    mod2 = 0.23077;
	    mod4 = -0.846;
	    set1 = -1800;
	    set2 = -400;
	    set4 = 2400;
	} else if(pos > 2600 && pos <= 3200) {
	    mod1 = -0.30769;
	    mod2 = -0.30769;
	    mod4 = -0.30769;
	    set1 = 1000;
	    set2 = 1000;
	    set4 = 1000;
	} else if(pos > 3200) {
	    mod1 = 0.76923;
	    mod2 = 0.23077;
	    mod4 = -0.846;
	    set1 = -2445;
	    set2 = -722;
	    set4 = 2723;
	}
	
	layer1 = set1 + pos * mod1; // create var for the starting position for .png's
	layer2 = set2 + pos * mod2;
	layer3 = set3 + pos * mod3;
	layer4 = set4 + pos * mod4;
	layer5 = set5 + pos * mod3;
	layer6 = set5 + pos * mod3;
	layer1 = Math.round(layer1); // round the values to a whole number
	layer2 = Math.round(layer2);
	layer3 = Math.round(layer3);
	layer4 = Math.round(layer4);
	layer5 = Math.round(layer5);
	layer6 = Math.round(layer6);
	
	pdiv1.css({"top" : +layer1+ "px" }); // same as above
	pdiv2.css({"top" : +layer2+ "px" });
	pdiv3.css({"top" : +layer3+ "px" });
	pdiv4.css({"top" : +layer4+ "px" });
	pdiv5.css({"top" : +layer5+ "px" });
	pdiv6.css({"top" : +layer6+ "px" });
    }
    
    $(window).bind('scroll', function(){ // when the user is scrolling...
	parallax();
	//sideParallax();
    });
});