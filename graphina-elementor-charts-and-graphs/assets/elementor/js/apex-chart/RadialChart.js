import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Radial Charts
export default class RadialChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }

    // Setup handlers for Radial chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            radial: (element) => this.observeChartElement(element, 'radial'),
        };
    }

    RadialChartDatalabelsFormat(chartOptions, extraData) {
        const prefix = extraData.chart_datalabel_prefix;
        const postfix = extraData.chart_datalabel_postfix;
        if(extraData.string_format){
            chartOptions.plotOptions.radialBar.dataLabels.total.formatter = (w) => {
                let total =   w.globals.seriesTotals.reduce((a, b) => {
                    return a + b
                }, 0) ;
                total = this.formatNumber(total, extraData.chart_label_pointer_number_for_label);
                return prefix + total + postfix;
            }
            chartOptions.plotOptions.radialBar.dataLabels.value.formatter = (val) => {
                // Get the total sum of all values in the series
                val = this.formatNumber(val, extraData.chart_label_pointer_number_for_label);
                return prefix + val + postfix;
            }
            chartOptions.yaxis.labels.formatter = (val) => {
                return prefix + this.formatNumber(val, extraData.chart_label_pointer_number_for_label) + postfix
            };
        }else{
            chartOptions.plotOptions.radialBar.dataLabels.value.formatter = (val) => {
                // Get the total sum of all values in the series
                val = new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                    minimumFractionDigits: extraData.chart_label_pointer_number_for_label,
                    maximumFractionDigits: extraData.chart_label_pointer_number_for_label,
                }).format(val);
                return prefix + val + postfix;
            }
            chartOptions.plotOptions.radialBar.dataLabels.total.formatter = (w) => {
                // Get the total sum of all values in the series
                let total =   w.globals.seriesTotals.reduce((a, b) => {
                    return a + b
                }, 0) ;
                total = new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                    minimumFractionDigits: extraData.chart_label_pointer_number_for_label,
                    maximumFractionDigits: extraData.chart_label_pointer_number_for_label,
                }).format(total);
                return prefix + total + postfix;
            };
             chartOptions.yaxis.labels.formatter = (val) => {
                return prefix + new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                    minimumFractionDigits: extraData.chart_label_pointer_number_for_label,
                    maximumFractionDigits: extraData.chart_label_pointer_number_for_label,
                }).format(val) + postfix; 
            };
        }
    }
   
    getChartOptions(finalChartOptions, chartType, extraData, responsive_options, elementId) {
        if (chartType === 'radial') {
            finalChartOptions.labels = finalChartOptions.xaxis.categories
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
        this.RadialChartDatalabelsFormat(finalChartOptions,extraData)
        return finalChartOptions;
    }
}

// Initialize RadialChart
window.graphinaRadialChart = new RadialChart();
