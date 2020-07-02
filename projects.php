<?php

require_once("dbauth/dbconnect.php");

// check the query string
$qs = $_SERVER["QUERY_STRING"];
$qsLength = strlen($qs);


// ------- G R A B --- C O N T E N T -------- //

// based on the query string, set variables
// from information in the database

$studId = ""; // if this never gets set, read as 'empty'

if($qs != ""){
    
    $ch1 = substr($qs,0,1); // first character
    $ch2plus = substr($qs,1,$qsLength); // subsequent characters
    
    if($ch1 == "k"){
        
        $sTerm = $ch2plus; // store the keyword as $sTerm
        
        // ------- K E Y W O R D --- E N T E R E D ------- //
        
        // if the keyword is a major, we'll include a description in the #RELATED HEAD
        if($sTerm == "ID"){
            $majorDesc = "Makes innovative concepts tangible in the form of products. These take the form of tools, environments or services that are meaningful and useful for society. Observation skills, technical knowledge, and human factors principles all form part of a rich and systematic design process.";
        } elseif($sTerm == "IXD"){
            $majorDesc = "Shapes the relationships between people, artifacts, and environments. We explore how people extract meaning from the world around us and turn understanding into interactions.";
        } elseif($sTerm == "VCD"){
            $majorDesc = "Educates and trains designers for the communication needs of industry and society. Students integrate methodology, aesthetics, technology, materials and audience to develop strategies and solutions. These take the form of print, screen and the built environment.";
        } elseif($sTerm == "Graduate"){
            $majorDesc = "Program is a two-year course leading to a masters degree in industrial design, visual communication design and interaction design. In a cross-disciplinary environment students develop their conceptual skills, experimenting with media and conducting personal design investigation on an advanced level.";
        } elseif($sTerm == "Branding"){
            $majorDesc = "Investigates conceptual and formal themes that arc across brand systems. Through a holistic approach, these projects demonstrate systematic methods that solidify and communicate an identity.";
        } elseif($sTerm == "Consumer"){
            $majorDesc = "Concerns the design of products with specific attention to the application of human factors, appropriate materials, and manufacturing techniques.";
        } elseif($sTerm == "Environment"){
            $majorDesc = "Specifically emphasizes the relationship of the product and/or system as well as the surrounding environment or location, and those that occupy this space.";
        } elseif($sTerm == "Information"){
            $majorDesc = "Utilizes visualization approaches and techniques that expose patterns and relationships within data, which may take form as an open dialog or editorial narrative.";
        } elseif($sTerm == "Interactive"){
            $majorDesc = "Especially takes into consideration the relationship that individuals, systems and artifacts have with each other within a given design concept.";
        } elseif($sTerm == "Medical"){
            $majorDesc = "Considers the special requirements of design in Medicine and Science, which include varying demographics, high understandability, ease of use, and a clean aesthetic.";
        } elseif($sTerm == "Mobile"){
            $majorDesc = "Involves the new and future possibilities or problems that come with mobilized computing systems, such as the presence of geographic information and unpredictable situational context in which the product and/or system may be used.";
        } elseif($sTerm == "Motion"){
            $majorDesc = "Incorporates traditional and new methods of design with the added dimension of time. Takes form through graphic animations and film, or a combination thereof.";
        } elseif($sTerm == "Print"){
            $majorDesc = "Deals with the design process for tangible communication materials.";// This includes presentation, location or context, materials, appropriate communication, and methods of distribution.";
        } elseif($sTerm == "Publication"){
            $majorDesc = "Exploration in developing powerful storytelling that addresses a specific audience through integrating typography and image, with pacing and curation of content.";
        } elseif($sTerm == "Sustainable"){
            $majorDesc = "Design with special attention to what makes an efficient, responsible, and lasting product without sacrificing quality, interest or desirability. Especially takes into consideration locality and availability of materials or services.";
        } elseif($sTerm == "Systems"){
            $majorDesc = "Concerned with the relationships and cultural implications of products and services rather than a summary of their individual components.";
        } elseif($sTerm == "Web"){
            $majorDesc = "Dealing with how content can be displayed or manipulated on an internet browser, especially considering the unpredictable nature of how that content may be interacted with or displayed (varying dimensions, touch-based browsing, etc.)";
        } else {
            $majorDesc = "";
        }
        
    } else if($ch1 == "w"){
        
        $que = "SELECT * FROM PROJECTS_capstone WHERE id='$ch2plus'";
        $res = mysql_query($que, $db) or die("Error: " .mysql_error());
        $groupInfo = mysql_fetch_array($res);
        
        $owner = $groupInfo[9]; // access owner field of PROJECTS_capstone db and store
        
        if($owner == "group"){
            
            // ------- G R O U P --- P R O J E C T ------- //
            
            
            $isGroup = 1;
            
            // project details
            $title  = $groupInfo[1]; // these are all arrays
            $tag    = $groupInfo[2];
            $desc   = $groupInfo[3];
            $video  = $groupInfo[4];
            $link1  = $groupInfo[5];
            $link1n = $groupInfo[6];
            $link2  = $groupInfo[7];
            $link2n = $groupInfo[8];
            $owner  = $groupInfo[9];
            $team   = $groupInfo[10];
            $oc     = $groupInfo[11];
            $misc   = $groupInfo[12];
            $img1   = $groupInfo[13]; 
            $img2   = $groupInfo[14];
            $img3   = $groupInfo[15];
            $img4   = $groupInfo[16];
            
            
            
            $tag = explode(", ", $tag);
            $tagAmnt = (count($tag));
            
            $team = explode(", ", $team);
            $teamAmnt = (count($team));
            
            for($j=0; $j < $teamAmnt; $j++){
                
                // get the names instead of IDs
                $v = $team[$j];
                $que = "SELECT * FROM PEOPLE_capstone WHERE id='$v'";
                $res = mysql_query($que, $db);
                $teamName[$j] = mysql_fetch_array($res);
                
                $teamfn[$j] = $teamName[$j][1];
                $teamln[$j] = $teamName[$j][2];
            }
            
            if($oc !== ""){
                $oc = explode(", ", $oc);
                $ocAmnt = (count($oc));
            }
            
            $image = array();
            if($img1 != ""){$image[1] = $img1;} // fill array (if and only if)
            if($img2 != ""){$image[2] = $img2;}
            if($img3 != ""){$image[3] = $img3;}
            if($img4 != ""){$image[4] = $img4;}
            
            $imgAmnt = count($image); // count each array and store for later
            
        } else {
            
            // ------- S O L O --- P R O J E C T ------- //
            
            
            $isGroup = 0;
            
            $que = "SELECT * FROM PEOPLE_capstone WHERE id='$owner'";
            $res = mysql_query($que, $db) or die("Error: " .mysql_error());
            $personInfo = mysql_fetch_array($res);
            
            // name fields + combined
            $fname = $personInfo[1];
            $lname = $personInfo[2];
            $studname = "$fname $lname";
            
            // student info
            $studId = $personInfo[0];
            $studBlrb = $personInfo[6];
            $studLink = $personInfo[5];
            $studMajor = $personInfo[3];
            $isGrad = $personInfo[4];
            
            // student images
            $tinyImg1 = "people/" .$lname. "" .$fname. "-1.gif";
            $tinyImg2 = "people/" .$lname. "" .$fname. "-2.gif";
            $coverImg = "people/" .$lname. "" .$fname. "-cover.jpg";
            
            if($studname == "Nicholas Smith"){
                $fname = "Nicholas St.";
                $lname = "Clair Smith";
            } elseif($studname == "Cierra Gonzales") {
                $fname = "Cierra Jade";
            } elseif($studname == "Daniya Ulgen") {
                $lname = "&Uuml;lgen";
            } elseif($studname == "Amber Joehnk") {
                $lname = "J&oslash;hnk";
            }
            
            // projects
            $projects = $personInfo[7];
            $projects = explode(", ", $projects);
            $projAmnt = count($projects); // max 4
            
            for($i=0; $i < $projAmnt; $i++){
                if($projects[$i] == $ch2plus){
                    $projOrderedID = $i;
                }
            }
            
            $image  = array(); // compile img 1 - 4
            
            // project info
            for($i=0; $i < $projAmnt; $i++){
                
                $que = "SELECT * FROM PROJECTS_capstone WHERE id='$projects[$i]'";
                $res = mysql_query($que, $db) or die("Error: " .mysql_error());
                $pInfo[$i] = mysql_fetch_array($res);
                
                $title[$i]  = $pInfo[$i][1]; // these are all arrays
                $tag[$i]    = $pInfo[$i][2];
                $desc[$i]   = $pInfo[$i][3];
                $video[$i]  = $pInfo[$i][4];
                $link1[$i]  = $pInfo[$i][5];
                $link1n[$i] = $pInfo[$i][6];
                $link2[$i]  = $pInfo[$i][7];
                $link2n[$i] = $pInfo[$i][8];
                $owner[$i]  = $pInfo[$i][9];
                $team[$i]   = $pInfo[$i][10];
                $oc[$i]     = $pInfo[$i][11];
                $misc[$i]   = $pInfo[$i][12];
                $img1[$i]   = $pInfo[$i][13]; 
                $img2[$i]   = $pInfo[$i][14];
                $img3[$i]   = $pInfo[$i][15];
                $img4[$i]   = $pInfo[$i][16];
                
                $tag[$i] = explode(", ", $tag[$i]);
                $tagAmnt[$i] = (count($tag[$i]));
                
                $team[$i] = explode(", ", $team[$i]);
                $teamAmnt[$i] = (count($team[$i]));
                
                for($j=0; $j < $teamAmnt[$i]; $j++){
                    
                    $v = $team[$i][$j];
                    $que = "SELECT * FROM PEOPLE_capstone WHERE id='$v'";
                    $res = mysql_query($que, $db);
                    $teamName[$i][$j] = mysql_fetch_array($res);
                    
                    $teamfn[$i][$j] = $teamName[$i][$j][1];
                    $teamln[$i][$j] = $teamName[$i][$j][2];
                    
                }
                
                if($oc[$i] != ""){
                    $oc[$i] = explode(", ", $oc[$i]);
                    $ocAmnt[$i] = (count($oc[$i]));
                }
                
            }
            
            for($i=0; $i < $projAmnt; $i++){
                $image[$i] = array();
                if($img1[$i] != ""){$image[$i][1] = $img1[$i];} // fill array (if and only if)
                if($img2[$i] != ""){$image[$i][2] = $img2[$i];}
                if($img3[$i] != ""){$image[$i][3] = $img3[$i];}
                if($img4[$i] != ""){$image[$i][4] = $img4[$i];}
                
                $imgAmnt[$i] = count($image[$i]); // count each array and store for later
            }
            
        }
        
        // end of group project variable declaration
        
        
    } else if($ch1 == "p"){
        
        $que = "SELECT * FROM PEOPLE_capstone WHERE id='$ch2plus'";
        $res = mysql_query($que, $db) or die("Error: " .mysql_error());
        $personInfo = mysql_fetch_array($res);
        
        // name fields + combined
        $fname = $personInfo[1];
        $lname = $personInfo[2];
        $studname = "$fname $lname";
        
        // student info
        $studId = $personInfo[0];
        $studBlrb = $personInfo[6];
        $studLink = $personInfo[5];
        $studMajor = $personInfo[3];
        $isGrad = $personInfo[4];
        
        // student images
        $tinyImg1 = "people/" .$lname. "" .$fname. "-1.gif";
        $tinyImg2 = "people/" .$lname. "" .$fname. "-2.gif";
        $coverImg = "people/" .$lname. "" .$fname. "-cover.jpg";
        
        if($studname == "Nicholas Smith"){
            $fname = "Nicholas St.";
            $lname = "Clair Smith";
        } elseif($studname == "Cierra Gonzales") {
            $fname = "Cierra Jade";
        } elseif($studname == "Daniya Ulgen") {
            $lname = "&Uuml;lgen";
        } elseif($studname == "Amber Joehnk") {
            $lname = "J&oslash;hnk";
        }
        
        // projects
        $projects = $personInfo[7];
        $projects = explode(", ", $projects);
        $projAmnt = count($projects); // max 4
        
        $image  = array(); // compile img 1 - 4
        
        // project info
        for($i=0; $i < $projAmnt; $i++){
            
            $que = "SELECT * FROM PROJECTS_capstone WHERE id='$projects[$i]'";
            $res = mysql_query($que, $db) or die("Error: " .mysql_error());
            $pInfo[$i] = mysql_fetch_array($res);
            
            $title[$i]  = $pInfo[$i][1]; // these are all arrays
            $tag[$i]    = $pInfo[$i][2];
            $desc[$i]   = $pInfo[$i][3];
            $video[$i]  = $pInfo[$i][4];
            $link1[$i]  = $pInfo[$i][5];
            $link1n[$i] = $pInfo[$i][6];
            $link2[$i]  = $pInfo[$i][7];
            $link2n[$i] = $pInfo[$i][8];
            $owner[$i]  = $pInfo[$i][9];
            $team[$i]   = $pInfo[$i][10];
            $oc[$i]     = $pInfo[$i][11];
            $misc[$i]   = $pInfo[$i][12];
            $img1[$i]   = $pInfo[$i][13]; 
            $img2[$i]   = $pInfo[$i][14];
            $img3[$i]   = $pInfo[$i][15];
            $img4[$i]   = $pInfo[$i][16];
            
            $tag[$i] = explode(", ", $tag[$i]);
            $tagAmnt[$i] = (count($tag[$i]));
            
            $team[$i] = explode(", ", $team[$i]);
            $teamAmnt[$i] = (count($team[$i]));
            
            for($j=0; $j < $teamAmnt[$i]; $j++){
                
                $v = $team[$i][$j];
                $que = "SELECT * FROM PEOPLE_capstone WHERE id='$v'";
                $res = mysql_query($que, $db);
                $teamName[$i][$j] = mysql_fetch_array($res);
                
                $teamfn[$i][$j] = $teamName[$i][$j][1];
                $teamln[$i][$j] = $teamName[$i][$j][2];
                
            }
            
            if($oc[$i] != ""){
                $oc[$i] = explode(", ", $oc[$i]);
                $ocAmnt[$i] = (count($oc[$i]));
            }
            
        }
        
        for($i=0; $i < $projAmnt; $i++){
            $image[$i] = array();
            if($img1[$i] != ""){$image[$i][1] = $img1[$i];} // fill array (if and only if)
            if($img2[$i] != ""){$image[$i][2] = $img2[$i];}
            if($img3[$i] != ""){$image[$i][3] = $img3[$i];}
            if($img4[$i] != ""){$image[$i][4] = $img4[$i];}
            
            $imgAmnt[$i] = count($image[$i]); // count each array and store for later
        }
        
        
    } else {
        
        // weird query string
        // do nothing?
        // display random projects?
        
    }
    
} else {
    
    $ch1 = "";
    
}

