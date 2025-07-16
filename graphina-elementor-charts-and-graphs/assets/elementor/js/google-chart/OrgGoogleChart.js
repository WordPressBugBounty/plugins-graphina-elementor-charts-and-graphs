import GraphinaGoogleChartBase from './GraphinaGoogleChartBase';

// Child class specifically for Org Charts
export default class OrgChart extends GraphinaGoogleChartBase {
    // Setup handlers for Org Chart
    setUpChartsHandler() {
        this.chartHandlers = {
            org_google: (element) => this.observeChartElement(element, 'OrgChart'),
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

    // Customize chart options for Org Charts (if needed)
    getFinalChartOptions(chartOptions,elementId){
        // Customize options here if needed
        return chartOptions;
    }

    setupTableData(dynamicData,dataTable,googleChart,googleChartTexture,extraData){
        if (dynamicData?.google_chart_data?.data?.length > 0) {
            dataTable.addColumn('string', 'Child');
            dataTable.addColumn('string', 'Parent');
            dataTable.addColumn('string', 'Tooltip');
             let temp = dynamicData.google_chart_data.data.map((x) => {
                return this.prepareGanttRowData(x)
            });
            temp.forEach(row => dataTable.addRow(row));
        } else if (dynamicData.length > 0) {
            dataTable.addColumn('string', 'Child');
            dataTable.addColumn('string', 'Parent');
            dataTable.addColumn('string', 'Tooltip');
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
// Initialize Org Chart
window.graphinaGoogleOrgChart = new OrgChart();
