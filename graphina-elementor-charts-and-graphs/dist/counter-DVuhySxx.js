import{G as g}from"./GraphinaApexChartBase-uDd5wIz2.js";class y extends g{constructor(){super(),this.observer={}}setUpChartsHandler(){this.chartHandlers={counter:t=>this.observeChartElement(t,"counter")}}afterManualLoad(t,r,e){this.startCounterAnimation(r,!1,t,e)}afterDynamicLoad(t,r,e){this.startCounterAnimation(r,!0,t,e)}afterRenderChart(t,r,e){e.color!==""&&(document.querySelector(`.count_number-pre-postfix-${r}`).style.color=e.color),e.headingColor!==""&&(document.querySelector(`.counter-title-${r}`).style.color=e.headingColor),e.subHeadingColor!==""&&(document.querySelector(`.counter-description-${r}`).style.color=e.subHeadingColor),e.show_counter_chart||t.destroy()}startCounterAnimation(t,r=!1,e=[],o){const n=document.querySelector(`.count_number-${t}`);let c=parseFloat(n.getAttribute("data-start")),s=parseFloat(n.getAttribute("data-end")),a=parseInt(n.getAttribute("data-speed"),10),i=parseInt(n.getAttribute("data-decimals"),10)||0;r&&(s=e.extra.end);const u=a||2e3,f=(s-c)/(u/50);let l=c;function m(h,C=""){const d=h.toString().split(".");return d[0]=d[0].replace(/\B(?=(\d{3})+(?!\d))/g,C),d.join(".")}function p(){l<s?(l=Math.min(l+f,s),n.textContent=m(l.toFixed(i),o.seperator),requestAnimationFrame(p)):n.textContent=m(s.toFixed(i),o.seperator)}p()}setFieldsForCounter(t,r,e,o){const n=`[data-setting="${o.graphina_prefix}${e}_element_column_no"]`,c=parent.document.querySelector(n);if(!c)return;c.innerHTML="";const s=r.extra.columns,a=o.element_column_no;s.forEach(i=>{const u=Array.isArray(a)?a.includes(i):a===i;c.append(new Option(i,i,u,u))})}getChartOptions(t,r,e,o,n){return r==="counter"&&(t.responsive=o),t}}new y;
//# sourceMappingURL=counter-DVuhySxx.js.map
