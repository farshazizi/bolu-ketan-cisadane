$(function () {
    $("#additionalModal").on("show.bs.modal", function (event) {
        let button = $(event.relatedTarget);
        let saleDetailId = button.data("sale-detail-id");

        $("#saleDetailId").val(saleDetailId);
        tableAdditional(saleDetailId);
    });
});

function tableAdditional(saleDetailId) {
    let url = getSaleAdditionalDetailRoute;
    url = url.replace(":salesDetail", saleDetailId);

    $.ajax({
        url: url,
        data: {
            saleDetailId,
        },
        success: function (response) {
            const data = response.data.saleAdditionalDetails;
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
