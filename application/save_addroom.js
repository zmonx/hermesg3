$(() => {
    var query = window.location.search.substring(1);
    var vars = query.split("=");
    var ID = vars[1];
    $(document).ready(function() {
        var api_url = "http://localhost/hermesg3/hermesdb/api.php/saveadd/";
        var key1 = ID;
        var key2 = $("#select").val();
        $("#save").click(function(index, element) {
            $.ajax({
                type: "POST",
                url: api_url + key1 + "/" + key2,

                success: function(result, status, xhr) {
                    alert("success");
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
        });
    });
});