import{G as i}from"./GraphinaApexChartBase-DFY0ZXdS.js";class b extends i{constructor(){super(),this.observer={}}setUpChartsHandler(){this.chartHandlers={radial:a=>this.observeChartElement(a,"radial")}}RadialChartDatalabelsFormat(a,r){const t=r.chart_datalabel_prefix,s=r.chart_datalabel_postfix;a.plotOptions.radialBar.dataLabels.total.formatter=e=>{let l=e.globals.seriesTotals.reduce((o,d)=>o+d,0);return t+l+s},a.plotOptions.radialBar.dataLabels.value.formatter=e=>(e=e,t+e+s)}getChartOptions(a,r,t,s,e){return r==="radial"&&(a.labels=a.xaxis.categories,a.responsive=s),this.RadialChartDatalabelsFormat(a,t),a}}new b;
//# sourceMappingURL=radial-Bss4Lx4D.js.map
