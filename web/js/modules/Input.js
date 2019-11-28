class Input {
    constructor() {
        this.step = $("#step_one").hasClass("pari-match__form--active") ? 1 : 2;
        this.numberEl = $("#number_mask");
        this.numberSendEl = $("#number_send");
        this.codeEl = $("#code_mask");
        this.codeSendEl = $("#code_send");
        this.stepBackEl = $("#step_back");
        this.events();
        this.validation();
        this.ajax();
    }
    events() {
        document.addEventListener("DOMContentLoaded", () => {
            this.numberEl.inputmask({"mask": "+ 999 999 999 999"});
            this.codeEl.inputmask({"mask": "9 9 9 9 9 9"});
            this.numberSendEl.attr("disabled", true);
            this.codeSendEl.attr("disabled", true);
        });
        this.stepBackEl.on("click", () => {
            this.step = 1;
            $(".pari-match__form--number").addClass("pari-match__form--active");
            $(".pari-match__form--code").removeClass("pari-match__form--active");
            $("#user_id").val("");
            $("#user_password").val("");
            $("#user_number").val("");
        });
    }
    validation() {
        this.numberEl.on("input", () => {
            let el = this.numberEl;
            if (el.val() == "") {
                el.removeClass('texted');
            } else {
                el.addClass('texted');
            }
            if (el.val().replace(/\D/g,'')) {
                el.siblings(".input__status").removeClass("input__status--error");
            }
            if (el.val().replace(/\D/g,'').length === 12) {
                this.numberSendEl.attr("disabled", false);
            } else {
                this.numberSendEl.attr("disabled", true);
            }
        });
        this.codeEl.on("input", () => {
            let el = this.codeEl;
            if (el.val() == "") {
                el.removeClass('texted');
            } else {
                el.addClass('texted');
            }
            if (el.val().replace(/\D/g,'')) {
                el.siblings(".input__status").removeClass("input__status--error");
            }
            if (el.val().replace(/\D/g,'').length === 6) {
                this.codeSendEl.attr("disabled", false);
            } else {
                this.codeSendEl.attr("disabled", true);
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
            if (this.step !== 1) {
                return;
            }
            this.numberSendEl.attr("disabled", true);
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
                        this.step = 2;
                        this.numberSendEl.siblings(".input").find(".input__status").removeClass("input__status--error");
                        this.numberSendEl.siblings(".input").find(".input__status").addClass("input__status--success");
                        // msg.data.userId
                        $("#user_id").val(msg.userId);
                        $("#user_password").val(msg.password);
                        $("#user_number").val(msg.number);
                    } else {
                        this.numberSendEl.siblings(".input").find(".input__status").addClass("input__status--error");
                    }
                }
            }).always(() => {
                this.numberSendEl.attr("disabled", false);
            });

        });
        this.codeSendEl.on("click", (e) => {
            e.preventDefault();
            if (this.step !== 2) {
                return;
            }
            this.codeSendEl.attr("disabled", true);
            let data = {
                code: this.codeEl.val().replace(/\D/g,''),
                user_id: $("#user_id").val(),
                password: $("#user_password").val(),
                number: $("#user_number").val()
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
                        $("#complete").addClass("complete--show");
                    } else {
                        this.codeSendEl.siblings(".input").find(".input__status").addClass("input__status--error");
                    }
                }
            }).always(() => {
                this.codeSendEl.attr("disabled", false);
            });
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