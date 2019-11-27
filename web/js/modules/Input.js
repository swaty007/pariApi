class Input {
    constructor() {
        this.step = 0;
        this.numberEl = $("#number_mask");
        this.numberSendEl = $("#number_send");
        this.codeEl = $("#code_mask");
        this.codeSendEl = $("#code_send");
        this.events();
        this.validation();
        this.ajax();
    }
    events() {
        document.addEventListener("DOMContentLoaded", () => {
            this.numberEl.inputmask({"mask": "+ 999 999 999 999"});
            this.codeEl.inputmask({"mask": "9 9 9 9"});

        });
    }
    validation() {
        this.numberEl.on("input", function () {
            if ($(this).val() == "") {
                $(this).removeClass('texted');
            } else {
                $(this).addClass('texted');
            }
            console.log($(this).val());
            console.log();
        });
        this.codeEl.on("input", function () {
            if ($(this).val() == "") {
                $(this).removeClass('texted');
            } else {
                $(this).addClass('texted');
            }
        });
        $(document).on("click",".input__status--error", function (e) {
            $(this).siblings(".input__el").val("");
            $(this).removeClass("input__status--error");
        });
    }
    ajax() {
        this.numberSendEl.on('click', (e) => {
            e.preventDefault();
            let data = {
                ref: this.getAllUrlParams(window.location.href).ref,
                number: this.numberEl.val().replace(/\D/g,''),
            };
            let formData = new FormData();
            formData.append("ref", data.ref);
            formData.append("number", data.number);

            console.log(data);

            $.ajax({
                type: "POST",
                url: "/site/register",
                cache : false,
                processData: false,
                dataType: 'json',
                contentType: false,
                data: formData,
                success: (msg) => {
                    console.log(msg);

                    if( msg.status == "ok" ) {
                        this.numberSendEl.siblings(".input__status").removeClass(".input__status--error");
                        $(".pari-match__form--number").removeClass("pari-match__form--active");
                        $(".pari-match__form--code").addClass("pari-match__form--active");
                        this.numberSendEl.siblings(".input").find(".input__status").removeClass("input__status--error");
                        this.numberSendEl.siblings(".input").find(".input__status").addClass("input__status--success");
                    } else {
                        this.numberSendEl.siblings(".input").find(".input__status").addClass("input__status--error");
                    }
                }
            })

        });
        this.codeSendEl.on("click", (e) => {
            e.preventDefault();

            let data = {
                code: this.codeEl.val().replace(/\D/g,''),
                user_id: "",
            };
            let formData = new FormData();
            formData.append("code", data.code);
            formData.append("user_id", data.user_id);

            console.log(data);

            $.ajax({
                type: "POST",
                url: "/site/check",
                cache : false,
                processData: false,
                dataType: 'json',
                contentType: false,
                data: formData,
                success: (msg) => {
                    console.log(msg);
                    if( msg.status == "ok" ) {
                        this.codeSendEl.siblings(".input").find(".input__status").removeClass("input__status--error");
                        this.codeSendEl.siblings(".input").find(".input__status").addClass("input__status--success");
                        // more anim
                    } else {
                        this.codeSendEl.siblings(".input").find(".input__status").addClass("input__status--error");
                    }

                }
            })
        });
    }
    getAllUrlParams(url) {

        // get query string from url (optional) or window
        var queryString = url ? url.split('?')[1] : window.location.search.slice(1);

        // we'll store the parameters here
        var obj = {};

        // if query string exists
        if (queryString) {

            // stuff after # is not part of query string, so get rid of it
            queryString = queryString.split('#')[0];

            // split our query string into its component parts
            var arr = queryString.split('&');

            for (var i = 0; i < arr.length; i++) {
                // separate the keys and the values
                var a = arr[i].split('=');

                // set parameter name and value (use 'true' if empty)
                var paramName = a[0];
                var paramValue = typeof (a[1]) === 'undefined' ? true : a[1];

                // (optional) keep case consistent
                paramName = paramName.toLowerCase();
                if (typeof paramValue === 'string') paramValue = paramValue.toLowerCase();

                // if the paramName ends with square brackets, e.g. colors[] or colors[2]
                if (paramName.match(/\[(\d+)?\]$/)) {

                    // create key if it doesn't exist
                    var key = paramName.replace(/\[(\d+)?\]/, '');
                    if (!obj[key]) obj[key] = [];

                    // if it's an indexed array e.g. colors[2]
                    if (paramName.match(/\[\d+\]$/)) {
                        // get the index value and add the entry at the appropriate position
                        var index = /\[(\d+)\]/.exec(paramName)[1];
                        obj[key][index] = paramValue;
                    } else {
                        // otherwise add the value to the end of the array
                        obj[key].push(paramValue);
                    }
                } else {
                    // we're dealing with a string
                    if (!obj[paramName]) {
                        // if it doesn't exist, create property
                        obj[paramName] = paramValue;
                    } else if (obj[paramName] && typeof obj[paramName] === 'string'){
                        // if property does exist and it's a string, convert it to an array
                        obj[paramName] = [obj[paramName]];
                        obj[paramName].push(paramValue);
                    } else {
                        // otherwise add the property
                        obj[paramName].push(paramValue);
                    }
                }
            }
        }

        return obj;
    }
}

export default Input;