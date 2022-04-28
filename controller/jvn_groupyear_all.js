document.addEventListener("DOMContentLoaded", () => {

    // let elemsitem = document.querySelectorAll(".nav-item");
  // elemsitem.forEach(el => {
    //   el.classList.remove("menu-open");
    // });
    let elemslink = document.querySelectorAll(".nav-link");
    elemslink.forEach(el => {
      el.classList.remove("active");
    });
    $("a[href='./jvn_groupyear_all.php']").addClass("active");
    
  get_reportData();
});

async function get_reportData() {

  let url = 'model/count_jvn_groupyear_all.php';

  let data = await fetch(url).then(res => res.json());
  
  let result = '';
  let chart_labels = [];
  let chart_datasetsN = [];
  let chart_datasetsY = [];
  let chart_datasetsNLL = [];

  data.forEach(d => {

    chart_labels.push(d.RECEIVE_YEAR);
    chart_datasetsN.push(d.N);
    chart_datasetsY.push(d.Y);
    chart_datasetsNLL.push(d.NLL);

    result += '<tr>';
    result += `<td>${d.RECEIVE_YEAR}</td>`;
    result += `<td>${d.N}</td>`;
    result += `<td>${d.Y}</td>`;
    result += `<td>${d.NLL}</td>`;
    result += `<td>${+d.N + +d.Y + +d.NLL}</td>`;
    result += '</tr>';
  });

  document.getElementById("tableBody").innerHTML = result;


  const labels = chart_labels;

  const chart_data = {
    labels: labels,
    datasets: [
      {
        backgroundColor: '#007bff',
        borderColor: '#007bff',
        data: chart_datasetsN
      }, 
      {
        backgroundColor: '#6c757d',
        borderColor: '#6c757d',
        data: chart_datasetsY
      },
      {
        backgroundColor: '#00bc8c',
        borderColor: '#00bc8c',
        data: chart_datasetsNLL
      }]
  };

  let ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
  };
  let mode = 'index';
  let intersect = true;

  const config = {
    type: 'bar',
    data: chart_data,
    options: {
        maintainAspectRatio: false,
        tooltips: {
            mode: mode,
            intersect: intersect
        },
        hover: {
            mode: mode,
            intersect: intersect
        },
        legend: {
            display: false
        },
        scales: {
            yAxes: [{
                gridLines: {
                    display: true,
                    lineWidth: '4px',
                    color: 'rgba(0, 0, 0, .2)',
                    zeroLineColor: 'transparent'
                },
                ticks: $.extend({
                    beginAtZero: true,
                    callback: function(value) {
                        if (value >= 1000) {
                            value /= 1000
                            value += 'k'
                        }
                        return '$' + value
                    }
                }, ticksStyle)
            }],
            xAxes: [{
                display: true,
                gridLines: {
                    display: false
                },
                ticks: ticksStyle
            }]
        },
        plugins:{
          legend: {
           display: false
          }
        }
    }
  };

  const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );

}