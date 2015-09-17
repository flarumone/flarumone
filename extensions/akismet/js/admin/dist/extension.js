System.register("akismet/main",["flarum/app","akismet/components/AkismetSettingsModal"],function(t){"use strict";var e,n;return{setters:[function(t){e=t["default"]},function(t){n=t["default"]}],execute:function(){e.initializers.add("akismet",function(){e.extensionSettings.akismet=function(){return e.modal.show(new n)}})}}}),System.register("akismet/components/AkismetSettingsModal",["flarum/components/Modal","flarum/components/Button","flarum/utils/saveConfig"],function(t){"use strict";function e(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function n(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function, not "+typeof e);t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,enumerable:!1,writable:!0,configurable:!0}}),e&&(Object.setPrototypeOf?Object.setPrototypeOf(t,e):t.__proto__=e)}var o,i,r,a,u=function(){function t(t,e){for(var n=0;n<e.length;n++){var o=e[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(t,o.key,o)}}return function(e,n,o){return n&&t(e.prototype,n),o&&t(e,o),e}}(),s=function(t,e,n){for(var o=!0;o;){var i=t,r=e,a=n;u=l=s=void 0,o=!1,null===i&&(i=Function.prototype);var u=Object.getOwnPropertyDescriptor(i,r);if(void 0!==u){if("value"in u)return u.value;var s=u.get;return void 0===s?void 0:s.call(a)}var l=Object.getPrototypeOf(i);if(null===l)return void 0;t=l,e=r,n=a,o=!0}};return{setters:[function(t){o=t["default"]},function(t){i=t["default"]},function(t){r=t["default"]}],execute:function(){a=function(t){function o(){e(this,o);for(var t=arguments.length,n=Array(t),i=0;t>i;i++)n[i]=arguments[i];s(Object.getPrototypeOf(o.prototype),"constructor",this).apply(this,n),this.apiKey=m.prop(app.config["akismet.api_key"]||"")}return n(o,t),u(o,[{key:"className",value:function(){return"AkismetSettingsModal Modal--small"}},{key:"title",value:function(){return"Akismet Settings"}},{key:"content",value:function(){return m("div",{className:"Modal-body"},m("div",{className:"Form"},m("div",{className:"Form-group"},m("label",null,"API Key"),m("input",{className:"FormControl",value:this.apiKey(),oninput:m.withAttr("value",this.apiKey)})),m("div",{className:"Form-group"},i.component({type:"submit",className:"Button Button--primary AkismetSettingsModal-save",loading:this.loading,children:"Save Changes"}))))}},{key:"onsubmit",value:function(t){var e=this;t.preventDefault(),this.loading=!0,r({"akismet.api_key":this.apiKey()}).then(function(){return e.hide()},function(){e.loading=!1,m.redraw()})}}]),o}(o),t("default",a)}}});