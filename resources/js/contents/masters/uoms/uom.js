$(function () {
    $("#datatable").DataTable({
        ajax: dataUrl,
        processing: true,
        serverSide: true,
        columns: [
            {
                data: "DT_RowIndex",
                width: "10%",
                orderable: false,
                searchable: false,
            },
            {
                data: "name",
            },
            {
                data: "action",
                orderable: false,
                searchable: false,
            },
        ],
        order: [[1, "asc"]],
    });
});

function remove(t) {
    var id = $(t).data("id");
    var url = destroyUrl.replace(":id", id);

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: url,
        type: "DELETE",
        dataType: "JSON",
        data: {
            id: id,
        },
        success: function (data) {
            $("#datatable").DataTable().ajax.reload(null, false);
            Swal.fire({
                icon: "success",
                text: data.message,
                showConfirmButton: false,
            });
        },
        error: function (xhr, ajaxOptions, thrownError) {
            Swal.fire({
                icon: "error",
                text: xhr.responseJSON.message,
                showConfirmButton: false,
            });
        },
    });
}

$(document).on("click", "#delete", function (e) {
    var t = $(this);
    e.preventDefault();
    Swal.fire({
        title: "Apakah kamu yakin?",
        text: "Uom akan dihapus",
        showCancelButton: true,
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.value) {
            remove(t);
        }
    });
});
