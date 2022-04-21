document.addEventListener("DOMContentLoaded", () => {
  get_reportData();
});

async function get_reportData() {

  let url = 'model/count_jvn_groupyear_all.php';

  let data = await fetch(url).then(res => res.json());
  
  let result = '';

  data.forEach(d => {
    result += '<tr>';
    result += `<td>${d.RECEIVE_YEAR}</td>`;
    result += `<td>${d.N}</td>`;
    result += `<td>${d.Y}</td>`;
    result += `<td>${d.NLL}</td>`;
    result += `<td>${+d.N + +d.Y + +d.NLL}</td>`;
    result += '</tr>';
  });

  document.getElementById("tableBody").innerHTML = result;

}