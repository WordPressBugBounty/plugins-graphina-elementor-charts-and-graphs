import{G as s}from"./GraphinaApexChartBase-CwqBMLNw.js";class c extends s{constructor(){super(),this.observer={}}setUpChartsHandler(){this.chartHandlers={donut:a=>this.observeChartElement(a,"donut")}}applyDataLabelFormatter(a,l,m=!1){let i=l.chart_datalabel_prefix??"",_=l.chart_datalabel_postfix??"";a.dataLabels||(a.dataLabels={}),l.chart_data_label_pointer?(a.plotOptions.pie.donut.labels.total.formatter=e=>{let t=e.globals.seriesTotals.reduce((o,r)=>o+r,0);return t=this.formatNumber(t,l.chart_datalabel_decimals_in_float),i+t+_},a.plotOptions.pie.donut.labels.value.formatter=e=>(e=this.formatNumber(e,l.chart_datalabel_decimals_in_float),i+e+_),a.tooltip.y={formatter:e=>i+this.formatNumber(e,l.chart_datalabel_decimals_in_float)+_}):(a.plotOptions.pie.donut.labels.value.formatter=e=>(e=new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:l.chart_datalabel_decimals_in_float,maximumFractionDigits:l.chart_datalabel_decimals_in_float}).format(e),i+e+_),a.plotOptions.pie.donut.labels.total.formatter=e=>{let t=e.globals.seriesTotals.reduce((o,r)=>o+r,0);return t=new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:l.chart_datalabel_decimals_in_float,maximumFractionDigits:l.chart_datalabel_decimals_in_float}).format(t),i+t+_},a.tooltip.y={formatter:e=>i+new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:l.chart_datalabel_decimals_in_float,maximumFractionDigits:l.chart_datalabel_decimals_in_float}).format(e)+_}),a.dataLabels&&(a.dataLabels.formatter=(e,t)=>{if(m){let o=t.w.globals.seriesTotals.reduce((r,n)=>(console.log(o),r+n),0);e=new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:l.chart_datalabel_decimals_in_float,maximumFractionDigits:l.chart_datalabel_decimals_in_float}).format(e/o*100)}return l.chart_datalabels_format_showlabel?t.w.globals.labels[t.seriesIndex]+"-"+i+new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:l.chart_datalabel_decimals_in_float,maximumFractionDigits:l.chart_datalabel_decimals_in_float}).format(e)+_:i+new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:l.chart_datalabel_decimals_in_float,maximumFractionDigits:l.chart_datalabel_decimals_in_float}).format(e)+"%"+_},l.chart_datalabels_format_showValue&&(a.dataLabels.formatter=(e,t)=>(e=t.w.globals.series[t.seriesIndex],l.chart_number_format_commas&&!l.chart_data_label_pointer&&(e=new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:l.chart_datalabel_decimals_in_float,maximumFractionDigits:l.chart_datalabel_decimals_in_float}).format(e)),l.chart_data_label_pointer?i+this.formatNumber(e,l.chart_datalabel_decimals_in_float)+_:l.chart_datalabels_format_showlabel?t.w.globals.labels[t.seriesIndex]+"-"+i+e+_:i+e+_)))}getChartOptions(a,l,m,i,_){return l==="donut"&&(a.labels=a.xaxis.categories,a.responsive=i),a}}new c;
//# sourceMappingURL=donut-BU-sPr6t.js.map
