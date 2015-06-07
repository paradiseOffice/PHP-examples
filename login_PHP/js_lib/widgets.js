/* advanced options button show/hide toggle */
$(function() {
     $( "#show_adv" ).click(function () {
        $( "#options" ).toggle();
     });
});
/* end of advanced options button */
$(function() {
    $( "#progressbar" ).progressbar({
        value: 0,
        max: 100
    });
    for (var i = 0; i < 101; i++)
    {
        setTimeout(function() {},10000);
        $( "#progressbar" ).progressbar({ value: i });
    }
});
$(function() {
    var regexSciNum = /^[0-9]+[\.|,][0-9]+[e|E][0-9]+$/;
    var inputSciNum = $( ".sciNum" ).val();
    var resultSciNum = regexCurrency.test(inputSciNum);
    if (!resultSciNum) 
    {
         $( "#messages" ).append("<p class='warn'>Please enter a scientific number value like 1.6e6 (1,600,000). </p>");
         return false;
    }
    else
    {
         return true;
    }            
});

$(function() {
    $( ".slider" ).slider({ min: 0, max: 100 });
    var sliderValue = $( "#slider1" ).slider("option", "value");
    console.log(sliderValue);
});

$(function() {
    $( "#spinner1" ).spinner({
        spin: function( event, ui ) {}
    });
    $( "#spinner1" ).on( "spin", function( event, ui ) { 
        var spinValue = ui.value; 
        console.log(spinValue); 
    });
});

$(function() {
    var timeRegex = /^(([0-9])|([0-1][0-9])|([2][0-3])):?([0-5][0-9])([:]?[0-5][0-9])*$/;
    var inputTime = $( ".timeField" ).val();
    var resultRegex = timeRegex.test(inputTime);
    if (!resultRegex) {
        $( "#messages" ).append("<p class='warn'>Time field isn't in HH:MM or HH:MM:SS format. </p>");
        return false;
    }
    else
    {
        return true;
    }
    
    // pass in a locale at some stage for setting the currency sign
    var regexCurrency = /^[0-9]+([\.|,][0-9]+)?/;
    var inputCurrency = $( ".currencyField" ).val();
    var resultRegex = regexCurrency.test(inputCurrency);
    if(!resultRegex) {
        // error - not a valid currency value... figure out error msg implementation.
        $( "#messages" ).append("<p class='warn'>Please enter a currency value that is 0 or more. </p>");
        return false;
    }
    else
    {
        return true;
    }
});
// set the label text (parameter)
// add a datepicker for the calendar button icon
// set a date range, min and max. (parameter)
$(function(){
    $.datepicker.setDefaults(
    $.extend($.datepicker.regional['en'])
    );
    $( "#dateField1" ).datepicker();
    /* {
       dayNamesShort: $.datepicker.regional[ "gb" ].dayNamesShort,
       dayNames: $.datepicker.regional[ "gb" ].dayNames,
       monthNamesShort: $.datepicker.regional[ "gb" ].monthNamesShort,
       monthNames: $.datepicker.regional[ "gb" ].monthNames
        } */
});

$(function() {
    var regexFloat = /^[0-9]+([\.|,][0-9]+)*/;
    var inputFloat = $( ".floatField" ).val();
    var resultRegex = regexFloat.test(inputFloat);
    if(!resultRegex) {
        // error - not a valid currency value... figure out error msg implementation.
        $( "#messages" ).append("<p class='warn'>Please enter a number with digits after the decimal point. </p>");
        return false;
    }
    else
    {
        return true;
    }
});

$(function() {
    $( document ).tooltip({ items: 'a' });
});

$( ".colour_picker" ).spectrum({
    flat: true,
    showInput: true
});
$(function() {
    // get value of select box on change   
    var default_cols = [['black', 'rgb(128,128,128)', 'white', 'red', 'blue'], ['rgb(200,122,95)', 'rgb(139,69,19)', 'rgb(255,140,0)', 'rgb(255,165,0)', 'goldenrod'], ['gold', 'yellow', 'yellowgreen', 'rgb(127,255,0)', 'green'], ['darkgreen', 'lightskyblue', 'dodgerblue', 'darkblue', 'darkslateblue'], ['blueviolet', 'violet', 'indigo', 'magenta', 'mediumorchid']];
    $( ".icon_swatches" ).spectrum({
         showPaletteOnly: true,
         showPalette:true,
         color: 'rgb(144, 129, 200)',
         palette:  default_cols  
    });
    $( ".palette" ).spectrum({
         flat: true,
         showPaletteOnly: true,
         showPalette:true,
         color: 'green',
         palette:  default_cols           
    });
});
