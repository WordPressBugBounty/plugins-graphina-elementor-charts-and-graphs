// Class specifically for Advance Data table
export default class DataTable {
    constructor() {
        this.extraData = {}
        this.init();
        this.currentPage = 1;
        this.rowsPerPage = 10; 
        this.pageRange   = 2;
        this.observer    = {}
    }

    // Initialize the class by setting up handlers and events
    init() {
        this.bindEventHandlers();
    }

   

    // Bind event listeners
    bindEventHandlers() {
        jQuery(window).on('elementor/frontend/init', this.handleElementorWidgetInit.bind(this));
        jQuery(window).on('elementor/editor/init', this.handleElementorWidgetInit.bind(this));
    }


    handleElementorWidgetInit() {
        elementorFrontend.hooks.addAction('frontend/element_ready/widget', ($scope) => {
            const chartElement = $scope.find('.graphina-advance-data-table');
            if (chartElement.length > 0) {
                this.initializeTables(chartElement);
            }
        });
    }

    initializeTables(chartElement) {
        this.observeTableElement(chartElement, 'advance-datatable')
    }

    // Setup IntersectionObserver to call setupTable when the element is in the viewport
    observeTableElement(element, dataTableType) {
        const elementID = element.data('element_id')
        if (gcfe_public_localize.view_port === 'off') {
            if (!this.observer[elementID]) {
                this.observer[elementID] = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            // Element is in viewport; initialize the chart
                            this.setupTable(jQuery(entry.target), dataTableType);
                            // Stop observing the element after initializing the chart
                            this.observer[elementID].unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 }); // Trigger when at least 10% of the element is visible
            }
            this.observer[elementID].observe(element[0]); // Start observing the chart element
        } else {
            this.setupTable(element, dataTableType);
        }
    }
    getJson(tableParent) {
        let header = [];
        let body = [];
        let divEle = document.querySelector(tableParent + ' table');
        let thEle = divEle.getElementsByTagName('th');
        if (thEle.length > 0) {
            let th = Object.keys(thEle);
            th.forEach((item, index) => {
                let value = thEle[index].getElementsByTagName('input')[0].value;
                header.push(value);
            });
        }
        let trEle = divEle.getElementsByTagName('tr');
        if (trEle.length > 0) {
            let tr = Object.keys(trEle);
            tr.forEach((item, index) => {
                let tdData = [];
                let tdEle = trEle[index].getElementsByTagName('td');
                if (tdEle.length > 0) {
                    let td = Object.keys(tdEle);
                    td.forEach((item, index) => {
                        let value = tdEle[index].getElementsByTagName('input')[0].value;
                        tdData.push(value);
                    });
                    body.push(tdData);
                }
            });
        }
        return JSON.stringify({ 'header': header, 'body': body });
    }

    generateTable(table_data,element_id,is_search=false){
        const mainElement = document.querySelector(`.graphina-table-${element_id}`)
        if(mainElement){
            mainElement.innerHTML = '';
        }

        // check is edit mode
        const is_editor_mode = jQuery("body").hasClass("elementor-editor-active");
        const tableElement = document.createElement("table"); 
        tableElement.classList.add('graphina-table-base', 'table-bordered', 'table-padding-left', `datatable-${element_id}`)
        let totalColumns = this.extraData.columns || table_data.header.length; // Use extraData.columns if set, else default
        let totalRows = this.extraData.rows || table_data.body.length; // Use extraData.rows if set, else default
        if(this.extraData.header_in_body){
            totalRows++;
        } 

        if(this.extraData.is_index && !is_editor_mode){
            totalColumns++;
        }

        if(is_search){
            totalRows = table_data.body.length
        }

        const start = (this.currentPage - 1) * this.rowsPerPage;
        const end = start + this.rowsPerPage;

        let paginatedRows = []
        if(this.extraData.is_pagination && (this.extraData.is_dynamic_table || !is_editor_mode)){
            paginatedRows   = table_data.body.slice(start, end);
            totalRows       = paginatedRows.length
        }else{
            paginatedRows   = table_data.body
        }
        
        
        
        // Create table header
        const thead = document.createElement("thead");
        thead.classList.add("graphina-table-header");
        const headerRow = document.createElement("tr");
        
        if(this.extraData.is_header && table_data.header.length > 0){
            for (let i = 0; i < totalColumns; i++) {
                const th = document.createElement("th");
                th.classList.add("graphina-table-cell");
                if (is_editor_mode && !this.extraData.is_dynamic_table) {
                    const inputEle = document.createElement("input");
                    inputEle.type = "text";
                    inputEle.setAttribute("placeholder", `Header ${i + 1}`);
                    inputEle.value = table_data.header[i] || `Column ${i + 1}`;
                    th.append(inputEle);
                } else {
                    th.textContent = table_data.header[i] || `Column ${i + 1}`;
                }
                headerRow.appendChild(th);
            }
            thead.appendChild(headerRow);
            tableElement.appendChild(thead);
        }

        // Create table body
        const tbody = document.createElement("tbody");
        tbody.classList.add("graphina-table-body");

        if(totalRows !== 0 && table_data.header.length > 0){
            for (let rowIndex = 0; rowIndex < totalRows; rowIndex++) {
                const row = document.createElement("tr");
    
                for (let colIndex = 0; colIndex < totalColumns; colIndex++) {
                    const td = document.createElement("td");
                    td.classList.add("graphina-table-cell");
                    if (is_editor_mode && !this.extraData.is_dynamic_table) {
                        const inputEle = document.createElement("input");
                        inputEle.type = "text";
                        inputEle.setAttribute("placeholder", `Value ${colIndex + 1}`);
                        inputEle.value = paginatedRows[rowIndex]?.[colIndex] || "";
                        td.append(inputEle);
                    } else {
                        td.textContent = paginatedRows[rowIndex]?.[colIndex] || "";
                    }
                    row.appendChild(td);
                }
    
                tbody.appendChild(row);
            }
        }else{
            const row = document.createElement("tr");
            const td = document.createElement("td");
            td.setAttribute('colspan', table_data.header.length);
            td.classList.add('graphina-table-no-data');
            td.classList.add('graphina-table-cell');
            td.innerText = gcfe_public_localize.no_data_available;
            row.appendChild(td);
            tbody.appendChild(row);
        }

        tableElement.appendChild(tbody);
        mainElement.append(tableElement);

        if(this.extraData.is_pagination && (this.extraData.is_dynamic_table || !is_editor_mode)){
            if(this.extraData.pagination_type === 'numbers'){
                this.generatePaginationControlsNumber(table_data, element_id);
            }else if(this.extraData.pagination_type === 'simple'){
                this.generatePaginationControlsSimple(table_data, element_id);
            }else if(this.extraData.pagination_type === 'simple_numbers'){
                this.generatePaginationControlsSimpleNumbers(table_data, element_id);
            }else{
                this.generatePaginationControlsFistLast(table_data,element_id)
            }
        }
    }

    createButton(width,fill,is_prev=false) {
        const svgContainer = document.createElement('span');
        svgContainer.classList.add('pagination-link', 'graphina-align');
        if(is_prev){
            svgContainer.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="${width}" height="${width}" fill="${fill}"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/></svg>`;
        }else{
            svgContainer.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="${width}" height="${width}" fill="${fill}"><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>`;
        }
        return svgContainer;
    }

    createPaginationInfo(paginationContainer,totalRows){
        if(this.extraData.pagination_info) {
            const paginationInfo = document.createElement('div');
            paginationInfo.classList.add('pagination-info');
            const currentStartRow = (this.currentPage - 1) * this.rowsPerPage + 1;
            const currentEndRow = Math.min(totalRows, this.currentPage * this.rowsPerPage);
            paginationInfo.innerText = `Showing ${currentStartRow} to ${currentEndRow} of ${totalRows} entries`;
            paginationContainer.append(paginationInfo);
            this.paginationStyle(paginationContainer,paginationInfo)
        }
    }
    

    generatePaginationControlsFistLast(table_data,element_id){
        const mainElement = document.querySelector(`.graphina-table-${element_id}`);
        let totalPages = Math.ceil(table_data.body.length / this.rowsPerPage);

        const paginationSection = document.createElement('section');
        paginationSection.classList.add('pagination-section');
        const paginationContainer = document.createElement('div');
        paginationContainer.classList.add('pagination');

        let totalRows  = table_data.body.length
        this.createPaginationInfo(paginationContainer,totalRows)
  
        if (totalPages > 1) {
            const pagewrapper = document.createElement('div');
            pagewrapper.classList.add('page-links-wrapper');
            pagewrapper.style.display = 'flex';


            if (this.currentPage > 1) {
                const svgContainer = this.createButton(this.extraData.pagination_button_height,this.extraData.pagination_text_color,true)        
                svgContainer.addEventListener("click", () => {
                    this.currentPage--;
                    this.generateTable(table_data, element_id);
                });
                pagewrapper.appendChild(svgContainer);
            }
            
            for (let i = 1; i <= totalPages; i++) {
                if(i === 1 || totalPages === i){
                    const pageButton = document.createElement("button");
                    pageButton.textContent = i;
                    pageButton.classList.add("pagination-link");
                    if (i === this.currentPage) {
                        pageButton.classList.add("active");
                    }
                    pageButton.addEventListener("click", () => {
                        this.currentPage = i;
                        this.generateTable(table_data, element_id);
                    });
                    pagewrapper.appendChild(pageButton);
                }
            }
            
            if (this.currentPage < totalPages) {
                const svgContainerNext = this.createButton(this.extraData.pagination_button_height,this.extraData.pagination_text_color,false)        
                svgContainerNext.addEventListener("click", () => {
                    this.currentPage++;
                    this.generateTable(table_data, element_id);
                });
                pagewrapper.appendChild(svgContainerNext);
            }
            paginationContainer.appendChild(pagewrapper);
        }
        paginationSection.appendChild(paginationContainer)
        mainElement.appendChild(paginationSection);
    }

    generatePaginationControlsSimpleNumbers(table_data,element_id){
        const mainElement = document.querySelector(`.graphina-table-${element_id}`);
        let totalPages = Math.ceil(table_data.body.length / this.rowsPerPage);
        let totalRows  = table_data.body.length
        const paginationSection = document.createElement('section');
        paginationSection.classList.add('pagination-section');
        const paginationContainer = document.createElement('div');
        paginationContainer.classList.add('pagination');
        
        this.createPaginationInfo(paginationContainer,totalRows)
       
        if (totalPages > 1) {

            const pagewrapper = document.createElement('div');
            pagewrapper.classList.add('page-links-wrapper');
            pagewrapper.style.display = 'flex';

            if (this.currentPage > 1) {
                const svgContainer = this.createButton(this.extraData.pagination_button_height,this.extraData.pagination_text_color,true)        
                svgContainer.addEventListener("click", () => {
                    this.currentPage--;
                    this.generateTable(table_data, element_id);
                });
                pagewrapper.appendChild(svgContainer);
            }

            for(let i = Math.max(1, this.currentPage - this.pageRange);i<= Math.min( totalPages, this.currentPage+ this.pageRange );i++){
                const pageButton = document.createElement("button");
                pageButton.textContent = i;
                pageButton.classList.add("pagination-link");
                if (i === this.currentPage) {
                    pageButton.classList.add("active");
                }
                pageButton.addEventListener("click", () => {
                    this.currentPage = i;
                    this.generateTable(table_data, element_id);
                });
                pagewrapper.appendChild(pageButton);
            }
            
            if (this.currentPage < totalPages) {
                const svgContainer = this.createButton(this.extraData.pagination_button_height,this.extraData.pagination_text_color,false)                  

                svgContainer.addEventListener("click", () => {
                    this.currentPage++;
                    this.generateTable(table_data, element_id);
                });
                pagewrapper.appendChild(svgContainer);
            }
            paginationContainer.appendChild(pagewrapper);

        }
        paginationSection.appendChild(paginationContainer)
        mainElement.appendChild(paginationSection);
    }

    paginationStyle(paginationContainer,paginationInfo){
        const align = this.extraData.pagination_align
        if (align === 'right') {
            paginationContainer.classList.add('rightLeft');
        } else if (align === 'left') {
            paginationContainer.classList.add('leftRight');
        } else if (align === 'center') {
            paginationContainer.classList.add('centerPagination');
            if (this.extraData.pagination_info === 'yes'){
                paginationInfo.style.margin = '20px 0';
            }
        }
    }

    generatePaginationControlsSimple(table_data, element_id) {
        const mainElement = document.querySelector(`.graphina-table-${element_id}`);
        let totalPages = Math.ceil(table_data.body.length / this.rowsPerPage);
        const paginationSection = document.createElement('section');
        paginationSection.classList.add('pagination-section');
        const paginationContainer = document.createElement('div');
        paginationContainer.classList.add('pagination');
        
        let totalRows  = table_data.body.length
        this.createPaginationInfo(paginationContainer,totalRows)
        
        if (totalPages > 1) {

            const pagewrapper = document.createElement('div');
            pagewrapper.classList.add('page-links-wrapper');
            pagewrapper.style.display = 'flex';

            const svgContainer = this.createButton(this.extraData.pagination_button_height,this.extraData.pagination_text_color,true)      
            svgContainer.disabled = this.currentPage === 1;
            svgContainer.addEventListener("click", () => {
                if (this.currentPage > 1) {
                    this.currentPage--;
                    this.generateTable(table_data, element_id);
                }
            });
            pagewrapper.appendChild(svgContainer);

            const svgContainerNext = this.createButton(this.extraData.pagination_button_height,this.extraData.pagination_text_color,false)      
            svgContainerNext.disabled = this.currentPage === totalPages;
            svgContainerNext.addEventListener("click", () => {
                if (this.currentPage < totalPages) {
                    this.currentPage++;
                    this.generateTable(table_data, element_id);
                }
            });
            pagewrapper.appendChild(svgContainerNext);
            paginationContainer.appendChild(pagewrapper);
        }
        paginationSection.appendChild(paginationContainer)
        mainElement.appendChild(paginationSection);
    }

    generatePaginationControlsNumber(table_data, element_id) {
        const mainElement = document.querySelector(`.graphina-table-${element_id}`);

        let totalPages = Math.ceil(table_data.body.length / this.rowsPerPage);
        
        const paginationSection = document.createElement('section');
        paginationSection.classList.add('pagination-section');
        const paginationContainer = document.createElement('div');
        paginationContainer.classList.add('pagination');

        let totalRows  = table_data.body.length
        this.createPaginationInfo(paginationContainer,totalRows)

        if (totalPages > 1) {
            for(let i = Math.max(1, this.currentPage - this.pageRange);i<= Math.min( totalPages, this.currentPage+ this.pageRange );i++){
                const pageButton = document.createElement("button");
                pageButton.textContent = i;
                pageButton.classList.add("pagination-link");
                if (i === this.currentPage) {
                    pageButton.classList.add("active");
                }
                pageButton.addEventListener("click", () => {
                    this.currentPage = i;
                    this.generateTable(table_data, element_id);
                });
                paginationContainer.appendChild(pageButton);
            }
            paginationSection.appendChild(paginationContainer)
            mainElement.appendChild(paginationSection);
        }
    }

    getDynamicData(elementId,settings) {
        let post_id = jQuery(`[data-element_id="${elementId}"]`).closest('[data-elementor-id]').data('elementor-id');
        
        return new Promise((resolve, reject) => {
            jQuery.ajax({
                url: gcfe_public_localize.ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action      : 'get_jquery_datatable_data',
                    nonce       : gcfe_public_localize.table_nonce,
                    chartType   : 'advance-datatable',
                    post_id     : post_id,
                    element_id  : elementId,
                    series_count: 0,
                    settings    : JSON.stringify(settings),
                    selected_field: []
                },
                success: (response) => {
                    resolve(response);
                },
                error: (error) => {
                    console.error('AJAX Error:', error);
                    reject(new Error('AJAX request failed.'));
                },
            });
        });
    }
    
    async setupTable(element,dataTableType){
        const element_id    = element.data('element_id')
        this.extraData      = element.data('extra_data');
        const table_data    = element.data('table_data');
        const settings      = element.data('settings');
        this.rowsPerPage    = this.extraData.pagination_row
        this.pageRange      = this.extraData.page_range

        if(this.extraData.is_dynamic_table){
            const dynamicData = await this.getDynamicData(element_id,settings);
            this.generateTable(dynamicData.data,element_id)
            this.setupSearchFilter(element_id,dynamicData.data)

        }else{
            this.generateTable(table_data,element_id);
        }
        
        // For update elementor controller
        if(!this.extraData.is_dynamic_table){
            if (document.querySelector(`.graphina-table-${element_id} table`)) {
                document.querySelector(`.graphina-table-${element_id} table`).addEventListener("change", () => {
                    let info = this.getJson(`.graphina-table-${element_id}`);
                    let jsonDataElement = parent.document.querySelector(`input[data-setting="${this.extraData.prefix}advance-datatable_element_data_json"]`);
                    document.querySelector(`input[data-setting="${this.extraData.prefix}advance-datatable_element_data_json"]`)
                    if (jsonDataElement) {
                        jsonDataElement.value = info;
                        let event = new Event("input", { bubbles: true });
                        jsonDataElement.dispatchEvent(event);
                    } else {
                        console.warn("Hidden input field not found!");
                    }
                });
            }
            this.setupSearchFilter(element_id,table_data)
        }

        
    }

    setupSearchFilter(element_id,table_data) {
        const filterInput = document.getElementById(`table-filter-${element_id}`);
        if (!filterInput) return;

        filterInput.addEventListener("keyup",  () => {
            const searchTerm = filterInput.value.toLowerCase();
            const rows = table_data.body;
            let data = {
                header: table_data.header,
                body: []
            }
            data.body = rows.filter(function (res) {
                return res.filter(function (val) {
                    return val.toString().toLowerCase().includes(searchTerm);
                }).length > 0;
            });
            this.generateTable(data,element_id,true);
        });
    }


}

new DataTable();
