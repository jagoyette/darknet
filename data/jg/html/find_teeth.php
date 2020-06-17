<?php

$darknet_dir = "/home/jgoyette/darknet/darknet/";
$darknet_exe = "/home/jgoyette/darknet/darknet/darknet";
$darknet_data = "/home/jgoyette/data/maximus300/maximus.data";
$darknet_cfg = "/home/jgoyette/data/maximus300/yolov3.cfg";
$darknet_weights = "/home/jgoyette/data/maximus300/yolov3.weights";

$image_dir = "/tmp/";
$results_dir = "/var/www/html/tooth_finder_results/";
$filename = pathinfo( $_FILES['uploadedfile']['name'], PATHINFO_FILENAME);
$target_path = $image_dir. basename( $_FILES['uploadedfile']['name']); 
$results_path = $results_dir . $filename;

#echo "Processing file: " .        $_FILES['uploadedfile']['name'] . "<br />"; 


if (move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
#   echo "Predicting tooth locations in " . $target_path . "<br/>";

   $cmd = $darknet_exe . ' detector test ' . $darknet_data . ' ' . $darknet_cfg . ' ' . $darknet_weights . ' ' . $target_path . ' -out ' . $results_path;
#   echo "Cmd: <pre>$cmd</pre><br />";

   $output = shell_exec("cd $darknet_dir; $cmd " . ' 2>&1');
   echo "<h4>Results</h4>";
   echo '<img src="/tooth_finder_results/' . $filename . '.jpg" width="300" >';
   echo "<pre>$output</pre>";

} else {
    echo "There was an error uploading the file, please try again!";
}

?>
