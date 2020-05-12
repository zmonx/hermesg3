$(() => {
  display_info_checkin();
});

function display_info_checkin() {
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var ID = vars[1];
  var urlAPI = base_url("api.php/show_info/" + ID);
  $.getJSON(urlAPI).done(function (data) {
    //console.log(JSON.stringify(data));

    var line = "";
    $.each(data, function (k, item) {
      console.log(item);
      line += "<tr>";
      line += "<td></td>";
      line += "<td >" + item.ginfo_in + "</td>";
      line += "<td >" + item.ginfo_out + "</td>";
      line += "<td >" + item.resinfo_bookdate + "</td>";
      line += "<td >" + item.ginfo_first_name + "</td>";
      line += "<td >" + item.ginfo_last_name + "</td>";
      line += "<td >" + item.room_name + "</td>";
      line += "</tr>";
    });

    $(document).ready(function () {
      $("#data_table").DataTable({
        aaSorting: [[0, "ASC"]],
      });
    });

    $("#display").append(line);
  });
}
