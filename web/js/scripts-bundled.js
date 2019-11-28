/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./web/js/scripts.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./web/js/modules/Input.js":
/*!*********************************!*\
  !*** ./web/js/modules/Input.js ***!
  \*********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\nvar Input =\n/*#__PURE__*/\nfunction () {\n  function Input() {\n    _classCallCheck(this, Input);\n\n    this.step = 1;\n    this.numberEl = $(\"#number_mask\");\n    this.numberSendEl = $(\"#number_send\");\n    this.codeEl = $(\"#code_mask\");\n    this.codeSendEl = $(\"#code_send\");\n    this.stepBackEl = $(\"#step_back\");\n    this.events();\n    this.validation();\n    this.ajax();\n  }\n\n  _createClass(Input, [{\n    key: \"events\",\n    value: function events() {\n      var _this = this;\n\n      document.addEventListener(\"DOMContentLoaded\", function () {\n        _this.numberEl.inputmask({\n          \"mask\": \"+ 999 999 999 999\"\n        });\n\n        _this.codeEl.inputmask({\n          \"mask\": \"9 9 9 9 9 9\"\n        });\n\n        _this.numberSendEl.attr(\"disabled\", true);\n\n        _this.codeSendEl.attr(\"disabled\", true);\n      });\n      this.stepBackEl.on(\"click\", function () {\n        _this.step = 1;\n        $(\".pari-match__form--number\").addClass(\"pari-match__form--active\");\n        $(\".pari-match__form--code\").removeClass(\"pari-match__form--active\");\n        $(\"#user_id\").val(\"\");\n        $(\"#user_password\").val(\"\");\n        $(\"#user_number\").val(\"\");\n      });\n    }\n  }, {\n    key: \"validation\",\n    value: function validation() {\n      var _this2 = this;\n\n      this.numberEl.on(\"input\", function () {\n        var el = _this2.numberEl;\n\n        if (el.val() == \"\") {\n          el.removeClass('texted');\n        } else {\n          el.addClass('texted');\n        }\n\n        if (el.val().replace(/\\D/g, '')) {\n          el.siblings(\".input__status\").removeClass(\"input__status--error\");\n        }\n\n        if (el.val().replace(/\\D/g, '').length === 12) {\n          _this2.numberSendEl.attr(\"disabled\", false);\n        } else {\n          _this2.numberSendEl.attr(\"disabled\", true);\n        }\n      });\n      this.codeEl.on(\"input\", function () {\n        var el = _this2.codeEl;\n\n        if (el.val() == \"\") {\n          el.removeClass('texted');\n        } else {\n          el.addClass('texted');\n        }\n\n        if (el.val().replace(/\\D/g, '')) {\n          el.siblings(\".input__status\").removeClass(\"input__status--error\");\n        }\n\n        if (el.val().replace(/\\D/g, '').length === 6) {\n          _this2.codeSendEl.attr(\"disabled\", false);\n        } else {\n          _this2.codeSendEl.attr(\"disabled\", true);\n        }\n      });\n      $(document).on(\"click\", \".input__status--error\", function (e) {\n        $(this).siblings(\".input__el\").val(\"\");\n        $(this).removeClass(\"input__status--error\");\n      });\n    }\n  }, {\n    key: \"ajax\",\n    value: function ajax() {\n      var _this3 = this;\n\n      this.numberSendEl.on('click', function (e) {\n        e.preventDefault();\n\n        if (_this3.step !== 1) {\n          return;\n        }\n\n        _this3.numberSendEl.attr(\"disabled\", true);\n\n        var data = {\n          ref: _this3.getAllUrlParams(window.location.href).ref,\n          number: _this3.numberEl.val().replace(/\\D/g, '')\n        };\n        var formData = new FormData();\n        formData.append(\"ref\", data.ref);\n        formData.append(\"number\", data.number);\n        console.log(data);\n        $.ajax({\n          type: \"POST\",\n          url: \"/site/register\",\n          cache: false,\n          processData: false,\n          dataType: 'json',\n          contentType: false,\n          data: formData,\n          success: function success(msg) {\n            console.log(msg);\n\n            if (msg.status == \"ok\") {\n              _this3.numberSendEl.siblings(\".input__status\").removeClass(\".input__status--error\");\n\n              $(\".pari-match__form--number\").removeClass(\"pari-match__form--active\");\n              $(\".pari-match__form--code\").addClass(\"pari-match__form--active\");\n              _this3.step = 2;\n\n              _this3.numberSendEl.siblings(\".input\").find(\".input__status\").removeClass(\"input__status--error\");\n\n              _this3.numberSendEl.siblings(\".input\").find(\".input__status\").addClass(\"input__status--success\"); // msg.data.userId\n\n\n              $(\"#user_id\").val(msg.userId);\n              $(\"#user_password\").val(msg.password);\n              $(\"#user_number\").val(msg.number);\n            } else {\n              _this3.numberSendEl.siblings(\".input\").find(\".input__status\").addClass(\"input__status--error\");\n            }\n          }\n        }).always(function () {\n          _this3.numberSendEl.attr(\"disabled\", false);\n        });\n      });\n      this.codeSendEl.on(\"click\", function (e) {\n        e.preventDefault();\n\n        if (_this3.step !== 2) {\n          return;\n        }\n\n        _this3.codeSendEl.attr(\"disabled\", true);\n\n        var data = {\n          code: _this3.codeEl.val().replace(/\\D/g, ''),\n          user_id: $(\"#user_id\").val(),\n          password: $(\"#user_password\").val(),\n          number: $(\"#user_number\").val()\n        };\n        var formData = new FormData();\n        formData.append(\"code\", data.code);\n        formData.append(\"user_id\", data.user_id);\n        console.log(data);\n        $.ajax({\n          type: \"POST\",\n          url: \"/site/check\",\n          cache: false,\n          processData: false,\n          dataType: 'json',\n          contentType: false,\n          data: formData,\n          success: function success(msg) {\n            console.log(msg);\n\n            if (msg.status == \"ok\") {\n              _this3.codeSendEl.siblings(\".input\").find(\".input__status\").removeClass(\"input__status--error\");\n\n              _this3.codeSendEl.siblings(\".input\").find(\".input__status\").addClass(\"input__status--success\");\n\n              $(\"#complete\").addClass(\"complete--show\"); // more anim\n            } else {\n              _this3.codeSendEl.siblings(\".input\").find(\".input__status\").addClass(\"input__status--error\");\n            }\n          }\n        }).always(function () {\n          _this3.codeSendEl.attr(\"disabled\", false);\n        });\n      });\n    }\n  }, {\n    key: \"getAllUrlParams\",\n    value: function getAllUrlParams(url) {\n      // get query string from url (optional) or window\n      var queryString = url ? url.split('?')[1] : window.location.search.slice(1); // we'll store the parameters here\n\n      var obj = {}; // if query string exists\n\n      if (queryString) {\n        // stuff after # is not part of query string, so get rid of it\n        queryString = queryString.split('#')[0]; // split our query string into its component parts\n\n        var arr = queryString.split('&');\n\n        for (var i = 0; i < arr.length; i++) {\n          // separate the keys and the values\n          var a = arr[i].split('='); // set parameter name and value (use 'true' if empty)\n\n          var paramName = a[0];\n          var paramValue = typeof a[1] === 'undefined' ? true : a[1]; // (optional) keep case consistent\n\n          paramName = paramName.toLowerCase();\n          if (typeof paramValue === 'string') paramValue = paramValue.toLowerCase(); // if the paramName ends with square brackets, e.g. colors[] or colors[2]\n\n          if (paramName.match(/\\[(\\d+)?\\]$/)) {\n            // create key if it doesn't exist\n            var key = paramName.replace(/\\[(\\d+)?\\]/, '');\n            if (!obj[key]) obj[key] = []; // if it's an indexed array e.g. colors[2]\n\n            if (paramName.match(/\\[\\d+\\]$/)) {\n              // get the index value and add the entry at the appropriate position\n              var index = /\\[(\\d+)\\]/.exec(paramName)[1];\n              obj[key][index] = paramValue;\n            } else {\n              // otherwise add the value to the end of the array\n              obj[key].push(paramValue);\n            }\n          } else {\n            // we're dealing with a string\n            if (!obj[paramName]) {\n              // if it doesn't exist, create property\n              obj[paramName] = paramValue;\n            } else if (obj[paramName] && typeof obj[paramName] === 'string') {\n              // if property does exist and it's a string, convert it to an array\n              obj[paramName] = [obj[paramName]];\n              obj[paramName].push(paramValue);\n            } else {\n              // otherwise add the property\n              obj[paramName].push(paramValue);\n            }\n          }\n        }\n      }\n\n      return obj;\n    }\n  }]);\n\n  return Input;\n}();\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (Input);\n\n//# sourceURL=webpack:///./web/js/modules/Input.js?");

/***/ }),

/***/ "./web/js/scripts.js":
/*!***************************!*\
  !*** ./web/js/scripts.js ***!
  \***************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _modules_Input__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modules/Input */ \"./web/js/modules/Input.js\");\n// 3rd party packages from NPM\n// import $ from \"jquery\";\n// import WOW from \"wowjs\";\n// import tocca from \"tocca\";\n// Our modules / classes\n // Instantiate a new object using our modules/classes\n\nvar main = new _modules_Input__WEBPACK_IMPORTED_MODULE_0__[\"default\"]();\n\n//# sourceURL=webpack:///./web/js/scripts.js?");

/***/ })

/******/ });