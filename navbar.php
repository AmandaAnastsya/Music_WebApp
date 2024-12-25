<!-- Navbar -->
<?php include('header.php') ?>
<header class="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a href="index.php" class="navbar-logo">Musiik.</a>
        
        <div class="navbar-nav">
            <a href="favorite.php" class="favorite-link">
                <i data-feather="star" class="favorite-icon"></i> Favorite
            </a>
        </div>

        <!-- btn Profile -->
        <button class="control-btn Profile" id="profileBtn">
            <i data-feather="user"></i>
            <span>Profile</span>
        </button>
        
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <ul>
                <li><a href="user_info.php">User Information</a></li>
                <li><a href="edit_profile.php">Edit Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>



<script>
    document.getElementById('profileBtn').addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        // Toggle visibilitas sidebar
        if (sidebar.style.display === 'block') {
            sidebar.style.display = 'none';
        } else {
            sidebar.style.display = 'block';
        }
    });
</script>