import{G as l}from"./GraphinaGoogleChartBase-tomRYu0s.js";class g extends l{setUpChartsHandler(){this.chartHandlers={org_google:e=>this.observeChartElement(e,"OrgChart")}}observeChartElement(e,r){gcfe_public_localize.view_port==="off"?(this.observer||(this.observer=new IntersectionObserver(o=>{o.forEach(s=>{s.isIntersecting&&(this.setupChart(jQuery(s.target),r),this.observer.unobserve(s.target))})},{threshold:.1})),this.observer.observe(e[0])):this.setupChart(e,r)}getFinalChartOptions(e){return e}setupTableData(e,r,o,s,a){var h,i;((i=(h=e==null?void 0:e.google_chart_data)==null?void 0:h.data)==null?void 0:i.length)>0?(r.addColumn("string","Child"),r.addColumn("string","Parent"),r.addColumn("string","Tooltip"),e.google_chart_data.data.map(t=>this.prepareGanttRowData(t)).forEach(t=>r.addRow(t))):e.length>0?(r.addColumn("string","Child"),r.addColumn("string","Parent"),r.addColumn("string","Tooltip"),e.map(t=>this.prepareGanttRowData(t)).forEach(t=>r.addRow(t))):(o.hide(),s.show())}}new g;
//# sourceMappingURL=org_google-e987LQ-l.js.map
