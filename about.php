



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Online Book Store</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            line-height: 1.6;
            min-height: 100vh;
            position: relative;
        }

        .header {
            background-color: #2c3e50;
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 2rem;
            padding-bottom: 100px; /* Space for footer */
        }

        .about-content {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }

        h1, h2, h3 {
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }

        p {
            margin-bottom: 1rem;
            color: #555;
        }

        .highlight {
            color: #3498db;
            font-weight: bold;
        }

        .footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 1.5rem;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        .timeline {
            margin: 2rem 0;
            border-left: 3px solid #3498db;
            padding-left: 2rem;
        }

        .timeline-item {
            margin-bottom: 2rem;
            position: relative;
            opacity: 0;
            transform: translateX(-20px);
            transition: all 0.5s ease-in-out;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -2.5rem;
            top: 5px;
            width: 15px;
            height: 15px;
            background-color: #3498db;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>About Our Book Store</h1>
    </header>

    <div class="container">
        <div class="about-content">
            <h2>Welcome to Our Literary World</h2>
            <p>Founded in <span class="highlight">2024</span> by <span class="highlight">Suraj Gole</span> and <span class="highlight">Varadmohan Purkar</span>, our online bookstore is dedicated to providing readers with a seamless and enriching book-buying experience.</p>
            <p>Our mission is simple: to connect readers with their next favorite book, support new authors, and enhance the joy of reading.</p>

            <div class="timeline">
                <div class="timeline-item">
                    <h3>Our Humble Beginnings</h3>
                    <p>Started as a passion project to create a user-friendly online bookstore with a diverse collection.</p>
                </div>
                <div class="timeline-item">
                    <h3>Going Digital</h3>
                    <p>Launched our advanced web platform in 2024, making book shopping easier and more accessible for everyone.</p>
                </div>
                <div class="timeline-item">
                    <h3>Today's Achievement</h3>
                    <p>Providing thousands of books across various genres, with a seamless shopping cart and secure checkout process.</p>
                </div>
            </div>

            <h2>Our Core Values</h2>
            <ul>
                <li>Quality over quantity</li>
                <li>Customer-first approach</li>
                <li>Supporting new authors</li>
                <li>Preserving the joy of reading</li>
                <li>Innovating the online book shopping experience</li>
            </ul>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; <span id="year"></span> Online Book Store. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timelineItems = document.querySelectorAll('.timeline-item');
            timelineItems.forEach((item, index) => {
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                }, index * 200);
            });
            
            document.getElementById('year').textContent = new Date().getFullYear();
        });
    </script>
</body>
</html>
