<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'School Portal'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?php if (isset($cssFile)): ?>
        <!-- <link rel="stylesheet" href="assets/css/<?php echo $cssFile; ?>"> -->
        <link rel="stylesheet" href="../css/login.css">
    <?php endif; ?>
</head>
<body>