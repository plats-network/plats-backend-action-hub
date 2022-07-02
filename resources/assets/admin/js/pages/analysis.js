$(document).ready(function () {
    const analysisController = new AnalysisControls();
});

class AnalysisControls {
    constructor() {
        this._initCustomLegendBarChart();
        // this._initSalesStocksCharts();
        // this._initTopLabel();
    }
      _initSalesStocksCharts() {
    if (document.getElementById('largeLineChart1')) {
      this._largeLineChart1 = ChartsExtend.LargeLineChart('largeLineChart1', {
        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Today'],
        datasets: [
          {
            label: 'New users',
            data: [23, 24, 26, 30, 27],
            icons: ['arrow-top', 'arrow-top', 'arrow-top', 'arrow-top', 'arrow-bottom'],
            borderColor: Globals.primary,
            pointBackgroundColor: Globals.primary,
            pointBorderColor: Globals.primary,
            pointHoverBackgroundColor: Globals.foreground,
            pointHoverBorderColor: Globals.primary,
            borderWidth: 2,
            pointRadius: 2,
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
            pointHoverRadius: 5,
            fill: false,
            datalabels: {
              align: 'end',
              anchor: 'end',
            },
          },
        ],
      });
    }

    if (document.getElementById('largeLineChart2')) {
      this._largeLineChart2 = ChartsExtend.LargeLineChart('largeLineChart2', {
        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Today'],
        datasets: [
          {
            label: 'Stock',
            data: [44, 49, 45, 33, 52],
            icons: ['arrow-top', 'arrow-top', 'arrow-bottom', 'arrow-bottom', 'arrow-top'],
            borderColor: Globals.secondary,
            pointBackgroundColor: Globals.secondary,
            pointBorderColor: Globals.secondary,
            pointHoverBackgroundColor: Globals.foreground,
            pointHoverBorderColor: Globals.secondary,
            borderWidth: 2,
            pointRadius: 2,
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
            pointHoverRadius: 5,
            fill: false,
            datalabels: {
              align: 'end',
              anchor: 'end',
            },
          },
        ],
      });
    }
  }

  // Top label input select2
  _initTopLabel() {
    jQuery('#selectTopLabel').select2({minimumResultsForSearch: Infinity, placeholder: ''});
  }

      // Sales chart with the custom legend
  _initCustomLegendBarChart() {
    if (document.getElementById('customLegendBarChart')) {
      const ctx = document.getElementById('customLegendBarChart').getContext('2d');
      this._customLegendBarChart = new Chart(ctx, {
        type: 'bar',
        options: {
          cornerRadius: parseInt(Globals.borderRadiusMd),
          plugins: {
            crosshair: false,
            datalabels: {display: false},
          },
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            yAxes: [
              {
                stacked: true,
                gridLines: {
                  display: true,
                  lineWidth: 1,
                  color: Globals.separatorLight,
                  drawBorder: false,
                },
                ticks: {
                  beginAtZero: true,
                  stepSize: 200,
                  min: 0,
                  max: 800,
                  padding: 20,
                },
              },
            ],
            xAxes: [
              {
                stacked: true,
                gridLines: {display: false},
                barPercentage: 0.5,
              },
            ],
          },
          legend: false,
          legendCallback: function (chart) {
            const legendContainer = chart.canvas.parentElement.parentElement.querySelector('.custom-legend-container');
            legendContainer.innerHTML = '';
            const legendItem = chart.canvas.parentElement.parentElement.querySelector('.custom-legend-item');
            for (let i = 0; i < chart.data.datasets.length; i++) {
              var itemClone = legendItem.content.cloneNode(true);
              var total = chart.data.datasets[i].data.reduce(function (total, num) {
                return total + num;
              });
              itemClone.querySelector('.text').innerHTML = chart.data.datasets[i].label.toLocaleUpperCase();
              itemClone.querySelector('.value').innerHTML = total;
              itemClone.querySelector('.value').style = 'color: ' + chart.data.datasets[i].borderColor + '!important';
              itemClone.querySelector('.icon-container').style = 'border-color: ' + chart.data.datasets[i].borderColor + '!important';
              itemClone.querySelector('.icon').style = 'color: ' + chart.data.datasets[i].borderColor + '!important';
              itemClone.querySelector('.icon').setAttribute('data-acorn-icon', chart.data.icons[i]);
              itemClone.querySelector('a').addEventListener('click', (event) => {
                event.preventDefault();
                const hidden = chart.getDatasetMeta(i).hidden;
                chart.getDatasetMeta(i).hidden = !hidden;
                if (event.currentTarget.classList.contains('opacity-50')) {
                  event.currentTarget.classList.remove('opacity-50');
                } else {
                  event.currentTarget.classList.add('opacity-50');
                }
                chart.update();
              });
              legendContainer.appendChild(itemClone);
            }
            new AcornIcons().replace();
          },
          tooltips: {
            enabled: false,
            custom: function (tooltip) {
              var tooltipEl = this._chart.canvas.parentElement.querySelector('.custom-tooltip');
              if (tooltip.opacity === 0) {
                tooltipEl.style.opacity = 0;
                return;
              }
              tooltipEl.classList.remove('above', 'below', 'no-transform');
              if (tooltip.yAlign) {
                tooltipEl.classList.add(tooltip.yAlign);
              } else {
                tooltipEl.classList.add('no-transform');
              }
              if (tooltip.body) {
                var chart = this;
                var index = tooltip.dataPoints[0].index;
                var datasetIndex = tooltip.dataPoints[0].datasetIndex;
                var icon = tooltipEl.querySelector('.icon');
                var iconContainer = tooltipEl.querySelector('.icon-container');
                iconContainer.style = 'border-color: ' + tooltip.labelColors[0].borderColor + '!important';
                icon.style = 'color: ' + tooltip.labelColors[0].borderColor + ';';
                icon.setAttribute('data-acorn-icon', chart._data.icons[datasetIndex]);
                new AcornIcons().replace();
                tooltipEl.querySelector('.text').innerHTML = chart._data.datasets[datasetIndex].label.toLocaleUpperCase();
                tooltipEl.querySelector('.value').innerHTML = chart._data.datasets[datasetIndex].data[index];
                tooltipEl.querySelector('.value').style = 'color: ' + tooltip.labelColors[0].borderColor + ';';
              }
              var positionY = this._chart.canvas.offsetTop;
              var positionX = this._chart.canvas.offsetLeft;
              tooltipEl.style.opacity = 1;
              tooltipEl.style.left = positionX + tooltip.dataPoints[0].x - 75 + 'px';
              tooltipEl.style.top = positionY + tooltip.caretY + 'px';
            },
          },
        },
        data: {
          labels: ['Ba Trieu', 'Hang Bai', 'Duy Tan', 'Legend'],
          datasets: [
            {
              label: 'Participants',
              backgroundColor: 'rgba(' + Globals.primaryrgb + ',0.1)',
              borderColor: Globals.primary,
              borderWidth: 2,
              data: [213, 434, 315, 367, 289, 354, 242],
            },
            {
              label: 'Participants Today',
              backgroundColor: 'rgba(' + Globals.secondaryrgb + ',0.1)',
              borderColor: Globals.secondary,
              borderWidth: 2,
              data: [30, 50, 30, 30, 40],
            },
          ],
          icons: ['user', 'star'],
        },
      });
      this._customLegendBarChart.generateLegend();
    }
  }


}
