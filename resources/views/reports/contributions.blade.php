<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>Contribution Chart</title>

  <script src="https://code.jquery.com/jquery-2.1.3.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.1/Chart.min.js"></script>

</head>
<body>
    <canvas id="contributions" width="400" height="400"></canvas>

    <script>
        var ctx = document.getElementById("contributions").getContext("2d");

        $.ajax({
            url: "/reports/contributions.json",
            dataType: "json",
            type: "GET",
            success: function(response){
                var data = {
                    labels: response.users,
                    datasets: [
                    {
                        data: response.commits
                    }]
                };

                new Chart(ctx).Bar(data, {});
            }
        });

    </script>
</body>
</html>