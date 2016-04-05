function sortTable(f,n){
  var rows = $('#mytable tbody  tr').get();

  rows.sort(function(a, b) {

    var A = getVal(a);
    var B = getVal(b);

    if(A < B) {
      return -1*f;
    }
    if(A > B) {
      return 1*f;
    }
    return 0;
  });

  function getVal(elm){
    var v = $(elm).children('td').eq(n).text().toUpperCase();
    if($.isNumeric(v)){
      v = parseInt(v,10);
    }
    return v;
  }

  $.each(rows, function(index, row) {
    $('#mytable').children('tbody').append(row);
  });
}
var t_id = 1;
var t_party = 1;
var t_guest = 1;
var t_food = 1;
var t_other = 1;
$("#t_id").click(function(){
    t_id *= -1;
    sortTable(t_id, $(this).prevAll().length );
});
$("#t_party").click(function(){
    t_party *= -1;
    sortTable(t_party, $(this).prevAll().length );
});
$("#t_guest").click(function(){
    t_guest *= -1;
    sortTable(t_guest, $(this).prevAll().length );
});
$("#t_food").click(function(){
    t_food *= -1;
    sortTable(t_food, $(this).prevAll().length );
});
$("#t_other").click(function(){
    t_other *= -1;
    sortTable(t_other, $(this).prevAll().length );
});
