import{G as g}from"./GraphinaGoogleChartBase-BJhuS1mN.js";class _ extends g{setUpChartsHandler(){this.chartHandlers={column_google:e=>this.observeChartElement(e,"ColumnChart")}}observeChartElement(e,r){gcfe_public_localize.view_port==="off"?(this.observer||(this.observer=new IntersectionObserver(t=>{t.forEach(s=>{s.isIntersecting&&(this.setupChart(jQuery(s.target),r),this.observer.unobserve(s.target))})},{threshold:.1})),this.observer.observe(e[0])):this.setupChart(e,r)}getFinalChartOptions(e){return e.vAxis.format==="percent"&&(e.vAxis.format="#'%'"),e}setupTableData(e,r,t,s,i){var h,l;((h=e==null?void 0:e.google_chart_data)==null?void 0:h.title_array.length)>0&&((l=e==null?void 0:e.google_chart_data)==null?void 0:l.data.length)>0?(r.addColumn("string",e.google_chart_data.title),e.google_chart_data.title_array.forEach(o=>{r.addColumn("number",o),e.google_chart_data.annotation_show&&r.addColumn({type:"string",role:"annotation"})}),e.google_chart_data.data.forEach(o=>r.addRow(o)),t.show(),s.hide()):e.columns.length>0&&e.rows.length>0?(e.columns.forEach((o,n)=>{r.addColumn(o)}),e.rows.forEach(o=>r.addRow(o))):(t.hide(),s.show())}}new _;
//# sourceMappingURL=column_google-Dg7rqV0E.js.map
