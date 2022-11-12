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
                data: "name",
            },
            {
                data: "totalOrder",
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

    $("#orderDetailModal").on("show.bs.modal", function (event) {
        let button = $(event.relatedTarget);
        let orderId = button.data("id");

        $("#locationId").val(orderId);
        tableOrderDetail(orderId);
    });
});

function tableOrderDetail(orderId) {
    $.ajax({
        url: dataOrderDetailRoute,
        data: {
            orderId,
        },
        success: function (response) {
            const data = response.data;
            let orderDetailList = `<table class="table">
                    <thead>
                        <th>No</th>
                        <th>Name</th>
                        <th>Jumlah</th>
                    </thead>
                    <tbody>`;

            $.each(data, (index, value) => {
                orderDetailList += `<tr>
                        <td>
                            ${index + 1}
                        </td>
                        <td>
                            ${value["inventory_stock"]["name"]}
                        </td>
                        <td>
                            ${value["quantity"]}
                        </td>
                    </tr>`;
            });
            orderDetailList += `</tbody></table>`;
            $("#orderDetailModal")
                .find("#orderDetailList")
                .html(orderDetailList);
        },
    });
}
