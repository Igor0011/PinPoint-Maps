<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Dropdown</title>
    <style>
        .custom-select {
            position: relative;
            display: inline-block;
            width: 200px; /* Adjust width as needed */
        }

        .select-selected {
            background-color: #ddd;
            padding: 10px;
            cursor: pointer;
            border: 1px solid #ccc;
            text-align: center;
            user-select: none; /* Prevent text selection */
            display: flex; /* Align items horizontally */
            align-items: center; /* Center items vertically */
            gap: 10px; /* Space between image and text */
        }

        .select-selected img {
            width: 20px; /* Set image width to 20px */
            height: 20px; /* Set image height to 20px */
        }

        .select-items {
            display: none; /* Initially hidden */
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            z-index: 99;
            width: 100%;
            box-sizing: border-box;
        }

        .select-items div {
            padding: 5px;
            cursor: pointer;
            display: flex; /* Use flexbox to align items */
            align-items: center; /* Center items vertically */
            gap: 10px; /* Space between image and text */
        }

        .select-items img {
            width: 20px; /* Set image width to 20px */
            height: 20px; /* Set image height to 20px */
        }

        .select-items div:hover {
            background-color: #ddd;
        }

        .select-show {
            display: block; /* Show dropdown */
        }
    </style>
</head>
<body>
    <div class="custom-select">
        <div class="select-selected">
            <img src="pin_images/pin1.png" alt="Selected Option">
            Select an option
        </div>
        <div class="select-items">
            <!-- <div data-value="1">
                <img src="pin_images/pin1.png" alt="Option 1">
                Option 1
            </div>
            <div data-value="2">
                <img src="pin_images/pin2.png" alt="Option 2">
                Option 2
            </div>
            <div data-value="3">
                <img src="pin_images/pin3.png" alt="Option 3">
                Option 3
            </div> -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selected = document.querySelector('.select-selected');
            const items = document.querySelector('.select-items');
            const options = items.querySelectorAll('div');

            selected.addEventListener('click', function() {
                console.log('Dropdown clicked');
                items.classList.toggle('select-show');
            });

            options.forEach(option => {
                option.addEventListener('click', function() {
                    console.log('Option selected:', this.innerHTML);
                    selected.innerHTML = this.innerHTML;
                    items.classList.remove('select-show');
                });
            });

            document.addEventListener('click', function(e) {
                if (!e.target.closest('.custom-select')) {
                    items.classList.remove('select-show');
                }
            });
        });
    </script>
</body>
</html>
