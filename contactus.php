<?php session_start();
/**
 * The MIT License (MIT)
 *
 * Copyright (c) [2025] [Predrag Rukavina https://www.phpsoftpro.com]
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
######################################################################
$metatitle = 'Example.Com';
######################################################################
$noreply = 'noreply@example.com';
######################################################################
$siteurl = 'https://www.example.com';
######################################################################
$myemail = 'admin@example.com';
######################################################################
######################################################################
$sitekey = '6LejAiYUAAAAAOLbB5vZn01_jRWYcAZL8y5ChgBm';
$seckey = '6LejAiYUAAAAAFChPP7JW09FzgA0Q6G13dFeShgs';
######################################################################
if (isset($_GET['ref'])) {
  if (isset($_POST['g-recaptcha-response'])) {
    $recaptcha = $_POST['g-recaptcha-response'];
  } else {
    echo "<div class='alert alert-primary'>reCAPTCHA validation failed.</div>";
    die();
  }
  if (!$recaptcha) {
    echo "<div class='alert alert-primary'>reCAPTCHA validation failed.</div>";
    die();
  }
  $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $seckey . "&response=" . $recaptcha . "");
  $getResponse = json_decode($response, true);
  if (intval($getResponse['success']) !== 1) {
    echo "<div class='alert alert-primary'>reCAPTCHA validation failed.</div>";
    die();
  }
  $ipse = $_SERVER['REMOTE_ADDR'];
  $first = $_POST['first'];
  $last = $_POST['last'];
  $gemail = $_POST['gemail'];
  $subject = $_POST['subject'];
  $message = $_POST['messages'];
  if (strlen($_POST['first']) < 2) {
    echo "<div class='alert alert-primary'>First name should be longer than 5 characters.</div>";
    die();
  }
  if (strlen($_POST['first']) > 200) {
    echo "<div class='alert alert-primary'>First name should be shorter than 200 characters.</div>";
    die();
  }
  if (strlen($_POST['last']) > 200) {
    echo "<div class='alert alert-primary'>Last name should be shorter than 200 characters.</div>";
    die();
  }
  if (strlen($_POST['subject']) > 200) {
    echo "<div class='alert alert-primary'>Subject should be shorter than 200 characters.</div>";
    die();
  }
  if (strlen($_POST['gemail']) < 5) {
    echo "<div class='alert alert-primary'>Email should be longer than 5 characters.</div>";
    die();
  }
  if (strlen($_POST['gemail']) > 200) {
    echo "<div class='alert alert-primary'>Email should be shorter than 200 characters.</div>";
    die();
  }
  if (strlen($_POST['messages']) < 5) {
    echo "<div class='alert alert-primary'>Message should be longer than 5 characters.</div>";
    die();
  }
  if (strlen($_POST['messages']) > 20000) {
    echo "<div class='alert alert-primary'>Message should be shorter than 20000 characters.</div>";
    die();
  }
  if (!filter_var($gemail, FILTER_VALIDATE_EMAIL)) {
    echo "<div class='alert alert-danger'>Please enter valid email address</div>";
    die();
  }
  $time = date("h:i A");
  $date = date("l, F jS, Y");
  $ip = $_SERVER['REMOTE_ADDR'];
  $header = 'MIME-Version: 1.0' . "\r\n";
  $header .= 'Content-type: text/html;charset=iso-8859-1' . "\r\n";
  $header .= "Return-Path: " . $metatitle . " <$myemail>\r\n";
  $header .= "From: $metatitle <$noreply>" . "\r\n";
  $header .= "Organization: " . $metatitle . " \r\n";
  $body = "<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='utf-8'>
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta name=viewport content='width=device-width, initial-scale=1' />
</head>
<body style='background:#e9e9e9'>
<div style='font-family: Segoe UI,Trebuchet MS,tahoma,sans-serif;background: #e9e9e9;font-size: 15px;color: #777;margin:22px;padding-left:15px;padding-right:15px;padding-bottom:15px;padding-top:5px;background:#fff'>
<div style='margin-bottom:20px;'>
<h2 style='font-size:20px;'>$metatitle</h2>
</div>
<div style='margin-bottom:20px;'>
Subject: $subject
</div>
<div style='margin-bottom:20px;'>
First Name: $first
</div>
<div style='margin-bottom:20px;'>
Last Name: $last
</div>
<div style='margin-bottom:20px;'>
Email Address: $gemail
</div>
<div style='margin-bottom:20px;'>
Time: $date at $time
</div>
<div style='margin-bottom:20px;'>
Ip Address: $ip
</div>
<div style='margin-bottom:20px;'>
Message: $message
</div>
<div style='margin-bottom:28px;'>
<a href=\"$siteurl\">$siteurl</a>
</div>
</div>
</body>
</html>";
  $sendemail = mail($myemail, $subject, $body, $header);
  if ($sendemail) {
    echo "<div class='alert alert-success'>Your message has been sent successfully</div>";
  } else {
    echo "<div class='alert alert-danger'>Mail failed</div>";
  }
  die();
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Feedback form by https://www.phpsoftpro.com">
  <title>Feedback</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <style>
    .container {
      max-width: 980px
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="<?php echo $siteurl; ?>">Feedback</a>
    </div>
  </nav>
  <div class="container my-5">
    <h1 class="h4">Feedback</h1>
    <form method="post" action="contactus.php?ref=1" class="message" id="sender">
      <div class="row">
        <div class="col-sm-6 mb-4">
          First Name*
          <input type="text" class="form-control" id="first" name="first" required>
        </div>
        <div class="col-sm-6 mb-4">
          Last Name
          <input type="text" class="form-control" id="last" name="last">
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6 mb-4">
          Email Address*
          <input type="email" class="form-control" id="gemail" name="gemail" required>
        </div>
        <div class="col-sm-6 mb-4">
          Subject
          <input type="text" class="form-control" id="subject" name="subject">
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 mb-4">
          Message*
          <textarea id="messages" name="messages" class="form-control" rows="4" required></textarea>
        </div>
      </div>
      <div class="row mt-2">
        <div class="col-sm-6 mb-4">
          <button type="submit" class="btn btn-primary">Send Message</button>
        </div>
        <div class="col-sm-6 mb-4">
          <script src="https://www.google.com/recaptcha/api.js"></script>
          <div class="recaheight">
            <div class="g-recaptcha mycaptcha" data-sitekey="<?php echo $sitekey; ?>"></div>
          </div>
        </div>
      </div>
    </form>
    <div class="row mt-2">
      <div class="col-sm-12 mb-2">
        <div class="loaders"></div>
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-sm-12 mb-2">
        <div id="msgs"> </div>
      </div>
    </div>
  </div>
  <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script>
    $(function () {
      $('#sender').submit(function (event) {
        $('.loaders').show();
        $.post('contactus.php?ref=1', $(this).serialize(),
          function (data) {
            $('#msgs').html(data);
            $("#sender").hide('slow');
            $(".loaders").hide('slow');
          });
        event.preventDefault();
      });
    });
  </script>
</body>

</html>