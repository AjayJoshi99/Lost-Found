document.addEventListener('DOMContentLoaded', () => {
  const toggleBtn = document.getElementById('toggleSidebar');
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('mainContent');

  toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('full');
  });

  document.getElementById('lostLink').addEventListener('click', e => {
    e.preventDefault();
    loadView('views/lostRequest.php');
  });

  document.getElementById('foundLink').addEventListener('click', e => {
    e.preventDefault();
    loadView('views/pendingRequest.php');
  });
    document.getElementById('adminHome').addEventListener('click', e => {
    e.preventDefault();
    window.location.href = '../admin/admin_dashboard.php';
  });

  document.getElementById('claimRequest').addEventListener('click', e => {
    e.preventDefault();
    loadView('views/claimRequest.php');
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
        mainContent.innerHTML = `<p class="text-danger">Error loading content: ${err.message}</p>`;
      });
  }
});
