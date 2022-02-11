Vue.component("date-picker", VueBootstrapDatetimePicker);
var app = new Vue({
    el: "#app",
    delimiters: ["{>", "<}"],
    data: {
        stockType: "1",
        date: "",
        notes: "",
        detail: [],
        errors: [],
        config: {
            format: "DD-MM-YYYY",
            useCurrent: false,
            showClear: false,
            showClose: false,
        },
    },
    mounted: function () {
        const vm = this;
        vm.addStockOut();
    },
    methods: {
        addStockOut: function () {
            let dataDetail = {
                inventoryStock: "",
                quantity: 0,
                notes: "",
            };
            this.detail.push(dataDetail);
        },
        deleteStockIn: function (index) {
            this.detail.splice(index, 1);
        },
        closeValidation: function () {
            this.errors = [];
        },
        submitForm: function (event) {
            this.errors = [];
            event.preventDefault();

            if (!this.date) {
                this.errors.push("Tanggal wajib diisi.");
            }

            let dataDetail = this.detail;
            for (let index = 0; index < dataDetail.length; index++) {
                if (!dataDetail[index].inventoryStock) {
                    this.errors.push(
                        "Stok pada baris ke-" + (index + 1) + " wajib diisi."
                    );
                }
                if (!dataDetail[index].quantity) {
                    this.errors.push(
                        "Kuantitas pada baris ke-" +
                            (index + 1) +
                            " wajib diisi."
                    );
                }
            }

            if (this.errors.length > 0) {
                return;
            }

            var data = JSON.parse(JSON.stringify(this.$data));

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });
            $.ajax({
                contentType: "application/json",
                data: JSON.stringify(data),
                type: "POST",
                url: storeRoute,
                success: function (response) {
                    if (
                        response.status === "success" &&
                        response.code === "store-stock-out-success"
                    ) {
                        Swal.fire({
                            icon: response.status,
                            text: response.message,
                            showConfirmButton: false,
                        });
                    } else {
                        Swal.fire({
                            icon: response.status,
                            text: response.message,
                            showConfirmButton: false,
                        });
                    }
                    window.location.reload(true);
                },
                error: function (xhr, textStatus, errorThrown) {
                    Swal.fire({
                        icon: xhr.responseJSON.status,
                        text: xhr.responseJSON.message,
                        showConfirmButton: false,
                    });
                },
            });
        },
    },
    watch: {
        errors: function () {
            if (this.errors.length > 0) {
                $("html, body").animate(
                    {
                        scrollTop: 0,
                    },
                    0
                );
            }
        },
    },
});
