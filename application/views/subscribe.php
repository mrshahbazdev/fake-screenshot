<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activate Subscription</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('https://source.unsplash.com/1600x900/?technology,abstract') no-repeat center center fixed;
            background-size: cover;
        }
        .subscribe-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .subscribe-header {
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 25px;
        }
        .btn-primary {
            border-radius: 25px;
            padding: 10px 20px;
        }
        .alert {
            border-radius: 25px;
        }
    </style>
</head>
<body>
    <div class="subscribe-container">
        <div class="subscribe-header text-center">
            <h2>Activate Subscription</h2>
            <p class="text-muted">Enter the number of days to activate your subscription.</p>
        </div>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>
        <?php echo form_open('user/do_subscribe'); ?>
            <div class="form-group">
                <label for="days">Number of Days</label>
                <input type="number" class="form-control" id="days" name="days" placeholder="Number of Days" required>
                <?php echo form_error('days', '<small class="form-text text-danger">', '</small>'); ?>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Activate Subscription</button>
        <?php echo form_close(); ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
