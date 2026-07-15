import GraphinaApexChartBase from './GraphinaApexChartBase';

export default class LineChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {};
    }
    
    setUpChartsHandler() {
        this.chartHandlers = {
            line: (element) => this.observeChartElement(element, 'line'),
        };
    }

    applyMarkerShapes(finalChartOptions) {
        const markers = finalChartOptions.markers || {};
        const markerShapes = markers.shape;

        if (!Array.isArray(markerShapes) || !Array.isArray(finalChartOptions.series)) {
            return;
        }

        const markerSizes = Array.isArray(markers.size) ? markers.size : [];
        const markerColors = Array.isArray(markers.colors) ? markers.colors : [];
        const markerStrokeColors = Array.isArray(markers.strokeColors) ? markers.strokeColors : [];
        const discreteMarkers = Array.isArray(markers.discrete) ? markers.discrete : [];

        finalChartOptions.series.forEach((series, seriesIndex) => {
            const shape = markerShapes[seriesIndex] || markerShapes[0] || 'circle';
            const data = Array.isArray(series.data) ? series.data : [];

            data.forEach((value, dataPointIndex) => {
                if (value === null || typeof value === 'undefined') {
                    return;
                }

                discreteMarkers.push({
                    seriesIndex,
                    dataPointIndex,
                    fillColor: markerColors[seriesIndex] ?? markerColors[0] ?? undefined,
                    strokeColor: markerStrokeColors[seriesIndex] ?? markerStrokeColors[0] ?? undefined,
                    shape,
                    size: markerSizes[seriesIndex] ?? markerSizes[0] ?? markers.size,
                });
            });
        });

        markers.discrete = discreteMarkers;
        markers.shape = markerShapes[0] || 'circle';
        finalChartOptions.markers = markers;
    }

    getChartOptions(finalChartOptions, chartType, extraData, elementId) {
        if (chartType === 'line') {
            this.applyMarkerShapes(finalChartOptions);

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
window.graphinaLineChart = new LineChart();
