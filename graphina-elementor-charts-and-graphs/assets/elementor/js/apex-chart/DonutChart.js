import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Donut Charts
export default class DonutChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }
    

    // Setup handlers for Donut chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            donut: (element) => this.observeChartElement(element, 'donut'),
        };
    }

    applyDataLabelFormatter(chartOptions,extraData,forminatorPercentage=false){
        let datalabelPreFix = extraData.chart_datalabel_prefix ?? '';
        let datalabelPostFix = extraData.chart_datalabel_postfix ?? '';
        if (!chartOptions.dataLabels) {
            chartOptions.dataLabels = {}; // Initialize dataLabels if it doesn't exist
        } 
        if(extraData.chart_data_label_pointer){
            chartOptions.plotOptions.pie.donut.labels.total.formatter = (w) => {
                let total =   w.globals.seriesTotals.reduce((a, b) => {
                    return a + b
                }, 0) ;
                total = this.formatNumber(total, extraData.chart_datalabel_decimals_in_float);
                return datalabelPreFix + total + datalabelPostFix;
            }
            chartOptions.plotOptions.pie.donut.labels.value.formatter = (val) => {
                // Get the total sum of all values in the series
                val = this.formatNumber(val, extraData.chart_datalabel_decimals_in_float);
                return datalabelPreFix + val + datalabelPostFix;
            }
            chartOptions.tooltip.y = {
                formatter : (val ) => {
                    return datalabelPreFix + this.formatNumber(val, extraData.chart_datalabel_decimals_in_float) + datalabelPostFix
                }
            };
                
        }else{
            chartOptions.plotOptions.pie.donut.labels.value.formatter = (val) => {
                // Get the total sum of all values in the series
                val = new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                    minimumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                    maximumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                }).format(val);
                return datalabelPreFix + val + datalabelPostFix;
            }
            chartOptions.plotOptions.pie.donut.labels.total.formatter = (w) => {
                // Get the total sum of all values in the series
                let total =   w.globals.seriesTotals.reduce((a, b) => {
                    return a + b
                }, 0) ;
                total = new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                    minimumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                    maximumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                }).format(total);
                return datalabelPreFix + total + datalabelPostFix;
            };
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
                    val =  new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                        minimumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                        maximumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                    }).format(val)
                }
                if(extraData.chart_datalabels_format_showlabel){
                    let label = opts.w.globals.labels[opts.seriesIndex];
                    return label + "-" + datalabelPreFix + new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                        minimumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                        maximumFractionDigits: extraData.chart_datalabel_decimals_in_float,
                    }).format(val) + "%" + datalabelPostFix ;
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
                        return datalabelPreFix + this.formatNumber(val, extraData.chart_datalabel_decimals_in_float) + datalabelPostFix;
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
    
    // Apply legend tooltip formatting
    applyLegendTooltip(chartOptions, extraData,chart_type) {
        if (extraData.legend_show_series_value) {
            chartOptions.legend.formatter = (seriesName, opts) => {
                try {
                    seriesName = decodeURIComponent(seriesName);
                } catch (e) {
                    console.error('Invalid URI component:', seriesName);
                    seriesName = seriesName;
                }                
                let value = opts.w.globals.series[opts.seriesIndex];
                return `<div class="legend-info"><span>${seriesName}</span>:${value}</div>`;
            };
        }
    }

    getChartOptions(finalChartOptions, chartType, extraData, elementId) {
        if (chartType === 'donut') {
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

// Initialize DonutChart
window.graphinaDonutChart = new DonutChart();
