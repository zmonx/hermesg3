$(() => {
    show_info();
    show_info_edit();
    $("#save_edit_infoguest").click(Update_infoguest_edit);
});

function show_info() {
    var query = window.location.search.substring(1);
    var vars = query.split("=");
    var ID = vars[1];
    var urlAPI = base_url("api.php/show_info/" + ID);

    $.getJSON(urlAPI, {
            format: "json",
        })
        .done(function(data) {
            console.log(data);
            $("#show_checkin").text(data["0"]["ginfo_in"]);
            $("#show_checkout").text(data["0"]["ginfo_out"]);
            $("#show_bookdate").text(data["0"]["resinfo_bookdate"]);
            $("#show_fname").text(data["0"]["ginfo_first_name"]);
            $("#show_lname").text(data["0"]["ginfo_last_name"]);
            $("#show_phone").text(data["0"]["ginfo_telno"]);
            $("#show_room").text(data["0"]["room_name"]);
            $("#show_type").text(data["0"]["rtype_eng"]);
            $("#show_building").text(data["0"]["room_building"]);
            $("#show_views").text(data["0"]["rview_eng"]);
        })
}

function show_info_edit() {
    var query = window.location.search.substring(1);
    var vars = query.split("=");
    var ID = vars[1];
    var urlAPI = base_url("api.php/show_info/" + ID);

    $.getJSON(urlAPI, {
        format: "json",
    })

    .done(function(data) {
        console.log(data);
        $("#fname_edit_infoguest").val(data["0"]["ginfo_first_name"]);
        $("#lname_edit_infoguest").val(data["0"]["ginfo_last_name"]);
        $("#passport_edit_infoguest").val(data["0"]["ginfo_passport_id"]);
        $("#phone_edit_infoguest").val(data["0"]["ginfo_telno"]);
        $("#bd_edit_infoguest").val(data["0"]["ginfo_birthday"]);
        $("#nation_edit_infoguest").val(data["0"]["ginfo_nation"]);
        $("#email_edit_infoguest").val(data["0"]["ginfo_email"]);
        $("#sex_edit_infoguest").val(data["0"]["ginfo_sex"]);
        $("#room_price_edit_infoguest").val(data["0"]["bl_price"]);
        $("#padd_edit_infoguest").val(data["0"]["ginfo_mail_addr"]);
        $("#badd_edit_infoguest").val(data["0"]["ginfo_comment"]);
        $("#sex_edit_infoguest").val(data["0"]["ginfo_sex"]);
        $("#incbreakfast_edit_infoguest").val(data["0"]["bl_incbreakfast"]);
        $("#breakfast_edit_infoguest").val(data["0"]["bl_breakfast"]);
    })

}

function Update_infoguest_edit() {
    var query = window.location.search.substring(1);
    var vars = query.split("=");
    var ID = vars[1];
    $("#id_bl_update").val(ID);
    $("#save_edit_infoguest").click(function(e) {
        e.preventDefault();
        $("update_form_edit").submit();
    });

    $("#update_form_edit").on("submit", function(e) {
        var parameter = $(this).serializeArray();
        $("#btn_yes_update").click(function(e) {
            console.log("1");
            console.log(parameter);
            console.log("1");
            var url = base_url("api.php/update_guest");
            $.post(url, parameter, function(response) {
                console.log("4");
                console.log(response);
                console.log("4");
                if (response["message"] == "success") {
                    $("#modal_alert").modal("show");
                }
            });
        });
        console.log("3");
        e.preventDefault();
    });
}

function base_url(path){
    var host = window.location.origin;
    // "http://localhost"
    var pathArray = window.location.pathname.split( '/' );
    // split path
    return host+"/"+pathArray[1]+"/"+path;
    // return http://localhost/hermes/+path
  }