function bindLanguagesAutoComplete(){
    // Initialize autocomplete with local lookup:
    jQuery('#languagespoken,#languagelearning').autocomplete({
        lookup: languages,
        minChars: 0,
        showNoSuggestionNotice: true,
        noSuggestionNotice: 'Sorry, no matching results'
    });
    
}
jQuery(document).ready(function(){
    bindLanguagesAutoComplete();
    jQuery(".connect-arrow-btn").click(function(){
        jQuery(".submenu").hide();
        var X=jQuery(this).attr('id');
        if(X==1){
            jQuery(this).siblings(".submenu").hide();
            jQuery(this).attr('id', '0');
        }
        else {
            jQuery(this).siblings(".submenu").show();
            jQuery(this).attr('id', '1');
        }
    });
    
    //Mouse click on sub menu
    jQuery(".submenu").mouseup(function(){
        return false
    });

    //Mouse click on my account link
    jQuery(".account").mouseup(function(){
        return false
    });

    //Document Click
    jQuery(document).mouseup(function(){
        jQuery(".submenu").hide();
        jQuery(".account").attr('id', '');
    });
    configreviewrating();
});

function configreviewrating(){
    jQuery('.star_rating_small').raty({
            half  : true,
            readOnly: true,
            starOff  : 'star-off-small.png',
            starOn   : 'star-on-small.png',
            starHalf :'star-half-small.png',
            number: 5,
            score: function() {
                return jQuery(this).attr('overallrating');
            }
    });
}
