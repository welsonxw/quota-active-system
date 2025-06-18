:root {
    --sidebar-width: 250px;
    --primary-color: #3498db;
    --primary-dark: #2980b9;
    --sidebar-bg: #2c3e50;
    --sidebar-text: #ecf0f1;
    --sidebar-hover: #34495e;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    display: flex;
    min-height: 100vh;
    background-color: #f5f7fa;
}

.sidebar {
    width: var(--sidebar-width);
    background-color: var(--sidebar-bg);
    color: var(--sidebar-text);
    height: 100vh;
    position: fixed;
    transition: all 0.3s;
    overflow-y: auto;
}

.sidebar-header {
    padding: 20px;
    background-color: rgba(0, 0, 0, 0.1);
    text-align: center;
}

.sidebar-header h3 {
    margin-bottom: 5px;
}

.sidebar-header p {
    font-size: 14px;
    color: #bdc3c7;
}

.sidebar-menu {
    padding: 20px 0;
}

.sidebar-menu h4 {
    padding: 10px 20px;
    color: #95a5a6;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.sidebar-menu ul {
    list-style: none;
}

.sidebar-menu li a {
    display: block;
    padding: 12px 20px;
    color: var(--sidebar-text);
    text-decoration: none;
    transition: all 0.3s;
}

.sidebar-menu li a:hover,
.sidebar-menu li a.active {
    background-color: var(--sidebar-hover);
    border-left: 4px solid var(--primary-color);
}

.sidebar-menu li a i {
    margin-right: 10px;
    font-size: 18px;
}

.main-content {
    flex: 1;
    margin-left: var(--sidebar-width);
    padding: 30px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.header h1 {
    color: #2c3e50;
}

.user-info {
    display: flex;
    align-items: center;
}

.user-info img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}

.logout-btn {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 15px;
    text-decoration: none;
    font-size: 14px;
}

.logout-btn:hover {
    background-color: #c0392b;
}

/* Rest of the student dashboard styles */
/* ... (same as previous CSS content) ... */