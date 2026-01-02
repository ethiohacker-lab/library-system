<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

$pageTitle = "Home";
include 'includes/header.php';

// Get library statistics
$stats = $lib->getLibraryStats();
?>

<!-- Hero Section -->
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Welcome to University Library</h1>
                <p class="lead mb-4">Explore our vast collection of books, journals, and digital resources. A world of knowledge awaits you.</p>
                <div class="d-flex flex-wrap gap-3">
                    <?php if (isLoggedIn()): ?>
                        <?php if (isAdmin()): ?>
                            <a href="admin/dashboard.php" class="btn btn-light btn-lg px-4">
                                <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
                            </a>
                        <?php else: ?>
                            <a href="member/dashboard.php" class="btn btn-light btn-lg px-4">
                                <i class="fas fa-tachometer-alt me-2"></i>Member Dashboard
                            </a>
                        <?php endif; ?>
                        <a href="member/search_books.php" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-search me-2"></i>Search Books
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-light btn-lg px-4">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                        <a href="register.php" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-book-open fa-10x opacity-75"></i>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section -->
<div class="container py-5">
    <h2 class="text-center mb-5">Library at a Glance</h2>
    <div class="row">
        <div class="col-md-3 col-6 mb-4">
            <div class="stat-card bg-primary text-center">
                <i class="fas fa-book fa-3x mb-3"></i>
                <h3><?php echo number_format($stats['total_books']); ?></h3>
                <p class="mb-0">Total Books</p>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <div class="stat-card bg-success text-center">
                <i class="fas fa-users fa-3x mb-3"></i>
                <h3><?php echo number_format($stats['total_members']); ?></h3>
                <p class="mb-0">Active Members</p>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <div class="stat-card bg-warning text-center">
                <i class="fas fa-exchange-alt fa-3x mb-3"></i>
                <h3><?php echo number_format($stats['borrowed_books']); ?></h3>
                <p class="mb-0">Books Borrowed</p>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <div class="stat-card bg-info text-center">
                <i class="fas fa-clock fa-3x mb-3"></i>
                <h3><?php echo number_format($stats['overdue_books']); ?></h3>
                <p class="mb-0">Overdue Books</p>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="container py-5">
    <h2 class="text-center mb-5">Our Features</h2>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="feature-icon mb-4">
                        <i class="fas fa-search fa-4x text-primary"></i>
                    </div>
                    <h4 class="card-title">Advanced Search</h4>
                    <p class="card-text">Find books quickly with our powerful search engine. Filter by title, author, category, or ISBN.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="feature-icon mb-4">
                        <i class="fas fa-mobile-alt fa-4x text-success"></i>
                    </div>
                    <h4 class="card-title">Easy Management</h4>
                    <p class="card-text">Borrow, return, and renew books online. Track your borrowing history and due dates.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="feature-icon mb-4">
                        <i class="fas fa-bell fa-4x text-warning"></i>
                    </div>
                    <h4 class="card-title">Smart Notifications</h4>
                    <p class="card-text">Get reminders for due dates, reservation availability, and new arrivals.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popular Books Section -->
<div class="container py-5">
    <h2 class="text-center mb-5">Popular Books</h2>
    <div class="row">
        <?php if (!empty($stats['popular_books'])): ?>
            <?php foreach ($stats['popular_books'] as $book): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($book['author']); ?></h6>
                            <p class="card-text">
                                <span class="badge bg-primary">Borrowed <?php echo $book['borrow_count']; ?> times</span>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>No borrowing data available yet.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Quick Access -->
<?php if (isLoggedIn()): ?>
<div class="container py-5 bg-light rounded">
    <h2 class="text-center mb-4">Quick Access</h2>
    <div class="row justify-content-center">
        <div class="col-auto mb-2">
            <a href="member/search_books.php" class="btn btn-primary">
                <i class="fas fa-search me-2"></i>Search Books
            </a>
        </div>
        <div class="col-auto mb-2">
            <a href="member/my_borrowings.php" class="btn btn-success">
                <i class="fas fa-book-reader me-2"></i>My Borrowings
            </a>
        </div>
        <?php if (isAdmin()): ?>
        <div class="col-auto mb-2">
            <a href="admin/manage_books.php" class="btn btn-warning">
                <i class="fas fa-book me-2"></i>Manage Books
            </a>
        </div>
        <div class="col-auto mb-2">
            <a href="admin/reports.php" class="btn btn-info">
                <i class="fas fa-chart-bar me-2"></i>View Reports
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>