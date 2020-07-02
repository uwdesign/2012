<?php

require_once("dbauth/dbconnect.php");

$iniQuery = "SELECT * FROM PROJECTS_capstone";
$iniresult = mysql_query($iniQuery, $db) or die("Error: " .mysql_error());
$wAmnt = mysql_num_rows($iniresult);       // total projects
$nFields = mysql_num_fields($iniresult);   // total titles

// vars for counting tags
$tag1num = 0;   // branding
$tag2num = 0;   // consumer product
$tag3num = 0;   // environment
$tag4num = 0;   // info vis
$tag5num = 0;   // interactive
$tag6num = 0;   // medical/science
$tag7num = 0;   // mobile
$tag8num = 0;   // motion
$tag9num = 0;   // print
$tag10num = 0;  // publication
$tag11num = 0;  // sustainable
$tag12num = 0;  // systems
$tag13num = 0;  // web design

$tag14num = 0;  // majors (we wont use these, probably)
$tag15num = 0;
$tag16num = 0;

// grab the information from the database (titles / tags / thumbs)
for($i=1; $i<=$wAmnt; $i++){
    
    $projQuery = "SELECT * FROM PROJECTS_capstone WHERE id='$i'";
    $projResult = mysql_query($projQuery, $db) or die("Error: " .mysql_error());
    $all = mysql_fetch_array($projResult);
    
    $title[$i]  = $all[1];
    $tag[$i]    = $all[2];
    $thumb[$i]  = "student_work/" .$all[17];
    
    $tag[$i] = explode(", ", $tag[$i]);
    $tagAmnt[$i] = (count($tag[$i]));
    
    // increment the tags values
    for($j=0; $j<$tagAmnt[$i]; $j++){
        $curtag = $tag[$i][$j];
        
        if($curtag == "Branding"){$tag1num++;}
        if($curtag == "Consumer"){$tag2num++;}
        if($curtag == "Environment"){$tag3num++;}
        if($curtag == "Information"){$tag4num++;}
        if($curtag == "Interactive"){$tag5num++;}
        if($curtag == "Medical"){$tag6num++;}
        if($curtag == "Mobile"){$tag7num++;}
        if($curtag == "Motion"){$tag8num++;}
        if($curtag == "Print"){$tag9num++;}
        if($curtag == "Publication"){$tag10num++;}
        if($curtag == "Sustainable"){$tag11num++;}
        if($curtag == "Systems"){$tag12num++;}
        if($curtag == "Web"){$tag13num++;}
        
        if($curtag == "ID"){$tag14num++;}
        if($curtag == "IXD"){$tag15num++;}
        if($curtag == "VCD"){$tag16num++;}
    }
}

// take the tag counts and put them in an array
$tagStats = array(
    1 => $tag1num,
    2 => $tag2num,
    3 => $tag3num,
    4 => $tag4num,
    5 => $tag5num,
    6 => $tag6num,
    7 => $tag7num,
    8 => $tag8num,
    9 => $tag9num,
    10 => $tag10num,
    11 => $tag11num,
    12 => $tag12num,
    13 => $tag13num // stops at 13 to not include major tags
);

// count and sort the array
$tagStatsAmnt = count($tagStats);
arsort($tagStats,SORT_NUMERIC);

// grab the keys (since they're jumbled now)
$popTagsKeys = array_keys($tagStats);

