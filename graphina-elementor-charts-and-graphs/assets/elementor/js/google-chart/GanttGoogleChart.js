import GraphinaGoogleChartBase from './GraphinaGoogleChartBase';

// Child class specifically for Gantt Charts
export default class GanttChart extends GraphinaGoogleChartBase {


    // Setup handlers for Gantt Chart
    setUpChartsHandler() {

        this.chartHandlers = {
            gantt_google: (element) => this.observeChartElement(element, 'Gantt'),
        };
    }

    // Setup IntersectionObserver to call setupChart when the element is in the viewport
    observeChartElement(element, chartType) {
        if (gcfe_public_localize.view_port === 'off') {
            if (!this.observer) {
                this.observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            // Element is in viewport; initialize the chart
                            this.setupChart(jQuery(entry.target), chartType);
                            // Stop observing the element after initializing the chart
                            this.observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 }); // Trigger when at least 10% of the element is visible
            }
            this.observer.observe(element[0]); // Start observing the chart element
        } else {
            this.setupChart(element, chartType);
        }
    }


    // Customize chart options for Gantt Charts (if needed)
    getFinalChartOptions(chartOptions,elementId){
        // Customize options here if needed
        
        return chartOptions;
    }

    getFinalChartData(chartData) {
        
        return chartData;
    }

    setDependField(settings, extraData) {
        const ele = window.parent.document.querySelectorAll('.elementor-control-iq_gantt_google_value_list_3_1_repeaters .elementor-repeater-fields');
        const depend_columns = extraData.dependColumn;
        ele.forEach((value, key) => {
            const selectField = value.querySelector('[data-setting="iq_gantt_google_chart_value_3_element_dependencies"]');
            const id = value.querySelector('[data-setting="_id"]').value;

            if (selectField && Object.keys(depend_columns).length > 0) {
                // Clear previous options
                selectField.innerHTML = '';

                // Add default "Select" option
                selectField.append(new Option('Select', ''));

                for (const key1 in depend_columns) {
                    if (id !== key1) {
                        const isSelected = settings['iq_gantt_google_value_list_3_1_repeaters'][key]['iq_gantt_google_chart_value_3_element_dependencies'][0] === key1;
                        selectField.append(new Option(depend_columns[key1], key1.toLowerCase(), isSelected, isSelected));
                    }
                }
            }
        });

    }


    setupTableData(dynamicData,dataTable,googleChart,googleChartTexture,extraData){
        if (dynamicData?.extra?.length > 0) {
            dataTable.addColumn('string', 'Task ID');
            dataTable.addColumn('string', 'Task Name');
            dataTable.addColumn('string', 'Resource');
            dataTable.addColumn('date', 'Start Date');
            dataTable.addColumn('date', 'End Date');
            dataTable.addColumn('number', 'Duration');
            dataTable.addColumn('number', 'Percent Complete');
            dataTable.addColumn('string', 'Dependencies');
            let temp = dynamicData.extra.map((x) => {
                return this.prepareGanttRowData(x)
            });
            temp.forEach(row => dataTable.addRow(row));
        } else if (dynamicData.length > 0) {
            dataTable.addColumn('string', 'Task ID');
            dataTable.addColumn('string', 'Task Name');
            dataTable.addColumn('string', 'Resource');
            dataTable.addColumn('date', 'Start Date');
            dataTable.addColumn('date', 'End Date');
            dataTable.addColumn('number', 'Duration');
            dataTable.addColumn('number', 'Percent Complete');
            dataTable.addColumn('string', 'Dependencies');

            let temp = dynamicData.map((x) => {
                return this.prepareGanttRowData(x)
            });

            temp.forEach(row => dataTable.addRow(row))
        } else {
            googleChart.hide()
            googleChartTexture.show()
        }
    }
}
// Initialize Gantt Chart
window.graphinaGoogleGanttChart = new GanttChart();
