import{G as i}from"./GraphinaApexChartBase-DL-VUTAW.js";class _ extends i{constructor(){super(),this.observer={}}setUpChartsHandler(){this.chartHandlers={polar:a=>this.observeChartElement(a,"polar")}}applyDataLabelFormatter(a,e){let l=e.chart_datalabel_prefix??"",r=e.chart_datalabel_postfix??"";a.dataLabels||(a.dataLabels={}),a.dataLabels.formatter=t=>(e.chart_number_format_commas&&!e.chart_data_label_pointer&&(t=new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:e.chart_datalabel_decimals_in_float,maximumFractionDigits:e.chart_datalabel_decimals_in_float}).format(t)),e.chart_data_label_pointer?l+this.formatNumber(t,e.chart_datalabel_decimals_in_float)+r:l+t+r)}getChartOptions(a,e,l,r,t){return e==="polar"&&(a.responsive=r,a.labels=a.xaxis.categories),a}}new _;
//# sourceMappingURL=polar-CHOO4d9H.js.map
