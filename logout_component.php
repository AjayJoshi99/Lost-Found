<?php
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../../index.php");
    exit();
}
?>
<button id="logoutBtn" class="logout-btn">Logout</button>

<div id="logoutDialog" class="dialog" style="display: none;">
    <div class="dialog-content">
        <p>Are you sure you want to logout?</p>
        <div class="dialog-buttons">
            <button id="confirmLogout" class="confirm-btn">Yes</button>
            <button id="cancelLogout" class="cancel-btn">No</button>
        </div>
    </div>
</div>

<script>
    document.getElementById('logoutBtn').onclick = function() {
        document.getElementById('logoutDialog').style.display = 'block';
    };

    document.getElementById('confirmLogout').onclick = function() {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '';
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'logout';
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    };

    document.getElementById('cancelLogout').onclick = function() {
        document.getElementById('logoutDialog').style.display = 'none';
    };
</script>

<style>
    .logout-btn {
        background-color: #f44336; 
        color: Black;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s, transform 0.2s;
    }

    .logout-btn:hover {
        background-color: #d32f2f; 
        transform: scale(1.05);
    }

    .dialog {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .dialog-content {
        background-color: black;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    .dialog-buttons {
        margin-top: 20px;
    }

    .confirm-btn, .cancel-btn {
        background-color: #4CAF50; 
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin: 0 5px;
        transition: background-color 0.3s, transform 0.2s;
    }

    .confirm-btn:hover {
        background-color: #45a049; 
        transform: scale(1.05);
    }

    .cancel-btn {
        background-color: #f44336; 
    }

    .cancel-btn:hover {
        background-color: #d32f2f; 
        transform: scale(1.05);
    }
</style>
