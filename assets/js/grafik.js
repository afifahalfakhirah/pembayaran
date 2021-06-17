$(document).ready(function(){
    $.ajax({
        url: "grafik.php",
        success: function(data){
            data = JSON.parse(data);
            let label = []
            let user = []
            Object.entries(data).forEach(([key, item]) => {
                label.push(key)
                user.push(item)
            })

            renderChart(label, user)
        }
    });
})

function renderChart(label, user) {

    const data = {
        labels: label,
        datasets: [{
          label: "Pembayaran",
          backgroundColor: 'rgb(255, 99, 132)',
          borderColor: 'rgb(255, 99, 132)',
          data: user,
        }]
      };
      
    const config = {
        type: 'bar',
        data,
        options: {}
    };
    
    new Chart(
        document.getElementById('myChart'),
        config
    );
}



