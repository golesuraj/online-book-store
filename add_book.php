<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px;
        }

        h2 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5em;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        form {
            background: rgba(255, 255, 255, 0.95);
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }

        form:hover {
            transform: translateY(-5px);
        }

        label {
            display: block;
            margin: 15px 0 8px;
            color: #333;
            font-weight: 600;
            font-size: 1.1em;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input:focus, textarea:focus {
            border-color: #667eea;
            box-shadow: 0 0 8px rgba(102, 126, 234, 0.3);
            outline: none;
        }

        input[type="file"] {
            padding: 10px;
            background: #f8f9fa;
            border: 2px dashed #667eea;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            font-size: 1.1em;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: bold;
        }

        button:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            background: linear-gradient(45deg, #764ba2, #667eea);
        }

        .file-input-container {
            position: relative;
            overflow: hidden;
        }

        .file-input-label {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .file-input-label:hover {
            background: #5555ff;
        }

        .file-name {
            margin-left: 10px;
            color: #666;
            font-style: italic;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .invalid {
            animation: shake 0.4s ease;
            border-color: #ff4444 !important;
        }
    </style>
</head>
<body>
    <h2>📚 Add a New Book</h2>
    <form action="insert_book.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <label>Title:</label>
        <input type="text" name="title" id="title" required>
        
        <label>Author:</label>
        <input type="text" name="author" id="author" required>
        
        <label>Price ($):</label>
        <input type="number" step="0.01" name="price" id="price" required>
        
        <label>Book Cover:</label>
        <div class="file-input-container">
            <label class="file-input-label">
                📸 Upload Image
                <input type="file" name="image" accept="image/*" required hidden>
            </label>
            <span class="file-name" id="fileName">No file chosen</span>
        </div>

        <label>Description:</label>
        <textarea name="description" id="description" required></textarea>

        <button type="submit" name="submit">➕ Add Book</button>
    </form>

    <script>
        // File name display
        document.querySelector('input[type="file"]').addEventListener('change', function(e) {
            const fileName = document.getElementById('fileName');
            fileName.textContent = this.files[0] ? this.files[0].name : 'No file chosen';
        });

        // Form validation
        function validateForm() {
            let isValid = true;
            const inputs = document.querySelectorAll('input, textarea');
            
            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    input.classList.add('invalid');
                    isValid = false;
                    setTimeout(() => input.classList.remove('invalid'), 1000);
                }
            });

            // Custom price validation
            const price = document.getElementById('price');
            if (price.value <= 0) {
                price.classList.add('invalid');
                isValid = false;
                setTimeout(() => price.classList.remove('invalid'), 1000);
            }

            return isValid;
        }

        // Input validation on typing
        document.querySelectorAll('input, textarea').forEach(input => {
            input.addEventListener('input', () => {
                if (input.checkValidity()) {
                    input.style.borderColor = '#667eea';
                }
            });
        });

        // Add floating label effect
        document.querySelectorAll('input, textarea').forEach(element => {
            element.addEventListener('focus', () => {
                element.previousElementSibling.style.color = '#667eea';
                element.previousElementSibling.style.transform = 'translateY(-5px)';
            });
            
            element.addEventListener('blur', () => {
                element.previousElementSibling.style.color = '#333';
                element.previousElementSibling.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>