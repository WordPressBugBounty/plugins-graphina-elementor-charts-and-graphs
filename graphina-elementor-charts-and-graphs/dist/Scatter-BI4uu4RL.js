import{G as i}from"./GraphinaApexChartBase-B0hQqMJh.js";class o extends i{constructor(){super(),this.observer={}}setUpChartsHandler(){this.chartHandlers={scatter:e=>this.observeChartElement(e,"scatter")}}observeChartElement(e,r){const t=e.data("element_id");gcfe_public_localize.view_port==="off"?(this.observer[t]||(this.observer[t]=new IntersectionObserver(a=>{a.forEach(s=>{s.isIntersecting&&(this.setupChart(jQuery(s.target),r),this.observer[t].unobserve(s.target))})},{threshold:.1})),this.observer[t].observe(e[0])):this.setupChart(e,r)}getChartOptions(e,r,t,a,s){return r==="scatter"&&(e.responsive=a),e}}new o;
//# sourceMappingURL=Scatter-BI4uu4RL.js.map