// populate the values into a new array
$popTagsVals = array();
for($i=0; $i<6; $i++){
    
    // conditional statement allows for less than 6 returned values
    if($tagStats[$popTagsKeys[$i]] != ""){$popTagsVals[$i] = $tagStats[$popTagsKeys[$i]];}
    
    // rename the keys based on the corresponding tag name
    if($popTagsKeys[$i] == 1){$popTagsKeysName[$i] = "Branding";}
    if($popTagsKeys[$i] == 2){$popTagsKeysName[$i] = "Consumer";}
    if($popTagsKeys[$i] == 3){$popTagsKeysName[$i] = "Environment";}
    if($popTagsKeys[$i] == 4){$popTagsKeysName[$i] = "Information";}
    if($popTagsKeys[$i] == 5){$popTagsKeysName[$i] = "Interactive";}
    if($popTagsKeys[$i] == 6){$popTagsKeysName[$i] = "Medical";}
    if($popTagsKeys[$i] == 7){$popTagsKeysName[$i] = "Mobile";}
    if($popTagsKeys[$i] == 8){$popTagsKeysName[$i] = "Motion";}
    if($popTagsKeys[$i] == 9){$popTagsKeysName[$i] = "Print";}
    if($popTagsKeys[$i] == 10){$popTagsKeysName[$i] = "Publication";}
    if($popTagsKeys[$i] == 11){$popTagsKeysName[$i] = "Sustainable";}
    if($popTagsKeys[$i] == 12){$popTagsKeysName[$i] = "Systems";}
    if($popTagsKeys[$i] == 13){$popTagsKeysName[$i] = "Web";}
}

$popTagsTotal = count($popTagsKeysName);


// array of consecutive integers
// equal to total number of projects (and thus thumbs)
// used to shuffle the display order of thumbnails
$p = array();
for($i=1; $i<=$wAmnt; $i++){
    $p[$i] = $i;
}

// array of the heights of the thumbnails
$pHeight = array();
for($i=1; $i<=$wAmnt; $i++){
    $imgUrl = $thumb[$i];
    $pHeight[$i] = getimagesize($imgUrl);
}


// random project to be chosen when the "random project" is selected
$randProjId = rand(1,$wAmnt);

// doctype, title, metadata, external links, etc.
include "doc_setup.html"; 

print <<<END


<!-- page-specific stylesheets (still in <head>) and scripts -->
<link rel="stylesheet" type="text/css" href="styles/index.css">


<!-- DIVs declared up here should be positioned absolute or fixed -->
<!-- do not add divs to the flow until after the B O D Y comment -->


<!-- #HEADER provides the nav -->
<!-- functions are controlled via scripts/topnav_functions_index.js -->
<div id="header">
    <div id="nav-show" class="nav-btn" style="margin:0px 0px 0px 18px;" onMouseOver="hideSubNav();"><p class="nav-btn-link">The Show</p></div>
    <div id="nav-work" class="nav-btn" onMouseOver="showSubNav()" onMouseDown="hideSubNav();"><p class="nav-btn-link">The Work</p></div>
    <div id="nav-cast" class="nav-btn" onMouseOver="hideSubNav();"><p class="nav-btn-link">The Cast</p></div>
    <div id="nav-random" class="nav-btn" onClick="window.location='projects.php?w$randProjId'"><p class="nav-btn-link">Surprise Me</p></div>
    <div id="nav-right"><p>UW DESIGN SHOW 2012</p></div>
</div>


END;

include "subnav.html";

print <<<END


<!-- #THETOP is the anchor that resets all of the tabs in the nav -->
<!-- nothing links to it... -->
<div id="thetop" style="position:absolute;top:1000px;left:0px;"></div>


<!-- #THESHOW is anchored where the parallax is best viewed -->
<!-- to style this div access styles/parallax.css -->
<div id="theshow"> </div>


<!-- #PLAX-_____ are defined initially in styles/parallax.css -->
<!-- behaviors are defined in scripts/parallax.js -->

<script type="text/javascript">

function loadFin(){
    d = document.getElementById('loading-screen');
    d.style.display = "none";
}

</script>

<div id="plax-elem0"> <img src="images/showdonttell.gif" alt="show, don't tell" /> </div>

<div id="plax-elem1"> <img src="images/parallax-1.png" alt="show, don't tell" /> </div>
<div id="plax-elem2"> <img src="images/parallax-2.png" alt="show, don't tell" /> </div>
<div id="plax-elem3"> <img src="images/parallax-3.png" alt="show, don't tell" /> </div>
<div id="plax-elem4"> <img src="images/parallax-4.png" alt="show, don't tell" /> </div>

