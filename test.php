<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .radio-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            vertical-align: middle;
        }

        .radio-label {
            margin-left: 10px;
        }


        .radio-icon {
            width: 24px;
            height: 24px;
        }

        .radio-label:hover {
            cursor: pointer;
        }
        svg {
            vertical-align: middle;
        }

    </style>
</head>
<body>
<div class="radio-container">
    <input type="radio" name="radio-group" id="public" class="radio-input">
    <label for="public" class="radio-label">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="radio-icon">
            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/>
            <polyline points="10 2 10 10 13 7 16 10 16 2"/>
        </svg>
        Public
    </label>
</div>
<div class="radio-container">
    <input type="radio" name="radio-group" id="private" class="radio-input">
    <label for="private" class="radio-label">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="radio-icon">
            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H10"/><path d="M20 15v7H6.5a2.5 2.5 0 0 1 0-5H20"/><rect width="8" height="5" x="12" y="6" rx="1"/><path d="M18 6V4a2 2 0 1 0-4 0v2"/>
        </svg>
        Private
    </label>
</div>
</body>
</html>
