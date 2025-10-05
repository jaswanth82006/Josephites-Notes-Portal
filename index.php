<?php
// index.php

$root = __DIR__ .'/Ser';
$reqPath = isset($_GET['path']) ? $_GET['path'] : ' ';
$fullPath = realpath($root . DIRECTORY_SEPARATOR . $reqPath);

// Security check
if (!$fullPath || strpos($fullPath, $root) !== 0 || !is_dir($fullPath)) {
    $reqPath = '';
    $fullPath = $root;
}

function scanDirLevel($dir, $base) {
    $result = [];
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        $relPath = str_replace($base . DIRECTORY_SEPARATOR, '', $path);

        if (is_dir($path)) {
            $subItems = array_diff(scandir($path), ['.','..']);
            $count = count($subItems);
            $result[] = [
                "type" => "dir",
                "name" => $item,
                "path" => $relPath,
                "count" => $count
            ];
        } else {
            $ext = strtolower(pathinfo($item, PATHINFO_EXTENSION));
            $result[] = [
                "type" => "file",
                "name" => $item,
                "path" => $relPath,
                "ext"  => $ext,
                "size" => filesize($path)
            ];
        }
    }

    // Sort folders first
    usort($result, function($a, $b) {
        if ($a['type'] === $b['type']) {
            return strcasecmp($a['name'], $b['name']);
        }
        return $a['type'] === 'dir' ? -1 : 1;
    });

    return $result;
}

$items = scanDirLevel($fullPath, $root);

function isImage($ext) {
    $imageExts = ['jpg','jpeg','png','gif','webp','bmp'];
    return in_array($ext, $imageExts);
}

function getFileIcon($ext) {
    $icons = [
        "pdf" => "assets/p.png",
        "doc" => "https://cdn-icons-png.flaticon.com/512/281/281760.png",
        "docx" => "https://cdn-icons-png.flaticon.com/512/281/281760.png",
        "xls" => "https://cdn-icons-png.flaticon.com/512/732/732220.png",
        "xlsx" => "https://cdn-icons-png.flaticon.com/512/732/732220.png",
        "txt" => "https://cdn-icons-png.flaticon.com/512/3022/3022254.png",
        "default" => "https://cdn-icons-png.flaticon.com/512/833/833524.png"
    ];
    return isset($icons[$ext]) ? $icons[$ext] : $icons["default"];
}

$folderIcon = "assets/f.png"; // Folder PNG
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jaswanth</title>
   <link rel="stylesheet" href="style.css">
   <script src="script.js"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-content">
            <img src="assets/L2.png" alt="Logo" class="logo">
            <h1 class="navbar-title">Josephites Notes Portal </h1>
        </div>
    </nav>
        <div class="bremb">
            <img src="assets/L.png" alt="Loo" class="loo">
          <h5 style="margin-left: 16px">Department of Mechanical Engineering</h5>
  </div>
    <!-- Main Content -->
    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
    <?php
      $parts = $reqPath ? explode(DIRECTORY_SEPARATOR, $reqPath) : [];
      $depth = count($parts);

      echo '<a href="?">😃Home</a>';
      if ($depth > 1) {
          echo ' / ... ';
          echo '/ <a href="?path=' . urlencode($reqPath) . '">' . htmlspecialchars(end($parts)) . '</a>';
      } elseif ($depth === 1) {
          echo ' / <a href="?path=' . urlencode($reqPath) . '">' . htmlspecialchars($parts[0]) . '</a>';
      }
    ?>  </div>

        <!-- File Grid -->

        <div class="file-grid">
    <?php foreach ($items as $item): ?>
      <?php if ($item['type'] === 'dir'): ?>
       <div class="file-card folder" onclick="window.location.href='?path=<?= urlencode($item['path']) ?>';" style="cursor:pointer;">
          <div class="file-image folder-icon"> <img src="<?= $folderIcon ?>" alt="Lo" class="lo"></div>
               <div class="file-content">
                        <div class="file-name"><?= htmlspecialchars($item['name']) ?></div>
                        <div class="file-info"><?= $item['count'] ?> items</div>
                    </div>
                </div>                

      <?php else: ?>

          <?php if (isImage($item['ext'])): ?>
                 <div class="file-card image">

<img src="Ser/<?= htmlspecialchars($item['path']) ?>" alt="Lo" class="file-image">


                             <div class="file-content">
                        <div class="file-name"><?= htmlspecialchars($item['name']) ?></div>
                        <div class="file-info">              (<?= round($item['size']/1024,1) ?> KB)
       <br>    <a href="Ser/<?= htmlspecialchars($item['path']) ?>" target="_blank" class="btn">Open</a>
          <a href="Ser/<?= htmlspecialchars($item['path']) ?>" download class="btn">Download</a>
   </div>
                    </div>
                </div>         
                
                
                
                
                
   <?php else: ?>
                           <div class="file-card pdf">
<div class="file-image pdf-icon"> 
<img src="<?= getFileIcon($item['ext']) ?>" alt="Lo" class="lo">

</div>
                             <div class="file-content">
                        <div class="file-name"><?= htmlspecialchars($item['name']) ?></div>
                        <div class="file-info">              (<?= round($item['size']/1024,1) ?> KB)
         <br>  <a href="Ser/<?= htmlspecialchars($item['path']) ?>" target="_blank" class="btn">Open</a>
          <a href="Ser/<?= htmlspecialchars($item['path']) ?>" download class="btn">Download</a>
   </div>
                    </div>
                </div>         
          
          
  <?php endif; ?>



      <?php endif; ?>
    <?php endforeach; ?>
  </div>
                    <h4 style="margin-left: 16px">🛑Created by Jaswanth</h4>
         </div>
         <h5>for Feedback and Upload materials,</h5>
<a href="https://api.whatsapp.com/send?phone=9952635001&text=Feedback," target="_lank" class="telegramim_button telegramim_shadow telegramim_pulse" 


style="font-size:22px;margin:20px;max-width:400px;background:#1ebf19;box-shadow:1px 1px 5px #80f090;color:White;border-radius:60px;">
    
    
    Whatsapp</a> 
    

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 copyright belongs to Jaswanth. All rights reserved.</p>
    </footer>


    

<script type="text/javascript">
    
    
    
    (function() 
    
    
    {var script=document.createElement("script");
    
    
    script.type="text/javascript";script.async =true;
    
    
    
    
    script.src="//telegram.im/widget-button/index.php?id=@TrickyHackerPaytm";document.getElementsByTagName("head")[0].appendChild(script);})();</script> 
<?php
// File to store logs
$file = "device_logs.txt";

// Collect info
$time = date("Y-m-d H:i:s");
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$timestampNow = time();

// Read existing lines
$lines = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES) : [];

// Check last log for this user agent
$canLog = true;
foreach (array_reverse($lines) as $line) {
    if (strpos($line, $userAgent) !== false) {
        // Extract datetime from line (after serial number)
        preg_match("/\d+\.\s(.*?)\s-\s/", $line, $matches);
        if (!empty($matches[1])) {
            $lastTime = strtotime($matches[1]);
            if ($timestampNow - $lastTime < 300) { // 300 seconds = 5 min
                $canLog = false;
            }
        }
        break;
    }
}

if ($canLog) {
    $serial = count($lines) + 1;
    $data = $serial . ". " . $time . " - " . $userAgent . "\n";
    file_put_contents($file, $data, FILE_APPEND);

    
} else {
    }
?>
</body>
</html>