<?php

session_start();

require_once('includes/configuration.php');

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Login interface</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/sign-in/">

    <!-- Bootstrap core CSS -->
<link href="https://getbootstrap.com/docs/4.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- Favicons -->
<link rel="apple-touch-icon" href="/docs/4.5/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="/docs/4.5/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="/docs/4.5/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="/docs/4.5/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="/docs/4.5/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
<link rel="icon" href="/docs/4.5/assets/img/favicons/favicon.ico">
<meta name="msapplication-config" content="/docs/4.5/assets/img/favicons/browserconfig.xml">
<meta name="theme-color" content="#563d7c">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.5/examples/sign-in/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
  <form role="form" action="" method="post">
<fieldset>
<div class="form-group col-lg-6">
<label>nom </label>
<input type="text" name="nom" class="form-control" placeholder="Nom ">
</div>
<div class="form-group col-lg-6">
<label>prenom </label>
<input type="text" name="prenom" class="form-control" placeholder="prenom ">
</div>
<div class="form-group col-lg-6">
<label>Email</label>
<input type="email" name="email" class="form-control" placeholder="Email">
</div>
<div class="form-group col-lg-6">
<label>Mot de passe</label>
<input type="password" name="motdepasse" class="form-control" placeholder="Mot de passe">
</div>
<div class="form-group col-lg-6">
<label>Répète-le</label>
<input type="password" name="motdepasse_confirme" class="form-control" placeholder="Répète-le">
</div>
<div class="col-sm-12">
<div class="checkbox">
</div>
</div>
<button class="btn btn-info btn-block" type="submit" name="inscription">S'inscrire</button>
<a href="login" class="btn btn-success btn-block">Retour à la connexion</a>
</fieldset>
</form>
</body>
</html>
