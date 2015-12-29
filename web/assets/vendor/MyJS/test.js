onload=function(){
    var e=document.getElementById("refreshed");
    if(e.value=="no")e.value="yes";
        else{e.value="no";location.reload();
    }
}
$( document ).ready(function() {

});

$('#newAuction').submit(function() {
var date = new Date();
var day = date.getDate();
var monthIndex = date.getMonth()+1;
var year = date.getFullYear();
var actualTime = day + '' + monthIndex + '' + year;
    var myEndTimeDay = $('#appbundle_auction_endAuction_day').val();
    var myEndTimeMonth = $('#appbundle_auction_endAuction_month').val();
    var myEndTimeYear = $('#appbundle_auction_endAuction_year').val();
    var endTime = myEndTimeDay + '' + myEndTimeMonth + '' + myEndTimeYear;
    if( parseInt(endTime) <= parseInt(actualTime))
    {
        alert("Change the end date of auction")
        return false;
    }

});
        $('.shipping-selector').collection({
            add: '<a href="#" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span></a>',
            delete: '<a href="#" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></a>',
            max: 3
        });

        $('.payment-selector').collection({
            add: '<a href="#" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign"></span></a>',
            delete: '<a href="#" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></a>',
            max: 3
        });


$('#buy').submit(function() {
   if( $('#auctionName').val() == '')
    {
     alert("Cannot leave fields blank");
     return false;
    }
    if( $('#auctionBuyer').val() == '')
    {
     alert("You can't buy -> Please LogIn");
     return false;
    }
    if( $('#auctionProductAmount').val() == '')
    {
     alert("Amount is valid");
     return false;
    }
    if( $('#auctionProductPrice').val() == '')
    {
     alert("Price is valid");
     return false;
    }
});



$('.my-slider').unslider();