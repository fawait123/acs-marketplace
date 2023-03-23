$(document).ready(function () {
    setTimeout(() => {
        $(".lds-dual-ring").addClass("d-none");
    }, 500);

    $("#modal-delete").on("show.bs.modal", function (e) {
        let target = e.relatedTarget;
        let uri = $(target).data("url");
        $("#form-delete").attr("action", uri);
    });
});
