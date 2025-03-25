class v{constructor(){this.extraData={},this.init(),this.currentPage=1,this.rowsPerPage=10,this.pageRange=2,this.observer={}}init(){this.bindEventHandlers()}bindEventHandlers(){jQuery(window).on("elementor/frontend/init",this.handleElementorWidgetInit.bind(this)),jQuery(window).on("elementor/editor/init",this.handleElementorWidgetInit.bind(this))}handleElementorWidgetInit(){elementorFrontend.hooks.addAction("frontend/element_ready/widget",e=>{const t=e.find(".graphina-advance-data-table");t.length>0&&this.initializeTables(t)})}initializeTables(e){this.observeTableElement(e,"advance-datatable")}observeTableElement(e,t){const a=e.data("element_id");gcfe_public_localize.view_port==="off"?(this.observer[a]||(this.observer[a]=new IntersectionObserver(i=>{i.forEach(s=>{s.isIntersecting&&(this.setupTable(jQuery(s.target),t),this.observer[a].unobserve(s.target))})},{threshold:.1})),this.observer[a].observe(e[0])):this.setupTable(e,t)}getJson(e){let t=[],a=[],i=document.querySelector(e+" table"),s=i.getElementsByTagName("th");s.length>0&&Object.keys(s).forEach((r,n)=>{let c=s[n].getElementsByTagName("input")[0].value;t.push(c)});let o=i.getElementsByTagName("tr");return o.length>0&&Object.keys(o).forEach((r,n)=>{let c=[],p=o[n].getElementsByTagName("td");p.length>0&&(Object.keys(p).forEach((E,u)=>{let b=p[u].getElementsByTagName("input")[0].value;c.push(b)}),a.push(c))}),JSON.stringify({header:t,body:a})}generateTable(e,t,a=!1){var b,x;const i=document.querySelector(`.graphina-table-${t}`);i&&(i.innerHTML="");const s=jQuery("body").hasClass("elementor-editor-active"),o=document.createElement("table");o.classList.add("graphina-table-base","table-bordered","table-padding-left",`datatable-${t}`);let l=this.extraData.columns||e.header.length,r=this.extraData.rows||e.body.length;this.extraData.header_in_body&&r++,this.extraData.is_index&&!s&&l++,a&&(r=e.body.length);const n=(this.currentPage-1)*this.rowsPerPage,c=n+this.rowsPerPage;let p=[];this.extraData.is_pagination&&(this.extraData.is_dynamic_table||!s)?(p=e.body.slice(n,c),r=p.length):p=e.body;const m=document.createElement("thead");m.classList.add("graphina-table-header");const E=document.createElement("tr");if(this.extraData.is_header&&e.header.length>0){for(let d=0;d<l;d++){const h=document.createElement("th");if(h.classList.add("graphina-table-cell"),s&&!this.extraData.is_dynamic_table){const g=document.createElement("input");g.type="text",g.setAttribute("placeholder",`Header ${d+1}`),g.value=e.header[d]||`Column ${d+1}`,h.append(g)}else h.textContent=e.header[d]||`Column ${d+1}`;E.appendChild(h)}m.appendChild(E),o.appendChild(m)}const u=document.createElement("tbody");if(u.classList.add("graphina-table-body"),r!==0&&e.header.length>0)for(let d=0;d<r;d++){const h=document.createElement("tr");for(let g=0;g<l;g++){const f=document.createElement("td");if(f.classList.add("graphina-table-cell"),s&&!this.extraData.is_dynamic_table){const y=document.createElement("input");y.type="text",y.setAttribute("placeholder",`Value ${g+1}`),y.value=((b=p[d])==null?void 0:b[g])||"",f.append(y)}else f.textContent=((x=p[d])==null?void 0:x[g])||"";h.appendChild(f)}u.appendChild(h)}else{const d=document.createElement("tr"),h=document.createElement("td");h.setAttribute("colspan",e.header.length),h.classList.add("graphina-table-no-data"),h.classList.add("graphina-table-cell"),h.innerText=gcfe_public_localize.no_data_available,d.appendChild(h),u.appendChild(d)}o.appendChild(u),i.append(o),this.extraData.is_pagination&&(this.extraData.is_dynamic_table||!s)&&(this.extraData.pagination_type==="numbers"?this.generatePaginationControlsNumber(e,t):this.extraData.pagination_type==="simple"?this.generatePaginationControlsSimple(e,t):this.extraData.pagination_type==="simple_numbers"?this.generatePaginationControlsSimpleNumbers(e,t):this.generatePaginationControlsFistLast(e,t))}createButton(e,t,a=!1){const i=document.createElement("span");return i.classList.add("pagination-link","graphina-align"),a?i.innerHTML=`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="${e}" height="${e}" fill="${t}"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/></svg>`:i.innerHTML=`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="${e}" height="${e}" fill="${t}"><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>`,i}createPaginationInfo(e,t){if(this.extraData.pagination_info){const a=document.createElement("div");a.classList.add("pagination-info");const i=(this.currentPage-1)*this.rowsPerPage+1,s=Math.min(t,this.currentPage*this.rowsPerPage);a.innerText=`Showing ${i} to ${s} of ${t} entries`,e.append(a),this.paginationStyle(e,a)}}generatePaginationControlsFistLast(e,t){const a=document.querySelector(`.graphina-table-${t}`);let i=Math.ceil(e.body.length/this.rowsPerPage);const s=document.createElement("section");s.classList.add("pagination-section");const o=document.createElement("div");o.classList.add("pagination");let l=e.body.length;if(this.createPaginationInfo(o,l),i>1){const r=document.createElement("div");if(r.classList.add("page-links-wrapper"),r.style.display="flex",this.currentPage>1){const n=this.createButton(this.extraData.pagination_button_height,this.extraData.pagination_text_color,!0);n.addEventListener("click",()=>{this.currentPage--,this.generateTable(e,t)}),r.appendChild(n)}for(let n=1;n<=i;n++)if(n===1||i===n){const c=document.createElement("button");c.textContent=n,c.classList.add("pagination-link"),n===this.currentPage&&c.classList.add("active"),c.addEventListener("click",()=>{this.currentPage=n,this.generateTable(e,t)}),r.appendChild(c)}if(this.currentPage<i){const n=this.createButton(this.extraData.pagination_button_height,this.extraData.pagination_text_color,!1);n.addEventListener("click",()=>{this.currentPage++,this.generateTable(e,t)}),r.appendChild(n)}o.appendChild(r)}s.appendChild(o),a.appendChild(s)}generatePaginationControlsSimpleNumbers(e,t){const a=document.querySelector(`.graphina-table-${t}`);let i=Math.ceil(e.body.length/this.rowsPerPage),s=e.body.length;const o=document.createElement("section");o.classList.add("pagination-section");const l=document.createElement("div");if(l.classList.add("pagination"),this.createPaginationInfo(l,s),i>1){const r=document.createElement("div");if(r.classList.add("page-links-wrapper"),r.style.display="flex",this.currentPage>1){const n=this.createButton(this.extraData.pagination_button_height,this.extraData.pagination_text_color,!0);n.addEventListener("click",()=>{this.currentPage--,this.generateTable(e,t)}),r.appendChild(n)}for(let n=Math.max(1,this.currentPage-this.pageRange);n<=Math.min(i,this.currentPage+this.pageRange);n++){const c=document.createElement("button");c.textContent=n,c.classList.add("pagination-link"),n===this.currentPage&&c.classList.add("active"),c.addEventListener("click",()=>{this.currentPage=n,this.generateTable(e,t)}),r.appendChild(c)}if(this.currentPage<i){const n=this.createButton(this.extraData.pagination_button_height,this.extraData.pagination_text_color,!1);n.addEventListener("click",()=>{this.currentPage++,this.generateTable(e,t)}),r.appendChild(n)}l.appendChild(r)}o.appendChild(l),a.appendChild(o)}paginationStyle(e,t){const a=this.extraData.pagination_align;a==="right"?e.classList.add("rightLeft"):a==="left"?e.classList.add("leftRight"):a==="center"&&(e.classList.add("centerPagination"),this.extraData.pagination_info==="yes"&&(t.style.margin="20px 0"))}generatePaginationControlsSimple(e,t){const a=document.querySelector(`.graphina-table-${t}`);let i=Math.ceil(e.body.length/this.rowsPerPage);const s=document.createElement("section");s.classList.add("pagination-section");const o=document.createElement("div");o.classList.add("pagination");let l=e.body.length;if(this.createPaginationInfo(o,l),i>1){const r=document.createElement("div");r.classList.add("page-links-wrapper"),r.style.display="flex";const n=this.createButton(this.extraData.pagination_button_height,this.extraData.pagination_text_color,!0);n.disabled=this.currentPage===1,n.addEventListener("click",()=>{this.currentPage>1&&(this.currentPage--,this.generateTable(e,t))}),r.appendChild(n);const c=this.createButton(this.extraData.pagination_button_height,this.extraData.pagination_text_color,!1);c.disabled=this.currentPage===i,c.addEventListener("click",()=>{this.currentPage<i&&(this.currentPage++,this.generateTable(e,t))}),r.appendChild(c),o.appendChild(r)}s.appendChild(o),a.appendChild(s)}generatePaginationControlsNumber(e,t){const a=document.querySelector(`.graphina-table-${t}`);let i=Math.ceil(e.body.length/this.rowsPerPage);const s=document.createElement("section");s.classList.add("pagination-section");const o=document.createElement("div");o.classList.add("pagination");let l=e.body.length;if(this.createPaginationInfo(o,l),i>1){for(let r=Math.max(1,this.currentPage-this.pageRange);r<=Math.min(i,this.currentPage+this.pageRange);r++){const n=document.createElement("button");n.textContent=r,n.classList.add("pagination-link"),r===this.currentPage&&n.classList.add("active"),n.addEventListener("click",()=>{this.currentPage=r,this.generateTable(e,t)}),o.appendChild(n)}s.appendChild(o),a.appendChild(s)}}getDynamicData(e,t){return new Promise((a,i)=>{jQuery.ajax({url:gcfe_public_localize.ajaxurl,type:"POST",dataType:"json",data:{action:"get_jquery_datatable_data",nonce:gcfe_public_localize.table_nonce,chartType:"advance-datatable",post_id:this.extraData.current_post_id,element_id:e,series_count:0,settings:JSON.stringify(t),selected_field:[]},success:s=>{a(s)},error:s=>{console.error("AJAX Error:",s),i(new Error("AJAX request failed."))}})})}async setupTable(e,t){const a=e.data("element_id");this.extraData=e.data("extra_data");const i=e.data("table_data"),s=e.data("settings");if(this.rowsPerPage=this.extraData.pagination_row,this.pageRange=this.extraData.page_range,this.extraData.is_dynamic_table){const o=await this.getDynamicData(a,s);this.generateTable(o.data,a),this.setupSearchFilter(a,o.data)}else this.generateTable(i,a);this.extraData.is_dynamic_table||(document.querySelector(`.graphina-table-${a} table`)&&document.querySelector(`.graphina-table-${a} table`).addEventListener("change",()=>{let o=this.getJson(`.graphina-table-${a}`),l=parent.document.querySelector(`input[data-setting="${this.extraData.prefix}advance-datatable_element_data_json"]`);if(document.querySelector(`input[data-setting="${this.extraData.prefix}advance-datatable_element_data_json"]`),l){l.value=o;let r=new Event("input",{bubbles:!0});l.dispatchEvent(r)}else console.warn("Hidden input field not found!")}),this.setupSearchFilter(a,i))}setupSearchFilter(e,t){const a=document.getElementById(`table-filter-${e}`);a&&a.addEventListener("keyup",()=>{const i=a.value.toLowerCase(),s=t.body;let o={header:t.header,body:[]};o.body=s.filter(function(l){return l.filter(function(r){return r.toString().toLowerCase().includes(i)}).length>0}),this.generateTable(o,e,!0)})}}new v;
//# sourceMappingURL=advance_data_table-DO8ieWAt.js.map
