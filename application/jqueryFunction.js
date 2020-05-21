$(() => {

  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var ID = vars[1];
  var urlAPI = base_url("api.php/getAgencyinfo/" + ID);
  $.getJSON(urlAPI, { format: "json" })
    .done(function (data) {
      console.log(data);
      $("#agency_code").val(data["0"]["agency_code"]);
      $("#agency_name").val(data["0"]["agency_name"]);
      $("#agency_price").val(data["0"]["agency_price"]);
      $("#agency_contact_name").val(data["0"]["agency_contact_name"]);
      $("#agency_telno").val(data["0"]["agency_telno"]);
      $("#agency_email").val(data["0"]["agency_email"]);
      $("#agency_address").val(data["0"]["agency_address"]);
      $("#agency_comment").val(data["0"]["agency_comment"]);
    })
    .fail(function (jqxhr, testStatus, error) {});
  $("#btnAgencyDelete").click(delAgency);
  $("#btnAgencyEdit").click(editAgency);
  $("#btn_close").click(redirectAgency);
});
 
function delAgency() {
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var dataDelete = new Object();
  dataDelete.agency_id = vars[1];
  const cb = document.querySelector('#deleteRecord');
  result = cb.checked;
//   alert(result);
  if(result==true){
    url = base_url("api.php/delAgencyConfirm")
  }else{
    url = base_url("api.php/delAgency")
  }
  
  
  $.post(url, dataDelete, function (response) {
    console.log(response);
    if (response['message'] == "success") {
    //   alert("success");
      $('#modal_alert').modal('show');
      setTimeout(redirectAgency, 800);
    }else{
      alert("fail")
    }
  });
}
function editAgency() {
  var url = base_url("api.php/updateAgency");
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var key1 = vars[1];
  var data3 = new Object();
  data3.agency_id = parseInt(key1);
  data3.agency_code = $("#agency_code").val();
  data3.agency_name = $("#agency_name").val();
  data3.agency_price = $("#agency_price").val();
  data3.agency_contact_name = $("#agency_contact_name").val();
  data3.agency_email = $("#agency_email").val();
  data3.agency_telno = $("#agency_telno").val();
  data3.agency_address = $("#agency_address").val();
  data3.agency_comment = $("#agency_comment").val();
  $.post(url, data3, function (response) {
    console.log(response);
    if (response['message'] == "success") {
    //   alert("success");
      $('#modal_alert').modal('show');
      setTimeout(redirectAgency, 800);
    }else{
      alert("fail")
    }
  });
}
function redirectAgency() {
    window.location.replace(base_url("page/agency.php"));
  }

function base_url(path){
  var host = window.location.origin;
  // "http://localhost"
  var pathArray = window.location.pathname.split( '/' );
  // split path
  return host+"/"+pathArray[1]+"/"+path;
  // return http://localhost/hermes/+path
}