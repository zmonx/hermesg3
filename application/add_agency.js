$(() => {
    $("#add_agency").click(add_agency);
    $("#btn_close_add_agency").click(redirectAgency);
    
 
});
function add_agency() {
    
    var code = $("#code_agency").val();
    var name = $("#name_agency").val();
    var commission = $("#commission_agency").val();
    var sales = $("#sales_name_agency").val();
    var email = $("#email_agency").val();
    var tel = $("#tel_agency").val();
    var address = $("#address_agency").val();
    var comment = $("#comment_agency").val();
    // alert(code+name+commission+sales+email+tel+address+comment);
    var urlAPI = base_url("api.php/add_agency/"+ code + "/" + name + "/" + address + "/" + sales + "/" + email + "/" + tel + "/" + commission + "/" + comment)  ;
    console.log(urlAPI);
      $('#modal_alert').modal('show');
      setTimeout(redirectAgency, 800);
    $.getJSON(urlAPI, { format: "json" }).done(function (data) {
        alert('success');
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