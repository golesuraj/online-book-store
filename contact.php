<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            background: #28a745;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }
        button:hover {
            background: #218838;
        }
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
    <script>
        function validateForm() {
            var name = document.forms["contactForm"]["name"].value;
            var email = document.forms["contactForm"]["email"].value;
            var subject = document.forms["contactForm"]["subject"].value;
            var message = document.forms["contactForm"]["message"].value;
            var errorMsg = "";

            if (name == "") {
                errorMsg += "Name is required.\n";
            }
            if (email == "") {
                errorMsg += "Email is required.\n";
            } else {
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    errorMsg += "Invalid email format.\n";
                }
            }
            if (subject == "") {
                errorMsg += "Subject is required.\n";
            }
            if (message == "") {
                errorMsg += "Message is required.\n";
            }

            if (errorMsg != "") {
                alert(errorMsg);
                return false;
            }
            return true;
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Contact Us</h2>
    <form name="contactForm" action="submit_contact.php" method="POST" onsubmit="return validateForm()">
        <label>Name:</label>
        <input type="text" name="name" placeholder="Enter your name">

        <label>Email:</label>
        <input type="email" name="email" placeholder="Enter your email">

        <label>Subject:</label>
        <input type="text" name="subject" placeholder="Enter subject">

        <label>Message:</label>
        <textarea name="message" rows="5" placeholder="Enter your message"></textarea>

        <button type="submit">Send Message</button>
    </form>
</div>

</body>
</html>
