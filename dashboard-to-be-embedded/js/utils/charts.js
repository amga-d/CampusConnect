import ApexCharts from 'apexcharts';

export function createActivityChart(element) {
  const options = {
    series: [{
      name: 'Activity',
      data: [31, 40, 28, 51, 42, 109, 100]
    }],
    chart: {
      height: 350,
      type: 'area',
      toolbar: {
        show: false
      },
      animations: {
        enabled: true,
        easing: 'easeinout',
        speed: 800,
        animateGradually: {
          enabled: true,
          delay: 150
        },
        dynamicAnimation: {
          enabled: true,
          speed: 350
        }
      }
    },
    colors: ['#6366F1'],
    fill: {
      type: 'gradient',
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.7,
        opacityTo: 0.3,
        stops: [0, 90, 100]
      }
    },
    stroke: {
      curve: 'smooth',
      width: 3
    },
    xaxis: {
      categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
    },
    tooltip: {
      theme: 'dark',
      x: {
        show: false
      }
    }
  };

  return new ApexCharts(element, options);
}

export function createEngagementDonut(element) {
  const options = {
    series: [44, 55, 13],
    chart: {
      type: 'donut',
      height: 200
    },
    colors: ['#6366F1', '#EC4899', '#10B981'],
    labels: ['Posts', 'Comments', 'Shares'],
    plotOptions: {
      pie: {
        donut: {
          size: '70%'
        }
      }
    },
    legend: {
      position: 'bottom'
    },
    responsive: [{
      breakpoint: 480,
      options: {
        chart: {
          width: 200
        },
        legend: {
          position: 'bottom'
        }
      }
    }]
  };

  return new ApexCharts(element, options);
}