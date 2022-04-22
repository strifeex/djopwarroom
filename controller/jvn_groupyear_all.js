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