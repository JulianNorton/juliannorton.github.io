</head>
<body>
<?php
echo "<h2>Hello, world!</h2>\n";
$json_data = @json_decode(file_get_contents('php://input'));
$deployment = $json_data->deployment;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $deployment->environment === 'production') {
  $git_cmd = "cd {$_SERVER['DOCUMENT_ROOT']}; git pull 2>&1";
  $git_output = system($git_cmd, $git_status);
  $json = json_encode(
    array(
      '_TIMESTAMP' => date('c'),
      '_DEPLOYMENT' => $deployment,
      '_GET_COMMAND' => $git_cmd,
      '_GIT_OUTPUT' => $git_output,
      '_GIT_STATUS' => $git_status,
    ),
    JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
  file_put_contents($outfile, "$json\n,\n", FILE_APPEND);
  if ($git_status != 0) {
    echo "<p>Status: " . htmlspecialchars($git_status) . "</p>\n";
    header("HTTP/1.1 500 Server error");
  }
}
else {
  header("HTTP/1.1 400 Invalid request");
}
?>
</body>
</html>
