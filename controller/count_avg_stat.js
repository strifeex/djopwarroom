document.addEventListener("DOMContentLoaded", () => {

  let elemslink = document.querySelectorAll(".nav-link");
  elemslink.forEach(el => {
    el.classList.remove("active");
  });
  $("a[href='./count_avg_stat.php']").addClass("active");

  get_reportData();
});

async function get_reportData() {

  let url = 'model/count_avg_stat.php';

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