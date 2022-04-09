$(function () {
    $("#datatable").DataTable({
        ajax: dataRoute,
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
                data: "date",
            },
            {
                data: "invoice_number",
            },
            {
                data: "type",
                render: function (data) {
                    if (data == "0") {
                        return '<span class="badge bg-primary">Langsung</span>';
                    } else if (data == "1") {
                        return '<span class="badge bg-success">Pesanan</span>';
                    } else {
                        return "";
                    }
                },
            },
            {
                data: "grand_total",
                className: "text-right",
            },
            {
                data: "notes",
            },
            {
                data: "action",
                orderable: false,
                searchable: false,
            },
        ],
        order: [[1, "asc"]],
        language: {
            emptyTable: "Tidak ada data",
        },
    });

    var tableOrder = $("#datatableOrder").DataTable({
        ajax: dataSaleOrdersRoute,
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
                data: "date",
            },
            {
                data: "name",
            },
            {
                data: "address",
            },
            {
                data: "phone",
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

    $("#orderModal").on("show.bs.modal", function (event) {
        tableOrder;
    });

    $("#btnChooseOrder").on("click", function (event) {
        let value = $("#orderIdChoosed").val();
        window.location.href = createSaleOrderRoute + "/" + value;
    });
});

$(document).on("click", "#orderId", function (event) {
    let value = $(event.target).val();
    $("#orderIdChoosed").val(value);
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
        text: "Penjualan akan dihapus",
        showCancelButton: true,
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.value) {
            remove(t);
        }
    });
});
