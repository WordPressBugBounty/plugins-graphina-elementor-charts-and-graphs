import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Nestedcolumn Charts
export default class NestedcolumnChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
        this.secondaryChart = [];
        this.secondaryChartData = [];
    }
    
    // Setup handlers for nestedcolumn chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            nested_column: (element) => this.observeChartElement(element, 'bar'),
        };
    }
   

    getChartOptions(finalChartOptions, chartType, extraData, elementId) {
        if (chartType === 'nested_column') {
            finalChartOptions.plotOptions = {
                bar: {
                    distributed: true,
                    horizontal: true,
                    barHeight: '75%',
                    dataLabels: {
                        position: 'bottom'
                    }
                }
            };
            finalChartOptions.chart.id = `barYear-${elementId}`;
            finalChartOptions.chart.events = {
                dataPointSelection: (event, chartContext, config) => {
                    this.toggleSecondaryChartData(config.dataPointIndex, finalChartOptions, elementId);
                },
            };
            finalChartOptions.tooltip =  {
                x: {
                    show: true
                },
                y: {
                    formatter: function(val) {
                        let decimal = 0;
                        let prefix  = extraData.chart_tooltip_prefix_val
                        let postfix = extraData.chart_tooltip_postfix_val
                        if( extraData.tooltip_formatter ){
                            return prefix + new Intl.NumberFormat(window.gcfe_public_localize.locale_with_hyphen, {
                                minimumFractionDigits: decimal,
                                maximumFractionDigits: decimal,
                            }).format(val) + postfix;
                        }else{
                            return val
                        }
                    }
                }
            }
           
        }
        this.initSChart(elementId,finalChartOptions)
        return finalChartOptions;
    }

    updateSecondaryChartVisibility(elementId) {
        const secondChartElement = jQuery(`.nested_column-chart-two-${elementId}`)[0];
        const firstChartElement = jQuery(`.nested_column-chart-one-${elementId}`)[0];
        if (this.secondaryChartData.length === 0) {
            secondChartElement.classList.remove("active");
            firstChartElement.classList.remove("chart-quarter-activated")
            jQuery(`.nested_column-chart-two-${elementId}`).hide()
        } else {
            firstChartElement.classList.add("chart-quarter-activated")
            secondChartElement.classList.add("active");
            jQuery(`.nested_column-chart-two-${elementId}`).show()
        }
    }

    initSChart(elementId,finalChartOptions){
        const chartEle = jQuery(`.nested_column-chart-two-${elementId}`)
        this.secondaryChart[elementId] = new ApexCharts(chartEle[0], chartEle.data('second_chart_options'));
        this.secondaryChart[elementId].render();
        jQuery(`.nested_column-chart-two-${elementId}`).hide()
    }

    toggleSecondaryChartData(index, finalChartOptions, elementId) {
        
        // Retrieve the data of the selected index
        const currentData = finalChartOptions.series[0].data[index];
        // Check if the data is already in the secondary chart
        const existingIndex = this.secondaryChartData.findIndex(
            (data) => data.name === currentData.x
        );
    
        if (existingIndex === -1) {
            // Add the selected data to the secondary chart
            this.secondaryChartData.push({
                name: currentData.x,
                data: currentData.quarters,
                color: currentData.color, // Include color for visual consistency
            });
        } else {
            // Remove the data from the secondary chart
            this.secondaryChartData.splice(existingIndex, 1);
        }
    
        // Update the visibility of the secondary chart
        this.updateSecondaryChartVisibility(elementId);
        // Update the secondary chart with the new data
        if (this.secondaryChart[elementId]) {
            this.secondaryChart[elementId].updateSeries(this.secondaryChartData);
        }
    }
}

// Initialize NestedcolumnChart
window.graphinaNestedcolumnChart = new NestedcolumnChart();
