import{G as x}from"./GraphinaApexChartBase-DZ5wXcmS.js";class d extends x{constructor(){super(),this.observer={}}setUpChartsHandler(){this.chartHandlers={candle:e=>this.observeChartElement(e,"candle")}}dateFormat(e,t=!1,r=!1){let a="-",s=new Date(e),o=s.getHours(),l="0"+s.getMinutes(),i=s.getDate(),n=s.getMonth()+1,h=s.getFullYear();return(r?i+a+n+a+h:"")+(r&&t?" ":"")+(t?o+":"+l.substr(-2):"")}candleChartXaxisFormat(e,t){const r=t.xaxis_show_time,a=t.xaxis_show_date;let s="",o="";t.xaxis_label_prefix_show&&(s=t.xaxis_label_prefix,o=t.xaxis_label_postfix),e.xaxis.labels.formatter=l=>(l=s+this.dateFormat(l,r,a)+o,l)}getChartOptions(e,t,r,a,s){return t==="candle"&&(e.xaxis.type="datetime",e.responsive=a),this.candleChartXaxisFormat(e,r),e}}new d;
//# sourceMappingURL=candle-j2SjWJpS.js.map
