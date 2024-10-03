import { Chart } from "chart.js";
import { registerables } from "chart.js";
const CreateChart = (el, type, labels, data, label) => {
    Chart.register(...registerables);
    new Chart(el, {
        type,
        data: {
            labels,
            datasets: [{
            label,
            data,
            borderWidth: 1
            }]
        },
        options: {
            scales: {
            y: {
                beginAtZero: true
            }
            }
        }
    });
}

export default CreateChart;
