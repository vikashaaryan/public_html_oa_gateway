$(function () {
  var e = {
    chart: {
      id: "widgest-chart-1",
      type: "area",
      height: 30,
      sparkline: { enabled: !0 },
      group: "widgest-chart-1",
      foreColor: "#adb0bb",
    },
    series: [
      {
        name: "",
        color: "#198754",
        data: [0, 150, 110, 240, 200, 200, 300, 200],
      },
    ],
    stroke: { curve: "straight", width: 2 },
    fill: {
      type: "gradient",
      gradient: {
        shadeIntensity: 0,
        inverseColors: !1,
        opacityFrom: 0.2,
        opacityTo: 0,
        stops: [0, 200],
      },
    },
    markers: { size: 0 },
    tooltip: {
      theme: "dark",
      fixed: { enabled: !0, position: "right" },
      x: { show: !1 },
    },
  };
  new ApexCharts(document.querySelector("#widgest-chart-1"), e).render();

  var e = {
      series: [
        { name: "San Francisco", data: [70, 90, 41, 67, 120, 43] },
        { name: "Diego", data: ["sat", "sun", "mon", "tu", "th", "fri"] },
      ],
      chart: {
        height: 300,
        type: "bar",
        foreColor: "#294DFF",
        toolbar: { show: !1 },
        stacked: !0,
      },
      colors: ["#294DFF", "#294DFF"],
      plotOptions: {
        bar: {
          borderRadius: [6],
          horizontal: !1,
          barHeight: "60%",
          columnWidth: "40%",
        },
      },
      stroke: { show: !1 },
      dataLabels: { enabled: !1 },
      legend: { show: !1 },
      grid: { show: !1 },
      yaxis: { tickAmount: 4 },
      xaxis: {
        categories: ["sat", "sun", "mon", "tu", "th", "fri"],
        axisTicks: { show: !1 },
      },
      tooltip: { theme: "dark", fillSeriesColor: !1, x: { show: !1 } },
    },
    a = new ApexCharts(document.querySelector("#most-visited"), e);
  a.render();

  var e = {
      series: [
        { name: "Footware", data: [2.5, 2.7, 3.2, 2.6, 1.9] },
        { name: "Fashionware", data: [-2.8, -1.1, -3, -1.5, -1.9] },
      ],
      chart: {
        height: 200,
        type: "bar",
        toolbar: { show: !1 },
        offsetX: -20,
        stacked: !0,
      },
      colors: ["#198754", "#0652DD"],
      plotOptions: {
        bar: {
          horizontal: !1,
          barHeight: "60%",
          columnWidth: "20%",
          borderRadius: [5],
          borderRadiusApplication: "end",
          borderRadiusWhenStacked: "all",
        },
      },
      stroke: { show: !1 },
      dataLabels: { enabled: !1 },
      legend: { show: !1 },
      grid: { show: !1 },
      yaxis: { min: -5, max: 5, tickAmount: 4 },
      xaxis: {
        categories: ["Jan", "Feb", "Mar", "Apr", "May"],
        axisTicks: { show: !1 },
      },
      tooltip: { theme: "dark" },
    },
    a = new ApexCharts(document.querySelector("#revenue-updates"), e);
  a.render();
  var e = {
      color: "#adb5bd",
      series: [38, 40, 25],
      labels: ["Expance", "Revenue", "Profit"],
      chart: { height: 230, type: "donut", foreColor: "#adb0bb" },
      plotOptions: {
        pie: {
          donut: {
            size: "89%",
            background: "transparent",
            labels: {
              show: !0,
              name: { show: !0, offsetY: 7 },
              value: { show: !1 },
              total: {
                show: !0,
                color: "#5A6A85",
                fontSize: "20px",
                fontWeight: "600",
                label: "$500,458",
              },
            },
          },
        },
      },
      dataLabels: { enabled: !1 },
      stroke: { show: !1 },
      legend: { show: !1 },
      colors: ["#0652DD", "#EAEFF4", "#198754"],
      tooltip: { theme: "dark", fillSeriesColor: !1 },
    },
    a = new ApexCharts(document.querySelector("#sales-overview"), e);
  a.render();
});

// widget 2

var e = {
  chart: {
    id: "widgest-chart-2",
    type: "area",
    height: 30,
    sparkline: { enabled: !0 },
    group: "widgest-chart-2",
    foreColor: "#adb0bb",
  },
  series: [
    {
      name: "",
      color: "#198754",
      data: [0, 500, 110, 240, 400, 200, 300, 200],
    },
  ],
  stroke: { curve: "straight", width: 2 },
  fill: {
    type: "gradient",
    gradient: {
      shadeIntensity: 0,
      inverseColors: !1,
      opacityFrom: 0.2,
      opacityTo: 0,
      stops: [0, 200],
    },
  },
  markers: { size: 0 },
  tooltip: {
    theme: "dark",
    fixed: { enabled: !0, position: "right" },
    x: { show: !1 },
  },
};
new ApexCharts(document.querySelector("#widgest-chart-2"), e).render();

// Widget 3

var e = {
  chart: {
    id: "widgest-chart-3",
    type: "area",
    height: 30,
    sparkline: { enabled: !0 },
    group: "widgest-chart-3",
    foreColor: "#adb0bb",
  },
  series: [
    {
      name: "",
      color: "#198754",
      data: [0, 300, 110, 240, 200, 200, 300, 200],
    },
  ],
  stroke: { curve: "straight", width: 2 },
  fill: {
    type: "gradient",
    gradient: {
      shadeIntensity: 0,
      inverseColors: !1,
      opacityFrom: 0.2,
      opacityTo: 0,
      stops: [0, 200],
    },
  },
  markers: { size: 0 },
  tooltip: {
    theme: "dark",
    fixed: { enabled: !0, position: "right" },
    x: { show: !1 },
  },
};
new ApexCharts(document.querySelector("#widgest-chart-3"), e).render();

// Widget 4

var e = {
  chart: {
    id: "widgest-chart-4",
    type: "area",
    height: 30,
    sparkline: { enabled: !0 },
    group: "widgest-chart-4",
    foreColor: "#adb0bb",
  },
  series: [
    {
      name: "",
      color: "#198754",
      data: [0, 80, 110, 100, 200, 200, 100, 50],
    },
  ],
  stroke: { curve: "straight", width: 2 },
  fill: {
    type: "gradient",
    gradient: {
      shadeIntensity: 0,
      inverseColors: !1,
      opacityFrom: 0.2,
      opacityTo: 0,
      stops: [0, 200],
    },
  },
  markers: { size: 0 },
  tooltip: {
    theme: "dark",
    fixed: { enabled: !0, position: "right" },
    x: { show: !1 },
  },
};
new ApexCharts(document.querySelector("#widgest-chart-4"), e).render();
