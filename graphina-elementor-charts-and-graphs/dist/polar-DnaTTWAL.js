import{G as c}from"./GraphinaApexChartBase-C_IMEUtX.js";class b extends c{constructor(){super(),this.observer={}}setUpChartsHandler(){this.chartHandlers={polar:e=>this.observeChartElement(e,"polar")}}applyDataLabelFormatter(e,a,m=!1){let t=a.chart_datalabel_prefix??"",r=a.chart_datalabel_postfix??"";e.dataLabels||(e.dataLabels={}),e.yaxis.labels.formatter=l=>this.formatNumber(l,a.chart_datalabel_decimals_in_float),e.dataLabels&&(e.dataLabels.formatter=(l,i)=>{if(m){let _=i.w.globals.seriesTotals.reduce((s,o)=>s+o,0);l=new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:a.chart_datalabel_decimals_in_float,maximumFractionDigits:a.chart_datalabel_decimals_in_float}).format(l/_*100)}return a.chart_datalabels_format_showlabel?i.w.globals.labels[i.seriesIndex]+"-"+t+new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:a.chart_datalabel_decimals_in_float,maximumFractionDigits:a.chart_datalabel_decimals_in_float}).format(l)+r:t+new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:a.chart_datalabel_decimals_in_float,maximumFractionDigits:a.chart_datalabel_decimals_in_float}).format(l)+"%"+r},a.chart_datalabels_format_showValue&&(e.dataLabels.formatter=(l,i)=>(l=i.w.globals.series[i.seriesIndex],a.chart_number_format_commas&&!a.chart_data_label_pointer&&(l=new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:a.chart_datalabel_decimals_in_float,maximumFractionDigits:a.chart_datalabel_decimals_in_float}).format(l)),a.chart_data_label_pointer&&(l=t+this.formatNumber(l,a.chart_datalabel_decimals_in_float)+r),a.chart_datalabels_format_showlabel?i.w.globals.labels[i.seriesIndex]+"-"+t+l+r:t+l+r)))}getChartOptions(e,a,m,t,r){return a==="polar"&&(e.responsive=t,e.labels=e.xaxis.categories),e}}new b;
//# sourceMappingURL=polar-DnaTTWAL.js.map