<div id="plax-info1">
    
    <div class="plax-info-head">
    <h2 style="color:#ffffff;">UW Design Show 2012</h2>
    </div>
    
    <div class="plax-info-subhead">
    <h5 style="color:#ffffff;">B.Des &mdash; Bachelor of Design</h5>
    </div>
    
    <div class="plax-info-scol">
    <h6 style="color:#ffffff;letter-spacing:0.1em;">WHERE?</h6>
    <p><a href="https://maps.google.com/maps/place?um=1&ie=UTF-8&q=jacob+lawrence+art+gallery&fb=1&gl=us&hq=jacob+lawrence+art+gallery&hnear=0x5490102c93e83355:0x102565466944d59a,Seattle,+WA&cid=8135398364775886000&ei=y4K1T5PWDIGiiQL-z_z6Bg&sa=X&oi=local_result&ct=map-marker-link&resnum=1&ved=0CI0BEK8LMAA" target="_blank" style="text-decoration:underline;">Jacob Lawrence Gallery</a><br>
    <a href="https://www.washington.edu/maps/?l=ART" target="_blank" style="text-decoration:underline;">School of Art</a><br>
    <a href="https://maps.google.com/maps/place?hl=en&safe=off&gl=us&bav=on.2,or.r_gc.r_pw.r_cp.r_qf.,cf.osb&biw=1216&bih=784&um=1&ie=UTF-8&q=university+of+washington+seattle+visitors+center&fb=1&gl=us&hq=university+of+washington+seattle+visitors+center&cid=8839807670201480870&ei=bYO1T93ZDK3YiQKC0LGsBw&sa=X&oi=local_result&ct=map-marker-link&resnum=5&ved=0CI4BEK8LMAQ" target="_blank" style="text-decoration:underline;">University of Washington</a></p>
    
    <h6 style="color:#ffffff;letter-spacing:0.1em;">WHEN?</h6>
    <p>6 &ndash; 16 June<br>
    Open Wednesday &ndash; Saturday<br>
    12 &ndash; 4pm</p>
    </div>
    
    <div class="plax-info-lcol">
    <h5 style="color:#ffffff;letter-spacing:0.1em;">PROFESSIONAL<br>NIGHT</h2>
    <p>Tuesday 5 June<br>
    5 &ndash; 8pm</p>
    
    <h5 style="color:#ffffff;letter-spacing:0.1em;">FRIENDS & FAMILY<br>NIGHT</h2>
    <p>Wednesday 6 June<br>
    5 &ndash; 8pm<br>
    Introductions & Awards:<br>
    6:30pm</p>
    </div>
    
</div>

<div id="plax-info2">
    
    <div class="plax-info-head">
    <h2>&nbsp;</h2>
    </div>
    
    <div class="plax-info-subhead">
    <h5 style="color:#ffffff;">M.Des &mdash; Master of Design</h5>
    </div>
    
    <div class="plax-info-scol">
    <h5 style="color:#ffffff;letter-spacing:0.1em;">MASTER OF DESIGN THESIS EXHIBITION</h5>
    <p><a href="https://maps.google.com/maps/place?um=1&ie=UTF-8&q=henry+art+gallery&fb=1&gl=us&hq=henry+art+gallery&hnear=0x5490102c93e83355:0x102565466944d59a,Seattle,+WA&cid=8125824423033647840&ei=toK1T5jSCuepiQLuuvmSBw&sa=X&oi=local_result&ct=map-marker-link&resnum=1&ved=0CIcBEK8LMAA" target="_blank" style="text-decoration:underline;">Henry Art Gallery</a><br>
    <a href="https://maps.google.com/maps/place?hl=en&safe=off&gl=us&bav=on.2,or.r_gc.r_pw.r_cp.r_qf.,cf.osb&biw=1216&bih=784&um=1&ie=UTF-8&q=university+of+washington+seattle+visitors+center&fb=1&gl=us&hq=university+of+washington+seattle+visitors+center&cid=8839807670201480870&ei=bYO1T93ZDK3YiQKC0LGsBw&sa=X&oi=local_result&ct=map-marker-link&resnum=5&ved=0CI4BEK8LMAQ" target="_blank" style="text-decoration:underline;">University of Washington</a></p>
    
    <p>26 May &ndash; 17 June<br>
    Opening Reception:<br>
    Friday 25 May<br>
    7 &ndash; 9pm</p>
    </div>
    
    <div class="plax-info-scol">
    <h5 style="color:#ffffff;letter-spacing:0.1em;">MASTER OF DESIGN THESIS PRESENTATIONS</h5>
    <p>Thursday 31 May<br>
    5 &ndash; 8:30pm<br>
    Conference Room<br>
    Mezzanine Level</p>
    </div>
    
