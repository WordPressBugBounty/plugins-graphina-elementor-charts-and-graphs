import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Candle Charts
export default class CandleChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }

    // Setup handlers for Candle chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            candle: (element) => this.observeChartElement(element, 'candle'),
        };
    }

   
    dateFormat(timestamp, isTime = false, isDate = false) {
        let dateSeparator = '-';
        let date = new Date(timestamp);
        let hours = date.getHours();
        let minutes = "0" + date.getMinutes();
        let day = date.getDate();
        let month = date.getMonth() + 1;
        let year = date.getFullYear()
        return (isDate ? (day + dateSeparator + month + dateSeparator + year) : '') + (isDate && isTime ? ' ' : '') + (isTime ? (hours + ':' + minutes.substr(-2)) : '');
    }

    candleChartXaxisFormat(chartOptions,extraData){
        const showTime = extraData.xaxis_show_time
        const showDate = extraData.xaxis_show_date
        
        let prefix  = ''
        let postfix = ''
        if(extraData.xaxis_label_prefix_show){
            prefix  = extraData.xaxis_label_prefix
            postfix = extraData.xaxis_label_postfix
        }
        chartOptions.xaxis.labels.formatter = (val) => {
            val = prefix + this.dateFormat(val,showTime,showDate) + postfix;
            return val
        }
    }
    getChartOptions(finalChartOptions, chartType,extraData,responsive_options,elementId) {
        if (chartType === 'candle') {
            finalChartOptions.xaxis.type = 'datetime';
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
        this.candleChartXaxisFormat(finalChartOptions,extraData)
        return finalChartOptions;
    }

}

// Initialize CandleChart
window.graphinaCandleChart = new CandleChart();
