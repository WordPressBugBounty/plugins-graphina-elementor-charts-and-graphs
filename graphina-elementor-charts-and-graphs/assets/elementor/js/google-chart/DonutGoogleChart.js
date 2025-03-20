import GraphinaGoogleChartBase from './GraphinaGoogleChartBase';

// Child class specifically for Donut Charts
export default class DonutChart extends GraphinaGoogleChartBase {
    // Setup handlers for Donut Chart
    setUpChartsHandler() {
        
        this.chartHandlers = {
            donut_google: (element) => this.observeChartElement(element, 'PieChart'),
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
    getFinalChartOptions(chartOptions) {
        // Customize options here if needed
        return chartOptions;
        }

    getFinalChartData(chartData){
        return chartData;
    }

    setupTableData(dynamicData,dataTable,googleChart,googleChartTexture,extraData){
        if(dynamicData?.google_chart_data?.data.length > 0){
            dataTable.addColumn('string', 'Month');
            dataTable.addColumn('number', 'Sale');
            dynamicData.google_chart_data.data.forEach(row => dataTable.addRow(row));
            googleChart.show()
            googleChartTexture.hide()
        } else if(dynamicData?.columns.length > 0 && dynamicData.rows.length > 0){
            dynamicData.columns.forEach((col, index) => {
                dataTable.addColumn(col[0],col[1])
            });
            dynamicData.rows.forEach(row => dataTable.addRow(row));
        } else{
            googleChart.hide()
            googleChartTexture.show()
        }
        var formatter = new google.visualization.NumberFormat({
            prefix: extraData.prefix ?? '',
            suffix: extraData.suffix ?? '',
        });
        formatter.format(dataTable, 1);
    }
}
// Initialize DonutChart
new DonutChart();
