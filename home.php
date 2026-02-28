<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Map Instructions</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .container {
            max-width: 800px;
            margin: auto;
            overflow: auto;
        }
    </style>
</head>

<body>
    <?php require 'inc/navbar.php'; ?>
    <div class="container">
        <h1>How to Use the Web Map</h1>

        <p>Welcome to the web map! Here’s a guide to help you get started:</p>

        <ul>
            <li><strong>Adding Pins:</strong>
                <p>To place a pin on the map, double-click on the desired location. A new pin will appear at that spot.</p>
            </li>

            <li><strong>Customizing Pins:</strong>
                <p>After placing a pin, you’ll be prompted to enter a name and select the pin type. Each pin type represents different categories, such as "Police Patrol" or "Radar," to help you organize the information effectively.</p>
            </li>

            <li><strong>Viewing and Sharing:</strong>
                <p>Pins are saved to a shared database, making them visible to all users. This allows for collaborative monitoring and sharing of important information.</p>
            </li>

            <li><strong>Managing Pins:</strong>
                <ul>
                    <li><strong>Approval:</strong>
                        <p>Other users can review and approve pins if they can confirm the information is accurate. This helps ensure the reliability of the data displayed.</p>
                    </li>
                    <li><strong>Editing:</strong>
                        <p>Users can edit the name and type of existing pins. This feature allows for updates or corrections to reflect the most current information.</p>
                    </li>
                    <li><strong>Deleting:</strong>
                        <p>Users also have the ability to delete pins if they are no longer relevant or if they were placed incorrectly.</p>
                    </li>
                </ul>
            </li>

            <li><strong>Pin Types:</strong>
                <p>Select from various pin types to categorize the information you’re sharing. This helps in organizing and filtering the pins based on their purpose.</p>
            </li>
        </ul>

        <p>By utilizing these features, you can contribute to a dynamic and accurate map that reflects real-time information and enhances collaborative efforts.</p>
    </div>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>