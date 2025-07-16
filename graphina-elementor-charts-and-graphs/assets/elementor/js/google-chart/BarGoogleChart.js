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
        this.setupChartTypeSwitcher(element);
    }
    
    // Customize chart options for Bar Charts (if needed)
    getFinalChartOptions(chartOptions,elementId){
        if( chartOptions.vAxis && chartOptions.vAxis.format === 'percent'){
            chartOptions.vAxis.format = '#\'%\''
        }
        return chartOptions
    }

    setupTableData(dynamicData, dataTable, googleChart, googleChartTexture, extraData) {
    const googleData = dynamicData?.google_chart_data;
    const hasGoogleData = googleData && Array.isArray(googleData.title_array) && Array.isArray(googleData.data);

    if (hasGoogleData && googleData.title_array.length > 0 && googleData.data.length > 0) {
        // First column: string label
        dataTable.addColumn('string', googleData.title);

        // Add number columns for data series
        googleData.title_array.forEach(() => {
            dataTable.addColumn('number', '');
            if (googleData.annotation_show) {
                dataTable.addColumn({ type: 'string', role: 'annotation' });
            }
        });

        // Add rows
        googleData.data.forEach((row) => {
            dataTable.addRow(row);
        });

        googleChart.show();
        googleChartTexture.hide();
    } else if (Array.isArray(dynamicData.columns) && dynamicData.columns.length > 0 &&
               Array.isArray(dynamicData.rows) && dynamicData.rows.length > 0) {

        dynamicData.columns.forEach((col) => dataTable.addColumn(col));
        dynamicData.rows.forEach((row) => dataTable.addRow(row));

        googleChart.show();
        googleChartTexture.hide();
    } else {
        googleChart.hide();
        googleChartTexture.show();
    }
}

}
// Initialize Bar Chart
window.graphinaGoogleBarChart = new BarChart();
