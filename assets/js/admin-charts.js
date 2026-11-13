(function () {
  'use strict';

  var root = document.querySelector('[data-admin-charts]');
  var dataEl = document.getElementById('admin-chart-data');
  if (!root || !dataEl || typeof Chart === 'undefined') {
    return;
  }

  var data = JSON.parse(dataEl.textContent || '{}');
  var rows = data.rows || [];
  var labels = data.labels || {};
  var css = getComputedStyle(document.documentElement);
  var font = (css.getPropertyValue('--font-sans') || 'system-ui').trim();
  var muted = (css.getPropertyValue('--muted') || '#5d6b66').trim();
  var line = (css.getPropertyValue('--line') || '#dbe5df').trim();

  var CHANNELS = [
    { key: 'form', label: 'Formulario', color: '#1F6B5A' },
    { key: 'whatsapp', label: 'WhatsApp directo', color: '#34C26B' },
    { key: 'instagram', label: 'Instagram', color: '#D6458F' }
  ];

  var state = { range: 30, mode: 'stack' };
  var charts = {};

  Chart.defaults.font.family = font;
  Chart.defaults.color = muted;
  Chart.defaults.plugins.tooltip.backgroundColor = '#0F2424';
  Chart.defaults.plugins.tooltip.padding = 10;
  Chart.defaults.plugins.tooltip.cornerRadius = 10;
  Chart.defaults.plugins.tooltip.boxPadding = 4;
  Chart.defaults.plugins.legend.labels.usePointStyle = true;
  Chart.defaults.plugins.legend.labels.pointStyle = 'circle';

  function parseDay(str) {
    var p = String(str).split('-');
    return new Date(+p[0], +p[1] - 1, +p[2]);
  }

  function dayKey(d) {
    var m = String(d.getMonth() + 1).padStart(2, '0');
    var day = String(d.getDate()).padStart(2, '0');
    return d.getFullYear() + '-' + m + '-' + day;
  }

  var dayFmt = new Intl.DateTimeFormat('es-AR', { day: 'numeric', month: 'short' });

  function rangeDays() {
    var today = parseDay(data.today);
    var days = [];
    for (var i = state.range - 1; i >= 0; i--) {
      var d = new Date(today);
      d.setDate(today.getDate() - i);
      days.push(dayKey(d));
    }
    return days;
  }

  function aggregate() {
    var days = rangeDays();
    var first = days[0];
    var perDay = {};
    var totals = { form: 0, whatsapp: 0, instagram: 0 };
    var perSource = {};

    days.forEach(function (d) {
      perDay[d] = { form: 0, whatsapp: 0, instagram: 0 };
    });

    rows.forEach(function (r) {
      var day = r[0], canal = r[1], source = r[2], total = r[3];
      if (day < first || !perDay[day] || !(canal in totals)) {
        return;
      }
      perDay[day][canal] += total;
      totals[canal] += total;
      var label = labels[source] || source || 'Directo';
      perSource[label] = perSource[label] || { form: 0, whatsapp: 0, instagram: 0, sum: 0 };
      perSource[label][canal] += total;
      perSource[label].sum += total;
    });

    var sources = Object.keys(perSource).sort(function (a, b) {
      return perSource[b].sum - perSource[a].sum;
    });

    return { days: days, perDay: perDay, totals: totals, perSource: perSource, sources: sources };
  }

  var emptyPlugin = {
    id: 'emptyState',
    afterDraw: function (chart) {
      var hasData = chart.data.datasets.some(function (ds) {
        return ds.data.some(function (v) { return v > 0; });
      });
      if (hasData) {
        return;
      }
      var area = chart.chartArea;
      var ctx = chart.ctx;
      ctx.save();
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      ctx.fillStyle = muted;
      ctx.font = '500 14px ' + font;
      ctx.fillText('Sin datos en este período', (area.left + area.right) / 2, (area.top + area.bottom) / 2);
      ctx.restore();
    }
  };

  var centerTotalPlugin = {
    id: 'centerTotal',
    afterDraw: function (chart) {
      var meta = chart.getDatasetMeta(0);
      if (!meta.data.length) {
        return;
      }
      var total = chart.data.datasets[0].data.reduce(function (sum, v, i) {
        return chart.getDataVisibility(i) ? sum + v : sum;
      }, 0);
      if (!total) {
        return;
      }
      var x = meta.data[0].x, y = meta.data[0].y;
      var ctx = chart.ctx;
      ctx.save();
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      ctx.fillStyle = '#1A3A3A';
      ctx.font = '700 28px ' + (css.getPropertyValue('--font-display') || font).trim();
      ctx.fillText(String(total), x, y - 8);
      ctx.fillStyle = muted;
      ctx.font = '600 11px ' + font;
      ctx.fillText('CONTACTOS', x, y + 16);
      ctx.restore();
    }
  };

  function buildDaily(agg) {
    var isLine = state.mode === 'line';
    var datasets = CHANNELS.map(function (c) {
      return {
        label: c.label,
        data: agg.days.map(function (d) { return agg.perDay[d][c.key]; }),
        backgroundColor: isLine ? c.color + '22' : c.color,
        borderColor: c.color,
        borderWidth: isLine ? 2.5 : 0,
        borderRadius: isLine ? 0 : 6,
        borderSkipped: false,
        maxBarThickness: 28,
        fill: isLine,
        tension: 0.35,
        pointRadius: isLine ? 3 : 0,
        pointHoverRadius: 6,
        pointBackgroundColor: '#fff',
        pointBorderWidth: 2
      };
    });

    if (charts.daily) {
      charts.daily.destroy();
    }

    charts.daily = new Chart(document.getElementById('chart-daily'), {
      type: isLine ? 'line' : 'bar',
      data: {
        labels: agg.days.map(function (d) { return dayFmt.format(parseDay(d)); }),
        datasets: datasets
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
          legend: { position: 'top', align: 'end' },
          tooltip: {
            callbacks: {
              footer: function (items) {
                var sum = items.reduce(function (s, i) { return s + i.parsed.y; }, 0);
                return 'Total: ' + sum;
              }
            }
          }
        },
        scales: {
          x: {
            stacked: !isLine,
            grid: { display: false },
            ticks: { maxRotation: 0, autoSkip: true, maxTicksLimit: state.range > 30 ? 10 : 15 }
          },
          y: {
            stacked: !isLine,
            beginAtZero: true,
            grid: { color: line },
            border: { display: false },
            ticks: { precision: 0 }
          }
        }
      },
      plugins: [emptyPlugin]
    });
  }

  function buildChannels(agg) {
    var values = CHANNELS.map(function (c) { return agg.totals[c.key]; });
    if (charts.channels) {
      charts.channels.data.datasets[0].data = values;
      charts.channels.update();
      return;
    }
    charts.channels = new Chart(document.getElementById('chart-channels'), {
      type: 'doughnut',
      data: {
        labels: CHANNELS.map(function (c) { return c.label; }),
        datasets: [{
          data: values,
          backgroundColor: CHANNELS.map(function (c) { return c.color; }),
          borderColor: '#fff',
          borderWidth: 3,
          hoverOffset: 10
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '68%',
        layout: { padding: 8 },
        plugins: {
          legend: { position: 'bottom' },
          tooltip: {
            callbacks: {
              label: function (item) {
                var sum = item.dataset.data.reduce(function (s, v) { return s + v; }, 0);
                var pct = sum ? Math.round((item.parsed / sum) * 100) : 0;
                return ' ' + item.label + ': ' + item.parsed + ' (' + pct + '%)';
              }
            }
          }
        }
      },
      plugins: [centerTotalPlugin, emptyPlugin]
    });
  }

  function buildSources(agg) {
    var top = agg.sources.slice(0, 8);
    var datasets = CHANNELS.map(function (c) {
      return {
        label: c.label,
        data: top.map(function (s) { return agg.perSource[s][c.key]; }),
        backgroundColor: c.color,
        borderRadius: 6,
        borderSkipped: false,
        maxBarThickness: 22
      };
    });

    if (charts.sources) {
      charts.sources.data.labels = top;
      charts.sources.data.datasets.forEach(function (ds, i) { ds.data = datasets[i].data; });
      charts.sources.update();
      return;
    }

    charts.sources = new Chart(document.getElementById('chart-sources'), {
      type: 'bar',
      data: { labels: top, datasets: datasets },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', axis: 'y', intersect: false },
        plugins: {
          legend: { position: 'bottom' },
          tooltip: {
            filter: function (item) { return item.parsed.x > 0; }
          }
        },
        scales: {
          x: {
            stacked: true,
            beginAtZero: true,
            grid: { color: line },
            border: { display: false },
            ticks: { precision: 0 }
          },
          y: {
            stacked: true,
            grid: { display: false },
            border: { display: false },
            ticks: { color: '#24302c', font: { weight: 600 } }
          }
        }
      },
      plugins: [emptyPlugin]
    });
  }

  function render() {
    var agg = aggregate();
    buildDaily(agg);
    buildChannels(agg);
    buildSources(agg);
  }

  function bindSeg(attr, key, parse) {
    var buttons = root.querySelectorAll('[data-' + attr + ']');
    buttons.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var value = parse(btn.getAttribute('data-' + attr));
        if (state[key] === value) {
          return;
        }
        state[key] = value;
        buttons.forEach(function (b) { b.classList.toggle('is-active', b === btn); });
        render();
      });
    });
  }

  bindSeg('range', 'range', function (v) { return parseInt(v, 10); });
  bindSeg('mode', 'mode', function (v) { return v; });
  render();
})();
