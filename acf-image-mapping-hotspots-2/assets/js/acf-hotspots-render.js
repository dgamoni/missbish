// "use strict";function _classCallCheck(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}var _createClass=function(){function t(t,e){for(var i=0;i<e.length;i++){var n=e[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(t,n.key,n)}}return function(e,i,n){return i&&t(e.prototype,i),n&&t(e,n),e}}(),HotspotInput=function(t){function e(t,e){return void 0===e&&(e=document),e.getElementsByClassName(t)}var i="acf-hotspot",n=function(){function n(t){_classCallCheck(this,n),this.class_point=i+"__point",this.x=t.x,this.y=t.y,this.context=t.context,this.i=this.context.points.length,this.point=this.create_point(t.x,t.y),this.tinymce_active=!1,t.exists||this.create_inputs(t.x,t.y),this.point_events()}return _createClass(n,[{key:"create_inputs",value:function(t,n){for(var s=this.context.spot_clone.cloneNode(!0),o=e(i+"__input",s),a=this.i,r=e(i+"__label",s)[0],c=0,u=o.length;c<u;c++){var h=o[c].getAttribute("data-name").replace("!!N!!",a);o[c].setAttribute("name",h)}return r.innerHTML=r.innerHTML.replace(/!!N!!/g,a+1),e(i+"__input--x",s)[0].value=t,e(i+"__input--y",s)[0].value=n,this.context.spot_clone_original.parentNode.appendChild(s),this.get_inputs_object(s)}},{key:"has_a_tinymce",value:function(){return!this.tinymce_active&&this.inputs.wrapper.getElementsByClassName("mce-tinymce").length>0&&(this.tinymce_active=!0,this.refresh_accordion(),!0)}},{key:"refresh_accordion",value:function(){var t=this;this.context.accordion_ready&&setTimeout(function(){return t.context.accordion.accordion("refresh")},10)}},{key:"reposition",value:function(t){var e=this.inputs.inputs;this.i=t,this.point.parentNode.appendChild(this.point);for(var i=0,n=e.length;i<n;i++)e[i].setAttribute("name",e[i].getAttribute("name").replace(/points]\[\d+\]\[/,"points]["+t+"]["))}},{key:"get_inputs_object",value:function(t){return this.inputs={wrapper:t,inputs:e(i+"__input",t),x:e(i+"__input--x",t)[0],y:e(i+"__input--y",t)[0]},this.handle_remove(),this.inputs}},{key:"init_tinymce",value:function(){if(!this.tinymce_active){var t=this;tinymce.init({selector:"."+this.context.id+" ."+i+"__point-fields:nth-child("+(this.i+2)+") ."+i+"__input--description",menubar:!1,statusbar:!1,height:300,setup:function(e){e.on("init",function(e){t.refresh_accordion(),setTimeout(function(){return t.is_loading(!1)},10)})}}),this.tinymce_active=!0}}},{key:"is_loading",value:function(t){var e=this.inputs.wrapper;t?e.classList.add(i+"__point-fields--loading"):e.classList.remove(i+"__point-fields--loading")}},{key:"create_point",value:function(t,e){var i=document.createElement("div");return i.classList.add(this.class_point),i.style.left=100*t+"%",i.style.top=100*e+"%",this.context.main_image.parentNode.appendChild(i),i}},{key:"update_position",value:function(t,e){this.x=t,this.y=e,this.inputs.x.value=t,this.inputs.y.value=e,this.point.style.left=100*t+"%",this.point.style.top=100*e+"%"}},{key:"handle_remove",value:function(){var t=this;if(void 0!==this.inputs.wrapper){var i=e("acf-hotspot__delete",this.inputs.wrapper)[0];i.addEventListener("click",function(e){e.preventDefault(),t.remove()})}}},{key:"remove",value:function(){if(confirm("Are you sure you would like to remove point #"+(this.i+1)+"? (this change will only persist if you save/update this post)")){var t=this.context.points;t.splice(this.i,1);for(var e=0,i=t.length;e<i;e++)t[e].reposition(e);this.point.parentNode.removeChild(this.point),this.inputs.wrapper.parentNode.removeChild(this.inputs.wrapper)}}},{key:"make_draggable",value:function(){var e=this,i=this.context.main_image;t(this.point).draggable({containment:"parent",scroll:!1,stop:function(t){var n=e.point.offsetLeft/i.offsetWidth,s=e.point.offsetTop/i.offsetHeight;e.update_position(n,s)}})}},{key:"point_events",value:function(){this.make_draggable()}}]),n}();return function(){function s(n){_classCallCheck(this,s),this.el=n,this.id=this.get_id(),this.source_image=t("."+i+"__upload .acf-image-uploader .view img",n),this.img_src="",this.main_image=e(i+"__image",this.el[0])[0],this.points=[],this.spot_clone=this.generate_spot_clone(),this.accordion_ready=!1,this.accordion=t("."+i+"__information",this.el),this.init()}return _createClass(s,[{key:"get_id",value:function(){for(var t=this.el[0].classList,e=0,i=t.length;e<i;e++)if(t[e].match(/acf-field-\d+/g))return t[e]}},{key:"add_exisiting_points",value:function(){for(var t=e(i+"__point-fields",this.el[0]),s=0,o=t.length;s<o;s++){var a=e(i+"__input--x",t[s])[0].value,r=e(i+"__input--y",t[s])[0].value,c=new n({x:a,y:r,context:this,exists:!0});c.get_inputs_object(t[s]),this.points.push(c)}}},{key:"generate_spot_clone",value:function(){for(var t=e(i+"__clone-base",this.el[0])[0],n=e(i+"__input",t),s=null,o=0,a=n.length;o<a;o++)n[o].setAttribute("data-name",n[o].getAttribute("name")),n[o].removeAttribute("name");return s=t.cloneNode(!0),this.spot_clone_original=t,s.classList.remove(i+"__clone-base"),s.classList.add(i+"__point-fields"),s}},{key:"change_hotspot_image",value:function(){this.img_src=this.source_image[0].getAttribute("src"),this.img_src=this.img_src.replace(/-\d+x\d+\./g,"."),this.main_image.setAttribute("src",this.img_src)}},{key:"watch_for_new_image",value:function(){var t=this;this.source_image.on("load error",function(){return t.change_hotspot_image()})}},{key:"listen_for_user_clicks",value:function(){var t=this;this.main_image.addEventListener("click",function(e){return t.create_hotspot_point(e.offsetX,e.offsetY)})}},{key:"create_hotspot_point",value:function(t,e){if(confirm("Are you sure you would like to create a new point?")){var i=this.main_image.offsetWidth,s=this.main_image.offsetHeight,o=new n({x:t/i,y:e/s,context:this});return this.accordion_ready&&this.accordion.accordion("refresh"),this.points.push(o)}}},{key:"sort_points",value:function(t,e){this.points.splice(e,0,this.points.splice(t,1)[0]);for(var i=0,n=this.points.length;i<n;i++)this.points[i].reposition(i)}},{key:"sortabe",value:function(){var t=this,e=-1;this.accordion.accordion({collapsible:!0,header:"."+i+"__label",beforeActivate:function(e,i){if(void 0!==i.newHeader[0]){var n=t.points[i.newHeader.parent().index()-1];n.tinymce_active||n.has_a_tinymce()||n.is_loading(!0),setTimeout(function(){return n.init_tinymce()},10)}},create:function(){t.accordion_ready=!0}}).sortable({handle:"."+i+"__label",start:function(t,i){e=i.item.index()},beforeStop:function(i,n){e!==n.item.index()&&t.sort_points(e-1,n.item.index()-1),e=-1}})}},{key:"init",value:function(){this.watch_for_new_image(),this.change_hotspot_image(),this.listen_for_user_clicks(),this.add_exisiting_points(),this.sortabe()}}]),s}()}(jQuery);
// "use strict";!function(t){"undefined"!=typeof acf.add_action?acf.add_action("ready append",function(n){acf.get_fields({type:"hotspots"},n).each(function(){new HotspotInput(t(this))})}):t(document).on("acf/setup_fields",function(n,e){t(e).find('.field[data-field_type="hotspots"]').each(function(){new HotspotInput(t(this))})})}(jQuery);
// //# sourceMappingURL=acf-hotspots-render.js.map

