(function (e) {
    e.fn.datepicker.dates.fr = {
        days: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
        daysShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"],
        daysMin: ["D", "L", "Ma", "Me", "J", "V", "S", "D"],
        months: ["Janvier", "F\351vrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Ao\373t", "Septembre", "Octobre", "Novembre", "D\351cembre"],
        monthsShort: ["Jan", "Fev", "Mar", "Avr", "Mai", "Jui", "Jul", "Aou", "Sep", "Oct", "Nov", "Dec"]
    };
    e.fn.datepicker.defaults.autoclose = true;
})(jQuery);


$(document).ready(function(){

//NAV VERTICAL Alcyon.com
$('.menuHide').click(function(){
    if($(".navTxt").hasClass('hide')) {
      $(".navTxt").removeClass("hide");
      $(".menuHideS").removeClass("glyphicon-plus");
      $(".menuHideS").addClass("glyphicon-minus");
    } else {
      $(".navTxt").addClass("hide");
      $(".menuHideS").removeClass("glyphicon-minus");
      $(".menuHideS").addClass("glyphicon-plus");
    }
  });

//NAV VERTICAL button
$(".nav2Y").click(function(){
  var current = $(this).attr('data-link');
  if($('div[data-link='+current+'H]').is(":visible"))
  {
    $(".navVisibility").removeClass("block");
  } else {
    $(".navVisibility").removeClass("block");
    $('div[data-link='+current+'H]').addClass('block'); 
  }
});
});