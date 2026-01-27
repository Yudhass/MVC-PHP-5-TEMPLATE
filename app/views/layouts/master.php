<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo isset($title) ? esc($title) : 'Application'; ?></title>
    
    <!-- Favicon -->
    <?php if (isset($favicon) && $favicon): ?>
        <link rel="shortcut icon" href="<?php echo esc($favicon); ?>">
    <?php endif; ?>
    
    <!-- Default CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Custom CSS Section -->
    <?php if (isset($css) && !empty($css)): ?>
        <?php if (is_array($css)): ?>
            <?php foreach ($css as $cssFile): ?>
                <link rel="stylesheet" href="<?php echo esc($cssFile); ?>">
            <?php endforeach; ?>
        <?php else: ?>
            <link rel="stylesheet" href="<?php echo esc($css); ?>">
        <?php endif; ?>
    <?php endif; ?>
    
    <!-- Inline Styles -->
    <?php if (isset($styles)): ?>
        <style>
            <?php echo $styles; ?>
        </style>
    <?php endif; ?>
</head>
<body>
    <!-- Include Navbar if exists -->
    <?php if (isset($navbar) && $navbar !== false): ?>
        <?php 
            $navbarFile = dirname(__FILE__) . '/../components/navbar.php';
            if (file_exists($navbarFile)) {
                include $navbarFile;
            }
        ?>
    <?php endif; ?>
    
    <!-- Include Sidebar if exists -->
    <?php if (isset($sidebar) && $sidebar !== false): ?>
        <?php 
            $sidebarFile = dirname(__FILE__) . '/../components/sidebar.php';
            if (file_exists($sidebarFile)) {
                include $sidebarFile;
            }
        ?>
    <?php endif; ?>
    
    <!-- Main Content Wrapper -->
    <div class="<?php echo isset($wrapperClass) ? esc($wrapperClass) : 'container'; ?>">
        <!-- Flash Message Display -->
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-<?php echo esc(isset($_SESSION['flash_message_type']) ? $_SESSION['flash_message_type'] : 'success'); ?> alert-dismissible fade show mt-3" role="alert">
                <?php echo esc($_SESSION['flash_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php 
                unset($_SESSION['flash_message']);
                unset($_SESSION['flash_message_type']);
            ?>
        <?php endif; ?>
        
        <!-- Main Content Section -->
        <?php if (isset($content)): ?>
            <?php echo $content; ?>
        <?php endif; ?>
    </div>
    
    <!-- Include Footer if exists -->
    <?php if (isset($footer) && $footer !== false): ?>
        <?php 
            $footerFile = dirname(__FILE__) . '/../components/footer.php';
            if (file_exists($footerFile)) {
                include $footerFile;
            }
        ?>
    <?php endif; ?>
    
    <!-- Default JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- Custom JS Section -->
    <?php if (isset($js) && !empty($js)): ?>
        <?php if (is_array($js)): ?>
            <?php foreach ($js as $jsFile): ?>
                <script src="<?php echo esc($jsFile); ?>"></script>
            <?php endforeach; ?>
        <?php else: ?>
            <script src="<?php echo esc($js); ?>"></script>
        <?php endif; ?>
    <?php endif; ?>
    
    <!-- Inline Scripts -->
    <?php if (isset($scripts)): ?>
        <script>
            <?php echo $scripts; ?>
        </script>
    <?php endif; ?>
</body>
</html>
