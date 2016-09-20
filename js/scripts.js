var counter=0;
var incrementCounter=function(e){
  counter++;
  $(this).text(counter);
};
var fetchRows = function(){
  $.ajax({
    url: 'Services/RecordPrinter.php',
    type: 'GET',
    data: 'json',
    error: function(error) {
      console.error(error);
    },
    success: function(data){
      loadData(data.rows);
    }
  });
};

var loadData=function(data){
  for(var i=0; i < data.length; i++){
    var rowdata = data[i];
    console.log(rowdata);
    var row ="<tr>"+
      "<td>"+rowdata.userid+"</td>"+
      "<td>"+rowdata.lastname+"</td>"+
      "<td>"+rowdata.firstname+"</td>"+
      "<td>"+rowdata.verifiedCount+"</td>"+
      "<td>"+rowdata.denialCount+"</td>"+
      "<td>"+rowdata.verifiedPercent+"</td>"+
      "<td>"+rowdata.denialPercent+"</td>"+
    "</tr>";
    $("#verifiedTableBody").append(row);
  }

};
$(document).ready(function(){
  $(".clickytime").click(incrementCounter);
  fetchRows();
});
