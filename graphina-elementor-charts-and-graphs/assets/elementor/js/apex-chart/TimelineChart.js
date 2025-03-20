import GraphinaApexChartBase from './GraphinaApexChartBase';

// Child class specifically for Timeline Charts
export default class TimelineChart extends GraphinaApexChartBase {
    constructor() {
        super();
        this.observer = {}; // For IntersectionObserver
    }

    // Setup handlers for timeline chart type
    setUpChartsHandler() {
        this.chartHandlers = {
            timeline: (element) => this.observeChartElement(element, 'timeline'),
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
    

    TimelineChartXaxisFormat(chartOptions,extraData){
        const showTime = extraData.xaxis_show_time
        const showDate = extraData.xaxis_show_date
        chartOptions.xaxis.labels.formatter = (val) => {
            val = this.dateFormat(val,showTime,showDate);
            return val;
        }
    }
    applyDataLabelFormatter(chartOptions, extraData) {
        const showTime = extraData.xaxis_show_time;
        const showDate = extraData.xaxis_show_date;
        let datalabelPreFix = extraData.chart_datalabel_prefix ?? '';
        let datalabelPostFix = extraData.chart_datalabel_postfix ?? '';
    
        if (!chartOptions.dataLabels) {
            chartOptions.dataLabels = {}; // Initialize dataLabels if it doesn't exist
        }
    
        chartOptions.dataLabels.formatter = (val) => {
            // Check if val is an array (indicating a range)
            if (Array.isArray(val) && val.length === 2) {
                let [startTimestamp, endTimestamp] = val;
        
                // Calculate the difference in milliseconds
                let diffMs = endTimestamp - startTimestamp;
        
                // Convert milliseconds to time components
                let diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));
                let diffHours = Math.floor((diffMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let diffMinutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
        
                // Return formatted duration
                return `${diffDays} days ${diffHours} hours ${diffMinutes} minutes`;
            } else {
                // Check if val is a valid number
                if (typeof val !== "number" || isNaN(val)) {
                    console.warn("Invalid value for data label:", val);
                    return datalabelPreFix + "N/A" + datalabelPostFix;
                }
        
                // Format single timestamp with both date and time
                return datalabelPreFix + this.dateFormat(val, true, true) + datalabelPostFix;
            }
        };
        
    }
    
    
    getChartOptions(finalChartOptions, chartType,extraData,responsive_options) {
        if (chartType === 'timeline') {
            finalChartOptions.xaxis.type = 'datetime'
            finalChartOptions.plotOptions = {
                bar: {
                    horizontal: true
                }
            }
            finalChartOptions.responsive = responsive_options
        }
        this.TimelineChartXaxisFormat(finalChartOptions,extraData);
        return finalChartOptions;
    }
}

// Initialize TimelineChart
new TimelineChart();