$que = "SELECT * FROM PROJECTS_capstone";
$res = mysql_query($que, $db) or die("Error: " .mysql_error());
$pTotal = mysql_num_rows($res); // the number of total projects that we have

// random project to be chosen when the "random project" is selected
$randProjId = rand(1,$pTotal);


include "doc_setup.html";   // doctype, title, metadata, external links, etc.

print <<<END

<!-- page-specific stylesheets and scripts -->
<link rel="stylesheet" type="text/css" href="styles/projects.css">
<link rel="stylesheet" type="text/css" href="styles/hoverscroll.css">


<!-- #HEADER provides the nav -->
<!-- functions are controlled via scripts/topnav_functions_index.js -->
<div id="header">
    <div id="nav-show" class="nav-btn" style="margin:0px 0px 0px 18px;" onMouseOver="hideSubNav();" onClick="window.location='index.php#top'"><p class="nav-btn-link">The Show</p></div>
    <div id="nav-work" class="nav-btn" onMouseOver="showSubNav()" onMouseDown="hideSubNav();" onClick="window.location='index.php#thework'"><p class="nav-btn-link">The Work</p></div>
    <div id="nav-cast" class="nav-btn" onMouseOver="hideSubNav();" onClick="window.location='index.php#thecast'"><p class="nav-btn-link">The Cast</p></div>
    <div id="nav-random" class="nav-btn" onClick="window.location='projects.php?w$randProjId'"><p class="nav-btn-link">Surprise Me</p></div>
    <div id="nav-right"><p>UW DESIGN SHOW 2012</p></div>
