import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Mixed Charts
export default class MixedChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }
    

    // Setup handlers for Mixed chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            mixed: (element) => this.observeChartElement(element, 'mixed'),
        };
    }

    applyYAxisFormatter(chartOptions, extraData, axisIndex = false, chart_type= 'mixed') {

        const formatAxisLabels = (val, prefix, postfix, decimal) => {
            if (typeof decimal === 'number' && decimal > 0) {
                return prefix + new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                    minimumFractionDigits: decimal,
                    maximumFractionDigits: decimal,
                }).format(val) + postfix;
            }
            return prefix + val + postfix;
        };

        const updateYAxisLabels = (yaxis, prefix, postfix, decimal) => {
            if (!yaxis.labels) {
                yaxis.labels = {};
            }
            yaxis.labels.formatter = (val) => formatAxisLabels(val, prefix, postfix, decimal);
        };

        // Default to single y-axis
        if (axisIndex === false) {
            const prefix = extraData.yaxis_label_prefix || '';
            const postfix = extraData.yaxis_label_postfix || '';
            const decimal = typeof extraData.decimal_in_float === 'number' ? extraData.decimal_in_float : 0;

            updateYAxisLabels(chartOptions.yaxis, prefix, postfix, decimal);
        }
        // Multiple y-axes: axisIndex 0 or 1
        else if (axisIndex === 0 || axisIndex === 1) {
            const yaxis = chartOptions.yaxis[axisIndex];

            const prefix = axisIndex === 0
                ? (extraData.yaxis_label_prefix || '')
                : (extraData.chart_opposite_yaxis_label_prefix || '');

            const postfix = axisIndex === 0
                ? (extraData.yaxis_label_postfix || '')
                : (extraData.chart_opposite_yaxis_label_postfix || '');

            let decimal = 0;
            if (axisIndex === 0) {
                decimal = typeof extraData.decimal_in_float === 'number' ? extraData.decimal_in_float : 0;
            } else if (axisIndex === 1 && extraData.chart_opposite_yaxis_format_number === true) {
                decimal = typeof extraData.decimal_in_float === 'number' ? extraData.decimal_in_float : 0;
            }

            updateYAxisLabels(yaxis, prefix, postfix, decimal);
        }
    }



    getChartOptions(finalChartOptions, chartType,extraData,responsive_options,elementId) {
        if (chartType === 'mixed') {
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

// Initialize MixedChart
window.graphinaMixedChart = new MixedChart();
