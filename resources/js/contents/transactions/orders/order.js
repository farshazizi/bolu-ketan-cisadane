$(function () {
    $("#datatable").DataTable({
        ajax: dataRoute,
        processing: true,
        serverSide: true,
        columns: [
            {
                data: "DT_RowIndex",
                width: "8%",
                orderable: false,
                searchable: false,
            },
            {
                data: "date",
                width: "15%",
            },
            {
                data: "name",
            },
            {
                data: "address",
            },
            {
                data: "phone",
                width: "15%",
            },
            {
                data: "status",
                width: "8%",
                render: function (data) {
                    if (data == "0") {
                        return '<span class="badge bg-warning">Menunggu Diproses</span>';
                    } else if (data == "1") {
                        return '<span class="badge bg-success">Berhasil</span>';
                    } else {
                        return "";
                    }
                },
            },
            {
                data: "action",
                orderable: false,
                searchable: false,
            },
        ],
        language: {
            emptyTable: "Tidak ada data",
        },
    });
});

function remove(t) {
    var id = $(t).data("id");
    var route = destroyRoute.replace(":id", id);
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: route,
        type: "DELETE",
        dataType: "JSON",
        success: function (response) {
            $("#datatable").DataTable().ajax.reload(null, false);
            Swal.fire({
                icon: response.status,
                text: response.message,
                showConfirmButton: false,
            });
        },
        error: function (xhr, ajaxOptions, thrownError) {
            Swal.fire({
                icon: xhr.responseJSON.status,
                text: xhr.responseJSON.message,
                showConfirmButton: false,
            });
        },
    });
}

$(document).on("click", "#delete", function (event) {
    var t = $(this);
    event.preventDefault();
    Swal.fire({
        title: "Apakah kamu yakin?",
        text: "Pesanan akan dihapus",
        showCancelButton: true,
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.value) {
            remove(t);
        }
    });
});