</div>


END;

// SUBNAV
include "subnav.html";


// #LOADING SCREEN prevents content from being viewed while it is still rendering
print "<div id=\"loading-screen\">";
    print "<img src=\"images/loading_notxt.gif\" id=\"loading-img\" alt=\"loading\" />";
print "</div>";


print "</head>";
if($studId != ""){
    print "<body onMouseDown=\"everyDn('" .$studId. "');\" onMouseUp=\"everyUp('" .$studId. "');\">";
} else {
    print "<body>";
}


// ------ P R I N T --- C O N T E N T ------- //

// ------------ P E R S O N A V ------------- //

// create the personav only in the case that a project (non-group) or person was queried
if(($ch1 == "w" || $ch1 == "p") && $isGroup != 1){
        
    print "<div id=\"personav\">";
        
        print "<div class=\"personav-content\" id=\"personav-name\">";
            print "<h3 class=\"personav-subcontent\">$fname<br>$lname</h3>";
        print "</div>";
        
        print "<div class=\"personav-content\" id=\"personav-img\">";
            print "<img src=\"" .$tinyImg1. "\" id=\"tiny-img\" />";
        print "</div>";
        
        print "<div class=\"personav-content\" id=\"personav-major\">";
            print "<div class=\"personav-subcontent\">";
                print "<h3>$studMajor</h3>";
                if($isGrad == 1){
                    print "<h6 style=\"color:#CDCFD0;\">MASTER</h6>";
                } else {
                    print "<h6 style=\"color:#CDCFD0;\">BACHELOR</h6>";
                }
            print "</div>";
        print "</div>";
        
        print "<div class=\"personav-content\" id=\"personav-link\">";
            print "<div class=\"personav-subcontent\">";
                print "<a href=\"$studLink\" target=\"_blank\" onMouseOver=\"document.getElementById('vp-graphic').style.padding='0px 0px 0px 10px'\" onMouseOut=\"document.getElementById('vp-graphic').style.padding='0px'\"><img src=\"images/viewportfolio.png\" id=\"vp-graphic\" style=\"margin:0px 0px -1px 0px;padding:0px;\" />";
                print "<h6 style=\"color:#CDCFD0;\">VIEW PORTFOLIO</h6></a>";
            print "</div>";
        print "</div>";
        
    print "</div>";
    
    print "<div id=\"cover\" style=\"
background:#ffffff url('" .$coverImg. "') no-repeat;\">";
        
        print "<div id=\"blurb\">";
            print "<h4 style=\"line-height:28px;\">$studBlrb</h4>";
        print "</div>";
    
    print "</div>";
    
}


