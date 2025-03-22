class _{constructor(){this.tableHandlers={},this.init(),this.observer={}}init(){this.setUpTableHandler(),this.bindEventHandlers()}bindEventHandlers(){jQuery(window).on("elementor/frontend/init",this.handleElementorWidgetInit.bind(this)),jQuery(window).on("elementor/editor/init",this.handleElementorWidgetInit.bind(this))}handleElementorWidgetInit(){elementorFrontend.hooks.addAction("frontend/element_ready/widget",t=>{const l=t.find(".graphina-jquery-data-table");l.length>0&&this.initializeTables(l)})}initializeTables(t){const l=t.data("chart_type");this.tableHandlers[l]&&this.tableHandlers[l](t)}setUpTableHandler(){this.tableHandlers={data_table_lite:t=>this.observeTableElement(t,"data_table_lite")}}observeTableElement(t,l){const e=t.data("element_id");gcfe_public_localize.view_port==="off"?(this.observer[e]||(this.observer[e]=new IntersectionObserver(i=>{i.forEach(d=>{d.isIntersecting&&(this.setupTable(jQuery(d.target),l),this.observer[e].unobserve(d.target))})},{threshold:.1})),this.observer[e].observe(t[0])):this.setupTable(t,l)}getDynamicData(t,l,e){return new Promise((i,d)=>{jQuery.ajax({url:gcfe_public_localize.ajaxurl,type:"POST",dataType:"json",data:{action:"get_jquery_datatable_data",nonce:gcfe_public_localize.table_nonce,chartType:"data_table_lite",post_id:l.current_post_id,element_id:e,series_count:0,settings:t,selected_field:[]},success:r=>{jQuery("#data_table_lite_loading_"+e).hide(),jQuery("#data_table_lite_no_data_"+e).hide(),i(r)},error:r=>{console.error("AJAX Error:",r),d(new Error("AJAX request failed."))}})})}async setupTable(t,l){const e=t.data("element_id");let i=t.data("chart_data");const d=t.data("extra_data"),r=t.data("settings");i.fnInitComplete=()=>{jQuery(".dataTables_scrollBody").css({overflow:"hidden",border:"0"}),jQuery(`#data_table_lite_${e} thead th`).addClass("all graphina-datatable-columns"),jQuery(`#data_table_lite_${e} tbody td`).addClass("graphina-datatable-tbody-td");const a=jQuery(".dataTables_scrollFoot");a.css("overflow","auto"),a.on("scroll",function(){jQuery(".dataTables_scrollBody").scrollLeft(jQuery(this).scrollLeft())})},i.rowCallback=function(a,s,o){o%2===0?jQuery(a).addClass("odd"):jQuery(a).addClass("even")};let n=jQuery(".data_table_lite_"+e).DataTable(i);if(d.is_dynamic_table){const a=await this.getDynamicData(r,d,e);let s={};a.data.body.length!==0&&a.data.header.length!==0?(s.data=a.data.body,s.columns=a.data.header,n.destroy(),jQuery("#data_table_lite_loading_"+e).hide(),n=jQuery("#data_table_lite_"+e).DataTable(s)):jQuery("#data_table_lite_loading_"+e).show()}else i.columns.length>0&&jQuery("#data_table_lite_loading_"+e).hide();d.table_footer&&jQuery(`#data_table_lite_${e}`).append("<tfoot><tr>"+i.columns.map(a=>`<th>${a.title}</th>`).join("")+"</tr></tfoot>"),d.table_data_direct&&(n.destroy(),jQuery(".data_table_lite_"+e).DataTable(i))}}new _;
//# sourceMappingURL=data_table-B5y0oVyT.js.map
