$(document).ready(function(){
//SOMEHOW FIX LAYOUT ISSUE OF FILTER BAR

    //CHECK IF XSMALL SCREEN SIZE ON LOAD AND ALTER FILTER BAR
    filterBar("768", ".filter-bar-container", "hidden", ".filter-icon-container", "hidden");


    if(window.onload) {
        if (window.matchMedia('(max-width: 768px)').matches) {
            if(!($("#filter-btn").click())) {
                $(".filter-bar-container").addClass("hidden");
                $(".d-flex").addClass("layout");
            } else if ($("#filter-btn").click()) {
                $(".filter-bar-container").removeClass("hidden");
                $(".d-flex").removeClass("layout");
            }
        }
    }

    $("#filter-btn").click(function(){
        $(".filter-bar-container").toggleClass("hidden");
        $(".d-flex").toggleClass("layout");
    })

    //ON MODIFICATION OF SCREEN SIZE
    $(window).resize(function() {
        //HIDE/SHOW FILTER
        filterBar("768", ".filter-bar-container", "hidden", ".filter-icon-container", "hidden");
        filterBar("768", ".d-flex", "layout", ".d-flex", "layout");
    })//END RESIZE CHECKER


    function addRemoveTwoClasses(width, targetAdd, classAdd, targetRmv, classRemove) {
        if(window.matchMedia('(max-width:'+ width +'px)').matches) {
            $(targetAdd).addClass(classAdd);
            $(targetRmv).removeClass(classRemove);
        } else if (window.matchMedia('(min-width:' + width + 'px)').matches) {
            $(targetRmv).addClass(classAdd);
            $(targetAdd).removeClass(classRemove);
        }
    }

    function filterBar(width, target1, t1, target2, t2) {
        if(window.matchMedia('(max-width:'+ width +'px)').matches) {
            $(target1).addClass(t1);
            $(target2).removeClass(t2);
        } else if (window.matchMedia('(min-width:' + width + 'px)').matches) {
            $(target2).addClass(t1);
            $(target1).removeClass(t2);
        }
    }

})//END PAGE LOAD

//SHOW WHATS COOKING
var userMap
function initializeMap() {
    userMap = new google.maps.Map(document.getElementById('map'), {
        //THIS WILL BE REPLACED WITH THE USER LOGGED IN
        center: {lat: 43.639832, lng: -79.395954},
        zoom: 15
    });
}
    //GET JSON OF ADDRESSES FROM PHP DATABASE
    $.post("../models/WCAddress.php", function(data) {
        var obj = JSON.parse(data);

        //FOR EACH ADDRESS PULLED FROM THE DATABASE THAT HAS A WHAT'S COOKING
        for(var i=1; i <= (Object.keys(obj.whats_cooking).length); i++) {
            var add = "add" + i;
            var user = "u" + i;
            coords(user, add, obj, userMap);
    };
});//END POST


function coords(user, add, obj, userMap) {
    var geoCode = new google.maps.Geocoder();
    geoCode.geocode({
        address: obj.whats_cooking[user][add]
    }, function (results, status) {
        if(status == "OK") {
            var marker = new google.maps.Marker({
                map: userMap,
                position: results[0].geometry.location
            });
        }
    });
}//END PLACE MARKER FUNCTION

//PINTEREST TO SHARE RECIPE




// Because I've specified the parsing type in my $post, I do not need to include JSON.parse. If it wasn't included, I would, beacuse it doesn't know that it is JSON.


//FINDING THE LENGTH OF A JS OBJECT
//https://stackoverflow.com/questions/5223/length-of-a-javascript-object?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa

//USING FOR LOOP TO POPULATE GEOCODE
//https://stackoverflow.com/questions/9052393/google-geocoding-multiple-addresses-in-a-loop-with-javascript-how-do-i-know-whe?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