print <<<END

<!-- DIVs declared up here should be positioned absolute or fixed -->
<!-- do not add divs to the flow until after the -->
<!-- B O D Y -->
<!-- comment -->


<!-- #THETOP is the anchor that resets all of the tabs in the nav -->
<!-- nothing links to it... -->
<div id="thetop" style="position:absolute;top:0px;left:0px;"></div>


<!-- B O D Y -->
<!-- DIVs declared below should be positioned relative and float left -->
    

<!-- #CONTAINER sets the width for the site (100%) and contains all content -->
<div id="container">


<!------ G E N E R A T E D --- B Y --- P H P ------>


END;


// -------- P R O J E C T --- D O C --------- //

// only if it's work or person queried
if($ch1 == "w" || $ch1 == "p"){
    
    // group projects look different
    // (most of the variables are strings instead of arrays)
    if($isGroup == 1){
        
        // all instances of $i refer to the project number (1st, 2nd..)
        // #PROJECT-DOC shows the information about each project
        print "<div class=\"project-gdoc\" id=\"project-0\">";
        
        print "<div class=\"anchors\" id=\"anchor0\"> </div>";
        
        // container for all project info
        print "<div class=\"p-info\">";
            
            // COL1 -- title
            print "<div class=\"p-info-col\">";
                print "<div class=\"p-title\">"; 
                print "<h2>" .$title. "</h2>";
                print "</div>";
            print "</div>";
            
            // COL2 -- desc / misc
            print "<div class=\"p-info-col\">";
                if($desc != ""){
                    print "<div class=\"p-desc\">";
                    print "<p style=\"margin:0px;\">" .$desc. "</p>";
                    print "</div>";
                }
                
                if($misc != ""){
                    print "<div class=\"p-misc\">";
                    print "<p style=\"margin:0px;\">" .$misc. "</p>";
                    print "</div>";
                }
            print "</div>";
                
            // COL3 -- team / oc
            print "<div class=\"p-info-col\">";
                if($team[1] != ""){
                    print "<div class=\"p-team\">";
                    print "<h6 style=\"margin:0px;\">THE GROUP:</h6>";
                    print "<p style=\"margin:0px;\">";
                    for($l=0; $l <= $teamAmnt; $l++){
                        print "<a href=\"?p" .$team[$l]. "\">" .$teamfn[$l]. " " .$teamln[$l]. "</a>";
                        if($l != $teamAmnt){
                            print "<br>";
                        }
                    };
                    print "</p>";
                    print "</div>";
                }
                
                if($ocAmnt > 0){
                    print "<div class=\"p-oc\">";
                    print "<h6 style=\"margin:0px;\">OTHER COLLABORATORS:</h6>";
                    print "<p style=\"margin:0px;\">";
                    for($l=0; $l < $ocAmnt; $l++){
                        print $oc[$l];
                        if($l != $ocAmnt){
                            print "<br>";
                        }
                    };
                    print "</p>";
                    print "</div>";
                }
            print "</div>";
            
            // COL4 -- tags / links
            print "<div class=\"p-info-col\">";
                print "<div class=\"p-tags\">";
                print "<h6 style=\"margin:0px;\">TAGS:</h6>";
                print "<p style=\"margin:0px;\">";
                for($k=0; $k < $tagAmnt; $k++){
                    print "<a href=\"?k" .$tag[$k]. "\">" .$tag[$k]. "</a>";
                    if($k != ($tagAmnt-1)){
                        print ", ";
                    }
                };
                print "</p>";
                print "</div>";
                
                if($link1 != ""){
                    print "<div class=\"p-links\">";
                    print "<h6 style=\"margin:0px;\">ADDITIONAL LINKS:</h6>";
                    print "<p style=\"margin:0px;\">";
                    print "<a href=\"" .$link1. "\" target=\"_blank\">" .$link1n. "</a>";
                    if($link2 != ""){
                        print "<br><a href=\"" .$link2. "\" target=\"_blank\">" .$link2n. "</a>";
                    }
                    print "</p>";
                    print "</div>";
                }
            print "</div>";
            
        print "</div>"; // end of #P-INFO
        
        
        // .HOVERSCROLL-CONTAINER contains the unordered list
        print "<div class=\"hoverscroll-container\">";
        
        // .MY-LIST-$i has hoverscroll.js and hoverscroll.css applied
        print "<ul id=\"my-list-0\">";
        
        if($video != ""){
            print "<li style=\"width:818;height:460px;\"><iframe src=\"http://player.vimeo.com/video/" .$video. "\" width=\"818\" height=\"460\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></li>";
        }
        
        for($j=1; $j <= $imgAmnt; $j++){
            print "<li style=\"width:auto;height:460px;\"><img src=\"student_work/" .$image[$j]. "\" /></li>";
        };
        
        print "</ul>";
        print "</div>";
        
        print "</div>"; // end of #PROJECT-DOC
                        // for GROUP PROJECTS_capstone
        
        
    } else {
    
        // reference the information from the head and print out the project documentation
        for($i = 0; $i < $projAmnt; $i++){
            
            
            // all instances of $i refer to the project number (1st, 2nd..)
            // #PROJECT-DOC shows the information about each project
            print "<div class=\"project-doc\" id=\"project-" .$i. "\">";
            
            print "<div class=\"anchors\" id=\"anchor" .$i. "\"> </div>";
            
            // container for all project info
            print "<div class=\"p-info\">";
                
                // COL1 -- title
                print "<div class=\"p-info-col\">";
                    print "<div class=\"p-title\">"; 
                    print "<h2>" .$title[$i]. "</h2>";
                    print "</div>";
                print "</div>";
                
                // COL2 -- desc / misc
                print "<div class=\"p-info-col\">";
                    if($desc[$i] != ""){
                        print "<div class=\"p-desc\">";
                        print "<p style=\"margin:0px;\">" .$desc[$i]. "</p>";
                        print "</div>";
                    }
                    
                    if($misc[$i] != ""){
                        print "<div class=\"p-misc\">";
                        print "<p style=\"margin:0px;\">" .$misc[$i]. "</p>";
                        print "</div>";
                    }
                print "</div>";
                    
                // COL3 -- team / oc
                print "<div class=\"p-info-col\">";
                    if($team[$i][1] != ""){
                        print "<div class=\"p-team\">";
                        print "<h6 style=\"margin:0px;\">THE GROUP:</h6>";
                        print "<p style=\"margin:0px;\">";
                        for($l=0; $l <= $teamAmnt[$i]; $l++){
                            print "<a href=\"?p" .$team[$i][$l]. "\">" .$teamfn[$i][$l]. " " .$teamln[$i][$l]. "</a>";
                            if($l != $teamAmnt[$i]){
                                print "<br>";
                            }
                        };
                        print "</p>";
                        print "</div>";
                    }
                    
                    
                    if($ocAmnt[$i] != ""){
                        print "<div class=\"p-oc\">";
                        print "<h6 style=\"margin:0px;\">OTHER COLLABORATORS:</h6>";
                        print "<p style=\"margin:0px;\">";
                        for($l=0; $l < $ocAmnt[$i]; $l++){
                            print $oc[$i][$l];
                            if($l != $ocAmnt[$i]){
                                print "<br>";
                            }
                        };
                        print "</p>";
                        print "</div>";
                    }
                print "</div>";
                
                // COL4 -- tags / links
                print "<div class=\"p-info-col\">";
                    print "<div class=\"p-tags\">";
                    print "<h6 style=\"margin:0px;\">TAGS:</h6>";
                    print "<p style=\"margin:0px;\">";
                    for($k=0; $k < $tagAmnt[$i]; $k++){
                        print "<a href=\"?k" .$tag[$i][$k]. "\">" .$tag[$i][$k]. "</a>";
                        if($k != ($tagAmnt[$i]-1)){
                            print ", ";
                        }
                    };
                    print "</p>";
                    print "</div>";
                    
                    if($link1[$i] != ""){
                        print "<div class=\"p-links\">";
                        print "<h6 style=\"margin:0px;\">ADDITIONAL LINKS:</h6>";
                        print "<p style=\"margin:0px;\">";
                        print "<a href=\"" .$link1[$i]. "\" target=\"_blank\">" .$link1n[$i]. "</a>";
                        if($link2[$i] != ""){
                            print "<br><a href=\"" .$link2[$i]. "\" target=\"_blank\">" .$link2n[$i]. "</a>";
                        }
                        print "</p>";
                        print "</div>";
                    }
                print "</div>";
                
            print "</div>"; // end of #P-INFO
            
            
            // .HOVERSCROLL-CONTAINER contains the unordered list
            print "<div class=\"hoverscroll-container\">";
            
            // .MY-LIST-$i has hoverscroll.js and hoverscroll.css applied
            print "<ul id=\"my-list-" .$i. "\">";
            
            if($video[$i] != ""){
                print "<li style=\"width:818;height:460px;\"><iframe src=\"http://player.vimeo.com/video/" .$video[$i]. "\" width=\"818\" height=\"460\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></li>";
            }
            
            for($j=1; $j <= $imgAmnt[$i]; $j++){
                print "<li style=\"width:auto;height:460px;\"><img src=\"student_work/" .$image[$i][$j]. "\" /></li>";
            };
            
            print "</ul>";
            print "</div>";
            
            print "</div>"; // end of #PROJECT-DOC
            
        }
    
    }
    
}