"use strict";

function _classCallCheck(t, e) {
    if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
}
var _createClass = function() {
        function t(t, e) {
            for (var i = 0; i < e.length; i++) {
                var n = e[i];
                n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(t, n.key, n)
            }
        }
        return function(e, i, n) {
            return i && t(e.prototype, i), n && t(e, n), e
        }
    }(),
    HotspotInput = function(t) {
        function e(t, e) {
            return void 0 === e && (e = document), e.getElementsByClassName(t)
        }
        var i = "acf-hotspot",
            n = function() {
                function n(t) {
                    _classCallCheck(this, n), this.class_point = i + "__point", this.x = t.x, this.y = t.y, this.context = t.context, this.i = this.context.points.length, this.point = this.create_point(t.x, t.y), this.tinymce_active = !1, t.exists || this.create_inputs(t.x, t.y), this.point_events()
                }
                return _createClass(n, [{
                    key: "create_inputs",
                    value: function(t, n) {
                        for (var s = this.context.spot_clone.cloneNode(!0), o = e(i + "__input", s), a = this.i, r = e(i + "__label", s)[0], c = 0, u = o.length; c < u; c++) {
                            var h = o[c].getAttribute("data-name").replace("!!N!!", a);
                            o[c].setAttribute("name", h)
                        }
                        return r.innerHTML = r.innerHTML.replace(/!!N!!/g, a + 1), e(i + "__input--x", s)[0].value = t, e(i + "__input--y", s)[0].value = n, this.context.spot_clone_original.parentNode.appendChild(s), this.get_inputs_object(s)
                    }
                }, {
                    key: "has_a_tinymce",
                    value: function() {
                        return !this.tinymce_active && this.inputs.wrapper.getElementsByClassName("mce-tinymce").length > 0 && (this.tinymce_active = !0, this.refresh_accordion(), !0)
                    }
                }, {
                    key: "refresh_accordion",
                    value: function() {
                        var t = this;
                        this.context.accordion_ready && setTimeout(function() {
                            return t.context.accordion.accordion("refresh")
                        }, 10)
                    }
                }, {
                    key: "reposition",
                    value: function(t) {
                        var e = this.inputs.inputs;
                        this.i = t, this.point.parentNode.appendChild(this.point);
                        for (var i = 0, n = e.length; i < n; i++) e[i].setAttribute("name", e[i].getAttribute("name").replace(/points]\[\d+\]\[/, "points][" + t + "]["))
                    }
                }, {
                    key: "get_inputs_object",
                    value: function(t) {
                        return this.inputs = {
                            wrapper: t,
                            inputs: e(i + "__input", t),
                            x: e(i + "__input--x", t)[0],
                            y: e(i + "__input--y", t)[0]
                        }, this.handle_remove(), this.inputs
                    }
                }, {
                    key: "init_tinymce",
                    value: function() {
                        if (!this.tinymce_active) {
                            var t = this;
                            tinymce.init({
                                selector: "." + this.context.id + " ." + i + "__point-fields:nth-child(" + (this.i + 2) + ") ." + i + "__input--description",
                                menubar: !1,
                                statusbar: !1,
                                height: 300,
                                setup: function(e) {
                                    e.on("init", function(e) {
                                        t.refresh_accordion(), setTimeout(function() {
                                            return t.is_loading(!1)
                                        }, 10)
                                    })
                                }
                            }), this.tinymce_active = !0
                        }
                    }
                }, {
                    key: "is_loading",
                    value: function(t) {
                        var e = this.inputs.wrapper;
                        //t ? e.classList.add(i + "__point-fields--loading") : e.classList.remove(i + "__point-fields--loading")
                    }
                }, {
                    key: "create_point",
                    value: function(t, e) {
                        var i = document.createElement("div");
                        return i.classList.add(this.class_point), i.style.left = 100 * t + "%", i.style.top = 100 * e + "%", this.context.main_image.parentNode.appendChild(i), i
                    }
                }, {
                    key: "update_position",
                    value: function(t, e) {
                        this.x = t, this.y = e, this.inputs.x.value = t, this.inputs.y.value = e, this.point.style.left = 100 * t + "%", this.point.style.top = 100 * e + "%"
                    }
                }, {
                    key: "handle_remove",
                    value: function() {
                        var t = this;
                        if (void 0 !== this.inputs.wrapper) {
                            var i = e("acf-hotspot__delete", this.inputs.wrapper)[0];
                            i.addEventListener("click", function(e) {
                                e.preventDefault(), t.remove()
                            })
                        }
                    }
                }, {
                    key: "remove",
                    value: function() {
                        if (confirm("Are you sure you would like to remove point #" + (this.i + 1) + "? (this change will only persist if you save/update this post)")) {
                            var t = this.context.points;
                            t.splice(this.i, 1);
                            for (var e = 0, i = t.length; e < i; e++) t[e].reposition(e);
                            this.point.parentNode.removeChild(this.point), this.inputs.wrapper.parentNode.removeChild(this.inputs.wrapper)
                        }
                    }
                }, {
                    key: "make_draggable",
                    value: function() {
                        var e = this,
                            i = this.context.main_image;
                        t(this.point).draggable({
                            containment: "parent",
                            scroll: !1,
                            stop: function(t) {
                                var n = e.point.offsetLeft / i.offsetWidth,
                                    s = e.point.offsetTop / i.offsetHeight;
                                e.update_position(n, s)
                            }
                        })
                    }
                }, {
                    key: "point_events",
                    value: function() {
                        this.make_draggable()
                    }
                }]), n
            }();
        return function() {
            function s(n) {
                _classCallCheck(this, s), this.el = n, this.id = this.get_id(), this.source_image = t("." + i + "__upload .acf-image-uploader .view img", n), this.img_src = "", this.main_image = e(i + "__image", this.el[0])[0], this.points = [], this.spot_clone = this.generate_spot_clone(), this.accordion_ready = !1, this.accordion = t("." + i + "__information", this.el), this.init()
            }
            return _createClass(s, [{
                key: "get_id",
                value: function() {
                    for (var t = this.el[0].classList, e = 0, i = t.length; e < i; e++)
                        if (t[e].match(/acf-field-\d+/g)) return t[e]
                }
            }, {
                key: "add_exisiting_points",
                value: function() {
                    for (var t = e(i + "__point-fields", this.el[0]), s = 0, o = t.length; s < o; s++) {
                        var a = e(i + "__input--x", t[s])[0].value,
                            r = e(i + "__input--y", t[s])[0].value,
                            c = new n({
                                x: a,
                                y: r,
                                context: this,
                                exists: !0
                            });
                        c.get_inputs_object(t[s]), this.points.push(c)
                    }
                }
            }, {
                key: "generate_spot_clone",
                value: function() {
                    for (var t = e(i + "__clone-base", this.el[0])[0], n = e(i + "__input", t), s = null, o = 0, a = n.length; o < a; o++) n[o].setAttribute("data-name", n[o].getAttribute("name")), n[o].removeAttribute("name");
                    return s = t.cloneNode(!0), this.spot_clone_original = t, s.classList.remove(i + "__clone-base"), s.classList.add(i + "__point-fields"), s
                }
            }, {
                key: "change_hotspot_image",
                value: function() {
                    this.img_src = this.source_image[0].getAttribute("src"), this.img_src = this.img_src.replace(/-\d+x\d+\./g, "."), this.main_image.setAttribute("src", this.img_src)
                }
            }, {
                key: "watch_for_new_image",
                value: function() {
                    var t = this;
                    this.source_image.on("load error", function() {
                        return t.change_hotspot_image()
                    })
                }
            }, {
                key: "listen_for_user_clicks",
                value: function() {
                    var t = this;
                    this.main_image.addEventListener("click", function(e) {
                        return t.create_hotspot_point(e.offsetX, e.offsetY)
                    })
                }
            }, {
                key: "create_hotspot_point",
                value: function(t, e) {
                    if (confirm("Are you sure you would like to create a new point?")) {
                        var i = this.main_image.offsetWidth,
                            s = this.main_image.offsetHeight,
                            o = new n({
                                x: t / i,
                                y: e / s,
                                context: this
                            });
                        return this.accordion_ready && this.accordion.accordion("refresh"), this.points.push(o)
                    }
                }
            }, {
                key: "sort_points",
                value: function(t, e) {
                    this.points.splice(e, 0, this.points.splice(t, 1)[0]);
                    for (var i = 0, n = this.points.length; i < n; i++) this.points[i].reposition(i)
                }
            }, {
                key: "sortabe",
                value: function() {
                    var t = this,
                        e = -1;
                    this.accordion.accordion({
                        collapsible: !0,
                        header: "." + i + "__label",
                        beforeActivate: function(e, i) {
                            if (void 0 !== i.newHeader[0]) {
                                var n = t.points[i.newHeader.parent().index() - 1];
                                n.tinymce_active || n.has_a_tinymce() || n.is_loading(!0), setTimeout(function() {
                                    return n.init_tinymce()
                                }, 10)
                            }
                        },
                        create: function() {
                            t.accordion_ready = !0
                        }
                    }).sortable({
                        handle: "." + i + "__label",
                        start: function(t, i) {
                            e = i.item.index()
                        },
                        beforeStop: function(i, n) {
                            e !== n.item.index() && t.sort_points(e - 1, n.item.index() - 1), e = -1
                        }
                    })
                }
            }, {
                key: "init",
                value: function() {
                    this.watch_for_new_image(), this.change_hotspot_image(), this.listen_for_user_clicks(), this.add_exisiting_points(), this.sortabe()
                }
            }]), s
        }()
    }(jQuery);
"use strict";
! function(t) {
    "undefined" != typeof acf.add_action ? acf.add_action("ready append", function(n) {
        acf.get_fields({
            type: "hotspots"
        }, n).each(function() {
            new HotspotInput(t(this))
        })
    }) : t(document).on("acf/setup_fields", function(n, e) {
        t(e).find('.field[data-field_type="hotspots"]').each(function() {
            new HotspotInput(t(this))
        })
    })
}(jQuery);
//# sourceMappingURL=acf-hotspots-render.js.map
