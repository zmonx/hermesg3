$(() => {
  display_info_checkin();
});

function display_info_checkin() {
  // var query = window.location.search.substring(1);
  // var vars = query.split("=");
  // var ID = vars[1];
  var urlAPI = base_url("api.php/show_gesinfo_checkout");
  $.getJSON(urlAPI).done(function (data) {
    //console.log(JSON.stringify(data));

    var line = "";
    $.each(data, function (k, item) {
      console.log(item);
      line += "<tr>";
      line += "<td><button type= 'button' class='btn btn-info btn-round'>Info</button></td>";
      line += "<td>" + item.ginfo_first_name + "</td>";
      line += "<td>" + item.room_name + "</td>";
      line += "<td>" + item.ginfo_telno + "</td>";
      line += "<td>" + item.ginfo_in + "</td>";
      line += "<td >" + item.ginfo_out + "</td>";
      line += "<td >";
      switch(item['bl_status']){
        case "0":
          line+="No Specific";break;
        case "1":
          line+="Avaliable";break;
        case "2":
          line+="Vacant";break;
        case "3":
          line+="Occupy";break;
        case "4":
          line+="Dirty";break;
        case "5":
          line+="๐๐๐";break;
        case "6":
          line+="House Use";break; 
          case "7":
          line+="Block";break; 
          case "8":
          line+="Reserved";break;
      }
      + item.bl_status + "</td>"; 
      line += "</tr>";
    });

    // $("#display").empty();
    $("#display").html(line);

    $('#data_table').DataTable(
    //   "autoWidth": true,
    //   "pageLength": 25,
    //   "searching": false,
    //   "paging": false,
    //   "info": false
    );
  });

//   $('#data_table').dataTable({
//     "bPaginate": false,
//     "bLengthChange": false,
//     "bFilter": true,
//     "bInfo": false,
//     "bAutoWidth": false });
// });
}
