import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Scatter Charts
export default class ScatterChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }

    // Setup handlers for Scatter chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            scatter: (element) => this.observeChartElement(element, 'scatter'),
        };
    }
   
    getChartOptions(finalChartOptions, chartType, extraData, responsive_options, elementId) {
        if (chartType === 'scatter') {
            finalChartOptions.responsive = responsive_options
             // Add loaded event to remove fixed height
             finalChartOptions.chart.events = {
                mounted: (chartContext, config) => {
                    // More specific selector targeting only the chart container
                    const chartElement = document.querySelector(`.graphina-elementor-chart[data-element_id="${elementId}"]`);
                    if (chartElement) {
                        // Remove fixed height but keep min-height for proper rendering
                        chartElement.style.height = '';
                    }
                },
               
            };
        }
        return finalChartOptions;
    }
}

// Initialize ScatterChart
window.graphinaScatterChart = new ScatterChart();
