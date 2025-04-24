/* attendance.js */
document.addEventListener('DOMContentLoaded', () => {
    const charts = document.querySelectorAll('.chart');
  
    charts.forEach(canvas => {
      const ctx = canvas.getContext('2d');
      const attended = parseInt(canvas.dataset.attended);
      const total = parseInt(canvas.dataset.total);
      const percentage = (attended / total) * 100;
  
      new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['Attended', 'Missed'],
          datasets: [{
            data: [attended, total - attended],
            backgroundColor: ['orange', '#444'],
            borderWidth: 0
          }]
        },
        options: {
          cutout: '70%',
          plugins: {
            legend: { display: false },
            tooltip: { enabled: true }
          }
        }
      });
    });
  });
  
  function toggleDetails(card) {
    card.classList.toggle('active');
  }
  
  const overallCanvas = document.getElementById("overallChart");
  if (overallCanvas) {
    const courseData = JSON.parse(overallCanvas.dataset.courses);
  
    const labels = courseData.map(c => c.label);
    const data = courseData.map(c => c.attended);
    const totalClasses = courseData.map(c => c.total);
    
    const colors = [
        "#39FF14",  // Neon Green
        "#FFA500",  // Neon Orange
        "#FFFF33",  // Neon Yellow
        "#FF00FF",  // Optional: Neon Pink
        "#00FFFF"   // Optional: Neon Cyan
      ];
      
    new Chart(overallCanvas, {
      type: "doughnut",
      data: {
        labels: labels,
        datasets: [{
          data: data,
          backgroundColor: colors.slice(0, data.length),
          borderWidth: 2,
          borderColor: "#111",
        }]
      },
      options: {
        cutout: "65%",
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              color: "#fff",
              boxWidth: 14,
              padding: 15
            }
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                const i = context.dataIndex;
                return `${labels[i]}: ${data[i]}/${totalClasses[i]} classes`;
              }
            }
          }
        }
      }
    });
  }
  