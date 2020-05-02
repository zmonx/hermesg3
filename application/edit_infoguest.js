$(() => {
    var query = window.location.search.substring(1);
    var vars = query.split("=");
    var ID = vars[1];
    // alert(ID);
    var urlAPI = "http://localhost/hermes/api.php/editguest/" + ID;

    $.getJSON(urlAPI, {
            format: "json",
        })
        .done(function(data) {
            console.log(data);
            $("#fname").val(data["0"]["ginfo_first_name"]);
            $("#lname").val(data["0"]["ginfo_last_name"]);
            $("#passport").val(data["0"]["ginfo_passport_id"]);
            $("#phone").val(data["0"]["ginfo_telno"]);
            $("#bd").val(data["0"]["ginfo_birthday"]);
            $("#nation").val(data["0"]["ginfo_nation"]);
            $("#email").val(data["0"]["ginfo_email"]);
            $("#sex").val(data["0"]["ginfo_sex"]);
            $("#inbreakfast").val(data["0"]["bl_incbreakfast"]);
            $("#breakfast").val(data["0"]["bl_breakfast"]);
            $("#room_price").val(data["0"]["bl_price"]);
            $("#padd").val(data["0"]["ginfo_mail_addr"]);
            $("#badd").val(data["0"]["ginfo_comment"]);
            $("#sex").val(data["0"]["ginfo_sex"]);
            $("#incbreakfast").val(data["0"]["bl_incbreakfast"]);
            $("#breakfast").val(data["0"]["bl_breakfast"]);
        })
        .fail(function(jqxhr, testStatus, error) {});

    $(document).ready(function() {
        // Material Select
        $(".mdb-select").materialSelect({});
    });
});