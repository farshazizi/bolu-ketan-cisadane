$(function () {
    $("#additionalModal").on("show.bs.modal", function (event) {
        let button = $(event.relatedTarget);
        let orderDetailId = button.data("order-detail-id");

        $("#orderDetailId").val(orderDetailId);
        tableAdditional(orderDetailId);
    });
});

function tableAdditional(orderDetailId) {
    let url = getOrderAdditionalDetailRoute;
    url = url.replace(":orderDetailId", orderDetailId);

    $.ajax({
        url: url,
        data: {
            orderDetailId,
        },
        success: function (response) {
            const data = response.data.orderAdditionalDetails;
            let additionalList = `<table class="table">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Harga</th>
                    </thead>
                    <tbody>`;

            $.each(data, (index, value) => {
                additionalList += `
                <tr>
                    <td>${index + 1}</td>
                    <td>
                        ${value["additional"]["name"]}
                    </td>
                    <td>
                        ${value["price"]}
                    </td>
                </tr>`;
            });
            additionalList += `</tbody></table>`;
            $("#additionalModal").find("#additionalList").html(additionalList);
        },
    });
}
