document.addEventListener("DOMContentLoaded", () => {

  let elemslink = document.querySelectorAll(".nav-link");
  elemslink.forEach(el => {
    el.classList.remove("active");
  });
  $("a[href='./count_avg_stat.php']").addClass("active");
  
  selectyear();
});

async function selectyear() {

  $("#loading").show();

  let { servertime } = await fetch('Model/checkServerDateTime.php')
  .then(res => res.json());
  
  let currentTime = moment(servertime, 'YYYY-MM');
  let beginningTime = moment(START_MONTHLY,'YYYY-MM');
  let month_diff = currentTime.diff(beginningTime, 'months');
  
  let result = '';
  for (let i = 0; i <= month_diff; i++) {
    let value = moment(START_MONTHLY, 'YYYY-MM').add(i, 'months').format('YYYY-MM');
    let text = moment(START_MONTHLY, 'YYYY-MM').add(i, 'months').add(543, 'years').format('MMMM YYYY');
    result += `<option value="${value}">${text}</option>`;
  }

  document.querySelector('#report_monthly').innerHTML = result;
  document.querySelector('#report_monthly').value = currentTime.format('YYYY-MM');

  const selectElement = document.querySelector('#report_monthly');

  selectElement.addEventListener('change', (event) => {
    get_reportData(document.querySelector('#report_monthly').value);
  });

  $("#loading").hide();
  get_reportData(currentTime.format('YYYY-MM'));
}

async function get_reportData(report_year) {

  let url = `model/count_avg_stat.php?report_year=${report_year}`;

  let data = await fetch(url).then(res => res.json());
  console.log(data);
  
  let result = '';
  data.forEach(d => {
    result += '<tr>';
    result += `<td>${d.unit}</td>`;
    result += `<td>${Math.floor(d.male)}</td>`;
    result += `<td>${Math.floor(d.female)}</td>`;
    result += `<td>${Math.floor(+d.male) + Math.floor(+d.female)}</td>`;
    result += '</tr>';
  });

  document.getElementById("tableBody").innerHTML = result;

}