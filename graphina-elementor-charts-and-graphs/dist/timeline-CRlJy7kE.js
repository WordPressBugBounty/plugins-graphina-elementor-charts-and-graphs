import{G as h}from"./GraphinaApexChartBase-C-IYbsiB.js";class u extends h{constructor(){super(),this.observer={}}setUpChartsHandler(){this.chartHandlers={timeline:t=>this.observeChartElement(t,"timeline")}}dateFormat(t,a=!1,r=!1){let s="-",e=new Date(t),l=e.getHours(),o="0"+e.getMinutes(),i=e.getDate(),m=e.getMonth()+1,n=e.getFullYear();return(r?i+s+m+s+n:"")+(r&&a?" ":"")+(a?l+":"+o.substr(-2):"")}TimelineChartXaxisFormat(t,a){const r=a.xaxis_show_time,s=a.xaxis_show_date;t.xaxis.labels.formatter=e=>(e=this.dateFormat(e,r,s),e)}applyDataLabelFormatter(t,a){a.xaxis_show_time,a.xaxis_show_date;let r=a.chart_datalabel_prefix??"",s=a.chart_datalabel_postfix??"";t.dataLabels||(t.dataLabels={}),t.dataLabels.formatter=e=>{if(Array.isArray(e)&&e.length===2){let[l,o]=e,i=o-l,m=Math.floor(i/(1e3*60*60*24)),n=Math.floor(i%(1e3*60*60*24)/(1e3*60*60)),d=Math.floor(i%(1e3*60*60)/(1e3*60));return`${m} days ${n} hours ${d} minutes`}else return typeof e!="number"||isNaN(e)?(console.warn("Invalid value for data label:",e),r+"N/A"+s):r+this.dateFormat(e,!0,!0)+s}}getChartOptions(t,a,r,s){return a==="timeline"&&(t.xaxis.type="datetime",t.plotOptions={bar:{horizontal:!0}},t.responsive=s),this.TimelineChartXaxisFormat(t,r),t}}new u;
//# sourceMappingURL=timeline-CRlJy7kE.js.map
