<!DOCTYPE html>
<html>
<head>
  <title>404 Not Found</title>
  <style>
    body {
  background-color: #f2f2f2;
  font-family: Arial, sans-serif;
  text-align: center;
}

.container {
  margin-top: 10%;
}

h1 {
  font-size: 10em;
  color: #333;
  margin-bottom: 0.2em;
}

p {
  font-size: 1.5em;
  color: #666;
  margin-top: 0;
}

a {
  color: #333;
  text-decoration: none;
  font-size: 1.2em;
}

a:hover {
  color: #007bff;
}

  </style>
</head>
<body>
  <div class="container">
    <h1>404</h1>
    <p>Oops! The page you're looking for is not found.</p>
    <a href="/">Go back to homepage</a>
    <?php
        die();
    ?>
  </div>
</body>
</html>
