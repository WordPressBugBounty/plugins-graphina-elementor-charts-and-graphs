import{G as d}from"./GraphinaApexChartBase-C-IYbsiB.js";class m extends d{constructor(){super(),this.observer={}}setUpChartsHandler(){this.chartHandlers={pie:a=>this.observeChartElement(a,"pie")}}applyDataLabelFormatter(a,e,b=!1){let t=e.chart_datalabel_prefix??"",s=e.chart_datalabel_postfix??"";a.dataLabels||(a.dataLabels={}),a.dataLabels&&(a.dataLabels.formatter=(l,r)=>{if(b){let i=r.w.globals.seriesTotals.reduce((o,_)=>(console.log(i),o+_),0);l=parseFloat(l/i*100).toFixed(parseInt(forminatorDecimal))}return e.chart_datalabels_format_showlabel?r.w.globals.labels[r.seriesIndex]+"-"+t+parseFloat(l).toFixed(1)+s:t+parseFloat(l).toFixed(1)+"%"+s},e.chart_datalabels_format_showValue&&(a.dataLabels.formatter=(l,r)=>(l=r.w.globals.series[r.seriesIndex],e.chart_number_format_commas&&!e.chart_data_label_pointer&&(l=new Intl.NumberFormat(r.w.globals.series[r.seriesIndex],{minimumFractionDigits:e.chart_datalabel_decimals_in_float,maximumFractionDigits:e.chart_datalabel_decimals_in_float}).format(l)),e.chart_data_label_pointer?t+this.formatNumber(l,e.chart_datalabel_decimals_in_float)+s:e.chart_datalabels_format_showlabel?r.w.globals.labels[r.seriesIndex]+"-"+t+l+s:t+l+s)))}getChartOptions(a,e,b,t,s){return e==="pie"&&(a.responsive=t,a.labels=a.xaxis.categories),a}}new m;
//# sourceMappingURL=pie-zWm7FS1f.js.map
