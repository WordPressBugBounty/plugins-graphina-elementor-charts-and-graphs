import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Line Charts
export default class LineChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }
    
    // Setup handlers for Line chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            line: (element) => this.observeChartElement(element, 'line'),
        };
    }

   
    getChartOptions(finalChartOptions, chartType,extraData,responsive_options,elementId) {
        if (chartType === 'line') {
            // finalChartOptions.chart.zoom = { enabled: false }; 
            finalChartOptions.responsive = responsive_options
        }
        return finalChartOptions;
    }
}
// Initialize Line Chart
new LineChart();
