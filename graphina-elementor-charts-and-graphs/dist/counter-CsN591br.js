import{G as g}from"./GraphinaApexChartBase-_qBnvcoG.js";class y extends g{constructor(){super(),this.observer={}}setUpChartsHandler(){this.chartHandlers={counter:t=>this.observeChartElement(t,"counter")}}afterManualLoad(t,r,e){this.startCounterAnimation(r,!1,t,e)}afterDynamicLoad(t,r,e){this.startCounterAnimation(r,!0,t,e)}afterRenderChart(t,r,e){e.color!==""&&(document.querySelector(`.count_number-pre-postfix-${r}`).style.color=e.color),e.headingColor!==""&&(document.querySelector(`.counter-title-${r}`).style.color=e.headingColor),e.subHeadingColor!==""&&(document.querySelector(`.counter-description-${r}`).style.color=e.subHeadingColor),e.show_counter_chart||t.destroy()}startCounterAnimation(t,r=!1,e=[],o){const n=document.querySelector(`.count_number-${t}`);let i=parseFloat(n.getAttribute("data-start")),s=parseFloat(n.getAttribute("data-end")),c=parseInt(n.getAttribute("data-speed"),10),a=parseInt(n.getAttribute("data-decimals"),10)||0;r&&(s=e.extra.end);const u=c||2e3,f=(s-i)/(u/50);let l=i;function m(h,C=""){const d=h.toString().split(".");return d[0]=d[0].replace(/\B(?=(\d{3})+(?!\d))/g,C),d.join(".")}function p(){l<s?(l=Math.min(l+f,s),n.textContent=m(l.toFixed(a),o.seperator),requestAnimationFrame(p)):n.textContent=m(s.toFixed(a),o.seperator)}p()}setFieldsForCounter(t,r,e,o){const n=`[data-setting="${o.graphina_prefix}${e}_element_column_no"]`,i=parent.document.querySelector(n);if(!i)return;i.innerHTML="";const s=r.extra.columns,c=o.element_column_no;s.forEach(a=>{const u=Array.isArray(c)?c.includes(a):c===a;i.append(new Option(a,a,u,u))})}processDynamicData(t,r,e){t.extra.category=["element1"]}getChartOptions(t,r,e,o,n){return r==="counter"&&(t.responsive=o),t}}new y;
//# sourceMappingURL=counter-CsN591br.js.map
