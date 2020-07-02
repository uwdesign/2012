// animate-scroll when nav buttons are clicked
$("document").ready(function() {
    
    $('#nav-show').click(function(){
        $('html, body').animate({
            scrollTop: $("#theshow").offset().top
        }, 1500);
     });

    $('#nav-work').click(function(){
        $('html, body').animate({
            scrollTop: $("#thework").offset().top
        }, 1500);
     });

    $('#nav-cast').click(function(){
        $('html, body').animate({
            scrollTop: $("#thecast").offset().top
        }, 1500);
     });
    
});

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

// check to see which div is scrolled into view, and colorize appropriately
function isScrolledIntoView(elem) {
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();

    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();

    return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom));
}

var show = $('#theshow'); // set up variables for the ids we are dealing with
var work = $('#thework'); // they are used in the above function isScrolledIntoView()
var cast = $('#thecast');
var thtp = $('#thetop');

// hover states for .nav-btn's
$("#nav-show").hover(
    function(){colorize('nav-show');},          // mouse over
    function(){if(!isScrolledIntoView(show)){   // mouse out
        fade('nav-show');
    } else {
        greyize('nav-show');
    }}
);
$("#nav-work").hover(
    function(){colorize('nav-work');},
    function(){if(!isScrolledIntoView(work)){
        fade('nav-work');
    } else {
        greyize('nav-work');
    }}
);
$("#nav-cast").hover(
    function(){colorize('nav-cast');},
    function(){if(!isScrolledIntoView(cast)){
        fade('nav-cast');
    } else {
        greyize('nav-cast');
    }}
);
$("#nav-random").hover(
    function(){colorize('nav-random');},
    function(){fade('nav-random');}
);


// based on where you are in the page, change a value
$(document).ready(function() {
        
    $(window).scroll(function() {
        if(isScrolledIntoView(show)) {
            greyize('nav-show');
            fadeAllExcept('nav-show');
        } else if(isScrolledIntoView(work)) {
            greyize('nav-work');
            fadeAllExcept('nav-work');
        } else if(isScrolledIntoView(cast)) {
            greyize('nav-cast');
            fadeAllExcept('nav-cast');
        } else if(isScrolledIntoView(thtp)) {
            fadeAllExcept('');
        } else {
            // do nothing?
        }
    });
});