<!doctype html>
<html lang="en">

<?session_start(); // Pastikan sesi dimulai
include('controller/middleware.php');?>
 

<head>
    <?php include('header.php') ?>
</head>

<body>
    <?php include('navbar.php') ?>
        
    <?php 
        include('database/Music.php'); 
        $data = new Music();
    ?>

   
    <?php include('by_genre.php'); ?>    

    <?php include('hotsong.php'); ?>

   <?php include('explore.php'); ?>

 

    <?php include('player.php'); ?>

    <?php include('footer.php'); ?>
</body>

</html>
