import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for DistributeColumn Charts
export default class DistributeColumnChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }
    

    // Setup handlers for DistributeColumn chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            distributed_column: (element) => this.observeChartElement(element, 'distributed_column'),
        };
    }

   
    getChartOptions(finalChartOptions, chartType, extraData, elementId) {
        if (chartType === 'distributed_column') {
            finalChartOptions.chart.type = 'bar'
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

// Initialize DistributeColumnChart
window.graphinaDistributeColumnChart = new DistributeColumnChart();
