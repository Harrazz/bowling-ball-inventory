<!-- <?php
session_start();
?> -->

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bowling navbar</title>
    <link rel="stylesheet" href="../navbar_file/navbar.css">
</head>

<body>
    <div class="sidebar" id="sidebar">
        <ul class="nav">
            <li class="nav-item toggle-item">
                <a class="nav-link" href="#" id="sidebarToggle">
                    <span class="icon">☰</span>
                    <span class="sidebar-title">Bowling Ball Inventory</span>
                </a>
            </li>

            <li class="nav-item"><a class="nav-link" href="../php/homepage.php"><span
                        class="icon">🏠</span><span>Homepage</span></a></li>
            <li class="nav-item"><a class="nav-link" href="../php/products.php"><span
                        class="icon">📦</span><span>Products</span></a></li>

            <!-- only admin can view this -->
            <?php if ($_SESSION['usersRole'] == 'Admin'): ?>
                <li class="nav-item"><a class="nav-link" href="../php/users.php"><span
                            class="icon">🧑‍💼</span><span>Users</span></a></li>
            <?php endif; ?>

            <li class="nav-item"><a class="nav-link" href="../php/suppliers.php"><span
                        class="icon">🚚</span><span>Suppliers</span></a></li>

            <li class="nav-item"><a class="nav-link" href="../php/orders.php"><span
                        class="icon">🛒</span><span>Orders</span></a></li>

            <!-- logout with popup -->
            <li class="nav-item"><a class="nav-link" href="../php/logout.php"
                    onclick="return confirm('Are you sure you want to logout?');"><span
                        class="icon">🚪</span><span>Logout</span></a></li>
        </ul>

    </div>

    <!-- navbar function -->
    <script>
        // Apply saved state when page loads
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            document.getElementById('sidebar').classList.add('collapsed');
        }

        // collapse & expand function
        document.getElementById('sidebarToggle').addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('sidebar').classList.toggle('collapsed');

            // save current navabr state
            const isCollapsed = document.getElementById('sidebar').classList.contains('collapsed');
            localStorage.setItem('sidebar-collapsed', isCollapsed)
        });

        // link active
        document.addEventListener('DOMContentLoaded', () => {
            const currentPage = window.location.pathname.split('/').pop();
            document.querySelectorAll('.nav-link').forEach(link => {
                if (link.getAttribute('href').split('/').pop() === currentPage) {
                    link.classList.add('active');
                }
            })
        })
    </script>

</body>

</html>