window.Modernizr = function(e, t, n) {
        function r(e) {
            y.cssText = e
        }

        function o(e, t) {
            return typeof e === t
        }

        function i(e, t) {
            return !!~("" + e).indexOf(t)
        }

        function a(e, t) {
            for (var r in e) {
                var o = e[r];
                if (!i(o, "-") && y[o] !== n) return "pfx" == t ? o : !0
            }
            return !1
        }

        function c(e, t, r) {
            for (var i in e) {
                var a = t[e[i]];
                if (a !== n) return r === !1 ? e[i] : o(a, "function") ? a.bind(r || t) : a
            }
            return !1
        }

        function s(e, t, n) {
            var r = e.charAt(0).toUpperCase() + e.slice(1),
                i = (e + " " + w.join(r + " ") + r).split(" ");
            return o(t, "string") || o(t, "undefined") ? a(i, t) : (i = (e + " " + C.join(r + " ") + r).split(" "), c(i, t, n))
        }
        var u, l, f, d = "2.8.2",
            p = {},
            m = !0,
            h = t.documentElement,
            v = "modernizr",
            g = t.createElement(v),
            y = g.style,
            b = ({}.toString, " -webkit- -moz- -o- -ms- ".split(" ")),
            E = "Webkit Moz O ms",
            w = E.split(" "),
            C = E.toLowerCase().split(" "),
            S = {
                svg: "http://www.w3.org/2000/svg"
            },
            j = {},
            x = [],
            N = x.slice,
            k = function(e, n, r, o) {
                var i, a, c, s, u = t.createElement("div"),
                    l = t.body,
                    f = l || t.createElement("body");
                if (parseInt(r, 10))
                    for (; r--;) c = t.createElement("div"), c.id = o ? o[r] : v + (r + 1), u.appendChild(c);
                return i = ["&#173;", '<style id="s', v, '">', e, "</style>"].join(""), u.id = v, (l ? u : f).innerHTML += i, f.appendChild(u), l || (f.style.background = "", f.style.overflow = "hidden", s = h.style.overflow, h.style.overflow = "hidden", h.appendChild(f)), a = n(u, e), l ? u.parentNode.removeChild(u) : (f.parentNode.removeChild(f), h.style.overflow = s), !!a
            },
            T = function() {
                function e(e, i) {
                    i = i || t.createElement(r[e] || "div"), e = "on" + e;
                    var a = e in i;
                    return a || (i.setAttribute || (i = t.createElement("div")), i.setAttribute && i.removeAttribute && (i.setAttribute(e, ""), a = o(i[e], "function"), o(i[e], "undefined") || (i[e] = n), i.removeAttribute(e))), i = null, a
                }
                var r = {
                    select: "input",
                    change: "input",
                    submit: "form",
                    reset: "form",
                    error: "img",
                    load: "img",
                    abort: "img"
                };
                return e
            }(),
            F = {}.hasOwnProperty;
        f = o(F, "undefined") || o(F.call, "undefined") ? function(e, t) {
            return t in e && o(e.constructor.prototype[t], "undefined")
        } : function(e, t) {
            return F.call(e, t)
        }, Function.prototype.bind || (Function.prototype.bind = function(e) {
            var t = this;
            if ("function" != typeof t) throw new TypeError;
            var n = N.call(arguments, 1),
                r = function() {
                    if (this instanceof r) {
                        var o = function() {};
                        o.prototype = t.prototype;
                        var i = new o,
                            a = t.apply(i, n.concat(N.call(arguments)));
                        return Object(a) === a ? a : i
                    }
                    return t.apply(e, n.concat(N.call(arguments)))
                };
            return r
        }), j.touch = function() {
            var n;
            return "ontouchstart" in e || e.DocumentTouch && t instanceof DocumentTouch ? n = !0 : k(["@media (", b.join("touch-enabled),("), v, ")", "{#modernizr{top:9px;position:absolute}}"].join(""), function(e) {
                n = 9 === e.offsetTop
            }), n
        }, j.rgba = function() {
            return r("background-color:rgba(150,255,150,.5)"), i(y.backgroundColor, "rgba")
        }, j.backgroundsize = function() {
            return s("backgroundSize")
        }, j.borderimage = function() {
            return s("borderImage")
        }, j.borderradius = function() {
            return s("borderRadius")
        }, j.csstransforms = function() {
            return !!s("transform")
        }, j.csstransforms3d = function() {
            var e = !!s("perspective");
            return e && "webkitPerspective" in h.style && k("@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}", function(t) {
                e = 9 === t.offsetLeft && 3 === t.offsetHeight
            }), e
        }, j.csstransitions = function() {
            return s("transition")
        }, j.svg = function() {
            return !!t.createElementNS && !!t.createElementNS(S.svg, "svg").createSVGRect
        };
        for (var z in j) f(j, z) && (l = z.toLowerCase(), p[l] = j[z](), x.push((p[l] ? "" : "no-") + l));
        return p.addTest = function(e, t) {
                if ("object" == typeof e)
                    for (var r in e) f(e, r) && p.addTest(r, e[r]);
                else {
                    if (e = e.toLowerCase(), p[e] !== n) return p;
                    t = "function" == typeof t ? t() : t, "undefined" != typeof m && m && (h.className += " " + (t ? "" : "no-") + e), p[e] = t
                }
                return p
            }, r(""), g = u = null,
            function(e, t) {
                function n(e, t) {
                    var n = e.createElement("p"),
                        r = e.getElementsByTagName("head")[0] || e.documentElement;
                    return n.innerHTML = "x<style>" + t + "</style>", r.insertBefore(n.lastChild, r.firstChild)
                }

                function r() {
                    var e = y.elements;
                    return "string" == typeof e ? e.split(" ") : e
                }

                function o(e) {
                    var t = g[e[h]];
                    return t || (t = {}, v++, e[h] = v, g[v] = t), t
                }

                function i(e, n, r) {
                    if (n || (n = t), l) return n.createElement(e);
                    r || (r = o(n));
                    var i;
                    return i = r.cache[e] ? r.cache[e].cloneNode() : m.test(e) ? (r.cache[e] = r.createElem(e)).cloneNode() : r.createElem(e), !i.canHaveChildren || p.test(e) || i.tagUrn ? i : r.frag.appendChild(i)
                }

                function a(e, n) {
                    if (e || (e = t), l) return e.createDocumentFragment();
                    n = n || o(e);
                    for (var i = n.frag.cloneNode(), a = 0, c = r(), s = c.length; s > a; a++) i.createElement(c[a]);
                    return i
                }

                function c(e, t) {
                    t.cache || (t.cache = {}, t.createElem = e.createElement, t.createFrag = e.createDocumentFragment, t.frag = t.createFrag()), e.createElement = function(n) {
                        return y.shivMethods ? i(n, e, t) : t.createElem(n)
                    }, e.createDocumentFragment = Function("h,f", "return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&(" + r().join().replace(/[\w\-]+/g, function(e) {
                        return t.createElem(e), t.frag.createElement(e), 'c("' + e + '")'
                    }) + ");return n}")(y, t.frag)
                }

                function s(e) {
                    e || (e = t);
                    var r = o(e);
                    return y.shivCSS && !u && !r.hasCSS && (r.hasCSS = !!n(e, "article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")), l || c(e, r), e
                }
                var u, l, f = "3.7.0",
                    d = e.html5 || {},
                    p = /^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,
                    m = /^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,
                    h = "_html5shiv",
                    v = 0,
                    g = {};
                ! function() {
                    try {
                        var e = t.createElement("a");
                        e.innerHTML = "<xyz></xyz>", u = "hidden" in e, l = 1 == e.childNodes.length || function() {
                            t.createElement("a");
                            var e = t.createDocumentFragment();
                            return "undefined" == typeof e.cloneNode || "undefined" == typeof e.createDocumentFragment || "undefined" == typeof e.createElement
                        }()
                    } catch (n) {
                        u = !0, l = !0
                    }
                }();
                var y = {
                    elements: d.elements || "abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output progress section summary template time video",
                    version: f,
                    shivCSS: d.shivCSS !== !1,
                    supportsUnknownElements: l,
                    shivMethods: d.shivMethods !== !1,
                    type: "default",
                    shivDocument: s,
                    createElement: i,
                    createDocumentFragment: a
                };
                e.html5 = y, s(t)
            }(this, t), p._version = d, p._prefixes = b, p._domPrefixes = C, p._cssomPrefixes = w, p.hasEvent = T, p.testProp = function(e) {
                return a([e])
            }, p.testAllProps = s, p.testStyles = k, p.prefixed = function(e, t, n) {
                return t ? s(e, t, n) : s(e, "pfx")
            }, h.className = h.className.replace(/(^|\s)no-js(\s|$)/, "$1$2") + (m ? " js " + x.join(" ") : ""), p
    }(this, this.document),
    function(e, t, n) {
        function r(e) {
            return "[object Function]" == v.call(e)
        }

        function o(e) {
            return "string" == typeof e
        }

        function i() {}

        function a(e) {
            return !e || "loaded" == e || "complete" == e || "uninitialized" == e
        }

        function c() {
            var e = g.shift();
            y = 1, e ? e.t ? m(function() {
                ("c" == e.t ? d.injectCss : d.injectJs)(e.s, 0, e.a, e.x, e.e, 1)
            }, 0) : (e(), c()) : y = 0
        }

        function s(e, n, r, o, i, s, u) {
            function l(t) {
                if (!p && a(f.readyState) && (b.r = p = 1, !y && c(), f.onload = f.onreadystatechange = null, t)) {
                    "img" != e && m(function() {
                        w.removeChild(f)
                    }, 50);
                    for (var r in N[n]) N[n].hasOwnProperty(r) && N[n][r].onload()
                }
            }
            var u = u || d.errorTimeout,
                f = t.createElement(e),
                p = 0,
                v = 0,
                b = {
                    t: r,
                    s: n,
                    e: i,
                    a: s,
                    x: u
                };
            1 === N[n] && (v = 1, N[n] = []), "object" == e ? f.data = n : (f.src = n, f.type = e), f.width = f.height = "0", f.onerror = f.onload = f.onreadystatechange = function() {
                l.call(this, v)
            }, g.splice(o, 0, b), "img" != e && (v || 2 === N[n] ? (w.insertBefore(f, E ? null : h), m(l, u)) : N[n].push(f))
        }

        function u(e, t, n, r, i) {
            return y = 0, t = t || "j", o(e) ? s("c" == t ? S : C, e, t, this.i++, n, r, i) : (g.splice(this.i++, 0, e), 1 == g.length && c()), this
        }

        function l() {
            var e = d;
            return e.loader = {
                load: u,
                i: 0
            }, e
        }
        var f, d, p = t.documentElement,
            m = e.setTimeout,
            h = t.getElementsByTagName("script")[0],
            v = {}.toString,
            g = [],
            y = 0,
            b = "MozAppearance" in p.style,
            E = b && !!t.createRange().compareNode,
            w = E ? p : h.parentNode,
            p = e.opera && "[object Opera]" == v.call(e.opera),
            p = !!t.attachEvent && !p,
            C = b ? "object" : p ? "script" : "img",
            S = p ? "script" : C,
            j = Array.isArray || function(e) {
                return "[object Array]" == v.call(e)
            },
            x = [],
            N = {},
            k = {
                timeout: function(e, t) {
                    return t.length && (e.timeout = t[0]), e
                }
            };
        d = function(e) {
            function t(e) {
                var t, n, r, e = e.split("!"),
                    o = x.length,
                    i = e.pop(),
                    a = e.length,
                    i = {
                        url: i,
                        origUrl: i,
                        prefixes: e
                    };
                for (n = 0; a > n; n++) r = e[n].split("="), (t = k[r.shift()]) && (i = t(i, r));
                for (n = 0; o > n; n++) i = x[n](i);
                return i
            }

            function a(e, o, i, a, c) {
                var s = t(e),
                    u = s.autoCallback;
                s.url.split(".").pop().split("?").shift(), s.bypass || (o && (o = r(o) ? o : o[e] || o[a] || o[e.split("/").pop().split("?")[0]]), s.instead ? s.instead(e, o, i, a, c) : (N[s.url] ? s.noexec = !0 : N[s.url] = 1, i.load(s.url, s.forceCSS || !s.forceJS && "css" == s.url.split(".").pop().split("?").shift() ? "c" : n, s.noexec, s.attrs, s.timeout), (r(o) || r(u)) && i.load(function() {
                    l(), o && o(s.origUrl, c, a), u && u(s.origUrl, c, a), N[s.url] = 2
                })))
            }

            function c(e, t) {
                function n(e, n) {
                    if (e) {
                        if (o(e)) n || (f = function() {
                            var e = [].slice.call(arguments);
                            d.apply(this, e), p()
                        }), a(e, f, t, 0, u);
                        else if (Object(e) === e)
                            for (s in c = function() {
                                    var t, n = 0;
                                    for (t in e) e.hasOwnProperty(t) && n++;
                                    return n
                                }(), e) e.hasOwnProperty(s) && (!n && !--c && (r(f) ? f = function() {
                                var e = [].slice.call(arguments);
                                d.apply(this, e), p()
                            } : f[s] = function(e) {
                                return function() {
                                    var t = [].slice.call(arguments);
                                    e && e.apply(this, t), p()
                                }
                            }(d[s])), a(e[s], f, t, s, u))
                    } else !n && p()
                }
                var c, s, u = !!e.test,
                    l = e.load || e.both,
                    f = e.callback || i,
                    d = f,
                    p = e.complete || i;
                n(u ? e.yep : e.nope, !!l), l && n(l)
            }
            var s, u, f = this.yepnope.loader;
            if (o(e)) a(e, 0, f, 0);
            else if (j(e))
                for (s = 0; s < e.length; s++) u = e[s], o(u) ? a(u, 0, f, 0) : j(u) ? d(u) : Object(u) === u && c(u, f);
            else Object(e) === e && c(e, f)
        }, d.addPrefix = function(e, t) {
            k[e] = t
        }, d.addFilter = function(e) {
            x.push(e)
        }, d.errorTimeout = 1e4, null == t.readyState && t.addEventListener && (t.readyState = "loading", t.addEventListener("DOMContentLoaded", f = function() {
            t.removeEventListener("DOMContentLoaded", f, 0), t.readyState = "complete"
        }, 0)), e.yepnope = l(), e.yepnope.executeStack = c, e.yepnope.injectJs = function(e, n, r, o, s, u) {
            var l, f, p = t.createElement("script"),
                o = o || d.errorTimeout;
            p.src = e;
            for (f in r) p.setAttribute(f, r[f]);
            n = u ? c : n || i, p.onreadystatechange = p.onload = function() {
                !l && a(p.readyState) && (l = 1, n(), p.onload = p.onreadystatechange = null)
            }, m(function() {
                l || (l = 1, n(1))
            }, o), s ? p.onload() : h.parentNode.insertBefore(p, h)
        }, e.yepnope.injectCss = function(e, n, r, o, a, s) {
            var u, o = t.createElement("link"),
                n = s ? c : n || i;
            o.href = e, o.rel = "stylesheet", o.type = "text/css";
            for (u in r) o.setAttribute(u, r[u]);
            a || (h.parentNode.insertBefore(o, h), m(n, 0))
        }
    }(this, document), Modernizr.load = function() {
        yepnope.apply(window, [].slice.call(arguments, 0))
    };