$(function(){
    $('#fromDatePicker').datepicker({
        inline: true,
        showOtherMonths: true,
        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        
        onSelect: function(dateText, inst) { 
            var dateAsString = dateText; //the first parameter of this function
            var dateAsObject = $(this).datepicker( 'getDate' ); //the getDate method
            // set the hidden elements
            document.getElementById("fromDayHidden").value = dateAsObject.getDate().toString();
            document.getElementById("fromMonthHidden").value = dateAsObject.getMonth();
            document.getElementById("fromYearHidden").value = dateAsObject.getFullYear();
        }
    });
    
    $('#toDatePicker').datepicker({
        inline: true,
        showOtherMonths: true,
        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        
        onSelect: function(dateText, inst) { 
            var dateAsString = dateText; //the first parameter of this function
            var dateAsObject = $(this).datepicker( 'getDate' ); //the getDate method
            // set the hidden elements
            document.getElementById("toDayHidden").value = dateAsObject.getDate().toString();
            document.getElementById("toMonthHidden").value = dateAsObject.getMonth();
            document.getElementById("toYearHidden").value = dateAsObject.getFullYear();
        }
    });
    
    $("#datepicker").datepicker({
           
    })
});