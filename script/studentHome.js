document.addEventListener('DOMContentLoaded', () => {
  const toggleBtn = document.getElementById('toggleSidebar');
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('mainContent');

  toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('full');
  });

  document.getElementById('lostRequestLink').addEventListener('click', e => {
    e.preventDefault();
    loadView('views/lostRequest.php');
  });
  document.getElementById('Help').addEventListener('click', e => {
    e.preventDefault();
    loadView('views/Help.php');
  });
  document.getElementById('Home').addEventListener('click', e => {
    e.preventDefault();
    window.location.href = '../user/student_dashboard.php';
  });

document.getElementById('foundRequestLink').addEventListener('click', e => {
    e.preventDefault();
    loadView('views/FoundRequest.php');
  });

  function loadView(url) {
    fetch(url)
      .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.text();
      })
      .then(html => {
        mainContent.innerHTML = html;
      })
      .catch(err => {
        mainContent.innerHTML = `<p>Error loading content: ${err.message}</p>`;
      });
  }
});
