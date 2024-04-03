// Income Line Chart
const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec']; 
let clientlbls = [{monthname: "Jan",clientnum: "0"},{monthname: "Feb",clientnum: "0"},{monthname: "Mar",clientnum: "0"},
                  {monthname: "Apr",clientnum: "0"},{monthname: "May",clientnum: "0"},{monthname: "June",clientnum: "0"},
                  {monthname: "July",clientnum: "0"},{monthname: "Aug",clientnum: "0"},{monthname: "Sept",clientnum: "0"},
                  {monthname: "Oct",clientnum: "0"},{monthname: "Nov",clientnum: "0"},{monthname: "Dec",clientnum: "0"},];
let leadlbls = [{monthname: "Jan",leadnum: "0"},{monthname: "Feb",leadnum: "0"},{monthname: "Mar",leadnum: "0"},
                  {monthname: "Apr",leadnum: "0"},{monthname: "May",leadnum: "0"},{monthname: "June",leadnum: "0"},
                  {monthname: "July",leadnum: "0"},{monthname: "Aug",leadnum: "0"},{monthname: "Sept",leadnum: "0"},
                  {monthname: "Oct",leadnum: "0"},{monthname: "Nov",leadnum: "0"},{monthname: "Dec",leadnum: "0"},];

  // Push properties from mnthclients to clientlbls
  if (! clientlbls.includes(mnthclients)) {
    for (const clientnum of mnthclients){
        clientlbls.push(clientnum)
      }
  }
 // Remove duplicate monthnames from clientlbls       
 function getUniqueListBy(clientlbls, key) {
  return [...new Map(clientlbls.map(item => [item[key], item])).values()]
}
const clientlblsnew = getUniqueListBy(clientlbls, 'monthname');

// Push properties from mnthleads to leadlbls
if (! leadlbls.includes(mnthleads)) {
  for (const leadnum of mnthleads){
      leadlbls.push(leadnum)
    }
}
// Remove duplicate monthnames from leadlbls       
function getUniqueListBy(leadlbls, key) {
return [...new Map(leadlbls.map(item => [item[key], item])).values()]
}
const leadlblsnew = getUniqueListBy(leadlbls, 'monthname');

// Remove key "monthname:" from clientlblsnew
for (var i = 0, len = clientlblsnew.length; i < len; i++) {
  delete clientlblsnew[i].monthname;
}    
// Remove key "monthname:" from clientlblsnew
for (var i = 0, len = leadlblsnew.length; i < len; i++) {
    delete leadlblsnew[i].monthname;
  }           
// Dump object array into cllbls array and feed it to chartjs
let cllbls = [];
  for (i of clientlblsnew) {
    cllbls.push(...Object.values(i))
  }
// Dump object array into ldlbls array and feed it to chartjs
let ldlbls = [];
  for (i of leadlblsnew) {
    ldlbls.push(...Object.values(i))
  }

console.log(cllbls);
console.log(ldlbls);

new Chart(document.getElementById("activityChart"), {
  type: "bar",
  data: {
    labels: labels,
    datasets: [
      {
        label: "Clients",
        data: cllbls,
        backgroundColor: [
          "rgba(255, 99, 132, 0.2)",
        ],
        borderColor: [
          "rgb(255, 99, 132)",
        ],
        borderWidth: 1,
      },
      {
        label: "Leads",
        data: ldlbls,
        backgroundColor: [
          "rgba(153, 102, 255, 0.2)",
        ],
        borderColor: [
          "rgba(153, 102, 255)",
        ],
        borderWidth: 1,
      },
    ],
  },
  options: {
    responsive: true,
    layout: {
      padding: {
        bottom: 5,
        top: 30,
        left: 5,
        right: 5,
      },
    },
    plugins: {
      legend: {
        display: true,
      },
    },
  },
});
