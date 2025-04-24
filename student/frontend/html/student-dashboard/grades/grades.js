const semCards = document.querySelectorAll('.sem-card');
const overlay = document.getElementById('gradeOverlay');
const overlayContent = document.querySelector('.overlay-content');
const overlayTitle = document.getElementById('overlayTitle');
const gradeDetails = document.getElementById('gradeDetails');

semCards.forEach(card => {
  card.addEventListener('click', () => {
    const sem = card.getAttribute('data-semester');
    overlayTitle.textContent = `Semester ${sem} Grades`;
    gradeDetails.innerHTML = `<p>Loading course and marksheet data for Semester ${sem}...</p>`;

    // Placeholder for future fetch
    setTimeout(() => {
      gradeDetails.innerHTML = `
        <p><strong>Course:</strong> Introduction to Programming</p>
        <p><strong>Grade:</strong> A</p>
        <p><strong>Course:</strong> Mathematics I</p>
        <p><strong>Grade:</strong> B+</p>
        <p><em>Marksheet download and detailed stats coming soon...</em></p>
      `;
    }, 1000);

    overlay.classList.add('active');
  });
});

function closeOverlay() {
  overlay.classList.remove('active');
}


//background animation
tsParticles.load("tsparticles", {
  fullScreen: {
    enable: true,
    zIndex: -1
  },
  particles: {
    number: {
      value: 60,
      density: {
        enable: true,
        area: 800
      }
    },
    color: {
      value: "#ffffff"
    },
    opacity: {
      value: 0.2
    },
    size: {
      value: 2
    },
    move: {
      enable: true,
      speed: 0.5,
      direction: "none",
      outMode: "bounce"
    },
    links: {
      enable: true,
      distance: 150,
      color: "#ffffff",
      opacity: 0.2,
      width: 1
    }
  },
  background: {
    color: "transparent"
  }
});