$(() => {
    var query = window.location.search.substring(1);
    var vars = query.split("=");
    var ID = vars[1];
    // alert(ID);
    var urlAPI = "http://localhost/hermesg3/hermesdb/api.php/editguest/" + ID;

    $.getJSON(urlAPI, {
            format: "json",
        })
        .done(function(data) {
            console.log(data);
            $("#fname1").val(data["0"]["resinfo_first_name"]);
            $("#lname1").val(data["0"]["resinfo_last_name"]);
            $("#tel1").val(data["0"]["resinfo_telno"]);
            $("#email1").val(data["0"]["resinfo_email"]);
        })
        .fail(function(jqxhr, testStatus, error) {});
});