// -------- R E L A T E D --- W O R K --------- //
//
//                        or
//
// ------- K E Y W O R D --- S E A R C H ------ //

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


// check the query string again
// to set some variables

if($ch1 != ""){
    
    if($ch1 == "k"){
        
        $que = "SELECT id FROM PROJECTS_capstone WHERE tags LIKE '%$ch2plus%'";
        $res = mysql_query($que, $db) or die("Error: " .mysql_error());
        $newAmnt = mysql_num_rows($res); // number of results
        
        for($i=0; $i<$newAmnt; $i++){
            $thumbIDs[$i] = mysql_fetch_array($res);
            $thumbIDs[$i] = $thumbIDs[$i][0];
        }
        $thumbAmnt = count($thumbIDs);
        
        if($ch2plus == "Consumer"){
            $sTerm = "Consumer Product";
        } elseif($ch2plus == "Information") {
            $sTerm = "Information Visualization";
        } elseif($ch2plus == "Medical") {
            $sTerm = "Medical";
        } elseif($ch2plus == "Web") {
            $sTerm = "Web Design";
        }
        
    } elseif($ch1 == "w" || $ch1 == "p"){
        
        if($ch1 == "w"){
            
            $que = "SELECT tags FROM PROJECTS_capstone WHERE id='$ch2plus'";
            
        } elseif($ch1 == "p"){
            
            $v = $projects[0];
            $que = "SELECT tags FROM PROJECTS_capstone WHERE id='$v'";
            
        }
            
        $sTerm = "Related";
        $res = mysql_query($que, $db) or die("Error: " .mysql_error());
        $workAmnt = mysql_num_rows($res);
        $workTags = mysql_fetch_array($res);
        
        $newtag = explode(", ", $workTags[0]);
        
        $glue = implode("%' OR tags LIKE '%", $newtag);
        
        $que = "SELECT id FROM PROJECTS_capstone WHERE (tags LIKE '%$glue%') AND NOT id='$ch2plus'";
        $res = mysql_query($que, $db) or die("Error: " .mysql_error());
        $newAmnt = mysql_num_rows($res); // number of results
        
        for($i=0; $i<$workAmnt; $i++){
            
            for($j=0; $j<$newAmnt; $j++){
                $thumbGrabber = mysql_fetch_array($res);
                $thumbIDs[$j] = $thumbGrabber[0];
            }
            
        }
        
        $thumbAmnt = count($thumbIDs);
        
    } else {
        
        $sTerm = "Some Random";
        
        $s = array();
        for($h=1; $h<=$pTotal; $h++){
            $s[$h] = $h;
        }
        shuffle($s);
        
        $thumbAmnt = 40;
        for($i=0; $i<$thumbAmnt; $i++){
            $thumbIDs[$i] = $s[$i];
        }
        
    }
    
}