</div>

<!-- / #PLAX stuff -->


</head>
<body>


<!-- B O D Y -->
<!-- DIVs declared below should be positioned based on flow -->


<!-- #CONTAINER sets the width for the site (100%) and contains all content -->
<div id="container">

<!-- #THESHOW is anchored where the parallax is best viewed -->
<!-- to style this div access styles/parallax.css -->
<div id="theshow"></div>

<!-- see scripts/parallax.js + styles/parallax.css -->
<div id="parallax-container"></div>

<!-- #THEWORK is for projects -->
<!-- it also defines the gap between work and the brand -->
<div class="v-sep" id="thework"> </div>

<!------ G E N E R A T E D --- B Y --- P H P ------>


END;


// begin #HEADER area

print "<div class=\"header-mainrow\" id=\"work-head\">";
    
    print "<h1>The Work</h1>";
    
print "</div>";
    
print "<div class=\"header-subrow\">";
    
    print "<div class=\"header-mcol\">";
        
        print "<div class=\"header-subhead\">";
            print "<p class=\"header-subhead-text\">HERE'S WHAT WE'VE BEEN UP TO</p>";
        print "</div>";
        
        print "<div class=\"header-subcol\">";
            print "<p>You're looking at a preview of some of the work that we &mdash; the graduating class of 2012 &mdash; think is worth showing off. Welcome to UW Design 2012.</p>";
        print "</div>";
        
    print "</div>";
    
    print "<div class=\"header-scol\">";
        
        print "<div class=\"header-subhead\">";
            print "<p class=\"header-subhead-text\">TOTAL PROJECTS</p>";
        print "</div>";
        
        print "<div class=\"header-subcol\">";
            print "<h3 style=\"margin:0px 0px 0px -4px;\">$wAmnt</h3>";
        print "</div>";
        
    print "</div>";
    
    print "<div class=\"header-lcol\">";
        
        print "<div class=\"header-subhead\">";
            print "<p class=\"header-subhead-text\">TOP PROJECT TAGS</p>";
        print "</div>";
        
        print "<div id=\"workstats-num\">";
            print "<p>";
            for($i=0; $i < $popTagsTotal; $i++){
                $end = $popTagsTotal - 1;
                print $popTagsVals[$i];
                if($i != $end){print "<BR>";}
            }
            print "</p>";
        print "</div>";
        
        print "<div id=\"workstats-name\">";
            print "<p>";
            for($i=0; $i < $popTagsTotal; $i++){
                $end = $popTagsTotal - 1;
                print "<a href=\"projects.php?k" .$popTagsKeysName[$i]. "\">" .$popTagsKeysName[$i]. "</a>";
                if($i != $end){print "<BR>";}
            }
            print "</p>";
        print "</div>";
        
        print "<div id=\"workstats-bars\">";
            print "<p>";
            for($i=0; $i < $popTagsTotal; $i++){
                $end = $popTagsTotal - 1;
                $calcWidth = $popTagsVals[$i] * 4.5;
                print "<div class=\"wbars\" id=\"wbar-$i\" style=\"width:" .$calcWidth. "px\"></div>";
                if($i != $end){print "<BR>";}
            }
            print "</p>";
        print "</div>";
        
    print "</div>";
    
