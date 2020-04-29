$(() => {
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var ID = vars[1];
  // alert(ID);
  var urlAPI = "http://localhost/hermesg3/hermesdb/api.php/addroom/" + ID;

  $.getJSON(urlAPI, {
    format: "json",
  })
    .done(function (data) {
      console.log(data);
      $("#room1").val(data["0"]["room_name"]);
      $("#fname1").val(data["0"]["resinfo_first_name"]);
      $("#lname1").val(data["0"]["resinfo_last_name"]);
      $("#tel1").val(data["0"]["resinfo_telno"]);
      $("#email1").val(data["0"]["resinfo_email"]);
    })
    .fail(function (jqxhr, testStatus, error) {});
});

function showRoom() {
  //    alert('sdasdsa');
  var urlAPI = "http://localhost/hermesg3/hermesdb/api.php/room";
  $.getJSON(urlAPI, {
    format: "json",
  })
    .done(function (data) {
      console.log(data);
      var selectionObject = document.getElementById("select");
      for (var i = 0; i < data.length; i++) {
        var option = document.createElement("OPTION"),
          txt = document.createTextNode(data[i]["room_name"]);
        option.appendChild(txt);
        option.setAttribute("value", data[i]["room_id"]);
        select.insertBefore(option, select.lastChild);
      }
    })
    .fail(function (jqxhr, textStatus, error) {});
}