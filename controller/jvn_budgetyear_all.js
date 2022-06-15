document.addEventListener("DOMContentLoaded", () => {

    let elemslink = document.querySelectorAll(".nav-link");
    elemslink.forEach(el => {
      el.classList.remove("active");
    });
    $("a[href='./jvn_budgetyear_all.php']").addClass("active");
    
  get_reportData();
});

async function get_reportData() {

  let url = 'model/count_jvn_budgetyear_all.php';

  let data = await fetch(url).then(res => res.json());
  
  let result = '';
  let chart_labels = [];
  let chart_datasetsN = [];
  let chart_datasetsY = [];
  let chart_datasetsNLL = [];

  data.forEach(d => {

    chart_labels.push(d.YEAR);
    chart_datasetsN.push(d.ENSURE);
    chart_datasetsY.push(d.CONTROL);
    chart_datasetsNLL.push(d.NOCONTROL);

    result += '<tr>';
    result += `<td>${d.YEAR}</td>`;
    result += `<td>${d.ENSURE}</td>`;
    result += `<td>${d.CONTROL}</td>`;
    result += `<td>${d.NOCONTROL}</td>`;
    result += `<td>${+d.TOTAL}</td>`;
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
                ticks: ticksStyle
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