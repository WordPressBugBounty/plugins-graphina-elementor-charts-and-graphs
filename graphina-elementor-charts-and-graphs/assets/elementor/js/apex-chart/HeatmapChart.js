import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Heatmap Charts
export default class HeatmapChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }
    

    // Setup handlers for heatmap chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            heatmap: (element) => this.observeChartElement(element, 'heatmap'),
        };
    }

    applyYAxisFormatter(chartOptions, extraData) {
        const prefix = extraData.yaxis_label_prefix ?? '';
        const postfix = extraData.yaxis_label_postfix ?? '';
        const series = chartOptions.series ?? [];

        chartOptions.yaxis = {
            labels: {
                formatter: function (val) {
                    const index = parseInt(val, 10);
                    const seriesName = series[index]?.name ?? val;
                    return prefix + seriesName + postfix;
                }
            }
        };
    }

    applyDataLabelFormatter(chartOptions, extraData) {

        let datalabelPreFix = extraData.chart_datalabel_prefix ?? '';
        let datalabelPostFix = extraData.chart_datalabel_postfix ?? '';
        if (!chartOptions.dataLabels) {
            chartOptions.dataLabels = {};
        }
        chartOptions.dataLabels.formatter = (val) => {
            if (extraData.string_format) {
                val = this.formatNumber(val, extraData.chart_label_pointer_number_for_label);
            }
            return datalabelPreFix + val + datalabelPostFix
        }
    }

    // Apply Y-axis label formatting
    applyYAxisFormatter(chartOptions, extraData, axisIndex = false) {
        const formatAxisLabels = (val, prefix, postfix, decimal, axisIndex) => {
            if (extraData.chart_yaxis_label_pointer) {
                return prefix + this.formatNumber(val, decimal) + postfix;
            } else if (extraData.yaxis_label_format && (axisIndex === 0 || axisIndex === false)) {
                return prefix + new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                    minimumFractionDigits: decimal,
                    maximumFractionDigits: decimal,
                }).format(val) + postfix;
            } else if (extraData.chart_opposite_yaxis_format_number && axisIndex === 1) {
                return prefix + new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                    minimumFractionDigits: decimal,
                    maximumFractionDigits: decimal,
                }).format(val) + postfix;
            }
            return prefix + val + postfix;
        };
    }


    getChartOptions(finalChartOptions, chartType,extraData,responsive_options,elementId) {
        if (chartType === 'heatmap') {
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

// Initialize HeatmapChart
window.graphinaHeatmapChart = new HeatmapChart();
