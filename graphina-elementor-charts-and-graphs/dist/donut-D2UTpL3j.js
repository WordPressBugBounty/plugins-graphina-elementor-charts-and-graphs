import{G as _}from"./GraphinaApexChartBase-DZ5wXcmS.js";class m extends _{constructor(){super(),this.observer={}}setUpChartsHandler(){this.chartHandlers={donut:a=>this.observeChartElement(a,"donut")}}applyDataLabelFormatter(a,e,o=!1){let t=e.chart_datalabel_prefix??"",s=e.chart_datalabel_postfix??"";a.dataLabels||(a.dataLabels={}),a.dataLabels&&(a.dataLabels.formatter=(l,r)=>{if(o){let i=r.w.globals.seriesTotals.reduce((b,d)=>(console.log(i),b+d),0);l=parseFloat(l/i*100).toFixed(parseInt(forminatorDecimal))}return e.chart_datalabels_format_showlabel?r.w.globals.labels[r.seriesIndex]+"-"+t+parseFloat(l).toFixed(1)+s:t+parseFloat(l).toFixed(1)+"%"+s},e.chart_datalabels_format_showValue&&(a.dataLabels.formatter=(l,r)=>(l=r.w.globals.series[r.seriesIndex],e.chart_number_format_commas&&!e.chart_data_label_pointer&&(l=new Intl.NumberFormat(r.w.globals.series[r.seriesIndex],{minimumFractionDigits:e.chart_datalabel_decimals_in_float,maximumFractionDigits:e.chart_datalabel_decimals_in_float}).format(l)),e.chart_data_label_pointer?t+this.formatNumber(l,e.chart_datalabel_decimals_in_float)+s:e.chart_datalabels_format_showlabel?r.w.globals.labels[r.seriesIndex]+"-"+t+l+s:t+l+s)))}getChartOptions(a,e,o,t,s){return e==="donut"&&(a.labels=a.xaxis.categories,a.responsive=t),a}}new m;
//# sourceMappingURL=donut-D2UTpL3j.js.map
