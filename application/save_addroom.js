$(() => {
    var query = window.location.search.substring(1);
    var vars = query.split("=");
    var ID = vars[1];
    $("#save_add_room").click(save);
});

function save() {
    var query = window.location.search.substring(1);
    var vars = query.split("=");
    var ID = vars[1];
    var api_url = "http://localhost/hermesg/api.php/saveadd/";
    var key1 = ID;
    var key2 = $("#select").val();
    $.ajax({
        type: "POST",
        url: api_url + key1 + "/" + key2,
        success: function(result, status, xhr) {
            alert("success" + key2);
        },
        error: function(xhr, status, error) {
            alert(
                "Result: " +
                status +
                " " +
                error +
                " " +
                xhr.status +
                " " +
                xhr.statusText
            );
        },
    });
}