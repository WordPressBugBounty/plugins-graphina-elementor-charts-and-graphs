import{G as n}from"./GraphinaApexChartBase-C_IMEUtX.js";class b extends n{constructor(){super(),this.observer={}}setUpChartsHandler(){this.chartHandlers={radar:r=>this.observeChartElement(r,"radar")}}applyDataLabelFormatter(r,e,o=!1){const a=e.chart_datalabel_prefix,t=e.chart_datalabel_postfix;if(r.dataLabels)if(e.string_format)r.dataLabels.formatter=l=>(l=a+this.formatNumber(l,e.chart_label_pointer_number_for_label)+t,e.chart_datalabels_format_showlabel?opts.w.globals.labels[opts.seriesIndex]+"-"+a+l+t:a+l+t);else{if(o){let l=opts.w.globals.seriesTotals.reduce((i,_)=>i+_,0);val=new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:e.chart_label_pointer_number_for_label,maximumFractionDigits:e.chart_label_pointer_number_for_label}).format(val/l*100)}r.dataLabels.formatter=(l,i)=>e.chart_datalabels_format_showlabel?i.w.globals.labels[i.seriesIndex]+"-"+a+new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:e.chart_label_pointer_number_for_label,maximumFractionDigits:e.chart_label_pointer_number_for_label}).format(l)+t:a+new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:e.chart_label_pointer_number_for_label,maximumFractionDigits:e.chart_label_pointer_number_for_label}).format(l)+t}}getChartOptions(r,e,o,a,t){return e==="radar"&&(r.responsive=a),r}}new b;
//# sourceMappingURL=radar-BB8T448a.js.map