//                                                  //
// ------- THUMBS AT THE BOTTOM OF THE PAGE ------- //
//                                                  //

// requires:
//
// $thumbIDs[i] --> where each val is a project ID (string) or (int)
// $thumbAmnt   --> the number of IDs in this array

// grab the information from the database (titles / tags / thumbs)
for($i=0; $i < $thumbAmnt; $i++){
    
    //var_dump($thumbIDs[$i]);
    
    $curID = $thumbIDs[$i];
    
    $que = "SELECT * FROM PROJECTS_capstone WHERE id='$curID'";
    $res = mysql_query($que, $db) or die("Error: " .mysql_error());
    $all = mysql_fetch_array($res);
    
    $thtitle[$curID] = $all[1];
    $thtag[$curID]   = $all[2];
    $ththumb[$curID] = "student_work/" .$all[17];
    
    $thtag[$curID] = explode(", ", $thtag[$curID]);
    $thtagAmnt[$curID] = (count($thtag[$curID]));
    
    // increment the tags values
    for($j=0; $j<$thtagAmnt[$curID]; $j++){
        $curtag = $thtag[$curID][$j];
        
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




// ------ P R I N T --- S T A T S ------ //


// begin #HEADER area

print "<div class=\"header-mainrow-proj\">";
    
    print "<h1>$sTerm Projects</h1>";
    
print "</div>";
    
print "<div class=\"header-subrow\">";
    
    if($majorDesc != ""){
        print "<div class=\"header-mcol\">";
            
            print "<div class=\"header-subhead\">";
                print "<p class=\"header-subhead-text\">ABOUT</p>";
            print "</div>";
            
            print "<div class=\"header-subcol\">";
                print "<p>$majorDesc</p>";
            print "</div>";
            
        print "</div>";
    }
    
    print "<div class=\"header-scol\">";
        
        print "<div class=\"header-subhead\">";
            print "<p class=\"header-subhead-text\">TOTAL PROJECTS</p>";
        print "</div>";
        
        print "<div class=\"header-subcol\">";
            print "<h3 style=\"margin:0px 0px 0px -4px;\">$thumbAmnt</h3>";
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


// ------ T H U M B --- W R A P P E R ------ // 

print "<div id=\"thumb-wrapper\">";

// array of integers
// fill this with the ids of the projects that came up as a result of the query
$p = array();
for($i=0; $i<$thumbAmnt; $i++){
    $p[$i] = $thumbIDs[$i];
}

// array of the heights of the thumbnails
$pHeight = array();
for($i=0; $i<$thumbAmnt; $i++){
    $imgUrl = $ththumb[$thumbIDs[$i]];
    $pHeight[$thumbIDs[$i]] = getimagesize($imgUrl);
}

// rearrange the array of consecutive integers
// use that array to retrieve elements by their array key
shuffle($p);


// ------- P R I N T --- T H U M B S ------- //

for($i=0; $i < $thumbAmnt; $i++){
    
    // grab a random project to display
    $projId = $p[$i];
    
    print "<div class='p-thumb' id=\"p-thumb" .$projId. "\" style=\"height:auto\">";
        
        print "<img src=\"" .$ththumb[$projId]. "\" style=\"width:200px;height:" .$pHeight[$projId][1]. "px;\" />";
        
        // to allow for the border-bottom on hover
        $adj = $pHeight[$projId][1];
        
        print "<div class='p-thumb-over' style='height:" .$adj. "px;position:absolute;top:0px' onClick=\"window.location='projects.php?w" .$projId. "'\" onMouseOver=\"projTitleHover('p-title" .$projId. "')\" onMouseOut=\"projTitleLeave('p-title" .$projId. "')\"></div>";
        
        print "<p id=\"p-title" .$projId. "\" class=\"proj-title\">" .$thtitle[$projId]. "</p><p class=\"proj-tags\">";
        
        for($j=0; $j<$thtagAmnt[$projId]; $j++){
            print "<a href=\"projects.php?k" .$thtag[$projId][$j]. "\">" .$thtag[$projId][$j]. "</a>";
            if($j != ($thtagAmnt[$projId]-1)){print ", ";}
        }
        
        print "</p>";
    
    print "</div>";
    
}

print "</div>"; // end of #THUMB-WRAPPER



include "footer.html";

print <<<END


<!-- N O --- M A R K U P --- P A S T --- H E R E -->

<div style="clear:both;"></div>
</div>


<!-- ADDITIONAL SCRIPTS -->

<script type="text/javascript" src="scripts/hoverscroll.js"></script>
<script type="text/javascript" src="scripts/topnav_functions_other.js"></script>
<script type="text/javascript" src="scripts/parallax.js"></script>

<script type="text/javascript">
<!--

// for when the user clicks on a project
// this logic figures out which project on the page to take them to
function gotoProject(id){
    window.location = '#anchor' +id;
}

// when the document is loaded (does not include images)
$("document").ready(function() {

    $('#my-list-0').imagesLoaded( function(){
        $('#my-list-0').hoverscroll({});
    });
        
    $('#my-list-1').imagesLoaded( function(){
        $('#my-list-1').hoverscroll({});
    });
    
    $('#my-list-2').imagesLoaded( function(){
        $('#my-list-2').hoverscroll({});
    });
    
    $('#my-list-3').imagesLoaded( function(){
        $('#my-list-3').hoverscroll({});
    });
    
    $('#my-list-4').imagesLoaded( function(){
        $('#my-list-4').hoverscroll({});
    });

    // grab the project thumbnails and applies the masonry.js column-flow and animation
    $('#thumb-wrapper').masonry({
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


// when the user hovers over a thumb, change the title pink (and reverse)
function projTitleHover(elem){
    d = document.getElementById(elem);
    d.style.color = "#FC265D";
}

function projTitleLeave(elem){
    d = document.getElementById(elem);
    d.style.color = "#000000";
}

function everyDn(){
    d = document.getElementById('tiny-img');
    d.src = "$tinyImg2";
}

function everyUp(){
    d = document.getElementById('tiny-img');
    d.src = "$tinyImg1";
}


$(window).bind("load", function() {
    var projOrderedID = "$projOrderedID";
    d = document.getElementById('loading-screen');
    
    if(projOrderedID != ""){
        gotoProject('$projOrderedID');
    }
    d.style.display = "none";
});


-->
</script>

END;
include "doc_end.html";
?>