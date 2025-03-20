class p{constructor(){this.chartHandlers={},this.init(),this.mainChart={}}init(){this.setUpChartsHandler(),this.bindEventHandlers()}bindEventHandlers(){jQuery(document.body).on("change",".graphina-select-apex-chart-type",this.debounce(this.handleChartTypeChange.bind(this),300)),jQuery(window).on("elementor/frontend/init",this.handleElementorWidgetInit.bind(this)),jQuery(window).on("elementor/editor/init",this.handleElementorWidgetInit.bind(this)),jQuery(document.body).on("click",".graphina-filter-div-button",this.handleChartFilter.bind(this))}debounce(r,t){let e;return function(...a){const i=this;clearTimeout(e),e=setTimeout(()=>r.apply(i,a),t)}}observeChartElement(r,t){const e=r.data("element_id");gcfe_public_localize.view_port==="off"?(this.observer[e]||(this.observer[e]=new IntersectionObserver(a=>{a.forEach(i=>{i.isIntersecting&&(this.setupChart(jQuery(i.target),t),this.observer[e].unobserve(i.target),this.observer[e].disconnect())})},{threshold:.1})),this.observer[e].observe(r[0])):this.setupChart(r,t)}handleChartTypeChange(r){const t=jQuery(r.target),e=t.val(),a=t.data("element_id"),i=jQuery(`.graphina-elementor-chart[data-element_id="${a}"]`);i.length>0&&this.updateChartType(i,e)}handleChartFilter(r){const t=r.currentTarget,e=jQuery(t).data("element_id"),a=jQuery(`.graphina-elementor-chart[data-element_id="${e}"]`);let i=jQuery(a).data("chart_type");this.updateChartType(a,i,!0)}setUpChartsHandler(){throw new Error("setUpChartsHandler method must be implemented by subclasses")}handleElementorWidgetInit(){elementorFrontend.hooks.addAction("frontend/element_ready/widget",r=>{const t=r.find(".graphina-elementor-chart");t.length>0&&this.initializeCharts(t)})}initializeCharts(r){const t=r.data("chart_type");this.chartHandlers[t]&&this.chartHandlers[t](r)}formatNumber(r,t){const e=["","K","M","B","T"];let a=0;for(;r>=1e3&&a<e.length-1;)r/=1e3,a++;return r.toFixed(t)+e[a]}applyLegendTooltip(r,t,e){t.legend_show_series_value&&(r.legend.tooltipHoverFormatter=(a,i)=>{let n=i.w.globals.series[i.seriesIndex][i.dataPointIndex];return["polar","column","line","scatter","pie","donut","radial"].includes(e)&&(n=i.w.globals.series[i.seriesIndex]),`<div class="legend-info"><span>${a}</span>:<strong>${n}</strong></div>`})}applyXAxisFormatter(r,t){t.xaxis_label_prefix_show&&(r.xaxis.labels.formatter=e=>`${t.xaxis_label_prefix}${e}${t.xaxis_label_postfix}`)}applyYAxisFormatter(r,t,e=!1){const a=(n,_,s,l,o)=>t.chart_yaxis_label_pointer?_+this.formatNumber(n,l)+s:t.yaxis_label_format&&(o===0||o===!1)?_+new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:l,maximumFractionDigits:l}).format(n)+s:t.chart_opposite_yaxis_format_number&&o===1?_+new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:l,maximumFractionDigits:l}).format(n)+s:_+n+s,i=(n,_,s,l,o)=>{n.labels||(n.labels={}),n.labels.formatter=c=>a(c,_,s,l,o)};if(e===!1)i(r.yaxis,t.yaxis_label_prefix,t.yaxis_label_postfix,t.decimal_in_float,e);else if(e===0||e===1){let n=r.yaxis[e],_=e===0?t.yaxis_label_prefix:t.chart_opposite_yaxis_label_prefix,s=e===0?t.yaxis_label_postfix:t.chart_opposite_yaxis_label_postfix,l=t.decimal_in_float;i(n,_,s,l,e)}}applyDataLabelFormatter(r,t){let e=t.chart_datalabel_prefix??"",a=t.chart_datalabel_postfix??"";r.dataLabels||(r.dataLabels={}),r.dataLabels.formatter=function(i){return t.chart_number_format_commas&&(i=new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:t.chart_datalabel_decimals_in_float,maximumFractionDigits:t.chart_datalabel_decimals_in_float}).format(i)),e+i+a}}async updateChartType(r,t,e=!1){const a=r.data("element_id"),i=r.data("chart_options"),n=r.data("extra_data"),_=r.data("settings");if(!i||!a){console.error("Missing required chart options or element ID.");return}if(t==="bar"&&i.chart.type!=="bar"&&(i.tooltip.shared=!1),i.chart.type=t,e){let l=[];const o=jQuery(`#graphina_chart_filter_${a}`).data("total_filter");for(let d=0;d<o;d++)l[d]=jQuery(`#graphina-start-date_${d}${a}`).val()??jQuery(`#graphina-drop_down_filter_${d}${a}`).val();const c=await this.getDynamicData(_,n,t,a,l);c.extra!==void 0?(i.series=c.extra.series,i.xaxis.categories=c.extra.category):(i.series=[],i.xaxis.categories=[])}ApexCharts.exec(a,"destroy"),new ApexCharts(r[0],i).render().then(()=>console.log(`Chart updated to ${t}.`)).catch(l=>console.error("Error updating chart:",l))}setFieldForForminator(r,t,e){const a=e.section_chart_forminator_aggregate,n=["mixed","brush","gantt_google"].includes(t)?r.forminator_columns:r.extra.forminator_columns;a?this.populateDropdownField(`[data-setting="${e.graphina_prefix}${t}_section_chart_forminator_aggregate_column"]`,n,e.section_chart_forminator_aggregate_column):(this.populateDropdownField(`[data-setting="${e.graphina_prefix}${t}_section_chart_forminator_x_axis_columns"]`,n,e.section_chart_forminator_x_axis_columns),this.populateDropdownField(`[data-setting="${e.graphina_prefix}${t}_section_chart_forminator_y_axis_columns"]`,n,e.section_chart_forminator_y_axis_columns))}setFieldsForCSV(r,t,e,a){const i=a.chart_dynamic_data_option==="sql-builder",n=i?t.extra.db_column:t.extra.column;this.populateDropdownField(`[data-setting="${a.graphina_prefix}${e}_${i?"chart_sql_builder_x_columns":"chart_csv_x_columns"}"]`,n,i?a.chart_csv_x_columns_sql:a.chart_csv_x_columns),this.populateDropdownField(`[data-setting="${a.graphina_prefix}${e}_${i?"chart_sql_builder_y_columns":"chart_csv_y_columns"}"]`,n,i?a.chart_csv_y_columns_sql:a.chart_csv_y_columns)}populateDropdownField(r,t,e){const a=parent.document.querySelector(r);if(a){a.innerHTML="";try{t.forEach(i=>{const n=Array.isArray(e)?e.includes(i):e===i;a.append(new Option(i,i,n,n))})}catch(i){console.log(i)}}}setFieldsForCounter(r,t,e,a){return!0}getDynamicData(r,t,e,a,i){let n="graphina_get_dynamic_data",_=gcfe_public_localize.nonce;return e==="counter"&&(n="get_jquery_datatable_data",_=gcfe_public_localize.table_nonce),new Promise((s,l)=>{jQuery.ajax({url:gcfe_public_localize.ajaxurl,type:"POST",dataType:"json",data:{action:n,nonce:_,chartType:e,post_id:t.current_post_id,element_id:a,series_count:t.chart_data_series_count_dynamic,settings:r,selected_field:i},success:o=>{o.status&&jQuery("body").hasClass("elementor-editor-active")&&(e==="counter"&&this.setFieldsForCounter(r,o,e,t),(t.chart_csv_column_wise_enable||t.chart_dynamic_data_option==="sql-builder")&&(t.chart_dynamic_data_option==="csv"||t.chart_dynamic_data_option==="remote-csv"||t.chart_dynamic_data_option==="google-sheet"||t.chart_dynamic_data_option==="sql-builder")&&this.setFieldsForCSV(r,o,e,t),t.dynamic_type==="forminator"&&this.setFieldForForminator(o,e,t)),s(o)},error:o=>{console.error("AJAX Error:",o),l(new Error("AJAX request failed."))}})})}getChartOptions(r,t,e,a,i){return r}afterRenderChart(r,t,e){return r}processDynamicData(r,t,e){return!0}afterManualLoad(r,t,e){return!0}afterDynamicLoad(r,t,e){return!0}async setupChart(r,t){try{const e=r.data("element_id"),a=r.data("chart_options"),i=r.data("responsive_options"),n=r.data("extra_data"),_=r.data("settings"),s=r.data("chart_type");if((s==="nested_column"||s==="brush"||s==="column")&&(t=s),!a||!e){console.error(`Missing required data attributes for ${t} chart.`);return}if(n.chart_data_option===!0){try{let c=[];const d=jQuery(`#graphina_chart_filter_${e}`).data("total_filter");for(let u=0;u<d;u++)c[u]=jQuery(`#graphina-start-date_${u}${e}`).val()??jQuery(`#graphina-drop_down_filter_${u}${e}`).val();const h=await this.getDynamicData(_,n,t,e,c);this.processDynamicData(h,e,n),h.extra!==void 0?s==="nested_column"?a.series=[{data:h.extra.series}]:(a.series=h.extra.series,a.xaxis.categories=h.extra.category):(a.series=[],a.xaxis.categories=[]),this.afterDynamicLoad(h,e,n)}catch(c){console.error("Failed to get dynamic data:",c)}jQuery(document).find(`.graphina-${e}-loader`).hide()}else this.afterManualLoad([],e,n);this.applyLegendTooltip(a,n,s),this.applyXAxisFormatter(a,n),this.applyDataLabelFormatter(a,n),n.chart_opposite_yaxis_title_enable?(this.applyYAxisFormatter(a,n,0),this.applyYAxisFormatter(a,n,1)):this.applyYAxisFormatter(a,n,!1);const l=this.getChartOptions(a,t,n,i,e);this.mainChart[e]&&this.mainChart[e].destroy();const o=new ApexCharts(jQuery(r)[0],l);await o.render(),this.mainChart[e]=o,this.afterRenderChart(o,e,n),n.can_chart_reload_ajax&&setInterval(async()=>{try{const c=await this.getDynamicData(_,n,t,e);c!=null&&c.extra?(o.updateSeries(c.extra.series),o.updateOptions(c.chart_option)):console.warn(`No data returned for ${t} chart with ID ${e}.`)}catch{console.warn(`Error fetching dynamic data for ${t} chart with ID ${e}:`)}},n.interval_data_refresh*1e3)}catch(e){console.error(`Error initializing ${t} chart:`,e)}}}export{p as G};
//# sourceMappingURL=GraphinaApexChartBase-DL-VUTAW.js.map
