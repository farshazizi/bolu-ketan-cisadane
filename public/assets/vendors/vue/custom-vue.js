// Vue.config.devtools = false;
// Vue.config.debug = false;
// Vue.config.silent = true;

Vue.options.delimiters = ["{>", "<}"];

// var store = new Vuex.Store({
//     state: {
//         _token: "<php echo csrf_token(); ?>",
//         date: "",
//         to: "",
//         notes: "",
//         slipID: "",
//         station: "",
//         manifest: "",
//         masterBiaya: "",
//     },
//     getters: {
//         getToAddedQuiz: function (state) {
//             return state.toAddedQuiz;
//         },
//     },
//     mutations: {
//         BACK_ADDED_QUIZ: function (state, payload) {
//             state.toAddedQuiz.typeQuiz = null;
//         },
//     },
//     actions: {
//         CHANGE_ANSWER: function (state, payload) {
//             state.commit("UPDATE_ANSWER", payload);
//         },
//     },
// });

// https://jsfiddle.net/mani04/bgzhw68m/
function addZeroToMonth(month) {
    if (parseInt(month) < 10) {
        return "0" + month;
    }
    return month;
}

function updateFunction(el, binding) {
    // get options from binding value.
    // v-select="THIS-IS-THE-BINDING-VALUE"
    let options = binding.value || {};

    // set up select2
    $(el)
        .select2(options)
        .on("select2:select", function (e) {
            // v-model looks for
            //  - an event named "change"
            //  - a value with property path "$event.target.value"
            el.dispatchEvent(new Event("change", { target: e.target }));
        });
}

function numberFormat3digit(value) {
    return new Intl.NumberFormat("en-US", {
        // style: 'currency',
        // currency: 'USD',
        minimumFractionDigits: 3,
        maximumFractionDigits: 3,
    }).format(value);
}

function numberFix(value) {
    return new Intl.NumberFormat("en-US", {
        // style: 'currency',
        // currency: 'USD',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(value);
}

function alertWarning(text) {
    $.notify(
        {
            // options
            title: "<strong>Perhatian!</strong>",
            message: text,
        },
        {
            // settings
            type: "warning",
            placement: {
                from: "bottom",
                align: "center",
            },
            template:
                '<div data-notify="container" class="col-xs-12 col-sm-6 alert alert-{0}" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                '<span data-notify="icon"></span> ' +
                '<span data-notify="title">{1}</span> ' +
                '<span data-notify="message">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                "</div>" +
                '<a href="{3}" target="{4}" data-notify="url"></a>' +
                "</div>",
        }
    );
}

function broadcastEventSelect2() {
    $(".select2").on("select2:select", function (e) {
        // v-model looks for
        //  - an event named "change"
        //  - a value with property path "$event.target.value"
        this.dispatchEvent(new Event("change", { target: e.target }));
    });
}

Array.prototype.remove = function () {
    var what,
        a = arguments,
        L = a.length,
        ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};

Vue.directive("select", {
    inserted: updateFunction,
    componentUpdated: updateFunction,
});

// Vue.use(VMoney);

Vue.component("input-currency", {
    props: ["value", "padding"],
    template: `
            <input class="form-control text-right" type="text" v-model="displayValue" @blur="isInputActive = false" @focus="isInputActive = true"/>
                `,
    data: function () {
        return {
            isInputActive: false,
        };
    },
    computed: {
        displayValue: {
            get: function () {
                if (this.isInputActive) {
                    // Cursor is inside the input field. unformat display value for user
                    return this.value.toString();
                } else {
                    // User is not modifying now. Format display value for user interface
                    var padding = 0;

                    if (this.padding) {
                        padding = parseInt(this.padding);
                    }

                    return parseFloat(this.value)
                        .toFixed(padding)
                        .replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");
                }
            },
            set: function (modifiedValue) {
                // Recalculate value after ignoring "$" and "," in user input
                let newValue = parseFloat(
                    modifiedValue.replace(/[^\d\.]/g, "")
                );
                // Ensure that it is not NaN
                if (isNaN(newValue)) {
                    newValue = 0;
                }
                // Note: we cannot set this.value as it is a "prop". It needs to be passed to parent component
                // $emit the event so that parent component gets it
                this.$emit("input", newValue);
            },
        },
    },
});

Vue.component("input-number-max", {
    props: ["value", "maxValue", "disabled"],
    template: `
        <div class="input-group">
            <input :disabled="disabled" class="form-control text-right" type="text" v-model="displayValue" @keyup="checkMax" @keydown="checkMax" @keypress="checkMax" @blur="isInputActive = false" @focus="isInputActive = true"> 
            <div class="input-group-addon">Max {>this.$parent.$options.methods.numberFormat(maxValue)<}</div>
        </div>
    `,
    // v-bind:value="value" v-on:input="$emit('input', $event.target.value)"
    data: function () {
        return {
            isInputActive: false,
        };
    },
    computed: {
        displayValue: {
            get: function () {
                if (this.isInputActive) {
                    // Cursor is inside the input field. unformat display value for user
                    // if(this.value > this.maxValue) {
                    //     return this.maxValue.toString();
                    // }

                    return this.value.toString();
                } else {
                    // User is not modifying now. Format display value for user interface
                    return parseFloat(this.value)
                        .toFixed(2)
                        .replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");
                }
            },
            set: function (modifiedValue) {
                // Recalculate value after ignoring "$" and "," in user input
                let newValue = parseFloat(
                    modifiedValue.replace(/[^\d\.]/g, "")
                );

                // Ensure that it is not NaN
                if (isNaN(newValue)) {
                    newValue = 0;
                }

                // if(newValue > this.maxValue) {
                //     newValue = this.maxValue;
                // }

                // Note: we cannot set this.value as it is a "prop". It needs to be passed to parent component
                // $emit the event so that parent component gets it
                this.$emit("input", newValue);
            },
        },
    },
    methods: {
        checkMax: function () {
            if (parseFloat(this.displayValue) > parseFloat(this.maxValue)) {
                this.$emit("input", this.maxValue);
            }
        },
    },
});
