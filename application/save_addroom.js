$(() => {
    var query = window.location.search.substring(1);
    var vars = query.split("=");
    var ID = vars[1];
    $("#id_bl_save").val(ID);
    $("#save_add_room").click(function(e) {
        e.preventDefault();
        $("#save_form").submit();
    });

    $("#save_form").on("submit", function(e) {
        var parameter = $(this).serializeArray();
        console.log("1");
        console.log(parameter);
        console.log("1");
        var url = "http://localhost/hermes/api.php/saveadd";
        $.post(url, parameter, function(response) {
            console.log("4");
            console.log(response);
            console.log("4");
            if (response["message"] == "success") {
                $("#modal_alert").modal("show");
            }
        });
        console.log("3");
        e.preventDefault();
    });
});

function reload() {
    location.reload();
}
// function save() {
//     var query = window.location.search.substring(1);
//     var vars = query.split("=");
//     var ID = vars[1];
//     $("#save_add_room").val(ID);
//     var parameter = $(this).serializeArray();
//     console.log(parameter);
//     // var url = "http://localhost/hermes/api.php/saveadd";
//     // $("#save_add_room").click(function(e) {
//     //     $.post(url, parameter, function(response) {
//     //         if (response["message"] == "success") {}
//     //     });
//     //     e.preventDefault();
//     // });
//     e.preventDefault();
//     // var api_url = "http://localhost/hermes/api.php/saveadd/";
//     // var key1 = ID;
//     // var key2 = $("#select").val();
//     // $.ajax({
//     //     type: "POST",
//     //     url: api_url + key1 + "/" + key2,
//     //     success: function(result, status, xhr) {
//     //         alert("success" + key2);
//     //     },
//     //     error: function(xhr, status, error) {
//     //         alert(
//     //             "Result: " +
//     //             status +
//     //             " " +
//     //             error +
//     //             " " +
//     //             xhr.status +
//     //             " " +
//     //             xhr.statusText
//     //         );
//     //     },
//     // });
// }