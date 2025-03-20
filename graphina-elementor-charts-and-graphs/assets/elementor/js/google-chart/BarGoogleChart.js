import GraphinaGoogleChartBase from './GraphinaGoogleChartBase';

// Child class specifically for Bar Charts
export default class BarChart extends GraphinaGoogleChartBase {
    // Setup handlers for Bar Chart
    setUpChartsHandler() {
        this.chartHandlers = {
            bar_google: (element) => this.observeChartElement(element, 'BarChart'),
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

    // Customize chart options for Bar Charts (if needed)
    getFinalChartOptions(chartOptions) {
        // Customize options here if needed
        return chartOptions;
    }

    setupTableData(dynamicData,dataTable,googleChart,googleChartTexture,extraData){
        if(dynamicData?.google_chart_data?.title_array.length > 0 && dynamicData?.google_chart_data?.data.length > 0){
            dataTable.addColumn('string',dynamicData.google_chart_data.title)
            dynamicData.google_chart_data.title_array.forEach((col) => {
                dataTable.addColumn('number',col);
                if(dynamicData.google_chart_data.annotation_show){
                    dataTable.addColumn({type:'string',role:'annotation'});
                }
            });
            dynamicData.google_chart_data.data.forEach(row => dataTable.addRow(row));
            googleChart.show()
            googleChartTexture.hide()
        }else if(dynamicData.columns.length > 0 && dynamicData.rows.length > 0){
            dynamicData.columns.forEach((col, index) => {
                dataTable.addColumn(col);
            });

            dynamicData.rows.forEach(row => dataTable.addRow(row));
        }else{
            googleChart.hide()
            googleChartTexture.show()
        }
    }
}
// Initialize Bar Chart
new BarChart();