print "</div>"; // end HEADER area


// masonry.js flows the children of #WORK-WRAPPER
print "<div id=\"work-wrapper\">";


// rearrange the array of consecutive integers
// use that array to retrieve elements by their array key
shuffle($p);

for($i=0; $i < $wAmnt; $i++){
    
    // grab a random project to display
    $projId = $p[$i];

    print "<div class='p-thumb' id=\"p-thumb" .$projId. "\" style=\"height:auto\">";
        
        print "<img src=\"" .$thumb[$projId]. "\" style=\"width:200px;height:" .$pHeight[$projId][1]. "px;\" />";
        
        // to allow for the border-bottom on hover
        $adj = $pHeight[$projId][1];
        
        print "<div class='p-thumb-over' style='height:" .$adj. "px;position:absolute;top:0px' onClick=\"window.location='projects.php?w" .$projId. "'\" onMouseOver=\"projTitleHover('p-title" .$projId. "')\" onMouseOut=\"projTitleLeave('p-title" .$projId. "')\"></div>";
        
        print "<p id=\"p-title" .$projId. "\" class=\"proj-title\">" .$title[$projId]. "</p><p class=\"proj-tags\">";
        
        for($j=0; $j<$tagAmnt[$projId]; $j++){
            print "<a href=\"projects.php?k" .$tag[$projId][$j]. "\">" .$tag[$projId][$j]. "</a>";
            if($j != ($tagAmnt[$projId]-1)){print ", ";}
        }
        
        print "</p>";
    
    print "</div>";
    
}
    
print <<<END


<!-- /div of the #WORK WRAPPER -->
</div>

<!-- #CAST contains the #cast anchor -->
<!-- it also defines the gap between the cast and the work -->
<div id="thecast"> </div>

<div id="cast-head">
    
    <div id="thecast-title">
        <h1>The Cast</h1>
    </div>
    
</div>

<div id="cast-container">


<!------ G E N E R A T E D --- B Y --- P H P ------>


END;


$myQuery = "SELECT * FROM PEOPLE_capstone";
$result = mysql_query($myQuery, $db) or die("Error: " .mysql_error());
$pAmnt = mysql_num_rows($result);


// variable declarations to be filled with the results from above

$fname    = array();
$lname    = array();
$major    = array();
$grad     = array();
$link     = array();
$tidbit   = array();
$projects = array(); // multi-dimensional (parse for commas)
$projAmnt = array();
$img1     = array();
$img2     = array();
$imgcover = array();
$imgcast  = array();

$x = 1; // used to increment when loading arrays

// grab all db data
while($all = mysql_fetch_array($result)){
    
    // simple arrays
    for($i=0; $i<$nFields; $i+=18){
        $fname[$x]    = $all[1];
        $lname[$x]    = $all[2];
        $major[$x]    = $all[3];
        $grad[$x]     = $all[4];
        $link[$x]     = $all[5];
        $tidbit[$x]   = $all[6];
        $projects[$x] = $all[7];
        $img1[$x]     = $all[8];
        $img2[$x]     = $all[9];
        $imgcover[$x] = $all[10];
        $imgcast[$x]  = $all[11];
        
        $x++; // inc
    }
}

for($i=1; $i<=$pAmnt; $i++){
    // parse the projects array items and separate them out
    $projects[$i] = explode(", ", $projects[$i]);
    // then apply them to sub-items in the array items
    $projAmnt[$i] = (count($projects[$i])-1); // count is 1 over, since there is a 0
}

$q = array();
for($i=1; $i<=53; $i++){
    $q[$i] = $i;
}
shuffle($q); // used to randomize student photos
$q[53] = $q[0];
unset($q[0]);

