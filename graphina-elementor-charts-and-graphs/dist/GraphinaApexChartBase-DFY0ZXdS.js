class p{constructor(){this.chartHandlers={},this.init(),this.mainChart={}}init(){this.setUpChartsHandler(),this.bindEventHandlers()}bindEventHandlers(){jQuery(document.body).on("change",".graphina-select-apex-chart-type",this.debounce(this.handleChartTypeChange.bind(this),300)),jQuery(window).on("elementor/frontend/init",this.handleElementorWidgetInit.bind(this)),jQuery(window).on("elementor/editor/init",this.handleElementorWidgetInit.bind(this)),jQuery(document.body).off("click",".graphina-filter-div-button.apex"),jQuery(document.body).on("click",".graphina-filter-div-button.apex",this.debounce(this.handleChartFilter.bind(this),300))}debounce(a,t){let e;return function(...r){const i=this;clearTimeout(e),e=setTimeout(()=>a.apply(i,r),t)}}observeChartElement(a,t){const e=a.data("element_id");gcfe_public_localize.view_port==="off"?(this.observer[e]||(this.observer[e]=new IntersectionObserver(r=>{r.forEach(i=>{i.isIntersecting&&(this.setupChart(jQuery(i.target),t),this.observer[e].unobserve(i.target),this.observer[e].disconnect())})},{threshold:.1})),this.observer[e].observe(a[0])):this.setupChart(a,t)}handleChartTypeChange(a){const t=jQuery(a.target),e=t.val(),r=t.data("element_id"),i=jQuery(`.graphina-elementor-chart[data-element_id="${r}"]`);i.length>0&&this.updateChartType(i,e)}handleChartFilter(a){const t=a.currentTarget,e=jQuery(t).data("element_id"),r=jQuery(`.graphina-elementor-chart[data-element_id="${e}"]`);let i=jQuery(r).data("chart_type");i==="column"&&(i="bar"),r.length>0&&this.updateChartType(r,i,!0)}setUpChartsHandler(){throw new Error("setUpChartsHandler method must be implemented by subclasses")}handleElementorWidgetInit(){elementorFrontend.hooks.addAction("frontend/element_ready/widget",a=>{const t=a.find(".graphina-elementor-chart");t.length>0&&this.initializeCharts(t)})}initializeCharts(a){const t=a.data("chart_type");this.chartHandlers[t]&&this.chartHandlers[t](a)}formatNumber(a,t){const e=["","K","M","B","T"];let r=0;for(;a>=1e3&&r<e.length-1;)a/=1e3,r++;return a.toFixed(t)+e[r]}applyLegendTooltip(a,t,e){t.legend_show_series_value&&(a.legend.tooltipHoverFormatter=(r,i)=>{let n=i.w.globals.series[i.seriesIndex][i.dataPointIndex];return["polar","column","line","scatter","pie","donut","radial"].includes(e)&&(n=i.w.globals.series[i.seriesIndex]),`<div class="legend-info"><span>${r}</span>:<strong>${n}</strong></div>`})}applyXAxisFormatter(a,t){t.xaxis_label_prefix_show&&(a.xaxis.labels.formatter=e=>`${t.xaxis_label_prefix}${e}${t.xaxis_label_postfix}`)}applyYAxisFormatter(a,t,e=!1){const r=(n,c,s,l,_)=>t.chart_yaxis_label_pointer?c+this.formatNumber(n,l)+s:t.yaxis_label_format&&(_===0||_===!1)?c+new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:l,maximumFractionDigits:l}).format(n)+s:t.chart_opposite_yaxis_format_number&&_===1?c+new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:l,maximumFractionDigits:l}).format(n)+s:c+n+s,i=(n,c,s,l,_)=>{n.labels||(n.labels={}),n.labels.formatter=o=>r(o,c,s,l,_)};if(e===!1)i(a.yaxis,t.yaxis_label_prefix,t.yaxis_label_postfix,t.decimal_in_float,e);else if(e===0||e===1){let n=a.yaxis[e],c=e===0?t.yaxis_label_prefix:t.chart_opposite_yaxis_label_prefix,s=e===0?t.yaxis_label_postfix:t.chart_opposite_yaxis_label_postfix,l=t.decimal_in_float;i(n,c,s,l,e)}}applyDataLabelFormatter(a,t){let e=t.chart_datalabel_prefix??"",r=t.chart_datalabel_postfix??"";a.dataLabels||(a.dataLabels={}),a.dataLabels.formatter=function(i){return t.chart_number_format_commas&&(i=new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen,{minimumFractionDigits:t.chart_datalabel_decimals_in_float,maximumFractionDigits:t.chart_datalabel_decimals_in_float}).format(i)),e+i+r}}async updateChartType(a,t,e=!1){const r=a.data("element_id"),i=a.data("chart_options"),n=a.data("extra_data"),c=a.data("settings");if(!i||!r||!t){console.error("Missing required chart options or element ID.");return}if(t==="bar"&&i.chart.type!=="bar"&&(i.tooltip.shared=!1),i.chart.type=t,e){let l=[];const _=jQuery(`#graphina_chart_filter_${r}`).data("total_filter");for(let d=0;d<_;d++)l[d]=jQuery(`#graphina-start-date_${d}${r}`).val()??jQuery(`#graphina-drop_down_filter_${d}${r}`).val();const o=await this.getDynamicData(c,n,t,r,l);o.extra!==void 0?(i.series=o.extra.series,i.xaxis.categories=o.extra.category):(i.series=[],i.xaxis.categories=[])}ApexCharts.exec(r,"destroy"),new ApexCharts(a[0],i).render().then(()=>console.log(`Chart updated to ${t}.`)).catch(l=>console.error("Error updating chart:",l))}setFieldForForminator(a,t,e){const r=e.section_chart_forminator_aggregate,n=["mixed","brush","gantt_google"].includes(t)?a.forminator_columns:a.extra.forminator_columns;r?this.populateDropdownField(`[data-setting="${e.graphina_prefix}${t}_section_chart_forminator_aggregate_column"]`,n,e.section_chart_forminator_aggregate_column):(this.populateDropdownField(`[data-setting="${e.graphina_prefix}${t}_section_chart_forminator_x_axis_columns"]`,n,e.section_chart_forminator_x_axis_columns),this.populateDropdownField(`[data-setting="${e.graphina_prefix}${t}_section_chart_forminator_y_axis_columns"]`,n,e.section_chart_forminator_y_axis_columns))}setFieldsForCSV(a,t,e,r){const i=r.chart_dynamic_data_option==="sql-builder",n=i?t.extra.db_column:t.extra.column;this.populateDropdownField(`[data-setting="${r.graphina_prefix}${e}_${i?"chart_sql_builder_x_columns":"chart_csv_x_columns"}"]`,n,i?r.chart_csv_x_columns_sql:r.chart_csv_x_columns),this.populateDropdownField(`[data-setting="${r.graphina_prefix}${e}_${i?"chart_sql_builder_y_columns":"chart_csv_y_columns"}"]`,n,i?r.chart_csv_y_columns_sql:r.chart_csv_y_columns)}populateDropdownField(a,t,e){const r=parent.document.querySelector(a);if(r){r.innerHTML="";try{t.forEach(i=>{const n=Array.isArray(e)?e.includes(i):e===i;r.append(new Option(i,i,n,n))})}catch(i){console.log(i)}}}setFieldsForCounter(a,t,e,r){return!0}getDynamicData(a,t,e,r,i){let n="graphina_get_dynamic_data",c=gcfe_public_localize.nonce;e==="counter"&&(n="get_jquery_datatable_data",c=gcfe_public_localize.table_nonce);let s=jQuery(`[data-element_id="${r}"]`).closest("[data-elementor-id]").data("elementor-id");return new Promise((l,_)=>{jQuery.ajax({url:gcfe_public_localize.ajaxurl,type:"POST",dataType:"json",data:{action:n,nonce:c,chartType:e,post_id:s,element_id:r,series_count:t.chart_data_series_count_dynamic,settings:JSON.stringify(a),selected_field:i},success:o=>{o.status&&jQuery("body").hasClass("elementor-editor-active")&&(e==="counter"&&this.setFieldsForCounter(a,o,e,t),(t.chart_csv_column_wise_enable||t.chart_dynamic_data_option==="sql-builder")&&(t.chart_dynamic_data_option==="csv"||t.chart_dynamic_data_option==="remote-csv"||t.chart_dynamic_data_option==="google-sheet"||t.chart_dynamic_data_option==="sql-builder")&&this.setFieldsForCSV(a,o,e,t),t.dynamic_type==="forminator"&&this.setFieldForForminator(o,e,t)),l(o)},error:o=>{console.error("AJAX Error:",o),_(new Error("AJAX request failed."))}})})}getChartOptions(a,t,e,r,i){return a}afterRenderChart(a,t,e){return a}processDynamicData(a,t,e){return!0}afterManualLoad(a,t,e){return!0}afterDynamicLoad(a,t,e){return!0}async setupChart(a,t){try{const e=a.data("element_id"),r=a.data("chart_options"),i=a.data("responsive_options"),n=a.data("extra_data"),c=a.data("settings"),s=a.data("chart_type");if((s==="nested_column"||s==="brush"||s==="column")&&(t=s),!r||!e){console.error(`Missing required data attributes for ${t} chart.`);return}if(n.chart_data_option===!0){try{let o=[];const d=jQuery(`#graphina_chart_filter_${e}`).data("total_filter");for(let u=0;u<d;u++)o[u]=jQuery(`#graphina-start-date_${u}${e}`).val()??jQuery(`#graphina-drop_down_filter_${u}${e}`).val();const h=await this.getDynamicData(c,n,t,e,o);this.processDynamicData(h,e,n),h.extra!==void 0?s==="nested_column"?r.series=[{data:h.extra.series}]:(r.series=h.extra.series,r.xaxis.categories=h.extra.category):(r.series=[],r.xaxis.categories=[]),this.afterDynamicLoad(h,e,n)}catch(o){console.error("Failed to get dynamic data:",o)}jQuery(document).find(`.graphina-${e}-loader`).hide()}else this.afterManualLoad([],e,n);this.applyLegendTooltip(r,n,s),this.applyXAxisFormatter(r,n),this.applyDataLabelFormatter(r,n),n.chart_opposite_yaxis_title_enable?(this.applyYAxisFormatter(r,n,0),this.applyYAxisFormatter(r,n,1)):this.applyYAxisFormatter(r,n,!1);const l=this.getChartOptions(r,t,n,i,e);this.mainChart[e]&&this.mainChart[e].destroy();const _=new ApexCharts(jQuery(a)[0],l);await _.render(),this.mainChart[e]=_,this.afterRenderChart(_,e,n),n.can_chart_reload_ajax&&setInterval(async()=>{try{const o=await this.getDynamicData(c,n,t,e);o!=null&&o.extra?(_.updateSeries(o.extra.series),_.updateOptions(o.chart_option)):console.warn(`No data returned for ${t} chart with ID ${e}.`)}catch{console.warn(`Error fetching dynamic data for ${t} chart with ID ${e}:`)}},n.interval_data_refresh*1e3)}catch(e){console.error(`Error initializing ${t} chart:`,e)}}}export{p as G};
//# sourceMappingURL=GraphinaApexChartBase-DFY0ZXdS.js.map
