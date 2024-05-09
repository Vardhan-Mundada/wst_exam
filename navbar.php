<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Navbar styles */
.navbar {
    background-color: #333;
    color: #fff;
    padding: 10px 0;
}

.container-nav {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    font-size: 1.5rem;
}

.nav-links {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.nav-links li {
    display: inline;
    margin-right: 20px;
}

.nav-links li:last-child {
    margin-right: 0;
}

.nav-links li a {
    color: #fff;
    text-decoration: none;
}

.user-info {
    display: flex;
    align-items: center;
}

.user-info a {
    color: #fff;
    text-decoration: none;
    margin-left: 20px;
}

    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container-nav">
            <div class="logo">Your Logo</div>
            <ul class="nav-links">
                <li><a href="#">Option 1</a></li>
                <li><a href="#">Option 2</a></li>
                <li><a href="#">Option 3</a></li>
                <li><a href="#">Option 4</a></li>
            </ul>
        </div>
    </nav>
</body>
</html>
