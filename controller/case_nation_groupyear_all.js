document.addEventListener("DOMContentLoaded", () => {

  let elemslink = document.querySelectorAll(".nav-link");
  elemslink.forEach(el => {
    el.classList.remove("active");
  });
  $("a[href='./case_nation_groupyear_all.php']").addClass("active");

  get_reportData();
});

async function get_reportData() {

  let url = 'model/case_nation_groupyear_all.php';

  let data = await fetch(url).then(res => res.json());
  
  let result = '';
  data.forEach(d => {
    let cols = Object.values(d);
    cols.shift();
    let sum = cols.reduce((previousValue, currentValue) => +previousValue + +currentValue);

    result += '<tr>';
    result += `<td>${d.RECEIVE_YEAR}</td>`;
    cols.forEach(e => {
      result += `<td>${+e}</td>`;
    });
    result += `<td>${sum}</td>`;
    result += '</tr>';
  });

  document.getElementById("tableBody").innerHTML = result;

}