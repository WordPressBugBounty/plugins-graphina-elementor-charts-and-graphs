import{G as n}from"./GraphinaApexChartBase-BPWN4Rp6.js";class d extends n{constructor(){super(),this.observer={},this.secondaryChart=[],this.secondaryChartData=[]}setUpChartsHandler(){this.chartHandlers={nested_column:t=>this.observeChartElement(t,"bar")}}getChartOptions(t,r,a,e,s){return r==="nested_column"&&(t.plotOptions={bar:{distributed:!0,horizontal:!0,barHeight:"75%",dataLabels:{position:"bottom"}}},t.chart.id=`barYear-${s}`,t.chart.events={dataPointSelection:(o,i,c)=>{this.toggleSecondaryChartData(c.dataPointIndex,t,s)}},t.tooltip={x:{show:!0},y:{formatter:function(o){let i=0,c=a.chart_tooltip_prefix_val,h=a.chart_tooltip_postfix_val;return a.tooltip_formatter?c+new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:i,maximumFractionDigits:i}).format(o)+h:o}}},t.responsive=e),this.initSChart(s,t),t}updateSecondaryChartVisibility(t){const r=jQuery(`.nested_column-chart-two-${t}`)[0],a=jQuery(`.nested_column-chart-one-${t}`)[0];this.secondaryChartData.length===0?(r.classList.remove("active"),a.classList.remove("chart-quarter-activated"),jQuery(`.nested_column-chart-two-${t}`).hide()):(a.classList.add("chart-quarter-activated"),r.classList.add("active"),jQuery(`.nested_column-chart-two-${t}`).show())}initSChart(t,r){const a=jQuery(`.nested_column-chart-two-${t}`);this.secondaryChart[t]=new ApexCharts(a[0],a.data("second_chart_options")),this.secondaryChart[t].render(),jQuery(`.nested_column-chart-two-${t}`).hide()}toggleSecondaryChartData(t,r,a){const e=r.series[0].data[t],s=this.secondaryChartData.findIndex(o=>o.name===e.x);s===-1?this.secondaryChartData.push({name:e.x,data:e.quarters,color:e.color}):this.secondaryChartData.splice(s,1),this.updateSecondaryChartVisibility(a),this.secondaryChart[a]&&this.secondaryChart[a].updateSeries(this.secondaryChartData)}}new d;
//# sourceMappingURL=nestedcolumn-CWuTDfe9.js.map
