!function(e){var t={};function n(o){if(t[o])return t[o].exports;var l=t[o]={i:o,l:!1,exports:{}};return e[o].call(l.exports,l,l.exports,n),l.l=!0,l.exports}n.m=e,n.c=t,n.d=function(e,t,o){n.o(e,t)||Object.defineProperty(e,t,{configurable:!1,enumerable:!0,get:o})},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=6)}({6:function(e,t){var n=wp.i18n.__,o=wp.components.Toolbar,l=wp.blocks,r=l.registerBlockType,c=l.Editable,i=l.BlockControls;function s(e,t){return["info"==e&&[wp.element.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",width:t,height:t,viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":"2","stroke-linecap":"round","stroke-linejoin":"round",className:"wpblocks-icon-nofill"},wp.element.createElement("circle",{cx:"12",cy:"12",r:"10"}),wp.element.createElement("line",{x1:"12",y1:"16",x2:"12",y2:"12"}),wp.element.createElement("line",{x1:"12",y1:"8",x2:"12",y2:"8"}))],"warning"==e&&[wp.element.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",width:t,height:t,viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":"2","stroke-linecap":"round","stroke-linejoin":"round",className:"wpblocks-icon-nofill"},wp.element.createElement("circle",{cx:"12",cy:"12",r:"10"}),wp.element.createElement("line",{x1:"12",y1:"8",x2:"12",y2:"12"}),wp.element.createElement("line",{x1:"12",y1:"16",x2:"12",y2:"16"}))],"error"==e&&[wp.element.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",width:t,height:t,viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":"2","stroke-linecap":"round","stroke-linejoin":"round",className:"wpblocks-icon-nofill"},wp.element.createElement("circle",{cx:"12",cy:"12",r:"10"}),wp.element.createElement("line",{x1:"15",y1:"9",x2:"9",y2:"15"}),wp.element.createElement("line",{x1:"9",y1:"9",x2:"15",y2:"15"}))],"success"==e&&[wp.element.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",width:t,height:t,viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":"2","stroke-linecap":"round","stroke-linejoin":"round",className:"wpblocks-icon-nofill"},wp.element.createElement("path",{d:"M22 11.08V12a10 10 0 1 1-5.93-9.14"}),wp.element.createElement("polyline",{points:"22 4 12 14.01 9 11.01"}))]]}r("wpblocks/infobox",{title:n("Info Box","wpblocks"),description:n("Displays a notice.","wpblocks"),icon:"info",category:"common",attributes:{style:{type:"string",default:"info"},content:{type:"array",source:"children",selector:".wpblocks-info-box .wpblocks-info-content"}},edit:function(e){var t=e.attributes,l=e.setAttributes,r=e.focus,a=e.setFocus,p=e.className,w=t.style,m=t.content,u=[{icon:s("info",20),title:n("Info","wpblocks"),onClick:function(){return l({style:"info"})},isActive:"info"==w},{icon:s("warning",20),title:n("Warning","wpblocks"),onClick:function(){return l({style:"warning"})},isActive:"warning"==w},{icon:s("error",20),title:n("Error","wpblocks"),onClick:function(){return l({style:"error"})},isActive:"error"==w},{icon:s("success",20),title:n("Success","wpblocks"),onClick:function(){return l({style:"success"})},isActive:"success"==w}];return[r&&wp.element.createElement(i,{key:"controls"},wp.element.createElement(o,{controls:u})),wp.element.createElement("div",{className:p+" wpblocks-info-box wpblocks-"+w},wp.element.createElement("span",{className:"wpblocks-info-icon"},s(w,24)),wp.element.createElement("div",{className:"wpblocks-info-content"},wp.element.createElement(c,{tagName:"div",multiline:"p",onChange:function(e){return l({content:e})},value:m,placeholder:n("Type your content here..."),focus:r,onFocus:function(e){return a({props:e,editable:"content"})},keepPlaceholderOnFocus:!0})))]},save:function(e){var t=e.attributes,n=(e.setAttributes,e.focus,e.setFocus,e.className),o=t.style,l=t.content;return wp.element.createElement("div",{className:n+" wpblocks-info-box wpblocks-"+o},wp.element.createElement("span",{className:"wpblocks-info-icon"},s(o,24)),wp.element.createElement("div",{className:"wpblocks-info-content"},l))}})}});