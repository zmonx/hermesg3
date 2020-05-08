$(() => {
  var query = window.location.search.substring(1);
  var vars = query.split("=");
  var ID = vars[1];
  // alert(ID);
  var urlAPI = "http://localhost/hermes/api.php/editguest/" + ID;

  $.getJSON(urlAPI, {
    format: "json",
  })
    .done(function (data) {
      console.log(data);

      $("#show_checkin_edit_infoguest").val(data["0"]["ginfo_in"]);
      $("#show_checkout_edit_infoguest").val(data["0"]["ginfo_out"]);
      $("#show_bookdate_edit_infoguest").val(data["0"]["ginfo_update"]);
      $("#show_fname_edit_infoguest").val(data["0"]["ginfo_first_name"]);
      $("#show_lname_edit_infoguest").val(data["0"]["ginfo_last_name"]);
      $("#show_phone_edit_infoguest").val(data["0"]["ginfo_telno"]);
      $("#show_room_edit_infoguest").val(data["0"]["ginfo_room"]);
      $("#show_type_edit_infoguest").val(data["0"]["rtype_eng"]);
      $("#show_building_edit_infoguest").val(data["0"]["room_building"]);
      $("#show_views_edit_infoguest").val(data["0"]["bl_breakfast"]);

      $("#fname_edit_infoguest").val(data["0"]["ginfo_first_name"]);
      $("#lname_edit_infoguest").val(data["0"]["ginfo_last_name"]);
      $("#passport_edit_infoguest").val(data["0"]["ginfo_passport_id"]);
      $("#phone_edit_infoguest").val(data["0"]["ginfo_telno"]);
      $("#bd_edit_infoguest").val(data["0"]["ginfo_birthday"]);
      $("#nation_edit_infoguest").val(data["0"]["ginfo_nation"]);
      $("#email_edit_infoguest").val(data["0"]["ginfo_email"]);
      $("#sex_edit_infoguest").val(data["0"]["ginfo_sex"]);
      $("#inbreakfast_edit_infoguest").val(data["0"]["bl_incbreakfast"]);
      $("#breakfast_edit_infoguest").val(data["0"]["bl_breakfast"]);
      $("#room_price_edit_infoguest").val(data["0"]["bl_price"]);
      $("#padd_edit_infoguest").val(data["0"]["ginfo_mail_addr"]);
      $("#badd_edit_infoguest").val(data["0"]["ginfo_comment"]);
      $("#sex_edit_infoguest").val(data["0"]["ginfo_sex"]);
      $("#incbreakfast_edit_infoguest").val(data["0"]["bl_incbreakfast"]);
      $("#breakfast_edit_infoguest").val(data["0"]["bl_breakfast"]);
    })
    .fail(function (jqxhr, testStatus, error) {});

  $(document).ready(function () {
    // Material Select
    $(".mdb-select").materialSelect({});
  });
});