// create right-padding for the images (which all float left loosely)
print "<div id=\"cast-pad\"> </div>";

// print out the names to correspond to the images (printed below)
print "<div id=\"cast-names\">";
    
    print "<div class=\"cast-col1\" id=\"cast-id\">";
        
        print "<div class=\"cast-head\"><a href=\"projects.php?kID\" onMouseOver=\"lightPic('id');\" onMouseOut=\"darkPic()\">";
            print "<h3 id=\"id-head\">ID</h3></a>";
        print "</div>";
        
        print "<div class=\"cast-subhead\" id=\"id-subdiv\"><a href=\"projects.php?kID\" onMouseOver=\"lightPic('id');\" onMouseOut=\"darkPic()\">";
            print "<h5 id=\"id-subhead\">Industrial Design</h5></a>";
        print "</div>";
        
        print "<div class=\"name-col1\">";
            print "<p class=\"cast-names\">";
            for($i=21; $i<=31; $i++){
                print "<a href=\"projects.php?p" .$i. "\"><span id=\"cast-name-" .$i. "\" onMouseOver=\"lightPic('" .$i. "');\"  onMouseOut=\"darkPic()\" >" .$fname[$i]. " " .$lname[$i]. "</a></span>";
                if($i != 31){print "<br>";}
            }
            print "</p>";
        print "</div>";
        
    print "</div>";
    
    print "<div class=\"cast-col2\" id=\"cast-ixd\">";
    
        print "<div class=\"cast-head\"><a href=\"projects.php?kIXD\" onMouseOver=\"lightPic('ixd');\" onMouseOut=\"darkPic()\">";
            print "<h3 id=\"ixd-head\">IxD</h3></a>";
        print "</div>";
        
        print "<div class=\"cast-subhead\" id=\"ixd-subdiv\"><a href=\"projects.php?kIXD\" onMouseOver=\"lightPic('ixd');\" onMouseOut=\"darkPic()\">";
            print "<h5 id=\"ixd-subhead\">Interaction Design</h5></a>";
        print "</div>";
        
        print "<div class=\"name-col1\">";
            print "<p class=\"cast-names\">";
            for($i=32; $i<=42; $i++){
                print "<a href=\"projects.php?p" .$i. "\"><span id=\"cast-name-" .$i. "\" onMouseOver=\"lightPic('" .$i. "');\"  onMouseOut=\"darkPic()\" >" .$fname[$i]. " " .$lname[$i]. "</a></span><br>";
            }
            print "</p>";
        print "</div>";
        
        // new col after x lines
        print "<div class=\"name-col2\">";
            print "<p class=\"cast-names\">";
            for($i=43; $i<=47; $i++){
                print "<a href=\"projects.php?p" .$i. "\"><span id=\"cast-name-" .$i. "\" onMouseOver=\"lightPic('" .$i. "');\"  onMouseOut=\"darkPic()\" >" .$fname[$i]. " " .$lname[$i]. "</a></span>";
                if($i != 47){print "<br>";}
            }
            print "</p>";
        print "</div>";
        
    print "</div>";
    
    print "<div class=\"cast-col1\" id=\"cast-vcd\">";
    
        print "<div class=\"cast-head\"><a href=\"projects.php?kVCD\" onMouseOver=\"lightPic('vcd');\" onMouseOut=\"darkPic()\">";
            print "<h3 id=\"vcd-head\">VCD</h3></a>";
        print "</div>";
        
        print "<div class=\"cast-subhead\" id=\"vcd-subdiv\"><a href=\"projects.php?kVCD\" onMouseOver=\"lightPic('vcd');\" onMouseOut=\"darkPic()\">";
            print "<h5 id=\"vcd-subhead\">Visual Communication Design</h5></a>";
        print "</div>";
        
        print "<div class=\"name-col1\">";
            print "<p class=\"cast-names\">";
            for($i=1; $i<=10; $i++){
                print "<a href=\"projects.php?p" .$i. "\"><span id=\"cast-name-" .$i. "\" onMouseOver=\"lightPic('" .$i. "');\"  onMouseOut=\"darkPic()\" >" .$fname[$i]. " " .$lname[$i]. "</a></span><br>";
            }
            print "</p>";
        print "</div>";
        
        // new col after 10 lines
        print "<div class=\"name-col2\">";
            print "<p class=\"cast-names\">";
            for($i=11; $i<=20; $i++){
                print "<a href=\"projects.php?p" .$i. "\"><span id=\"cast-name-" .$i. "\" onMouseOver=\"lightPic('" .$i. "');\"  onMouseOut=\"darkPic()\" >" .$fname[$i]. " " .$lname[$i]. "</a></span>";
                if($i != 20){print "<br>";}
            }
            print "</p>";
        print "</div>";
        
    print "</div>"; // end of #CAST -VCD
    
    print "<div class=\"cast-col2\" id=\"cast-grad\">";
    
        print "<div class=\"cast-head\"><a href=\"projects.php?kGraduate\" onMouseOver=\"lightPic('grad');\" onMouseOut=\"darkPic()\">";
            print "<h3 id=\"grad-head\">M.Des</h3></a>";
        print "</div>";
        
        print "<div class=\"cast-subhead\" id=\"grad-subdiv\"><a href=\"projects.php?kMasters\" onMouseOver=\"lightPic('grad');\" onMouseOut=\"darkPic()\">";
            print "<h5 id=\"grad-subhead\">Master of Design</h5></a>";
        print "</div>";
        
        print "<div class=\"name-col1\">";
            print "<p class=\"cast-names\">";
            for($i=48; $i<=53; $i++){
                print "<a href=\"projects.php?p" .$i. "\"><span id=\"cast-name-" .$i. "\" onMouseOver=\"lightPic('" .$i. "');\" onMouseOut=\"darkPic()\">" .$fname[$i]. " " .$lname[$i]. "</a></span>";
                if($i != 53){print "<br>";}
            }
            print "</p>";
        print "</div>";
        
    print "</div>"; // end of #CAST-GRAD

