// Class specifically for Advance Data table
export default class TreeChart {
    constructor() {
        this.chartHandlers = {};
        this.init();
        this.observer = {};
    }

    // Initialize the class by setting up handlers and events
    init() {
        this.bindElementorInit(); // Bind Elementor hooks separately
    }

    bindElementorInit() {
        // Flag to track if our handler has been registered
        let elementorHookCalled = false;
        
        const runOnElementorReady = () => {
            if (elementorHookCalled) return;
            
            // Wait for Elementor modules to be ready
            if (window.elementorFrontend && window.elementorFrontend.elementsHandler) {
                elementorHookCalled = true;
                
                // Register the widget handler
                window.elementorFrontend.hooks.addAction('frontend/element_ready/widget', ($scope) => {
                    const chartElement = $scope.find('.graphina-tree-chart');
                    if (chartElement.length > 0) {
                        this.initializeTables(chartElement);
                    }
                });
            }
        };

        // Case 1: Check if Elementor is already initialized
        if (window.elementorFrontend && window.elementorFrontend.elementsHandler) {
            runOnElementorReady();
        }

        // Case 2: Wait for Elementor to initialize
        jQuery(window).on('elementor/frontend/init', () => {
            // Add a small delay to ensure modules are loaded
            setTimeout(runOnElementorReady, 50);
        });

        // Case 3: Fallback for non-Elementor pages
        jQuery(document).ready(() => {
            if (!elementorHookCalled) {
                const chartElements = jQuery('.graphina-tree-chart');
                if (chartElements.length > 0) {
                    chartElements.each((index, element) => {
                        this.initializeTables(jQuery(element));
                    });
                }
            }
        });
    }

    handleElementorWidgetInit() {
        elementorFrontend.hooks.addAction('frontend/element_ready/widget', ($scope) => {
            const chartElement = $scope.find('.graphina-tree-chart');
            if (chartElement.length > 0) {
                this.initializeTables(chartElement);
            }
        });
    }

    initializeTables(chartElement) {
        this.observeTableElement(chartElement, 'tree')
    }

    // Setup IntersectionObserver to call setupTree when the element is in the viewport
    observeTableElement(element, chartType) {

        const elementID = element.data('element_id')
        if (gcfe_public_localize.view_port === 'off') {
            if (!this.observer[elementID]) {
                this.observer[elementID] = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            // Element is in viewport; initialize the chart
                            this.setupTree(jQuery(entry.target), chartType);
                            // Stop observing the element after initializing the chart
                            this.observer[elementID].unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 }); // Trigger when at least 10% of the element is visible
            }
            this.observer[elementID].observe(element[0]); // Start observing the chart element
        } else {
            this.setupTree(element, chartType);
        }
    }
    getDynamicTreeData(settings, extraData, elementId) {
       
        let post_id = jQuery(`[data-element_id="${elementId}"]`).closest('[data-elementor-id]').data('elementor-id');
        return new Promise((resolve, reject) => {
            jQuery.ajax({
                url: gcfe_public_localize.ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action      : 'graphina_get_dynamic_tree_data',
                    nonce       : gcfe_public_localize.tree_nonce,
                    chartType   : 'tree',
                    post_id     : post_id,
                    element_id  : elementId,
                    series_count: 0,
                    settings    : JSON.stringify(settings),
                
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

    addContentLists(columns,extraData,chartType){
        const element = parent.document.querySelector(`[data-setting="${extraData.graphina_prefix}${chartType}_available_tree_columns"`);
        if (!element) return;
    
        element.innerHTML = ''; // Clear existing options
        try {
            element.value = columns
        } catch (error) {
            console.log(error);
        }
    }

    async setupTree(element, chartType) {

        const element_id = element.data('element_id')
        const chartOptions = element.data('chart_options');
        let chart_data = element.data('chart_data');
        
        const extraData = element.data('extra_data');
        const settings = element.data('settings');

        chartOptions.nodeTemplate = (content) => {
            const template = extraData.tree_template;
            return new Function('content', `return \`${template}\`;`)(content);
        };
        


        try {
            if(extraData.chart_data_option === true){
                
                const dynamicData = await this.getDynamicTreeData(settings, extraData, element_id);

                // for showing available field in json
                this.addContentLists(dynamicData.chart_data.columns,extraData,chartType)
                chart_data = dynamicData.chart_data.tree_data
                jQuery(document).find(`.graphina-${element_id}-loader`).hide()
            }
            
            const tree = new ApexTree(element, chartOptions);
            tree.render(chart_data);
        } catch (error) {
            console.log(error);
        }

    }
    
    
    
}
    


new TreeChart();
