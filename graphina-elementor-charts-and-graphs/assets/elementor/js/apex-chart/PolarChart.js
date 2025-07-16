import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Polar Charts
export default class PolarChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }

    // Setup handlers for Polar chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            polar: (element) => this.observeChartElement(element, 'polar'),
        };
    }
   
    applyDataLabelFormatter(chartOptions,extraData,forminatorPercentage=false){
        let datalabelPreFix = extraData.chart_datalabel_prefix ?? '';
        let datalabelPostFix = extraData.chart_datalabel_postfix ?? '';
        if (!chartOptions.dataLabels) {
            chartOptions.dataLabels = {}; // Initialize dataLabels if it doesn't exist
        } 
        if(extraData.chart_data_label_pointer){
            chartOptions.tooltip.y = {
                formatter : (val ) => {
                    return  datalabelPreFix + this.formatNumber(val, extraData.chart_datalabel_decimals_in_float) + datalabelPostFix
                }
            };
        }else{
            chartOptions.tooltip.y = {
                formatter : (val ) => {
                    return datalabelPreFix + new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                        minimumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                        maximumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                    }).format(val) + datalabelPostFix;
                }
            }
        }
        if(chartOptions.dataLabels){
            chartOptions.dataLabels.formatter = (val,opts) => {
                if(forminatorPercentage){
                    let totals = opts.w.globals.seriesTotals.reduce((a, b) => {
                        return  a + b;
                    }, 0)
                    val = new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                        minimumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                        maximumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                    }).format(val/totals * 100);
                }
                if(extraData.chart_datalabels_format_showlabel){
                    let label = opts.w.globals.labels[opts.seriesIndex];
                    return label + "-" + datalabelPreFix + new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                        minimumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                        maximumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                    }).format(val) + datalabelPostFix ;
                }
                return datalabelPreFix + new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                    minimumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                    maximumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                }).format(val) + "%"  + datalabelPostFix ;
            }
            if ( extraData.chart_datalabels_format_showValue) {
                chartOptions.dataLabels.formatter = (val, opts) => {
                    val = opts.w.globals.series[opts.seriesIndex]; 
                    if(extraData.chart_number_format_commas && !extraData.chart_data_label_pointer){
                        val = new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                            minimumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                            maximumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                        }).format(val);
                    }
                    if (extraData.chart_data_label_pointer) {
                        val = datalabelPreFix + this.formatNumber(val, extraData.chart_datalabel_decimals_in_float) + datalabelPostFix;
                    }
                    if(extraData.chart_datalabels_format_showlabel){
                        let label = opts.w.globals.labels[opts.seriesIndex];
                        return label + "-" + datalabelPreFix + val + datalabelPostFix;
                    }
                    return datalabelPreFix + val + datalabelPostFix;
                };
            }
        }
    
    }
    getChartOptions(finalChartOptions, chartType, extraData, responsive_options, elementId) {
        if (chartType === 'polar') {
            finalChartOptions.labels = finalChartOptions.xaxis.categories
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

// Initialize PolarChart
window.graphinaPolarChart = new PolarChart();
