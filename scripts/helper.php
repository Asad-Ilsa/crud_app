<?php

function console_log($msg) {
    echo "<script>console.log('$msg')</script>";
}

function navigate($path) {
    echo "<script>window.location.href = '" . $path . "'</script>";
}

?>