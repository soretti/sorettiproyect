function registro() {
    $("#submit_tienda").click(function(t) {
        t.preventDefault(), $("#tienda_registro").val("TRS6745-*1"), $("#form-tienda").submit()
    }), $("#submit_editar").click(function(t) {
        t.preventDefault(), $("#tienda_registro").val("TRS6745-*1"), $("#form-editar").submit()
    })
}

$(document).ready(function(){

    if($('#area_desarrollo').val()!='desarrollo' && $('#enviado').val()!=1){
        $('#desarollo_profesional').val($('#area_desarrollo option:selected').text()); 

        $.ajax({
            url: base_url+'contacto/areas_especialidad',
            type: 'POST',
            data: {
              "especialidad_id" : $('#area_desarrollo').val(),
            },
        })
        .done(function(response) {
            $("#especialidad").html(response);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

   }else{
       $('#desarollo_profesional').val("");
       $("#especialidad").html("<option value=''>Especialidad *</option>");
   }

   /*--Lista Paises--*/
   $.ajax({
        url: base_url+'contacto/catpais',
        type: 'POST',
        data: {
           "pais_id" : 30,
        },
    })
    .done(function(response) {
        $("#pais").html(response);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });

    /*--Lista Estados--*/
    $.ajax({
        url: base_url+'contacto/catestado',
        type: 'POST',
        data: {
          "idcatpais" : 30, "estado_id" : 310,
        },
    })
    .done(function(response) {
        $("#estado").html(response);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });

    /*--Lista Municipios--*/
    $.ajax({
        url: base_url+'contacto/catmunicipio',
        type: 'POST',
        data: {
          "idcatestado" : 310,
        },
    })
    .done(function(response) {
        $("#municipio").html(response);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });


});

$(document).on('change','#pais', function(){

    if($('#pais').val()!='pais'){

       $.ajax({
            url: base_url+'contacto/catestado',
            type: 'POST',
            data: {
              "idcatpais" : $('#pais').val(),
            },
        })
        .done(function(response) {
            $("#estado").html(response);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

        $("#municipio").html("<option value='municipio'>Delegación / Municipio *</option>");

   }else{
       $('#pais').val("pais");
       $("#estado").html("<option value='estado'>Estado *</option>");
   }
    
});


$(document).on('change','#estado', function(){

    if($('#pais').val()!='estado'){

       $.ajax({
            url: base_url+'contacto/catmunicipio',
            type: 'POST',
            data: {
              "idcatestado" : $('#estado').val(),
            },
        })
        .done(function(response) {
            $("#municipio").html(response);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

   }else{
       $('#estado').val("estado");
       $("#municipio").html("<option value='municipio'>Municipio *</option>");
   }
    
});



$(document).on('change','#area_desarrollo', function(){

    if($('#area_desarrollo').val()!='desarrollo'){
       $('#desarollo_profesional').val($('#area_desarrollo option:selected').text()); 

       $.ajax({
            url: base_url+'contacto/areas_especialidad',
            type: 'POST',
            data: {
              "especialidad_id" : $('#area_desarrollo').val(),
            },
        })
        .done(function(response) {
            $("#especialidad").html(response);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

   }else{
       $('#desarollo_profesional').val("");
       $("#especialidad").html("<option value=''>Especialidad *</option>");
   }
    
});

function contacto() {
    $("#enviar-contacto").click(function(t) {
        t.preventDefault();

        if($('#f_dia').val()!='dia' && $('#f_mes').val()!='mes' && $('#f_anno').val()!='anio'){
            $('#fecha_nacimiento').val($('#f_dia').val()+'/'+$('#f_mes').val()+'/'+$('#f_anno').val());
        }else{
            $('#fecha_nacimiento').val('');
        }
        $("#mcontacto").val("TRS6745-*1"); 
        $("#form-contacto").submit()
    })
}

function contacto_inmediato() {
    $("#enviar-inmediato").click(function(t) {
        t.preventDefault(), $("#contenedor-contactoinmediato").load(base_url + "contacto/inmediato #inner-contactoinmediato", {
            nombre: $("#f_nombre").val(),
            email: $("#f_email").val(),
            mcontacto: 1,
            texto: $("#f_texto").val()
        }, contacto_inmediato)
    })
}

function combinaciones_productos() {
    var t = new Array,
        e = "",
        i = 0,
        o = new Object;
    $(".atributo").each(function(e) {
        atributo_padre = $(this).prev().text(), $(this).is(":radio:checked") && (t[i] = $(this).val(), i++, o[atributo_padre] = $(this).attr("stringValue")), $(this).is("select") && (t[i] = $(this).val(), i++, o[atributo_padre] = $("option:selected", this).attr("stringValue"))
    }), $("#input_combinaciones").val(JSON.stringify(o)), t.sort();
    var n = t.length - 1;
    if ($.each(t, function(t, i) {
            extra = "", n != t && (extra = ","), e = e + i + extra
        }), "undefined" != typeof combinaciones[e]) {
        if (combinacion_imagenes = combinaciones[e].imagenes.split(","), $(".owl-carousel-ficha .item").each(function(t) {
                $(this).parent().removeClass("hide"), imageid = $(this).attr("imageId"), imagen = combinacion_imagenes.indexOf(imageid), imagen < 0 && "" != combinaciones[e].imagenes && $(this).parent().addClass("hide")
            }), owlFicha.trigger("to.owl.carousel", 0), $(".foto_sm").find("a").attr("href", $(".owl-item:not(.hide)").eq(0).find("a").attr("href")), $(".foto_sm").find("img").attr("src", $(".owl-item:not(.hide)").eq(0).find("a").attr("foto-sm")), $("#precio").text(formato_precio(combinaciones[e].precio)), combinaciones[e].precio_sin_promocion ? ($("#precio_sin_promocion").removeClass("hide"), $("#precio_sin_promocion").text(formato_precio(combinaciones[e].precio_sin_promocion))) : $("#precio_sin_promocion").addClass("hide"), $("#stock").text(combinaciones[e].stock), $("#producto_id").val(combinaciones[e].id), combinaciones[e].mayoreo_precio && 1 * combinaciones[e].mayoreo_cantidad > 0 ? ($("#mayoreo").text("Aparir de " + combinaciones[e].mayoreo_cantidad + " piezas " + formato_precio(combinaciones[e].mayoreo_precio)), $("#mayoreo").removeClass("hide")) : $("#mayoreo").addClass("hide"), 1 * combinaciones[e].stock == 0 && 1 * combinaciones[e].comprar_sin_stock == 0) return $("#producto-data, #comprar").addClass("hide"), $(".alert-warning").addClass("show"), void $(".alert-warning").text("Este producto ya no está en stock con estos atributos , pero está disponible con otros.");
        1 == combinaciones[e].comprar_sin_stock ? $(".box-stock").addClass("hide") : $(".box-stock").removeClass("hide"), $(".alert-warning").removeClass("show"), $(".alert-warning").text(""), $("#producto-data, #comprar").removeClass("hide")
    } else $("#producto-data, #comprar").addClass("hide"), $(".alert-warning").addClass("show"), $(".alert-warning").text("Esta combinacion no existe para este producto. Porvafor selecciona otra combinación.")
}

function formato_precio(t) {
    var e = !1;
    return 0 > t && (e = !0, t = Math.abs(t)), (e ? "-$ " : "$ ") + parseFloat(t, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString()
}
if (function(t) {
        var e = null,
            i = {
                init: function(i) {
                    var n = t.extend({
                        slideTransition: "none",
                        slideTransitionSpeed: 2e3,
                        slideEndAnimation: !0,
                        position: "0,0",
                        transitionIn: "left",
                        transitionOut: "left",
                        fullWidth: !1,
                        delay: 0,
                        timeout: 2e3,
                        speedIn: 2500,
                        speedOut: 1e3,
                        easeIn: "easeOutExpo",
                        easeOut: "easeOutCubic",
                        controls: !1,
                        pager: !1,
                        autoChange: !0,
                        pauseOnHover: !1,
                        backgroundAnimation: !1,
                        backgroundElement: null,
                        backgroundX: 500,
                        backgroundY: 500,
                        backgroundSpeed: 2500,
                        backgroundEase: "easeOutCubic",
                        responsive: !1,
                        increase: !1,
                        dimensions: "",
                        startCallback: null,
                        startNextSlideCallback: null,
                        stopCallback: null,
                        pauseCallback: null,
                        resumeCallback: null,
                        nextSlideCallback: null,
                        prevSlideCallback: null,
                        pagerCallback: null
                    }, i);
                    return this.each(function() {
                        e = new o(this, n)
                    })
                },
                pause: function() {
                    e.pause(!0)
                },
                resume: function() {
                    e.resume()
                },
                stop: function() {
                    e.stop()
                },
                start: function() {
                    e.start()
                },
                startNextSlide: function() {
                    e.startNextSlide()
                }
            },
            o = function(e, i) {
                function o() {
                    if (i.controls && (Y.append('<a href="#" class="prev"></a><a href="#" class="next" ></a>'), Y.find(".next").bind("click", function() {
                            return f()
                        }), Y.find(".prev").bind("click", function() {
                            return m()
                        })), i.pauseOnHover && Y.bind({
                            mouseenter: function() {
                                r(!1)
                            },
                            mouseleave: function() {
                                l()
                            }
                        }), i.fullWidth ? Y.css({
                            overflow: "visible"
                        }) : Y.css({
                            overflow: "hidden"
                        }), i.pager) {
                        var e = "boolean" != typeof i.pager;
                        Q = e ? i.pager : t('<div class="fs-pager-wrapper"></div>'), e ? Q.addClass("fs-custom-pager-wrapper") : Y.append(Q)
                    }
                    Y.children(".slide").each(function(o) {
                        var n = t(this);
                        if (n.children().attr("rel", o).addClass("fs_obj"), n.children("[data-fixed]").addClass("fs_fixed_obj"), i.pager || e) {
                            var s = t('<a rel="' + o + '" href="#"></a>').bind("click", function() {
                                return u(this)
                            });
                            Q.append(s)
                        }
                    }), i.pager && (Q = t(Q).children("a")), i.responsive && R(), Y.find(".fs_loader").length > 0 && Y.find(".fs_loader").remove(), n()
                }

                function n() {
                    B.stop = !1, B.pause = !1, B.running = !0, g("slide"), p(i.startCallback)
                }

                function s() {
                    B.stop = !1, B.pause = !1, B.running = !0, h(), p(i.startNextSlideCallback)
                }

                function a() {
                    B.stop = !0, B.running = !1, Y.find(".slide").stop(!0, !0), Y.find(".fs_obj").stop(!0, !0).removeClass("fs-animation"), F(q), p(i.stopCallback)
                }

                function r(t) {
                    B.pause = !0, B.running = !1, t && Y.find(".fs-animation").finish(), p(i.pauseCallback)
                }

                function l() {
                    B.stop = !1, B.pause = !1, B.running = !0, B.slideComplete ? g("slide") : B.stepComplete ? g("step") : B.finishedObjs < B.maxObjs || g(B.currentStep < B.maxStep ? "step" : "slide"), p(i.resumeCallback)
                }

                function h() {
                    B.lastSlide = B.currentSlide, B.currentSlide += 1, B.stop = !1, B.pause = !1, B.running = !0, w(), p(i.nextSlideCallback)
                }

                function c() {
                    B.lastSlide = B.currentSlide, B.currentSlide -= 1, B.stop = !1, B.pause = !1, B.running = !0, w(), p(i.prevSlideCallback)
                }

                function d(t) {
                    B.lastSlide = B.currentSlide, B.currentSlide = t, B.stop = !1, B.pause = !1, B.running = !0, w(), p(i.pagerCallback)
                }

                function p(e) {
                    t.isFunction(e) && e.call(this, Y, B.currentSlide, B.lastSlide, B.currentStep)
                }

                function u(e) {
                    var i = parseInt(t(e).attr("rel"));
                    return i != B.currentSlide && (a(), d(i)), !1
                }

                function m() {
                    return a(), c(), !1
                }

                function f() {
                    return a(), h(), !1
                }

                function g(t) {
                    if (!B.pause && !B.stop && B.running) switch (t) {
                        case "slide":
                            B.slideComplete = !1, v();
                            break;
                        case "step":
                            B.stepComplete = !1, C();
                            break;
                        case "obj":
                            T()
                    }
                }

                function v() {
                    var t = i.timeout;
                    B.init ? (B.init = !1, w(!0)) : q.push(setTimeout(function() {
                        0 == B.maxSlide && 1 == B.running || (B.lastSlide = B.currentSlide, B.currentSlide += 1, w())
                    }, t))
                }

                function w(t) {
                    if (Y.find(".active-slide").removeClass("active-slide"), B.currentSlide > B.maxSlide && (B.currentSlide = 0), B.currentSlide < 0 && (B.currentSlide = B.maxSlide), N.currentSlide = Y.children(".slide:eq(" + B.currentSlide + ")").addClass("active-slide"), 0 == N.currentSlide.length && (B.currentSlide = 0, N.currentSlide = Y.children(".slide:eq(" + B.currentSlide + ")")), null != B.lastSlide && (B.lastSlide < 0 && (B.lastSlide = B.maxSlide), N.lastSlide = Y.children(".slide:eq(" + B.lastSlide + ")")), t ? N.animation = "none" : (N.animation = N.currentSlide.attr("data-in"), null == N.animation && (N.animation = i.slideTransition)), i.slideEndAnimation && null != B.lastSlide) $();
                    else switch (N.animation) {
                        case "none":
                            y(), x();
                            break;
                        case "scrollLeft":
                            y(), x();
                            break;
                        case "scrollRight":
                            y(), x();
                            break;
                        case "scrollTop":
                            y(), x();
                            break;
                        case "scrollBottom":
                            y(), x();
                            break;
                        default:
                            y()
                    }
                }

                function y() {
                    i.backgroundAnimation && H(), i.pager && (Q.removeClass("active"), Q.eq(B.currentSlide).addClass("active")), _(), N.currentSlide.children().hide(), B.currentStep = 0, B.currentObj = 0, B.maxObjs = 0, B.finishedObjs = 0, N.currentSlide.children("[data-fixed]").show(), W()
                }

                function b(t) {
                    null != N.lastSlide && N.lastSlide.hide(), t.hasClass("active-slide") && g("step")
                }

                function x() {
                    null != N.lastSlide && "none" != N.animation && L()
                }

                function z() {}

                function _() {
                    var e = N.currentSlide.children(),
                        i = 0;
                    e.each(function() {
                        var e = parseFloat(t(this).attr("data-step"));
                        i = e > i ? e : i
                    }), B.maxStep = i
                }

                function C() {
                    var t;
                    t = 0 == B.currentStep ? N.currentSlide.children('*:not([data-step]):not([data-fixed]), *[data-step="' + B.currentStep + '"]:not([data-fixed])') : N.currentSlide.children('*[data-step="' + B.currentStep + '"]:not([data-fixed])'), B.maxObjs = t.length, Z = t, B.maxObjs > 0 ? (B.currentObj = 0, B.finishedObjs = 0, g("obj")) : k()
                }

                function k() {
                    return B.stepComplete = !0, B.currentStep += 1, B.currentStep > B.maxStep ? void(i.autoChange && (B.currentStep = 0, B.slideComplete = !0, g("slide"))) : void g("step")
                }

                function T() {
                    var e = t(Z[B.currentObj]);
                    e.addClass("fs-animation");
                    var o = e.attr("data-position"),
                        n = e.attr("data-in"),
                        s = e.attr("data-delay"),
                        a = e.attr("data-time"),
                        r = e.attr("data-ease-in"),
                        l = e.attr("data-special");
                    o = null == o ? i.position.split(",") : o.split(","), null == n && (n = i.transitionIn), null == s && (s = i.delay), null == r && (r = i.easeIn), E(e, o, n, s, a, r, l), B.currentObj += 1, B.currentObj < B.maxObjs ? g("obj") : B.currentObj = 0
                }

                function S(t) {
                    t.removeClass("fs-animation"), t.attr("rel") == B.currentSlide && (B.finishedObjs += 1, B.finishedObjs == B.maxObjs && k())
                }

                function $() {
                    var e = N.lastSlide.children(":not([data-fixed])");
                    e.each(function() {
                        var e = t(this),
                            o = e.position(),
                            n = e.attr("data-out"),
                            s = e.attr("data-ease-out");
                        null == n && (n = i.transitionOut), null == s && (s = i.easeOut), O(e, o, n, null, s)
                    }).promise().done(function() {
                        x(), y()
                    })
                }

                function W() {
                    var t = N.currentSlide,
                        e = {},
                        o = {},
                        n = i.slideTransitionSpeed,
                        s = N.animation;
                    switch (i.responsive ? unit = "%" : unit = "px", s) {
                        case "slideLeft":
                            e.left = U + unit, e.top = "0" + unit, e.display = "block", o.left = "0" + unit, o.top = "0" + unit;
                            break;
                        case "slideTop":
                            e.left = "0" + unit, e.top = -J + unit, e.display = "block", o.left = "0" + unit, o.top = "0" + unit;
                            break;
                        case "slideBottom":
                            e.left = "0" + unit, e.top = J + unit, e.display = "block", o.left = "0" + unit, o.top = "0" + unit;
                            break;
                        case "slideRight":
                            e.left = -U + unit, e.top = "0" + unit, e.display = "block", o.left = "0" + unit, o.top = "0" + unit;
                            break;
                        case "fade":
                            e.left = "0" + unit, e.top = "0" + unit, e.display = "block", e.opacity = 0, o.opacity = 1;
                            break;
                        case "none":
                            e.left = "0" + unit, e.top = "0" + unit, e.display = "block", n = 0;
                            break;
                        case "scrollLeft":
                            e.left = U + unit, e.top = "0" + unit, e.display = "block", o.left = "0" + unit, o.top = "0" + unit;
                            break;
                        case "scrollTop":
                            e.left = "0" + unit, e.top = -J + unit, e.display = "block", o.left = "0" + unit, o.top = "0" + unit;
                            break;
                        case "scrollBottom":
                            e.left = "0" + unit, e.top = J + unit, e.display = "block", o.left = "0" + unit, o.top = "0" + unit;
                            break;
                        case "scrollRight":
                            e.left = -U + unit, e.top = "0" + unit, e.display = "block", o.left = "0" + unit, o.top = "0" + unit
                    }
                    t.css(e).animate(o, n, "linear", function() {
                        b(t)
                    })
                }

                function L() {
                    var t = {},
                        e = i.slideTransitionSpeed,
                        o = null,
                        n = N.animation;
                    switch (o = i.responsive ? "%" : "px", n) {
                        case "scrollLeft":
                            t.left = -U + o, t.top = "0" + o;
                            break;
                        case "scrollTop":
                            t.left = "0" + o, t.top = J + o;
                            break;
                        case "scrollBottom":
                            t.left = "0" + o, t.top = -J + o;
                            break;
                        case "scrollRight":
                            t.left = U + o, t.top = "0" + o;
                            break;
                        default:
                            e = 0
                    }
                    N.lastSlide.animate(t, e, "linear", function() {
                        z()
                    })
                }

                function E(e, o, n, s, a, r, l) {
                    var h = {},
                        c = {},
                        d = i.speedIn,
                        p = null;
                    switch (p = i.responsive ? "%" : "px", null != a && "" != a && (d = a - s), h.opacity = 1, n) {
                        case "left":
                            h.top = o[0], h.left = U;
                            break;
                        case "bottomLeft":
                            h.top = J, h.left = U;
                            break;
                        case "topLeft":
                            h.top = -1 * e.outerHeight(), h.left = U;
                            break;
                        case "top":
                            h.top = -1 * e.outerHeight(), h.left = o[1];
                            break;
                        case "bottom":
                            h.top = J, h.left = o[1];
                            break;
                        case "right":
                            h.top = o[0], h.left = -K - e.outerWidth();
                            break;
                        case "bottomRight":
                            h.top = J, h.left = -K - e.outerWidth();
                            break;
                        case "topRight":
                            h.top = -1 * e.outerHeight(), h.left = -K - e.outerWidth();
                            break;
                        case "fade":
                            h.top = o[0], h.left = o[1], h.opacity = 0, c.opacity = 1;
                            break;
                        case "none":
                            h.top = o[0], h.left = o[1], h.display = "none", d = 0
                    }
                    c.top = o[0], c.left = o[1], c.left = c.left + p, c.top = c.top + p, h.left = h.left + p, h.top = h.top + p, q.push(setTimeout(function() {
                        if ("cycle" == l && e.attr("rel") == B.currentSlide) {
                            var o = e.prev();
                            if (o.length > 0) {
                                var n = t(o).attr("data-position").split(",");
                                n = {
                                    top: n[0],
                                    left: n[1]
                                };
                                var s = t(o).attr("data-out");
                                null == s && (s = i.transitionOut), O(o, n, s, d)
                            }
                        }
                        e.css(h).show().animate(c, d, r, function() {
                            S(e)
                        }).addClass("fs_obj_active")
                    }, s))
                }

                function O(t, e, o, n, s) {
                    var a = {},
                        r = {},
                        l = null;
                    n = i.speedOut, l = i.responsive ? "%" : "px";
                    var h = t.outerWidth(),
                        c = t.outerHeight();
                    switch (i.responsive && (h = A(h, X), c = A(c, V)), o) {
                        case "left":
                            r.left = -K - 100 - h;
                            break;
                        case "bottomLeft":
                            r.top = J, r.left = -K - 100 - h;
                            break;
                        case "topLeft":
                            r.top = -c, r.left = -K - 100 - h;
                            break;
                        case "top":
                            r.top = -c;
                            break;
                        case "bottom":
                            r.top = J;
                            break;
                        case "right":
                            r.left = U;
                            break;
                        case "bottomRight":
                            r.top = J, r.left = U;
                            break;
                        case "topRight":
                            r.top = -c, r.left = U;
                            break;
                        case "fade":
                            a.opacity = 1, r.opacity = 0;
                            break;
                        case "hide":
                            r.display = "none", n = 0;
                            break;
                        default:
                            r.display = "none", n = 0
                    }
                    "undefined" != typeof r.top && r.top.toString().indexOf("px") > 0 && (r.top = r.top.substring(0, r.top.length - 2), i.responsive && (r.top = A(r.top, V))), "undefined" != typeof r.left && r.left.toString().indexOf("px") > 0 && (r.left = r.left.substring(0, r.left.length - 2), i.responsive && (r.left = A(r.left, X))), r.left = r.left + l, r.top = r.top + l, t.css(a).animate(r, n, s, function() {
                        t.hide()
                    }).removeClass("fs_obj_active")
                }

                function H() {
                    var e;
                    e = null == i.backgroundElement || "" == i.backgroundElement ? Y.parent() : t(i.backgroundElement);
                    var o = e.css("background-position");
                    o = o.split(" ");
                    var n = i.backgroundX,
                        s = i.backgroundY,
                        a = Number(o[0].replace(/[px,%]/g, "")) + Number(n),
                        r = Number(o[1].replace(/[px,%]/g, "")) + Number(s);
                    e.animate({
                        backgroundPositionX: a + "px",
                        backgroundPositionY: r + "px"
                    }, i.backgroundSpeed, i.backgroundEase)
                }

                function R() {
                    var o = i.dimensions.split(","),
                        n = j();
                    X = o[0], V = o[1], i.increase || t(e).css({
                        maxWidth: X + "px"
                    });
                    var s = Y.children(".slide").find("*");
                    s.each(function() {
                        var e = t(this),
                            i = null,
                            o = null,
                            s = null;
                        if (null != e.attr("data-position")) {
                            var a = e.attr("data-position").split(",");
                            i = A(a[1], X), o = A(a[0], V), e.attr("data-position", o + "," + i)
                        }
                        null != e.attr("width") && "" != e.attr("width") ? (s = e.attr("width"), i = A(s, X), e.attr("width", i + "%"), e.css("width", i + "%")) : "0px" != e.css("width") ? (s = e.css("width"), s.indexOf("px") > 0 && (s = s.substring(0, s.length - 2), i = A(s, X), e.css("width", i + "%"))) : "img" == e.prop("tagName").toLowerCase() && -1 != n ? (s = P(e), i = A(s, X), e.css("width", i + "%").attr("width", i + "%")) : "img" == e.prop("tagName").toLowerCase() && (s = e.get(0).width, i = A(s, X), e.css("width", i + "%")), null != e.attr("height") && "" != e.attr("height") ? (s = e.attr("height"), o = A(s, V), e.attr("height", o + "%"), e.css("height", o + "%")) : "0px" != e.css("height") ? (s = e.css("height"), s.indexOf("px") > 0 && (s = s.substring(0, s.length - 2), o = A(s, V), e.css("height", o + "%"))) : "img" == e.prop("tagName").toLowerCase() && -1 != n ? (s = I(e), o = A(s, V), e.css("height", o + "%").attr("height", o + "%")) : "img" == e.prop("tagName").toLowerCase() && (s = e.get(0).height, o = A(s, V), e.css("height", o + "%")), e.attr("data-fontsize", e.css("font-size"))
                    }), Y.css({
                        width: "auto",
                        height: "auto"
                    }).append('<div class="fs-stretcher" style="width:' + X + "px; height:" + V + 'px"></div>'), D(), t(window).bind("resize", function() {
                        D()
                    })
                }

                function P(t) {
                    var e = new Image;
                    return e.src = t.attr("src"), e.width
                }

                function I(t) {
                    var e = new Image;
                    return e.src = t.attr("src"), e.height
                }

                function D() {
                    var e = Y.innerWidth();
                    Y.innerHeight();
                    if (X >= e || i.increase) {
                        var o = X / V,
                            n = e / o;
                        Y.find(".fs-stretcher").css({
                            width: e + "px",
                            height: n + "px"
                        })
                    }
                    G = t("body").width();
                    var s = Y.width();
                    K = A((G - s) / 2, X), U = 100, i.fullWidth && (U = 100 + 2 * K), J = 100, (0 == B.init || X > e) && M()
                }

                function M() {
                    var e = null,
                        i = Y.children(".slide").find("*");
                    i.each(function() {
                        obj = t(this);
                        var i = obj.attr("data-fontsize");
                        i.indexOf("px") > 0 && (i = i.substring(0, i.length - 2), e = A(i, V) * (Y.find(".fs-stretcher").height() / 100), obj.css("fontSize", e + "px"), obj.css("lineHeight", "100%"))
                    })
                }

                function A(t, e) {
                    return t / (e / 100)
                }

                function F(e) {
                    var i = e.length;
                    t.each(e, function(t) {
                        clearTimeout(this), t == i - 1 && (e = [])
                    })
                }

                function j() {
                    var t = -1;
                    if ("Microsoft Internet Explorer" == navigator.appName) {
                        var e = navigator.userAgent,
                            i = new RegExp("MSIE ([0-9]{1,}[.0-9]{0,})");
                        null != i.exec(e) && (t = parseFloat(RegExp.$1))
                    }
                    return t
                }
                var B = {
                        init: !0,
                        running: !1,
                        pause: !1,
                        stop: !1,
                        slideComplete: !1,
                        stepComplete: !1,
                        controlsActive: !0,
                        currentSlide: 0,
                        lastSlide: null,
                        maxSlide: 0,
                        currentStep: 0,
                        maxStep: 0,
                        currentObj: 0,
                        maxObjs: 0,
                        finishedObjs: 0
                    },
                    N = {
                        currentSlide: null,
                        lastSlide: null,
                        animationkey: "none"
                    },
                    q = [],
                    Z = null,
                    X = null,
                    V = null;
                t(e).wrapInner('<div class="fraction-slider" />');
                var Y = t(e).find(".fraction-slider"),
                    Q = null;
                B.maxSlide = Y.children(".slide").length - 1;
                var U = Y.width(),
                    G = t("body").width(),
                    K = 0;
                i.fullWidth && (K = (G - U) / 2, U = G);
                var J = Y.height();
                o(), this.start = function() {
                    n()
                }, this.startNextSlide = function() {
                    s()
                }, this.stop = function() {
                    a()
                }, this.pause = function() {
                    r(!1)
                }, this.resume = function() {
                    l()
                }
            };
        t.fn.fractionSlider = function(e) {
            return i[e] ? i[e].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof e && e ? void t.error("Method " + e + " does not exist on jQuery.tooltip") : i.init.apply(this, arguments)
        };
        var n = {};
        t.each(["Quad", "Cubic", "Quart", "Quint", "Expo"], function(t, e) {
            n[e] = function(e) {
                return Math.pow(e, t + 2)
            }
        }), t.extend(n, {
            Sine: function(t) {
                return 1 - Math.cos(t * Math.PI / 2)
            },
            Circ: function(t) {
                return 1 - Math.sqrt(1 - t * t)
            },
            Elastic: function(t) {
                return 0 == t || 1 == t ? t : -Math.pow(2, 8 * (t - 1)) * Math.sin((80 * (t - 1) - 7.5) * Math.PI / 15)
            },
            Back: function(t) {
                return t * t * (3 * t - 2)
            },
            Bounce: function(t) {
                for (var e, i = 4; t < ((e = Math.pow(2, --i)) - 1) / 11;);
                return 1 / Math.pow(4, 3 - i) - 7.5625 * Math.pow((3 * e - 2) / 22 - t, 2)
            }
        }), t.each(n, function(e, i) {
            t.easing["easeIn" + e] = i, t.easing["easeOut" + e] = function(t) {
                return 1 - i(1 - t)
            }, t.easing["easeInOut" + e] = function(t) {
                return .5 > t ? i(2 * t) / 2 : 1 - i(-2 * t + 2) / 2
            }
        })
    }(jQuery), function() {
        var t, e, i, o, n, s = function(t, e) {
                return function() {
                    return t.apply(e, arguments)
                }
            },
            a = [].indexOf || function(t) {
                for (var e = 0, i = this.length; i > e; e++)
                    if (e in this && this[e] === t) return e;
                return -1
            };
        e = function() {
            function t() {}
            return t.prototype.extend = function(t, e) {
                var i, o;
                for (i in e) o = e[i], null == t[i] && (t[i] = o);
                return t
            }, t.prototype.isMobile = function(t) {
                return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(t)
            }, t.prototype.addEvent = function(t, e, i) {
                return null != t.addEventListener ? t.addEventListener(e, i, !1) : null != t.attachEvent ? t.attachEvent("on" + e, i) : t[e] = i
            }, t.prototype.removeEvent = function(t, e, i) {
                return null != t.removeEventListener ? t.removeEventListener(e, i, !1) : null != t.detachEvent ? t.detachEvent("on" + e, i) : delete t[e]
            }, t.prototype.innerHeight = function() {
                return "innerHeight" in window ? window.innerHeight : document.documentElement.clientHeight
            }, t
        }(), i = this.WeakMap || this.MozWeakMap || (i = function() {
            function t() {
                this.keys = [], this.values = []
            }
            return t.prototype.get = function(t) {
                var e, i, o, n, s;
                for (s = this.keys, e = o = 0, n = s.length; n > o; e = ++o)
                    if (i = s[e], i === t) return this.values[e]
            }, t.prototype.set = function(t, e) {
                var i, o, n, s, a;
                for (a = this.keys, i = n = 0, s = a.length; s > n; i = ++n)
                    if (o = a[i], o === t) return void(this.values[i] = e);
                return this.keys.push(t), this.values.push(e)
            }, t
        }()), t = this.MutationObserver || this.WebkitMutationObserver || this.MozMutationObserver || (t = function() {
            function t() {
                "undefined" != typeof console && null !== console && console.warn("MutationObserver is not supported by your browser."), "undefined" != typeof console && null !== console && console.warn("WOW.js cannot detect dom mutations, please call .sync() after loading new content.")
            }
            return t.notSupported = !0, t.prototype.observe = function() {}, t
        }()), o = this.getComputedStyle || function(t) {
            return this.getPropertyValue = function(e) {
                var i;
                return "float" === e && (e = "styleFloat"), n.test(e) && e.replace(n, function(t, e) {
                    return e.toUpperCase()
                }), (null != (i = t.currentStyle) ? i[e] : void 0) || null
            }, this
        }, n = /(\-([a-z]){1})/g, this.WOW = function() {
            function n(t) {
                null == t && (t = {}), this.scrollCallback = s(this.scrollCallback, this), this.scrollHandler = s(this.scrollHandler, this), this.start = s(this.start, this), this.scrolled = !0, this.config = this.util().extend(t, this.defaults), this.animationNameCache = new i
            }
            return n.prototype.defaults = {
                boxClass: "wow",
                animateClass: "animated",
                offset: 0,
                mobile: !0,
                live: !0
            }, n.prototype.init = function() {
                var t;
                return this.element = window.document.documentElement, "interactive" === (t = document.readyState) || "complete" === t ? this.start() : this.util().addEvent(document, "DOMContentLoaded", this.start), this.finished = []
            }, n.prototype.start = function() {
                var e, i, o, n;
                if (this.stopped = !1, this.boxes = function() {
                        var t, i, o, n;
                        for (o = this.element.querySelectorAll("." + this.config.boxClass), n = [], t = 0, i = o.length; i > t; t++) e = o[t], n.push(e);
                        return n
                    }.call(this), this.all = function() {
                        var t, i, o, n;
                        for (o = this.boxes, n = [], t = 0, i = o.length; i > t; t++) e = o[t], n.push(e);
                        return n
                    }.call(this), this.boxes.length)
                    if (this.disabled()) this.resetStyle();
                    else
                        for (n = this.boxes, i = 0, o = n.length; o > i; i++) e = n[i], this.applyStyle(e, !0);
                return this.disabled() || (this.util().addEvent(window, "scroll", this.scrollHandler), this.util().addEvent(window, "resize", this.scrollHandler), this.interval = setInterval(this.scrollCallback, 50)), this.config.live ? new t(function(t) {
                    return function(e) {
                        var i, o, n, s, a;
                        for (a = [], n = 0, s = e.length; s > n; n++) o = e[n], a.push(function() {
                            var t, e, n, s;
                            for (n = o.addedNodes || [], s = [], t = 0, e = n.length; e > t; t++) i = n[t], s.push(this.doSync(i));
                            return s
                        }.call(t));
                        return a
                    }
                }(this)).observe(document.body, {
                    childList: !0,
                    subtree: !0
                }) : void 0
            }, n.prototype.stop = function() {
                return this.stopped = !0, this.util().removeEvent(window, "scroll", this.scrollHandler), this.util().removeEvent(window, "resize", this.scrollHandler), null != this.interval ? clearInterval(this.interval) : void 0
            }, n.prototype.sync = function() {
                return t.notSupported ? this.doSync(this.element) : void 0
            }, n.prototype.doSync = function(t) {
                var e, i, o, n, s;
                if (null == t && (t = this.element), 1 === t.nodeType) {
                    for (t = t.parentNode || t, n = t.querySelectorAll("." + this.config.boxClass), s = [], i = 0, o = n.length; o > i; i++) e = n[i], a.call(this.all, e) < 0 ? (this.boxes.push(e), this.all.push(e), this.stopped || this.disabled() ? this.resetStyle() : this.applyStyle(e, !0), s.push(this.scrolled = !0)) : s.push(void 0);
                    return s
                }
            }, n.prototype.show = function(t) {
                return this.applyStyle(t), t.className = "" + t.className + " " + this.config.animateClass
            }, n.prototype.applyStyle = function(t, e) {
                var i, o, n;
                return o = t.getAttribute("data-wow-duration"), i = t.getAttribute("data-wow-delay"), n = t.getAttribute("data-wow-iteration"), this.animate(function(s) {
                    return function() {
                        return s.customStyle(t, e, o, i, n)
                    }
                }(this))
            }, n.prototype.animate = function() {
                return "requestAnimationFrame" in window ? function(t) {
                    return window.requestAnimationFrame(t)
                } : function(t) {
                    return t()
                }
            }(), n.prototype.resetStyle = function() {
                var t, e, i, o, n;
                for (o = this.boxes, n = [], e = 0, i = o.length; i > e; e++) t = o[e], n.push(t.style.visibility = "visible");
                return n
            }, n.prototype.customStyle = function(t, e, i, o, n) {
                return e && this.cacheAnimationName(t), t.style.visibility = e ? "hidden" : "visible", i && this.vendorSet(t.style, {
                    animationDuration: i
                }), o && this.vendorSet(t.style, {
                    animationDelay: o
                }), n && this.vendorSet(t.style, {
                    animationIterationCount: n
                }), this.vendorSet(t.style, {
                    animationName: e ? "none" : this.cachedAnimationName(t)
                }), t
            }, n.prototype.vendors = ["moz", "webkit"], n.prototype.vendorSet = function(t, e) {
                var i, o, n, s;
                s = [];
                for (i in e) o = e[i], t["" + i] = o, s.push(function() {
                    var e, s, a, r;
                    for (a = this.vendors, r = [], e = 0, s = a.length; s > e; e++) n = a[e], r.push(t["" + n + i.charAt(0).toUpperCase() + i.substr(1)] = o);
                    return r
                }.call(this));
                return s
            }, n.prototype.vendorCSS = function(t, e) {
                var i, n, s, a, r, l;
                for (n = o(t), i = n.getPropertyCSSValue(e), l = this.vendors, a = 0, r = l.length; r > a; a++) s = l[a], i = i || n.getPropertyCSSValue("-" + s + "-" + e);
                return i
            }, n.prototype.animationName = function(t) {
                var e;
                try {
                    e = this.vendorCSS(t, "animation-name").cssText
                } catch (i) {
                    e = o(t).getPropertyValue("animation-name")
                }
                return "none" === e ? "" : e
            }, n.prototype.cacheAnimationName = function(t) {
                return this.animationNameCache.set(t, this.animationName(t))
            }, n.prototype.cachedAnimationName = function(t) {
                return this.animationNameCache.get(t)
            }, n.prototype.scrollHandler = function() {
                return this.scrolled = !0
            }, n.prototype.scrollCallback = function() {
                var t;
                return !this.scrolled || (this.scrolled = !1, this.boxes = function() {
                    var e, i, o, n;
                    for (o = this.boxes, n = [], e = 0, i = o.length; i > e; e++) t = o[e], t && (this.isVisible(t) ? this.show(t) : n.push(t));
                    return n
                }.call(this), this.boxes.length || this.config.live) ? void 0 : this.stop()
            }, n.prototype.offsetTop = function(t) {
                for (var e; void 0 === t.offsetTop;) t = t.parentNode;
                for (e = t.offsetTop; t = t.offsetParent;) e += t.offsetTop;
                return e
            }, n.prototype.isVisible = function(t) {
                var e, i, o, n, s;
                return i = t.getAttribute("data-wow-offset") || this.config.offset, s = window.pageYOffset, n = s + Math.min(this.element.clientHeight, this.util().innerHeight()) - i, o = this.offsetTop(t), e = o + t.clientHeight, n >= o && e >= s
            }, n.prototype.util = function() {
                return null != this._util ? this._util : this._util = new e
            }, n.prototype.disabled = function() {
                return !this.config.mobile && this.util().isMobile(navigator.userAgent)
            }, n
        }()
    }.call(this), function(t, e, i, o) {
        "use strict";
        var n = i("html"),
            s = i(t),
            a = i(e),
            r = i.fancybox = function() {
                r.open.apply(this, arguments)
            },
            l = navigator.userAgent.match(/msie/i),
            h = null,
            c = e.createTouch !== o,
            d = function(t) {
                return t && t.hasOwnProperty && t instanceof i
            },
            p = function(t) {
                return t && "string" === i.type(t)
            },
            u = function(t) {
                return p(t) && t.indexOf("%") > 0
            },
            m = function(t) {
                return t && !(t.style.overflow && "hidden" === t.style.overflow) && (t.clientWidth && t.scrollWidth > t.clientWidth || t.clientHeight && t.scrollHeight > t.clientHeight)
            },
            f = function(t, e) {
                var i = parseInt(t, 10) || 0;
                return e && u(t) && (i = r.getViewport()[e] / 100 * i), Math.ceil(i)
            },
            g = function(t, e) {
                return f(t, e) + "px"
            };
        i.extend(r, {
            version: "2.1.5",
            defaults: {
                padding: 15,
                margin: 20,
                width: 800,
                height: 600,
                minWidth: 100,
                minHeight: 100,
                maxWidth: 9999,
                maxHeight: 9999,
                pixelRatio: 1,
                autoSize: !0,
                autoHeight: !1,
                autoWidth: !1,
                autoResize: !0,
                autoCenter: !c,
                fitToView: !0,
                aspectRatio: !1,
                topRatio: .5,
                leftRatio: .5,
                scrolling: "auto",
                wrapCSS: "",
                arrows: !0,
                closeBtn: !0,
                closeClick: !1,
                nextClick: !1,
                mouseWheel: !0,
                autoPlay: !1,
                playSpeed: 3e3,
                preload: 3,
                modal: !1,
                loop: !0,
                ajax: {
                    dataType: "html",
                    headers: {
                        "X-fancyBox": !0
                    }
                },
                iframe: {
                    scrolling: "auto",
                    preload: !0
                },
                swf: {
                    wmode: "transparent",
                    allowfullscreen: "true",
                    allowscriptaccess: "always"
                },
                keys: {
                    next: {
                        13: "left",
                        34: "up",
                        39: "left",
                        40: "up"
                    },
                    prev: {
                        8: "right",
                        33: "down",
                        37: "right",
                        38: "down"
                    },
                    close: [27],
                    play: [32],
                    toggle: [70]
                },
                direction: {
                    next: "left",
                    prev: "right"
                },
                scrollOutside: !0,
                index: 0,
                type: null,
                href: null,
                content: null,
                title: null,
                tpl: {
                    wrap: '<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',
                    image: '<img class="fancybox-image" src="{href}" alt="" />',
                    iframe: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen' + (l ? ' allowtransparency="true"' : "") + "></iframe>",
                    error: '<p class="fancybox-error">The requested content cannot be loaded.<br/>Please try again later.</p>',
                    closeBtn: '<a title="Close" class="fancybox-item fancybox-close" href="javascript:;"></a>',
                    next: '<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
                    prev: '<a title="Previous" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'
                },
                openEffect: "fade",
                openSpeed: 250,
                openEasing: "swing",
                openOpacity: !0,
                openMethod: "zoomIn",
                closeEffect: "fade",
                closeSpeed: 250,
                closeEasing: "swing",
                closeOpacity: !0,
                closeMethod: "zoomOut",
                nextEffect: "elastic",
                nextSpeed: 250,
                nextEasing: "swing",
                nextMethod: "changeIn",
                prevEffect: "elastic",
                prevSpeed: 250,
                prevEasing: "swing",
                prevMethod: "changeOut",
                helpers: {
                    overlay: !0,
                    title: !0
                },
                onCancel: i.noop,
                beforeLoad: i.noop,
                afterLoad: i.noop,
                beforeShow: i.noop,
                afterShow: i.noop,
                beforeChange: i.noop,
                beforeClose: i.noop,
                afterClose: i.noop
            },
            group: {},
            opts: {},
            previous: null,
            coming: null,
            current: null,
            isActive: !1,
            isOpen: !1,
            isOpened: !1,
            wrap: null,
            skin: null,
            outer: null,
            inner: null,
            player: {
                timer: null,
                isActive: !1
            },
            ajaxLoad: null,
            imgPreload: null,
            transitions: {},
            helpers: {},
            open: function(t, e) {
                return t && (i.isPlainObject(e) || (e = {}), !1 !== r.close(!0)) ? (i.isArray(t) || (t = d(t) ? i(t).get() : [t]), i.each(t, function(n, s) {
                    var a, l, h, c, u, m, f, g = {};
                    "object" === i.type(s) && (s.nodeType && (s = i(s)), d(s) ? (g = {
                        href: s.data("fancybox-href") || s.attr("href"),
                        title: s.data("fancybox-title") || s.attr("title"),
                        isDom: !0,
                        element: s
                    }, i.metadata && i.extend(!0, g, s.metadata())) : g = s), a = e.href || g.href || (p(s) ? s : null), l = e.title !== o ? e.title : g.title || "", h = e.content || g.content, c = h ? "html" : e.type || g.type, !c && g.isDom && (c = s.data("fancybox-type"), c || (u = s.prop("class").match(/fancybox\.(\w+)/), c = u ? u[1] : null)), p(a) && (c || (r.isImage(a) ? c = "image" : r.isSWF(a) ? c = "swf" : "#" === a.charAt(0) ? c = "inline" : p(s) && (c = "html", h = s)), "ajax" === c && (m = a.split(/\s+/, 2), a = m.shift(), f = m.shift())), h || ("inline" === c ? a ? h = i(p(a) ? a.replace(/.*(?=#[^\s]+$)/, "") : a) : g.isDom && (h = s) : "html" === c ? h = a : c || a || !g.isDom || (c = "inline", h = s)), i.extend(g, {
                        href: a,
                        type: c,
                        content: h,
                        title: l,
                        selector: f
                    }), t[n] = g
                }), r.opts = i.extend(!0, {}, r.defaults, e), e.keys !== o && (r.opts.keys = e.keys ? i.extend({}, r.defaults.keys, e.keys) : !1), r.group = t, r._start(r.opts.index)) : void 0
            },
            cancel: function() {
                var t = r.coming;
                t && !1 !== r.trigger("onCancel") && (r.hideLoading(), r.ajaxLoad && r.ajaxLoad.abort(), r.ajaxLoad = null, r.imgPreload && (r.imgPreload.onload = r.imgPreload.onerror = null), t.wrap && t.wrap.stop(!0, !0).trigger("onReset").remove(), r.coming = null, r.current || r._afterZoomOut(t))
            },
            close: function(t) {
                r.cancel(), !1 !== r.trigger("beforeClose") && (r.unbindEvents(), r.isActive && (r.isOpen && t !== !0 ? (r.isOpen = r.isOpened = !1, r.isClosing = !0, i(".fancybox-item, .fancybox-nav").remove(), r.wrap.stop(!0, !0).removeClass("fancybox-opened"), r.transitions[r.current.closeMethod]()) : (i(".fancybox-wrap").stop(!0).trigger("onReset").remove(), r._afterZoomOut())))
            },
            play: function(t) {
                var e = function() {
                        clearTimeout(r.player.timer)
                    },
                    i = function() {
                        e(), r.current && r.player.isActive && (r.player.timer = setTimeout(r.next, r.current.playSpeed))
                    },
                    o = function() {
                        e(), a.unbind(".player"), r.player.isActive = !1, r.trigger("onPlayEnd")
                    },
                    n = function() {
                        r.current && (r.current.loop || r.current.index < r.group.length - 1) && (r.player.isActive = !0, a.bind({
                            "onCancel.player beforeClose.player": o,
                            "onUpdate.player": i,
                            "beforeLoad.player": e
                        }), i(), r.trigger("onPlayStart"))
                    };
                t === !0 || !r.player.isActive && t !== !1 ? n() : o()
            },
            next: function(t) {
                var e = r.current;
                e && (p(t) || (t = e.direction.next), r.jumpto(e.index + 1, t, "next"))
            },
            prev: function(t) {
                var e = r.current;
                e && (p(t) || (t = e.direction.prev), r.jumpto(e.index - 1, t, "prev"))
            },
            jumpto: function(t, e, i) {
                var n = r.current;
                n && (t = f(t), r.direction = e || n.direction[t >= n.index ? "next" : "prev"], r.router = i || "jumpto", n.loop && (0 > t && (t = n.group.length + t % n.group.length), t %= n.group.length), n.group[t] !== o && (r.cancel(), r._start(t)))
            },
            reposition: function(t, e) {
                var o, n = r.current,
                    s = n ? n.wrap : null;
                s && (o = r._getPosition(e), t && "scroll" === t.type ? (delete o.position, s.stop(!0, !0).animate(o, 200)) : (s.css(o), n.pos = i.extend({}, n.dim, o)))
            },
            update: function(t) {
                var e = t && t.type,
                    i = !e || "orientationchange" === e;
                i && (clearTimeout(h), h = null), r.isOpen && !h && (h = setTimeout(function() {
                    var o = r.current;
                    o && !r.isClosing && (r.wrap.removeClass("fancybox-tmp"), (i || "load" === e || "resize" === e && o.autoResize) && r._setDimension(), "scroll" === e && o.canShrink || r.reposition(t), r.trigger("onUpdate"), h = null)
                }, i && !c ? 0 : 300))
            },
            toggle: function(t) {
                r.isOpen && (r.current.fitToView = "boolean" === i.type(t) ? t : !r.current.fitToView, c && (r.wrap.removeAttr("style").addClass("fancybox-tmp"), r.trigger("onUpdate")), r.update())
            },
            hideLoading: function() {
                a.unbind(".loading"), i("#fancybox-loading").remove()
            },
            showLoading: function() {
                var t, e;
                r.hideLoading(), t = i('<div id="fancybox-loading"><div></div></div>').click(r.cancel).appendTo("body"), a.bind("keydown.loading", function(t) {
                    27 === (t.which || t.keyCode) && (t.preventDefault(), r.cancel())
                }), r.defaults.fixed || (e = r.getViewport(), t.css({
                    position: "absolute",
                    top: .5 * e.h + e.y,
                    left: .5 * e.w + e.x
                }))
            },
            getViewport: function() {
                var e = r.current && r.current.locked || !1,
                    i = {
                        x: s.scrollLeft(),
                        y: s.scrollTop()
                    };
                return e ? (i.w = e[0].clientWidth, i.h = e[0].clientHeight) : (i.w = c && t.innerWidth ? t.innerWidth : s.width(), i.h = c && t.innerHeight ? t.innerHeight : s.height()), i
            },
            unbindEvents: function() {
                r.wrap && d(r.wrap) && r.wrap.unbind(".fb"), a.unbind(".fb"), s.unbind(".fb")
            },
            bindEvents: function() {
                var t, e = r.current;
                e && (s.bind("orientationchange.fb" + (c ? "" : " resize.fb") + (e.autoCenter && !e.locked ? " scroll.fb" : ""), r.update), t = e.keys, t && a.bind("keydown.fb", function(n) {
                    var s = n.which || n.keyCode,
                        a = n.target || n.srcElement;
                    return 27 === s && r.coming ? !1 : void(n.ctrlKey || n.altKey || n.shiftKey || n.metaKey || a && (a.type || i(a).is("[contenteditable]")) || i.each(t, function(t, a) {
                        return e.group.length > 1 && a[s] !== o ? (r[t](a[s]), n.preventDefault(), !1) : i.inArray(s, a) > -1 ? (r[t](), n.preventDefault(), !1) : void 0
                    }))
                }), i.fn.mousewheel && e.mouseWheel && r.wrap.bind("mousewheel.fb", function(t, o, n, s) {
                    for (var a = t.target || null, l = i(a), h = !1; l.length && !(h || l.is(".fancybox-skin") || l.is(".fancybox-wrap"));) h = m(l[0]), l = i(l).parent();
                    0 === o || h || r.group.length > 1 && !e.canShrink && (s > 0 || n > 0 ? r.prev(s > 0 ? "down" : "left") : (0 > s || 0 > n) && r.next(0 > s ? "up" : "right"), t.preventDefault())
                }))
            },
            trigger: function(t, e) {
                var o, n = e || r.coming || r.current;
                if (n) {
                    if (i.isFunction(n[t]) && (o = n[t].apply(n, Array.prototype.slice.call(arguments, 1))), o === !1) return !1;
                    n.helpers && i.each(n.helpers, function(e, o) {
                        o && r.helpers[e] && i.isFunction(r.helpers[e][t]) && r.helpers[e][t](i.extend(!0, {}, r.helpers[e].defaults, o), n)
                    }), a.trigger(t)
                }
            },
            isImage: function(t) {
                return p(t) && t.match(/(^data:image\/.*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg)((\?|#).*)?$)/i)
            },
            isSWF: function(t) {
                return p(t) && t.match(/\.(swf)((\?|#).*)?$/i)
            },
            _start: function(t) {
                var e, o, n, s, a, l = {};
                if (t = f(t), e = r.group[t] || null, !e) return !1;
                if (l = i.extend(!0, {}, r.opts, e), s = l.margin, a = l.padding, "number" === i.type(s) && (l.margin = [s, s, s, s]), "number" === i.type(a) && (l.padding = [a, a, a, a]), l.modal && i.extend(!0, l, {
                        closeBtn: !1,
                        closeClick: !1,
                        nextClick: !1,
                        arrows: !1,
                        mouseWheel: !1,
                        keys: null,
                        helpers: {
                            overlay: {
                                closeClick: !1
                            }
                        }
                    }), l.autoSize && (l.autoWidth = l.autoHeight = !0), "auto" === l.width && (l.autoWidth = !0), "auto" === l.height && (l.autoHeight = !0), l.group = r.group, l.index = t, r.coming = l, !1 === r.trigger("beforeLoad")) return void(r.coming = null);
                if (n = l.type, o = l.href, !n) return r.coming = null, r.current && r.router && "jumpto" !== r.router ? (r.current.index = t, r[r.router](r.direction)) : !1;
                if (r.isActive = !0, ("image" === n || "swf" === n) && (l.autoHeight = l.autoWidth = !1, l.scrolling = "visible"), "image" === n && (l.aspectRatio = !0), "iframe" === n && c && (l.scrolling = "scroll"), l.wrap = i(l.tpl.wrap).addClass("fancybox-" + (c ? "mobile" : "desktop") + " fancybox-type-" + n + " fancybox-tmp " + l.wrapCSS).appendTo(l.parent || "body"), i.extend(l, {
                        skin: i(".fancybox-skin", l.wrap),
                        outer: i(".fancybox-outer", l.wrap),
                        inner: i(".fancybox-inner", l.wrap)
                    }), i.each(["Top", "Right", "Bottom", "Left"], function(t, e) {
                        l.skin.css("padding" + e, g(l.padding[t]))
                    }), r.trigger("onReady"), "inline" === n || "html" === n) {
                    if (!l.content || !l.content.length) return r._error("content")
                } else if (!o) return r._error("href");
                "image" === n ? r._loadImage() : "ajax" === n ? r._loadAjax() : "iframe" === n ? r._loadIframe() : r._afterLoad()
            },
            _error: function(t) {
                i.extend(r.coming, {
                    type: "html",
                    autoWidth: !0,
                    autoHeight: !0,
                    minWidth: 0,
                    minHeight: 0,
                    scrolling: "no",
                    hasError: t,
                    content: r.coming.tpl.error
                }), r._afterLoad()
            },
            _loadImage: function() {
                var t = r.imgPreload = new Image;
                t.onload = function() {
                    this.onload = this.onerror = null, r.coming.width = this.width / r.opts.pixelRatio, r.coming.height = this.height / r.opts.pixelRatio, r._afterLoad()
                }, t.onerror = function() {
                    this.onload = this.onerror = null, r._error("image")
                }, t.src = r.coming.href, t.complete !== !0 && r.showLoading()
            },
            _loadAjax: function() {
                var t = r.coming;
                r.showLoading(), r.ajaxLoad = i.ajax(i.extend({}, t.ajax, {
                    url: t.href,
                    error: function(t, e) {
                        r.coming && "abort" !== e ? r._error("ajax", t) : r.hideLoading()
                    },
                    success: function(e, i) {
                        "success" === i && (t.content = e, r._afterLoad())
                    }
                }))
            },
            _loadIframe: function() {
                var t = r.coming,
                    e = i(t.tpl.iframe.replace(/\{rnd\}/g, (new Date).getTime())).attr("scrolling", c ? "auto" : t.iframe.scrolling).attr("src", t.href);
                i(t.wrap).bind("onReset", function() {
                    try {
                        i(this).find("iframe").hide().attr("src", "//about:blank").end().empty()
                    } catch (t) {}
                }), t.iframe.preload && (r.showLoading(), e.one("load", function() {
                    i(this).data("ready", 1), c || i(this).bind("load.fb", r.update), i(this).parents(".fancybox-wrap").width("100%").removeClass("fancybox-tmp").show(), r._afterLoad()
                })), t.content = e.appendTo(t.inner), t.iframe.preload || r._afterLoad()
            },
            _preloadImages: function() {
                var t, e, i = r.group,
                    o = r.current,
                    n = i.length,
                    s = o.preload ? Math.min(o.preload, n - 1) : 0;
                for (e = 1; s >= e; e += 1) t = i[(o.index + e) % n], "image" === t.type && t.href && ((new Image).src = t.href)
            },
            _afterLoad: function() {
                var t, e, o, n, s, a, l = r.coming,
                    h = r.current,
                    c = "fancybox-placeholder";
                if (r.hideLoading(), l && r.isActive !== !1) {
                    if (!1 === r.trigger("afterLoad", l, h)) return l.wrap.stop(!0).trigger("onReset").remove(), void(r.coming = null);
                    switch (h && (r.trigger("beforeChange", h), h.wrap.stop(!0).removeClass("fancybox-opened").find(".fancybox-item, .fancybox-nav").remove()), r.unbindEvents(), t = l, e = l.content, o = l.type, n = l.scrolling, i.extend(r, {
                        wrap: t.wrap,
                        skin: t.skin,
                        outer: t.outer,
                        inner: t.inner,
                        current: t,
                        previous: h
                    }), s = t.href, o) {
                        case "inline":
                        case "ajax":
                        case "html":
                            t.selector ? e = i("<div>").html(e).find(t.selector) : d(e) && (e.data(c) || e.data(c, i('<div class="' + c + '"></div>').insertAfter(e).hide()), e = e.show().detach(), t.wrap.bind("onReset", function() {
                                i(this).find(e).length && e.hide().replaceAll(e.data(c)).data(c, !1)
                            }));
                            break;
                        case "image":
                            e = t.tpl.image.replace("{href}", s);
                            break;
                        case "swf":
                            e = '<object id="fancybox-swf" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%"><param name="movie" value="' + s + '"></param>', a = "", i.each(t.swf, function(t, i) {
                                e += '<param name="' + t + '" value="' + i + '"></param>', a += " " + t + '="' + i + '"'
                            }), e += '<embed src="' + s + '" type="application/x-shockwave-flash" width="100%" height="100%"' + a + "></embed></object>"
                    }
                    d(e) && e.parent().is(t.inner) || t.inner.append(e), r.trigger("beforeShow"), t.inner.css("overflow", "yes" === n ? "scroll" : "no" === n ? "hidden" : n), r._setDimension(), r.reposition(), r.isOpen = !1, r.coming = null, r.bindEvents(), r.isOpened ? h.prevMethod && r.transitions[h.prevMethod]() : i(".fancybox-wrap").not(t.wrap).stop(!0).trigger("onReset").remove(), r.transitions[r.isOpened ? t.nextMethod : t.openMethod](), r._preloadImages()
                }
            },
            _setDimension: function() {
                var t, e, o, n, s, a, l, h, c, d, p, m, v, w, y, b = r.getViewport(),
                    x = 0,
                    z = !1,
                    _ = !1,
                    C = r.wrap,
                    k = r.skin,
                    T = r.inner,
                    S = r.current,
                    $ = S.width,
                    W = S.height,
                    L = S.minWidth,
                    E = S.minHeight,
                    O = S.maxWidth,
                    H = S.maxHeight,
                    R = S.scrolling,
                    P = S.scrollOutside ? S.scrollbarWidth : 0,
                    I = S.margin,
                    D = f(I[1] + I[3]),
                    M = f(I[0] + I[2]);
                if (C.add(k).add(T).width("auto").height("auto").removeClass("fancybox-tmp"), t = f(k.outerWidth(!0) - k.width()), e = f(k.outerHeight(!0) - k.height()), o = D + t, n = M + e, s = u($) ? (b.w - o) * f($) / 100 : $, a = u(W) ? (b.h - n) * f(W) / 100 : W, "iframe" === S.type) {
                    if (w = S.content, S.autoHeight && 1 === w.data("ready")) try {
                        w[0].contentWindow.document.location && (T.width(s).height(9999), y = w.contents().find("body"), P && y.css("overflow-x", "hidden"), a = y.outerHeight(!0))
                    } catch (A) {}
                } else(S.autoWidth || S.autoHeight) && (T.addClass("fancybox-tmp"), S.autoWidth || T.width(s), S.autoHeight || T.height(a), S.autoWidth && (s = T.width()), S.autoHeight && (a = T.height()), T.removeClass("fancybox-tmp"));
                if ($ = f(s), W = f(a), c = s / a, L = f(u(L) ? f(L, "w") - o : L), O = f(u(O) ? f(O, "w") - o : O), E = f(u(E) ? f(E, "h") - n : E), H = f(u(H) ? f(H, "h") - n : H), l = O, h = H, S.fitToView && (O = Math.min(b.w - o, O), H = Math.min(b.h - n, H)), m = b.w - D, v = b.h - M, S.aspectRatio ? ($ > O && ($ = O, W = f($ / c)), W > H && (W = H, $ = f(W * c)), L > $ && ($ = L, W = f($ / c)), E > W && (W = E, $ = f(W * c))) : ($ = Math.max(L, Math.min($, O)), S.autoHeight && "iframe" !== S.type && (T.width($), W = T.height()), W = Math.max(E, Math.min(W, H))), S.fitToView)
                    if (T.width($).height(W), C.width($ + t), d = C.width(), p = C.height(), S.aspectRatio)
                        for (;
                            (d > m || p > v) && $ > L && W > E && !(x++ > 19);) W = Math.max(E, Math.min(H, W - 10)), $ = f(W * c), L > $ && ($ = L, W = f($ / c)), $ > O && ($ = O, W = f($ / c)), T.width($).height(W), C.width($ + t), d = C.width(), p = C.height();
                    else $ = Math.max(L, Math.min($, $ - (d - m))), W = Math.max(E, Math.min(W, W - (p - v)));
                P && "auto" === R && a > W && m > $ + t + P && ($ += P), T.width($).height(W), C.width($ + t), d = C.width(), p = C.height(), z = (d > m || p > v) && $ > L && W > E, _ = S.aspectRatio ? l > $ && h > W && s > $ && a > W : (l > $ || h > W) && (s > $ || a > W), i.extend(S, {
                    dim: {
                        width: g(d),
                        height: g(p)
                    },
                    origWidth: s,
                    origHeight: a,
                    canShrink: z,
                    canExpand: _,
                    wPadding: t,
                    hPadding: e,
                    wrapSpace: p - k.outerHeight(!0),
                    skinSpace: k.height() - W
                }), !w && S.autoHeight && W > E && H > W && !_ && T.height("auto")
            },
            _getPosition: function(t) {
                var e = r.current,
                    i = r.getViewport(),
                    o = e.margin,
                    n = r.wrap.width() + o[1] + o[3],
                    s = r.wrap.height() + o[0] + o[2],
                    a = {
                        position: "absolute",
                        top: o[0],
                        left: o[3]
                    };
                return e.autoCenter && e.fixed && !t && s <= i.h && n <= i.w ? a.position = "fixed" : e.locked || (a.top += i.y, a.left += i.x), a.top = g(Math.max(a.top, a.top + (i.h - s) * e.topRatio)), a.left = g(Math.max(a.left, a.left + (i.w - n) * e.leftRatio)), a
            },
            _afterZoomIn: function() {
                var t = r.current;
                t && (r.isOpen = r.isOpened = !0, r.wrap.css("overflow", "visible").addClass("fancybox-opened"), r.update(), (t.closeClick || t.nextClick && r.group.length > 1) && r.inner.css("cursor", "pointer").bind("click.fb", function(e) {
                    i(e.target).is("a") || i(e.target).parent().is("a") || (e.preventDefault(), r[t.closeClick ? "close" : "next"]())
                }), t.closeBtn && i(t.tpl.closeBtn).appendTo(r.skin).bind("click.fb", function(t) {
                    t.preventDefault(), r.close()
                }), t.arrows && r.group.length > 1 && ((t.loop || t.index > 0) && i(t.tpl.prev).appendTo(r.outer).bind("click.fb", r.prev), (t.loop || t.index < r.group.length - 1) && i(t.tpl.next).appendTo(r.outer).bind("click.fb", r.next)), r.trigger("afterShow"), t.loop || t.index !== t.group.length - 1 ? r.opts.autoPlay && !r.player.isActive && (r.opts.autoPlay = !1, r.play()) : r.play(!1))
            },
            _afterZoomOut: function(t) {
                t = t || r.current, i(".fancybox-wrap").trigger("onReset").remove(), i.extend(r, {
                    group: {},
                    opts: {},
                    router: !1,
                    current: null,
                    isActive: !1,
                    isOpened: !1,
                    isOpen: !1,
                    isClosing: !1,
                    wrap: null,
                    skin: null,
                    outer: null,
                    inner: null
                }), r.trigger("afterClose", t)
            }
        }), r.transitions = {
            getOrigPosition: function() {
                var t = r.current,
                    e = t.element,
                    i = t.orig,
                    o = {},
                    n = 50,
                    s = 50,
                    a = t.hPadding,
                    l = t.wPadding,
                    h = r.getViewport();
                return !i && t.isDom && e.is(":visible") && (i = e.find("img:first"), i.length || (i = e)), d(i) ? (o = i.offset(), i.is("img") && (n = i.outerWidth(), s = i.outerHeight())) : (o.top = h.y + (h.h - s) * t.topRatio, o.left = h.x + (h.w - n) * t.leftRatio), ("fixed" === r.wrap.css("position") || t.locked) && (o.top -= h.y, o.left -= h.x), o = {
                    top: g(o.top - a * t.topRatio),
                    left: g(o.left - l * t.leftRatio),
                    width: g(n + l),
                    height: g(s + a)
                }
            },
            step: function(t, e) {
                var i, o, n, s = e.prop,
                    a = r.current,
                    l = a.wrapSpace,
                    h = a.skinSpace;
                ("width" === s || "height" === s) && (i = e.end === e.start ? 1 : (t - e.start) / (e.end - e.start), r.isClosing && (i = 1 - i), o = "width" === s ? a.wPadding : a.hPadding, n = t - o, r.skin[s](f("width" === s ? n : n - l * i)), r.inner[s](f("width" === s ? n : n - l * i - h * i)))
            },
            zoomIn: function() {
                var t = r.current,
                    e = t.pos,
                    o = t.openEffect,
                    n = "elastic" === o,
                    s = i.extend({
                        opacity: 1
                    }, e);
                delete s.position, n ? (e = this.getOrigPosition(), t.openOpacity && (e.opacity = .1)) : "fade" === o && (e.opacity = .1), r.wrap.css(e).animate(s, {
                    duration: "none" === o ? 0 : t.openSpeed,
                    easing: t.openEasing,
                    step: n ? this.step : null,
                    complete: r._afterZoomIn
                })
            },
            zoomOut: function() {
                var t = r.current,
                    e = t.closeEffect,
                    i = "elastic" === e,
                    o = {
                        opacity: .1
                    };
                i && (o = this.getOrigPosition(), t.closeOpacity && (o.opacity = .1)), r.wrap.animate(o, {
                    duration: "none" === e ? 0 : t.closeSpeed,
                    easing: t.closeEasing,
                    step: i ? this.step : null,
                    complete: r._afterZoomOut
                })
            },
            changeIn: function() {
                var t, e = r.current,
                    i = e.nextEffect,
                    o = e.pos,
                    n = {
                        opacity: 1
                    },
                    s = r.direction,
                    a = 200;
                o.opacity = .1, "elastic" === i && (t = "down" === s || "up" === s ? "top" : "left", "down" === s || "right" === s ? (o[t] = g(f(o[t]) - a), n[t] = "+=" + a + "px") : (o[t] = g(f(o[t]) + a), n[t] = "-=" + a + "px")), "none" === i ? r._afterZoomIn() : r.wrap.css(o).animate(n, {
                    duration: e.nextSpeed,
                    easing: e.nextEasing,
                    complete: r._afterZoomIn
                })
            },
            changeOut: function() {
                var t = r.previous,
                    e = t.prevEffect,
                    o = {
                        opacity: .1
                    },
                    n = r.direction,
                    s = 200;
                "elastic" === e && (o["down" === n || "up" === n ? "top" : "left"] = ("up" === n || "left" === n ? "-" : "+") + "=" + s + "px"), t.wrap.animate(o, {
                    duration: "none" === e ? 0 : t.prevSpeed,
                    easing: t.prevEasing,
                    complete: function() {
                        i(this).trigger("onReset").remove()
                    }
                })
            }
        }, r.helpers.overlay = {
            defaults: {
                closeClick: !0,
                speedOut: 200,
                showEarly: !0,
                css: {},
                locked: !c,
                fixed: !0
            },
            overlay: null,
            fixed: !1,
            el: i("html"),
            create: function(t) {
                t = i.extend({}, this.defaults, t), this.overlay && this.close(), this.overlay = i('<div class="fancybox-overlay"></div>').appendTo(r.coming ? r.coming.parent : t.parent), this.fixed = !1, t.fixed && r.defaults.fixed && (this.overlay.addClass("fancybox-overlay-fixed"), this.fixed = !0)
            },
            open: function(t) {
                var e = this;
                t = i.extend({}, this.defaults, t), this.overlay ? this.overlay.unbind(".overlay").width("auto").height("auto") : this.create(t), this.fixed || (s.bind("resize.overlay", i.proxy(this.update, this)), this.update()), t.closeClick && this.overlay.bind("click.overlay", function(t) {
                    return i(t.target).hasClass("fancybox-overlay") ? (r.isActive ? r.close() : e.close(), !1) : void 0
                }), this.overlay.css(t.css).show()
            },
            close: function() {
                var t, e;
                s.unbind("resize.overlay"), this.el.hasClass("fancybox-lock") && (i(".fancybox-margin").removeClass("fancybox-margin"), t = s.scrollTop(), e = s.scrollLeft(), this.el.removeClass("fancybox-lock"), s.scrollTop(t).scrollLeft(e)), i(".fancybox-overlay").remove().hide(), i.extend(this, {
                    overlay: null,
                    fixed: !1
                })
            },
            update: function() {
                var t, i = "100%";
                this.overlay.width(i).height("100%"), l ? (t = Math.max(e.documentElement.offsetWidth, e.body.offsetWidth), a.width() > t && (i = a.width())) : a.width() > s.width() && (i = a.width()), this.overlay.width(i).height(a.height())
            },
            onReady: function(t, e) {
                var o = this.overlay;
                i(".fancybox-overlay").stop(!0, !0), o || this.create(t), t.locked && this.fixed && e.fixed && (o || (this.margin = a.height() > s.height() ? i("html").css("margin-right").replace("px", "") : !1), e.locked = this.overlay.append(e.wrap), e.fixed = !1), t.showEarly === !0 && this.beforeShow.apply(this, arguments)
            },
            beforeShow: function(t, e) {
                var o, n;
                e.locked && (this.margin !== !1 && (i("*").filter(function() {
                    return "fixed" === i(this).css("position") && !i(this).hasClass("fancybox-overlay") && !i(this).hasClass("fancybox-wrap")
                }).addClass("fancybox-margin"), this.el.addClass("fancybox-margin")), o = s.scrollTop(), n = s.scrollLeft(), this.el.addClass("fancybox-lock"), s.scrollTop(o).scrollLeft(n)), this.open(t)
            },
            onUpdate: function() {
                this.fixed || this.update()
            },
            afterClose: function(t) {
                this.overlay && !r.coming && this.overlay.fadeOut(t.speedOut, i.proxy(this.close, this))
            }
        }, r.helpers.title = {
            defaults: {
                type: "float",
                position: "bottom"
            },
            beforeShow: function(t) {
                var e, o, n = r.current,
                    s = n.title,
                    a = t.type;
                if (i.isFunction(s) && (s = s.call(n.element, n)), p(s) && "" !== i.trim(s)) {
                    switch (e = i('<div class="fancybox-title fancybox-title-' + a + '-wrap">' + s + "</div>"), a) {
                        case "inside":
                            o = r.skin;
                            break;
                        case "outside":
                            o = r.wrap;
                            break;
                        case "over":
                            o = r.inner;
                            break;
                        default:
                            o = r.skin, e.appendTo("body"), l && e.width(e.width()), e.wrapInner('<span class="child"></span>'), r.current.margin[2] += Math.abs(f(e.css("margin-bottom")))
                    }
                    e["top" === t.position ? "prependTo" : "appendTo"](o)
                }
            }
        }, i.fn.fancybox = function(t) {
            var e, o = i(this),
                n = this.selector || "",
                s = function(s) {
                    var a, l, h = i(this).blur(),
                        c = e;
                    s.ctrlKey || s.altKey || s.shiftKey || s.metaKey || h.is(".fancybox-wrap") || (a = t.groupAttr || "data-fancybox-group", l = h.attr(a), l || (a = "rel", l = h.get(0)[a]), l && "" !== l && "nofollow" !== l && (h = n.length ? i(n) : o, h = h.filter("[" + a + '="' + l + '"]'), c = h.index(this)), t.index = c, r.open(h, t) !== !1 && s.preventDefault())
                };
            return t = t || {}, e = t.index || 0, n && t.live !== !1 ? a.undelegate(n, "click.fb-start").delegate(n + ":not('.fancybox-item, .fancybox-nav')", "click.fb-start", s) : o.unbind("click.fb-start").bind("click.fb-start", s), this.filter("[data-fancybox-start=1]").trigger("click"), this
        }, a.ready(function() {
            var e, s;
            i.scrollbarWidth === o && (i.scrollbarWidth = function() {
                var t = i('<div style="width:50px;height:50px;overflow:auto"><div/></div>').appendTo("body"),
                    e = t.children(),
                    o = e.innerWidth() - e.height(99).innerWidth();
                return t.remove(), o
            }), i.support.fixedPosition === o && (i.support.fixedPosition = function() {
                var t = i('<div style="position:fixed;top:20px;"></div>').appendTo("body"),
                    e = 20 === t[0].offsetTop || 15 === t[0].offsetTop;
                return t.remove(), e
            }()), i.extend(r.defaults, {
                scrollbarWidth: i.scrollbarWidth(),
                fixed: i.support.fixedPosition,
                parent: i("body")
            }), e = i(t).width(), n.addClass("fancybox-lock-test"), s = i(t).width(), n.removeClass("fancybox-lock-test"), i("<style type='text/css'>.fancybox-margin{margin-right:" + (s - e) + "px;}</style>").appendTo("head")
        })
    }(window, document, jQuery), function(t) {
        function e(e) {
            var i = e || window.event,
                o = [].slice.call(arguments, 1),
                n = 0,
                s = 0,
                a = 0,
                e = t.event.fix(i);
            return e.type = "mousewheel", i.wheelDelta && (n = i.wheelDelta / 120), i.detail && (n = -i.detail / 3), a = n, void 0 !== i.axis && i.axis === i.HORIZONTAL_AXIS && (a = 0, s = -1 * n), void 0 !== i.wheelDeltaY && (a = i.wheelDeltaY / 120), void 0 !== i.wheelDeltaX && (s = -1 * i.wheelDeltaX / 120), o.unshift(e, n, s, a), (t.event.dispatch || t.event.handle).apply(this, o)
        }
        var i = ["DOMMouseScroll", "mousewheel"];
        if (t.event.fixHooks)
            for (var o = i.length; o;) t.event.fixHooks[i[--o]] = t.event.mouseHooks;
        t.event.special.mousewheel = {
            setup: function() {
                if (this.addEventListener)
                    for (var t = i.length; t;) this.addEventListener(i[--t], e, !1);
                else this.onmousewheel = e
            },
            teardown: function() {
                if (this.removeEventListener)
                    for (var t = i.length; t;) this.removeEventListener(i[--t], e, !1);
                else this.onmousewheel = null
            }
        }, t.fn.extend({
            mousewheel: function(t) {
                return t ? this.bind("mousewheel", t) : this.trigger("mousewheel")
            },
            unmousewheel: function(t) {
                return this.unbind("mousewheel", t)
            }
        })
    }(jQuery), function(t) {
        "use strict";
        var e = t.fancybox,
            i = function(e, i, o) {
                return o = o || "", "object" === t.type(o) && (o = t.param(o, !0)), t.each(i, function(t, i) {
                    e = e.replace("$" + t, i || "")
                }), o.length && (e += (e.indexOf("?") > 0 ? "&" : "?") + o), e
            };
        e.helpers.media = {
            defaults: {
                youtube: {
                    matcher: /(youtube\.com|youtu\.be|youtube-nocookie\.com)\/(watch\?v=|v\/|u\/|embed\/?)?(videoseries\?list=(.*)|[\w-]{11}|\?listType=(.*)&list=(.*)).*/i,
                    params: {
                        autoplay: 1,
                        autohide: 1,
                        fs: 1,
                        rel: 0,
                        hd: 1,
                        wmode: "opaque",
                        enablejsapi: 1
                    },
                    type: "iframe",
                    url: "//www.youtube.com/embed/$3"
                },
                vimeo: {
                    matcher: /(?:vimeo(?:pro)?.com)\/(?:[^\d]+)?(\d+)(?:.*)/,
                    params: {
                        autoplay: 1,
                        hd: 1,
                        show_title: 1,
                        show_byline: 1,
                        show_portrait: 0,
                        fullscreen: 1
                    },
                    type: "iframe",
                    url: "//player.vimeo.com/video/$1"
                },
                metacafe: {
                    matcher: /metacafe.com\/(?:watch|fplayer)\/([\w\-]{1,10})/,
                    params: {
                        autoPlay: "yes"
                    },
                    type: "swf",
                    url: function(e, i, o) {
                        return o.swf.flashVars = "playerVars=" + t.param(i, !0), "//www.metacafe.com/fplayer/" + e[1] + "/.swf"
                    }
                },
                dailymotion: {
                    matcher: /dailymotion.com\/video\/(.*)\/?(.*)/,
                    params: {
                        additionalInfos: 0,
                        autoStart: 1
                    },
                    type: "swf",
                    url: "//www.dailymotion.com/swf/video/$1"
                },
                twitvid: {
                    matcher: /twitvid\.com\/([a-zA-Z0-9_\-\?\=]+)/i,
                    params: {
                        autoplay: 0
                    },
                    type: "iframe",
                    url: "//www.twitvid.com/embed.php?guid=$1"
                },
                twitpic: {
                    matcher: /twitpic\.com\/(?!(?:place|photos|events)\/)([a-zA-Z0-9\?\=\-]+)/i,
                    type: "image",
                    url: "//twitpic.com/show/full/$1/"
                },
                instagram: {
                    matcher: /(instagr\.am|instagram\.com)\/p\/([a-zA-Z0-9_\-]+)\/?/i,
                    type: "image",
                    url: "//$1/p/$2/media/?size=l"
                },
                google_maps: {
                    matcher: /maps\.google\.([a-z]{2,3}(\.[a-z]{2})?)\/(\?ll=|maps\?)(.*)/i,
                    type: "iframe",
                    url: function(t) {
                        return "//maps.google." + t[1] + "/" + t[3] + t[4] + "&output=" + (t[4].indexOf("layer=c") > 0 ? "svembed" : "embed")
                    }
                }
            },
            beforeLoad: function(e, o) {
                var n, s, a, r, l = o.href || "",
                    h = !1;
                for (n in e)
                    if (e.hasOwnProperty(n) && (s = e[n], a = l.match(s.matcher))) {
                        h = s.type, r = t.extend(!0, {}, s.params, o[n] || (t.isPlainObject(e[n]) ? e[n].params : null)), l = "function" === t.type(s.url) ? s.url.call(this, a, r, o) : i(s.url, a, r);
                        break
                    }
                h && (o.href = l, o.type = h, o.autoHeight = !1)
            }
        }
    }(jQuery), "undefined" == typeof jQuery) throw new Error("Bootstrap's JavaScript requires jQuery"); + function(t) {
    "use strict";

    function e() {
        var t = document.createElement("bootstrap"),
            e = {
                WebkitTransition: "webkitTransitionEnd",
                MozTransition: "transitionend",
                OTransition: "oTransitionEnd otransitionend",
                transition: "transitionend"
            };
        for (var i in e)
            if (void 0 !== t.style[i]) return {
                end: e[i]
            };
        return !1
    }
    t.fn.emulateTransitionEnd = function(e) {
        var i = !1,
            o = this;
        t(this).one("bsTransitionEnd", function() {
            i = !0
        });
        var n = function() {
            i || t(o).trigger(t.support.transition.end)
        };
        return setTimeout(n, e), this
    }, t(function() {
        t.support.transition = e(), t.support.transition && (t.event.special.bsTransitionEnd = {
            bindType: t.support.transition.end,
            delegateType: t.support.transition.end,
            handle: function(e) {
                return t(e.target).is(this) ? e.handleObj.handler.apply(this, arguments) : void 0
            }
        })
    })
}(jQuery), + function(t) {
    "use strict";

    function e(e) {
        return this.each(function() {
            var i = t(this),
                n = i.data("bs.alert");
            n || i.data("bs.alert", n = new o(this)), "string" == typeof e && n[e].call(i)
        })
    }
    var i = '[data-dismiss="alert"]',
        o = function(e) {
            t(e).on("click", i, this.close)
        };
    o.VERSION = "3.2.0", o.prototype.close = function(e) {
        function i() {
            s.detach().trigger("closed.bs.alert").remove()
        }
        var o = t(this),
            n = o.attr("data-target");
        n || (n = o.attr("href"), n = n && n.replace(/.*(?=#[^\s]*$)/, ""));
        var s = t(n);
        e && e.preventDefault(), s.length || (s = o.hasClass("alert") ? o : o.parent()), s.trigger(e = t.Event("close.bs.alert")), e.isDefaultPrevented() || (s.removeClass("in"), t.support.transition && s.hasClass("fade") ? s.one("bsTransitionEnd", i).emulateTransitionEnd(150) : i())
    };
    var n = t.fn.alert;
    t.fn.alert = e, t.fn.alert.Constructor = o, t.fn.alert.noConflict = function() {
        return t.fn.alert = n, this
    }, t(document).on("click.bs.alert.data-api", i, o.prototype.close)
}(jQuery), + function(t) {
    "use strict";

    function e(e) {
        return this.each(function() {
            var o = t(this),
                n = o.data("bs.button"),
                s = "object" == typeof e && e;
            n || o.data("bs.button", n = new i(this, s)), "toggle" == e ? n.toggle() : e && n.setState(e)
        })
    }
    var i = function(e, o) {
        this.$element = t(e), this.options = t.extend({}, i.DEFAULTS, o), this.isLoading = !1
    };
    i.VERSION = "3.2.0", i.DEFAULTS = {
        loadingText: "loading..."
    }, i.prototype.setState = function(e) {
        var i = "disabled",
            o = this.$element,
            n = o.is("input") ? "val" : "html",
            s = o.data();
        e += "Text", null == s.resetText && o.data("resetText", o[n]()), o[n](null == s[e] ? this.options[e] : s[e]), setTimeout(t.proxy(function() {
            "loadingText" == e ? (this.isLoading = !0, o.addClass(i).attr(i, i)) : this.isLoading && (this.isLoading = !1, o.removeClass(i).removeAttr(i))
        }, this), 0)
    }, i.prototype.toggle = function() {
        var t = !0,
            e = this.$element.closest('[data-toggle="buttons"]');
        if (e.length) {
            var i = this.$element.find("input");
            "radio" == i.prop("type") && (i.prop("checked") && this.$element.hasClass("active") ? t = !1 : e.find(".active").removeClass("active")), t && i.prop("checked", !this.$element.hasClass("active")).trigger("change")
        }
        t && this.$element.toggleClass("active")
    };
    var o = t.fn.button;
    t.fn.button = e, t.fn.button.Constructor = i, t.fn.button.noConflict = function() {
        return t.fn.button = o, this
    }, t(document).on("click.bs.button.data-api", '[data-toggle^="button"]', function(i) {
        var o = t(i.target);
        o.hasClass("btn") || (o = o.closest(".btn")), e.call(o, "toggle"), i.preventDefault()
    })
}(jQuery), + function(t) {
    "use strict";

    function e(e) {
        return this.each(function() {
            var o = t(this),
                n = o.data("bs.carousel"),
                s = t.extend({}, i.DEFAULTS, o.data(), "object" == typeof e && e),
                a = "string" == typeof e ? e : s.slide;
            n || o.data("bs.carousel", n = new i(this, s)), "number" == typeof e ? n.to(e) : a ? n[a]() : s.interval && n.pause().cycle()
        })
    }
    var i = function(e, i) {
        this.$element = t(e).on("keydown.bs.carousel", t.proxy(this.keydown, this)), this.$indicators = this.$element.find(".carousel-indicators"), this.options = i, this.paused = this.sliding = this.interval = this.$active = this.$items = null, "hover" == this.options.pause && this.$element.on("mouseenter.bs.carousel", t.proxy(this.pause, this)).on("mouseleave.bs.carousel", t.proxy(this.cycle, this))
    };
    i.VERSION = "3.2.0", i.DEFAULTS = {
        interval: 5e3,
        pause: "hover",
        wrap: !0
    }, i.prototype.keydown = function(t) {
        switch (t.which) {
            case 37:
                this.prev();
                break;
            case 39:
                this.next();
                break;
            default:
                return
        }
        t.preventDefault()
    }, i.prototype.cycle = function(e) {
        return e || (this.paused = !1), this.interval && clearInterval(this.interval), this.options.interval && !this.paused && (this.interval = setInterval(t.proxy(this.next, this), this.options.interval)), this
    }, i.prototype.getItemIndex = function(t) {
        return this.$items = t.parent().children(".item"), this.$items.index(t || this.$active)
    }, i.prototype.to = function(e) {
        var i = this,
            o = this.getItemIndex(this.$active = this.$element.find(".item.active"));
        return e > this.$items.length - 1 || 0 > e ? void 0 : this.sliding ? this.$element.one("slid.bs.carousel", function() {
            i.to(e)
        }) : o == e ? this.pause().cycle() : this.slide(e > o ? "next" : "prev", t(this.$items[e]))
    }, i.prototype.pause = function(e) {
        return e || (this.paused = !0), this.$element.find(".next, .prev").length && t.support.transition && (this.$element.trigger(t.support.transition.end), this.cycle(!0)), this.interval = clearInterval(this.interval), this
    }, i.prototype.next = function() {
        return this.sliding ? void 0 : this.slide("next")
    }, i.prototype.prev = function() {
        return this.sliding ? void 0 : this.slide("prev")
    }, i.prototype.slide = function(e, i) {
        var o = this.$element.find(".item.active"),
            n = i || o[e](),
            s = this.interval,
            a = "next" == e ? "left" : "right",
            r = "next" == e ? "first" : "last",
            l = this;
        if (!n.length) {
            if (!this.options.wrap) return;
            n = this.$element.find(".item")[r]()
        }
        if (n.hasClass("active")) return this.sliding = !1;
        var h = n[0],
            c = t.Event("slide.bs.carousel", {
                relatedTarget: h,
                direction: a
            });
        if (this.$element.trigger(c), !c.isDefaultPrevented()) {
            if (this.sliding = !0, s && this.pause(), this.$indicators.length) {
                this.$indicators.find(".active").removeClass("active");
                var d = t(this.$indicators.children()[this.getItemIndex(n)]);
                d && d.addClass("active")
            }
            var p = t.Event("slid.bs.carousel", {
                relatedTarget: h,
                direction: a
            });
            return t.support.transition && this.$element.hasClass("slide") ? (n.addClass(e), n[0].offsetWidth, o.addClass(a), n.addClass(a), o.one("bsTransitionEnd", function() {
                n.removeClass([e, a].join(" ")).addClass("active"), o.removeClass(["active", a].join(" ")), l.sliding = !1, setTimeout(function() {
                    l.$element.trigger(p)
                }, 0)
            }).emulateTransitionEnd(1e3 * o.css("transition-duration").slice(0, -1))) : (o.removeClass("active"), n.addClass("active"), this.sliding = !1, this.$element.trigger(p)), s && this.cycle(), this
        }
    };
    var o = t.fn.carousel;
    t.fn.carousel = e, t.fn.carousel.Constructor = i, t.fn.carousel.noConflict = function() {
        return t.fn.carousel = o, this
    }, t(document).on("click.bs.carousel.data-api", "[data-slide], [data-slide-to]", function(i) {
        var o, n = t(this),
            s = t(n.attr("data-target") || (o = n.attr("href")) && o.replace(/.*(?=#[^\s]+$)/, ""));
        if (s.hasClass("carousel")) {
            var a = t.extend({}, s.data(), n.data()),
                r = n.attr("data-slide-to");
            r && (a.interval = !1), e.call(s, a), r && s.data("bs.carousel").to(r), i.preventDefault()
        }
    }), t(window).on("load", function() {
        t('[data-ride="carousel"]').each(function() {
            var i = t(this);
            e.call(i, i.data())
        })
    })
}(jQuery), + function(t) {
    "use strict";

    function e(e) {
        return this.each(function() {
            var o = t(this),
                n = o.data("bs.collapse"),
                s = t.extend({}, i.DEFAULTS, o.data(), "object" == typeof e && e);
            !n && s.toggle && "show" == e && (e = !e), n || o.data("bs.collapse", n = new i(this, s)), "string" == typeof e && n[e]()
        })
    }
    var i = function(e, o) {
        this.$element = t(e), this.options = t.extend({}, i.DEFAULTS, o), this.transitioning = null, this.options.parent && (this.$parent = t(this.options.parent)), this.options.toggle && this.toggle()
    };
    i.VERSION = "3.2.0", i.DEFAULTS = {
        toggle: !0
    }, i.prototype.dimension = function() {
        var t = this.$element.hasClass("width");
        return t ? "width" : "height"
    }, i.prototype.show = function() {
        if (!this.transitioning && !this.$element.hasClass("in")) {
            var i = t.Event("show.bs.collapse");
            if (this.$element.trigger(i), !i.isDefaultPrevented()) {
                var o = this.$parent && this.$parent.find("> .panel > .in");
                if (o && o.length) {
                    var n = o.data("bs.collapse");
                    if (n && n.transitioning) return;
                    e.call(o, "hide"), n || o.data("bs.collapse", null)
                }
                var s = this.dimension();
                this.$element.removeClass("collapse").addClass("collapsing")[s](0), this.transitioning = 1;
                var a = function() {
                    this.$element.removeClass("collapsing").addClass("collapse in")[s](""), this.transitioning = 0, this.$element.trigger("shown.bs.collapse")
                };
                if (!t.support.transition) return a.call(this);
                var r = t.camelCase(["scroll", s].join("-"));
                this.$element.one("bsTransitionEnd", t.proxy(a, this)).emulateTransitionEnd(350)[s](this.$element[0][r])
            }
        }
    }, i.prototype.hide = function() {
        if (!this.transitioning && this.$element.hasClass("in")) {
            var e = t.Event("hide.bs.collapse");
            if (this.$element.trigger(e), !e.isDefaultPrevented()) {
                var i = this.dimension();
                this.$element[i](this.$element[i]())[0].offsetHeight, this.$element.addClass("collapsing").removeClass("collapse").removeClass("in"), this.transitioning = 1;
                var o = function() {
                    this.transitioning = 0, this.$element.trigger("hidden.bs.collapse").removeClass("collapsing").addClass("collapse")
                };
                return t.support.transition ? void this.$element[i](0).one("bsTransitionEnd", t.proxy(o, this)).emulateTransitionEnd(350) : o.call(this)
            }
        }
    }, i.prototype.toggle = function() {
        this[this.$element.hasClass("in") ? "hide" : "show"]()
    };
    var o = t.fn.collapse;
    t.fn.collapse = e, t.fn.collapse.Constructor = i, t.fn.collapse.noConflict = function() {
        return t.fn.collapse = o, this
    }, t(document).on("click.bs.collapse.data-api", '[data-toggle="collapse"]', function(i) {
        var o, n = t(this),
            s = n.attr("data-target") || i.preventDefault() || (o = n.attr("href")) && o.replace(/.*(?=#[^\s]+$)/, ""),
            a = t(s),
            r = a.data("bs.collapse"),
            l = r ? "toggle" : n.data(),
            h = n.attr("data-parent"),
            c = h && t(h);
        r && r.transitioning || (c && c.find('[data-toggle="collapse"][data-parent="' + h + '"]').not(n).addClass("collapsed"), n[a.hasClass("in") ? "addClass" : "removeClass"]("collapsed")), e.call(a, l)
    })
}(jQuery), + function(t) {
    "use strict";

    function e(e) {
        e && 3 === e.which || (t(n).remove(), t(s).each(function() {
            var o = i(t(this)),
                n = {
                    relatedTarget: this
                };
            o.hasClass("open") && (o.trigger(e = t.Event("hide.bs.dropdown", n)), e.isDefaultPrevented() || o.removeClass("open").trigger("hidden.bs.dropdown", n))
        }))
    }

    function i(e) {
        var i = e.attr("data-target");
        i || (i = e.attr("href"), i = i && /#[A-Za-z]/.test(i) && i.replace(/.*(?=#[^\s]*$)/, ""));
        var o = i && t(i);
        return o && o.length ? o : e.parent()
    }

    function o(e) {
        return this.each(function() {
            var i = t(this),
                o = i.data("bs.dropdown");
            o || i.data("bs.dropdown", o = new a(this)), "string" == typeof e && o[e].call(i)
        })
    }
    var n = ".dropdown-backdrop",
        s = '[data-toggle="dropdown"]',
        a = function(e) {
            t(e).on("click.bs.dropdown", this.toggle)
        };
    a.VERSION = "3.2.0", a.prototype.toggle = function(o) {
        var n = t(this);
        if (!n.is(".disabled, :disabled")) {
            var s = i(n),
                a = s.hasClass("open");
            if (e(), !a) {
                "ontouchstart" in document.documentElement && !s.closest(".navbar-nav").length && t('<div class="dropdown-backdrop"/>').insertAfter(t(this)).on("click", e);
                var r = {
                    relatedTarget: this
                };
                if (s.trigger(o = t.Event("show.bs.dropdown", r)), o.isDefaultPrevented()) return;
                n.trigger("focus"), s.toggleClass("open").trigger("shown.bs.dropdown", r)
            }
            return !1
        }
    }, a.prototype.keydown = function(e) {
        if (/(38|40|27)/.test(e.keyCode)) {
            var o = t(this);
            if (e.preventDefault(), e.stopPropagation(), !o.is(".disabled, :disabled")) {
                var n = i(o),
                    a = n.hasClass("open");
                if (!a || a && 27 == e.keyCode) return 27 == e.which && n.find(s).trigger("focus"), o.trigger("click");
                var r = " li:not(.divider):visible a",
                    l = n.find('[role="menu"]' + r + ', [role="listbox"]' + r);
                if (l.length) {
                    var h = l.index(l.filter(":focus"));
                    38 == e.keyCode && h > 0 && h--, 40 == e.keyCode && h < l.length - 1 && h++, ~h || (h = 0), l.eq(h).trigger("focus")
                }
            }
        }
    };
    var r = t.fn.dropdown;
    t.fn.dropdown = o, t.fn.dropdown.Constructor = a, t.fn.dropdown.noConflict = function() {
        return t.fn.dropdown = r, this
    }, t(document).on("click.bs.dropdown.data-api", e).on("click.bs.dropdown.data-api", ".dropdown form", function(t) {
        t.stopPropagation()
    }).on("click.bs.dropdown.data-api", s, a.prototype.toggle).on("keydown.bs.dropdown.data-api", s + ', [role="menu"], [role="listbox"]', a.prototype.keydown)
}(jQuery), + function(t) {
    "use strict";

    function e(e, o) {
        return this.each(function() {
            var n = t(this),
                s = n.data("bs.modal"),
                a = t.extend({}, i.DEFAULTS, n.data(), "object" == typeof e && e);
            s || n.data("bs.modal", s = new i(this, a)), "string" == typeof e ? s[e](o) : a.show && s.show(o)
        })
    }
    var i = function(e, i) {
        this.options = i, this.$body = t(document.body), this.$element = t(e), this.$backdrop = this.isShown = null, this.scrollbarWidth = 0, this.options.remote && this.$element.find(".modal-content").load(this.options.remote, t.proxy(function() {
            this.$element.trigger("loaded.bs.modal")
        }, this))
    };
    i.VERSION = "3.2.0", i.DEFAULTS = {
        backdrop: !0,
        keyboard: !0,
        show: !0
    }, i.prototype.toggle = function(t) {
        return this.isShown ? this.hide() : this.show(t)
    }, i.prototype.show = function(e) {
        var i = this,
            o = t.Event("show.bs.modal", {
                relatedTarget: e
            });
        this.$element.trigger(o), this.isShown || o.isDefaultPrevented() || (this.isShown = !0, this.checkScrollbar(), this.$body.addClass("modal-open"), this.setScrollbar(), this.escape(), this.$element.on("click.dismiss.bs.modal", '[data-dismiss="modal"]', t.proxy(this.hide, this)), this.backdrop(function() {
            var o = t.support.transition && i.$element.hasClass("fade");
            i.$element.parent().length || i.$element.appendTo(i.$body), i.$element.show().scrollTop(0), o && i.$element[0].offsetWidth, i.$element.addClass("in").attr("aria-hidden", !1), i.enforceFocus();
            var n = t.Event("shown.bs.modal", {
                relatedTarget: e
            });
            o ? i.$element.find(".modal-dialog").one("bsTransitionEnd", function() {
                i.$element.trigger("focus").trigger(n)
            }).emulateTransitionEnd(300) : i.$element.trigger("focus").trigger(n)
        }))
    }, i.prototype.hide = function(e) {
        e && e.preventDefault(), e = t.Event("hide.bs.modal"), this.$element.trigger(e), this.isShown && !e.isDefaultPrevented() && (this.isShown = !1, this.$body.removeClass("modal-open"), this.resetScrollbar(), this.escape(), t(document).off("focusin.bs.modal"), this.$element.removeClass("in").attr("aria-hidden", !0).off("click.dismiss.bs.modal"), t.support.transition && this.$element.hasClass("fade") ? this.$element.one("bsTransitionEnd", t.proxy(this.hideModal, this)).emulateTransitionEnd(300) : this.hideModal())
    }, i.prototype.enforceFocus = function() {
        t(document).off("focusin.bs.modal").on("focusin.bs.modal", t.proxy(function(t) {
            this.$element[0] === t.target || this.$element.has(t.target).length || this.$element.trigger("focus")
        }, this))
    }, i.prototype.escape = function() {
        this.isShown && this.options.keyboard ? this.$element.on("keyup.dismiss.bs.modal", t.proxy(function(t) {
            27 == t.which && this.hide()
        }, this)) : this.isShown || this.$element.off("keyup.dismiss.bs.modal");
    }, i.prototype.hideModal = function() {
        var t = this;
        this.$element.hide(), this.backdrop(function() {
            t.$element.trigger("hidden.bs.modal")
        })
    }, i.prototype.removeBackdrop = function() {
        this.$backdrop && this.$backdrop.remove(), this.$backdrop = null
    }, i.prototype.backdrop = function(e) {
        var i = this,
            o = this.$element.hasClass("fade") ? "fade" : "";
        if (this.isShown && this.options.backdrop) {
            var n = t.support.transition && o;
            if (this.$backdrop = t('<div class="modal-backdrop ' + o + '" />').appendTo(this.$body), this.$element.on("click.dismiss.bs.modal", t.proxy(function(t) {
                    t.target === t.currentTarget && ("static" == this.options.backdrop ? this.$element[0].focus.call(this.$element[0]) : this.hide.call(this))
                }, this)), n && this.$backdrop[0].offsetWidth, this.$backdrop.addClass("in"), !e) return;
            n ? this.$backdrop.one("bsTransitionEnd", e).emulateTransitionEnd(150) : e()
        } else if (!this.isShown && this.$backdrop) {
            this.$backdrop.removeClass("in");
            var s = function() {
                i.removeBackdrop(), e && e()
            };
            t.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one("bsTransitionEnd", s).emulateTransitionEnd(150) : s()
        } else e && e()
    }, i.prototype.checkScrollbar = function() {
        document.body.clientWidth >= window.innerWidth || (this.scrollbarWidth = this.scrollbarWidth || this.measureScrollbar())
    }, i.prototype.setScrollbar = function() {
        var t = parseInt(this.$body.css("padding-right") || 0, 10);
        this.scrollbarWidth && this.$body.css("padding-right", t + this.scrollbarWidth)
    }, i.prototype.resetScrollbar = function() {
        this.$body.css("padding-right", "")
    }, i.prototype.measureScrollbar = function() {
        var t = document.createElement("div");
        t.className = "modal-scrollbar-measure", this.$body.append(t);
        var e = t.offsetWidth - t.clientWidth;
        return this.$body[0].removeChild(t), e
    };
    var o = t.fn.modal;
    t.fn.modal = e, t.fn.modal.Constructor = i, t.fn.modal.noConflict = function() {
        return t.fn.modal = o, this
    }, t(document).on("click.bs.modal.data-api", '[data-toggle="modal"]', function(i) {
        var o = t(this),
            n = o.attr("href"),
            s = t(o.attr("data-target") || n && n.replace(/.*(?=#[^\s]+$)/, "")),
            a = s.data("bs.modal") ? "toggle" : t.extend({
                remote: !/#/.test(n) && n
            }, s.data(), o.data());
        o.is("a") && i.preventDefault(), s.one("show.bs.modal", function(t) {
            t.isDefaultPrevented() || s.one("hidden.bs.modal", function() {
                o.is(":visible") && o.trigger("focus")
            })
        }), e.call(s, a, this)
    })
}(jQuery), + function(t) {
    "use strict";

    function e(e) {
        return this.each(function() {
            var o = t(this),
                n = o.data("bs.tooltip"),
                s = "object" == typeof e && e;
            (n || "destroy" != e) && (n || o.data("bs.tooltip", n = new i(this, s)), "string" == typeof e && n[e]())
        })
    }
    var i = function(t, e) {
        this.type = this.options = this.enabled = this.timeout = this.hoverState = this.$element = null, this.init("tooltip", t, e)
    };
    i.VERSION = "3.2.0", i.DEFAULTS = {
        animation: !0,
        placement: "top",
        selector: !1,
        template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
        trigger: "hover focus",
        title: "",
        delay: 0,
        html: !1,
        container: !1,
        viewport: {
            selector: "body",
            padding: 0
        }
    }, i.prototype.init = function(e, i, o) {
        this.enabled = !0, this.type = e, this.$element = t(i), this.options = this.getOptions(o), this.$viewport = this.options.viewport && t(this.options.viewport.selector || this.options.viewport);
        for (var n = this.options.trigger.split(" "), s = n.length; s--;) {
            var a = n[s];
            if ("click" == a) this.$element.on("click." + this.type, this.options.selector, t.proxy(this.toggle, this));
            else if ("manual" != a) {
                var r = "hover" == a ? "mouseenter" : "focusin",
                    l = "hover" == a ? "mouseleave" : "focusout";
                this.$element.on(r + "." + this.type, this.options.selector, t.proxy(this.enter, this)), this.$element.on(l + "." + this.type, this.options.selector, t.proxy(this.leave, this))
            }
        }
        this.options.selector ? this._options = t.extend({}, this.options, {
            trigger: "manual",
            selector: ""
        }) : this.fixTitle()
    }, i.prototype.getDefaults = function() {
        return i.DEFAULTS
    }, i.prototype.getOptions = function(e) {
        return e = t.extend({}, this.getDefaults(), this.$element.data(), e), e.delay && "number" == typeof e.delay && (e.delay = {
            show: e.delay,
            hide: e.delay
        }), e
    }, i.prototype.getDelegateOptions = function() {
        var e = {},
            i = this.getDefaults();
        return this._options && t.each(this._options, function(t, o) {
            i[t] != o && (e[t] = o)
        }), e
    }, i.prototype.enter = function(e) {
        var i = e instanceof this.constructor ? e : t(e.currentTarget).data("bs." + this.type);
        return i || (i = new this.constructor(e.currentTarget, this.getDelegateOptions()), t(e.currentTarget).data("bs." + this.type, i)), clearTimeout(i.timeout), i.hoverState = "in", i.options.delay && i.options.delay.show ? void(i.timeout = setTimeout(function() {
            "in" == i.hoverState && i.show()
        }, i.options.delay.show)) : i.show()
    }, i.prototype.leave = function(e) {
        var i = e instanceof this.constructor ? e : t(e.currentTarget).data("bs." + this.type);
        return i || (i = new this.constructor(e.currentTarget, this.getDelegateOptions()), t(e.currentTarget).data("bs." + this.type, i)), clearTimeout(i.timeout), i.hoverState = "out", i.options.delay && i.options.delay.hide ? void(i.timeout = setTimeout(function() {
            "out" == i.hoverState && i.hide()
        }, i.options.delay.hide)) : i.hide()
    }, i.prototype.show = function() {
        var e = t.Event("show.bs." + this.type);
        if (this.hasContent() && this.enabled) {
            this.$element.trigger(e);
            var i = t.contains(document.documentElement, this.$element[0]);
            if (e.isDefaultPrevented() || !i) return;
            var o = this,
                n = this.tip(),
                s = this.getUID(this.type);
            this.setContent(), n.attr("id", s), this.$element.attr("aria-describedby", s), this.options.animation && n.addClass("fade");
            var a = "function" == typeof this.options.placement ? this.options.placement.call(this, n[0], this.$element[0]) : this.options.placement,
                r = /\s?auto?\s?/i,
                l = r.test(a);
            l && (a = a.replace(r, "") || "top"), n.detach().css({
                top: 0,
                left: 0,
                display: "block"
            }).addClass(a).data("bs." + this.type, this), this.options.container ? n.appendTo(this.options.container) : n.insertAfter(this.$element);
            var h = this.getPosition(),
                c = n[0].offsetWidth,
                d = n[0].offsetHeight;
            if (l) {
                var p = a,
                    u = this.$element.parent(),
                    m = this.getPosition(u);
                a = "bottom" == a && h.top + h.height + d - m.scroll > m.height ? "top" : "top" == a && h.top - m.scroll - d < 0 ? "bottom" : "right" == a && h.right + c > m.width ? "left" : "left" == a && h.left - c < m.left ? "right" : a, n.removeClass(p).addClass(a)
            }
            var f = this.getCalculatedOffset(a, h, c, d);
            this.applyPlacement(f, a);
            var g = function() {
                o.$element.trigger("shown.bs." + o.type), o.hoverState = null
            };
            t.support.transition && this.$tip.hasClass("fade") ? n.one("bsTransitionEnd", g).emulateTransitionEnd(150) : g()
        }
    }, i.prototype.applyPlacement = function(e, i) {
        var o = this.tip(),
            n = o[0].offsetWidth,
            s = o[0].offsetHeight,
            a = parseInt(o.css("margin-top"), 10),
            r = parseInt(o.css("margin-left"), 10);
        isNaN(a) && (a = 0), isNaN(r) && (r = 0), e.top = e.top + a, e.left = e.left + r, t.offset.setOffset(o[0], t.extend({
            using: function(t) {
                o.css({
                    top: Math.round(t.top),
                    left: Math.round(t.left)
                })
            }
        }, e), 0), o.addClass("in");
        var l = o[0].offsetWidth,
            h = o[0].offsetHeight;
        "top" == i && h != s && (e.top = e.top + s - h);
        var c = this.getViewportAdjustedDelta(i, e, l, h);
        c.left ? e.left += c.left : e.top += c.top;
        var d = c.left ? 2 * c.left - n + l : 2 * c.top - s + h,
            p = c.left ? "left" : "top",
            u = c.left ? "offsetWidth" : "offsetHeight";
        o.offset(e), this.replaceArrow(d, o[0][u], p)
    }, i.prototype.replaceArrow = function(t, e, i) {
        this.arrow().css(i, t ? 50 * (1 - t / e) + "%" : "")
    }, i.prototype.setContent = function() {
        var t = this.tip(),
            e = this.getTitle();
        t.find(".tooltip-inner")[this.options.html ? "html" : "text"](e), t.removeClass("fade in top bottom left right")
    }, i.prototype.hide = function() {
        function e() {
            "in" != i.hoverState && o.detach(), i.$element.trigger("hidden.bs." + i.type)
        }
        var i = this,
            o = this.tip(),
            n = t.Event("hide.bs." + this.type);
        return this.$element.removeAttr("aria-describedby"), this.$element.trigger(n), n.isDefaultPrevented() ? void 0 : (o.removeClass("in"), t.support.transition && this.$tip.hasClass("fade") ? o.one("bsTransitionEnd", e).emulateTransitionEnd(150) : e(), this.hoverState = null, this)
    }, i.prototype.fixTitle = function() {
        var t = this.$element;
        (t.attr("title") || "string" != typeof t.attr("data-original-title")) && t.attr("data-original-title", t.attr("title") || "").attr("title", "")
    }, i.prototype.hasContent = function() {
        return this.getTitle()
    }, i.prototype.getPosition = function(e) {
        e = e || this.$element;
        var i = e[0],
            o = "BODY" == i.tagName;
        return t.extend({}, "function" == typeof i.getBoundingClientRect ? i.getBoundingClientRect() : null, {
            scroll: o ? document.documentElement.scrollTop || document.body.scrollTop : e.scrollTop(),
            width: o ? t(window).width() : e.outerWidth(),
            height: o ? t(window).height() : e.outerHeight()
        }, o ? {
            top: 0,
            left: 0
        } : e.offset())
    }, i.prototype.getCalculatedOffset = function(t, e, i, o) {
        return "bottom" == t ? {
            top: e.top + e.height,
            left: e.left + e.width / 2 - i / 2
        } : "top" == t ? {
            top: e.top - o,
            left: e.left + e.width / 2 - i / 2
        } : "left" == t ? {
            top: e.top + e.height / 2 - o / 2,
            left: e.left - i
        } : {
            top: e.top + e.height / 2 - o / 2,
            left: e.left + e.width
        }
    }, i.prototype.getViewportAdjustedDelta = function(t, e, i, o) {
        var n = {
            top: 0,
            left: 0
        };
        if (!this.$viewport) return n;
        var s = this.options.viewport && this.options.viewport.padding || 0,
            a = this.getPosition(this.$viewport);
        if (/right|left/.test(t)) {
            var r = e.top - s - a.scroll,
                l = e.top + s - a.scroll + o;
            r < a.top ? n.top = a.top - r : l > a.top + a.height && (n.top = a.top + a.height - l)
        } else {
            var h = e.left - s,
                c = e.left + s + i;
            h < a.left ? n.left = a.left - h : c > a.width && (n.left = a.left + a.width - c)
        }
        return n
    }, i.prototype.getTitle = function() {
        var t, e = this.$element,
            i = this.options;
        return t = e.attr("data-original-title") || ("function" == typeof i.title ? i.title.call(e[0]) : i.title)
    }, i.prototype.getUID = function(t) {
        do t += ~~(1e6 * Math.random()); while (document.getElementById(t));
        return t
    }, i.prototype.tip = function() {
        return this.$tip = this.$tip || t(this.options.template)
    }, i.prototype.arrow = function() {
        return this.$arrow = this.$arrow || this.tip().find(".tooltip-arrow")
    }, i.prototype.validate = function() {
        this.$element[0].parentNode || (this.hide(), this.$element = null, this.options = null)
    }, i.prototype.enable = function() {
        this.enabled = !0
    }, i.prototype.disable = function() {
        this.enabled = !1
    }, i.prototype.toggleEnabled = function() {
        this.enabled = !this.enabled
    }, i.prototype.toggle = function(e) {
        var i = this;
        e && (i = t(e.currentTarget).data("bs." + this.type), i || (i = new this.constructor(e.currentTarget, this.getDelegateOptions()), t(e.currentTarget).data("bs." + this.type, i))), i.tip().hasClass("in") ? i.leave(i) : i.enter(i)
    }, i.prototype.destroy = function() {
        clearTimeout(this.timeout), this.hide().$element.off("." + this.type).removeData("bs." + this.type)
    };
    var o = t.fn.tooltip;
    t.fn.tooltip = e, t.fn.tooltip.Constructor = i, t.fn.tooltip.noConflict = function() {
        return t.fn.tooltip = o, this
    }
}(jQuery), + function(t) {
    "use strict";

    function e(e) {
        return this.each(function() {
            var o = t(this),
                n = o.data("bs.popover"),
                s = "object" == typeof e && e;
            (n || "destroy" != e) && (n || o.data("bs.popover", n = new i(this, s)), "string" == typeof e && n[e]())
        })
    }
    var i = function(t, e) {
        this.init("popover", t, e)
    };
    if (!t.fn.tooltip) throw new Error("Popover requires tooltip.js");
    i.VERSION = "3.2.0", i.DEFAULTS = t.extend({}, t.fn.tooltip.Constructor.DEFAULTS, {
        placement: "right",
        trigger: "click",
        content: "",
        template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
    }), i.prototype = t.extend({}, t.fn.tooltip.Constructor.prototype), i.prototype.constructor = i, i.prototype.getDefaults = function() {
        return i.DEFAULTS
    }, i.prototype.setContent = function() {
        var t = this.tip(),
            e = this.getTitle(),
            i = this.getContent();
        t.find(".popover-title")[this.options.html ? "html" : "text"](e), t.find(".popover-content").empty()[this.options.html ? "string" == typeof i ? "html" : "append" : "text"](i), t.removeClass("fade top bottom left right in"), t.find(".popover-title").html() || t.find(".popover-title").hide()
    }, i.prototype.hasContent = function() {
        return this.getTitle() || this.getContent()
    }, i.prototype.getContent = function() {
        var t = this.$element,
            e = this.options;
        return t.attr("data-content") || ("function" == typeof e.content ? e.content.call(t[0]) : e.content)
    }, i.prototype.arrow = function() {
        return this.$arrow = this.$arrow || this.tip().find(".arrow")
    }, i.prototype.tip = function() {
        return this.$tip || (this.$tip = t(this.options.template)), this.$tip
    };
    var o = t.fn.popover;
    t.fn.popover = e, t.fn.popover.Constructor = i, t.fn.popover.noConflict = function() {
        return t.fn.popover = o, this
    }
}(jQuery), + function(t) {
    "use strict";

    function e(i, o) {
        var n = t.proxy(this.process, this);
        this.$body = t("body"), this.$scrollElement = t(t(i).is("body") ? window : i), this.options = t.extend({}, e.DEFAULTS, o), this.selector = (this.options.target || "") + " .nav li > a", this.offsets = [], this.targets = [], this.activeTarget = null, this.scrollHeight = 0, this.$scrollElement.on("scroll.bs.scrollspy", n), this.refresh(), this.process()
    }

    function i(i) {
        return this.each(function() {
            var o = t(this),
                n = o.data("bs.scrollspy"),
                s = "object" == typeof i && i;
            n || o.data("bs.scrollspy", n = new e(this, s)), "string" == typeof i && n[i]()
        })
    }
    e.VERSION = "3.2.0", e.DEFAULTS = {
        offset: 10
    }, e.prototype.getScrollHeight = function() {
        return this.$scrollElement[0].scrollHeight || Math.max(this.$body[0].scrollHeight, document.documentElement.scrollHeight)
    }, e.prototype.refresh = function() {
        var e = "offset",
            i = 0;
        t.isWindow(this.$scrollElement[0]) || (e = "position", i = this.$scrollElement.scrollTop()), this.offsets = [], this.targets = [], this.scrollHeight = this.getScrollHeight();
        var o = this;
        this.$body.find(this.selector).map(function() {
            var o = t(this),
                n = o.data("target") || o.attr("href"),
                s = /^#./.test(n) && t(n);
            return s && s.length && s.is(":visible") && [
                [s[e]().top + i, n]
            ] || null
        }).sort(function(t, e) {
            return t[0] - e[0]
        }).each(function() {
            o.offsets.push(this[0]), o.targets.push(this[1])
        })
    }, e.prototype.process = function() {
        var t, e = this.$scrollElement.scrollTop() + this.options.offset,
            i = this.getScrollHeight(),
            o = this.options.offset + i - this.$scrollElement.height(),
            n = this.offsets,
            s = this.targets,
            a = this.activeTarget;
        if (this.scrollHeight != i && this.refresh(), e >= o) return a != (t = s[s.length - 1]) && this.activate(t);
        if (a && e <= n[0]) return a != (t = s[0]) && this.activate(t);
        for (t = n.length; t--;) a != s[t] && e >= n[t] && (!n[t + 1] || e <= n[t + 1]) && this.activate(s[t])
    }, e.prototype.activate = function(e) {
        this.activeTarget = e, t(this.selector).parentsUntil(this.options.target, ".active").removeClass("active");
        var i = this.selector + '[data-target="' + e + '"],' + this.selector + '[href="' + e + '"]',
            o = t(i).parents("li").addClass("active");
        o.parent(".dropdown-menu").length && (o = o.closest("li.dropdown").addClass("active")), o.trigger("activate.bs.scrollspy")
    };
    var o = t.fn.scrollspy;
    t.fn.scrollspy = i, t.fn.scrollspy.Constructor = e, t.fn.scrollspy.noConflict = function() {
        return t.fn.scrollspy = o, this
    }, t(window).on("load.bs.scrollspy.data-api", function() {
        t('[data-spy="scroll"]').each(function() {
            var e = t(this);
            i.call(e, e.data())
        })
    })
}(jQuery), + function(t) {
    "use strict";

    function e(e) {
        return this.each(function() {
            var o = t(this),
                n = o.data("bs.tab");
            n || o.data("bs.tab", n = new i(this)), "string" == typeof e && n[e]()
        })
    }
    var i = function(e) {
        this.element = t(e)
    };
    i.VERSION = "3.2.0", i.prototype.show = function() {
        var e = this.element,
            i = e.closest("ul:not(.dropdown-menu)"),
            o = e.data("target");
        if (o || (o = e.attr("href"), o = o && o.replace(/.*(?=#[^\s]*$)/, "")), !e.parent("li").hasClass("active")) {
            var n = i.find(".active:last a")[0],
                s = t.Event("show.bs.tab", {
                    relatedTarget: n
                });
            if (e.trigger(s), !s.isDefaultPrevented()) {
                var a = t(o);
                this.activate(e.closest("li"), i), this.activate(a, a.parent(), function() {
                    e.trigger({
                        type: "shown.bs.tab",
                        relatedTarget: n
                    })
                })
            }
        }
    }, i.prototype.activate = function(e, i, o) {
        function n() {
            s.removeClass("active").find("> .dropdown-menu > .active").removeClass("active"), e.addClass("active"), a ? (e[0].offsetWidth, e.addClass("in")) : e.removeClass("fade"), e.parent(".dropdown-menu") && e.closest("li.dropdown").addClass("active"), o && o()
        }
        var s = i.find("> .active"),
            a = o && t.support.transition && s.hasClass("fade");
        a ? s.one("bsTransitionEnd", n).emulateTransitionEnd(150) : n(), s.removeClass("in")
    };
    var o = t.fn.tab;
    t.fn.tab = e, t.fn.tab.Constructor = i, t.fn.tab.noConflict = function() {
        return t.fn.tab = o, this
    }, t(document).on("click.bs.tab.data-api", '[data-toggle="tab"], [data-toggle="pill"]', function(i) {
        i.preventDefault(), e.call(t(this), "show")
    })
}(jQuery), + function(t) {
    "use strict";

    function e(e) {
        return this.each(function() {
            var o = t(this),
                n = o.data("bs.affix"),
                s = "object" == typeof e && e;
            n || o.data("bs.affix", n = new i(this, s)), "string" == typeof e && n[e]()
        })
    }
    var i = function(e, o) {
        this.options = t.extend({}, i.DEFAULTS, o), this.$target = t(this.options.target).on("scroll.bs.affix.data-api", t.proxy(this.checkPosition, this)).on("click.bs.affix.data-api", t.proxy(this.checkPositionWithEventLoop, this)), this.$element = t(e), this.affixed = this.unpin = this.pinnedOffset = null, this.checkPosition()
    };
    i.VERSION = "3.2.0", i.RESET = "affix affix-top affix-bottom", i.DEFAULTS = {
        offset: 0,
        target: window
    }, i.prototype.getPinnedOffset = function() {
        if (this.pinnedOffset) return this.pinnedOffset;
        this.$element.removeClass(i.RESET).addClass("affix");
        var t = this.$target.scrollTop(),
            e = this.$element.offset();
        return this.pinnedOffset = e.top - t
    }, i.prototype.checkPositionWithEventLoop = function() {
        setTimeout(t.proxy(this.checkPosition, this), 1)
    }, i.prototype.checkPosition = function() {
        if (this.$element.is(":visible")) {
            var e = t(document).height(),
                o = this.$target.scrollTop(),
                n = this.$element.offset(),
                s = this.options.offset,
                a = s.top,
                r = s.bottom;
            "object" != typeof s && (r = a = s), "function" == typeof a && (a = s.top(this.$element)), "function" == typeof r && (r = s.bottom(this.$element));
            var l = null != this.unpin && o + this.unpin <= n.top ? !1 : null != r && n.top + this.$element.height() >= e - r ? "bottom" : null != a && a >= o ? "top" : !1;
            if (this.affixed !== l) {
                null != this.unpin && this.$element.css("top", "");
                var h = "affix" + (l ? "-" + l : ""),
                    c = t.Event(h + ".bs.affix");
                this.$element.trigger(c), c.isDefaultPrevented() || (this.affixed = l, this.unpin = "bottom" == l ? this.getPinnedOffset() : null, this.$element.removeClass(i.RESET).addClass(h).trigger(t.Event(h.replace("affix", "affixed"))), "bottom" == l && this.$element.offset({
                    top: e - this.$element.height() - r
                }))
            }
        }
    };
    var o = t.fn.affix;
    t.fn.affix = e, t.fn.affix.Constructor = i, t.fn.affix.noConflict = function() {
        return t.fn.affix = o, this
    }, t(window).on("load", function() {
        t('[data-spy="affix"]').each(function() {
            var i = t(this),
                o = i.data();
            o.offset = o.offset || {}, o.offsetBottom && (o.offset.bottom = o.offsetBottom), o.offsetTop && (o.offset.top = o.offsetTop), e.call(i, o)
        })
    })
}(jQuery),
function(t, e, i, o) {
    function n(e, i) {
        this.settings = null, this.options = t.extend({}, n.Defaults, i), this.$element = t(e), this.drag = t.extend({}, p), this.state = t.extend({}, u), this.e = t.extend({}, m), this._plugins = {}, this._supress = {}, this._current = null, this._speed = null, this._coordinates = [], this._breakpoint = null, this._width = null, this._items = [], this._clones = [], this._mergers = [], this._invalidated = {}, this._pipe = [], t.each(n.Plugins, t.proxy(function(t, e) {
            this._plugins[t[0].toLowerCase() + t.slice(1)] = new e(this)
        }, this)), t.each(n.Pipe, t.proxy(function(e, i) {
            this._pipe.push({
                filter: i.filter,
                run: t.proxy(i.run, this)
            })
        }, this)), this.setup(), this.initialize()
    }

    function s(t) {
        if (t.touches !== o) return {
            x: t.touches[0].pageX,
            y: t.touches[0].pageY
        };
        if (t.touches === o) {
            if (t.pageX !== o) return {
                x: t.pageX,
                y: t.pageY
            };
            if (t.pageX === o) return {
                x: t.clientX,
                y: t.clientY
            }
        }
    }

    function a(t) {
        var e, o, n = i.createElement("div"),
            s = t;
        for (e in s)
            if (o = s[e], "undefined" != typeof n.style[o]) return n = null, [o, e];
        return [!1]
    }

    function r() {
        return a(["transition", "WebkitTransition", "MozTransition", "OTransition"])[1]
    }

    function l() {
        return a(["transform", "WebkitTransform", "MozTransform", "OTransform", "msTransform"])[0]
    }

    function h() {
        return a(["perspective", "webkitPerspective", "MozPerspective", "OPerspective", "MsPerspective"])[0]
    }

    function c() {
        return "ontouchstart" in e || !!navigator.msMaxTouchPoints
    }

    function d() {
        return e.navigator.msPointerEnabled
    }
    var p, u, m;
    p = {
        start: 0,
        startX: 0,
        startY: 0,
        current: 0,
        currentX: 0,
        currentY: 0,
        offsetX: 0,
        offsetY: 0,
        distance: null,
        startTime: 0,
        endTime: 0,
        updatedX: 0,
        targetEl: null
    }, u = {
        isTouch: !1,
        isScrolling: !1,
        isSwiping: !1,
        direction: !1,
        inMotion: !1
    }, m = {
        _onDragStart: null,
        _onDragMove: null,
        _onDragEnd: null,
        _transitionEnd: null,
        _resizer: null,
        _responsiveCall: null,
        _goToLoop: null,
        _checkVisibile: null
    }, n.Defaults = {
        items: 3,
        loop: !1,
        center: !1,
        mouseDrag: !0,
        touchDrag: !0,
        pullDrag: !0,
        freeDrag: !1,
        margin: 0,
        stagePadding: 0,
        merge: !1,
        mergeFit: !0,
        autoWidth: !1,
        startPosition: 0,
        rtl: !1,
        smartSpeed: 250,
        fluidSpeed: !1,
        dragEndSpeed: !1,
        responsive: {},
        responsiveRefreshRate: 200,
        responsiveBaseElement: e,
        responsiveClass: !1,
        fallbackEasing: "swing",
        info: !1,
        nestedItemSelector: !1,
        itemElement: "div",
        stageElement: "div",
        themeClass: "owl-theme",
        baseClass: "owl-carousel",
        itemClass: "owl-item",
        centerClass: "center",
        activeClass: "active"
    }, n.Width = {
        Default: "default",
        Inner: "inner",
        Outer: "outer"
    }, n.Plugins = {}, n.Pipe = [{
        filter: ["width", "items", "settings"],
        run: function(t) {
            t.current = this._items && this._items[this.relative(this._current)]
        }
    }, {
        filter: ["items", "settings"],
        run: function() {
            var t = this._clones,
                e = this.$stage.children(".cloned");
            (e.length !== t.length || !this.settings.loop && t.length > 0) && (this.$stage.children(".cloned").remove(), this._clones = [])
        }
    }, {
        filter: ["items", "settings"],
        run: function() {
            var t, e, i = this._clones,
                o = this._items,
                n = this.settings.loop ? i.length - Math.max(2 * this.settings.items, 4) : 0;
            for (t = 0, e = Math.abs(n / 2); e > t; t++) n > 0 ? (this.$stage.children().eq(o.length + i.length - 1).remove(), i.pop(), this.$stage.children().eq(0).remove(), i.pop()) : (i.push(i.length / 2), this.$stage.append(o[i[i.length - 1]].clone().addClass("cloned")), i.push(o.length - 1 - (i.length - 1) / 2), this.$stage.prepend(o[i[i.length - 1]].clone().addClass("cloned")))
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function() {
            var t, e, i, o = this.settings.rtl ? 1 : -1,
                n = (this.width() / this.settings.items).toFixed(3),
                s = 0;
            for (this._coordinates = [], e = 0, i = this._clones.length + this._items.length; i > e; e++) t = this._mergers[this.relative(e)], t = this.settings.mergeFit && Math.min(t, this.settings.items) || t, s += (this.settings.autoWidth ? this._items[this.relative(e)].width() + this.settings.margin : n * t) * o, this._coordinates.push(s)
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function() {
            var e, i, o = (this.width() / this.settings.items).toFixed(3),
                n = {
                    width: Math.abs(this._coordinates[this._coordinates.length - 1]) + 2 * this.settings.stagePadding,
                    "padding-left": this.settings.stagePadding || "",
                    "padding-right": this.settings.stagePadding || ""
                };
            if (this.$stage.css(n), n = {
                    width: this.settings.autoWidth ? "auto" : o - this.settings.margin
                }, n[this.settings.rtl ? "margin-left" : "margin-right"] = this.settings.margin, !this.settings.autoWidth && t.grep(this._mergers, function(t) {
                    return t > 1
                }).length > 0)
                for (e = 0, i = this._coordinates.length; i > e; e++) n.width = Math.abs(this._coordinates[e]) - Math.abs(this._coordinates[e - 1] || 0) - this.settings.margin, this.$stage.children().eq(e).css(n);
            else this.$stage.children().css(n)
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function(t) {
            t.current && this.reset(this.$stage.children().index(t.current))
        }
    }, {
        filter: ["position"],
        run: function() {
            this.animate(this.coordinates(this._current))
        }
    }, {
        filter: ["width", "position", "items", "settings"],
        run: function() {
            var t, e, i, o, n = this.settings.rtl ? 1 : -1,
                s = 2 * this.settings.stagePadding,
                a = this.coordinates(this.current()) + s,
                r = a + this.width() * n,
                l = [];
            for (i = 0, o = this._coordinates.length; o > i; i++) t = this._coordinates[i - 1] || 0, e = Math.abs(this._coordinates[i]) + s * n, (this.op(t, "<=", a) && this.op(t, ">", r) || this.op(e, "<", a) && this.op(e, ">", r)) && l.push(i);
            this.$stage.children("." + this.settings.activeClass).removeClass(this.settings.activeClass), this.$stage.children(":eq(" + l.join("), :eq(") + ")").addClass(this.settings.activeClass), this.settings.center && (this.$stage.children("." + this.settings.centerClass).removeClass(this.settings.centerClass), this.$stage.children().eq(this.current()).addClass(this.settings.centerClass))
        }
    }], n.prototype.initialize = function() {
        if (this.trigger("initialize"), this.$element.addClass(this.settings.baseClass).addClass(this.settings.themeClass).toggleClass("owl-rtl", this.settings.rtl), this.browserSupport(), this.settings.autoWidth && this.state.imagesLoaded !== !0) {
            var e, i, n;
            if (e = this.$element.find("img"), i = this.settings.nestedItemSelector ? "." + this.settings.nestedItemSelector : o, n = this.$element.children(i).width(), e.length && 0 >= n) return this.preloadAutoWidthImages(e), !1
        }
        this.$element.addClass("owl-loading"), this.$stage = t("<" + this.settings.stageElement + ' class="owl-stage"/>').wrap('<div class="owl-stage-outer">'), this.$element.append(this.$stage.parent()), this.replace(this.$element.children().not(this.$stage.parent())), this._width = this.$element.width(), this.refresh(), this.$element.removeClass("owl-loading").addClass("owl-loaded"), this.eventsCall(), this.internalEvents(), this.addTriggerableEvents(), this.trigger("initialized")
    }, n.prototype.setup = function() {
        var e = this.viewport(),
            i = this.options.responsive,
            o = -1,
            n = null;
        i ? (t.each(i, function(t) {
            e >= t && t > o && (o = Number(t))
        }), n = t.extend({}, this.options, i[o]), delete n.responsive, n.responsiveClass && this.$element.attr("class", function(t, e) {
            return e.replace(/\b owl-responsive-\S+/g, "")
        }).addClass("owl-responsive-" + o)) : n = t.extend({}, this.options), (null === this.settings || this._breakpoint !== o) && (this.trigger("change", {
            property: {
                name: "settings",
                value: n
            }
        }), this._breakpoint = o, this.settings = n, this.invalidate("settings"), this.trigger("changed", {
            property: {
                name: "settings",
                value: this.settings
            }
        }))
    }, n.prototype.optionsLogic = function() {
        this.$element.toggleClass("owl-center", this.settings.center), this.settings.loop && this._items.length < this.settings.items && (this.settings.loop = !1), this.settings.autoWidth && (this.settings.stagePadding = !1, this.settings.merge = !1)
    }, n.prototype.prepare = function(e) {
        var i = this.trigger("prepare", {
            content: e
        });
        return i.data || (i.data = t("<" + this.settings.itemElement + "/>").addClass(this.settings.itemClass).append(e)), this.trigger("prepared", {
            content: i.data
        }), i.data
    }, n.prototype.update = function() {
        for (var e = 0, i = this._pipe.length, o = t.proxy(function(t) {
                return this[t]
            }, this._invalidated), n = {}; i > e;)(this._invalidated.all || t.grep(this._pipe[e].filter, o).length > 0) && this._pipe[e].run(n), e++;
        this._invalidated = {}
    }, n.prototype.width = function(t) {
        switch (t = t || n.Width.Default) {
            case n.Width.Inner:
            case n.Width.Outer:
                return this._width;
            default:
                return this._width - 2 * this.settings.stagePadding + this.settings.margin
        }
    }, n.prototype.refresh = function() {
        if (0 === this._items.length) return !1;
        (new Date).getTime();
        this.trigger("refresh"), this.setup(), this.optionsLogic(), this.$stage.addClass("owl-refresh"), this.update(), this.$stage.removeClass("owl-refresh"), this.state.orientation = e.orientation, this.watchVisibility(), this.trigger("refreshed")
    }, n.prototype.eventsCall = function() {
        this.e._onDragStart = t.proxy(function(t) {
            this.onDragStart(t)
        }, this), this.e._onDragMove = t.proxy(function(t) {
            this.onDragMove(t)
        }, this), this.e._onDragEnd = t.proxy(function(t) {
            this.onDragEnd(t)
        }, this), this.e._onResize = t.proxy(function(t) {
            this.onResize(t)
        }, this), this.e._transitionEnd = t.proxy(function(t) {
            this.transitionEnd(t)
        }, this), this.e._preventClick = t.proxy(function(t) {
            this.preventClick(t)
        }, this)
    }, n.prototype.onThrottledResize = function() {
        e.clearTimeout(this.resizeTimer), this.resizeTimer = e.setTimeout(this.e._onResize, this.settings.responsiveRefreshRate)
    }, n.prototype.onResize = function() {
        return this._items.length ? this._width === this.$element.width() ? !1 : this.trigger("resize").isDefaultPrevented() ? !1 : (this._width = this.$element.width(), this.invalidate("width"), this.refresh(), void this.trigger("resized")) : !1
    }, n.prototype.eventsRouter = function(t) {
        var e = t.type;
        "mousedown" === e || "touchstart" === e ? this.onDragStart(t) : "mousemove" === e || "touchmove" === e ? this.onDragMove(t) : "mouseup" === e || "touchend" === e ? this.onDragEnd(t) : "touchcancel" === e && this.onDragEnd(t)
    }, n.prototype.internalEvents = function() {
        var i = (c(), d());
        this.settings.mouseDrag ? (this.$stage.on("mousedown", t.proxy(function(t) {
            this.eventsRouter(t)
        }, this)), this.$stage.on("dragstart", function() {
            return !1
        }), this.$stage.get(0).onselectstart = function() {
            return !1
        }) : this.$element.addClass("owl-text-select-on"), this.settings.touchDrag && !i && this.$stage.on("touchstart touchcancel", t.proxy(function(t) {
            this.eventsRouter(t)
        }, this)), this.transitionEndVendor && this.on(this.$stage.get(0), this.transitionEndVendor, this.e._transitionEnd, !1), this.settings.responsive !== !1 && this.on(e, "resize", t.proxy(this.onThrottledResize, this))
    }, n.prototype.onDragStart = function(o) {
        var n, a, r, l;
        if (n = o.originalEvent || o || e.event, 3 === n.which || this.state.isTouch) return !1;
        if ("mousedown" === n.type && this.$stage.addClass("owl-grab"), this.trigger("drag"), this.drag.startTime = (new Date).getTime(), this.speed(0), this.state.isTouch = !0, this.state.isScrolling = !1, this.state.isSwiping = !1, this.drag.distance = 0, a = s(n).x, r = s(n).y, this.drag.offsetX = this.$stage.position().left, this.drag.offsetY = this.$stage.position().top, this.settings.rtl && (this.drag.offsetX = this.$stage.position().left + this.$stage.width() - this.width() + this.settings.margin), this.state.inMotion && this.support3d) l = this.getTransformProperty(), this.drag.offsetX = l, this.animate(l), this.state.inMotion = !0;
        else if (this.state.inMotion && !this.support3d) return this.state.inMotion = !1, !1;
        this.drag.startX = a - this.drag.offsetX, this.drag.startY = r - this.drag.offsetY, this.drag.start = a - this.drag.startX, this.drag.targetEl = n.target || n.srcElement, this.drag.updatedX = this.drag.start, ("IMG" === this.drag.targetEl.tagName || "A" === this.drag.targetEl.tagName) && (this.drag.targetEl.draggable = !1), t(i).on("mousemove.owl.dragEvents mouseup.owl.dragEvents touchmove.owl.dragEvents touchend.owl.dragEvents", t.proxy(function(t) {
            this.eventsRouter(t)
        }, this))
    }, n.prototype.onDragMove = function(t) {
        var i, n, a, r, l, h;
        this.state.isTouch && (this.state.isScrolling || (i = t.originalEvent || t || e.event, n = s(i).x, a = s(i).y, this.drag.currentX = n - this.drag.startX, this.drag.currentY = a - this.drag.startY, this.drag.distance = this.drag.currentX - this.drag.offsetX, this.drag.distance < 0 ? this.state.direction = this.settings.rtl ? "right" : "left" : this.drag.distance > 0 && (this.state.direction = this.settings.rtl ? "left" : "right"), this.settings.loop ? this.op(this.drag.currentX, ">", this.coordinates(this.minimum())) && "right" === this.state.direction ? this.drag.currentX -= (this.settings.center && this.coordinates(0)) - this.coordinates(this._items.length) : this.op(this.drag.currentX, "<", this.coordinates(this.maximum())) && "left" === this.state.direction && (this.drag.currentX += (this.settings.center && this.coordinates(0)) - this.coordinates(this._items.length)) : (r = this.settings.rtl ? this.coordinates(this.maximum()) : this.coordinates(this.minimum()), l = this.settings.rtl ? this.coordinates(this.minimum()) : this.coordinates(this.maximum()), h = this.settings.pullDrag ? this.drag.distance / 5 : 0, this.drag.currentX = Math.max(Math.min(this.drag.currentX, r + h), l + h)), (this.drag.distance > 8 || this.drag.distance < -8) && (i.preventDefault !== o ? i.preventDefault() : i.returnValue = !1, this.state.isSwiping = !0), this.drag.updatedX = this.drag.currentX, (this.drag.currentY > 16 || this.drag.currentY < -16) && this.state.isSwiping === !1 && (this.state.isScrolling = !0, this.drag.updatedX = this.drag.start), this.animate(this.drag.updatedX)))
    }, n.prototype.onDragEnd = function(e) {
        var o, n, s;
        if (this.state.isTouch) {
            if ("mouseup" === e.type && this.$stage.removeClass("owl-grab"), this.trigger("dragged"), this.drag.targetEl.removeAttribute("draggable"), this.state.isTouch = !1, this.state.isScrolling = !1, this.state.isSwiping = !1, 0 === this.drag.distance && this.state.inMotion !== !0) return this.state.inMotion = !1, !1;
            this.drag.endTime = (new Date).getTime(), o = this.drag.endTime - this.drag.startTime, n = Math.abs(this.drag.distance), (n > 3 || o > 300) && this.removeClick(this.drag.targetEl), s = this.closest(this.drag.updatedX), this.speed(this.settings.dragEndSpeed || this.settings.smartSpeed), this.current(s), this.invalidate("position"), this.update(), this.settings.pullDrag || this.drag.updatedX !== this.coordinates(s) || this.transitionEnd(), this.drag.distance = 0, t(i).off(".owl.dragEvents")
        }
    }, n.prototype.removeClick = function(i) {
        this.drag.targetEl = i, t(i).on("click.preventClick", this.e._preventClick), e.setTimeout(function() {
            t(i).off("click.preventClick")
        }, 300)
    }, n.prototype.preventClick = function(e) {
        e.preventDefault ? e.preventDefault() : e.returnValue = !1, e.stopPropagation && e.stopPropagation(), t(e.target).off("click.preventClick")
    }, n.prototype.getTransformProperty = function() {
        var t, i;
        return t = e.getComputedStyle(this.$stage.get(0), null).getPropertyValue(this.vendorName + "transform"), t = t.replace(/matrix(3d)?\(|\)/g, "").split(","), i = 16 === t.length, i !== !0 ? t[4] : t[12]
    }, n.prototype.closest = function(e) {
        var i = -1,
            o = 30,
            n = this.width(),
            s = this.coordinates();
        return this.settings.freeDrag || t.each(s, t.proxy(function(t, a) {
            return e > a - o && a + o > e ? i = t : this.op(e, "<", a) && this.op(e, ">", s[t + 1] || a - n) && (i = "left" === this.state.direction ? t + 1 : t), -1 === i
        }, this)), this.settings.loop || (this.op(e, ">", s[this.minimum()]) ? i = e = this.minimum() : this.op(e, "<", s[this.maximum()]) && (i = e = this.maximum())), i
    }, n.prototype.animate = function(e) {
        this.trigger("translate"), this.state.inMotion = this.speed() > 0, this.support3d ? this.$stage.css({
            transform: "translate3d(" + e + "px,0px, 0px)",
            transition: this.speed() / 1e3 + "s"
        }) : this.state.isTouch ? this.$stage.css({
            left: e + "px"
        }) : this.$stage.animate({
            left: e
        }, this.speed() / 1e3, this.settings.fallbackEasing, t.proxy(function() {
            this.state.inMotion && this.transitionEnd()
        }, this))
    }, n.prototype.current = function(t) {
        if (t === o) return this._current;
        if (0 === this._items.length) return o;
        if (t = this.normalize(t), this._current !== t) {
            var e = this.trigger("change", {
                property: {
                    name: "position",
                    value: t
                }
            });
            e.data !== o && (t = this.normalize(e.data)), this._current = t, this.invalidate("position"), this.trigger("changed", {
                property: {
                    name: "position",
                    value: this._current
                }
            })
        }
        return this._current
    }, n.prototype.invalidate = function(t) {
        this._invalidated[t] = !0
    }, n.prototype.reset = function(t) {
        t = this.normalize(t), t !== o && (this._speed = 0, this._current = t, this.suppress(["translate", "translated"]), this.animate(this.coordinates(t)), this.release(["translate", "translated"]))
    }, n.prototype.normalize = function(e, i) {
        var n = i ? this._items.length : this._items.length + this._clones.length;
        return !t.isNumeric(e) || 1 > n ? o : e = this._clones.length ? (e % n + n) % n : Math.max(this.minimum(i), Math.min(this.maximum(i), e))
    }, n.prototype.relative = function(t) {
        return t = this.normalize(t), t -= this._clones.length / 2, this.normalize(t, !0)
    }, n.prototype.maximum = function(t) {
        var e, i, o, n = 0,
            s = this.settings;
        if (t) return this._items.length - 1;
        if (!s.loop && s.center) e = this._items.length - 1;
        else if (s.loop || s.center)
            if (s.loop || s.center) e = this._items.length + s.items;
            else {
                if (!s.autoWidth && !s.merge) throw "Can not detect maximum absolute position.";
                for (revert = s.rtl ? 1 : -1, i = this.$stage.width() - this.$element.width();
                    (o = this.coordinates(n)) && !(o * revert >= i);) e = ++n
            }
        else e = this._items.length - s.items;
        return e
    }, n.prototype.minimum = function(t) {
        return t ? 0 : this._clones.length / 2
    }, n.prototype.items = function(t) {
        return t === o ? this._items.slice() : (t = this.normalize(t, !0), this._items[t])
    }, n.prototype.mergers = function(t) {
        return t === o ? this._mergers.slice() : (t = this.normalize(t, !0), this._mergers[t])
    }, n.prototype.clones = function(e) {
        var i = this._clones.length / 2,
            n = i + this._items.length,
            s = function(t) {
                return t % 2 === 0 ? n + t / 2 : i - (t + 1) / 2
            };
        return e === o ? t.map(this._clones, function(t, e) {
            return s(e)
        }) : t.map(this._clones, function(t, i) {
            return t === e ? s(i) : null
        })
    }, n.prototype.speed = function(t) {
        return t !== o && (this._speed = t), this._speed
    }, n.prototype.coordinates = function(e) {
        var i = null;
        return e === o ? t.map(this._coordinates, t.proxy(function(t, e) {
            return this.coordinates(e)
        }, this)) : (this.settings.center ? (i = this._coordinates[e], i += (this.width() - i + (this._coordinates[e - 1] || 0)) / 2 * (this.settings.rtl ? -1 : 1)) : i = this._coordinates[e - 1] || 0, i)
    }, n.prototype.duration = function(t, e, i) {
        return Math.min(Math.max(Math.abs(e - t), 1), 6) * Math.abs(i || this.settings.smartSpeed)
    }, n.prototype.to = function(i, o) {
        if (this.settings.loop) {
            var n = i - this.relative(this.current()),
                s = this.current(),
                a = this.current(),
                r = this.current() + n,
                l = 0 > a - r ? !0 : !1,
                h = this._clones.length + this._items.length;
            r < this.settings.items && l === !1 ? (s = a + this._items.length, this.reset(s)) : r >= h - this.settings.items && l === !0 && (s = a - this._items.length, this.reset(s)), e.clearTimeout(this.e._goToLoop), this.e._goToLoop = e.setTimeout(t.proxy(function() {
                this.speed(this.duration(this.current(), s + n, o)), this.current(s + n), this.update()
            }, this), 30)
        } else this.speed(this.duration(this.current(), i, o)), this.current(i), this.update()
    }, n.prototype.next = function(t) {
        t = t || !1, this.to(this.relative(this.current()) + 1, t)
    }, n.prototype.prev = function(t) {
        t = t || !1, this.to(this.relative(this.current()) - 1, t)
    }, n.prototype.transitionEnd = function(t) {
        return t !== o && (t.stopPropagation(), (t.target || t.srcElement || t.originalTarget) !== this.$stage.get(0)) ? !1 : (this.state.inMotion = !1, void this.trigger("translated"))
    }, n.prototype.viewport = function() {
        var o;
        if (this.options.responsiveBaseElement !== e) o = t(this.options.responsiveBaseElement).width();
        else if (e.innerWidth) o = e.innerWidth;
        else {
            if (!i.documentElement || !i.documentElement.clientWidth) throw "Can not detect viewport width.";
            o = i.documentElement.clientWidth
        }
        return o
    }, n.prototype.replace = function(e) {
        this.$stage.empty(), this._items = [], e && (e = e instanceof jQuery ? e : t(e)), this.settings.nestedItemSelector && (e = e.find("." + this.settings.nestedItemSelector)), e.filter(function() {
            return 1 === this.nodeType
        }).each(t.proxy(function(t, e) {
            e = this.prepare(e), this.$stage.append(e), this._items.push(e), this._mergers.push(1 * e.find("[data-merge]").andSelf("[data-merge]").attr("data-merge") || 1)
        }, this)), this.reset(t.isNumeric(this.settings.startPosition) ? this.settings.startPosition : 0), this.invalidate("items")
    }, n.prototype.add = function(t, e) {
        e = e === o ? this._items.length : this.normalize(e, !0), this.trigger("add", {
            content: t,
            position: e
        }), 0 === this._items.length || e === this._items.length ? (this.$stage.append(t), this._items.push(t), this._mergers.push(1 * t.find("[data-merge]").andSelf("[data-merge]").attr("data-merge") || 1)) : (this._items[e].before(t), this._items.splice(e, 0, t), this._mergers.splice(e, 0, 1 * t.find("[data-merge]").andSelf("[data-merge]").attr("data-merge") || 1)), this.invalidate("items"), this.trigger("added", {
            content: t,
            position: e
        })
    }, n.prototype.remove = function(t) {
        t = this.normalize(t, !0), t !== o && (this.trigger("remove", {
            content: this._items[t],
            position: t
        }), this._items[t].remove(), this._items.splice(t, 1), this._mergers.splice(t, 1), this.invalidate("items"), this.trigger("removed", {
            content: null,
            position: t
        }))
    }, n.prototype.addTriggerableEvents = function() {
        var e = t.proxy(function(e, i) {
            return t.proxy(function(t) {
                t.relatedTarget !== this && (this.suppress([i]), e.apply(this, [].slice.call(arguments, 1)), this.release([i]))
            }, this)
        }, this);
        t.each({
            next: this.next,
            prev: this.prev,
            to: this.to,
            destroy: this.destroy,
            refresh: this.refresh,
            replace: this.replace,
            add: this.add,
            remove: this.remove
        }, t.proxy(function(t, i) {
            this.$element.on(t + ".owl.carousel", e(i, t + ".owl.carousel"))
        }, this))
    }, n.prototype.watchVisibility = function() {
        function i(t) {
            return t.offsetWidth > 0 && t.offsetHeight > 0
        }

        function o() {
            i(this.$element.get(0)) && (this.$element.removeClass("owl-hidden"), this.refresh(), e.clearInterval(this.e._checkVisibile))
        }
        i(this.$element.get(0)) || (this.$element.addClass("owl-hidden"), e.clearInterval(this.e._checkVisibile), this.e._checkVisibile = e.setInterval(t.proxy(o, this), 500))
    }, n.prototype.preloadAutoWidthImages = function(e) {
        var i, o, n, s;
        i = 0, o = this, e.each(function(a, r) {
            n = t(r), s = new Image, s.onload = function() {
                i++, n.attr("src", s.src), n.css("opacity", 1), i >= e.length && (o.state.imagesLoaded = !0, o.initialize())
            }, s.src = n.attr("src") || n.attr("data-src") || n.attr("data-src-retina")
        })
    }, n.prototype.destroy = function() {
        this.$element.hasClass(this.settings.themeClass) && this.$element.removeClass(this.settings.themeClass), this.settings.responsive !== !1 && t(e).off("resize.owl.carousel"), this.transitionEndVendor && this.off(this.$stage.get(0), this.transitionEndVendor, this.e._transitionEnd);
        for (var o in this._plugins) this._plugins[o].destroy();
        (this.settings.mouseDrag || this.settings.touchDrag) && (this.$stage.off("mousedown touchstart touchcancel"), t(i).off(".owl.dragEvents"), this.$stage.get(0).onselectstart = function() {}, this.$stage.off("dragstart", function() {
            return !1
        })), this.$element.off(".owl"), this.$stage.children(".cloned").remove(), this.e = null, this.$element.removeData("owlCarousel"), this.$stage.children().contents().unwrap(), this.$stage.children().unwrap(), this.$stage.unwrap()
    }, n.prototype.op = function(t, e, i) {
        var o = this.settings.rtl;
        switch (e) {
            case "<":
                return o ? t > i : i > t;
            case ">":
                return o ? i > t : t > i;
            case ">=":
                return o ? i >= t : t >= i;
            case "<=":
                return o ? t >= i : i >= t
        }
    }, n.prototype.on = function(t, e, i, o) {
        t.addEventListener ? t.addEventListener(e, i, o) : t.attachEvent && t.attachEvent("on" + e, i)
    }, n.prototype.off = function(t, e, i, o) {
        t.removeEventListener ? t.removeEventListener(e, i, o) : t.detachEvent && t.detachEvent("on" + e, i)
    }, n.prototype.trigger = function(e, i, o) {
        var n = {
                item: {
                    count: this._items.length,
                    index: this.current()
                }
            },
            s = t.camelCase(t.grep(["on", e, o], function(t) {
                return t
            }).join("-").toLowerCase()),
            a = t.Event([e, "owl", o || "carousel"].join(".").toLowerCase(), t.extend({
                relatedTarget: this
            }, n, i));
        return this._supress[e] || (t.each(this._plugins, function(t, e) {
            e.onTrigger && e.onTrigger(a)
        }), this.$element.trigger(a), this.settings && "function" == typeof this.settings[s] && this.settings[s].apply(this, a)), a
    }, n.prototype.suppress = function(e) {
        t.each(e, t.proxy(function(t, e) {
            this._supress[e] = !0
        }, this))
    }, n.prototype.release = function(e) {
        t.each(e, t.proxy(function(t, e) {
            delete this._supress[e]
        }, this))
    }, n.prototype.browserSupport = function() {
        if (this.support3d = h(), this.support3d) {
            this.transformVendor = l();
            var t = ["transitionend", "webkitTransitionEnd", "transitionend", "oTransitionEnd"];
            this.transitionEndVendor = t[r()], this.vendorName = this.transformVendor.replace(/Transform/i, ""), this.vendorName = "" !== this.vendorName ? "-" + this.vendorName.toLowerCase() + "-" : ""
        }
        this.state.orientation = e.orientation
    }, t.fn.owlCarousel = function(e) {
        return this.each(function() {
            t(this).data("owlCarousel") || t(this).data("owlCarousel", new n(this, e))
        })
    }, t.fn.owlCarousel.Constructor = n
}(window.Zepto || window.jQuery, window, document),
function(t, e, i, o) {
    var n = function(e) {
        this._core = e, this._loaded = [], this._handlers = {
            "initialized.owl.carousel change.owl.carousel": t.proxy(function(e) {
                if (e.namespace && this._core.settings && this._core.settings.lazyLoad && (e.property && "position" == e.property.name || "initialized" == e.type))
                    for (var i = this._core.settings, o = i.center && Math.ceil(i.items / 2) || i.items, n = i.center && -1 * o || 0, s = (e.property && e.property.value || this._core.current()) + n, a = this._core.clones().length, r = t.proxy(function(t, e) {
                            this.load(e)
                        }, this); n++ < o;) this.load(a / 2 + this._core.relative(s)), a && t.each(this._core.clones(this._core.relative(s++)), r)
            }, this)
        }, this._core.options = t.extend({}, n.Defaults, this._core.options), this._core.$element.on(this._handlers)
    };
    n.Defaults = {
        lazyLoad: !1
    }, n.prototype.load = function(i) {
        var o = this._core.$stage.children().eq(i),
            n = o && o.find(".owl-lazy");
        !n || t.inArray(o.get(0), this._loaded) > -1 || (n.each(t.proxy(function(i, o) {
            var n, s = t(o),
                a = e.devicePixelRatio > 1 && s.attr("data-src-retina") || s.attr("data-src");
            this._core.trigger("load", {
                element: s,
                url: a
            }, "lazy"), s.is("img") ? s.one("load.owl.lazy", t.proxy(function() {
                s.css("opacity", 1), this._core.trigger("loaded", {
                    element: s,
                    url: a
                }, "lazy")
            }, this)).attr("src", a) : (n = new Image, n.onload = t.proxy(function() {
                s.css({
                    "background-image": "url(" + a + ")",
                    opacity: "1"
                }), this._core.trigger("loaded", {
                    element: s,
                    url: a
                }, "lazy")
            }, this), n.src = a)
        }, this)), this._loaded.push(o.get(0)))
    }, n.prototype.destroy = function() {
        var t, e;
        for (t in this.handlers) this._core.$element.off(t, this.handlers[t]);
        for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null)
    }, t.fn.owlCarousel.Constructor.Plugins.Lazy = n
}(window.Zepto || window.jQuery, window, document),
function(t, e, i, o) {
    var n = function(e) {
        this._core = e, this._handlers = {
            "initialized.owl.carousel": t.proxy(function() {
                this._core.settings.autoHeight && this.update()
            }, this),
            "changed.owl.carousel": t.proxy(function(t) {
                this._core.settings.autoHeight && "position" == t.property.name && this.update()
            }, this),
            "loaded.owl.lazy": t.proxy(function(t) {
                this._core.settings.autoHeight && t.element.closest("." + this._core.settings.itemClass) === this._core.$stage.children().eq(this._core.current()) && this.update()
            }, this)
        }, this._core.options = t.extend({}, n.Defaults, this._core.options), this._core.$element.on(this._handlers)
    };
    n.Defaults = {
        autoHeight: !1,
        autoHeightClass: "owl-height"
    }, n.prototype.update = function() {
        this._core.$stage.parent().height(this._core.$stage.children().eq(this._core.current()).height()).addClass(this._core.settings.autoHeightClass)
    }, n.prototype.destroy = function() {
        var t, e;
        for (t in this._handlers) this._core.$element.off(t, this._handlers[t]);
        for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null)
    }, t.fn.owlCarousel.Constructor.Plugins.AutoHeight = n
}(window.Zepto || window.jQuery, window, document),
function(t, e, i, o) {
    var n = function(e) {
        this._core = e, this._videos = {}, this._playing = null, this._fullscreen = !1, this._handlers = {
            "resize.owl.carousel": t.proxy(function(t) {
                this._core.settings.video && !this.isInFullScreen() && t.preventDefault()
            }, this),
            "refresh.owl.carousel changed.owl.carousel": t.proxy(function(t) {
                this._playing && this.stop()
            }, this),
            "prepared.owl.carousel": t.proxy(function(e) {
                var i = t(e.content).find(".owl-video");
                i.length && (i.css("display", "none"), this.fetch(i, t(e.content)))
            }, this)
        }, this._core.options = t.extend({}, n.Defaults, this._core.options), this._core.$element.on(this._handlers), this._core.$element.on("click.owl.video", ".owl-video-play-icon", t.proxy(function(t) {
            this.play(t)
        }, this))
    };
    n.Defaults = {
        video: !1,
        videoHeight: !1,
        videoWidth: !1
    }, n.prototype.fetch = function(t, e) {
        var i = t.attr("data-vimeo-id") ? "vimeo" : "youtube",
            o = t.attr("data-vimeo-id") || t.attr("data-youtube-id"),
            n = t.attr("data-width") || this._core.settings.videoWidth,
            s = t.attr("data-height") || this._core.settings.videoHeight,
            a = t.attr("href");
        if (!a) throw new Error("Missing video URL.");
        if (o = a.match(/(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/), o[3].indexOf("youtu") > -1) i = "youtube";
        else {
            if (!(o[3].indexOf("vimeo") > -1)) throw new Error("Video URL not supported.");
            i = "vimeo"
        }
        o = o[6], this._videos[a] = {
            type: i,
            id: o,
            width: n,
            height: s
        }, e.attr("data-video", a), this.thumbnail(t, this._videos[a])
    }, n.prototype.thumbnail = function(e, i) {
        var o, n, s, a = i.width && i.height ? 'style="width:' + i.width + "px;height:" + i.height + 'px;"' : "",
            r = e.find("img"),
            l = "src",
            h = "",
            c = this._core.settings,
            d = function(t) {
                n = '<div class="owl-video-play-icon"></div>', o = c.lazyLoad ? '<div class="owl-video-tn ' + h + '" ' + l + '="' + t + '"></div>' : '<div class="owl-video-tn" style="opacity:1;background-image:url(' + t + ')"></div>', e.after(o), e.after(n)
            };
        return e.wrap('<div class="owl-video-wrapper"' + a + "></div>"), this._core.settings.lazyLoad && (l = "data-src", h = "owl-lazy"), r.length ? (d(r.attr(l)), r.remove(), !1) : void("youtube" === i.type ? (s = "http://img.youtube.com/vi/" + i.id + "/hqdefault.jpg", d(s)) : "vimeo" === i.type && t.ajax({
            type: "GET",
            url: "http://vimeo.com/api/v2/video/" + i.id + ".json",
            jsonp: "callback",
            dataType: "jsonp",
            success: function(t) {
                s = t[0].thumbnail_large, d(s)
            }
        }))
    }, n.prototype.stop = function() {
        this._core.trigger("stop", null, "video"), this._playing.find(".owl-video-frame").remove(), this._playing.removeClass("owl-video-playing"), this._playing = null
    }, n.prototype.play = function(e) {
        this._core.trigger("play", null, "video"), this._playing && this.stop();
        var i, o, n = t(e.target || e.srcElement),
            s = n.closest("." + this._core.settings.itemClass),
            a = this._videos[s.attr("data-video")],
            r = a.width || "100%",
            l = a.height || this._core.$stage.height();
        "youtube" === a.type ? i = '<iframe width="' + r + '" height="' + l + '" src="http://www.youtube.com/embed/' + a.id + "?autoplay=1&v=" + a.id + '" frameborder="0" allowfullscreen></iframe>' : "vimeo" === a.type && (i = '<iframe src="http://player.vimeo.com/video/' + a.id + '?autoplay=1" width="' + r + '" height="' + l + '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'), s.addClass("owl-video-playing"), this._playing = s, o = t('<div style="height:' + l + "px; width:" + r + 'px" class="owl-video-frame">' + i + "</div>"), n.after(o)
    }, n.prototype.isInFullScreen = function() {
        var o = i.fullscreenElement || i.mozFullScreenElement || i.webkitFullscreenElement;
        return o && t(o).parent().hasClass("owl-video-frame") && (this._core.speed(0), this._fullscreen = !0), o && this._fullscreen && this._playing ? !1 : this._fullscreen ? (this._fullscreen = !1, !1) : this._playing && this._core.state.orientation !== e.orientation ? (this._core.state.orientation = e.orientation, !1) : !0
    }, n.prototype.destroy = function() {
        var t, e;
        this._core.$element.off("click.owl.video");
        for (t in this._handlers) this._core.$element.off(t, this._handlers[t]);
        for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null)
    }, t.fn.owlCarousel.Constructor.Plugins.Video = n
}(window.Zepto || window.jQuery, window, document),
function(t, e, i, o) {
    var n = function(e) {
        this.core = e, this.core.options = t.extend({}, n.Defaults, this.core.options), this.swapping = !0, this.previous = o, this.next = o, this.handlers = {
            "change.owl.carousel": t.proxy(function(t) {
                "position" == t.property.name && (this.previous = this.core.current(), this.next = t.property.value)
            }, this),
            "drag.owl.carousel dragged.owl.carousel translated.owl.carousel": t.proxy(function(t) {
                this.swapping = "translated" == t.type
            }, this),
            "translate.owl.carousel": t.proxy(function(t) {
                this.swapping && (this.core.options.animateOut || this.core.options.animateIn) && this.swap()
            }, this)
        }, this.core.$element.on(this.handlers)
    };
    n.Defaults = {
        animateOut: !1,
        animateIn: !1
    }, n.prototype.swap = function() {
        if (1 === this.core.settings.items && this.core.support3d) {
            this.core.speed(0);
            var e, i = t.proxy(this.clear, this),
                o = this.core.$stage.children().eq(this.previous),
                n = this.core.$stage.children().eq(this.next),
                s = this.core.settings.animateIn,
                a = this.core.settings.animateOut;
            this.core.current() !== this.previous && (a && (e = this.core.coordinates(this.previous) - this.core.coordinates(this.next), o.css({
                left: e + "px"
            }).addClass("animated owl-animated-out").addClass(a).one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", i)), s && n.addClass("animated owl-animated-in").addClass(s).one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", i))
        }
    }, n.prototype.clear = function(e) {
        t(e.target).css({
            left: ""
        }).removeClass("animated owl-animated-out owl-animated-in").removeClass(this.core.settings.animateIn).removeClass(this.core.settings.animateOut), this.core.transitionEnd()
    }, n.prototype.destroy = function() {
        var t, e;
        for (t in this.handlers) this.core.$element.off(t, this.handlers[t]);
        for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null)
    }, t.fn.owlCarousel.Constructor.Plugins.Animate = n
}(window.Zepto || window.jQuery, window, document),
function(t, e, i, o) {
    var n = function(e) {
        this.core = e, this.core.options = t.extend({}, n.Defaults, this.core.options), this.handlers = {
            "translated.owl.carousel refreshed.owl.carousel": t.proxy(function() {
                this.autoplay()
            }, this),
            "play.owl.autoplay": t.proxy(function(t, e, i) {
                this.play(e, i)
            }, this),
            "stop.owl.autoplay": t.proxy(function() {
                this.stop()
            }, this),
            "mouseover.owl.autoplay": t.proxy(function() {
                this.core.settings.autoplayHoverPause && this.pause()
            }, this),
            "mouseleave.owl.autoplay": t.proxy(function() {
                this.core.settings.autoplayHoverPause && this.autoplay()
            }, this)
        }, this.core.$element.on(this.handlers)
    };
    n.Defaults = {
        autoplay: !1,
        autoplayTimeout: 5e3,
        autoplayHoverPause: !1,
        autoplaySpeed: !1
    }, n.prototype.autoplay = function() {
        this.core.settings.autoplay && !this.core.state.videoPlay ? (e.clearInterval(this.interval), this.interval = e.setInterval(t.proxy(function() {
            this.play()
        }, this), this.core.settings.autoplayTimeout)) : e.clearInterval(this.interval)
    }, n.prototype.play = function(t, o) {
        return i.hidden === !0 || this.core.state.isTouch || this.core.state.isScrolling || this.core.state.isSwiping || this.core.state.inMotion ? void 0 : this.core.settings.autoplay === !1 ? void e.clearInterval(this.interval) : void this.core.next(this.core.settings.autoplaySpeed)
    }, n.prototype.stop = function() {
        e.clearInterval(this.interval)
    }, n.prototype.pause = function() {
        e.clearInterval(this.interval)
    }, n.prototype.destroy = function() {
        var t, i;
        e.clearInterval(this.interval);
        for (t in this.handlers) this.core.$element.off(t, this.handlers[t]);
        for (i in Object.getOwnPropertyNames(this)) "function" != typeof this[i] && (this[i] = null)
    }, t.fn.owlCarousel.Constructor.Plugins.autoplay = n
}(window.Zepto || window.jQuery, window, document),
function(t, e, i, o) {
    "use strict";
    var n = function(e) {
        this._core = e, this._initialized = !1, this._pages = [], this._controls = {}, this._templates = [], this.$element = this._core.$element, this._overrides = {
            next: this._core.next,
            prev: this._core.prev,
            to: this._core.to
        }, this._handlers = {
            "prepared.owl.carousel": t.proxy(function(e) {
                this._core.settings.dotsData && this._templates.push(t(e.content).find("[data-dot]").andSelf("[data-dot]").attr("data-dot"))
            }, this),
            "add.owl.carousel": t.proxy(function(e) {
                this._core.settings.dotsData && this._templates.splice(e.position, 0, t(e.content).find("[data-dot]").andSelf("[data-dot]").attr("data-dot"))
            }, this),
            "remove.owl.carousel prepared.owl.carousel": t.proxy(function(t) {
                this._core.settings.dotsData && this._templates.splice(t.position, 1)
            }, this),
            "change.owl.carousel": t.proxy(function(t) {
                if ("position" == t.property.name && !this._core.state.revert && !this._core.settings.loop && this._core.settings.navRewind) {
                    var e = this._core.current(),
                        i = this._core.maximum(),
                        o = this._core.minimum();
                    t.data = t.property.value > i ? e >= i ? o : i : t.property.value < o ? i : t.property.value
                }
            }, this),
            "changed.owl.carousel": t.proxy(function(t) {
                "position" == t.property.name && this.draw()
            }, this),
            "refreshed.owl.carousel": t.proxy(function() {
                this._initialized || (this.initialize(), this._initialized = !0), this._core.trigger("refresh", null, "navigation"), this.update(), this.draw(), this._core.trigger("refreshed", null, "navigation")
            }, this)
        }, this._core.options = t.extend({}, n.Defaults, this._core.options), this.$element.on(this._handlers)
    };
    n.Defaults = {
        nav: !1,
        navRewind: !0,
        navText: ["prev", "next"],
        navSpeed: !1,
        navElement: "div",
        navContainer: !1,
        navContainerClass: "owl-nav",
        navClass: ["owl-prev", "owl-next"],
        slideBy: 1,
        dotClass: "owl-dot",
        dotsClass: "owl-dots",
        dots: !0,
        dotsEach: !1,
        dotData: !1,
        dotsSpeed: !1,
        dotsContainer: !1,
        controlsClass: "owl-controls"
    }, n.prototype.initialize = function() {
        var e, i, o = this._core.settings;
        o.dotsData || (this._templates = [t("<div>").addClass(o.dotClass).append(t("<span>")).prop("outerHTML")]), o.navContainer && o.dotsContainer || (this._controls.$container = t("<div>").addClass(o.controlsClass).appendTo(this.$element)), this._controls.$indicators = o.dotsContainer ? t(o.dotsContainer) : t("<div>").hide().addClass(o.dotsClass).appendTo(this._controls.$container), this._controls.$indicators.on("click", "div", t.proxy(function(e) {
            var i = t(e.target).parent().is(this._controls.$indicators) ? t(e.target).index() : t(e.target).parent().index();
            e.preventDefault(), this.to(i, o.dotsSpeed)
        }, this)), e = o.navContainer ? t(o.navContainer) : t("<div>").addClass(o.navContainerClass).prependTo(this._controls.$container), this._controls.$next = t("<" + o.navElement + ">"), this._controls.$previous = this._controls.$next.clone(), this._controls.$previous.addClass(o.navClass[0]).html(o.navText[0]).hide().prependTo(e).on("click", t.proxy(function(t) {
            this.prev(o.navSpeed)
        }, this)), this._controls.$next.addClass(o.navClass[1]).html(o.navText[1]).hide().appendTo(e).on("click", t.proxy(function(t) {
            this.next(o.navSpeed)
        }, this));
        for (i in this._overrides) this._core[i] = t.proxy(this[i], this)
    }, n.prototype.destroy = function() {
        var t, e, i, o;
        for (t in this._handlers) this.$element.off(t, this._handlers[t]);
        for (e in this._controls) this._controls[e].remove();
        for (o in this.overides) this._core[o] = this._overrides[o];
        for (i in Object.getOwnPropertyNames(this)) "function" != typeof this[i] && (this[i] = null)
    }, n.prototype.update = function() {
        var t, e, i, o = this._core.settings,
            n = this._core.clones().length / 2,
            s = n + this._core.items().length,
            a = o.center || o.autoWidth || o.dotData ? 1 : o.dotsEach || o.items;
        if ("page" !== o.slideBy && (o.slideBy = Math.min(o.slideBy, o.items)), o.dots || "page" == o.slideBy)
            for (this._pages = [], t = n, e = 0, i = 0; s > t; t++)(e >= a || 0 === e) && (this._pages.push({
                start: t - n,
                end: t - n + a - 1
            }), e = 0, ++i), e += this._core.mergers(this._core.relative(t))
    }, n.prototype.draw = function() {
        var e, i, o = "",
            n = this._core.settings,
            s = (this._core.$stage.children(), this._core.relative(this._core.current()));
        if (!n.nav || n.loop || n.navRewind || (this._controls.$previous.toggleClass("disabled", 0 >= s), this._controls.$next.toggleClass("disabled", s >= this._core.maximum())), this._controls.$previous.toggle(n.nav), this._controls.$next.toggle(n.nav), n.dots) {
            if (e = this._pages.length - this._controls.$indicators.children().length, n.dotData && 0 !== e) {
                for (i = 0; i < this._controls.$indicators.children().length; i++) o += this._templates[this._core.relative(i)];
                this._controls.$indicators.html(o)
            } else e > 0 ? (o = new Array(e + 1).join(this._templates[0]), this._controls.$indicators.append(o)) : 0 > e && this._controls.$indicators.children().slice(e).remove();
            this._controls.$indicators.find(".active").removeClass("active"), this._controls.$indicators.children().eq(t.inArray(this.current(), this._pages)).addClass("active")
        }
        this._controls.$indicators.toggle(n.dots)
    }, n.prototype.onTrigger = function(e) {
        var i = this._core.settings;
        e.page = {
            index: t.inArray(this.current(), this._pages),
            count: this._pages.length,
            size: i && (i.center || i.autoWidth || i.dotData ? 1 : i.dotsEach || i.items)
        }
    }, n.prototype.current = function() {
        var e = this._core.relative(this._core.current());
        return t.grep(this._pages, function(t) {
            return t.start <= e && t.end >= e
        }).pop()
    }, n.prototype.getPosition = function(e) {
        var i, o, n = this._core.settings;
        return "page" == n.slideBy ? (i = t.inArray(this.current(), this._pages), o = this._pages.length, e ? ++i : --i, i = this._pages[(i % o + o) % o].start) : (i = this._core.relative(this._core.current()), o = this._core.items().length, e ? i += n.slideBy : i -= n.slideBy), i
    }, n.prototype.next = function(e) {
        t.proxy(this._overrides.to, this._core)(this.getPosition(!0), e)
    }, n.prototype.prev = function(e) {
        t.proxy(this._overrides.to, this._core)(this.getPosition(!1), e)
    }, n.prototype.to = function(e, i, o) {
        var n;
        o ? t.proxy(this._overrides.to, this._core)(e, i) : (n = this._pages.length, t.proxy(this._overrides.to, this._core)(this._pages[(e % n + n) % n].start, i))
    }, t.fn.owlCarousel.Constructor.Plugins.Navigation = n
}(window.Zepto || window.jQuery, window, document),
function(t, e, i, o) {
    "use strict";
    var n = function(i) {
        this._core = i, this._hashes = {}, this.$element = this._core.$element, this._handlers = {
            "initialized.owl.carousel": t.proxy(function() {
                "URLHash" == this._core.settings.startPosition && t(e).trigger("hashchange.owl.navigation")
            }, this),
            "prepared.owl.carousel": t.proxy(function(e) {
                var i = t(e.content).find("[data-hash]").andSelf("[data-hash]").attr("data-hash");
                this._hashes[i] = e.content
            }, this)
        }, this._core.options = t.extend({}, n.Defaults, this._core.options), this.$element.on(this._handlers), t(e).on("hashchange.owl.navigation", t.proxy(function() {
            var t = e.location.hash.substring(1),
                i = this._core.$stage.children(),
                o = this._hashes[t] && i.index(this._hashes[t]) || 0;
            return t ? void this._core.to(o, !1, !0) : !1
        }, this))
    };
    n.Defaults = {
        URLhashListener: !1
    }, n.prototype.destroy = function() {
        var i, o;
        t(e).off("hashchange.owl.navigation");
        for (i in this._handlers) this._core.$element.off(i, this._handlers[i]);
        for (o in Object.getOwnPropertyNames(this)) "function" != typeof this[o] && (this[o] = null)
    }, t.fn.owlCarousel.Constructor.Plugins.Hash = n
}(window.Zepto || window.jQuery, window, document),
function(t, e, i, o) {
    function n(e, i) {
        this.element = e, this.options = t.extend({}, h, i), this._defaults = h, this._name = l, this.init()
    }
    var s, a, r, l = "pinterest_grid",
        h = {
            padding_x: 10,
            padding_y: 10,
            no_columns: 3,
            margin_bottom: 15,
            single_column_breakpoint: 700
        };
    n.prototype.init = function() {
        var i, o = this;
        t(e).resize(function() {
            clearTimeout(i), i = setTimeout(function() {
                o.make_layout_change(o)
            }, 11)
        }), o.make_layout_change(o), setTimeout(function() {
            t(e).resize()
        }, 500)
    }, n.prototype.calculate = function(e) {
        var i = this,
            o = 0,
            n = t(this.element);
        n.width();
        a = t(this.element).children(), r = e === !0 ? n.width() - i.options.padding_x : (n.width() - i.options.padding_x * i.options.no_columns) / i.options.no_columns, a.each(function() {
            t(this).css("width", r)
        }), s = i.options.no_columns, a.each(function(n) {
            var a, l = 0,
                h = 0,
                c = t(this),
                d = c.prevAll();
            a = e === !1 ? n % s : 0;
            for (var p = 0; s > p; p++) c.removeClass("c" + p);
            n % s === 0 && o++, c.addClass("c" + a), c.addClass("r" + o), d.each(function(e) {
                t(this).hasClass("c" + a) && (h += t(this).outerHeight() + i.options.padding_y)
            }), l = e === !0 ? 0 : n % s * (r + i.options.padding_x), c.css({
                left: l,
                top: h
            })
        }), this.tallest(n)
    }, n.prototype.tallest = function(e) {
        for (var i = [], o = 0, n = 0; s > n; n++) {
            var a = 0;
            e.find(".c" + n).each(function() {
                a += t(this).outerHeight()
            }), i[n] = a
        }
        o = Math.max.apply(Math, i), e.css("height", o + (this.options.padding_y + this.options.margin_bottom))
    }, n.prototype.make_layout_change = function(i) {
        t(e).width() < i.options.single_column_breakpoint ? i.calculate(!0) : i.calculate(!1)
    }, t.fn[l] = function(e) {
        return this.each(function() {
            t.data(this, "plugin_" + l) || t.data(this, "plugin_" + l, new n(this, e))
        })
    }
}(jQuery, window, document), "function" != typeof Object.create && (Object.create = function(t) {
        function e() {}
        return e.prototype = t, new e
    }),
    function(t, e, i, o) {
        var n = {
            init: function(e, i) {
                var o = this;
                o.elem = i, o.$elem = t(i), o.imageSrc = o.$elem.data("zoom-image") ? o.$elem.data("zoom-image") : o.$elem.attr("src"), o.options = t.extend({}, t.fn.elevateZoom.options, e), o.options.tint && (o.options.lensColour = "none", o.options.lensOpacity = "1"), "inner" == o.options.zoomType && (o.options.showLens = !1), o.$elem.parent().removeAttr("title").removeAttr("alt"), o.zoomImage = o.imageSrc, o.refresh(1), t("#" + o.options.gallery + " a").click(function(e) {
                    return o.options.galleryActiveClass && (t("#" + o.options.gallery + " a").removeClass(o.options.galleryActiveClass), t(this).addClass(o.options.galleryActiveClass)), e.preventDefault(), t(this).data("zoom-image") ? o.zoomImagePre = t(this).data("zoom-image") : o.zoomImagePre = t(this).data("image"), o.swaptheimage(t(this).data("image"), o.zoomImagePre), !1
                })
            },
            refresh: function(t) {
                var e = this;
                setTimeout(function() {
                    e.fetch(e.imageSrc)
                }, t || e.options.refresh)
            },
            fetch: function(t) {
                var e = this,
                    i = new Image;
                i.onload = function() {
                    e.largeWidth = i.width, e.largeHeight = i.height, e.startZoom(), e.currentImage = e.imageSrc, e.options.onZoomedImageLoaded(e.$elem)
                }, i.src = t
            },
            startZoom: function() {
                var e = this;
                if (e.nzWidth = e.$elem.width(), e.nzHeight = e.$elem.height(), e.isWindowActive = !1, e.isLensActive = !1, e.isTintActive = !1, e.overWindow = !1, e.options.imageCrossfade && (e.zoomWrap = e.$elem.wrap('<div style="height:' + e.nzHeight + "px;width:" + e.nzWidth + 'px;" class="zoomWrapper" />'), e.$elem.css("position", "absolute")), e.zoomLock = 1, e.scrollingLock = !1, e.changeBgSize = !1, e.currentZoomLevel = e.options.zoomLevel, e.nzOffset = e.$elem.offset(), e.widthRatio = e.largeWidth / e.currentZoomLevel / e.nzWidth, e.heightRatio = e.largeHeight / e.currentZoomLevel / e.nzHeight, "window" == e.options.zoomType && (e.zoomWindowStyle = "overflow: hidden;background-position: 0px 0px;text-align:center;background-color: " + String(e.options.zoomWindowBgColour) + ";width: " + String(e.options.zoomWindowWidth) + "px;height: " + String(e.options.zoomWindowHeight) + "px;float: left;background-size: " + e.largeWidth / e.currentZoomLevel + "px " + e.largeHeight / e.currentZoomLevel + "px;display: none;z-index:100;border: " + String(e.options.borderSize) + "px solid " + e.options.borderColour + ";background-repeat: no-repeat;position: absolute;"), "inner" == e.options.zoomType) {
                    var i = e.$elem.css("border-left-width");
                    e.zoomWindowStyle = "overflow: hidden;margin-left: " + String(i) + ";margin-top: " + String(i) + ";background-position: 0px 0px;width: " + String(e.nzWidth) + "px;height: " + String(e.nzHeight) + "px;float: left;display: none;cursor:" + e.options.cursor + ";px solid " + e.options.borderColour + ";background-repeat: no-repeat;position: absolute;"
                }
                "window" == e.options.zoomType && (e.nzHeight < e.options.zoomWindowWidth / e.widthRatio ? lensHeight = e.nzHeight : lensHeight = String(e.options.zoomWindowHeight / e.heightRatio), e.largeWidth < e.options.zoomWindowWidth ? lensWidth = e.nzWidth : lensWidth = e.options.zoomWindowWidth / e.widthRatio, e.lensStyle = "background-position: 0px 0px;width: " + String(e.options.zoomWindowWidth / e.widthRatio) + "px;height: " + String(e.options.zoomWindowHeight / e.heightRatio) + "px;float: right;display: none;overflow: hidden;z-index: 999;-webkit-transform: translateZ(0);opacity:" + e.options.lensOpacity + ";filter: alpha(opacity = " + 100 * e.options.lensOpacity + "); zoom:1;width:" + lensWidth + "px;height:" + lensHeight + "px;background-color:" + e.options.lensColour + ";cursor:" + e.options.cursor + ";border: " + e.options.lensBorderSize + "px solid " + e.options.lensBorderColour + ";background-repeat: no-repeat;position: absolute;"), e.tintStyle = "display: block;position: absolute;background-color: " + e.options.tintColour + ";filter:alpha(opacity=0);opacity: 0;width: " + e.nzWidth + "px;height: " + e.nzHeight + "px;", e.lensRound = "", "lens" == e.options.zoomType && (e.lensStyle = "background-position: 0px 0px;float: left;display: none;border: " + String(e.options.borderSize) + "px solid " + e.options.borderColour + ";width:" + String(e.options.lensSize) + "px;height:" + String(e.options.lensSize) + "px;background-repeat: no-repeat;position: absolute;"), "round" == e.options.lensShape && (e.lensRound = "border-top-left-radius: " + String(e.options.lensSize / 2 + e.options.borderSize) + "px;border-top-right-radius: " + String(e.options.lensSize / 2 + e.options.borderSize) + "px;border-bottom-left-radius: " + String(e.options.lensSize / 2 + e.options.borderSize) + "px;border-bottom-right-radius: " + String(e.options.lensSize / 2 + e.options.borderSize) + "px;"), e.zoomContainer = t('<div class="zoomContainer" style="-webkit-transform: translateZ(0);position:absolute;left:' + e.nzOffset.left + "px;top:" + e.nzOffset.top + "px;height:" + e.nzHeight + "px;width:" + e.nzWidth + 'px;"></div>'),
                    t("body").append(e.zoomContainer), e.options.containLensZoom && "lens" == e.options.zoomType && e.zoomContainer.css("overflow", "hidden"), "inner" != e.options.zoomType && (e.zoomLens = t("<div class='zoomLens' style='" + e.lensStyle + e.lensRound + "'>&nbsp;</div>").appendTo(e.zoomContainer).click(function() {
                        e.$elem.trigger("click")
                    }), e.options.tint && (e.tintContainer = t("<div/>").addClass("tintContainer"), e.zoomTint = t("<div class='zoomTint' style='" + e.tintStyle + "'></div>"), e.zoomLens.wrap(e.tintContainer), e.zoomTintcss = e.zoomLens.after(e.zoomTint), e.zoomTintImage = t('<img style="position: absolute; left: 0px; top: 0px; max-width: none; width: ' + e.nzWidth + "px; height: " + e.nzHeight + 'px;" src="' + e.imageSrc + '">').appendTo(e.zoomLens).click(function() {
                        e.$elem.trigger("click")
                    }))), isNaN(e.options.zoomWindowPosition) ? e.zoomWindow = t("<div style='z-index:999;left:" + e.windowOffsetLeft + "px;top:" + e.windowOffsetTop + "px;" + e.zoomWindowStyle + "' class='zoomWindow'>&nbsp;</div>").appendTo("body").click(function() {
                        e.$elem.trigger("click")
                    }) : e.zoomWindow = t("<div style='z-index:999;left:" + e.windowOffsetLeft + "px;top:" + e.windowOffsetTop + "px;" + e.zoomWindowStyle + "' class='zoomWindow'>&nbsp;</div>").appendTo(e.zoomContainer).click(function() {
                        e.$elem.trigger("click")
                    }), e.zoomWindowContainer = t("<div/>").addClass("zoomWindowContainer").css("width", e.options.zoomWindowWidth), e.zoomWindow.wrap(e.zoomWindowContainer), "lens" == e.options.zoomType && e.zoomLens.css({
                        backgroundImage: "url('" + e.imageSrc + "')"
                    }), "window" == e.options.zoomType && e.zoomWindow.css({
                        backgroundImage: "url('" + e.imageSrc + "')"
                    }), "inner" == e.options.zoomType && e.zoomWindow.css({
                        backgroundImage: "url('" + e.imageSrc + "')"
                    }), e.$elem.bind("touchmove", function(t) {
                        t.preventDefault();
                        var i = t.originalEvent.touches[0] || t.originalEvent.changedTouches[0];
                        e.setPosition(i)
                    }), e.zoomContainer.bind("touchmove", function(t) {
                        "inner" == e.options.zoomType && e.showHideWindow("show"), t.preventDefault();
                        var i = t.originalEvent.touches[0] || t.originalEvent.changedTouches[0];
                        e.setPosition(i)
                    }), e.zoomContainer.bind("touchend", function(t) {
                        e.showHideWindow("hide"), e.options.showLens && e.showHideLens("hide"), e.options.tint && "inner" != e.options.zoomType && e.showHideTint("hide")
                    }), e.$elem.bind("touchend", function(t) {
                        e.showHideWindow("hide"), e.options.showLens && e.showHideLens("hide"), e.options.tint && "inner" != e.options.zoomType && e.showHideTint("hide")
                    }), e.options.showLens && (e.zoomLens.bind("touchmove", function(t) {
                        t.preventDefault();
                        var i = t.originalEvent.touches[0] || t.originalEvent.changedTouches[0];
                        e.setPosition(i)
                    }), e.zoomLens.bind("touchend", function(t) {
                        e.showHideWindow("hide"), e.options.showLens && e.showHideLens("hide"), e.options.tint && "inner" != e.options.zoomType && e.showHideTint("hide")
                    })), e.$elem.bind("mousemove", function(t) {
                        0 == e.overWindow && e.setElements("show"), (e.lastX !== t.clientX || e.lastY !== t.clientY) && (e.setPosition(t), e.currentLoc = t), e.lastX = t.clientX, e.lastY = t.clientY
                    }), e.zoomContainer.bind("mousemove", function(t) {
                        0 == e.overWindow && e.setElements("show"), (e.lastX !== t.clientX || e.lastY !== t.clientY) && (e.setPosition(t), e.currentLoc = t), e.lastX = t.clientX, e.lastY = t.clientY
                    }), "inner" != e.options.zoomType && e.zoomLens.bind("mousemove", function(t) {
                        (e.lastX !== t.clientX || e.lastY !== t.clientY) && (e.setPosition(t), e.currentLoc = t), e.lastX = t.clientX, e.lastY = t.clientY
                    }), e.options.tint && "inner" != e.options.zoomType && e.zoomTint.bind("mousemove", function(t) {
                        (e.lastX !== t.clientX || e.lastY !== t.clientY) && (e.setPosition(t), e.currentLoc = t), e.lastX = t.clientX, e.lastY = t.clientY
                    }), "inner" == e.options.zoomType && e.zoomWindow.bind("mousemove", function(t) {
                        (e.lastX !== t.clientX || e.lastY !== t.clientY) && (e.setPosition(t), e.currentLoc = t), e.lastX = t.clientX, e.lastY = t.clientY
                    }), e.zoomContainer.add(e.$elem).mouseenter(function() {
                        0 == e.overWindow && e.setElements("show")
                    }).mouseleave(function() {
                        e.scrollLock || e.setElements("hide")
                    }), "inner" != e.options.zoomType && e.zoomWindow.mouseenter(function() {
                        e.overWindow = !0, e.setElements("hide")
                    }).mouseleave(function() {
                        e.overWindow = !1
                    }), 1 != e.options.zoomLevel, e.options.minZoomLevel ? e.minZoomLevel = e.options.minZoomLevel : e.minZoomLevel = 2 * e.options.scrollZoomIncrement, e.options.scrollZoom && e.zoomContainer.add(e.$elem).bind("mousewheel DOMMouseScroll MozMousePixelScroll", function(i) {
                        e.scrollLock = !0, clearTimeout(t.data(this, "timer")), t.data(this, "timer", setTimeout(function() {
                            e.scrollLock = !1
                        }, 250));
                        var o = i.originalEvent.wheelDelta || -1 * i.originalEvent.detail;
                        return i.stopImmediatePropagation(), i.stopPropagation(), i.preventDefault(), o / 120 > 0 ? e.currentZoomLevel >= e.minZoomLevel && e.changeZoomLevel(e.currentZoomLevel - e.options.scrollZoomIncrement) : e.options.maxZoomLevel ? e.currentZoomLevel <= e.options.maxZoomLevel && e.changeZoomLevel(parseFloat(e.currentZoomLevel) + e.options.scrollZoomIncrement) : e.changeZoomLevel(parseFloat(e.currentZoomLevel) + e.options.scrollZoomIncrement), !1
                    })
            },
            setElements: function(t) {
                var e = this;
                return e.options.zoomEnabled ? ("show" == t && e.isWindowSet && ("inner" == e.options.zoomType && e.showHideWindow("show"), "window" == e.options.zoomType && e.showHideWindow("show"), e.options.showLens && e.showHideLens("show"), e.options.tint && "inner" != e.options.zoomType && e.showHideTint("show")), void("hide" == t && ("window" == e.options.zoomType && e.showHideWindow("hide"), e.options.tint || e.showHideWindow("hide"), e.options.showLens && e.showHideLens("hide"), e.options.tint && e.showHideTint("hide")))) : !1
            },
            setPosition: function(t) {
                var e = this;
                return e.options.zoomEnabled ? (e.nzHeight = e.$elem.height(), e.nzWidth = e.$elem.width(), e.nzOffset = e.$elem.offset(), e.options.tint && "inner" != e.options.zoomType && (e.zoomTint.css({
                    top: 0
                }), e.zoomTint.css({
                    left: 0
                })), e.options.responsive && !e.options.scrollZoom && e.options.showLens && (e.nzHeight < e.options.zoomWindowWidth / e.widthRatio ? lensHeight = e.nzHeight : lensHeight = String(e.options.zoomWindowHeight / e.heightRatio), e.largeWidth < e.options.zoomWindowWidth ? lensWidth = e.nzWidth : lensWidth = e.options.zoomWindowWidth / e.widthRatio, e.widthRatio = e.largeWidth / e.nzWidth, e.heightRatio = e.largeHeight / e.nzHeight, "lens" != e.options.zoomType && (e.nzHeight < e.options.zoomWindowWidth / e.widthRatio ? lensHeight = e.nzHeight : lensHeight = String(e.options.zoomWindowHeight / e.heightRatio), e.options.zoomWindowWidth < e.options.zoomWindowWidth ? lensWidth = e.nzWidth : lensWidth = e.options.zoomWindowWidth / e.widthRatio, e.zoomLens.css("width", lensWidth), e.zoomLens.css("height", lensHeight), e.options.tint && (e.zoomTintImage.css("width", e.nzWidth), e.zoomTintImage.css("height", e.nzHeight))), "lens" == e.options.zoomType && e.zoomLens.css({
                    width: String(e.options.lensSize) + "px",
                    height: String(e.options.lensSize) + "px"
                })), e.zoomContainer.css({
                    top: e.nzOffset.top
                }), e.zoomContainer.css({
                    left: e.nzOffset.left
                }), e.mouseLeft = parseInt(t.pageX - e.nzOffset.left), e.mouseTop = parseInt(t.pageY - e.nzOffset.top), "window" == e.options.zoomType && (e.Etoppos = e.mouseTop < e.zoomLens.height() / 2, e.Eboppos = e.mouseTop > e.nzHeight - e.zoomLens.height() / 2 - 2 * e.options.lensBorderSize, e.Eloppos = e.mouseLeft < 0 + e.zoomLens.width() / 2, e.Eroppos = e.mouseLeft > e.nzWidth - e.zoomLens.width() / 2 - 2 * e.options.lensBorderSize), "inner" == e.options.zoomType && (e.Etoppos = e.mouseTop < e.nzHeight / 2 / e.heightRatio, e.Eboppos = e.mouseTop > e.nzHeight - e.nzHeight / 2 / e.heightRatio, e.Eloppos = e.mouseLeft < 0 + e.nzWidth / 2 / e.widthRatio, e.Eroppos = e.mouseLeft > e.nzWidth - e.nzWidth / 2 / e.widthRatio - 2 * e.options.lensBorderSize), e.mouseLeft <= 0 || e.mouseTop < 0 || e.mouseLeft > e.nzWidth || e.mouseTop > e.nzHeight ? void e.setElements("hide") : (e.options.showLens && (e.lensLeftPos = String(e.mouseLeft - e.zoomLens.width() / 2), e.lensTopPos = String(e.mouseTop - e.zoomLens.height() / 2)), e.Etoppos && (e.lensTopPos = 0), e.Eloppos && (e.windowLeftPos = 0, e.lensLeftPos = 0, e.tintpos = 0), "window" == e.options.zoomType && (e.Eboppos && (e.lensTopPos = Math.max(e.nzHeight - e.zoomLens.height() - 2 * e.options.lensBorderSize, 0)), e.Eroppos && (e.lensLeftPos = e.nzWidth - e.zoomLens.width() - 2 * e.options.lensBorderSize)), "inner" == e.options.zoomType && (e.Eboppos && (e.lensTopPos = Math.max(e.nzHeight - 2 * e.options.lensBorderSize, 0)), e.Eroppos && (e.lensLeftPos = e.nzWidth - e.nzWidth - 2 * e.options.lensBorderSize)), "lens" == e.options.zoomType && (e.windowLeftPos = String(-1 * ((t.pageX - e.nzOffset.left) * e.widthRatio - e.zoomLens.width() / 2)), e.windowTopPos = String(-1 * ((t.pageY - e.nzOffset.top) * e.heightRatio - e.zoomLens.height() / 2)), e.zoomLens.css({
                    backgroundPosition: e.windowLeftPos + "px " + e.windowTopPos + "px"
                }), e.changeBgSize && (e.nzHeight > e.nzWidth ? ("lens" == e.options.zoomType && e.zoomLens.css({
                    "background-size": e.largeWidth / e.newvalueheight + "px " + e.largeHeight / e.newvalueheight + "px"
                }), e.zoomWindow.css({
                    "background-size": e.largeWidth / e.newvalueheight + "px " + e.largeHeight / e.newvalueheight + "px"
                })) : ("lens" == e.options.zoomType && e.zoomLens.css({
                    "background-size": e.largeWidth / e.newvaluewidth + "px " + e.largeHeight / e.newvaluewidth + "px"
                }), e.zoomWindow.css({
                    "background-size": e.largeWidth / e.newvaluewidth + "px " + e.largeHeight / e.newvaluewidth + "px"
                })), e.changeBgSize = !1), e.setWindowPostition(t)), e.options.tint && "inner" != e.options.zoomType && e.setTintPosition(t), "window" == e.options.zoomType && e.setWindowPostition(t), "inner" == e.options.zoomType && e.setWindowPostition(t), e.options.showLens && (e.fullwidth && "lens" != e.options.zoomType && (e.lensLeftPos = 0), e.zoomLens.css({
                    left: e.lensLeftPos + "px",
                    top: e.lensTopPos + "px"
                })), void 0)) : !1
            },
            showHideWindow: function(t) {
                var e = this;
                "show" == t && (e.isWindowActive || (e.options.zoomWindowFadeIn ? e.zoomWindow.stop(!0, !0, !1).fadeIn(e.options.zoomWindowFadeIn) : e.zoomWindow.show(), e.isWindowActive = !0)), "hide" == t && e.isWindowActive && (e.options.zoomWindowFadeOut ? e.zoomWindow.stop(!0, !0).fadeOut(e.options.zoomWindowFadeOut) : e.zoomWindow.hide(), e.isWindowActive = !1)
            },
            showHideLens: function(t) {
                var e = this;
                "show" == t && (e.isLensActive || (e.options.lensFadeIn ? e.zoomLens.stop(!0, !0, !1).fadeIn(e.options.lensFadeIn) : e.zoomLens.show(), e.isLensActive = !0)), "hide" == t && e.isLensActive && (e.options.lensFadeOut ? e.zoomLens.stop(!0, !0).fadeOut(e.options.lensFadeOut) : e.zoomLens.hide(), e.isLensActive = !1)
            },
            showHideTint: function(t) {
                var e = this;
                "show" == t && (e.isTintActive || (e.options.zoomTintFadeIn ? e.zoomTint.css({
                    opacity: e.options.tintOpacity
                }).animate().stop(!0, !0).fadeIn("slow") : (e.zoomTint.css({
                    opacity: e.options.tintOpacity
                }).animate(), e.zoomTint.show()), e.isTintActive = !0)), "hide" == t && e.isTintActive && (e.options.zoomTintFadeOut ? e.zoomTint.stop(!0, !0).fadeOut(e.options.zoomTintFadeOut) : e.zoomTint.hide(), e.isTintActive = !1)
            },
            setLensPostition: function(t) {},
            setWindowPostition: function(e) {
                var i = this;
                if (isNaN(i.options.zoomWindowPosition)) i.externalContainer = t("#" + i.options.zoomWindowPosition), i.externalContainerWidth = i.externalContainer.width(), i.externalContainerHeight = i.externalContainer.height(), i.externalContainerOffset = i.externalContainer.offset(), i.windowOffsetTop = i.externalContainerOffset.top, i.windowOffsetLeft = i.externalContainerOffset.left;
                else switch (i.options.zoomWindowPosition) {
                    case 1:
                        i.windowOffsetTop = i.options.zoomWindowOffety, i.windowOffsetLeft = +i.nzWidth;
                        break;
                    case 2:
                        i.options.zoomWindowHeight > i.nzHeight && (i.windowOffsetTop = -1 * (i.options.zoomWindowHeight / 2 - i.nzHeight / 2), i.windowOffsetLeft = i.nzWidth);
                        break;
                    case 3:
                        i.windowOffsetTop = i.nzHeight - i.zoomWindow.height() - 2 * i.options.borderSize, i.windowOffsetLeft = i.nzWidth;
                        break;
                    case 4:
                        i.windowOffsetTop = i.nzHeight, i.windowOffsetLeft = i.nzWidth;
                        break;
                    case 5:
                        i.windowOffsetTop = i.nzHeight, i.windowOffsetLeft = i.nzWidth - i.zoomWindow.width() - 2 * i.options.borderSize;
                        break;
                    case 6:
                        i.options.zoomWindowHeight > i.nzHeight && (i.windowOffsetTop = i.nzHeight, i.windowOffsetLeft = -1 * (i.options.zoomWindowWidth / 2 - i.nzWidth / 2 + 2 * i.options.borderSize));
                        break;
                    case 7:
                        i.windowOffsetTop = i.nzHeight, i.windowOffsetLeft = 0;
                        break;
                    case 8:
                        i.windowOffsetTop = i.nzHeight, i.windowOffsetLeft = -1 * (i.zoomWindow.width() + 2 * i.options.borderSize);
                        break;
                    case 9:
                        i.windowOffsetTop = i.nzHeight - i.zoomWindow.height() - 2 * i.options.borderSize, i.windowOffsetLeft = -1 * (i.zoomWindow.width() + 2 * i.options.borderSize);
                        break;
                    case 10:
                        i.options.zoomWindowHeight > i.nzHeight && (i.windowOffsetTop = -1 * (i.options.zoomWindowHeight / 2 - i.nzHeight / 2), i.windowOffsetLeft = -1 * (i.zoomWindow.width() + 2 * i.options.borderSize));
                        break;
                    case 11:
                        i.windowOffsetTop = i.options.zoomWindowOffety, i.windowOffsetLeft = -1 * (i.zoomWindow.width() + 2 * i.options.borderSize);
                        break;
                    case 12:
                        i.windowOffsetTop = -1 * (i.zoomWindow.height() + 2 * i.options.borderSize), i.windowOffsetLeft = -1 * (i.zoomWindow.width() + 2 * i.options.borderSize);
                        break;
                    case 13:
                        i.windowOffsetTop = -1 * (i.zoomWindow.height() + 2 * i.options.borderSize), i.windowOffsetLeft = 0;
                        break;
                    case 14:
                        i.options.zoomWindowHeight > i.nzHeight && (i.windowOffsetTop = -1 * (i.zoomWindow.height() + 2 * i.options.borderSize), i.windowOffsetLeft = -1 * (i.options.zoomWindowWidth / 2 - i.nzWidth / 2 + 2 * i.options.borderSize));
                        break;
                    case 15:
                        i.windowOffsetTop = -1 * (i.zoomWindow.height() + 2 * i.options.borderSize), i.windowOffsetLeft = i.nzWidth - i.zoomWindow.width() - 2 * i.options.borderSize;
                        break;
                    case 16:
                        i.windowOffsetTop = -1 * (i.zoomWindow.height() + 2 * i.options.borderSize), i.windowOffsetLeft = i.nzWidth;
                        break;
                    default:
                        i.windowOffsetTop = i.options.zoomWindowOffety, i.windowOffsetLeft = i.nzWidth
                }
                i.isWindowSet = !0, i.windowOffsetTop = i.windowOffsetTop + i.options.zoomWindowOffety, i.windowOffsetLeft = i.windowOffsetLeft + i.options.zoomWindowOffetx, i.zoomWindow.css({
                    top: i.windowOffsetTop
                }), i.zoomWindow.css({
                    left: i.windowOffsetLeft
                }), "inner" == i.options.zoomType && (i.zoomWindow.css({
                    top: 0
                }), i.zoomWindow.css({
                    left: 0
                })), i.windowLeftPos = String(-1 * ((e.pageX - i.nzOffset.left) * i.widthRatio - i.zoomWindow.width() / 2)), i.windowTopPos = String(-1 * ((e.pageY - i.nzOffset.top) * i.heightRatio - i.zoomWindow.height() / 2)), i.Etoppos && (i.windowTopPos = 0), i.Eloppos && (i.windowLeftPos = 0), i.Eboppos && (i.windowTopPos = -1 * (i.largeHeight / i.currentZoomLevel - i.zoomWindow.height())), i.Eroppos && (i.windowLeftPos = -1 * (i.largeWidth / i.currentZoomLevel - i.zoomWindow.width())), i.fullheight && (i.windowTopPos = 0), i.fullwidth && (i.windowLeftPos = 0), ("window" == i.options.zoomType || "inner" == i.options.zoomType) && (1 == i.zoomLock && (i.widthRatio <= 1 && (i.windowLeftPos = 0), i.heightRatio <= 1 && (i.windowTopPos = 0)), i.largeHeight < i.options.zoomWindowHeight && (i.windowTopPos = 0), i.largeWidth < i.options.zoomWindowWidth && (i.windowLeftPos = 0), i.options.easing ? (i.xp || (i.xp = 0), i.yp || (i.yp = 0), i.loop || (i.loop = setInterval(function() {
                    i.xp += (i.windowLeftPos - i.xp) / i.options.easingAmount, i.yp += (i.windowTopPos - i.yp) / i.options.easingAmount, i.scrollingLock ? (clearInterval(i.loop), i.xp = i.windowLeftPos, i.yp = i.windowTopPos, i.xp = -1 * ((e.pageX - i.nzOffset.left) * i.widthRatio - i.zoomWindow.width() / 2), i.yp = -1 * ((e.pageY - i.nzOffset.top) * i.heightRatio - i.zoomWindow.height() / 2), i.changeBgSize && (i.nzHeight > i.nzWidth ? ("lens" == i.options.zoomType && i.zoomLens.css({
                        "background-size": i.largeWidth / i.newvalueheight + "px " + i.largeHeight / i.newvalueheight + "px"
                    }), i.zoomWindow.css({
                        "background-size": i.largeWidth / i.newvalueheight + "px " + i.largeHeight / i.newvalueheight + "px"
                    })) : ("lens" != i.options.zoomType && i.zoomLens.css({
                        "background-size": i.largeWidth / i.newvaluewidth + "px " + i.largeHeight / i.newvalueheight + "px"
                    }), i.zoomWindow.css({
                        "background-size": i.largeWidth / i.newvaluewidth + "px " + i.largeHeight / i.newvaluewidth + "px"
                    })), i.changeBgSize = !1), i.zoomWindow.css({
                        backgroundPosition: i.windowLeftPos + "px " + i.windowTopPos + "px"
                    }), i.scrollingLock = !1, i.loop = !1) : (i.changeBgSize && (i.nzHeight > i.nzWidth ? ("lens" == i.options.zoomType && i.zoomLens.css({
                        "background-size": i.largeWidth / i.newvalueheight + "px " + i.largeHeight / i.newvalueheight + "px"
                    }), i.zoomWindow.css({
                        "background-size": i.largeWidth / i.newvalueheight + "px " + i.largeHeight / i.newvalueheight + "px"
                    })) : ("lens" != i.options.zoomType && i.zoomLens.css({
                        "background-size": i.largeWidth / i.newvaluewidth + "px " + i.largeHeight / i.newvaluewidth + "px"
                    }), i.zoomWindow.css({
                        "background-size": i.largeWidth / i.newvaluewidth + "px " + i.largeHeight / i.newvaluewidth + "px"
                    })), i.changeBgSize = !1), i.zoomWindow.css({
                        backgroundPosition: i.xp + "px " + i.yp + "px"
                    }))
                }, 16))) : (i.changeBgSize && (i.nzHeight > i.nzWidth ? ("lens" == i.options.zoomType && i.zoomLens.css({
                    "background-size": i.largeWidth / i.newvalueheight + "px " + i.largeHeight / i.newvalueheight + "px"
                }), i.zoomWindow.css({
                    "background-size": i.largeWidth / i.newvalueheight + "px " + i.largeHeight / i.newvalueheight + "px"
                })) : ("lens" == i.options.zoomType && i.zoomLens.css({
                    "background-size": i.largeWidth / i.newvaluewidth + "px " + i.largeHeight / i.newvaluewidth + "px"
                }), i.largeHeight / i.newvaluewidth < i.options.zoomWindowHeight ? i.zoomWindow.css({
                    "background-size": i.largeWidth / i.newvaluewidth + "px " + i.largeHeight / i.newvaluewidth + "px"
                }) : i.zoomWindow.css({
                    "background-size": i.largeWidth / i.newvalueheight + "px " + i.largeHeight / i.newvalueheight + "px"
                })), i.changeBgSize = !1), i.zoomWindow.css({
                    backgroundPosition: i.windowLeftPos + "px " + i.windowTopPos + "px"
                })))
            },
            setTintPosition: function(t) {
                var e = this;
                e.nzOffset = e.$elem.offset(), e.tintpos = String(-1 * (t.pageX - e.nzOffset.left - e.zoomLens.width() / 2)), e.tintposy = String(-1 * (t.pageY - e.nzOffset.top - e.zoomLens.height() / 2)), e.Etoppos && (e.tintposy = 0), e.Eloppos && (e.tintpos = 0), e.Eboppos && (e.tintposy = -1 * (e.nzHeight - e.zoomLens.height() - 2 * e.options.lensBorderSize)), e.Eroppos && (e.tintpos = -1 * (e.nzWidth - e.zoomLens.width() - 2 * e.options.lensBorderSize)), e.options.tint && (e.fullheight && (e.tintposy = 0), e.fullwidth && (e.tintpos = 0), e.zoomTintImage.css({
                    left: e.tintpos + "px"
                }), e.zoomTintImage.css({
                    top: e.tintposy + "px"
                }))
            },
            swaptheimage: function(e, i) {
                var o = this,
                    n = new Image;
                o.options.loadingIcon && (o.spinner = t("<div style=\"background: url('" + o.options.loadingIcon + "') no-repeat center;height:" + o.nzHeight + "px;width:" + o.nzWidth + 'px;z-index: 2000;position: absolute; background-position: center center;"></div>'), o.$elem.after(o.spinner)), o.options.onImageSwap(o.$elem), n.onload = function() {
                    o.largeWidth = n.width, o.largeHeight = n.height, o.zoomImage = i, o.zoomWindow.css({
                        "background-size": o.largeWidth + "px " + o.largeHeight + "px"
                    }), o.zoomWindow.css({
                        "background-size": o.largeWidth + "px " + o.largeHeight + "px"
                    }), o.swapAction(e, i)
                }, n.src = i
            },
            swapAction: function(e, i) {
                var o = this,
                    n = new Image;
                if (n.onload = function() {
                        o.nzHeight = n.height, o.nzWidth = n.width, o.options.onImageSwapComplete(o.$elem), o.doneCallback()
                    }, n.src = e, o.currentZoomLevel = o.options.zoomLevel, o.options.maxZoomLevel = !1, "lens" == o.options.zoomType && o.zoomLens.css({
                        backgroundImage: "url('" + i + "')"
                    }), "window" == o.options.zoomType && o.zoomWindow.css({
                        backgroundImage: "url('" + i + "')"
                    }), "inner" == o.options.zoomType && o.zoomWindow.css({
                        backgroundImage: "url('" + i + "')"
                    }), o.currentImage = i, o.options.imageCrossfade) {
                    var s = o.$elem,
                        a = s.clone();
                    if (o.$elem.attr("src", e), o.$elem.after(a), a.stop(!0).fadeOut(o.options.imageCrossfade, function() {
                            t(this).remove()
                        }), o.$elem.width("auto").removeAttr("width"), o.$elem.height("auto").removeAttr("height"), s.fadeIn(o.options.imageCrossfade), o.options.tint && "inner" != o.options.zoomType) {
                        var r = o.zoomTintImage,
                            l = r.clone();
                        o.zoomTintImage.attr("src", i), o.zoomTintImage.after(l), l.stop(!0).fadeOut(o.options.imageCrossfade, function() {
                            t(this).remove()
                        }), r.fadeIn(o.options.imageCrossfade), o.zoomTint.css({
                            height: o.$elem.height()
                        }), o.zoomTint.css({
                            width: o.$elem.width()
                        })
                    }
                    o.zoomContainer.css("height", o.$elem.height()), o.zoomContainer.css("width", o.$elem.width()), "inner" == o.options.zoomType && (o.options.constrainType || (o.zoomWrap.parent().css("height", o.$elem.height()), o.zoomWrap.parent().css("width", o.$elem.width()), o.zoomWindow.css("height", o.$elem.height()), o.zoomWindow.css("width", o.$elem.width()))), o.options.imageCrossfade && (o.zoomWrap.css("height", o.$elem.height()), o.zoomWrap.css("width", o.$elem.width()))
                } else o.$elem.attr("src", e), o.options.tint && (o.zoomTintImage.attr("src", i), o.zoomTintImage.attr("height", o.$elem.height()), o.zoomTintImage.css({
                    height: o.$elem.height()
                }), o.zoomTint.css({
                    height: o.$elem.height()
                })), o.zoomContainer.css("height", o.$elem.height()), o.zoomContainer.css("width", o.$elem.width()), o.options.imageCrossfade && (o.zoomWrap.css("height", o.$elem.height()), o.zoomWrap.css("width", o.$elem.width()));
                o.options.constrainType && ("height" == o.options.constrainType && (o.zoomContainer.css("height", o.options.constrainSize), o.zoomContainer.css("width", "auto"), o.options.imageCrossfade ? (o.zoomWrap.css("height", o.options.constrainSize), o.zoomWrap.css("width", "auto"), o.constwidth = o.zoomWrap.width()) : (o.$elem.css("height", o.options.constrainSize), o.$elem.css("width", "auto"), o.constwidth = o.$elem.width()), "inner" == o.options.zoomType && (o.zoomWrap.parent().css("height", o.options.constrainSize), o.zoomWrap.parent().css("width", o.constwidth), o.zoomWindow.css("height", o.options.constrainSize), o.zoomWindow.css("width", o.constwidth)), o.options.tint && (o.tintContainer.css("height", o.options.constrainSize), o.tintContainer.css("width", o.constwidth), o.zoomTint.css("height", o.options.constrainSize), o.zoomTint.css("width", o.constwidth), o.zoomTintImage.css("height", o.options.constrainSize), o.zoomTintImage.css("width", o.constwidth))), "width" == o.options.constrainType && (o.zoomContainer.css("height", "auto"), o.zoomContainer.css("width", o.options.constrainSize), o.options.imageCrossfade ? (o.zoomWrap.css("height", "auto"), o.zoomWrap.css("width", o.options.constrainSize), o.constheight = o.zoomWrap.height()) : (o.$elem.css("height", "auto"), o.$elem.css("width", o.options.constrainSize), o.constheight = o.$elem.height()), "inner" == o.options.zoomType && (o.zoomWrap.parent().css("height", o.constheight), o.zoomWrap.parent().css("width", o.options.constrainSize), o.zoomWindow.css("height", o.constheight), o.zoomWindow.css("width", o.options.constrainSize)), o.options.tint && (o.tintContainer.css("height", o.constheight), o.tintContainer.css("width", o.options.constrainSize), o.zoomTint.css("height", o.constheight), o.zoomTint.css("width", o.options.constrainSize), o.zoomTintImage.css("height", o.constheight), o.zoomTintImage.css("width", o.options.constrainSize))))
            },
            doneCallback: function() {
                var t = this;
                t.options.loadingIcon && t.spinner.hide(), t.nzOffset = t.$elem.offset(), t.nzWidth = t.$elem.width(), t.nzHeight = t.$elem.height(), t.currentZoomLevel = t.options.zoomLevel, t.widthRatio = t.largeWidth / t.nzWidth, t.heightRatio = t.largeHeight / t.nzHeight, "window" == t.options.zoomType && (t.nzHeight < t.options.zoomWindowWidth / t.widthRatio ? lensHeight = t.nzHeight : lensHeight = String(t.options.zoomWindowHeight / t.heightRatio), t.options.zoomWindowWidth < t.options.zoomWindowWidth ? lensWidth = t.nzWidth : lensWidth = t.options.zoomWindowWidth / t.widthRatio, t.zoomLens && (t.zoomLens.css("width", lensWidth), t.zoomLens.css("height", lensHeight)))
            },
            getCurrentImage: function() {
                var t = this;
                return t.zoomImage
            },
            getGalleryList: function() {
                var e = this;
                return e.gallerylist = [], e.options.gallery ? t("#" + e.options.gallery + " a").each(function() {
                    var i = "";
                    t(this).data("zoom-image") ? i = t(this).data("zoom-image") : t(this).data("image") && (i = t(this).data("image")), i == e.zoomImage ? e.gallerylist.unshift({
                        href: "" + i,
                        title: t(this).find("img").attr("title")
                    }) : e.gallerylist.push({
                        href: "" + i,
                        title: t(this).find("img").attr("title")
                    })
                }) : e.gallerylist.push({
                    href: "" + e.zoomImage,
                    title: t(this).find("img").attr("title")
                }), e.gallerylist
            },
            changeZoomLevel: function(t) {
                var e = this;
                e.scrollingLock = !0, e.newvalue = parseFloat(t).toFixed(2), newvalue = parseFloat(t).toFixed(2), maxheightnewvalue = e.largeHeight / (e.options.zoomWindowHeight / e.nzHeight * e.nzHeight), maxwidthtnewvalue = e.largeWidth / (e.options.zoomWindowWidth / e.nzWidth * e.nzWidth), "inner" != e.options.zoomType && (maxheightnewvalue <= newvalue ? (e.heightRatio = e.largeHeight / maxheightnewvalue / e.nzHeight, e.newvalueheight = maxheightnewvalue, e.fullheight = !0) : (e.heightRatio = e.largeHeight / newvalue / e.nzHeight, e.newvalueheight = newvalue, e.fullheight = !1), maxwidthtnewvalue <= newvalue ? (e.widthRatio = e.largeWidth / maxwidthtnewvalue / e.nzWidth, e.newvaluewidth = maxwidthtnewvalue, e.fullwidth = !0) : (e.widthRatio = e.largeWidth / newvalue / e.nzWidth, e.newvaluewidth = newvalue, e.fullwidth = !1), "lens" == e.options.zoomType && (maxheightnewvalue <= newvalue ? (e.fullwidth = !0, e.newvaluewidth = maxheightnewvalue) : (e.widthRatio = e.largeWidth / newvalue / e.nzWidth, e.newvaluewidth = newvalue, e.fullwidth = !1))), "inner" == e.options.zoomType && (maxheightnewvalue = parseFloat(e.largeHeight / e.nzHeight).toFixed(2), maxwidthtnewvalue = parseFloat(e.largeWidth / e.nzWidth).toFixed(2), newvalue > maxheightnewvalue && (newvalue = maxheightnewvalue), newvalue > maxwidthtnewvalue && (newvalue = maxwidthtnewvalue), maxheightnewvalue <= newvalue ? (e.heightRatio = e.largeHeight / newvalue / e.nzHeight, newvalue > maxheightnewvalue ? e.newvalueheight = maxheightnewvalue : e.newvalueheight = newvalue, e.fullheight = !0) : (e.heightRatio = e.largeHeight / newvalue / e.nzHeight, newvalue > maxheightnewvalue ? e.newvalueheight = maxheightnewvalue : e.newvalueheight = newvalue, e.fullheight = !1), maxwidthtnewvalue <= newvalue ? (e.widthRatio = e.largeWidth / newvalue / e.nzWidth, newvalue > maxwidthtnewvalue ? e.newvaluewidth = maxwidthtnewvalue : e.newvaluewidth = newvalue, e.fullwidth = !0) : (e.widthRatio = e.largeWidth / newvalue / e.nzWidth, e.newvaluewidth = newvalue, e.fullwidth = !1)), scrcontinue = !1, "inner" == e.options.zoomType && (e.nzWidth >= e.nzHeight && (e.newvaluewidth <= maxwidthtnewvalue ? scrcontinue = !0 : (scrcontinue = !1, e.fullheight = !0, e.fullwidth = !0)), e.nzHeight > e.nzWidth && (e.newvaluewidth <= maxwidthtnewvalue ? scrcontinue = !0 : (scrcontinue = !1, e.fullheight = !0, e.fullwidth = !0))), "inner" != e.options.zoomType && (scrcontinue = !0), scrcontinue && (e.zoomLock = 0, e.changeZoom = !0, e.options.zoomWindowHeight / e.heightRatio <= e.nzHeight && (e.currentZoomLevel = e.newvalueheight, "lens" != e.options.zoomType && "inner" != e.options.zoomType && (e.changeBgSize = !0, e.zoomLens.css({
                    height: String(e.options.zoomWindowHeight / e.heightRatio) + "px"
                })), ("lens" == e.options.zoomType || "inner" == e.options.zoomType) && (e.changeBgSize = !0)), e.options.zoomWindowWidth / e.widthRatio <= e.nzWidth && ("inner" != e.options.zoomType && e.newvaluewidth > e.newvalueheight && (e.currentZoomLevel = e.newvaluewidth), "lens" != e.options.zoomType && "inner" != e.options.zoomType && (e.changeBgSize = !0, e.zoomLens.css({
                    width: String(e.options.zoomWindowWidth / e.widthRatio) + "px"
                })), ("lens" == e.options.zoomType || "inner" == e.options.zoomType) && (e.changeBgSize = !0)), "inner" == e.options.zoomType && (e.changeBgSize = !0, e.nzWidth > e.nzHeight && (e.currentZoomLevel = e.newvaluewidth), e.nzHeight > e.nzWidth && (e.currentZoomLevel = e.newvaluewidth))), e.setPosition(e.currentLoc)
            },
            closeAll: function() {
                self.zoomWindow && self.zoomWindow.hide(), self.zoomLens && self.zoomLens.hide(), self.zoomTint && self.zoomTint.hide()
            },
            changeState: function(t) {
                var e = this;
                "enable" == t && (e.options.zoomEnabled = !0), "disable" == t && (e.options.zoomEnabled = !1)
            }
        };
        t.fn.elevateZoom = function(e) {
            return this.each(function() {
                var i = Object.create(n);
                i.init(e, this), t.data(this, "elevateZoom", i)
            })
        }, t.fn.elevateZoom.options = {
            zoomActivation: "hover",
            zoomEnabled: !0,
            preloading: 1,
            zoomLevel: 1,
            scrollZoom: !1,
            scrollZoomIncrement: .1,
            minZoomLevel: !1,
            maxZoomLevel: !1,
            easing: !1,
            easingAmount: 12,
            lensSize: 200,
            zoomWindowWidth: 400,
            zoomWindowHeight: 400,
            zoomWindowOffetx: 0,
            zoomWindowOffety: 0,
            zoomWindowPosition: 1,
            zoomWindowBgColour: "#fff",
            lensFadeIn: !1,
            lensFadeOut: !1,
            debug: !1,
            zoomWindowFadeIn: !1,
            zoomWindowFadeOut: !1,
            zoomWindowAlwaysShow: !1,
            zoomTintFadeIn: !1,
            zoomTintFadeOut: !1,
            borderSize: 4,
            showLens: !0,
            borderColour: "#888",
            lensBorderSize: 1,
            lensBorderColour: "#000",
            lensShape: "square",
            zoomType: "window",
            containLensZoom: !1,
            lensColour: "white",
            lensOpacity: .4,
            lenszoom: !1,
            tint: !1,
            tintColour: "#333",
            tintOpacity: .4,
            gallery: !1,
            galleryActiveClass: "zoomGalleryActive",
            imageCrossfade: !1,
            constrainType: !1,
            constrainSize: !1,
            loadingIcon: !1,
            cursor: "default",
            responsive: !0,
            onComplete: t.noop,
            onZoomedImageLoaded: function() {},
            onImageSwap: t.noop,
            onImageSwapComplete: t.noop
        }
    }(jQuery, window, document),
    function(t) {
        t(document).ready(function() {
            function e(t, e, i) {
                t /= 255, e /= 255, i /= 255;
                var o, n, s = Math.max(t, e, i),
                    a = Math.min(t, e, i),
                    r = (s + a) / 2;
                if (s == a) o = n = 0;
                else {
                    var l = s - a;
                    switch (n = r > .5 ? l / (2 - s - a) : l / (s + a), s) {
                        case t:
                            o = (e - i) / l + (i > e ? 6 : 0);
                            break;
                        case e:
                            o = (i - t) / l + 2;
                            break;
                        case i:
                            o = (t - e) / l + 4
                    }
                    o /= 6
                }
                return r
            }
            t("#cssmenu li.has-sub>a").on("click", function() {
                    t(this).removeAttr("href");
                    var e = t(this).parent("li");
                    e.hasClass("open") ? (e.removeClass("open"), e.find("li").removeClass("open"), e.find("ul").slideUp()) : (e.addClass("open"), e.children("ul").slideDown(), e.siblings("li").children("ul").slideUp(), e.siblings("li").removeClass("open"), e.siblings("li").find("li").removeClass("open"), e.siblings("li").find("ul").slideUp())
                }), t("#cssmenu>ul>li.has-sub>a").append('<span class="holder"></span>'),
                function() {
                    var i, o, n, s = t("#cssmenu").css("color");
                    if (void 0 != s) {
                        s = s.slice(4), i = s.slice(0, s.indexOf(",")), s = s.slice(s.indexOf(" ") + 1), o = s.slice(0, s.indexOf(",")), s = s.slice(s.indexOf(" ") + 1), n = s.slice(0, s.indexOf(")"));
                        e(i, o, n)
                    }
                }(), t("#cssmenu").find("li.open").eq(0).parents("ul").css("display", "block"), t("#cssmenu").find("li.open").eq(0).parents("li").addClass("open")
        })
    }(jQuery),
    function(t) {
        t.fn.camera = function(e, i) {
            function o() {
                return navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPod/i) ? !0 : void 0
            }

            function n() {
                var e = t($).width();
                t("li", $).removeClass("camera_visThumb"), t("li", $).each(function() {
                    var i = t(this).position(),
                        o = t("ul", $).outerWidth(),
                        n = t("ul", $).offset().left,
                        s = t("> div", $).offset().left,
                        a = s - n;
                    a > 0 ? t(".camera_prevThumbs", G).removeClass("hideNav") : t(".camera_prevThumbs", G).addClass("hideNav"), o - a > e ? t(".camera_nextThumbs", G).removeClass("hideNav") : t(".camera_nextThumbs", G).addClass("hideNav");
                    var r = i.left,
                        l = i.left + t(this).width();
                    e >= l - a && r - a >= 0 && t(this).addClass("camera_visThumb")
                })
            }

            function s() {
                function i() {
                    if (g = p.width(), -1 != e.height.indexOf("%")) {
                        var i = Math.round(g / (100 / parseFloat(e.height)));
                        v = "" != e.minHeight && i < parseFloat(e.minHeight) ? parseFloat(e.minHeight) : i, p.css({
                            height: v
                        })
                    } else "auto" == e.height ? v = p.height() : (v = parseFloat(e.height), p.css({
                        height: v
                    }));
                    t(".camerarelative", b).css({
                        width: g,
                        height: v
                    }), t(".imgLoaded", b).each(function() {
                        var i, o, n = t(this),
                            s = n.attr("width"),
                            a = n.attr("height"),
                            r = (n.index(), n.attr("data-alignment")),
                            l = n.attr("data-portrait");
                        if (("undefined" == typeof r || r === !1 || "" === r) && (r = e.alignment), ("undefined" == typeof l || l === !1 || "" === l) && (l = e.portrait), 0 == l || "false" == l)
                            if (g / v > s / a) {
                                var h = g / s,
                                    c = .5 * Math.abs(v - a * h);
                                switch (r) {
                                    case "topLeft":
                                        i = 0;
                                        break;
                                    case "topCenter":
                                        i = 0;
                                        break;
                                    case "topRight":
                                        i = 0;
                                        break;
                                    case "centerLeft":
                                        i = "-" + c + "px";
                                        break;
                                    case "center":
                                        i = "-" + c + "px";
                                        break;
                                    case "centerRight":
                                        i = "-" + c + "px";
                                        break;
                                    case "bottomLeft":
                                        i = "-" + 2 * c + "px";
                                        break;
                                    case "bottomCenter":
                                        i = "-" + 2 * c + "px";
                                        break;
                                    case "bottomRight":
                                        i = "-" + 2 * c + "px"
                                }
                                n.css({
                                    height: a * h,
                                    "margin-left": 0,
                                    "margin-right": 0,
                                    "margin-top": i,
                                    position: "absolute",
                                    visibility: "visible",
                                    width: g
                                })
                            } else {
                                var h = v / a,
                                    c = .5 * Math.abs(g - s * h);
                                switch (r) {
                                    case "topLeft":
                                        o = 0;
                                        break;
                                    case "topCenter":
                                        o = "-" + c + "px";
                                        break;
                                    case "topRight":
                                        o = "-" + 2 * c + "px";
                                        break;
                                    case "centerLeft":
                                        o = 0;
                                        break;
                                    case "center":
                                        o = "-" + c + "px";
                                        break;
                                    case "centerRight":
                                        o = "-" + 2 * c + "px";
                                        break;
                                    case "bottomLeft":
                                        o = 0;
                                        break;
                                    case "bottomCenter":
                                        o = "-" + c + "px";
                                        break;
                                    case "bottomRight":
                                        o = "-" + 2 * c + "px"
                                }
                                n.css({
                                    height: v,
                                    "margin-left": o,
                                    "margin-right": o,
                                    "margin-top": 0,
                                    position: "absolute",
                                    visibility: "visible",
                                    width: s * h
                                })
                            }
                        else if (g / v > s / a) {
                            var h = v / a,
                                c = .5 * Math.abs(g - s * h);
                            switch (r) {
                                case "topLeft":
                                    o = 0;
                                    break;
                                case "topCenter":
                                    o = c + "px";
                                    break;
                                case "topRight":
                                    o = 2 * c + "px";
                                    break;
                                case "centerLeft":
                                    o = 0;
                                    break;
                                case "center":
                                    o = c + "px";
                                    break;
                                case "centerRight":
                                    o = 2 * c + "px";
                                    break;
                                case "bottomLeft":
                                    o = 0;
                                    break;
                                case "bottomCenter":
                                    o = c + "px";
                                    break;
                                case "bottomRight":
                                    o = 2 * c + "px"
                            }
                            n.css({
                                height: v,
                                "margin-left": o,
                                "margin-right": o,
                                "margin-top": 0,
                                position: "absolute",
                                visibility: "visible",
                                width: s * h
                            })
                        } else {
                            var h = g / s,
                                c = .5 * Math.abs(v - a * h);
                            switch (r) {
                                case "topLeft":
                                    i = 0;
                                    break;
                                case "topCenter":
                                    i = 0;
                                    break;
                                case "topRight":
                                    i = 0;
                                    break;
                                case "centerLeft":
                                    i = c + "px";
                                    break;
                                case "center":
                                    i = c + "px";
                                    break;
                                case "centerRight":
                                    i = c + "px";
                                    break;
                                case "bottomLeft":
                                    i = 2 * c + "px";
                                    break;
                                case "bottomCenter":
                                    i = 2 * c + "px";
                                    break;
                                case "bottomRight":
                                    i = 2 * c + "px"
                            }
                            n.css({
                                height: a * h,
                                "margin-left": 0,
                                "margin-right": 0,
                                "margin-top": i,
                                position: "absolute",
                                visibility: "visible",
                                width: g
                            })
                        }
                    })
                }
                var o;
                1 == j ? (clearTimeout(o), o = setTimeout(i, 200)) : i(), j = !0
            }

            function a() {
                t("iframe", u).each(function() {
                    t(".camera_caption", u).show();
                    var i = t(this),
                        o = i.attr("data-src");
                    i.attr("src", o);
                    var n = e.imagePath + "blank.gif",
                        s = new Image;
                    if (s.src = n, -1 != e.height.indexOf("%")) {
                        var a = Math.round(g / (100 / parseFloat(e.height)));
                        v = "" != e.minHeight && a < parseFloat(e.minHeight) ? parseFloat(e.minHeight) : a
                    } else v = "auto" == e.height ? p.height() : parseFloat(e.height);
                    i.after(t(s).attr({
                        "class": "imgFake",
                        width: g,
                        height: v
                    }));
                    var r = i.clone();
                    i.remove(), t(s).bind("click", function() {
                        "absolute" == t(this).css("position") ? (t(this).remove(), -1 != o.indexOf("vimeo") || -1 != o.indexOf("youtube") ? -1 != o.indexOf("?") ? autoplay = "&autoplay=1" : autoplay = "?autoplay=1" : -1 != o.indexOf("dailymotion") && (-1 != o.indexOf("?") ? autoplay = "&autoPlay=1" : autoplay = "?autoPlay=1"), r.attr("src", o + autoplay), Y = !0) : (t(this).css({
                            position: "absolute",
                            top: 0,
                            left: 0,
                            zIndex: 10
                        }).after(r), r.css({
                            position: "absolute",
                            top: 0,
                            left: 0,
                            zIndex: 9
                        }))
                    })
                })
            }

            function r(t) {
                for (var e, i, o = t.length; o; e = parseInt(Math.random() * o), i = t[--o], t[o] = t[e], t[e] = i);
                return t
            }

            function l() {
                if (t($).length && !t(S).length) {
                    var e, i = t($).outerWidth(),
                        o = (t("ul > li", $).outerWidth(), t("li.cameracurrent", $).length ? t("li.cameracurrent", $).position() : ""),
                        s = t("ul > li", $).length * t("ul > li", $).outerWidth(),
                        a = t("ul", $).offset().left,
                        r = t("> div", $).offset().left;
                    e = 0 > a ? "-" + (r - a) : r - a, 1 == nt && (t("ul", $).width(t("ul > li", $).length * t("ul > li", $).outerWidth()), t($).length && !t(S).lenght && p.css({
                        marginBottom: t($).outerHeight()
                    }), n(), t("ul", $).width(t("ul > li", $).length * t("ul > li", $).outerWidth()), t($).length && !t(S).lenght && p.css({
                        marginBottom: t($).outerHeight()
                    })), nt = !1;
                    var l = t("li.cameracurrent", $).length ? o.left : "",
                        h = t("li.cameracurrent", $).length ? o.left + t("li.cameracurrent", $).outerWidth() : "";
                    l < t("li.cameracurrent", $).outerWidth() && (l = 0), h - e > i ? s > l + i ? t("ul", $).animate({
                        "margin-left": "-" + l + "px"
                    }, 500, n) : t("ul", $).animate({
                        "margin-left": "-" + (t("ul", $).outerWidth() - i) + "px"
                    }, 500, n) : 0 > l - e ? t("ul", $).animate({
                        "margin-left": "-" + l + "px"
                    }, 500, n) : (t("ul", $).css({
                        "margin-left": "auto",
                        "margin-right": "auto"
                    }), setTimeout(n, 100))
                }
            }

            function h() {
                tt = 0;
                var i = t(".camera_bar_cont", G).width(),
                    o = t(".camera_bar_cont", G).height();
                if ("pie" != f) switch (U) {
                    case "leftToRight":
                        t("#" + w).css({
                            right: i
                        });
                        break;
                    case "rightToLeft":
                        t("#" + w).css({
                            left: i
                        });
                        break;
                    case "topToBottom":
                        t("#" + w).css({
                            bottom: o
                        });
                        break;
                    case "bottomToTop":
                        t("#" + w).css({
                            top: o
                        })
                } else it.clearRect(0, 0, e.pieDiameter, e.pieDiameter)
            }

            function c(i) {
                y.addClass("camerasliding"), Y = !1;
                var n = parseFloat(t("div.cameraSlide.cameracurrent", b).index());
                if (i > 0) var d = i - 1;
                else if (n == P - 1) var d = 0;
                else var d = n + 1;
                var m = t(".cameraSlide:eq(" + d + ")", b),
                    x = t(".cameraSlide:eq(" + (d + 1) + ")", b).addClass("cameranext");
                if (n != d + 1 && x.hide(), t(".cameraContent", u).fadeOut(600), t(".camera_caption", u).show(), t(".camerarelative", m).append(t("> div ", y).eq(d).find("> div.camera_effected")), t(".camera_target_content .cameraContent:eq(" + d + ")", p).append(t("> div ", y).eq(d).find("> div")), t(".imgLoaded", m).length) {
                    if (W.length > d + 1 && !t(".imgLoaded", x).length) {
                        var z = W[d + 1],
                            _ = new Image;
                        _.src = z + "?" + (new Date).getTime(), x.prepend(t(_).attr("class", "imgLoaded").css("visibility", "hidden")), _.onload = function() {
                            yt = _.naturalWidth, bt = _.naturalHeight, t(_).attr("data-alignment", H[d + 1]).attr("data-portrait", O[d + 1]), t(_).attr("width", yt), t(_).attr("height", bt), s()
                        }
                    }
                    e.onLoaded.call(this), t(".camera_loader", p).is(":visible") ? t(".camera_loader", p).fadeOut(400) : (t(".camera_loader", p).css({
                        visibility: "hidden"
                    }), t(".camera_loader", p).fadeOut(400, function() {
                        t(".camera_loader", p).css({
                            visibility: "visible"
                        })
                    }));
                    var C, k, T, L, E, R = e.rows,
                        I = e.cols,
                        D = 1,
                        M = 0,
                        F = new Array("simpleFade", "curtainTopLeft", "curtainTopRight", "curtainBottomLeft", "curtainBottomRight", "curtainSliceLeft", "curtainSliceRight", "blindCurtainTopLeft", "blindCurtainTopRight", "blindCurtainBottomLeft", "blindCurtainBottomRight", "blindCurtainSliceBottom", "blindCurtainSliceTop", "stampede", "mosaic", "mosaicReverse", "mosaicRandom", "mosaicSpiral", "mosaicSpiralReverse", "topLeftBottomRight", "bottomRightTopLeft", "bottomLeftTopRight", "topRightBottomLeft", "scrollLeft", "scrollRight", "scrollTop", "scrollBottom", "scrollHorz");
                    marginLeft = 0, marginTop = 0, opacityOnGrid = 0, 1 == e.opacityOnGrid ? opacityOnGrid = 0 : opacityOnGrid = 1;
                    var j = t(" > div", y).eq(d).attr("data-fx");
                    if (L = o() && "" != e.mobileFx && "default" != e.mobileFx ? e.mobileFx : "undefined" != typeof j && j !== !1 && "default" !== j ? j : e.fx, "random" == L ? (L = r(F), L = L[0]) : (L = L, L.indexOf(",") > 0 && (L = L.replace(/ /g, ""), L = L.split(","), L = r(L), L = L[0])), dataEasing = t(" > div", y).eq(d).attr("data-easing"), mobileEasing = t(" > div", y).eq(d).attr("data-mobileEasing"), E = o() && "" != e.mobileEasing && "default" != e.mobileEasing ? "undefined" != typeof mobileEasing && mobileEasing !== !1 && "default" !== mobileEasing ? mobileEasing : e.mobileEasing : "undefined" != typeof dataEasing && dataEasing !== !1 && "default" !== dataEasing ? dataEasing : e.easing, C = t(" > div", y).eq(d).attr("data-slideOn"), "undefined" != typeof C && C !== !1) B = C;
                    else if ("random" == e.slideOn) {
                        var B = new Array("next", "prev");
                        B = r(B), B = B[0]
                    } else B = e.slideOn;
                    var Z = t(" > div", y).eq(d).attr("data-time");
                    k = "undefined" != typeof Z && Z !== !1 && "" !== Z ? parseFloat(Z) : e.time;
                    var X = t(" > div", y).eq(d).attr("data-transPeriod");
                    switch (T = "undefined" != typeof X && X !== !1 && "" !== X ? parseFloat(X) : e.transPeriod, t(y).hasClass("camerastarted") || (L = "simpleFade", B = "next", E = "", T = 400, t(y).addClass("camerastarted")), L) {
                        case "simpleFade":
                            I = 1, R = 1;
                            break;
                        case "curtainTopLeft":
                            I = 0 == e.slicedCols ? e.cols : e.slicedCols, R = 1;
                            break;
                        case "curtainTopRight":
                            I = 0 == e.slicedCols ? e.cols : e.slicedCols, R = 1;
                            break;
                        case "curtainBottomLeft":
                            I = 0 == e.slicedCols ? e.cols : e.slicedCols, R = 1;
                            break;
                        case "curtainBottomRight":
                            I = 0 == e.slicedCols ? e.cols : e.slicedCols, R = 1;
                            break;
                        case "curtainSliceLeft":
                            I = 0 == e.slicedCols ? e.cols : e.slicedCols, R = 1;
                            break;
                        case "curtainSliceRight":
                            I = 0 == e.slicedCols ? e.cols : e.slicedCols, R = 1;
                            break;
                        case "blindCurtainTopLeft":
                            R = 0 == e.slicedRows ? e.rows : e.slicedRows, I = 1;
                            break;
                        case "blindCurtainTopRight":
                            R = 0 == e.slicedRows ? e.rows : e.slicedRows, I = 1;
                            break;
                        case "blindCurtainBottomLeft":
                            R = 0 == e.slicedRows ? e.rows : e.slicedRows, I = 1;
                            break;
                        case "blindCurtainBottomRight":
                            R = 0 == e.slicedRows ? e.rows : e.slicedRows, I = 1;
                            break;
                        case "blindCurtainSliceTop":
                            R = 0 == e.slicedRows ? e.rows : e.slicedRows, I = 1;
                            break;
                        case "blindCurtainSliceBottom":
                            R = 0 == e.slicedRows ? e.rows : e.slicedRows, I = 1;
                            break;
                        case "stampede":
                            M = "-" + T;
                            break;
                        case "mosaic":
                            M = e.gridDifference;
                            break;
                        case "mosaicReverse":
                            M = e.gridDifference;
                            break;
                        case "mosaicRandom":
                            break;
                        case "mosaicSpiral":
                            M = e.gridDifference, D = 1.7;
                            break;
                        case "mosaicSpiralReverse":
                            M = e.gridDifference, D = 1.7;
                            break;
                        case "topLeftBottomRight":
                            M = e.gridDifference, D = 6;
                            break;
                        case "bottomRightTopLeft":
                            M = e.gridDifference, D = 6;
                            break;
                        case "bottomLeftTopRight":
                            M = e.gridDifference, D = 6;
                            break;
                        case "topRightBottomLeft":
                            M = e.gridDifference, D = 6;
                            break;
                        case "scrollLeft":
                            I = 1, R = 1;
                            break;
                        case "scrollRight":
                            I = 1, R = 1;
                            break;
                        case "scrollTop":
                            I = 1, R = 1;
                            break;
                        case "scrollBottom":
                            I = 1, R = 1;
                            break;
                        case "scrollHorz":
                            I = 1, R = 1
                    }
                    for (var V, K, J = 0, ot = R * I, nt = g - Math.floor(g / I) * I, st = v - Math.floor(v / R) * R, at = 0, rt = 0, lt = new Array, ht = new Array, ct = new Array; ot > J;) {
                        lt.push(J), ht.push(J), A.append('<div class="cameraappended" style="display:none; overflow:hidden; position:absolute; z-index:1000" />');
                        var dt = t(".cameraappended:eq(" + J + ")", b);
                        "scrollLeft" == L || "scrollRight" == L || "scrollTop" == L || "scrollBottom" == L || "scrollHorz" == L ? Q.eq(d).clone().show().appendTo(dt) : "next" == B ? Q.eq(d).clone().show().appendTo(dt) : Q.eq(n).clone().show().appendTo(dt), V = nt > J % I ? 1 : 0, J % I == 0 && (at = 0), K = Math.floor(J / I) < st ? 1 : 0, dt.css({
                            height: Math.floor(v / R + K + 1),
                            left: at,
                            top: rt,
                            width: Math.floor(g / I + V + 1)
                        }), t("> .cameraSlide", dt).css({
                            height: v,
                            "margin-left": "-" + at + "px",
                            "margin-top": "-" + rt + "px",
                            width: g
                        }), at = at + dt.width() - 1, J % I == I - 1 && (rt = rt + dt.height() - 1), J++
                    }
                    switch (L) {
                        case "curtainTopLeft":
                            break;
                        case "curtainBottomLeft":
                            break;
                        case "curtainSliceLeft":
                            break;
                        case "curtainTopRight":
                            lt = lt.reverse();
                            break;
                        case "curtainBottomRight":
                            lt = lt.reverse();
                            break;
                        case "curtainSliceRight":
                            lt = lt.reverse();
                            break;
                        case "blindCurtainTopLeft":
                            break;
                        case "blindCurtainBottomLeft":
                            lt = lt.reverse();
                            break;
                        case "blindCurtainSliceTop":
                            break;
                        case "blindCurtainTopRight":
                            break;
                        case "blindCurtainBottomRight":
                            lt = lt.reverse();
                            break;
                        case "blindCurtainSliceBottom":
                            lt = lt.reverse();
                            break;
                        case "stampede":
                            lt = r(lt);
                            break;
                        case "mosaic":
                            break;
                        case "mosaicReverse":
                            lt = lt.reverse();
                            break;
                        case "mosaicRandom":
                            lt = r(lt);
                            break;
                        case "mosaicSpiral":
                            var pt, ut, mt, ft = R / 2,
                                gt = 0;
                            for (mt = 0; ft > mt; mt++) {
                                for (ut = mt, pt = mt; I - mt - 1 > pt; pt++) ct[gt++] = ut * I + pt;
                                for (pt = I - mt - 1, ut = mt; R - mt - 1 > ut; ut++) ct[gt++] = ut * I + pt;
                                for (ut = R - mt - 1, pt = I - mt - 1; pt > mt; pt--) ct[gt++] = ut * I + pt;
                                for (pt = mt, ut = R - mt - 1; ut > mt; ut--) ct[gt++] = ut * I + pt
                            }
                            lt = ct;
                            break;
                        case "mosaicSpiralReverse":
                            var pt, ut, mt, ft = R / 2,
                                gt = ot - 1;
                            for (mt = 0; ft > mt; mt++) {
                                for (ut = mt, pt = mt; I - mt - 1 > pt; pt++) ct[gt--] = ut * I + pt;
                                for (pt = I - mt - 1, ut = mt; R - mt - 1 > ut; ut++) ct[gt--] = ut * I + pt;
                                for (ut = R - mt - 1, pt = I - mt - 1; pt > mt; pt--) ct[gt--] = ut * I + pt;
                                for (pt = mt, ut = R - mt - 1; ut > mt; ut--) ct[gt--] = ut * I + pt
                            }
                            lt = ct;
                            break;
                        case "topLeftBottomRight":
                            for (var ut = 0; R > ut; ut++)
                                for (var pt = 0; I > pt; pt++) ct.push(pt + ut);
                            ht = ct;
                            break;
                        case "bottomRightTopLeft":
                            for (var ut = 0; R > ut; ut++)
                                for (var pt = 0; I > pt; pt++) ct.push(pt + ut);
                            ht = ct.reverse();
                            break;
                        case "bottomLeftTopRight":
                            for (var ut = R; ut > 0; ut--)
                                for (var pt = 0; I > pt; pt++) ct.push(pt + ut);
                            ht = ct;
                            break;
                        case "topRightBottomLeft":
                            for (var ut = 0; R > ut; ut++)
                                for (var pt = I; pt > 0; pt--) ct.push(pt + ut);
                            ht = ct
                    }
                    t.each(lt, function(i, o) {
                        function s() {
                            if (t(this).addClass("cameraeased"), t(".cameraeased", b).length >= 0 && t($).css({
                                    visibility: "visible"
                                }), t(".cameraeased", b).length == ot) {
                                l(), t(".moveFromLeft, .moveFromRight, .moveFromTop, .moveFromBottom, .fadeIn, .fadeFromLeft, .fadeFromRight, .fadeFromTop, .fadeFromBottom", u).each(function() {
                                    t(this).css("visibility", "hidden")
                                }), Q.eq(d).show().css("z-index", "999").removeClass("cameranext").addClass("cameracurrent"), Q.eq(n).css("z-index", "1").removeClass("cameracurrent"), t(".cameraContent", u).eq(d).addClass("cameracurrent"), n >= 0 && t(".cameraContent", u).eq(n).removeClass("cameracurrent"), e.onEndTransition.call(this), "hide" != t("> div", y).eq(d).attr("data-video") && t(".cameraContent.cameracurrent .imgFake", u).length && t(".cameraContent.cameracurrent .imgFake", u).click();
                                var i = Q.eq(d).find(".fadeIn").length,
                                    o = t(".cameraContent", u).eq(d).find(".moveFromLeft, .moveFromRight, .moveFromTop, .moveFromBottom, .fadeIn, .fadeFromLeft, .fadeFromRight, .fadeFromTop, .fadeFromBottom").length;
                                0 != i && t(".cameraSlide.cameracurrent .fadeIn", u).each(function() {
                                    if ("" != t(this).attr("data-easing")) var e = t(this).attr("data-easing");
                                    else var e = E;
                                    var o = t(this);
                                    if ("undefined" == typeof o.attr("data-outerWidth") || o.attr("data-outerWidth") === !1 || "" === o.attr("data-outerWidth")) {
                                        var n = o.outerWidth();
                                        o.attr("data-outerWidth", n)
                                    } else var n = o.attr("data-outerWidth");
                                    if ("undefined" == typeof o.attr("data-outerHeight") || o.attr("data-outerHeight") === !1 || "" === o.attr("data-outerHeight")) {
                                        var s = o.outerHeight();
                                        o.attr("data-outerHeight", s)
                                    } else var s = o.attr("data-outerHeight");
                                    var a = o.position(),
                                        r = (a.left, a.top, o.attr("class")),
                                        l = o.index();
                                    o.parents(".camerarelative").outerHeight(), o.parents(".camerarelative").outerWidth(); - 1 != r.indexOf("fadeIn") ? o.animate({
                                        opacity: 0
                                    }, 0).css("visibility", "visible").delay(k / i * (.1 * (l - 1))).animate({
                                        opacity: 1
                                    }, k / i * .15, e) : o.css("visibility", "visible")
                                }), t(".cameraContent.cameracurrent", u).show(), 0 != o && t(".cameraContent.cameracurrent .moveFromLeft, .cameraContent.cameracurrent .moveFromRight, .cameraContent.cameracurrent .moveFromTop, .cameraContent.cameracurrent .moveFromBottom, .cameraContent.cameracurrent .fadeIn, .cameraContent.cameracurrent .fadeFromLeft, .cameraContent.cameracurrent .fadeFromRight, .cameraContent.cameracurrent .fadeFromTop, .cameraContent.cameracurrent .fadeFromBottom", u).each(function() {
                                    if ("" != t(this).attr("data-easing")) var e = t(this).attr("data-easing");
                                    else var e = E;
                                    var i = t(this),
                                        n = i.position(),
                                        s = (n.left, n.top, i.attr("class")),
                                        a = i.index(),
                                        r = i.outerHeight(); - 1 != s.indexOf("moveFromLeft") ? (i.css({
                                        left: "-" + g + "px",
                                        right: "auto"
                                    }), i.css("visibility", "visible").delay(k / o * (.1 * (a - 1))).animate({
                                        left: n.left
                                    }, k / o * .15, e)) : -1 != s.indexOf("moveFromRight") ? (i.css({
                                        left: g + "px",
                                        right: "auto"
                                    }), i.css("visibility", "visible").delay(k / o * (.1 * (a - 1))).animate({
                                        left: n.left
                                    }, k / o * .15, e)) : -1 != s.indexOf("moveFromTop") ? (i.css({
                                        top: "-" + v + "px",
                                        bottom: "auto"
                                    }), i.css("visibility", "visible").delay(k / o * (.1 * (a - 1))).animate({
                                        top: n.top
                                    }, k / o * .15, e, function() {
                                        i.css({
                                            top: "auto",
                                            bottom: 0
                                        })
                                    })) : -1 != s.indexOf("moveFromBottom") ? (i.css({
                                        top: v + "px",
                                        bottom: "auto"
                                    }), i.css("visibility", "visible").delay(k / o * (.1 * (a - 1))).animate({
                                        top: n.top
                                    }, k / o * .15, e)) : -1 != s.indexOf("fadeFromLeft") ? (i.animate({
                                        opacity: 0
                                    }, 0).css({
                                        left: "-" + g + "px",
                                        right: "auto"
                                    }), i.css("visibility", "visible").delay(k / o * (.1 * (a - 1))).animate({
                                        left: n.left,
                                        opacity: 1
                                    }, k / o * .15, e)) : -1 != s.indexOf("fadeFromRight") ? (i.animate({
                                        opacity: 0
                                    }, 0).css({
                                        left: g + "px",
                                        right: "auto"
                                    }), i.css("visibility", "visible").delay(k / o * (.1 * (a - 1))).animate({
                                        left: n.left,
                                        opacity: 1
                                    }, k / o * .15, e)) : -1 != s.indexOf("fadeFromTop") ? (i.animate({
                                        opacity: 0
                                    }, 0).css({
                                        top: "-" + v + "px",
                                        bottom: "auto"
                                    }), i.css("visibility", "visible").delay(k / o * (.1 * (a - 1))).animate({
                                        top: n.top,
                                        opacity: 1
                                    }, k / o * .15, e, function() {
                                        i.css({
                                            top: "auto",
                                            bottom: 0
                                        })
                                    })) : -1 != s.indexOf("fadeFromBottom") ? (i.animate({
                                        opacity: 0
                                    }, 0).css({
                                        bottom: "-" + r + "px"
                                    }), i.css("visibility", "visible").delay(k / o * (.1 * (a - 1))).animate({
                                        bottom: "0",
                                        opacity: 1
                                    }, k / o * .15, e)) : -1 != s.indexOf("fadeIn") ? i.animate({
                                        opacity: 0
                                    }, 0).css("visibility", "visible").delay(k / o * (.1 * (a - 1))).animate({
                                        opacity: 1
                                    }, k / o * .15, e) : i.css("visibility", "visible")
                                }), t(".cameraappended", b).remove(), y.removeClass("camerasliding"), Q.eq(n).hide();
                                var s, r = t(".camera_bar_cont", G).width(),
                                    p = t(".camera_bar_cont", G).height();
                                s = "pie" != f ? .05 : .005, t("#" + w).animate({
                                    opacity: e.loaderOpacity
                                }, 200), N = setInterval(function() {
                                    if (y.hasClass("stopped") && clearInterval(N), "pie" != f) switch (1.002 >= tt && !y.hasClass("stopped") && !y.hasClass("paused") && !y.hasClass("hovered") ? tt += s : 1 >= tt && (y.hasClass("stopped") || y.hasClass("paused") || y.hasClass("stopped") || y.hasClass("hovered")) ? tt = tt : y.hasClass("stopped") || y.hasClass("paused") || y.hasClass("hovered") || (clearInterval(N), a(), t("#" + w).animate({
                                        opacity: 0
                                    }, 200, function() {
                                        clearTimeout(q), q = setTimeout(h, m), c(), e.onStartLoading.call(this)
                                    })), U) {
                                        case "leftToRight":
                                            t("#" + w).animate({
                                                right: r - r * tt
                                            }, k * s, "linear");
                                            break;
                                        case "rightToLeft":
                                            t("#" + w).animate({
                                                left: r - r * tt
                                            }, k * s, "linear");
                                            break;
                                        case "topToBottom":
                                            t("#" + w).animate({
                                                bottom: p - p * tt
                                            }, k * s, "linear");
                                            break;
                                        case "bottomToTop":
                                            t("#" + w).animate({
                                                bottom: p - p * tt
                                            }, k * s, "linear")
                                    } else et = tt, it.clearRect(0, 0, e.pieDiameter, e.pieDiameter), it.globalCompositeOperation = "destination-over", it.beginPath(), it.arc(e.pieDiameter / 2, e.pieDiameter / 2, e.pieDiameter / 2 - e.loaderStroke, 0, 2 * Math.PI, !1), it.lineWidth = e.loaderStroke, it.strokeStyle = e.loaderBgColor, it.stroke(), it.closePath(), it.globalCompositeOperation = "source-over", it.beginPath(), it.arc(e.pieDiameter / 2, e.pieDiameter / 2, e.pieDiameter / 2 - e.loaderStroke, 0, 2 * Math.PI * et, !1), it.lineWidth = e.loaderStroke - 2 * e.loaderPadding, it.strokeStyle = e.loaderColor, it.stroke(), it.closePath(), 1.002 >= tt && !y.hasClass("stopped") && !y.hasClass("paused") && !y.hasClass("hovered") ? tt += s : 1 >= tt && (y.hasClass("stopped") || y.hasClass("paused") || y.hasClass("hovered")) ? tt = tt : y.hasClass("stopped") || y.hasClass("paused") || y.hasClass("hovered") || (clearInterval(N), a(), t("#" + w + ", .camera_canvas_wrap", G).animate({
                                        opacity: 0
                                    }, 200, function() {
                                        clearTimeout(q), q = setTimeout(h, m), c(), e.onStartLoading.call(this)
                                    }))
                                }, k * s)
                            }
                        }
                        switch (V = nt > o % I ? 1 : 0, o % I == 0 && (at = 0), K = Math.floor(o / I) < st ? 1 : 0, L) {
                            case "simpleFade":
                                height = v, width = g, opacityOnGrid = 0;
                                break;
                            case "curtainTopLeft":
                                height = 0, width = Math.floor(g / I + V + 1), marginTop = "-" + Math.floor(v / R + K + 1) + "px";
                                break;
                            case "curtainTopRight":
                                height = 0, width = Math.floor(g / I + V + 1), marginTop = "-" + Math.floor(v / R + K + 1) + "px";
                                break;
                            case "curtainBottomLeft":
                                height = 0, width = Math.floor(g / I + V + 1), marginTop = Math.floor(v / R + K + 1) + "px";
                                break;
                            case "curtainBottomRight":
                                height = 0, width = Math.floor(g / I + V + 1), marginTop = Math.floor(v / R + K + 1) + "px";
                                break;
                            case "curtainSliceLeft":
                                height = 0, width = Math.floor(g / I + V + 1), o % 2 == 0 ? marginTop = Math.floor(v / R + K + 1) + "px" : marginTop = "-" + Math.floor(v / R + K + 1) + "px";
                                break;
                            case "curtainSliceRight":
                                height = 0, width = Math.floor(g / I + V + 1), o % 2 == 0 ? marginTop = Math.floor(v / R + K + 1) + "px" : marginTop = "-" + Math.floor(v / R + K + 1) + "px";
                                break;
                            case "blindCurtainTopLeft":
                                height = Math.floor(v / R + K + 1), width = 0, marginLeft = "-" + Math.floor(g / I + V + 1) + "px";
                                break;
                            case "blindCurtainTopRight":
                                height = Math.floor(v / R + K + 1), width = 0, marginLeft = Math.floor(g / I + V + 1) + "px";
                                break;
                            case "blindCurtainBottomLeft":
                                height = Math.floor(v / R + K + 1), width = 0, marginLeft = "-" + Math.floor(g / I + V + 1) + "px";
                                break;
                            case "blindCurtainBottomRight":
                                height = Math.floor(v / R + K + 1), width = 0, marginLeft = Math.floor(g / I + V + 1) + "px";
                                break;
                            case "blindCurtainSliceBottom":
                                height = Math.floor(v / R + K + 1), width = 0, o % 2 == 0 ? marginLeft = "-" + Math.floor(g / I + V + 1) + "px" : marginLeft = Math.floor(g / I + V + 1) + "px";
                                break;
                            case "blindCurtainSliceTop":
                                height = Math.floor(v / R + K + 1), width = 0, o % 2 == 0 ? marginLeft = "-" + Math.floor(g / I + V + 1) + "px" : marginLeft = Math.floor(g / I + V + 1) + "px";
                                break;
                            case "stampede":
                                height = 0, width = 0, marginLeft = .2 * g * (i % I - (I - Math.floor(I / 2))) + "px", marginTop = .2 * v * (Math.floor(i / I) + 1 - (R - Math.floor(R / 2))) + "px";
                                break;
                            case "mosaic":
                                height = 0, width = 0;
                                break;
                            case "mosaicReverse":
                                height = 0, width = 0, marginLeft = Math.floor(g / I + V + 1) + "px", marginTop = Math.floor(v / R + K + 1) + "px";
                                break;
                            case "mosaicRandom":
                                height = 0, width = 0, marginLeft = .5 * Math.floor(g / I + V + 1) + "px", marginTop = .5 * Math.floor(v / R + K + 1) + "px";
                                break;
                            case "mosaicSpiral":
                                height = 0, width = 0, marginLeft = .5 * Math.floor(g / I + V + 1) + "px", marginTop = .5 * Math.floor(v / R + K + 1) + "px";
                                break;
                            case "mosaicSpiralReverse":
                                height = 0, width = 0, marginLeft = .5 * Math.floor(g / I + V + 1) + "px", marginTop = .5 * Math.floor(v / R + K + 1) + "px";
                                break;
                            case "topLeftBottomRight":
                                height = 0, width = 0;
                                break;
                            case "bottomRightTopLeft":
                                height = 0, width = 0, marginLeft = Math.floor(g / I + V + 1) + "px", marginTop = Math.floor(v / R + K + 1) + "px";
                                break;
                            case "bottomLeftTopRight":
                                height = 0, width = 0, marginLeft = 0, marginTop = Math.floor(v / R + K + 1) + "px";
                                break;
                            case "topRightBottomLeft":
                                height = 0, width = 0, marginLeft = Math.floor(g / I + V + 1) + "px", marginTop = 0;
                                break;
                            case "scrollRight":
                                height = v, width = g, marginLeft = -g;
                                break;
                            case "scrollLeft":
                                height = v, width = g, marginLeft = g;
                                break;
                            case "scrollTop":
                                height = v, width = g, marginTop = v;
                                break;
                            case "scrollBottom":
                                height = v, width = g, marginTop = -v;
                                break;
                            case "scrollHorz":
                                height = v, width = g, 0 == n && d == P - 1 ? marginLeft = -g : d > n || n == P - 1 && 0 == d ? marginLeft = g : marginLeft = -g
                        }
                        var r = t(".cameraappended:eq(" + o + ")", b);
                        "undefined" != typeof N && (clearInterval(N), clearTimeout(q), q = setTimeout(h, T + M)), t(S).length && (t(".camera_pag li", p).removeClass("cameracurrent"), t(".camera_pag li", p).eq(d).addClass("cameracurrent")), t($).length && (t("li", $).removeClass("cameracurrent"), t("li", $).eq(d).addClass("cameracurrent"), t("li", $).not(".cameracurrent").find("img").animate({
                            opacity: .5
                        }, 0), t("li.cameracurrent img", $).animate({
                            opacity: 1
                        }, 0), t("li", $).hover(function() {
                            t("img", this).stop(!0, !1).animate({
                                opacity: 1
                            }, 150)
                        }, function() {
                            t(this).hasClass("cameracurrent") || t("img", this).stop(!0, !1).animate({
                                opacity: .5
                            }, 150)
                        }));
                        var m = parseFloat(T) + parseFloat(M);
                        "scrollLeft" == L || "scrollRight" == L || "scrollTop" == L || "scrollBottom" == L || "scrollHorz" == L ? (e.onStartTransition.call(this), m = 0, r.delay((T + M) / ot * ht[i] * D * .5).css({
                            display: "block",
                            height: height,
                            "margin-left": marginLeft,
                            "margin-top": marginTop,
                            width: width
                        }).animate({
                            height: Math.floor(v / R + K + 1),
                            "margin-top": 0,
                            "margin-left": 0,
                            width: Math.floor(g / I + V + 1)
                        }, T - M, E, s), Q.eq(n).delay((T + M) / ot * ht[i] * D * .5).animate({
                            "margin-left": -1 * marginLeft,
                            "margin-top": -1 * marginTop
                        }, T - M, E, function() {
                            t(this).css({
                                "margin-top": 0,
                                "margin-left": 0
                            })
                        })) : (e.onStartTransition.call(this), m = parseFloat(T) + parseFloat(M), "next" == B ? r.delay((T + M) / ot * ht[i] * D * .5).css({
                            display: "block",
                            height: height,
                            "margin-left": marginLeft,
                            "margin-top": marginTop,
                            width: width,
                            opacity: opacityOnGrid
                        }).animate({
                            height: Math.floor(v / R + K + 1),
                            "margin-top": 0,
                            "margin-left": 0,
                            opacity: 1,
                            width: Math.floor(g / I + V + 1)
                        }, T - M, E, s) : (Q.eq(d).show().css("z-index", "999").addClass("cameracurrent"), Q.eq(n).css("z-index", "1").removeClass("cameracurrent"), t(".cameraContent", u).eq(d).addClass("cameracurrent"), t(".cameraContent", u).eq(n).removeClass("cameracurrent"), r.delay((T + M) / ot * ht[i] * D * .5).css({
                            display: "block",
                            height: Math.floor(v / R + K + 1),
                            "margin-top": 0,
                            "margin-left": 0,
                            opacity: 1,
                            width: Math.floor(g / I + V + 1)
                        }).animate({
                            height: height,
                            "margin-left": marginLeft,
                            "margin-top": marginTop,
                            width: width,
                            opacity: opacityOnGrid
                        }, T - M, E, s)))
                    })
                } else {
                    var vt = W[d],
                        wt = new Image;
                    wt.src = vt + "?" + (new Date).getTime(), m.css("visibility", "hidden"), m.prepend(t(wt).attr("class", "imgLoaded").css("visibility", "hidden"));
                    var yt, bt;
                    t(wt).get(0).complete && "0" != yt && "0" != bt && "undefined" != typeof yt && yt !== !1 && "undefined" != typeof bt && bt !== !1 || (t(".camera_loader", p).delay(500).fadeIn(400), wt.onload = function() {
                        yt = wt.naturalWidth, bt = wt.naturalHeight, t(wt).attr("data-alignment", H[d]).attr("data-portrait", O[d]), t(wt).attr("width", yt), t(wt).attr("height", bt), b.find(".cameraSlide_" + d).hide().css("visibility", "visible"), s(), c(d + 1)
                    })
                }
            }
            var d = {
                alignment: "center",
                autoAdvance: !0,
                mobileAutoAdvance: !0,
                barDirection: "leftToRight",
                barPosition: "bottom",
                cols: 6,
                easing: "easeInOutExpo",
                mobileEasing: "",
                fx: "random",
                mobileFx: "",
                gridDifference: 250,
                height: "50%",
                imagePath: "images/",
                hover: !0,
                loader: "pie",
                loaderColor: "#eeeeee",
                loaderBgColor: "#222222",
                loaderOpacity: .8,
                loaderPadding: 2,
                loaderStroke: 7,
                minHeight: "200px",
                navigation: !0,
                navigationHover: !0,
                mobileNavHover: !0,
                opacityOnGrid: !1,
                overlayer: !0,
                pagination: !0,
                playPause: !0,
                pauseOnClick: !0,
                pieDiameter: 38,
                piePosition: "rightTop",
                portrait: !1,
                rows: 4,
                slicedCols: 12,
                slicedRows: 8,
                slideOn: "random",
                thumbnails: !1,
                time: 7e3,
                transPeriod: 1500,
                onEndTransition: function() {},
                onLoaded: function() {},
                onStartLoading: function() {},
                onStartTransition: function() {}
            };
            t.support.borderRadius = !1, t.each(["borderRadius", "BorderRadius", "MozBorderRadius", "WebkitBorderRadius", "OBorderRadius", "KhtmlBorderRadius"], function() {
                void 0 !== document.body.style[this] && (t.support.borderRadius = !0)
            });
            var e = t.extend({}, d, e),
                p = t(this).addClass("camera_wrap");
            p.wrapInner('<div class="camera_src" />').wrapInner('<div class="camera_fakehover" />');
            var u = t(".camera_fakehover", p),
                m = p;
            u.append('<div class="camera_target"></div>'), 1 == e.overlayer && u.append('<div class="camera_overlayer"></div>'), u.append('<div class="camera_target_content"></div>');
            var f;
            f = "pie" != e.loader || t.support.borderRadius ? e.loader : "bar", "pie" == f ? u.append('<div class="camera_pie"></div>') : "bar" == f ? u.append('<div class="camera_bar"></div>') : u.append('<div class="camera_bar" style="display:none"></div>'), 1 == e.playPause && u.append('<div class="camera_commands"></div>'), 1 == e.navigation && u.append('<div class="camera_prev"><span></span></div>').append('<div class="camera_next"><span></span></div>'), 1 == e.thumbnails && p.append('<div class="camera_thumbs_cont" />'), 1 == e.thumbnails && 1 != e.pagination && t(".camera_thumbs_cont", p).wrap("<div />").wrap('<div class="camera_thumbs" />').wrap("<div />").wrap('<div class="camera_command_wrap" />'), 1 == e.pagination && p.append('<div class="camera_pag"></div>'), p.append('<div class="camera_loader"></div>'), t(".camera_caption", p).each(function() {
                t(this).wrapInner("<div />")
            });
            var g, v, w = "pie_" + p.index(),
                y = t(".camera_src", p),
                b = t(".camera_target", p),
                x = t(".camera_target_content", p),
                z = t(".camera_pie", p),
                _ = t(".camera_bar", p),
                C = t(".camera_prev", p),
                k = t(".camera_next", p),
                T = t(".camera_commands", p),
                S = t(".camera_pag", p),
                $ = t(".camera_thumbs_cont", p),
                W = new Array;
            t("> div", y).each(function() {
                W.push(t(this).attr("data-src"))
            });
            var L = new Array;
            t("> div", y).each(function() {
                t(this).attr("data-link") ? L.push(t(this).attr("data-link")) : L.push("")
            });
            var E = new Array;
            t("> div", y).each(function() {
                t(this).attr("data-target") ? E.push(t(this).attr("data-target")) : E.push("")
            });
            var O = new Array;
            t("> div", y).each(function() {
                t(this).attr("data-portrait") ? O.push(t(this).attr("data-portrait")) : O.push("")
            });
            var H = new Array;
            t("> div", y).each(function() {
                t(this).attr("data-alignment") ? H.push(t(this).attr("data-alignment")) : H.push("")
            });
            var R = new Array;
            t("> div", y).each(function() {
                t(this).attr("data-thumb") ? R.push(t(this).attr("data-thumb")) : R.push("")
            });
            var P = W.length;
            t(x).append('<div class="cameraContents" />');
            var I;
            for (I = 0; P > I; I++)
                if (t(".cameraContents", x).append('<div class="cameraContent" />'), "" != L[I]) {
                    var D = t("> div ", y).eq(I).attr("data-box");
                    D = "undefined" != typeof D && D !== !1 && "" != D ? 'data-box="' + t("> div ", y).eq(I).attr("data-box") + '"' : "", t(".camera_target_content .cameraContent:eq(" + I + ")", p).append('<a class="camera_link" href="' + L[I] + '" ' + D + ' target="' + E[I] + '"></a>')
                }
            t(".camera_caption", p).each(function() {
                var e = t(this).parent().index(),
                    i = p.find(".cameraContent").eq(e);
                t(this).appendTo(i)
            }), b.append('<div class="cameraCont" />');
            var M, A = t(".cameraCont", p);
            for (M = 0; P > M; M++) {
                A.append('<div class="cameraSlide cameraSlide_' + M + '" />');
                var F = t("> div:eq(" + M + ")", y);
                b.find(".cameraSlide_" + M).clone(F)
            }
            t(window).bind("load resize pageshow", function() {
                l(), n()
            }), A.append('<div class="cameraSlide cameraSlide_' + M + '" />');
            var j;
            p.show();
            var B, g = b.width(),
                v = b.height();
            t(window).bind("resize pageshow", function() {
                1 == j && s(), t("ul", $).animate({
                    "margin-top": 0
                }, 0, l), y.hasClass("paused") || (y.addClass("paused"), t(".camera_stop", G).length ? (t(".camera_stop", G).hide(), t(".camera_play", G).show(), "none" != f && t("#" + w).hide()) : "none" != f && t("#" + w).hide(), clearTimeout(B), B = setTimeout(function() {
                    y.removeClass("paused"), t(".camera_play", G).length ? (t(".camera_play", G).hide(), t(".camera_stop", G).show(), "none" != f && t("#" + w).fadeIn()) : "none" != f && t("#" + w).fadeIn()
                }, 1500))
            });
            var N, q, Z, X, T, S, V, Y;
            if (Z = o() && "" != e.mobileAutoAdvance ? e.mobileAutoAdvance : e.autoAdvance, 0 == Z && y.addClass("paused"), X = o() && "" != e.mobileNavHover ? e.mobileNavHover : e.navigationHover, 0 != y.length) {
                var Q = t(".cameraSlide", b);
                Q.wrapInner('<div class="camerarelative" />');
                var U = e.barDirection,
                    G = p;
                t("iframe", u).each(function() {
                    var e = t(this),
                        i = e.attr("src");
                    e.attr("data-src", i);
                    var o = e.parent().index(".camera_src > div");
                    t(".camera_target_content .cameraContent:eq(" + o + ")", p).append(e)
                }), a(), 1 == e.hover && (o() || u.hover(function() {
                    y.addClass("hovered")
                }, function() {
                    y.removeClass("hovered")
                })), 1 == X && (t(C, p).animate({
                    opacity: 0
                }, 0), t(k, p).animate({
                    opacity: 0
                }, 0), t(T, p).animate({
                    opacity: 0
                }, 0), o() ? (t(document).on("vmouseover", m, function() {
                    t(C, p).animate({
                        opacity: 1
                    }, 200), t(k, p).animate({
                        opacity: 1
                    }, 200), t(T, p).animate({
                        opacity: 1
                    }, 200)
                }), t(document).on("vmouseout", m, function() {
                    t(C, p).delay(500).animate({
                        opacity: 0
                    }, 200), t(k, p).delay(500).animate({
                        opacity: 0
                    }, 200), t(T, p).delay(500).animate({
                        opacity: 0
                    }, 200)
                })) : u.hover(function() {
                    t(C, p).animate({
                        opacity: 1
                    }, 200), t(k, p).animate({
                        opacity: 1
                    }, 200), t(T, p).animate({
                        opacity: 1
                    }, 200)
                }, function() {
                    t(C, p).animate({
                        opacity: 0
                    }, 200), t(k, p).animate({
                        opacity: 0
                    }, 200), t(T, p).animate({
                        opacity: 0
                    }, 200)
                })), G.on("click", ".camera_stop", function() {
                    Z = !1, y.addClass("paused"), t(".camera_stop", G).length ? (t(".camera_stop", G).hide(), t(".camera_play", G).show(), "none" != f && t("#" + w).hide()) : "none" != f && t("#" + w).hide()
                }), G.on("click", ".camera_play", function() {
                    Z = !0, y.removeClass("paused"), t(".camera_play", G).length ? (t(".camera_play", G).hide(), t(".camera_stop", G).show(), "none" != f && t("#" + w).show()) : "none" != f && t("#" + w).show()
                }), 1 == e.pauseOnClick && t(".camera_target_content", u).mouseup(function() {
                    Z = !1, y.addClass("paused"), t(".camera_stop", G).hide(), t(".camera_play", G).show(), t("#" + w).hide()
                }), t(".cameraContent, .imgFake", u).hover(function() {
                    V = !0
                }, function() {
                    V = !1
                }), t(".cameraContent, .imgFake", u).bind("click", function() {
                    1 == Y && 1 == V && (Z = !1, t(".camera_caption", u).hide(), y.addClass("paused"), t(".camera_stop", G).hide(), t(".camera_play", G).show(), t("#" + w).hide())
                })
            }
            if ("pie" != f) {
                _.append('<span class="camera_bar_cont" />'), t(".camera_bar_cont", _).animate({
                    opacity: e.loaderOpacity
                }, 0).css({
                    position: "absolute",
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0,
                    "background-color": e.loaderBgColor
                }).append('<span id="' + w + '" />'), t("#" + w).animate({
                    opacity: 0
                }, 0);
                var K = t("#" + w);
                switch (K.css({
                    position: "absolute",
                    "background-color": e.loaderColor
                }), e.barPosition) {
                    case "left":
                        _.css({
                            right: "auto",
                            width: e.loaderStroke
                        });
                        break;
                    case "right":
                        _.css({
                            left: "auto",
                            width: e.loaderStroke
                        });
                        break;
                    case "top":
                        _.css({
                            bottom: "auto",
                            height: e.loaderStroke
                        });
                        break;
                    case "bottom":
                        _.css({
                            top: "auto",
                            height: e.loaderStroke
                        })
                }
                switch (U) {
                    case "leftToRight":
                        K.css({
                            left: 0,
                            right: 0,
                            top: e.loaderPadding,
                            bottom: e.loaderPadding
                        });
                        break;
                    case "rightToLeft":
                        K.css({
                            left: 0,
                            right: 0,
                            top: e.loaderPadding,
                            bottom: e.loaderPadding
                        });
                        break;
                    case "topToBottom":
                        K.css({
                            left: e.loaderPadding,
                            right: e.loaderPadding,
                            top: 0,
                            bottom: 0
                        });
                        break;
                    case "bottomToTop":
                        K.css({
                            left: e.loaderPadding,
                            right: e.loaderPadding,
                            top: 0,
                            bottom: 0
                        })
                }
            } else {
                z.append('<canvas id="' + w + '"></canvas>');
                var K = document.getElementById(w);
                K.setAttribute("width", e.pieDiameter), K.setAttribute("height", e.pieDiameter);
                var J;
                switch (e.piePosition) {
                    case "leftTop":
                        J = "left:0; top:0;";
                        break;
                    case "rightTop":
                        J = "right:0; top:0;";
                        break;
                    case "leftBottom":
                        J = "left:0; bottom:0;";
                        break;
                    case "rightBottom":
                        J = "right:0; bottom:0;"
                }
                K.setAttribute("style", "position:absolute; z-index:1002; " + J);
                var tt, et;
                if (K && K.getContext) {
                    var it = K.getContext("2d");
                    it.rotate(1.5 * Math.PI), it.translate(-e.pieDiameter, 0)
                }
            }
            if (("none" == f || 0 == Z) && (t("#" + w).hide(), t(".camera_canvas_wrap", G).hide()), t(S).length) {
                t(S).append('<ul class="camera_pag_ul" />');
                var ot;
                for (ot = 0; P > ot; ot++) t(".camera_pag_ul", p).append('<li class="pag_nav_' + ot + '" style="position:relative; z-index:1002"><span><span>' + ot + "</span></span></li>");
                t(".camera_pag_ul li", p).hover(function() {
                    if (t(this).addClass("camera_hover"), t(".camera_thumb", this).length) {
                        var e = t(".camera_thumb", this).outerWidth(),
                            i = t(".camera_thumb", this).outerHeight(),
                            o = t(this).outerWidth();
                        t(".camera_thumb", this).show().css({
                            top: "-" + i + "px",
                            left: "-" + (e - o) / 2 + "px"
                        }).animate({
                            opacity: 1,
                            "margin-top": "-3px"
                        }, 200), t(".thumb_arrow", this).show().animate({
                            opacity: 1,
                            "margin-top": "-3px"
                        }, 200)
                    }
                }, function() {
                    t(this).removeClass("camera_hover"), t(".camera_thumb", this).animate({
                        "margin-top": "-20px",
                        opacity: 0
                    }, 200, function() {
                        t(this).css({
                            marginTop: "5px"
                        }).hide()
                    }), t(".thumb_arrow", this).animate({
                        "margin-top": "-20px",
                        opacity: 0
                    }, 200, function() {
                        t(this).css({
                            marginTop: "5px"
                        }).hide()
                    })
                })
            }
            if (t($).length) {
                t(S).length ? (t.each(R, function(e, i) {
                    if ("" != t("> div", y).eq(e).attr("data-thumb")) {
                        var o = t("> div", y).eq(e).attr("data-thumb"),
                            n = new Image;
                        n.src = o, t("li.pag_nav_" + e, S).append(t(n).attr("class", "camera_thumb").css({
                            position: "absolute"
                        }).animate({
                            opacity: 0
                        }, 0)), t("li.pag_nav_" + e + " > img", S).after('<div class="thumb_arrow" />'), t("li.pag_nav_" + e + " > .thumb_arrow", S).animate({
                            opacity: 0
                        }, 0)
                    }
                }), p.css({
                    marginBottom: t(S).outerHeight()
                })) : (t($).append("<div />"), t($).before('<div class="camera_prevThumbs hideNav"><div></div></div>').before('<div class="camera_nextThumbs hideNav"><div></div></div>'), t("> div", $).append("<ul />"), t.each(R, function(e, i) {
                    if ("" != t("> div", y).eq(e).attr("data-thumb")) {
                        var o = t("> div", y).eq(e).attr("data-thumb"),
                            n = new Image;
                        n.src = o, t("ul", $).append('<li class="pix_thumb pix_thumb_' + e + '" />'), t("li.pix_thumb_" + e, $).append(t(n).attr("class", "camera_thumb"))
                    }
                }))
            } else !t($).length && t(S).length && p.css({
                marginBottom: t(S).outerHeight()
            });
            var nt = !0;
            t(T).length && (t(T).append('<div class="camera_play"></div>').append('<div class="camera_stop"></div>'), 1 == Z ? (t(".camera_play", G).hide(), t(".camera_stop", G).show()) : (t(".camera_stop", G).hide(), t(".camera_play", G).show())), h(), t(".moveFromLeft, .moveFromRight, .moveFromTop, .moveFromBottom, .fadeIn, .fadeFromLeft, .fadeFromRight, .fadeFromTop, .fadeFromBottom", u).each(function() {
                t(this).css("visibility", "hidden")
            }), e.onStartLoading.call(this), c(), t(C).length && t(C).click(function() {
                if (!y.hasClass("camerasliding")) {
                    var i = parseFloat(t(".cameraSlide.cameracurrent", b).index());
                    clearInterval(N), a(), t("#" + w + ", .camera_canvas_wrap", p).animate({
                        opacity: 0
                    }, 0), h(), c(0 != i ? i : P), e.onStartLoading.call(this)
                }
            }), t(k).length && t(k).click(function() {
                if (!y.hasClass("camerasliding")) {
                    var i = parseFloat(t(".cameraSlide.cameracurrent", b).index());
                    clearInterval(N), a(), t("#" + w + ", .camera_canvas_wrap", G).animate({
                        opacity: 0
                    }, 0), h(), c(i == P - 1 ? 1 : i + 2), e.onStartLoading.call(this)
                }
            }), o() && (u.bind("swipeleft", function(i) {
                if (!y.hasClass("camerasliding")) {
                    var o = parseFloat(t(".cameraSlide.cameracurrent", b).index());
                    clearInterval(N), a(), t("#" + w + ", .camera_canvas_wrap", G).animate({
                        opacity: 0
                    }, 0), h(), c(o == P - 1 ? 1 : o + 2), e.onStartLoading.call(this)
                }
            }), u.bind("swiperight", function(i) {
                if (!y.hasClass("camerasliding")) {
                    var o = parseFloat(t(".cameraSlide.cameracurrent", b).index());
                    clearInterval(N), a(), t("#" + w + ", .camera_canvas_wrap", G).animate({
                        opacity: 0
                    }, 0), h(), c(0 != o ? o : P), e.onStartLoading.call(this)
                }
            })), t(S).length && t(".camera_pag li", p).click(function() {
                if (!y.hasClass("camerasliding")) {
                    var i = parseFloat(t(this).index()),
                        o = parseFloat(t(".cameraSlide.cameracurrent", b).index());
                    i != o && (clearInterval(N), a(), t("#" + w + ", .camera_canvas_wrap", G).animate({
                        opacity: 0
                    }, 0), h(), c(i + 1), e.onStartLoading.call(this));
                }
            }), t($).length && (t(".pix_thumb img", $).click(function() {
                if (!y.hasClass("camerasliding")) {
                    var i = parseFloat(t(this).parents("li").index()),
                        o = parseFloat(t(".cameracurrent", b).index());
                    i != o && (clearInterval(N), a(), t("#" + w + ", .camera_canvas_wrap", G).animate({
                        opacity: 0
                    }, 0), t(".pix_thumb", $).removeClass("cameracurrent"), t(this).parents("li").addClass("cameracurrent"), h(), c(i + 1), l(), e.onStartLoading.call(this))
                }
            }), t(".camera_thumbs_cont .camera_prevThumbs", G).hover(function() {
                t(this).stop(!0, !1).animate({
                    opacity: 1
                }, 250)
            }, function() {
                t(this).stop(!0, !1).animate({
                    opacity: .7
                }, 250)
            }), t(".camera_prevThumbs", G).click(function() {
                var e = 0,
                    i = (t($).outerWidth(), t("ul", $).offset().left),
                    o = t("> div", $).offset().left,
                    s = o - i;
                t(".camera_visThumb", $).each(function() {
                    var i = t(this).outerWidth();
                    e += i
                }), s - e > 0 ? t("ul", $).animate({
                    "margin-left": "-" + (s - e) + "px"
                }, 500, n) : t("ul", $).animate({
                    "margin-left": 0
                }, 500, n)
            }), t(".camera_thumbs_cont .camera_nextThumbs", G).hover(function() {
                t(this).stop(!0, !1).animate({
                    opacity: 1
                }, 250)
            }, function() {
                t(this).stop(!0, !1).animate({
                    opacity: .7
                }, 250)
            }), t(".camera_nextThumbs", G).click(function() {
                var e = 0,
                    i = t($).outerWidth(),
                    o = t("ul", $).outerWidth(),
                    s = t("ul", $).offset().left,
                    a = t("> div", $).offset().left,
                    r = a - s;
                t(".camera_visThumb", $).each(function() {
                    var i = t(this).outerWidth();
                    e += i
                }), o > r + e + e ? t("ul", $).animate({
                    "margin-left": "-" + (r + e) + "px"
                }, 500, n) : t("ul", $).animate({
                    "margin-left": "-" + (o - i) + "px"
                }, 500, n)
            }))
        }
    }(jQuery),
    function(t) {
        t.fn.cameraStop = function() {
            var e = t(this),
                i = t(".camera_src", e);
            "pie_" + e.index();
            if (i.addClass("stopped"), t(".camera_showcommands").length) {
                t(".camera_thumbs_wrap", e)
            } else;
        }
    }(jQuery),
    function(t) {
        t.fn.cameraPause = function() {
            var e = t(this),
                i = t(".camera_src", e);
            i.addClass("paused")
        }
    }(jQuery),
    function(t) {
        t.fn.cameraResume = function() {
            var e = t(this),
                i = t(".camera_src", e);
            ("undefined" == typeof autoAdv || autoAdv !== !0) && i.removeClass("paused")
        }
    }(jQuery), $(document).ready(function() {
        var t = $(".grupos").length,
            e = $("input[name='grupos[]']:checked").length;
        registro(), $("#form-tienda input[name=boletin]").click(function() {
            $(this).is(":checked") ? $("#form-tienda #temas-de-interes").removeClass("hide") : $("#form-tienda #temas-de-interes").addClass("hide")
        }), $("#form-editar input[name=pass]").click(function() {
            $(this).is(":checked") ? $("#form-editar #cambiar-contrasena").removeClass("hide") : $("#form-editar #cambiar-contrasena").addClass("hide")
        }), $("#marcarTodo").change(function() {
            $(this).is(":checked") ? $("input[type=checkbox]").prop("checked", !0) : $("input[type=checkbox]").prop("checked", !1)
        }), $("input[name=inlineRadioOptions]").change(function() {
            "option1" == $(this).val() ? $("#form-grupo .grupos-interes").removeClass("hide") : $("#form-grupo .grupos-interes").addClass("hide")
        }), $("input[name='grupos[]']:checked").each(function() {
            e == t && $("#marcarTodo").prop("checked", !0)
        }), $("#section-catalogo-button").mouseover(function() {
            $(this).css("background-color", "#85A327"), $("#section-catalogo-button a").css("color", "#ffffff"), $("#section-catalogo-button img").attr("src", $(this).attr("imgDos"))
        }), $("#camera_wrap_1").length && $("#camera_wrap_1").camera({
            fx: "simpleFade",
            loader: "none",
            playPause: !1,
            pagination: !0,
            height: "25%"
        }), $("#section-catalogo-button").mouseout(function() {
            $(this).css("background-color", "#ffffff"), $("#section-catalogo-button a").css("color", "#85A327"), $("#section-catalogo-button img").attr("src", $(this).attr("imgUno"))
        })
    }), $(document).ready(function() {
        contacto(), $("#form-contacto input[name=boletin]").click(function() {
            $(this).is(":checked") ? $("#form-contacto #temas-de-interes").removeClass("hide") : $("#form-contacto #temas-de-interes").addClass("hide")
        })
    }), $(document).ready(function() {
        contacto_inmediato()
    });
var owlFicha;
jQuery(document).ready(function(t) {
    owlFicha = t(".owl-carousel-ficha").owlCarousel({
        margin: 30,
        nav: !0,
        responsiveClass: !0,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        responsive: {
            0: {
                items: 2
            },
            490: {
                items: 3
            },
            560: {
                items: 4
            },
            1e3: {
                items: 3
            }
        }
    }), t(".combinaciones .tipo3").each(function(e) {
        t(this).find("div").eq(0).css("background-color", t(this).attr("color"))
    }), "undefined" != typeof combinaciones && combinaciones_productos(), t(".atributo").change(function(t) {
        combinaciones_productos()
    })
});
var owl, owlProductos;
jQuery(document).ready(function(t) {
    t("#suscribirse").click(function() {
        t("#mnewsletter").val("TRS6745-*1"), action = t("#formulario-newsletter").find("form").eq(0).attr("action"), t("#formulario-newsletter").load(action + " #formulario-newsletter-inner", t("#formulario-newsletter").find("form").eq(0).serializeArray())
    }), t("#suscribe_sendblaster").click(function(e) {
        e.preventDefault(), t("#mnewsletterf").val("TRS6745-*1"), t.ajax({
            url: base_url + "/boletin/newsletter/suscribe_sendblaster",
            type: "POST",
            dataType: "json",
            data: t("#boletin").serialize()
        }).done(function(t) {
            t.error && alert(t.error), t.enviado && alert(t.enviado), console.log("success")
        }).fail(function() {
            console.log("error")
        }).always(function() {
            console.log("complete")
        })
    }), owl = t(".owl-carousel").owlCarousel({
        loop: !0,
        margin: 30,
        nav: !0,
        responsiveClass: !0,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1e3: {
                items: 3
            }
        }
    }), owlProductos = t(".owl-carousel-productos").owlCarousel({
        loop: !0,
        margin: 30,
        nav: !0,
        responsiveClass: !0,
        responsive: {
            0: {
                items: 1
            },
            490: {
                items: 2
            },
            560: {
                items: 3
            },
            1e3: {
                items: 4
            }
        },
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>']
    }), owlMarcas = t(".owl-carousel-marcas").owlCarousel({
        loop: !0,
        margin: 30,
        nav: !0,
        responsiveClass: !0,
        responsive: {
            0: {
                items: 3
            },
            769: {
                items: 4
            },
            1e3: {
                items: 6
            }
        },
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>']
    }), t("#pinterest_grid").pinterest_grid({
        no_columns: 3,
        padding_x: 0,
        padding_y: 0,
        margin_bottom: 50,
        single_column_breakpoint: 700
    }), t("#pinterest_grid_categorias").pinterest_grid({
        no_columns: 3,
        padding_x: 0,
        padding_y: 0,
        margin_bottom: 50,
        single_column_breakpoint: 700
    }), t("#pinterest_grid_productos").pinterest_grid({
        no_columns: 4,
        padding_x: 0,
        padding_y: 0,
        margin_bottom: 50,
        single_column_breakpoint: 700
    }), t("a.fancy").fancybox(), t("#boton-search").click(function() {
        document.location = base_url + "buscador/" + t("#input-search").val()
    }), t("#input-search").keyup(function(e) {
        return "13" == e.keyCode && (document.location = base_url + "buscador/" + t("#input-search").val()), !1
    }), t(".menu-princial").find("li.active").eq(0).parents().addClass("active"), t("a[rel=producto]").fancybox({
        transitionIn: "none",
        transitionOut: "none",
        titlePosition: "over",
        titleFormat: function(t, e, i, o) {
            return '<span id="fancybox-title-over">Image ' + (i + 1) + " / " + e.length + " " + t + "</span>"
        }
    }), t(".categorias").click(function(e) {
        t(window).width() < 992 && t(".menu-categorias-vertical").toggle("fast")
    }), t(".fancybox-frame").fancybox({
        type: "iframe",
        width: "60%",
        height: "60%"
    }), t("#form-contacto input[name=boletin]").click(function() {
        t(this).is(":checked") ? t("#form-contacto #temas-de-interes").removeClass("hide") : t("#form-contacto #temas-de-interes").addClass("hide")
    })
}), $(document).ready(function() {
    $("#zoom_03").elevateZoom({
        gallery: "gallery_01",
        cursor: "pointer",
        galleryActiveClass: "active",
        imageCrossfade: !0,
        lensSize: 200,
        scrollZoom: !0,
        loadingIcon: "http://www.elevateweb.co.uk/spinner.gif"
    }), $("#zoom_03").bind("click", function(t) {
        var e = $("#zoom_03").data("elevateZoom");
        return e.closeAll(), $.fancybox(e.getGalleryList()), !1
    })
}), jQuery(document).ready(function(t) {
    var e = 0;
    t(".solicitar_cotizacion").click(function() {
        t("#paqueteid").val(t(this).attr("item-articulo")), t("#modal-asunto-titulo").html(t(this).attr("asunto-titulo"))
    }), t("#btn-informacion-producto").click(function() {
        return 1 == e ? !1 : (e = 1, void t.ajax({
            url: t(this).attr("href") + "/" + t("#paqueteid").val(),
            type: "POST",
            dataType: "json",
            data: {
                privacidad: t("#privacidad").serialize(),
                boletin: t("#boletin").serialize(),
                grupos: t("input[name='grupos[]']").serializeArray(),
                nombre: t("#nombre_f").val(),
                email: t("#email_f").val(),
                telefono: t("#telefono_f").val(),
                lada: t("#lada_f").val(),
                texto: t("#texto_f").val(),
                email_field_f: t("#texto_f").val(),
                mcontacto: "TRS6745-*1"
            }
        }).done(function(i) {
            e = 0, i.error && alert(i.error), i.enviado && t("#cotizacion-body").prepend('<div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <strong>Su solicitud se envio correctamente</strong> en breve nos pondremos en contacto con usted</div>')
        }))
    })
});