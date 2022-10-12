Vue.component("date-picker", VueBootstrapDatetimePicker);
var app = new Vue({
    el: "#app",
    delimiters: ["{>", "<}"],
    data: {
        orderId: "",
        indexDetail: 0,
        date: new Date().toISOString().slice(0, 10),
        name: "",
        address: "",
        phone: "",
        notes: "",
        grandTotal: 0,
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
        vm.addSale();

        if (Object.keys(dataOrder).length !== 0) {
            if (dataOrder.order) {
                let order = dataOrder.order;
                // Set data header
                vm.orderId = order.id;
                vm.date = order.date;
                vm.name = order.name;
                vm.address = order.address;
                vm.phone = order.phone;
                vm.notes = order.notes;

                // Set data detail
                let orderDetails = order.order_details;
                for (let index = 0; index < orderDetails.length; index++) {
                    var objectDetail = {
                        keyDetail: index,
                        inventoryStock: orderDetails[index].inventory_stock_id,
                        stock: 0,
                        quantity: orderDetails[index].quantity,
                        price: orderDetails[index].price,
                        discount: 0,
                        total: orderDetails[index].total,
                        totalAdditional: orderDetails[index].total_additional,
                        notes: orderDetails[index].notes,
                    };
                    vm.$set(vm.detail, index, objectDetail);
                    vm.getStock(index);

                    let orderAdditionalDetils =
                        orderDetails[index].order_additional_details;
                    let detailAdditionalLength = vm.detailAdditional.length;
                    for (
                        let indexAdditional = 0;
                        indexAdditional < orderAdditionalDetils.length;
                        indexAdditional++
                    ) {
                        var objectAdditionalDetail = {
                            additionalId:
                                orderAdditionalDetils[indexAdditional]
                                    .additional.id,
                            additionalName:
                                orderAdditionalDetils[indexAdditional]
                                    .additional.name,
                            keyDetail: index,
                            price: orderAdditionalDetils[indexAdditional].price,
                        };

                        vm.$set(
                            vm.detailAdditional,
                            detailAdditionalLength,
                            objectAdditionalDetail
                        );
                        detailAdditionalLength++;
                    }

                    // Show field
                    $(".order").show();
                }
            }
        }

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

            $("body").on("change", "#discount", function (event) {
                let index = $(event.target).attr("index");
                let value = $(event.target).val();
                let quantity = vm.detail[index].quantity;
                let price = vm.detail[index].price;
                let total = quantity * price - value;

                vm.$set(vm.detail[index], "total", total);
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

            if (this.detail.length > 0) {
                for (let index = 0; index < this.detail.length; index++) {
                    grandTotal += parseFloat(
                        this.detail[index].total +
                            this.detail[index].totalAdditional
                    );
                }
            }

            this.grandTotal = grandTotal;

            return grandTotal;
        },
    },
    methods: {
        addSale: function () {
            if (this.detail.length > 0) {
                let dataDetail = {
                    keyDetail: this.detail.length,
                    inventoryStock: "",
                    stock: 0,
                    quantity: 0,
                    price: 0,
                    discount: 0,
                    total: 0,
                    totalAdditional: 0,
                    notes: "",
                };
                this.detail.push(dataDetail);
            } else {
                let dataDetail = {
                    keyDetail: 0,
                    inventoryStock: "",
                    stock: 0,
                    quantity: 0,
                    price: 0,
                    discount: 0,
                    total: 0,
                    totalAdditional: 0,
                    notes: "",
                };
                this.detail.push(dataDetail);
            }
        },
        deleteDetail: function (index) {
            let keyDetail = this.detail[index].keyDetail;
            this.detail.splice(index, 1);
            this.deleteAllDetailAdditional(keyDetail);
        },
        deleteAllDetailAdditional: function (keyDetail) {
            let dataDetailAdditional = [];
            let newIndex = 0;

            if (this.detail.length > 0) {
                for (let key = 0; key < this.detailAdditional.length; key++) {
                    if (this.detailAdditional[key].keyDetail !== keyDetail) {
                        dataDetailAdditional[newIndex] =
                            this.detailAdditional[key];
                        newIndex++;
                    }
                }

                if (dataDetailAdditional.length > 0) {
                    this.detailAdditional = [];
                    for (
                        let key = 0;
                        key < dataDetailAdditional.length;
                        key++
                    ) {
                        this.detailAdditional[key] = dataDetailAdditional[key];
                    }
                }
            } else {
                this.detailAdditional = [];
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
        getStock: function (index) {
            let dataDetail = this.detail[index];
            let inventoryId = dataDetail.inventoryStock;
            let url = getStockRoute.replace(":id", inventoryId);

            $.ajax({
                url: url,
                type: "GET",
                dataType: "JSON",
                success: function (response) {
                    let stock = response.data.stock;
                    dataDetail.stock = stock;

                    if (stock == 0) {
                        Swal.fire({
                            icon: "warning",
                            text: "Stok barang 0.",
                            showConfirmButton: false,
                        });
                    }
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
                    if (dataDetail[index].stock == 0) {
                        this.errors.push(
                            "Jumlah Stok pada baris ke-" +
                                (index + 1) +
                                " kosong."
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
                        response.code === "store-sale-success"
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
                    window.location.href = indexRoute;
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
