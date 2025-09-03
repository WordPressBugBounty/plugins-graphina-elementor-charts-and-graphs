import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Area Charts
export default class AreaChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }

    // Setup handlers for area chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            area: (element) => this.observeChartElement(element, 'area'),
        };
    }

    getChartOptions(finalChartOptions, chartType,extraData,elementId) {
        if (chartType === 'area') {
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

window.graphinaAreaChart = new AreaChart();
