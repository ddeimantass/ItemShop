const url = "http://127.0.0.1:8000/api/item/";
$( document ).ready(function() {
    $("#list").on("click", "table a.reduce", function () {reduce($(this).attr("id"));});

    function reduce(id) {
        $.getJSON(url + id + "/reduce", function(data){
            let button = '';
            let tr = '<td>' + data.name + '</td>';

            tr += '<td>' + data.price + '</td>';
            tr += '<td>' + data.quantity + '</td>';

            if (data.quantity > 0) {
                button = '<a id="' + data.id + '" class="reduce btn btn-danger" href="#" >reduce</a>';
            }

            tr += '<td>' + button + '</td>';

            $("#tr-" + data.id).html(tr)
        });
    }
});