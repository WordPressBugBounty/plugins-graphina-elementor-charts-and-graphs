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

    dateFormat(timestamp, showTime = false, showDate = false) {
        const date = new Date(timestamp);
        const pad = (n) => (n < 10 ? '0' + n : n);

        const day = pad(date.getDate());
        const month = pad(date.getMonth() + 1);
        const year = date.getFullYear();
        const hours = pad(date.getHours());
        const minutes = pad(date.getMinutes());

        let dateStr = showDate ? `${day}-${month}-${year}` : '';
        let timeStr = showTime ? `${hours}:${minutes}` : '';

        return showDate && showTime ? `${dateStr} ${timeStr}` : (dateStr || timeStr);
    }

    TimelineChartXaxisFormat(chartOptions, extraData) {
        const showTime = extraData.xaxis_show_time;
        const showDate = extraData.xaxis_show_date;

        chartOptions.xaxis.labels = chartOptions.xaxis.labels || {};
        chartOptions.xaxis.labels.formatter = (val) => {
            return this.dateFormat(val, showTime, showDate);
        };
    }
    applyDataLabelFormatter(chartOptions, extraData) {
        const showTime = extraData.xaxis_show_time;
        const showDate = extraData.xaxis_show_date;
        const datalabelPreFix = extraData.chart_datalabel_prefix ?? '';
        const datalabelPostFix = extraData.chart_datalabel_postfix ?? '';

        chartOptions.dataLabels = chartOptions.dataLabels || {};
        chartOptions.dataLabels.formatter = (val) => {
            if (Array.isArray(val) && val.length === 2) {
                const [start, end] = val;
                const diffMs = end - start;
                const days = Math.floor(diffMs / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diffMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
                return `${datalabelPreFix}${days} days ${hours} hours ${minutes} minutes${datalabelPostFix}`;
            }
            return datalabelPreFix + 'N/A' + datalabelPostFix;
        };
    }

    applyTooltipFormatter(chartOptions, extraData) {
        chartOptions.tooltip = chartOptions.tooltip || {};
        chartOptions.tooltip.custom = function ({ series, seriesIndex, dataPointIndex, w }) {
            const data = w.config.series[seriesIndex].data[dataPointIndex];
            const label = data.x || 'Task';

            const format = (timestamp) => {
                const date = new Date(timestamp);
                const day = String(date.getDate()).padStart(2, '0');
                const month = date.toLocaleString('en-US', { month: 'short' });
                const year = date.getFullYear();
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                return `${day} ${month} ${year} ${hours}:${minutes}`;
            };

            const [start, end] = data.y;

            return `
            <div style="padding: 8px;">
                <strong>${label}</strong><br/>
                ${format(start)} → ${format(end)}
            </div>
        `;
        };
    }


    getChartOptions(finalChartOptions, chartType, extraData,elementId) {
        finalChartOptions.yaxis.labels.formatter = function (vl){return vl}
        
        if (chartType === 'timeline') {
            finalChartOptions.chart = finalChartOptions.chart || {};
            finalChartOptions.xaxis = finalChartOptions.xaxis || {};
            finalChartOptions.plotOptions = {
                bar: {
                    horizontal: true,
                    rangeBarGroupRows: true,
                },
            };
            finalChartOptions.chart.events = {
                mounted: (chartContext, config) => {
                    const chartElement = document.querySelector(`.graphina-elementor-chart[data-element_id="${elementId}"]`);
                    if (chartElement) {
                        chartElement.style.height = '';
                    }
                },
            };

            this.TimelineChartXaxisFormat(finalChartOptions, extraData);
            this.applyTooltipFormatter(finalChartOptions, extraData);
            this.applyDataLabelFormatter(finalChartOptions, extraData);
        }

        return finalChartOptions;
    }
}

// Initialize TimelineChart
window.graphinaTimelineChart = new TimelineChart();