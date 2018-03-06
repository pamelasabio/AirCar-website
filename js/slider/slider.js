
//http://ghusse.github.io/jQRangeSlider/options.html#optionsUsage
(function($, undefined){
	"use strict";
     $(document).ready(function(){
        var simple = $("#slider");
        simple.rangeSlider(
            {bounds: {min: 0, max: 500},wheelMode: "zoom"}
                          
        ); 
     });
})(jQuery);