// colors to be used in the following functions
var greyC = "#8E9093";
var pinkC = "#FC265D";
var dargC = "#221F1F";
var blakC = "#000000";
var ligrC = "#CDCFD0";

// call this in lightPic() if the id != an int
function styleElem(id,min,max){
    for(h=1; h<=53; h++){
        if(h < min || h > max){
            var d = document.getElementById('cast-thumb-' + h);
            d.style.opacity = 0.1;
        } else {
            var e = document.getElementById('cast-name-' + h);
            e.style.color = pinkC;
        }
    }
    var f = document.getElementById(id+ '-head');
    var g = document.getElementById(id+ '-subhead');
    var h = document.getElementById(id+ '-subdiv');
    f.style.color = pinkC;
    g.style.color = pinkC;
    h.style.borderTopColor = pinkC;
    h.style.borderBottomColor = pinkC;
}

// when a name or major is hovered, execute this function to light up the corresponding img
function lightPic(id) {
    
    // light up the id indicated, if not a string
    if(id >= 1 && id <= 53){
        for(g=1; g<=53; g++){
            var d = document.getElementById('cast-thumb-' + g);
            if(g != id){d.style.opacity = 0.1;}
        }
        var e = document.getElementById('cast-name-' + id);
        e.style.color = pinkC;
    // dim all but VCD majors
    } else if(id == "id") {
        styleElem('id','21','31');
    // dim all but ID majors
    } else if(id == "vcd") {
        styleElem('vcd','1','20');
    // dim all but IXD majors
    } else if(id == "ixd") {
        styleElem('ixd','32','47');
    // dim all but MASTERS students
    } else if(id == "grad") {
        styleElem('grad','48','53');
    } else {
        return; // does this ever happen? hope not...
    }
}


// every item that calls the lightPic() function
// must call darkPic() onMouseOut to reset hover states
function darkPic() {
    
    for(i=1; i<=53; i++){
        var d = document.getElementById('cast-thumb-' + i);
        d.style.opacity = 1;
        var e = document.getElementById('cast-name-' + i);
        e.style.color = greyC;
    }
    
    var newId = "";
    for(i=1; i<=4; i++){
        if(i == 1){newId = "id";}
        if(i == 2){newId = "ixd";}
        if(i == 3){newId = "vcd";}
        if(i == 4){newId = "grad";}
        
        var f = document.getElementById(newId+ "-head");
        var g = document.getElementById(newId+ "-subhead");
        var h = document.getElementById(newId+ "-subdiv");
        f.style.color = dargC;
        g.style.color = dargC;
        h.style.borderTopColor = blakC;
        h.style.borderBottomColor = ligrC;
    }
    
}


// when the user hovers over a thumb, change the title pink (and reverse)
function projTitleHover(elem){
    d = document.getElementById(elem);
    d.style.color = pinkC;
}

function projTitleLeave(elem){
    d = document.getElementById(elem);
    d.style.color = blakC;
}