print "</div>"; // end of #CAST-NAMES


// print out the images for each student
print "<div id=\"cast-images\">";
    for($i=1; $i<=53; $i++){
        print "<div class=\"cast-thumbs\">";
        print "<a href=\"projects.php?p" .$q[$i]. "\"><img src=\"people/" .$lname[$q[$i]]. "" .$fname[$q[$i]]. "-cast.png\"  onMouseOver=\"lightPic('" .$q[$i]. "');\"  onMouseOut=\"darkPic()\" alt=\"\" id=\"cast-thumb-" .$q[$i]. "\" class=\"castimg\"/></a>";
        print "</div>";
    }
print "</div>";

print "</div>"; // end #CAST CONTAINER


include "footer.html";

print <<<END




<!-- N O --- M A R K U P --- P A S T --- T H I S --- P O I N T -->

<div style="clear:both;"></div>
</div>


<!-- ADDITIONAL SCRIPTS -->

<script type="text/javascript" src="scripts/topnav_functions_index.js"></script>
<script type="text/javascript" src="scripts/parallax.js"></script>

<script type="text/javascript">
<!--

// grab the project thumbnails and applies the masonry.js column-flow and animation
$("document").ready(function() {
    $('#work-wrapper').masonry({
        itemSelector: '.p-thumb',
        columnWidth: 216,
        isAnimated: true,
        isFitWidth: true
    });
});


// when the user hovers #WORK the sub nav with keywords needs to appear
function showSubNav(){
    d = document.getElementById('subnav');
    d.style.display = "block";
}

function hideSubNav(){
    d = document.getElementById('subnav');
    d.style.display = "none";
}

-->
</script>


END;
include "doc_end.html";
?>