<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>Contribution Chart</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.1/Chart.min.js"></script>
</head>
<body>
    <canvas id="contributions"></canvas>

    <script>
        var ctx = document.getElementById("contributions").getContext("2d"),
            contributionsChart = new Chart(ctx).Bar(data, {});

    </script>
</body>
</html>