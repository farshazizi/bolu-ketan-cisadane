Vue.component("date-picker", VueBootstrapDatetimePicker);
var app = new Vue({
    el: "#app",
    delimiters: ["{>", "<}"],
    data: {
        date: new Date().toISOString().slice(0, 10),
        notes: "",
        grandTotal: 0,
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
        vm.addPurchase();

        $(function () {
            $("body").on("change", "#quantity", function (event) {
                let index = $(event.target).attr("index");
                let value = $(event.target).val();
                let total = value * vm.detail[index].price;

                vm.$set(vm.detail[index], "total", total);
            });

            $("body").on("change", "#price", function (event) {
                let index = $(event.target).attr("index");
                let value = $(event.target).val();
                let total = value * vm.detail[index].quantity;

                vm.$set(vm.detail[index], "total", total);
            });
        });
    },
    filters: {
        numberFormat: function (value) {
            return new Intl.NumberFormat("en-US", {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            }).format(value);
        },
    },
    computed: {
        calculateGrandTotal: function () {
            let grandTotal = 0;
            if (this.detail.length > 0) {
                for (var index = 0; index < this.detail.length; index++) {
                    grandTotal += parseFloat(this.detail[index].total);
                }
            }
            this.grandTotal = grandTotal;

            return grandTotal;
        },
    },
    methods: {
        addPurchase: function () {
            let dataDetail = {
                ingredient: "",
                uom: "",
                quantity: 0,
                price: 0,
                total: 0,
                notes: "",
            };
            this.detail.push(dataDetail);
        },
        deleteSale: function (index) {
            this.detail.splice(index, 1);
        },
        getUom: function (index) {
            let dataDetail = this.detail[index];
            let ingredientId = dataDetail.ingredient;
            route = getUomRoute.replace(":id", ingredientId);
            $.ajax({
                url: route,
                type: "GET",
                dataType: "JSON",
                success: function (response) {
                    let uomName = response.data.ingredient.uom.name;
                    dataDetail.uom = uomName;
                    $("#uom").val(uomName);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        icon: xhr.responseJSON.status,
                        text: xhr.responseJSON.message,
                        showConfirmButton: false,
                    });
                },
            });
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
                if (!dataDetail[index].ingredient) {
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
                if (!dataDetail[index].price) {
                    this.errors.push(
                        "Harga pada baris ke-" + (index + 1) + " wajib diisi."
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
                data: JSON.stringify(data),
                contentType: "application/json",
                type: "POST",
                url: storeRoute,
                success: function (response) {
                    console.log(response);
                    if (
                        response.status === "success" &&
                        response.code === "store-purchase-success"
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
