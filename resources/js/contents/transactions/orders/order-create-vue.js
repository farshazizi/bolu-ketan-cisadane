Vue.component("date-picker", VueBootstrapDatetimePicker);
var app = new Vue({
    el: "#app",
    delimiters: ["{>", "<}"],
    data: {
        indexDetail: 0,
        date: new Date().toISOString().slice(0, 10),
        name: "",
        address: "",
        phone: "",
        grandTotal: 0,
        notes: "",
        status: "0",
        detail: [],
        detailAdditional: [],
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
        vm.addOrder();

        $(function () {
            $("body").on("change", "#quantity", function (event) {
                let index = $(event.target).attr("index");
                let value = $(event.target).val();

                if (value > vm.detail[index].stock) {
                    Swal.fire({
                        icon: "warning",
                        text: "Kuantitas melebihi stok.",
                        showConfirmButton: false,
                    });

                    vm.$set(vm.detail[index], "quantity", 0);
                } else {
                    let total = value * vm.detail[index].price;
                    vm.$set(vm.detail[index], "total", total);
                    vm.setIndexAdditional(index);
                    vm.calculateTotalAdditional();
                }
            });

            $("body").on("hide.bs.modal", "#additionalModal", function (event) {
                $("#additional").val("");
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
            let grandTotalDetail = 0;
            let grandTotalAdditional = 0;

            if (this.detail.length > 0) {
                for (let index = 0; index < this.detail.length; index++) {
                    grandTotalDetail += parseFloat(this.detail[index].total);
                }
            }

            if (this.detailAdditional.length > 0) {
                for (
                    let indexAdditional = 0;
                    indexAdditional < this.detailAdditional.length;
                    indexAdditional++
                ) {
                    grandTotalAdditional += parseFloat(
                        this.detailAdditional[indexAdditional].price *
                            this.detail[this.indexDetail].quantity
                    );
                }
            }

            grandTotal = grandTotalDetail + grandTotalAdditional;
            this.grandTotal = grandTotal;

            return grandTotal;
        },
    },
    methods: {
        addOrder: function () {
            let dataDetail = {
                inventoryStock: "",
                quantity: 0,
                price: 0,
                total: 0,
                totalAdditional: 0,
                notes: "",
            };
            this.detail.push(dataDetail);
        },
        deleteDetail: function (index) {
            this.detail.splice(index, 1);
            this.deleteAllDetailAdditional();
        },
        deleteAllDetailAdditional: function () {
            let dataDetailAdditional = [];
            let index = 0;
            for (let key = 0; key < this.detailAdditional.length; key++) {
                if (this.detailAdditional[key].index === this.indexDetail) {
                    dataDetailAdditional[index] = this.detailAdditional[key];
                    index++;
                }
            }
            this.detailAdditional = [];
            for (let key = 0; key < dataDetailAdditional.length; key++) {
                this.detailAdditional[key] = dataDetailAdditional[key];
            }
        },
        getPrice: function (index) {
            let dataDetail = this.detail[index];
            let inventoryId = dataDetail.inventoryStock;
            let url = getPriceRoute.replace(":id", inventoryId);

            $.ajax({
                url: url,
                type: "GET",
                dataType: "JSON",
                success: function (response) {
                    let price = response.data.price;
                    dataDetail.price = price;
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
        setIndexAdditional: function (index) {
            this.indexDetail = index;
        },
        addAdditional: function () {
            let index = this.indexDetail;
            let additionalId = $("#additional").val();

            if (additionalId) {
                let additionalName = $("#additional option:selected")
                    .text()
                    .trim();
                let price = $("#additional option:selected").attr("price");
                let dataDetailAdditional = {
                    additionalId: additionalId,
                    additionalName: additionalName,
                    price: parseFloat(price),
                    keyDetail: index,
                };
                this.detailAdditional.push(dataDetailAdditional);
                this.calculateTotalAdditional();
            }
        },
        deleteAdditional: function (index) {
            this.detailAdditional.splice(index, 1);
            this.calculateTotalAdditional();
        },
        calculateTotalAdditional: function () {
            let totalPrice = 0;

            for (let key = 0; key < this.detailAdditional.length; key++) {
                let detailIndex = this.detailAdditional[key].keyDetail;
                if (detailIndex == this.indexDetail) {
                    totalPrice += parseInt(
                        this.detailAdditional[key].price *
                            this.detail[this.indexDetail].quantity
                    );
                }
            }

            this.detail[this.indexDetail].totalAdditional = totalPrice;
        },
        closeValidation: function () {
            this.errors = [];
        },
        submitForm: function (event) {
            this.errors = [];
            event.preventDefault();

            if (!this.date) this.errors.push("Tanggal wajib diisi.");
            if (!this.name) this.errors.push("Nama wajib diisi.");
            if (!this.address) this.errors.push("Alamat wajib diisi.");
            if (!this.phone) this.errors.push("No. Telepon wajib diisi.");

            let dataDetail = this.detail;

            if (dataDetail.length > 0) {
                for (let index = 0; index < dataDetail.length; index++) {
                    if (!dataDetail[index].inventoryStock) {
                        this.errors.push(
                            "Stok pada baris ke-" +
                                (index + 1) +
                                " wajib diisi."
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
            } else {
                this.errors.push("Detail penjualan harus diinputkan.");
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
                    if (
                        response.status === "success" &&
                        response.code === "store-order-success"
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
