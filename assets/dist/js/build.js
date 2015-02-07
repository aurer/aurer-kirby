function addClass(a, b) {
    "use strict";
    var c = a.className, d = new RegExp("\\s?" + b + "\\s?");
    c.match(d) || (a.className += " " + b);
}

function removeClass(a, b) {
    "use strict";
    var c = new RegExp("\\s?" + b);
    a.className = a.className.replace(c, "");
}

function handleFixedNav() {
    "use strict";
    var a = (document.body.scrollHeight, window.screen.height, document.querySelector(".mast"), 
    document.body), b = 0;
    window.onscroll = function() {
        var c = document.body.scrollTop || document.documentElement.scrollTop || 0;
        if (document.body.scrollWidth > 700) {
            c > 40 ? addClass(a, "off-top") : removeClass(a, "off-top");
            var d = 2 + (c - 30) / 100;
            d > 6 && (d = 6), b = -c / d;
        }
    };
}

!function() {
    for (var a, b = function() {}, c = [ "assert", "clear", "count", "debug", "dir", "dirxml", "error", "exception", "group", "groupCollapsed", "groupEnd", "info", "log", "markTimeline", "profile", "profileEnd", "table", "time", "timeEnd", "timeStamp", "trace", "warn" ], d = c.length, e = window.console = window.console || {}; d--; ) a = c[d], 
    e[a] || (e[a] = b);
}(), function(a) {
    "function" == typeof define ? define(a) : "undefined" != typeof module ? module.exports = a : this.qwest = a;
}(function() {
    var win = window, limit = null, requests = 0, request_stack = [], getXHR = function() {
        return win.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    }, version2 = "" === getXHR().responseType, qwest = function(method, url, data, options, before) {
        data = data || null, options = options || {};
        var typeSupported = !1, xhr = getXHR(), async = void 0 === options.async ? !0 : !!options.async, cache = options.cache, type = options.type ? options.type.toLowerCase() : "json", user = options.user || "", password = options.password || "", headers = {
            "X-Requested-With": "XMLHttpRequest"
        }, accepts = {
            xml: "application/xml, text/xml",
            html: "text/html",
            json: "application/json, text/javascript",
            js: "application/javascript, text/javascript"
        }, toUpper = function(a, b, c) {
            return b + c.toUpperCase();
        }, vars = "", i, j, parseError = "parseError", serialized, success_stack = [], error_stack = [], complete_stack = [], response, success, error, func, promises = {
            success: function(a) {
                return async ? success_stack.push(a) : success && a.apply(xhr, [ response ]), promises;
            },
            error: function(a) {
                return async ? error_stack.push(a) : error && a.apply(xhr, [ response ]), promises;
            },
            complete: function(a) {
                return async ? complete_stack.push(a) : a.apply(xhr), promises;
            }
        }, promises_limit = {
            success: function(a) {
                return request_stack[request_stack.length - 1].success.push(a), promises_limit;
            },
            error: function(a) {
                return request_stack[request_stack.length - 1].error.push(a), promises_limit;
            },
            complete: function(a) {
                return request_stack[request_stack.length - 1].complete.push(a), promises_limit;
            }
        }, handleResponse = function() {
            var i, req, p;
            if (--requests, request_stack.length) {
                for (req = request_stack.shift(), p = qwest(req.method, req.url, req.data, req.options, req.before), 
                i = 0; func = req.success[i]; ++i) p.success(func);
                for (i = 0; func = req.error[i]; ++i) p.error(func);
                for (i = 0; func = req.complete[i]; ++i) p.complete(func);
            }
            try {
                if (!/^2/.test(xhr.status)) throw xhr.status + " (" + xhr.statusText + ")";
                var responseText = "responseText", responseXML = "responseXML";
                if (typeSupported && void 0 !== xhr.response) response = xhr.response; else switch (type) {
                  case "json":
                    try {
                        response = win.JSON ? win.JSON.parse(xhr[responseText]) : eval("(" + xhr[responseText] + ")");
                    } catch (e) {
                        throw "Error while parsing JSON body";
                    }
                    break;

                  case "js":
                    response = eval(xhr[responseText]);
                    break;

                  case "xml":
                    if (!xhr[responseXML] || xhr[responseXML][parseError] && xhr[responseXML][parseError].errorCode && xhr[responseXML][parseError].reason) throw "Error while parsing XML body";
                    response = xhr[responseXML];
                    break;

                  default:
                    response = xhr[responseText];
                }
                if (success = !0, async) for (i = 0; func = success_stack[i]; ++i) func.apply(xhr, [ response ]);
            } catch (e) {
                if (error = !0, response = "Request to '" + url + "' aborted: " + e, async) for (i = 0; func = error_stack[i]; ++i) func.apply(xhr, [ response ]);
            }
            if (async) for (i = 0; func = complete_stack[i]; ++i) func.apply(xhr);
        }, buildData = function(a, b) {
            var c = [], d = encodeURIComponent;
            if ("object" == typeof a && null != a) for (var e in a) a.hasOwnProperty(e) && (c = c.concat(buildData(a[e], b ? b + "[" + e + "]" : e))); else null != a && null != b && c.push(d(b) + "=" + d(a));
            return c.join("&");
        };
        if (limit && requests == limit) return request_stack.push({
            method: method,
            url: url,
            data: data,
            options: options,
            before: before,
            success: [],
            error: [],
            complete: []
        }), promises_limit;
        if (++requests, win.ArrayBuffer && (data instanceof ArrayBuffer || data instanceof Blob || data instanceof Document || data instanceof FormData) ? "GET" == method && (data = null) : (data = buildData(data), 
        serialized = !0), "GET" == method && (vars += data), null == cache && (cache = "POST" == method), 
        cache || (vars && (vars += "&"), vars += "__t=" + Date.now()), vars && (url += (/\?/.test(url) ? "&" : "?") + vars), 
        xhr.open(method, url, async, user, password), type && version2) try {
            xhr.responseType = type, typeSupported = xhr.responseType == type;
        } catch (e) {}
        version2 ? xhr.onload = handleResponse : xhr.onreadystatechange = function() {
            4 == xhr.readyState && handleResponse();
        };
        for (i in headers) j = i.replace(/(^|-)([^-])/g, toUpper), headers[j] = headers[i], 
        delete headers[i], xhr.setRequestHeader(j, headers[j]);
        return !headers["Content-Type"] && serialized && "POST" == method && xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"), 
        headers.Accept || xhr.setRequestHeader("Accept", accepts[type]), before && before.apply(xhr), 
        xhr.send("POST" == method ? data : null), promises;
    };
    return {
        get: function(a, b, c, d) {
            return qwest("GET", a, b, c, d);
        },
        post: function(a, b, c, d) {
            return qwest("POST", a, b, c, d);
        },
        xhr2: version2,
        limit: function(a) {
            limit = a;
        }
    };
}()), Appreciation = {
    init: function(a) {
        this.ele = document.querySelector(a), this.ele && (this.button = this.ele.querySelector(".btn--appreciate"), 
        this.bindEvents());
    },
    bindEvents: function() {
        this.button.onclick = function(a) {
            Appreciation.addEntry();
            a.preventDefault();
        };
    },
    addEntry: function() {
        var a = this.button, b = a.getAttribute("data-page_id");
        qwest.post("/appreciate", {
            page_id: b
        }, {
            responseType: "json"
        }).success(function() {
            a.innerText = "Thank you!", a.className += " appreciated";
        });
    }
}, Appreciation.init("button.appreciate"), function() {
    "use strict";
    handleFixedNav();
}();