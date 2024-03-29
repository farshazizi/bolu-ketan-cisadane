$(function () {
    $("#datatable").DataTable({
        ajax: dataRoute,
        processing: true,
        serverSide: true,
        columns: [
            {
                data: "DT_RowIndex",
                width: "10%",
                orderable: true,
                searchable: false,
            },
            {
                data: "date",
                orderable: false,
                searchable: false,
            },
            {
                data: "invoice_number",
                orderable: true,
                searchable: true,
            },
            {
                data: "type",
                width: "5%",
                orderable: false,
                searchable: false,
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
                orderable: false,
                searchable: false,
            },
            {
                data: "notes",
                orderable: false,
                searchable: false,
            },
            {
                data: "action",
                orderable: false,
                searchable: false,
            },
        ],
        order: [[1, "desc"]],
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

    $("#orderModal").on("show.bs.modal", function () {
        tableOrder;
    });

    $("#btnChooseOrder").on("click", function () {
        let value = $("#orderIdChoosed").val();
        window.location.href = createSaleOrderRoute + "/" + value;
    });
});

$(document).on("click", "#orderId", function (event) {
    let value = $(event.target).val();
    $("#orderIdChoosed").val(value);
});

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
