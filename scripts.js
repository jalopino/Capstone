jQuery(document).ready(function(){
    jQuery(".license-info-tab").hide();
    jQuery(".profile-pic-popup").hide();
    jQuery("#changepasstab").css("background-color", "#d3d3d3");
    jQuery("#changepasstab").click(function() {
        jQuery(".change-pass-tab").fadeIn();
        jQuery("#changepasstab").css("background-color", "#d3d3d3");
        jQuery(".border-table").css("border-right", "1px solid black");
        jQuery("#licenseinformationtab").css("background-color", "white");
        jQuery(".license-info-tab").hide();
    });
    jQuery("#licenseinformationtab").click(function() {
        jQuery(".license-info-tab").fadeIn();
        jQuery("#licenseinformationtab").css("background-color", "#d3d3d3");
        jQuery(".border-table").css("border-right", "0px");
        jQuery("#changepasstab").css("background-color", "white");
        jQuery(".change-pass-tab").hide();
    });
    jQuery(".pop-up").click(function() {
        jQuery(".profile-pic-popup").fadeIn();
    });
    jQuery(".profile-pic-popup").click(function() {
        jQuery(".profile-pic-popup").fadeOut();
    });
    jQuery(".profile-pic-popup-child").click(function(e) {
        e.stopPropagation();
     })
});

