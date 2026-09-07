<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Quick Receipt</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body {
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            background: #f1f5f9; padding: 20px;
        }
        .auth-card {
            width: 100%; max-width: 440px;
            padding: 42px 36px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(15,23,42,.08);
            color: #1e293b;
        }
        .auth-logo {
            width: 60px; height: 60px; margin: 0 auto 18px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 14px; background: #2563eb; color: #fff; font-size: 24px;
        }
        .auth-card h2 { text-align: center; font-weight: 700; font-size: 22px; }
        .auth-card .sub { text-align: center; font-size: 13px; color: #64748b; margin: 6px 0 28px; }
        .field { margin-bottom: 18px; }
        .field label { font-size: 12px; font-weight: 600; color: #475569; display: block; margin-bottom: 7px; text-transform: uppercase; letter-spacing: .8px; }
        .input-wrap { position: relative; }
        .input-wrap i.icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 14px; }
        .input-wrap input {
            width: 100%; padding: 13px 44px 13px 42px;
            border-radius: 10px; border: 1px solid #cbd5e1;
            background: #fff; color: #1e293b; font-size: 14px;
            outline: none; transition: border .15s, box-shadow .15s;
        }
        .input-wrap input::placeholder { color: #94a3b8; }
        .input-wrap input:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,.15); }
        .toggle-pass { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; cursor: pointer; font-size: 14px; }
        .btn-submit {
            width: 100%; padding: 13px; margin-top: 6px;
            border: none; border-radius: 10px;
            background: #2563eb; color: #fff;
            font-size: 15px; font-weight: 600; letter-spacing: .4px;
            cursor: pointer; transition: transform .12s, background .15s;
        }
        .btn-submit:hover { background: #1d4ed8; transform: translateY(-1px); }
        .alert-error {
            background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c;
            padding: 11px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 18px;
        }
        .alert-success {
            background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d;
            padding: 11px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 18px;
        }
        .switch-link { text-align: center; margin-top: 22px; font-size: 13px; color: #64748b; }
        .switch-link a { color: #2563eb; text-decoration: none; font-weight: 600; }
        .switch-link a:hover { text-decoration: underline; }
        .form-text.text-danger, small { color: #dc2626 !important; font-size: 12px; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-logo"><i class="fa fa-user-plus"></i></div>
        <h2>Create Account</h2>
        <p class="sub">Join Quick Receipt to start generating receipts</p>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert-error"><i class="fa fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>
        <?php echo form_open('user/do_register'); ?>
            <div class="field">
                <label for="username">Username</label>
                <div class="input-wrap">
                    <i class="icon fa fa-user"></i>
                    <input type="text" id="username" name="username" placeholder="Choose a username" value="<?php echo set_value('username'); ?>" required>
                </div>
                <?php echo form_error('username', '<small>', '</small>'); ?>
            </div>
            <div class="field">
                <label for="email">Email</label>
                <div class="input-wrap">
                    <i class="icon fa fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo set_value('email'); ?>" required>
                </div>
                <?php echo form_error('email', '<small>', '</small>'); ?>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <i class="icon fa fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Create a password" required>
                    <i class="toggle-pass fa fa-eye" onclick="togglePass(this)"></i>
                </div>
                <?php echo form_error('password', '<small>', '</small>'); ?>
            </div>
            <button type="submit" class="btn-submit"><i class="fa fa-user-plus"></i>&nbsp; Create Account</button>
        <?php echo form_close(); ?>
        <p class="switch-link">Already have an account? <a href="<?php echo site_url('user/login'); ?>">Sign in</a></p>
    </div>
    <script>
        function togglePass(el) {
            var input = document.getElementById('password');
            var isPass = input.type === 'password';
            input.type = isPass ? 'text' : 'password';
            el.classList.toggle('fa-eye');
            el.classList.toggle('fa-eye-slash');
        }
    </script>
</body>
</html>
